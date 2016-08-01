<?php
/**
* 
*/
class Activate_platform_store extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function storeUserChangePhone(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['user_email']) && !empty($_POST['user_email'])){
		}else{
			$data = array("message"=>"user email field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['contact_no']) && !empty($_POST['contact_no'])){
		}else{
			$data = array("message"=>"Contact # field is required !");
			echo json_encode($data);
			return  ;
		}
		$insertArr = array(
			'user_email'=>$_POST['user_email'],
			'contact_no'=>$_POST['contact_no'], 	
		);
			
		if(!$this->db->update('reseller_store',$insertArr,array('user_id'=>$this->session->userdata('user_id')))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'Updated successfully ! ');
			echo json_encode($data );
		}
	}


	function index(){
		$cur_user_id = $this->session->userdata('user_id');

		$profile = $this->mdl_common->allSelects('Select * From  reseller_store where user_id= '.$cur_user_id);
		foreach ($profile as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		
	}


	function getrejectedSimList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Reject" AND created BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Reject" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}



	function getSimNumberByID($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * From activate_platform_sim  where sim_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}


	function editSimNumber(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"user_name field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['sim_no']) && !empty($_POST['sim_no'])){
		}else{
			$data = array("message"=>"Content field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ship_date']) && !empty($_POST['ship_date'])){
		}else{
			$_POST['ship_date'] = '';
		}

		$userId = $this->mdl_common->sponserID($_POST['user_name']);
		$insertArr = array(
			'user_id'=>$userId,
			'user_name'=>$_POST['user_name'],
			'sim_no'=>$_POST['sim_no'], 	
			'ship_date'=>$_POST['ship_date'],

		);
			

		if(!$this->db->update('activate_platform_sim',$insertArr,array('sim_id'=>$_POST['sim_id']))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'SIM # Edited successfully ! ');
			echo json_encode($data );
		}
	}


	function getapprovedSimList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Approve" AND created BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Approve" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}

	

	function approveWaitingSimStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['sim_phone_no'])){
			$updateArr = array(
				'sim_status'=>'Approve',
				'sim_phone_no'=>$_POST['sim_phone_no']
			);
			if(!$this->db->update('activate_platform',$updateArr, array('id'=>$id))){
				$data = array('message'=>'SIM  Not Approve! Error..');
				echo json_encode($data);				
			}else{

				$userid = $this->mdl_common->allSelects('SELECT * from activate_platform where id = '.$id);
				foreach ($userid as $user) {
						$this->send_approve_sim_mail($user['email'], $user['first_name'], $user['last_name'], $user['sim'], $_POST['sim_phone_no']);	
				}
				$data = array('message'=>'SIM approved');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'SIM Error...  Number Required');
			echo json_encode($data);	
		}
	}

	function send_approve_sim_mail(  $user_email=null,  $userName=null, $lastName=null, $simnumber=null, $phonenumber=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('SIM Activation approved');
     
        $mail_body	='<div>
        					<p>Hi '.$userName.' '.$lastName.', </p>
        					<p>Your phone number '.$phonenumber.' for SIM card number '.$simnumber.' is now active and ready for use, as a survey participant under Smart Mark. </p>
        					<p>Start by simply inserting the sim card into your device. You may need to restart your device first in order to connect to the network.</p>
        					<p>If you have any questions, please get in touch and we will assist you. </p>
        					<p>ws@xonnova.com</p>
        					<p>Team xonnova</p>
        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }


	function getwaitingSimList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Waiting" AND created BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform   where sim_status = "Waiting" ORDER BY id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}


	function approveSimStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
				'sim_status'=>'Waiting',
			);
			if(!$this->db->update('activate_platform',$updateArr, array('id'=>$id))){
				$data = array('message'=>'SIM  Not approve! Error..');
				echo json_encode($data);				
			}else{
				$data = array('message'=>'SIM approved');
				echo json_encode($data);
			}
	}


	function rejectSimStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['comment'])){
			$updateArr = array(
				'sim_status'=>'Reject',
				'sim_comment'=>$_POST['comment']
			);
			if(!$this->db->update('activate_platform',$updateArr, array('id'=>$id))){
				$data = array('message'=>'SIM  Not Reject! Error..');
				echo json_encode($data);				
			}else{

				$userid = $this->mdl_common->allSelects('SELECT * from activate_platform where id = '.$id);
				foreach ($userid as $user) {
						$this->send_reject_sim_mail($user['email'], $user['user_name'], $_POST['comment']);	
				}
				$data = array('message'=>'SIM Rejected');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'SIM Error...  Comment Required');
			echo json_encode($data);	
		}
	}

	function send_reject_sim_mail(  $user_email=null,  $userName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('SIM Activation Rejected');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your SIM Activation request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you. </p>
        					<p>ws@xonnova.com</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }




	function addSim(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"user_name field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['sim_no']) && !empty($_POST['sim_no'])){
		}else{
			$data = array("message"=>"Content field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ship_date']) && !empty($_POST['ship_date'])){
		}else{
			$_POST['ship_date'] = '';
		}

		if(isset($_POST['type']) && !empty($_POST['type'])){
		}else{
			$data = array("message"=>"type field is required !");
			echo json_encode($data);
			return  ;
		}

		if($_POST['type'] == 'BO'){
			$this->db->where('user_name',$_POST['user_name']);
			$rs2	=	$this->db->get('user_master');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$userId = $this->mdl_common->sponserID($_POST['user_name']);	
			}else{
				$data = array("message"=>"user not exist !");
				echo json_encode($data);
				return  ;		
			}
		}else{
			$this->db->where('user_name',$_POST['user_name']);
			$rs2	=	$this->db->get('reseller_store');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$userId = $this->mdl_common->resellerID($_POST['user_name']);	
			}else{
				$data = array("message"=>"user not exist !");
				echo json_encode($data);
				return  ;		
			}
		}

		$insertArr = array(
			'user_id'=>$userId,
			'user_name'=>$_POST['user_name'],
			'sim_no'=>$_POST['sim_no'], 	
			'ship_date'=>$_POST['ship_date'],

		);
			

		if(!$this->db->insert('activate_platform_sim',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'SIM # Added successfully ! ');
			echo json_encode($data );
		}
	}


	function getSimList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim   WHERE  sim_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}


	function deleteSim(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('activate_platform_sim',array('sim_id'=>$_POST['sim_id']));
	}
	
	
	
	
	function getTotalStoreCredit($id){
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductStoreCredit($id){
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}






	function activatePlatformStore(){
		$_POST = json_decode(file_get_contents("php://input"),true);


		if($this->session->userdata('user_id') == null){
			$data = array('message'=>' Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		$userID = $this->session->userdata('user_id');
		$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);

		// $userName = $this->session->userdata('user_name');
		// $userPhone = $this->session->userdata('contact_no');
		// $userEmail = $this->session->userdata('user_email');

		$userName = $this->mdl_common->getSIMusernameStore($this->session->userdata('user_id'));
		$userPhone = $this->mdl_common->getSIMuserphoneStore($this->session->userdata('user_id'));
		$userEmail = $this->mdl_common->getSIMuseremailStore($this->session->userdata('user_id'));
			
				if(isset($_POST['q2']) && !empty($_POST['q2']) && $_POST['q2'] == '1'){
					

						if(isset($_POST['first_name'])&&!empty($_POST['first_name'])){
							$firstName = $_POST['first_name'];
						}else{
							$firstName = '';
							$data = array("message"=>"First Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['middle_name']) && !empty($_POST['middle_name'])){
							$middleName = $_POST['middle_name'];
						}else{
							$middleName = null;
						}

						if(isset($_POST['last_name'])&&!empty($_POST['last_name'])){
							$lastName = $_POST['last_name'];
						}else{
							$lastName = '';
							$data = array("message"=>"Last Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['address1'])&&!empty($_POST['address1'])){
							$address1 = $_POST['address1'];
						}else{
							$address1 = '';
							$data = array("message"=>"Address Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['address2']) && !empty($_POST['address2'])){
							$address2 = $_POST['address2'];
						}else{
							$address2 = null;
						}

						if(isset($_POST['city'])&&!empty($_POST['city'])){
							$city = $_POST['city'];
						}else{
							$city = '';
							$data = array("message"=>"City Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['state'])&&!empty($_POST['state'])){
							$state = $_POST['state'];
						}else{
							$state = '';
							$data = array("message"=>"State Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['zip'])&&!empty($_POST['zip'])){
							$zip = $_POST['zip'];
						}else{
							$zip = '';
							$data = array("message"=>"Zip # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['attphone'])&&!empty($_POST['attphone'])){
							$phone = $_POST['attphone'];
						}else{
							$phone = '';
							$data = array("message"=>"Phone # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_brand'])&&!empty($_POST['phone_brand'])){
						}else{
							$data = array("message"=>"Phone Brand Field Required !"); 
							echo json_encode($data);
							return false ;
						}


						if(isset($_POST['phone_type'])&&!empty($_POST['phone_type'])){
						}else{
							$data = array("message"=>"Phone Model Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_imei'])&&!empty($_POST['phone_imei'])){
						}else{
							$data = array("message"=>"Phone IMEI Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['annual_income'])&&!empty($_POST['annual_income'])){
						}else{
							$data = array("message"=>"Annual Income Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['health_insurance'])&&!empty($_POST['health_insurance'])){
						}else{
							$data = array("message"=>"Health Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['dental_insurance'])&&!empty($_POST['dental_insurance'])){
						}else{
							$data = array("message"=>"Dental Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['life_insurance'])&&!empty($_POST['life_insurance'])){
						}else{
							$data = array("message"=>"Life Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['user_emailATTSim'])&&!empty($_POST['user_emailATTSim'])){
							$email = $_POST['user_emailATTSim'];
						}else{
							$email = '';
							$data = array("message"=>"Email Required !"); 
							echo json_encode($data);
							return false ;
						}


						if(isset($_POST['attq3'])&&!empty($_POST['attq3'])){
							$question3 = $_POST['attq3'];
						}else{
							$question3 = '';
							$data = array("message"=>"Question # 2 Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['dobATTSim'])&&!empty($_POST['dobATTSim'])){
							$dob = $_POST['dobATTSim'];
						}else{
							$dob = '';
							$data = array("message"=>"Date Of Birth Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['attpin'])&&!empty($_POST['attpin'])){
							$simNumber = $_POST['attpin'];
						}else{
							$simNumber = '';
							$data = array("message"=>"SIM # Required !"); 
							echo json_encode($data);
							return false ;
						}



						$this->db->where('user_id',$this->session->userdata('user_id'));
						$this->db->where('sim_no',$_POST['attpin']);
						$rs2	=	$this->db->get('activate_platform_sim');
						$UserInfo2	=	$rs2->num_rows();	
						if($UserInfo2 == 0){
							$data = array("message"=>"This SIM # is not assigned to you ! !"); 
							echo json_encode($data);
							return false ;
						}


						$this->db->where('sim',$_POST['attpin']);
						$rs2	=	$this->db->get('activate_platform');
						$UserInfo2	=	$rs2->num_rows();	
						if($UserInfo2 != 0){
							$data = array('message'=>' An Activation request for this SIM # has already been sent by you.');
							echo json_encode($data);	
							return;
						}

						// if(isset($_POST['imei'])&&!empty($_POST['imei'])){
						// }else{
						// 	$data = array("message"=>"IMEI # Required !"); 
						// 	echo json_encode($data);
						// 	return false ;
						// }
						
						if(isset($_POST['area_code'])&&!empty($_POST['area_code'])){
							$areaCode = $_POST['area_code'];
						}else{
							$areaCode = '';
							$data = array("message"=>"Area Code Required !"); 
							echo json_encode($data);
							return false ;
						}



						if(isset($_POST['race'])&&!empty($_POST['race'])){
						}else{
							$data = array("message"=>"Race Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['gender'])&&!empty($_POST['gender'])){
						}else{
							$data = array("message"=>"Gender Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['pref_lang'])&&!empty($_POST['pref_lang'])){
						}else{
							$data = array("message"=>"Preferred language Required !"); 
							echo json_encode($data);
							return false ;
						}
						
						if(isset($_POST['home_owner'])&&!empty($_POST['home_owner'])){
						}else{
							$data = array("message"=>"Home owner Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['bus_owner'])&&!empty($_POST['bus_owner'])){
						}else{
							$data = array("message"=>"Business  owner Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['industry'])&&!empty($_POST['industry'])){
						}else{
							$_POST['industry'] = '';
						}

					
					
					$q4 = 10;
					// deduct

					if($userStoreCredit >= $q4){	
						$Arr = array(
							'user_id'=>$userID,
							'credit'=>$q4,
							'wallet_type'=>'2',
							'message'=>'Avtivation SIM ',
						);
						$this->db->insert('store_credit_report_info',$Arr);


						$insertarr = array(
							'user_id'=>$this->session->userdata('user_id'),
							'dealer_code'=>$this->session->userdata('dealer_code'),
							'user_name'=>$userName,
							'user_phone'=>$userPhone,
							'user_email'=>$userEmail,
							// 'q1'=>$_POST['q1'],
							'q2'=>'SmartMark',
							'q3'=>$question3,
							'q4'=>$q4,
							'sim'=>$simNumber,
							'area_code'=>$areaCode,

							'first_name'=>$firstName,
							'middle_name'=>$middleName,
							'last_name'=>$lastName,
							'email'=>$email,
							
							'dob'=>$dob,
							'phone_number'=>$phone,
							
							'address1'=>$address1,
							'address2'=>$address2,
							'city'=>$city,
							'state'=>$state,
							'zip'=>$zip,

							//'imei'=>$_POST['imei'],


							'race'=>$_POST['race'],
							'gender'=>$_POST['gender'],
							'pref_lang'=>$_POST['pref_lang'],
							'home_owner'=>$_POST['home_owner'],
							'bus_owner'=>$_POST['bus_owner'],
							'industry'=>$_POST['industry'],

							'phone_brand'=>$_POST['phone_brand'],
							'phone_type'=>$_POST['phone_type'],
							'phone_imei'=>$_POST['phone_imei'],
							'annual_income'=>$_POST['annual_income'],
							'health_insurance'=>$_POST['health_insurance'],
							'dental_insurance'=>$_POST['dental_insurance'],
							'life_insurance'=>$_POST['life_insurance'],
						);
						$this->db->insert('activate_platform',$insertarr);
						$data = array("message"=>"Your Registration Completed succesfully  ");
						echo json_encode($data);
					}else{
						$data = array("message"=>"Registration  Fail! insufficient store credits.   "); 
						echo json_encode($data);
					}		
				}else{

					if(isset($_POST['q1']) && !empty($_POST['q1']) && $_POST['q1'] == 'YES'){

						if(isset($_POST['client_name'])&&!empty($_POST['client_name'])){
							$clientName = $_POST['client_name'];
						}else{
							$clientName = '';
							$data = array("message"=>"Client Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['current_company'])&&!empty($_POST['current_company'])){
							$currentCompany = $_POST['current_company'];
						}else{
							$currentCompany = '';
							$data = array("message"=>"Current Company Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_number'])&&!empty($_POST['phone_number'])){
							$phone = $_POST['phone_number'];
						}else{
							$phone = '';
							$data = array("message"=>"Phone # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['account'])&&!empty($_POST['account'])){
							$account = $_POST['account'];
						}else{
							$account = '';
							$data = array("message"=>"Account # Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['pin'])&&!empty($_POST['pin'])){
							$pin = $_POST['pin'];
						}else{
							$pin = '';
							$data = array("message"=>"Pin # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['zip_code'])&&!empty($_POST['zip_code'])){
							$zip = $_POST['zip_code'];
						}else{
							$zip = '';
							$data = array("message"=>"Zip # Required !"); 
							echo json_encode($data);
							return false ;
						}

						$insertarr = array(
							'user_id'=>$this->session->userdata('user_id'),
							'dealer_code'=>$this->session->userdata('dealer_code'),
							'user_name'=>$userName,
							'user_phone'=>$userPhone,
							'user_email'=>$userEmail,
							'q1'=>$_POST['q1'],
							'q2'=>'Simple Mobile',
							'client_name'=>$clientName,
							'current_company'=>$currentCompany,
							'phone_number'=>$phone,
							'account'=>$account,
							'pin'=>$pin,
							'zip_code'=>$zip,
						);
						if(!$this->db->insert('activate_platform',$insertarr)){
							$data = array('message'=>'Error ..');
							echo json_encode($data);
						}else{
							$data = array('message'=>'Submited ..');
							echo json_encode($data);
						}
					}else{
						if(isset($_POST['smq3']) && !empty($_POST['smq3'])){
							if($_POST['smq3'] == '40'){
								$q4 = '10';	
							}else if ($_POST['smq3'] == '55'){
								$q4 = '25';	
							}else if ($_POST['smq3'] == '65'){
								$q4 = '35';
							}

									if(isset($_POST['first_name2'])&&!empty($_POST['first_name2'])){
										$firstName = $_POST['first_name2'];
									}else{
										$firstName = '';
										$data = array("message"=>"First Name Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['middle_name2']) && !empty($_POST['middle_name2'])){
										$middleName = $_POST['middle_name2'];
									}else{
										$middleName = null;
									}

									if(isset($_POST['last_name2'])&&!empty($_POST['last_name2'])){
										$lastName = $_POST['last_name2'];
									}else{
										$lastName = '';
										$data = array("message"=>"Last Name Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['address12'])&&!empty($_POST['address12'])){
										$address1 = $_POST['address12'];
									}else{
										$address1 = '';
										$data = array("message"=>"Address Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['address22']) && !empty($_POST['address22'])){
										$address2 = $_POST['address22'];
									}else{
										$address2 = null;
									}

									if(isset($_POST['city2'])&&!empty($_POST['city2'])){
										$city = $_POST['city2'];
									}else{
										$city = '';
										$data = array("message"=>"City Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['state2'])&&!empty($_POST['state2'])){
										$state = $_POST['state2'];
									}else{
										$state = '';
										$data = array("message"=>"State Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['zip2'])&&!empty($_POST['zip2'])){
										$zip = $_POST['zip2'];
									}else{
										$zip = '';
										$data = array("message"=>"Zip # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smphone'])&&!empty($_POST['smphone'])){
										$phone = $_POST['smphone'];
									}else{
										$phone = '';
										$data = array("message"=>"Phone # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['user_emailSmSim'])&&!empty($_POST['user_emailSmSim'])){
										$email = $_POST['user_emailSmSim'];
									}else{
										$email = '';
										$data = array("message"=>"Email  Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smq3'])&&!empty($_POST['smq3'])){
										$question3 = $_POST['smq3'];
									}else{
										$question3 = '';
										$data = array("message"=>"Question # 3 Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['dobSmSim'])&&!empty($_POST['dobSmSim'])){
										$dob = $_POST['dobSmSim'];
									}else{
										$dob = '';
										$data = array("message"=>"Date Of Birth Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smpin'])&&!empty($_POST['smpin'])){
										$simNumber = $_POST['smpin'];
									}else{
										$simNumber = '';
										$data = array("message"=>"SIM # Required !"); 
										echo json_encode($data);
										return false ;
									}
									if(isset($_POST['area_code2'])&&!empty($_POST['area_code2'])){
										$areaCode = $_POST['area_code2'];
									}else{
										$areaCode = '';
										$data = array("message"=>"Area Code Required !"); 
										echo json_encode($data);
										return false ;
									}

									
								

								
								
								if($userStoreCredit >= $q4){	
									$Arr = array(
										'user_id'=>$userID,
										'credit'=>$q4,
										'wallet_type'=>'2',
										'message'=>'Avtivation SIM ',
									);
									$this->db->insert('store_credit_report_info',$Arr);

									$insertarr = array(
										'user_id'=>$this->session->userdata('user_id'),
										'dealer_code'=>$this->session->userdata('dealer_code'),
										'user_name'=>$userName,
										'user_phone'=>$userPhone,
										'user_email'=>$userEmail,
										'q1'=>$_POST['q1'],
										'q2'=>'Simple Mobile',
										'q3'=>$question3,
										'q4'=>$q4,
										'sim'=>$simNumber,
										'area_code'=>$areaCode,

										'first_name'=>$firstName,
										'middle_name'=>$middleName,
										'last_name'=>$lastName,
										'email'=>$email,
										
										'dob'=>$dob,
										'phone_number'=>$phone,
										
										'address1'=>$address1,
										'address2'=>$address2,
										'city'=>$city,
										'state'=>$state,
										'zip'=>$zip,

										
									);
									$this->db->insert('activate_platform',$insertarr);
									$data = array("message"=>"Your Activation Submitted succesfully  ");
									echo json_encode($data);
								}else{
									$data = array("message"=>"Activation   Fail!  insufficient store credits. "); 
									echo json_encode($data);
								}		



						}

					}
				}
					
			
			
		// }
		

	}














	function activatePlatform(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if($this->session->userdata('user_id') == null){
			$data = array('message'=>' Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		
		// $simOrdered = $this->mdl_common->isUserOrderSim($this->session->userdata('user_id'));
			
		// if(isset($simOrdered) && !empty($simOrdered)){
		// 	$data = array('message'=>'Already Submited ..');
		// 	echo json_encode($data);
		// }else{
		
		// $userName = $this->mdl_common->getSIMusername($this->session->userdata('user_id'));
		// $userPhone = $this->mdl_common->getSIMuserphone($this->session->userdata('user_id'));
		// $userEmail = $this->mdl_common->getSIMuseremail($this->session->userdata('user_id'));
		$userName = $this->mdl_common->getSIMusernameStore($this->session->userdata('user_id'));
		$userPhone = $this->mdl_common->getSIMuserphoneStore($this->session->userdata('user_id'));
		$userEmail = $this->mdl_common->getSIMuseremailStore($this->session->userdata('user_id'));
			
				if(isset($_POST['q2']) && !empty($_POST['q2']) && $_POST['q2'] == '1'){
					$this->load->library('authorize_net');
						

						if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
							$card_no = $_POST['card_no'];
						}else{
							$card_no = '';
							$data = array("message"=>"Card # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
							$expiryYear = $_POST['expiry_year'];
						}else{
							$expiryYear = '';
							$data = array("message"=>"Expiry Year Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
							$expiryMonth = $_POST['expiry_month'];
						}else{
							$expiryMonth = '';
							$data = array("message"=>"Expiry Month Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
							$cvvNo = $_POST['cvv_no'];
						}else{
							$cvvNo = '';
							$data = array("message"=>"CVV # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['first_name'])&&!empty($_POST['first_name'])){
							$firstName = $_POST['first_name'];
						}else{
							$firstName = '';
							$data = array("message"=>"First Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['middle_name']) && !empty($_POST['middle_name'])){
							$middleName = $_POST['middle_name'];
						}else{
							$middleName = null;
						}

						if(isset($_POST['last_name'])&&!empty($_POST['last_name'])){
							$lastName = $_POST['last_name'];
						}else{
							$lastName = '';
							$data = array("message"=>"Last Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['address1'])&&!empty($_POST['address1'])){
							$address1 = $_POST['address1'];
						}else{
							$address1 = '';
							$data = array("message"=>"Address Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['address2']) && !empty($_POST['address2'])){
							$address2 = $_POST['address2'];
						}else{
							$address2 = null;
						}

						if(isset($_POST['city'])&&!empty($_POST['city'])){
							$city = $_POST['city'];
						}else{
							$city = '';
							$data = array("message"=>"City Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['state'])&&!empty($_POST['state'])){
							$state = $_POST['state'];
						}else{
							$state = '';
							$data = array("message"=>"State Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['zip'])&&!empty($_POST['zip'])){
							$zip = $_POST['zip'];
						}else{
							$zip = '';
							$data = array("message"=>"Zip # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['attphone'])&&!empty($_POST['attphone'])){
							$phone = $_POST['attphone'];
						}else{
							$phone = '';
							$data = array("message"=>"Phone # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_brand'])&&!empty($_POST['phone_brand'])){
						}else{
							$data = array("message"=>"Phone Brand Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_type'])&&!empty($_POST['phone_type'])){
						}else{
							$data = array("message"=>"Phone Model Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_imei'])&&!empty($_POST['phone_imei'])){
						}else{
							$data = array("message"=>"Phone IMEI Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['annual_income'])&&!empty($_POST['annual_income'])){
						}else{
							$data = array("message"=>"Annual Income Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['health_insurance'])&&!empty($_POST['health_insurance'])){
						}else{
							$data = array("message"=>"Health Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['dental_insurance'])&&!empty($_POST['dental_insurance'])){
						}else{
							$data = array("message"=>"Dental Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['life_insurance'])&&!empty($_POST['life_insurance'])){
						}else{
							$data = array("message"=>"Life Insurance Field Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['user_emailATTSim'])&&!empty($_POST['user_emailATTSim'])){
							$email = $_POST['user_emailATTSim'];
						}else{
							$email = '';
							$data = array("message"=>"Email Required !"); 
							echo json_encode($data);
							return false ;
						}


						if(isset($_POST['attq3'])&&!empty($_POST['attq3'])){
							$question3 = $_POST['attq3'];
						}else{
							$question3 = '';
							$data = array("message"=>"Question # 2 Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['dobATTSim'])&&!empty($_POST['dobATTSim'])){
							$dob = $_POST['dobATTSim'];
						}else{
							$dob = '';
							$data = array("message"=>"Date Of Birth Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['attpin'])&&!empty($_POST['attpin'])){
							$simNumber = $_POST['attpin'];
						}else{
							$simNumber = '';
							$data = array("message"=>"SIM # Required !"); 
							echo json_encode($data);
							return false ;
						}


						$this->db->where('user_id',$this->session->userdata('user_id'));
						$this->db->where('sim_no',$_POST['attpin']);
						$rs2	=	$this->db->get('activate_platform_sim');
						$UserInfo2	=	$rs2->num_rows();	
						if($UserInfo2 == 0){
							$data = array("message"=>"This SIM # is not assigned to you ! !"); 
							echo json_encode($data);
							return false ;
						}


						$this->db->where('sim',$_POST['attpin']);
						$rs2	=	$this->db->get('activate_platform');
						$UserInfo2	=	$rs2->num_rows();	
						if($UserInfo2 != 0){
							$data = array('message'=>' An Activation request for this SIM # has already been sent by you.');
							echo json_encode($data);	
							return;
						}


						// if(isset($_POST['imei'])&&!empty($_POST['imei'])){
						// }else{
						// 	$data = array("message"=>"IMEI # Required !"); 
						// 	echo json_encode($data);
						// 	return false ;
						// }
						
						if(isset($_POST['area_code'])&&!empty($_POST['area_code'])){
							$areaCode = $_POST['area_code'];
						}else{
							$areaCode = '';
							$data = array("message"=>"Area Code Required !"); 
							echo json_encode($data);
							return false ;
						}



						if(isset($_POST['race'])&&!empty($_POST['race'])){
						}else{
							$data = array("message"=>"Race Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['gender'])&&!empty($_POST['gender'])){
						}else{
							$data = array("message"=>"Gender Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['pref_lang'])&&!empty($_POST['pref_lang'])){
						}else{
							$data = array("message"=>"Preferred language Required !"); 
							echo json_encode($data);
							return false ;
						}
						
						if(isset($_POST['home_owner'])&&!empty($_POST['home_owner'])){
						}else{
							$data = array("message"=>"Home owner Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['bus_owner'])&&!empty($_POST['bus_owner'])){
						}else{
							$data = array("message"=>"Business  owner Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['industry'])&&!empty($_POST['industry'])){
						}else{
							$_POST['industry'] = '';
						}


					$auth_net = array(
						'x_card_num'			=> trim($card_no), // Visa
						'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
						'x_card_code'			=> trim($cvvNo),
						'x_description'			=> 'Activate Platform xonnova  Network transaction',
						'x_amount'				=> 10,
						'x_first_name'			=> $firstName,
						'x_last_name'			=> $lastName,
						'x_address'				=> $address1.''.$address2,
						'x_city'				=> $city,
						'x_state'				=> $state,
						'x_zip'					=> $zip,
						//'x_country'				=> $_POST['country'],
						'x_phone'				=> trim($phone),
						'x_email'				=> $email,
						'x_customer_ip'			=> $this->input->ip_address(),
					);

					$this->authorize_net->setData($auth_net);
					
					
					if($this->authorize_net->authorizeAndCapture()){	

						$expiry_year = $expiryMonth.'/'.$expiryYear;
						
						


						$insertarr = array(
							'user_id'=>$this->session->userdata('user_id'),
							'dealer_code'=>$this->session->userdata('dealer_code'),
							'user_name'=>$userName,
							'user_phone'=>$userPhone,
							'user_email'=>$userEmail,
							// 'q1'=>$_POST['q1'],
							'q2'=>'SmartMark',
							'q3'=>$question3,
							'q4'=>10,
							'sim'=>$simNumber,
							'area_code'=>$areaCode,

							'first_name'=>$firstName,
							'middle_name'=>$middleName,
							'last_name'=>$lastName,
							'email'=>$email,
							
							'dob'=>$dob,
							'phone_number'=>$phone,
							
							'address1'=>$address1,
							'address2'=>$address2,
							'city'=>$city,
							'state'=>$state,
							'zip'=>$zip,

							//'imei'=>$_POST['imei'],

							'card_no'=>$card_no,
							'expiry_date'=>$expiry_year,
							'cvv_no'=>$cvvNo,
							'transaction_id'=>$this->authorize_net->getTransactionId(),

							'race'=>$_POST['race'],
							'gender'=>$_POST['gender'],
							'pref_lang'=>$_POST['pref_lang'],
							'home_owner'=>$_POST['home_owner'],
							'bus_owner'=>$_POST['bus_owner'],
							'industry'=>$_POST['industry'],

							'phone_brand'=>$_POST['phone_brand'],
							'phone_type'=>$_POST['phone_type'],
							'phone_imei'=>$_POST['phone_imei'],
							'annual_income'=>$_POST['annual_income'],
							'health_insurance'=>$_POST['health_insurance'],
							'dental_insurance'=>$_POST['dental_insurance'],
							'life_insurance'=>$_POST['life_insurance'],
						);
						$this->db->insert('activate_platform',$insertarr);
						$data = array("message"=>"Your Activation Submitted succesfully &   Transaction ID : ".$this->authorize_net->getTransactionId());
						echo json_encode($data);
					}else{
						$data = array("message"=>"Activation   Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
						echo json_encode($data);
					}		
				}else{

					if(isset($_POST['q1']) && !empty($_POST['q1']) && $_POST['q1'] == 'YES'){

						if(isset($_POST['client_name'])&&!empty($_POST['client_name'])){
							$clientName = $_POST['client_name'];
						}else{
							$clientName = '';
							$data = array("message"=>"Client Name Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['current_company'])&&!empty($_POST['current_company'])){
							$currentCompany = $_POST['current_company'];
						}else{
							$currentCompany = '';
							$data = array("message"=>"Current Company Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['phone_number'])&&!empty($_POST['phone_number'])){
							$phone = $_POST['phone_number'];
						}else{
							$phone = '';
							$data = array("message"=>"Phone # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['account'])&&!empty($_POST['account'])){
							$account = $_POST['account'];
						}else{
							$account = '';
							$data = array("message"=>"Account # Required !"); 
							echo json_encode($data);
							return false ;
						}
						if(isset($_POST['pin'])&&!empty($_POST['pin'])){
							$pin = $_POST['pin'];
						}else{
							$pin = '';
							$data = array("message"=>"Pin # Required !"); 
							echo json_encode($data);
							return false ;
						}

						if(isset($_POST['zip_code'])&&!empty($_POST['zip_code'])){
							$zip = $_POST['zip_code'];
						}else{
							$zip = '';
							$data = array("message"=>"Zip # Required !"); 
							echo json_encode($data);
							return false ;
						}

						$insertarr = array(
							'user_id'=>$this->session->userdata('user_id'),
							'dealer_code'=>$this->session->userdata('dealer_code'),
							'user_name'=>$userName,
							'user_phone'=>$userPhone,
							'user_email'=>$userEmail,
							'q1'=>$_POST['q1'],
							'q2'=>'Simple Mobile',
							'client_name'=>$clientName,
							'current_company'=>$currentCompany,
							'phone_number'=>$phone,
							'account'=>$account,
							'pin'=>$pin,
							'zip_code'=>$zip,
						);
						if(!$this->db->insert('activate_platform',$insertarr)){
							$data = array('message'=>'Error ..');
							echo json_encode($data);
						}else{
							$data = array('message'=>'Submited ..');
							echo json_encode($data);
						}
					}else{
						if(isset($_POST['smq3']) && !empty($_POST['smq3'])){
							if($_POST['smq3'] == '40'){
								$q4 = '10';	
							}else if ($_POST['smq3'] == '55'){
								$q4 = '25';	
							}else if ($_POST['smq3'] == '65'){
								$q4 = '35';
							}

							$this->load->library('authorize_net');

								if(isset($_POST['card_no2'])&&!empty($_POST['card_no2'])){
										$card_no = $_POST['card_no2'];
									}else{
										$card_no = '';
										$data = array("message"=>"Card # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['expiry_year2'])&&!empty($_POST['expiry_year2'])){
										$expiryYear = $_POST['expiry_year2'];
									}else{
										$expiryYear = '';
										$data = array("message"=>"Expiry Year Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['expiry_month2'])&&!empty($_POST['expiry_month2'])){
										$expiryMonth = $_POST['expiry_month2'];
									}else{
										$expiryMonth = '';
										$data = array("message"=>"Expiry Month Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['cvv_no2'])&&!empty($_POST['cvv_no2'])){
										$cvvNo = $_POST['cvv_no2'];
									}else{
										$cvvNo = '';
										$data = array("message"=>"CVV # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['first_name2'])&&!empty($_POST['first_name2'])){
										$firstName = $_POST['first_name2'];
									}else{
										$firstName = '';
										$data = array("message"=>"First Name Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['middle_name2']) && !empty($_POST['middle_name2'])){
										$middleName = $_POST['middle_name2'];
									}else{
										$middleName = null;
									}

									if(isset($_POST['last_name2'])&&!empty($_POST['last_name2'])){
										$lastName = $_POST['last_name2'];
									}else{
										$lastName = '';
										$data = array("message"=>"Last Name Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['address12'])&&!empty($_POST['address12'])){
										$address1 = $_POST['address12'];
									}else{
										$address1 = '';
										$data = array("message"=>"Address Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['address22']) && !empty($_POST['address22'])){
										$address2 = $_POST['address22'];
									}else{
										$address2 = null;
									}

									if(isset($_POST['city2'])&&!empty($_POST['city2'])){
										$city = $_POST['city2'];
									}else{
										$city = '';
										$data = array("message"=>"City Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['state2'])&&!empty($_POST['state2'])){
										$state = $_POST['state2'];
									}else{
										$state = '';
										$data = array("message"=>"State Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['zip2'])&&!empty($_POST['zip2'])){
										$zip = $_POST['zip2'];
									}else{
										$zip = '';
										$data = array("message"=>"Zip # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smphone'])&&!empty($_POST['smphone'])){
										$phone = $_POST['smphone'];
									}else{
										$phone = '';
										$data = array("message"=>"Phone # Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['user_emailSmSim'])&&!empty($_POST['user_emailSmSim'])){
										$email = $_POST['user_emailSmSim'];
									}else{
										$email = '';
										$data = array("message"=>"Email  Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smq3'])&&!empty($_POST['smq3'])){
										$question3 = $_POST['smq3'];
									}else{
										$question3 = '';
										$data = array("message"=>"Question # 3 Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['dobSmSim'])&&!empty($_POST['dobSmSim'])){
										$dob = $_POST['dobSmSim'];
									}else{
										$dob = '';
										$data = array("message"=>"Date Of Birth Required !"); 
										echo json_encode($data);
										return false ;
									}

									if(isset($_POST['smpin'])&&!empty($_POST['smpin'])){
										$simNumber = $_POST['smpin'];
									}else{
										$simNumber = '';
										$data = array("message"=>"SIM # Required !"); 
										echo json_encode($data);
										return false ;
									}
									if(isset($_POST['area_code2'])&&!empty($_POST['area_code2'])){
										$areaCode = $_POST['area_code2'];
									}else{
										$areaCode = '';
										$data = array("message"=>"Area Code Required !"); 
										echo json_encode($data);
										return false ;
									}

									
								

								$auth_net = array(
									'x_card_num'			=> trim($card_no), // Visa
									'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
									'x_card_code'			=> trim($cvvNo),
									'x_description'			=> 'Activate Platform  xonnova Network transaction',
									'x_amount'				=> $q4,
									'x_first_name'			=> $firstName,
									'x_last_name'			=> $lastName,
									'x_address'				=> $address1.''.$address2,
									'x_city'				=> $city,
									'x_state'				=> $state,
									'x_zip'					=> $zip,
									//'x_country'				=> $_POST['country'],
									'x_phone'				=> trim($phone),
									'x_email'				=> $email,
									'x_customer_ip'			=> $this->input->ip_address(),
								);

								$this->authorize_net->setData($auth_net);
								
								
								if($this->authorize_net->authorizeAndCapture()){	

									$expiry_year = $expiryMonth.'/'.$expiryYear;
						
									
									
									// $insertarr = array(
									// 	'user_id'=>$this->session->userdata('user_id'),
									// 	'user_name'=>$userName,
									// 	'user_phone'=>$userPhone,
									// 	'user_email'=>$userEmail,
									// 	'q1'=>$_POST['q1'],
									// 	'q2'=>'Simple Mobile',
									// 	'q3'=>$_POST['smq3'],
									// 	'q4'=>$q4,
									// 	'sim'=>$_POST['smpin'],
									// 	'first_name'=>$_POST['first_name2'],
									// 	'middle_name'=>$mn,
									// 	'last_name'=>$_POST['last_name2'],
									// 	'email'=>$_POST['user_emailSmSim'],
							
									// 	'dob'=>$_POST['dobSmSim'],
									// 	'phone_number'=>$_POST['smphone'],
										
									// 	'address1'=>$_POST['address12'],
									// 	'address2'=>$add,
									// 	'city'=>$_POST['city2'],
									// 	'state'=>$_POST['state2'],
									// 	'zip'=>$_POST['zip2'],

									// 	'card_no'=>$_POST['card_no2'],
									// 	'expiry_date'=>$expiry_year,
									// 	'cvv_no'=>$_POST['cvv_no2'],
									// 	'transaction_id'=>$this->authorize_net->getTransactionId(),
									// );

									$insertarr = array(
										'user_id'=>$this->session->userdata('user_id'),
										'dealer_code'=>$this->session->userdata('dealer_code'),
										'user_name'=>$userName,
										'user_phone'=>$userPhone,
										'user_email'=>$userEmail,
										'q1'=>$_POST['q1'],
										'q2'=>'Simple Mobile',
										'q3'=>$question3,
										'q4'=>$q4,
										'sim'=>$simNumber,
										'area_code'=>$areaCode,

										'first_name'=>$firstName,
										'middle_name'=>$middleName,
										'last_name'=>$lastName,
										'email'=>$email,
										
										'dob'=>$dob,
										'phone_number'=>$phone,
										
										'address1'=>$address1,
										'address2'=>$address2,
										'city'=>$city,
										'state'=>$state,
										'zip'=>$zip,

										'card_no'=>$card_no,
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$cvvNo,
										'transaction_id'=>$this->authorize_net->getTransactionId(),
									);
									$this->db->insert('activate_platform',$insertarr);
									$data = array("message"=>"Your Activation Submitted succesfully &   Transaction ID : ".$this->authorize_net->getTransactionId());
									echo json_encode($data);
								}else{
									$data = array("message"=>"Activation   Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
									echo json_encode($data);
								}		



						}

					}
				}
					
			
			
		// }
		

	}



	function activatePlatformReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name as sim_user_name From activate_platform as a Left JOIN activate_platform_sim as b on a.sim = b.sim_no where a.sim_status = "Pending" ORDER BY a.id DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function activatePlatformReportByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name as sim_user_name From activate_platform as a Left JOIN activate_platform_sim as b on a.sim = b.sim_no  where a.id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}


	function activatePlatformReport2(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.sim_no From activate_platform as a Left JOIN activate_platform_sim as b on a.user_id = b.user_id where a.sim_status = "Pending" ORDER BY a.id DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function activatePlatformReportByUser2($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.sim_no From activate_platform as a Left JOIN activate_platform_sim as b on a.user_id = b.user_id  where a.id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}
}