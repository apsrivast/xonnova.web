<?php
/**
* 
*/
class Solar_form_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}

	

	function getSolarFormForUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		// $from = $_POST['from_date'];
		// $to = $_POST['to_date'];
		// if(isset($from) && !empty($from) && isset($to) && !empty($to)){
		// 	$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.cheque_status = "Bounce" AND a.bank_cheque_status = "Deposited" AND a.hold_date BETWEEN "'.$from.'" AND "'.$to.'"');
		// 	if(isset($list) && !empty($list)){
		// 		foreach ($list as $key => $value) {
		// 			$arr[] = $value;
		// 		}
		// 		echo json_encode($arr);
		// 	}else{
		// 		return false;
		// 	}
		// }else{
			
			$list = $this->mdl_common->allSelects('SELECT * From soler_form   WHERE user_id ='.$this->session->userdata('user_id'));
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		// }
	}



	function insertSolarForm(){
		$_POST = json_decode(file_get_contents("php://input"),true);


		if($this->session->userdata('user_id') == null){
			$data = array('mess'=>' Login Again !');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
		}else{
			$data = array("mess"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
		}else{
			$data = array("mess"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address1']) && !empty($_POST['address1'])){
		}else{
			$data = array("mess"=>"Address 1 field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else{
			$_POST['address2'] = '';
		}
		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("mess"=>"City  field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("mess"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("mess"=>"ZIP Code field is required !");
			echo json_encode($data);
			return  ;
		}
		
		
		if(isset($_POST['country']) && !empty($_POST['country'])){
		}else{
			$data = array("mess"=>"Country field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone_no']) && !empty($_POST['phone_no'])){
		}else{
			$data = array("mess"=>"Phone # is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['call_time']) && !empty($_POST['call_time'])){
		}else{
			$data = array("mess"=>"Best Time to Reach You field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['business_email']) && !empty($_POST['business_email'])){
		}else{
			$data = array("mess"=>"Email field is required !");
			echo json_encode($data);
			return  ;
		}

		$insertArr = array(
			'user_id'=> $this->session->userdata('user_id'),
			'user_name'=> $this->session->userdata('user_name'),
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'],
			'address1'=>$_POST['address1'],
			'address2'=>$_POST['address2'],
			'city'=>$_POST['city'],
			'state'=>$_POST['state'],
			'zip'=>$_POST['zip'],
			'country'=>$_POST['country'],
			'phone_no'=>$_POST['phone_no'],
			'call_time'=>$_POST['call_time'],
			'business_email'=>$_POST['business_email'],
			'prefer_lang'=>$_POST['prefer_lang'],
			'owner_house'=>$_POST['owner_house'],
		);

		if(!$this->db->insert('soler_form',$insertArr)){
		    $data = array('mess' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'Leads  uploaded successfully ! ');
			echo json_encode($data );
		}
	}



	function getBounceDepositList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.cheque_status = "Bounce" AND a.bank_cheque_status = "Deposited" AND a.hold_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id   WHERE a.cheque_status = "Bounce" AND a.bank_cheque_status = "Deposited"');
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


	function bounceHoldDeposit(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['deposit_id'])){
			$updateArr = array(
				'cheque_status'=>'Bounce',
			);
			if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$_POST['deposit_id']))){
				$data = array('message'=>'Deposit Cheque Not Mark Bounce! Error..');
				echo json_encode($data);				
			}else{
				$data = array('message'=>'Deposit Cheque Mark Bounce');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Error... Deposit Cheque Not Mark Bounce');
			echo json_encode($data);	
		}
	}

	function approveChequeDeposit(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['deposit_id'])){
			$updateArr = array(
				'bank_cheque_status'=>'Deposited',
			);
			if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$_POST['deposit_id']))){
				$data = array('message'=>'Cheque Deposit-Status Not Deposited! Error..');
				echo json_encode($data);				
			}else{
				$data = array('message'=>'Cheque Deposit-Status Deposited');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Error... Cheque Deposit-Status Not Deposited ');
			echo json_encode($data);	
		}
	}


	function getApproveChequeDepositList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id   WHERE a.deposit_status != "Reject" AND a.bank_cheque_status = "Deposited" AND a.deposit_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.deposit_status != "Reject" AND a.bank_cheque_status = "Deposited"');
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

	function getChequeDepositList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id   WHERE a.deposit_status = "Approve"  AND a.bank_cheque_status = "NOT Deposited" AND a.deposit_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.deposit_status = "Approve" AND a.bank_cheque_status = "NOT Deposited"');
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




	function getHoldDepositForReleaseList(){
		$Date = date('Y-m-d');
		$list = $this->mdl_common->allSelects('SELECT * From deposit_info  WHERE cheque_status = "Hold" AND hold_date <="'.$Date.'"');
		foreach ($list as $key => $value) {
			$updateArr = array(
				'cheque_status'=>'Release',
			);
			$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$value['deposit_id']));
		}
		
	}


	function getDepositByID($id){
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id   WHERE a.deposit_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}

	function getRejectedDepositList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.deposit_status = "Reject" AND a.deposit_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.deposit_status = "Reject"');
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

	function getHoldDepositList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE a.cheque_status = "Hold" AND a.bank_cheque_status = "Deposited" AND a.hold_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, d.user_name as reseller_name From deposit_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id   WHERE a.cheque_status = "Hold" AND a.bank_cheque_status = "Deposited"');
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

	function releaseHoldDeposit(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['deposit_id'])){
			$updateArr = array(
				'cheque_status'=>'Release',
			);
			if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$_POST['deposit_id']))){
				$data = array('message'=>'Deposit Not Release! Error..');
				echo json_encode($data);				
			}else{
				$data = array('message'=>'Deposit Release');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Error... Deposit Not Release ');
			echo json_encode($data);	
		}
	}

	function useronHold(){
		  $data = array('status' => false);
		  $this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		  $this->db->where(array('cheque_status'=>'Hold'));
		  $user = $this->db->get('deposit_info')->result_array();
		  
		  if(count($user) == 0){
		   $data['status'] = true;
		  }
		  echo json_encode($data );
	}


	function rejectDepositStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['comment'])){
			$updateArr = array(
				'deposit_status'=>'Reject',
				'reject_comment'=>$_POST['comment']
			);
			if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$id))){
				$data = array('message'=>'Deposit Not Reject! Error..');
				echo json_encode($data);				
			}else{

				$userid = $this->mdl_common->allSelects('SELECT user_id from deposit_info where deposit_id = '.$id);
				foreach ($userid as $user) {
					$this->db->where('user_id',$user['user_id']);
					$rs2	=	$this->db->get('user_master');
					$UserInfo2	=	$rs2->num_rows();	
					if($UserInfo2 > 0){
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from user_master where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
						}
					}else{
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from reseller_store where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
						}		
					}

				}
				$data = array('message'=>'Deposit Rejected');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'Deposit Error...  Comment Required');
			echo json_encode($data);	
		}
	}

	function send_deposit_mail(  $user_email=null,  $userName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Deposit Rejected');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Deposit request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }
    function send_hold_deposit_mail(  $user_email=null,  $userName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Deposit Approved');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Deposit request has been approved. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }
	
	
	function send_hold_deposit_mail_store(  $user_email=null,  $userName=null, $dealerCode=null, $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Deposit Approved');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Deposit request has been approved. </p>
							<p>Your Dealer Code</p>
        					<p>'.$dealerCode.'</p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }
    

    function holdDepositStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['amount'])){
			$Date = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 14, date("Y")));
			$updateArr = array(
				'deposit_status'=>'Approve',
				'admin_amount'=>$_POST['amount'],
				'cheque_status'=>'Hold',
				'hold_date'=>$Date,
				'reject_comment'=>$_POST['comment']
				
			);
			$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$id));
			$userid = $this->mdl_common->allSelects('SELECT user_id from deposit_info where deposit_id = '.$id);
			foreach ($userid as $user) {
					$this->db->where('user_id',$user['user_id']);
					$rs2	=	$this->db->get('user_master');
					$UserInfo2	=	$rs2->num_rows();	
					if($UserInfo2 > 0){
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from user_master where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_hold_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
						}
					}else{
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name, dealer_code   from reseller_store where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_hold_deposit_mail_store($usermail['user_email'], $usermail['user_name'], $usermail['dealer_code'], $_POST['comment']);	
						}		
					}
				// $useremail = $this->mdl_common->allSelects('SELECT user_email, user_name from user_master where user_id = '.$user['user_id']);
				// foreach ($useremail as $usermail) {
				// 	$this->send_hold_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
				// }

				$Arr = array(
					'user_id'=>$user['user_id'],
					'credit'=>$_POST['amount'],
					'wallet_type'=>'1',
					'message'=>'Deposit Approve',
				);
				$this->db->insert('store_credit_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$user['user_id']));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$user['user_id'],
					);
					$this->db->insert('store_credit_report_user_map_info',$insertwallete);
				}
				
			}
			$data = array('message'=>'Deposit Approve');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Deposit Error... Amount Required');
			echo json_encode($data);	
		}
		
	}

	function releaseDepositStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['amount'])){
			
			$updateArr = array(
				'deposit_status'=>'Approve',
				'admin_amount'=>$_POST['amount'],
				'reject_comment'=>$_POST['comment']
			);
			$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$id));
			$userid = $this->mdl_common->allSelects('SELECT user_id from deposit_info where deposit_id = '.$id);
			foreach ($userid as $user) {
					$this->db->where('user_id',$user['user_id']);
					$rs2	=	$this->db->get('user_master');
					$UserInfo2	=	$rs2->num_rows();	
					if($UserInfo2 > 0){
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from user_master where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_hold_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
						}
					}else{
						$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name, dealer_code   from reseller_store where user_id = '.$user['user_id']);
						foreach ($useremail as $usermail) {
							$this->send_hold_deposit_mail_store($usermail['user_email'], $usermail['user_name'], $usermail['dealer_code'], $_POST['comment']);	
						}		
					}
				// $useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from user_master where user_id = '.$user['user_id']);
				// foreach ($useremail as $usermail) {
				// 	$this->send_hold_deposit_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
				// }

				$Arr = array(
					'user_id'=>$user['user_id'],
					'credit'=>$_POST['amount'],
					'wallet_type'=>'1',
					'message'=>'Deposit Approve',
				);
				$this->db->insert('store_credit_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$user['user_id']));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$user['user_id'],
					);
					$this->db->insert('store_credit_report_user_map_info',$insertwallete);
				}
				
			}
			$data = array('message'=>'Deposit Approve');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Deposit Error... Amount Required');
			echo json_encode($data);	
		}
		
	}

	
	


}