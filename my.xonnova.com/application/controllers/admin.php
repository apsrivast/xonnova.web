<?php

class Admin extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function getRankMembersNewList(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level where b.level_updated_at > "'.$lastDate.'"');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			
		}
	}

	
	function getActivationTotal(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT * From activate_platform where sim != "" AND sim_status="Pending"'));
		echo json_encode($total);
	}

	function getStoreTotal(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT * From  reseller_store where status="Pending"'));
		echo json_encode($total);
	}
	
	function insertIntoClientTable($post){
		//$post = json_decode(file_get_contents("php://input"),true);
		if(isset($post['sponsor_id'])&&!empty($post['sponsor_id'])){
			$sponsorId = $this->mdl_common->sponserID($post['sponsor_id']);
		}else{
			$sponsorId = '';
		}
		if(isset($post['package'])&&!empty($post['package'])){
			$package = $post['package'];
		}else{
			$package = '';
		}
		if(isset($post['first_name'])&&!empty($post['first_name'])){
			$firstName = $post['first_name'];
		}else{
			$firstName = '';
		}

		// if(isset($post['middle_name']) && !empty($post['middle_name'])){
		// 	$middleName = $post['middle_name'];
		// }else{
		// 	$middleName = '';
		// }

		if(isset($post['last_name'])&&!empty($post['last_name'])){
			$lastName = $post['last_name'];
		}else{
			$lastName = '';
		}
		if(isset($post['user_name'])&&!empty($post['user_name'])){
			$userName = $post['user_name'];
		}else{
			$userName = '';
		}
		if(isset($post['user_email'])&&!empty($post['user_email'])){
			$userEmail = $post['user_email'];
		}else{
			$userEmail = '';
		}
		if(isset($post['user_password'])&&!empty($post['user_password'])){
			$userPassword = $post['user_password'];
		}else{
			$userPassword = '';
		}
		if(isset($post['dob'])&&!empty($post['dob'])){
			$dob = $post['dob'];
		}else{
			$dob = '';
		}

		if(isset($post['address1'])&&!empty($post['address1'])){
			$address1 = $post['address1'];
		}else{
			$address1 = '';
		}

		// if(isset($post['address2']) && !empty($post['address2'])){
		// 	$address2 = $post['address2'];
		// }else{
		// 	$address2 = '';
		// }

		if(isset($post['city'])&&!empty($post['city'])){
			$city = $post['city'];
		}else{
			$city = '';
		}

		if(isset($post['state'])&&!empty($post['state'])){
			$state = $post['state'];
		}else{
			$state = '';
		}

		if(isset($post['zip'])&&!empty($post['zip'])){
			$zip = $post['zip'];
		}else{
			$zip = '';
		}
		if(isset($post['phone'])&&!empty($post['phone'])){
			$phone = $post['phone'];
		}else{
			$phone = '';
		}
		if(isset($post['country'])&&!empty($post['country'])){
			$country = $post['country'];
		}else{
			$country = '';
		}
		$insertArr = array(
				'sponsor_id'=>$sponsorId,
				'package_id'=>$package,//create
				'f_name'=>$firstName,
				//'middle_name'=>$middleName,
				'l_name'=>$lastName,
				'u_name'=>$userName,
				'u_email'=>$userEmail,
				'u_pass'=>$userPassword,
				'u_dob'=>$dob,//create
				'u_address'=>$address1,
				//'address2'=>$post['address2'],
				'u_city'=>$city,
				'u_state'=>$state,
				'u_zip'=>$zip,
				'u_contact'=>$phone,
				'u_country'=>$country,
				'fail_status'=>1,
		);
		$this->db->insert('store_user_info',$insertArr);

	}
	
	function insertIntoClientTableForAffiliate($post){
		//$post = json_decode(file_get_contents("php://input"),true);
		if(isset($post['sponsorid'])&&!empty($post['sponsorid'])){
			$sponsorId = $this->mdl_common->sponserID($post['sponsorid']);
		}else{
			$sponsorId = '';
		}
		if(isset($post['packag'])&&!empty($post['packag'])){
			$package = $post['packag'];
		}else{
			$package = '';
		}
		if(isset($post['fname'])&&!empty($post['fname'])){
			$firstName = $post['fname'];
		}else{
			$firstName = '';
		}

		// if(isset($post['middle_name']) && !empty($post['middle_name'])){
		// 	$middleName = $post['middle_name'];
		// }else{
		// 	$middleName = '';
		// }

		if(isset($post['lname'])&&!empty($post['lname'])){
			$lastName = $post['lname'];
		}else{
			$lastName = '';
		}
		if(isset($post['uname'])&&!empty($post['uname'])){
			$userName = $post['uname'];
		}else{
			$userName = '';
		}
		if(isset($post['fieldemail'])&&!empty($post['fieldemail'])){
			$userEmail = $post['fieldemail'];
		}else{
			$userEmail = '';
		}
		if(isset($post['password'])&&!empty($post['password'])){
			$userPassword = $post['password'];
		}else{
			$userPassword = '';
		}
		if(isset($post['dob'])&&!empty($post['dob'])){
			$dob = $post['dob'];
		}else{
			$dob = '';
		}

		if(isset($post['address1'])&&!empty($post['address1'])){
			$address1 = $post['address1'];
		}else{
			$address1 = '';
		}

		// if(isset($post['address2']) && !empty($post['address2'])){
		// 	$address2 = $post['address2'];
		// }else{
		// 	$address2 = '';
		// }

		if(isset($post['city'])&&!empty($post['city'])){
			$city = $post['city'];
		}else{
			$city = '';
		}

		if(isset($post['state'])&&!empty($post['state'])){
			$state = $post['state'];
		}else{
			$state = '';
		}

		if(isset($post['zip'])&&!empty($post['zip'])){
			$zip = $post['zip'];
		}else{
			$zip = '';
		}
		if(isset($post['phone'])&&!empty($post['phone'])){
			$phone = $post['phone'];
		}else{
			$phone = '';
		}
		if(isset($post['country'])&&!empty($post['country'])){
			$country = $post['country'];
		}else{
			$country = '';
		}
		$insertArr = array(
				'sponsor_id'=>$sponsorId,
				'package_id'=>$package,//create
				'f_name'=>$firstName,
				//'middle_name'=>$middleName,
				'l_name'=>$lastName,
				'u_name'=>$userName,
				'u_email'=>$userEmail,
				'u_pass'=>$userPassword,
				'u_dob'=>$dob,//create
				'u_address'=>$address1,
				//'address2'=>$post['address2'],
				'u_city'=>$city,
				'u_state'=>$state,
				'u_zip'=>$zip,
				'u_contact'=>$phone,
				'u_country'=>$country,
				'fail_status'=>1,
		);
		$this->db->insert('store_user_info',$insertArr);

	}


	function index(){
		$getPackage = $this->mdl_common->allSelects('Select * From package_info where package_status = "active"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}


	function send_user_email_on_purchase_approve($order_id=null, $user_name=null, $user_email=null, $shipping_id=null, $shipped_via=null, $shipping_date=null ) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('xonnova network Purchase Shipping Mail');
        //$html = $this->mdl_common->userMailBody($user_name,$password);
        $mail_body	=	$this->mailBody($order_id, $user_name, $shipping_id, $shipped_via, $shipping_date);
        $this->email->message($mail_body);

        $this->email->send();
    }

   function mailBody($order_id=null, $user_name=null,  $shipping_id=null, $shipped_via=null, $shipping_date=null){
			
		$mail_body = '
						<div>
						<h3>Order Shipped </h3>
						<h1 style="font-size:70px;">Thank you</h1>
						<p>Bellow are important detail about your order. Question? We are always here to help you. Simply contact our chat support at any time from your backoffice.</p>

						<p>Order number: "'.$order_id.'" </p>
						<p>Username: "'.$user_name.'"</p>

						<h4>Your recent order Shipping</h4>

						<table width="100%" cellspacing="0" cellpadding="10px"  height="100px" style="border:2px solid rgb(0,0,0);">
							<tbody>
								<tr style="background-color:#c0c0c0;" >
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										Tracking Id
									</td>
									<td  align="center" style="border:0 1px 0 1px solid rgb(0,0,0);">
										Shipped Via
									</td>
									

									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										Shipping Date
									</td>
									
								</tr>
								<tr>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										'.$shipping_id.'
									</td>
									<td  align="center" style="border:1px solid rgb(0,0,0);">
										'.$shipped_via.'
									</td>
									

									<td  align="center" style="border:1px solid rgb(0,0,0);">
										'.$shipping_date.'
									</td>
									
								</tr>
								
							</tbody>
						</table>
					</div>

					';
		
		return $mail_body;		
	}
	
	function updateOrderStatus(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'delivery_status'=>$_POST['delivery_status'],
			'shipped_via'=>$_POST['shipped_via'],
			'tracking_id'=>$_POST['tracking_id'],
			'shipping_date'=>$_POST['shipping_date'],
		);

		if(!$this->db->update('product_purchase_info',$updateArr, array('purchase_id'=>$_POST['purchase_id']))){
			$data = array('message'=>'Order status Not updated! Error..');
			echo json_encode($data);
		}else{
			$this->send_user_email_on_purchase_approve($_POST['order_id'], $_POST['user_name'], $_POST['user_email'], $_POST['tracking_id'], $_POST['shipped_via'], $_POST['shipping_date']);	
			
			$data = array('message'=>'Order status updated succesfully.');
			echo json_encode($data);
		}
	}
	function getSponserNameAutoSuggest(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT user_name FROM user_master');
		foreach ($query as $key => $value) {
			$arr[]= $value;
		}
		echo json_encode($arr);
	}
	
	public function addCreditUser() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->mdl_common->getUserId($_POST['user_name']);

		$amount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$id);
			if(isset($amount) && !empty($amount)){
				foreach ($amount as $total) {						
					$totalBalance= $total['total_balance'] + $_POST['credit'];
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$id));
				}
			}else{
				$totalBalance = $_POST['credit'];
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$id));
			}
			$Arr = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['credit'],
					'message'=>$_POST['message'],
				);
			$this->db->insert('add_credit',$Arr);

			//Earning Details in one table	
			$earning_details_by_user = array(
					'user_id'=>$id,
					'description'=>'Credit amount By Admin',
					'amount'=>$_POST['credit'],
					'message'=>$_POST['message'],
					'current_balance'=>$this->mdl_common->getTotalBalance($id),
					//'e_d_b_u_date'=>$value['created_at'],
				);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);
			//end
	}

	function getCreditList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name, d.* From add_credit as d LEFT JOIN  user_master as a on d.user_id= a.user_id LEFT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level ');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
		}
	}
	
	public function deleteCreditUser() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->mdl_common->getUserId($_POST['user_name']);

		$amount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$id);
			if(isset($amount) && !empty($amount) ){
				
				foreach ($amount as $total) {
					if($total['total_balance'] >= $_POST['credit']){
						$totalBalance= $total['total_balance'] - $_POST['credit'];
						$updattotalarr = array(
							'total_balance'=>$totalBalance,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$id));	
						$Arr = array(
							'user_id'=>$id,
							'admin_id'=>$this->session->userdata('user_id'),
							'credit'=>$_POST['credit'],
							'message'=>$_POST['message'],
						);
						$this->db->insert('deduct_credit',$Arr);
					//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$id,
								'description'=>'Deducted amount By admin',
								'amount'=> -$_POST['credit'],
								'message'=>$_POST['message'],
								'current_balance'=>$this->mdl_common->getTotalBalance($id),
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
					//end
						$data = array('message'=>'amount Deducted from '.$_POST['user_name'].' Account!');
						echo json_encode($data);
					}else{
						$data = array('message'=>'amount is greater than '.$_POST['user_name'].' Account balance : '.$total['total_balance']);
						echo json_encode($data);
					}
				}
				
			}else{
				$data = array('message'=>'amount NOT Deducted from '.$_POST['user_name'].' Account!');
				echo json_encode($data);
			}
	}

	function deleteCreditList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name, d.* From deduct_credit as d LEFT JOIN  user_master as a on d.user_id= a.user_id LEFT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level ');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
		}
	}
	
	function updateDepositStatus($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'deposit_status'=>'Approve'
		);
		if((isset($_POST['user_id']) && !empty($_POST['user_id'])) && !empty($_POST['deposit_id']) && !empty($_POST['bank_amount']) && !empty($_POST['deposit_status']) && $_POST['deposit_status'] != "Approve"){
			if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$id))){
				$data = array('message'=>'Deposit Not updated! Error..');
				echo json_encode($data);				
			}else{
				// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$_POST['user_id']);
				// if(isset($selectearningtotal) && !empty($selectearningtotal)){
				// 	foreach ($selectearningtotal as $total) {						
				// 		$totalBalance = $total['total_balance'] + $_POST['bank_amount'];
				// 		$updattotalarr = array('total_balance'=>$totalBalance);
				// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$_POST['user_id']));
				// 	}
				// }else{
				// 	$updattotalarr = array('total_balance'=>$_POST['bank_amount']);
				// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$_POST['user_id']));
				// }

				$Arr = array(
						'user_id'=>$_POST['user_id'],
						'admin_id'=>$this->session->userdata('user_id'),
						'credit'=>$_POST['bank_amount'],
						'wallet_type'=>'1',
						'message'=>'Deposit Approve',
					);
				$this->db->insert('store_credit_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$_POST['user_id']));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$_POST['user_id'],
						'admin_id'=>$this->session->userdata('user_id'),
					);
					$this->db->insert('store_credit_report_user_map_info',$insertwallete);
				}

				$data = array('message'=>'Deposit approved succesfully.');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'Error this Data is invalid!');
			echo json_encode($data);
		}
	}
	
	function getNewDeposits(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$total = count($this->mdl_common->allSelects('SELECT * From deposit_info where deposit_status="Pending"'));
		echo json_encode($total);
	}
	
	function getNewPlatformRequest(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$total = count($this->mdl_common->allSelects('SELECT * From new_platform where created_at > "'.$lastDate.'"'));
		echo json_encode($total);
	}
	
	function getNewUserSignups(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$total = count($this->mdl_common->allSelects('SELECT * From user_master where created_at > "'.$lastDate.'"'));
		//$total = count($this->mdl_common->allSelects('SELECT * From user_master where user_id > 1 AND shipping_status="not approved"'));
		echo json_encode($total);
	}
	
	function getNewRank(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$total = count($this->mdl_common->allSelects('SELECT * From earning_info where level_updated_at > "'.$lastDate.'"'));
		echo json_encode($total);
	}
	
	function getNewReferral(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$total = count($this->mdl_common->allSelects('SELECT * From user_master where updated_at > "'.$lastDate.'"'));
		echo json_encode($total);
	}

	
	function getRankMembersList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level  ORDER BY a.user_id DESC');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			
		}
	}

	function newOrderTab(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$contentData =count($this->mdl_common->allSelects('SELECT a.*, b.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id where a.delivery_status = "Processing"'));
		echo json_encode($contentData);
	}
	
	function getCurentUser(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master where user_id='.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	function getUser(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('Select * From user_master where parent_id = 0 and user_type="user" ORDER BY user_name ASC');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
	function addHolding(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST)){
			$position = $_POST['user_position'];
			$user = $_POST['user_name'];
			$childPosition = $_POST['child_position'];

			$lftPosition = $this->mdl_common->leftPosition($position);
			$rghtPosition = $this->mdl_common->rghtPosition($position);
			
			$packageId = $this->mdl_common->getUserPackageById($user);
			if($position == $user){
				$data = array("err"=>"Sorry.. Both Position & User Can not be same!");
				echo json_encode($data);
				return ;
			}else{
				if(!empty($childPosition) && $childPosition == 1){
					if($lftPosition != 0){ 
						$data = array("err"=>"This user have already Top Child!");
						echo json_encode($data);
					}else{
						$holding = array(
							'parent_id'=>$position,
							'position'=>$childPosition,
						);
						$this->db->update('user_master',$holding,array('user_id'=>$user));
						
						$updLeft = array(
								'lft_user'=>$user,
							);
						$this->db->update('user_master',$updLeft,array('user_id'=>$position));
						
						$sponsor = $this->mdl_common->getAllSponsor($user);
						
						$this->getParentToParentReferralBinary($position,$packageId,$user);
						
						$checkExistTeam = $this->mdl_common->selectChildUser($user);
						if($checkExistTeam){
							$this->getParentToParentReferralBinaryExistTeam($user);							
						}


						//////////////////////////////////////////////////////////////////////////////////////////////////
						$this->mdl_common->insertMatrixBonus($user, $packageId);
						
						$data = array("message"=>"User Added to Top Position in tree");
						echo json_encode($data);
					}				
				}else{
					if($rghtPosition != 0){
						$data = array("err"=>"This user have already Bottom Child!");
						echo json_encode($data);
					}else{
						$holding = array(
							'parent_id'=>$position,
							'position'=>$childPosition,
						);

						$this->db->update('user_master',$holding,array('user_id'=>$user));
						$updRght = array(
								'rght_user'=>$user,
							);
						$this->db->update('user_master',$updRght,array('user_id'=>$position));
						
						$sponsor = $this->mdl_common->getAllSponsor($user);
						
						$this->getParentToParentReferralBinary($position,$packageId,$user);
						
						$checkExistTeam = $this->mdl_common->selectChildUser($user);
						if($checkExistTeam){
							$this->getParentToParentReferralBinaryExistTeam($user);							
						}

						//////////////////////////////////////////////////////////////////////////////////////////////////
						$this->mdl_common->insertMatrixBonus($user, $packageId);
							
						$data = array("message"=>"User Added to Bottom Position in tree");
						echo json_encode($data);
					}
				}
			}
		}else{
			$data = array("err"=>"Error... User not Added to position!");
			echo json_encode($data);
		}
	}
	
	function getParentToParentReferralBinary($parntUser,$packageID,$childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllParent($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$currency = $this->mdl_common->sponsorCountry($sponser);
					if($currency =="MEX"){
						$binaryPoint = $this->onlegacy_mdl->getMEXPackageBinaryPoint($packageID);
					}else{
						$binaryPoint = $this->onlegacy_mdl->getUSPackageBinaryPoint($packageID);
					}
				}else{
					$binaryPoint = 0;
				}	
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point from earning_info where user_id = '.$sponser);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$totalBinaryPoint = $total['referral_binary_point'] + $binaryPoint;
							$updattotalarr = array(
								'referral_binary_point'=>$totalBinaryPoint,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						}
					}else{
						$totalBinaryPoint = $binaryPoint;
						$updattotalarr = array(
							'referral_binary_point'=>$totalBinaryPoint,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					}

					$insertBinamry = array(
							'parent_id'=>$sponser,
							'user_id'=>$user,
							'referral_binary'=>$binaryPoint
						);
					$this->db->insert('referrals_binary',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$user = $this->mdl_common->getAllParent($user);
		}
	}
	
	function getSponsorToSponsorQV($parntUser,$packageID,$childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllSponsor($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$parentCurrency = $this->mdl_common->sponsorCountry($sponser);
					if($parentCurrency =="MEX"){
						$binaryPoint = $this->onlegacy_mdl->getMEXPackageQvPoint($packageID);
					}else{
						$binaryPoint = $this->onlegacy_mdl->getUSPackageQvPoint($packageID);
					}
				}else{
					$binaryPoint = 0;
				}	
				$insertBinamry = array(
						'sponsor_id'=>$sponser,
						'user_id'=>$user,
						'qv_point'=>$binaryPoint
					);
				$this->db->insert('unilevel_binary_info',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			$user = $this->mdl_common->getAllSponsor($user);
		}
	}
	
	function getParentToParentReferralBinaryExistTeam($childUser){
		$TotalBV1 = $this->mdl_common->getNewTeamBV($childUser);
		
		$user = $childUser;
		$parent = $this->mdl_common->getAllParent($user);
		
		for($i=$parent; $i>=1; $i--){
			if($parent > 0){	
				$sponsorPackageForQv = $this->mdl_common->getPackageById($parent);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$TotalBV = $TotalBV1;
				}else{
					$TotalBV = 0;
				}	
				$selectearningtotal = $this->mdl_common->allSelects('SELECT * from earning_info where user_id = '.$parent);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$total = $total['referral_binary_point'] + $TotalBV;
							$updattotalarr = array(
								'referral_binary_point'=>$total,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
						}
					}else{
						$updattotalarr = array(
							'referral_binary_point'=>$TotalBV,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
					}

					$insertBinamry = array(
							'parent_id'=>$parent,
							'user_id'=>$user,
							'referral_binary'=>$TotalBV
						);
					$this->db->insert('referrals_binary',$insertBinamry);
				//echo $user.' => '.$TotalBV.'<br>';
			}
			$parent = $this->mdl_common->getAllParent($parent);
			$user = $this->mdl_common->getAllParent($user);
		}			
	}
	
	function addHoldingAccept(){
		$parent = $_POST['parent_id'];
		$user = $_POST['user_id'];
		$username = $_POST['user_name'];
		$position =$_POST['position'];
		if((isset($user) && !empty($user)) && (isset($parent) && !empty($parent)) && (isset($username) && !empty($username)) && (isset($position) && !empty($position))){
			if($position == 'L'){
				$arr = array(
						'lft_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}elseif($position == 'R'){
				$arr = array(
						'rght_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}else{
				echo 'Position Not Found!';
			}
		}else{
			echo 'Position Not Found! Error...';
		}
	}
	function addUnilevelAccept(){
		$parent = $this->mdl_common->getUserId($_POST['user_name']);
		$user = $_POST['user_id'];
		$username = $_POST['user_name'];
		$position =$_POST['position'];
		if((isset($user) && !empty($user)) && (isset($parent) && !empty($parent)) && (isset($username) && !empty($username)) && (isset($position) && !empty($position))){
			if($position == 'L'){
				$arr = array(
						'lft_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}elseif($position == 'R'){
				$arr = array(
						'rght_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}else{
				echo 'Position Not Found!';
			}
		}else{
			echo 'Position Not Found! Error...';
		}
	}

	function getVoucher(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('Select * From voucher_info');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function addVoucher(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if(isset($_POST['voucher_name'])&&!empty($_POST['voucher_name'])){
		}else{
			$data = array("message"=>"voucher name Required !"); 
			echo json_encode($data);
			return false ;
		}
		if(isset($_POST['voucher_code'])&&!empty($_POST['voucher_code'])){
		}else{
			$data = array("message"=>"voucher code Required !"); 
			echo json_encode($data);
			return false ;
		}
		if(isset($_POST['voucher_validity'])&&!empty($_POST['voucher_validity'])){
		}else{
			$data = array("message"=>"voucher validity Required !"); 
			echo json_encode($data);
			return false ;
		}
		if(isset($_POST['voucher_desc'])&&!empty($_POST['voucher_desc'])){
		}else{
			$_POST['voucher_desc'] = "";
		}


		if(isset($_POST) && !empty($_POST)){
			$inserArr = array(
				'voucher_name'=>trim($_POST['voucher_name']),
				'voucher_code'=>trim($_POST['voucher_code']),
				'voucher_desc'=>trim($_POST['voucher_desc']),
				'voucher_validity'=>trim($_POST['voucher_validity']),
				'voucher_status'=>trim('active'),
			);
			/* $this->db->insert('voucher_info',$inserArr);
			$data = array('message'=>'Voucher Added Successfully.');
			echo json_encode($data); */
			if(!$this->db->insert('voucher_info',$inserArr)){
				$data = array("message"=>"Sorry ...".$this->db->_error_message());
			}else{
				$data = array("message"=>"Voucher Added Successfully");
			}
			echo json_encode($data);
		}else{
			$data = array('message'=>'Voucher Error....');
			echo json_encode($data);
		}
	}

	function getPosition(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE lft_user=0 OR rght_user=0 ORDER BY user_name ASC');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	function getMember(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT * From user_master where user_type="user"'));
		echo json_encode($total);
	}

	function getTotalEarning(){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(total_balance) as total from earning_info');
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
    public function isUniqueValue() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) > 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	public function isUniqueValue1() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_email',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) > 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	public function isUniqueValue2() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}

	function userNameSpace($str){
		  return ( ! preg_match("/^([a-zA-Z0-9])+$/i", $str)) ? FALSE : TRUE;
		 }

	function insertUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['country']) && !empty($_POST['country'])){
		}else{
			$data = array("error"=>"Country field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
		}else{
			$data = array("error"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['middle_name']) && !empty($_POST['middle_name'])){
		}else{
			$_POST['middle_name'] = '';
		}
		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
		}else{
			$data = array("error"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$uname = $this->userNameSpace($_POST['user_name']);
			if($uname){
			}else{
				$data = array("error"=>"User Name field without space !");
				echo json_encode($data);
				return  ;
			}
		}else{
			$data = array("error"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['user_email']) && !empty($_POST['user_email'])){
		}else{
			$data = array("error"=>"Email field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else{
			$_POST['ssn'] = '';
		}
		if(isset($_POST['user_password']) && !empty($_POST['user_password'])){
		}else{
			$data = array("error"=>"Password field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['dob']) && !empty($_POST['dob'])){
		}else{
			$data = array("error"=>"Birth Date field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address1']) && !empty($_POST['address1'])){
		}else{
			$data = array("error"=>"Address field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else{
			$_POST['address2'] = '';
		}

		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("error"=>"City field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("error"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("error"=>"Zip Code field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone']) && !empty($_POST['phone'])){
		}else{
			$data = array("error"=>"Phone # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['phone_carrier']) && !empty($_POST['phone_carrier'])){
		}else{
			$data = array("error"=>"Phone Carrier # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['sponsor_id']) && !empty($_POST['sponsor_id'])){
		}else{
			$data = array("error"=>"Sponser Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['package']) && !empty($_POST['package'])){
		}else{
			$data = array("error"=>"Package field is required !");
			echo json_encode($data);
			return  ;
		}
		
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));
	
		$sponser = $this->mdl_common->sponserID($_POST['sponsor_id']);
		$currency = $this->mdl_common->sponsorCountry($sponser);
		$recuringAmount = $this->mdl_common->planPrice(1,$_POST['country']);
		$amount = $this->mdl_common->planPrice($_POST['package'],$_POST['country']);
		
		$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
		if(!empty($sponsorPackageForQv) && $sponsorPackageForQv > 1){
			$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);
			$binaryPoint = $this->mdl_common->packageBinaryPoint($_POST['package']);
			//$referralAmount = $this->mdl_common->packageReferralAmount($_POST['package']);
		}else{
			$qvPoint = 0;
			$binaryPoint = 0;
			//$referralAmount = 0;
		}
		$referralAmount = $this->mdl_common->packageReferralAmount($_POST['package'],$currency,$_POST['country']);
					
		$existUserName = $this->mdl_common->isUserExist($_POST['user_name']);
		$existUserEmail = $this->mdl_common->isEmailExist($_POST['user_email']);
		//$data['sponser'] = $_POST['sponsor_id'];
		$data = array("sponser"=>$_POST['sponsor_id']);
		if($existUserName == true && $existUserEmail == true){	
			
			if((isset($_POST['voucher_code']) && !empty($_POST['voucher_code']) && $_POST['voucher_code'] !=null) || (isset($_POST['checked']) && !empty($_POST['checked']))){
				$existVoucherCode = $this->mdl_common->isVoucherCodeExist($_POST['voucher_code']);
				if($existVoucherCode == true){
					/////////////////////////for no bonus/////////////////////////////////////////////////////////////
					$_POST['package'] = 1;
					$referralAmount = $this->mdl_common->packageReferralAmount($_POST['package'],$currency,$_POST['country']);

					$insertArr = array(
							'package'=>$_POST['package'],
							'first_name'=>$_POST['first_name'],
							'middle_name'=>$_POST['middle_name'],
							'last_name'=>$_POST['last_name'],
							'user_name'=>$_POST['user_name'],
							'user_email'=>$_POST['user_email'],
							'user_password'=>md5($_POST['user_password']),
							'dob'=>$_POST['dob'],
							'address1'=>$_POST['address1'],
							'address2'=>$_POST['address2'],
							'city'=>$_POST['city'],
							'state'=>$_POST['state'],
							'zip'=>$_POST['zip'],
							'contact_no'=>$_POST['phone'],
							'phone_carrier'=>$_POST['phone_carrier'],
							'country'=>$_POST['country'],
							'sponsor_id'=>$sponser,
							'form_status'=>1,
							'ssn'=>$_POST['ssn'],
					);
					$this->db->insert('user_master',$insertArr);
					$last_id =  $this->db->insert_id();
					//for apps table
					$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

					$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);

					$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

					//$this->mdl_common->insertShippingStatus($last_id,"Registration");
					if($_POST['package'] > 5){
						$levelRank = 5;
					}else{
						$levelRank = $_POST['package'];
					}
					$earnings = array(
									'user_id'=>$last_id,
									'sponser_id'=>$sponser,
									'total_amount'=>$amount,
									'referrals_earning'=>$referralAmount,
									'level'=>$levelRank,
								   );
					$this->db->insert('earning_info',$earnings);

					// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
							
					// if(isset($selectearningtotal) && !empty($selectearningtotal)){
					// 	foreach ($selectearningtotal as $total) {						
					// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
					// 		$updattotalarr = array(
					// 			'total_balance'=>$totalreferralAmount,
					// 		);
					// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// 	}
					// }else{
					// 	$totalreferralAmount = $referralAmount;
					// 	$updattotalarr = array(
					// 		'total_balance'=>$totalreferralAmount,
					// 	);
					// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// }
					
					// $inserBonus = array(
					// 		'parent_id'=>$sponser,
					// 		'user_id'=>$last_id,
					// 		'referral_bonus'=>$referralAmount
					// 	);
					// $this->db->insert('referral_bonus',$inserBonus);
					
					// //Earning Details in one table	
					// $earning_details_by_user = array(
					// 		'user_id'=>$sponser,
					// 		'ref_id'=>$last_id,
					// 		'type_id'=>'1',
					// 		'description'=>'Referral amount from '.$_POST['user_name'],
					// 		'amount'=>$referralAmount,
					// 		//'message'=>"",
					// 		//'e_d_b_u_date'=>$value['created_at'],
					// 	);
					// $this->db->insert('earning_details_by_user',$earning_details_by_user);
					// //end



					////bonus 2
					//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
					////bonus 3
					$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
					$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
					$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
					//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
					////bonus 5
					$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);





					$voucherinsertarr = array(
							'user_id'=>$last_id,
							'voucher_code'=>$_POST['voucher_code'],
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->insert('voucher_details',$voucherinsertarr);
					$voucherupdatearr = array(
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->update('voucher_info',$voucherupdatearr,array('voucher_code'=>$_POST['voucher_code']));

					$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
					$this->sendMail($last_id,$_POST['user_password']);
					
					$data = array("message"=>"Your Registration Completed succesfully");
					echo json_encode($data);
				}else{
					$data = array("error"=>"Voucher Code Not Exist !");
					echo json_encode($data);
				}	
			}else{
				if(isset($_POST['name_on_card']) && !empty($_POST['name_on_card'])){
				}else{
					$data = array("error"=>"Name on Card field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['card_no']) && !empty($_POST['card_no'])){
				}else{
					$data = array("error"=>"Card # field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['expiry_year']) && !empty($_POST['expiry_year'])){
				}else{
					$data = array("error"=>"Expiry Year field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['expiry_month']) && !empty($_POST['expiry_month'])){
				}else{
					$data = array("error"=>"Expiry Month field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['cvv_no']) && !empty($_POST['cvv_no'])){
				}else{
					$data = array("error"=>"CVV # field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['billing_zip']) && !empty($_POST['billing_zip'])){
				}else{
					$data = array("error"=>"Billing Zip field is required !");
					echo json_encode($data);
					return  ;
				}
				
				// //AIM payment Method
				// $this->load->library('authorize_net');

				// $auth_net = array(
				// 	'x_card_num'			=> trim($_POST['card_no']), // Visa
				// 	'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
				// 	'x_card_code'			=> trim($_POST['cvv_no']),
				// 	'x_description'			=> 'xonnova Network transaction',
				// 	'x_amount'				=> trim($amount),
				// 	//'x_amount'				=> 29,
				// 	'x_first_name'			=> $_POST['first_name'],
				// 	'x_last_name'			=> $_POST['last_name'],
				// 	'x_address'				=> $_POST['address1'].''.$_POST['address2'],
				// 	'x_city'				=> $_POST['city'],
				// 	'x_state'				=> $_POST['state'],
				// 	'x_zip'					=> $_POST['zip'],
				// 	'x_country'				=> $_POST['country'],
				// 	'x_phone'				=> trim($_POST['phone']),
				// 	'x_email'				=> $_POST['user_email'],
				// 	'x_customer_ip'			=> $this->input->ip_address(),
				// );

				// $this->authorize_net->setData($auth_net);
				
				// // Send request
				// if($this->authorize_net->authorizeAndCapture()){					
				// 	//ARB payment method
				// 	$this->load->library('authorize_arb');

				// 	// Start with a create object
				// 	$this->authorize_arb->startData('create');

				// 	$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				// 	$this->authorize_arb->addData('refId', $refId);
				// 	$total_amt = $amount + $recuringAmount;
				// 	$subscription_data = array(			
				// 		'name' => $_POST['name_on_card'].'xonnova Subscription',
				// 		'paymentSchedule' => array(
				// 			'interval' => array(
				// 				'length' => 1,
				// 				'unit' => 'months',
				// 				),
				// 			'startDate' => $recurringStartDate,
				// 			'totalOccurrences' => 9999,
				// 			'trialOccurrences' => 0,
				// 			),
				// 		'amount' => 29.00,
				// 		'trialAmount' => 0,
				// 		'payment' => array(
				// 			'creditCard' => array(
				// 				'cardNumber' => $_POST['card_no'],
				// 				'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
				// 				'cardCode' => $_POST['cvv_no'],
				// 				),
				// 			),			
				// 		'billTo' => array(
				// 			'firstName' => $this->input->post('user_name'),
				// 			'lastName' => $this->input->post('user_name'),				
				// 			),
				// 	);
			
				// 	$this->authorize_arb->addData('subscription', $subscription_data);

				$stripeValue = $this->mdl_common->getStripeValue();	
				if($stripeValue ==2){

					// //AIM payment Method
					$this->load->library('authorize_net');

					$auth_net = array(
						'x_card_num'			=> trim($_POST['card_no']), // Visa
						'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
						'x_card_code'			=> trim($_POST['cvv_no']),
						'x_description'			=> 'xonnova Network transaction',
						'x_amount'				=> trim($amount),
						//'x_amount'				=> 29,
						'x_first_name'			=> $_POST['first_name'],
						'x_last_name'			=> $_POST['last_name'],
						'x_address'				=> $_POST['address1'].''.$_POST['address2'],
						'x_city'				=> $_POST['city'],
						'x_state'				=> $_POST['state'],
						'x_zip'					=> $_POST['zip'],
						'x_country'				=> $_POST['country'],
						'x_phone'				=> trim($_POST['phone']),
						'x_email'				=> $_POST['user_email'],
						'x_customer_ip'			=> $this->input->ip_address(),
					);

					$this->authorize_net->setData($auth_net);
					
					// Send request
					if($this->authorize_net->authorizeAndCapture()){					
						//ARB payment method
						$this->load->library('authorize_arb');

						// Start with a create object
						$this->authorize_arb->startData('create');

						$refId = substr(md5( microtime() . 'ref' ), 0, 20);
						$this->authorize_arb->addData('refId', $refId);
						$total_amt = $amount + $recuringAmount;
						$subscription_data = array(			
							'name' => $_POST['name_on_card'].'xonnova Subscription',
							'paymentSchedule' => array(
								'interval' => array(
									'length' => 1,
									'unit' => 'months',
									),
								'startDate' => $recurringStartDate,
								'totalOccurrences' => 9999,
								'trialOccurrences' => 0,
								),
							'amount' => 29.00,
							'trialAmount' => 0,
							'payment' => array(
								'creditCard' => array(
									'cardNumber' => $_POST['card_no'],
									'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
									'cardCode' => $_POST['cvv_no'],
									),
								),			
							'billTo' => array(
								'firstName' => $this->input->post('user_name'),
								'lastName' => $this->input->post('user_name'),				
								),
						);
				
						$this->authorize_arb->addData('subscription', $subscription_data);
						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>2,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										'transaction_id'=>$this->authorize_net->getTransactionId(),
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
										'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();

						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);

						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
								
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }
						
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['user_name'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end



						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);





						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id,$_POST['user_password']);
							if($this->authorize_arb->send()){
									$arr = array(
										'transaction_arb_id'=>$this->authorize_arb->getId(),
									);
									$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
								$data = array("message"=>"WELCOME TO xonnova NETWORK Your Registration Completed succesfully! Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
								echo json_encode($data);
							}else{
								$data = array("error"=>"Registration  Fail! Subscription Error ID : ".$this->authorize_arb->getError()); 
								echo json_encode($data);
							}
					}else{
						$data = array("error"=>"Registration  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
						echo json_encode($data);
					}

				}elseif($stripeValue ==1){

					try {
					  	include('./stripe/init.php');
						\Stripe\Stripe::setApiKey('sk_live_1DZ70B8dI9zquSk4yCAUZ5Z4');
						$myCard = array('number' => $_POST['card_no'], 'exp_month' => $_POST['expiry_month'], 'exp_year' => $_POST['expiry_year']);
						$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $amount * 100, 'currency' => 'usd', "metadata" => array("user_name" => $_POST['user_name'])));



					
						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>2,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();

						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);

						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
								
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }
						
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['user_name'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end



						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);





						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id,$_POST['user_password']);
						// 	if($this->authorize_arb->send()){
						// 			$arr = array(
						// 				'transaction_arb_id'=>$this->authorize_arb->getId(),
						// 			);
						// 			$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
						// 		$data = array("message"=>"WELCOME TO xonnova NETWORK Your Registration Completed succesfully! Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
						// 		echo json_encode($data);
						// 	}else{
						// 		$data = array("error"=>"Registration  Fail! Subscription Error ID : ".$this->authorize_arb->getError()); 
						// 		echo json_encode($data);
						// 	}
						// }else{
						// 	$data = array("error"=>"Registration  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
						// 	echo json_encode($data);
						// }
						$data = array("message"=>"WELCOME TO  NETWORK Your Registration Completed succesfully ! Transaction ID : ".$charge->id);
						echo json_encode($data);

						} catch(\Stripe\Error\Card $e) {
						  	$body = $e->getJsonBody();
						  	$err  = $body['error'];
							$data = array("error"=>$err['message']);
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\RateLimit $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\InvalidRequest $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Authentication $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\ApiConnection $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Base $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (Exception $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						}

				}else{
						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>2,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										//'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										//'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();

						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);		
						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);

						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id,$_POST['user_password']);						
						$data = array("message"=>"WELCOME TO  NETWORK Your Registration Completed succesfully ! ");
						echo json_encode($data);				
				}
			}
			$existUserNameInClient = count($this->mdl_common->allSelects('SELECT * From user_master where user_name="'.$_POST['user_name'].'"'));
			if($existUserNameInClient == 0){	
				$this->insertIntoClientTable($_POST);	
			}
		}else{
			$data = array("error"=>"User allready Exist !");
			echo json_encode($data);
		}	
	}

	
	function addAffiliate(){
		header('Content-Type: application/json');
		if(isset($_POST['country']) && !empty($_POST['country'])){
		}else{
			$data = array("error"=>"Country field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['fname']) && !empty($_POST['fname'])){
		}else{
			$data = array("error"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['mname']) && !empty($_POST['mname'])){
		}else{
			$_POST['mname'] = '';
		}
		if(isset($_POST['lname']) && !empty($_POST['lname'])){
		}else{
			$data = array("error"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['uname']) && !empty($_POST['uname'])){
			$uname = $this->userNameSpace($_POST['uname']);
			if($uname){
			}else{
				$data = array("error"=>"User Name field without space !");
				echo json_encode($data);
				return  ;
			}
		}else{
			$data = array("error"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['fieldemail']) && !empty($_POST['fieldemail'])){
		}else{
			$data = array("error"=>"Email field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else{
			$_POST['ssn'] = '';
		}
		if(isset($_POST['password']) && !empty($_POST['password'])){
		}else{
			$data = array("error"=>"Password field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['dob']) && !empty($_POST['dob'])){
		}else{
			$data = array("error"=>"Birth Date field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address1']) && !empty($_POST['address1'])){
		}else{
			$data = array("error"=>"Address field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else{
			$_POST['address2'] = '';
		}

		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("error"=>"City field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("error"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("error"=>"Zip Code field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone']) && !empty($_POST['phone'])){
		}else{
			$data = array("error"=>"Phone # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['phonecarrier']) && !empty($_POST['phonecarrier'])){
		}else{
			$data = array("error"=>"Phone Carrier # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['sponsorid']) && !empty($_POST['sponsorid'])){
		}else{
			$data = array("error"=>"Sponser Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['packag']) && !empty($_POST['packag'])){
		}else{
			$data = array("error"=>"Package field is required !");
			echo json_encode($data);
			return  ;
		}
		$parentUserID = $this->mdl_common->getUserId($_POST['parentUser']);//$_POST['parentUser'];
		$sponser = $this->mdl_common->sponserID($_POST['sponsorid']);
		$currency = $this->mdl_common->sponsorCountry($sponser);
		$recuringAmount = $this->mdl_common->planPrice(1,$_POST['country']);
		$amount = $this->mdl_common->planPrice($_POST['packag'],$_POST['country']);
		
		$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
		if(!empty($sponsorPackageForQv) && $sponsorPackageForQv > 1){
			$qvPoint = $this->mdl_common->packageQVPoint($_POST['packag']);
			$binaryPoint = $this->mdl_common->packageBinaryPoint($_POST['packag']);
			//$referralAmount = $this->mdl_common->packageReferralAmount($_POST['packag']);
		}else{
			$qvPoint = 0;
			$binaryPoint = 0;
			//$referralAmount = 0;
		}
		$referralAmount = $this->mdl_common->packageReferralAmount($_POST['packag'],$currency,$_POST['country']);
		
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));

		$existUserName = $this->mdl_common->isUserExist($_POST['uname']);
		$existUserEmail = $this->mdl_common->isEmailExist($_POST['fieldemail']);
		if($existUserName == true && $existUserEmail == true){
			if((isset($_POST['voucher']) && !empty($_POST['voucher']) && $_POST['voucher'] !=null) && (isset($_POST['check']) && !empty($_POST['check']))){
				$existVoucherCode = $this->mdl_common->checkVoucherCode($_POST['voucher']);
				if(isset($existVoucherCode) && !empty($existVoucherCode) && $existVoucherCode == $_POST['voucher']){
					/////////////////////////for no bonus/////////////////////////////////////////////////////////////
					$_POST['packag'] = 1;
					$referralAmount = $this->mdl_common->packageReferralAmount($_POST['packag'],$currency,$_POST['country']);
					$insertArr = array(
							'parent_id'=>$parentUserID,
							'package'=>$_POST['packag'],
							'first_name'=>$_POST['fname'],
							'middle_name'=>$_POST['mname'],
							'last_name'=>$_POST['lname'],
							'user_name'=>$_POST['uname'],
							'user_email'=>$_POST['fieldemail'],
							'user_password'=>md5($_POST['password']),
							'dob'=>$_POST['dob'],
							'address1'=>$_POST['address1'],
							'address2'=>$_POST['address2'],
							'city'=>$_POST['city'],
							'state'=>$_POST['state'],
							'zip'=>$_POST['zip'],
							'contact_no'=>$_POST['phone'],
							'phone_carrier'=>$_POST['phonecarrier'],
							'country'=>$_POST['country'],
							'sponsor_id'=>$sponser,
							'form_status'=>3,
							'ssn'=>$_POST['ssn'],
					);
					$this->db->insert('user_master',$insertArr);
					$last_id =  $this->db->insert_id();

					//for apps table
					$this->mdl_common->xoApp($_POST['fieldemail'],$_POST['password']);

					$this->mdl_common->insertShippingStatus($last_id,"Registration");
					
					if(!empty($_POST['userchild']) && $_POST['userchild'] == 'L'){
						$updArr = array('lft_user'=>$last_id);
						$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
					}elseif(!empty($_POST['userchild']) &&$_POST['userchild'] == 'R'){
						$updArr = array('rght_user'=>$last_id);
						$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
					}
					if($_POST['packag'] > 5){
						$levelRank = 5;
					}else{
						$levelRank = $_POST['packag'];
					}
					$earnings = array(
									'user_id'=>$last_id,
									'sponser_id'=>$sponser,
									'total_amount'=>$amount,
									'referrals_earning'=>$referralAmount,
									'level'=>$levelRank,
								   );
					$this->db->insert('earning_info',$earnings);
					
					// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
							
					// if(isset($selectearningtotal) && !empty($selectearningtotal)){
					// 	foreach ($selectearningtotal as $total) {						
					// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
					// 		$updattotalarr = array(
					// 			'total_balance'=>$totalreferralAmount,
					// 		);
					// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// 	}
					// }else{
					// 	$totalreferralAmount = $referralAmount;
					// 	$updattotalarr = array(
					// 		'total_balance'=>$totalreferralAmount,
					// 	);
					// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// }

					$this->getSponsorToSponsorQV($sponser,$_POST['packag'],$last_id);
					
					$this->getParentToParentReferralBinary($parentUserID,$_POST['packag'],$last_id);
					
					// $inserBonus = array(
					// 		'parent_id'=>$sponser,
					// 		'user_id'=>$last_id,
					// 		'referral_bonus'=>$referralAmount
					// 	);
					// $this->db->insert('referral_bonus',$inserBonus);
					
					// //Earning Details in one table	
					// $earning_details_by_user = array(
					// 		'user_id'=>$sponser,
					// 		'ref_id'=>$last_id,
					// 		'type_id'=>'1',
					// 		'description'=>'Referral amount from '.$_POST['uname'],
					// 		'amount'=>$referralAmount,
					// 		//'message'=>"",
					// 		//'e_d_b_u_date'=>$value['created_at'],
					// 	);
					// $this->db->insert('earning_details_by_user',$earning_details_by_user);
					// //end



					////bonus 2
					//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
					////bonus 3
					$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
					$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['packag']);
					$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
					//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
					////bonus 5
					$this->mdl_common->insertMatrixBonus($last_id, $_POST['packag']);




					$voucherinsertarr = array(
							'user_id'=>$last_id,
							'voucher_code'=>$_POST['voucher'],
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->insert('voucher_details',$voucherinsertarr);
					$voucherupdatearr = array(
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->update('voucher_info',$voucherupdatearr,array('voucher_code'=>$_POST['voucher']));
					
					$this->send_user_email($_POST['uname'],$_POST['password'],$_POST['fieldemail']);
					$this->sendMail($last_id,$_POST['password']);
					$data['sucess'] = "Your registration completed successfully ";//array("message"=>"Your Registration Completed succesfully");
					echo json_encode($data);
				}else{
					$data['error'] = "Registration Fail! & Your Voucher Code is Invalid ";
					echo json_encode($data);
				}				
			}else{
				if(isset($_POST['nameoncard']) && !empty($_POST['nameoncard'])){
				}else{
					$data = array("error"=>"Name on Card field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['cardno']) && !empty($_POST['cardno'])){
				}else{
					$data = array("error"=>"Card # field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['year']) && !empty($_POST['year'])){
				}else{
					$data = array("error"=>"Expiry Year field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['month']) && !empty($_POST['month'])){
				}else{
					$data = array("error"=>"Expiry Month field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['cvvno']) && !empty($_POST['cvvno'])){
				}else{
					$data = array("error"=>"CVV # field is required !");
					echo json_encode($data);
					return  ;
				}

				if(isset($_POST['billingzip']) && !empty($_POST['billingzip'])){
				}else{
					$data = array("error"=>"Billing Zip field is required !");
					echo json_encode($data);
					return  ;
				}
								
				// //AIM payment Method
				// $this->load->library('authorize_net');
				// $auth_net = array(
				// 	'x_card_num'			=> trim($_POST['cardno']), // Visa
				// 	'x_exp_date'			=> trim($_POST['year']).'/'.trim($_POST['month']),
				// 	'x_card_code'			=> trim($_POST['cvvno']),
				// 	'x_description'			=> $_POST['nameoncard'].'xonnova Network  transaction',
				// 	'x_amount'				=> trim($amount),
				// 	//'x_amount'				=> 29,
				// 	'x_first_name'			=> $_POST['fname'],
				// 	'x_last_name'			=> $_POST['lname'],
				// 	'x_address'				=> $_POST['address1'].''.$_POST['address2'],
				// 	'x_city'				=> $_POST['city'],
				// 	'x_state'				=> $_POST['state'],
				// 	'x_zip'					=> $_POST['zip'],
				// 	'x_country'				=> $_POST['country'],
				// 	'x_phone'				=> trim($_POST['phone']),
				// 	'x_email'				=> $_POST['fieldemail'],
				// 	'x_customer_ip'			=> $this->input->ip_address(),
				// );

				// $this->authorize_net->setData($auth_net);
				
				// // Send request
				// if($this->authorize_net->authorizeAndCapture()){
				// 	//ARB payment method
				// 	$this->load->library('authorize_arb');

				// 	// Start with a create object
				// 	$this->authorize_arb->startData('create');

				// 	$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				// 	$this->authorize_arb->addData('refId', $refId);
				// 	$total_amt = $amount + $recuringAmount;
				// 	$subscription_data = array(			
				// 		'name' => $_POST['nameoncard'].'xonnova Subscription',
				// 		'paymentSchedule' => array(
				// 			'interval' => array(
				// 				'length' => 1,
				// 				'unit' => 'months',
				// 				),
				// 			'startDate' => $recurringStartDate,
				// 			'totalOccurrences' => 9999,
				// 			'trialOccurrences' => 0,
				// 			),
				// 		'amount' => 29.00,
				// 		'trialAmount' => 0,
				// 		'payment' => array(
				// 			'creditCard' => array(
				// 				'cardNumber' => $_POST['cardno'],
				// 				'expirationDate' => $_POST['year'].'-'.$_POST['month'],
				// 				'cardCode' => $_POST['cvvno'],
				// 				),
				// 			),			
				// 		'billTo' => array(
				// 			'firstName' => $_POST['uname'],
				// 			'lastName' => $_POST['lname'],				
				// 			),
				// 	);
			
				// 	$this->authorize_arb->addData('subscription', $subscription_data);
				// 	//$this->authorize_arb->addData('subscription', $subscription_data);

				$stripeValue = $this->mdl_common->getStripeValue();	
				if($stripeValue == 2){

					//AIM payment Method
					$this->load->library('authorize_net');
					$auth_net = array(
						'x_card_num'			=> trim($_POST['cardno']), // Visa
						'x_exp_date'			=> trim($_POST['year']).'/'.trim($_POST['month']),
						'x_card_code'			=> trim($_POST['cvvno']),
						'x_description'			=> $_POST['nameoncard'].'xonnova Network  transaction',
						'x_amount'				=> trim($amount),
						//'x_amount'				=> 29,
						'x_first_name'			=> $_POST['fname'],
						'x_last_name'			=> $_POST['lname'],
						'x_address'				=> $_POST['address1'].''.$_POST['address2'],
						'x_city'				=> $_POST['city'],
						'x_state'				=> $_POST['state'],
						'x_zip'					=> $_POST['zip'],
						'x_country'				=> $_POST['country'],
						'x_phone'				=> trim($_POST['phone']),
						'x_email'				=> $_POST['fieldemail'],
						'x_customer_ip'			=> $this->input->ip_address(),
					);

					$this->authorize_net->setData($auth_net);
					
					// Send request
					if($this->authorize_net->authorizeAndCapture()){
						//ARB payment method
						$this->load->library('authorize_arb');

						// Start with a create object
						$this->authorize_arb->startData('create');

						$refId = substr(md5( microtime() . 'ref' ), 0, 20);
						$this->authorize_arb->addData('refId', $refId);
						$total_amt = $amount + $recuringAmount;
						$subscription_data = array(			
							'name' => $_POST['nameoncard'].'xonnova Subscription',
							'paymentSchedule' => array(
								'interval' => array(
									'length' => 1,
									'unit' => 'months',
									),
								'startDate' => $recurringStartDate,
								'totalOccurrences' => 9999,
								'trialOccurrences' => 0,
								),
							'amount' => 29.00,
							'trialAmount' => 0,
							'payment' => array(
								'creditCard' => array(
									'cardNumber' => $_POST['cardno'],
									'expirationDate' => $_POST['year'].'-'.$_POST['month'],
									'cardCode' => $_POST['cvvno'],
									),
								),			
							'billTo' => array(
								'firstName' => $_POST['uname'],
								'lastName' => $_POST['lname'],				
								),
						);
				
						$this->authorize_arb->addData('subscription', $subscription_data);
						//$this->authorize_arb->addData('subscription', $subscription_data);
						$insertArr = array(
								'parent_id'=>$parentUserID,
								'package'=>$_POST['packag'],
								'first_name'=>$_POST['fname'],
								'middle_name'=>$_POST['mname'],
								'last_name'=>$_POST['lname'],
								'user_name'=>$_POST['uname'],
								'user_email'=>$_POST['fieldemail'],
								'user_password'=>md5($_POST['password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phonecarrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>4,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['fieldemail'],$_POST['password']);


						$this->mdl_common->insertShippingStatus($last_id,"Registration");
						if(!empty($_POST['userchild']) && $_POST['userchild'] == 'L'){
							$updArr = array('lft_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}elseif(!empty($_POST['userchild']) &&$_POST['userchild'] == 'R'){
							$updArr = array('rght_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}
						$expiry_year = $_POST['month'].'/'.$_POST['year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['packag'],
										'name_on_card'=>$_POST['nameoncard'],
										'card_no'=>$_POST['cardno'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvvno'],
										'billing_zip'=>$_POST['billingzip'],
										'transaction_id'=>$this->authorize_net->getTransactionId(),
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
										'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();
						if($_POST['packag'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['packag'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);
						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
							
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }

						$this->getSponsorToSponsorQV($sponser,$_POST['packag'],$last_id);
						
						$this->getParentToParentReferralBinary($parentUserID,$_POST['packag'],$last_id);
						
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['uname'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end



						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['packag']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['packag']);





						
						$this->send_user_email($_POST['uname'],$_POST['password'],$_POST['fieldemail']);
						$this->sendMail($last_id,$_POST['password']);
							if($this->authorize_arb->send()){
									$arr = array(
										'transaction_arb_id'=>$this->authorize_arb->getId(),
									);
									$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
								$data['sucess'] = "WELCOME TO xonnova NETWORK Your Registration Completed succesfully!   Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId();
								echo json_encode($data);	
							}else{
								$data['error'] = "Registration  Fail! Subscription Error ID : ".$this->authorize_arb->getError();//array("message"=>"Registration  Fail!".$this->authorize_net->getError());
								echo json_encode($data);
							}
					}else{
						$data['error'] = "Registration  Fail! Transaction Error ID : ".$this->authorize_net->getError();//array("message"=>"Registration  Fail!".$this->authorize_net->getError());
						echo json_encode($data);
					}


				}elseif($stripeValue == 1){

					try {
					  	include('./stripe/init.php');
						\Stripe\Stripe::setApiKey('sk_live_1DZ70B8dI9zquSk4yCAUZ5Z4');
						$myCard = array('number' => $_POST['cardno'], 'exp_month' => $_POST['month'], 'exp_year' => $_POST['year']);
						$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $amount * 100, 'currency' => 'usd', "metadata" => array("user_name" => $_POST['uname'])));



							
						$insertArr = array(
								'parent_id'=>$parentUserID,
								'package'=>$_POST['packag'],
								'first_name'=>$_POST['fname'],
								'middle_name'=>$_POST['mname'],
								'last_name'=>$_POST['lname'],
								'user_name'=>$_POST['uname'],
								'user_email'=>$_POST['fieldemail'],
								'user_password'=>md5($_POST['password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phonecarrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>4,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['fieldemail'],$_POST['password']);


						$this->mdl_common->insertShippingStatus($last_id,"Registration");
						if(!empty($_POST['userchild']) && $_POST['userchild'] == 'L'){
							$updArr = array('lft_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}elseif(!empty($_POST['userchild']) &&$_POST['userchild'] == 'R'){
							$updArr = array('rght_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}
						$expiry_year = $_POST['month'].'/'.$_POST['year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['packag'],
										'name_on_card'=>$_POST['nameoncard'],
										'card_no'=>$_POST['cardno'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvvno'],
										'billing_zip'=>$_POST['billingzip'],
										'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();
						if($_POST['packag'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['packag'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);
						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
							
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }

						$this->getSponsorToSponsorQV($sponser,$_POST['packag'],$last_id);
						
						$this->getParentToParentReferralBinary($parentUserID,$_POST['packag'],$last_id);
						
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['uname'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end



						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['packag']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['packag']);





						
						$this->send_user_email($_POST['uname'],$_POST['password'],$_POST['fieldemail']);
						$this->sendMail($last_id,$_POST['password']);
						// 	if($this->authorize_arb->send()){
						// 			$arr = array(
						// 				'transaction_arb_id'=>$this->authorize_arb->getId(),
						// 			);
						// 			$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
						// 		$data['sucess'] = "WELCOME TO xonnova NETWORK Your Registration Completed succesfully!   Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId();
						// 		echo json_encode($data);	
						// 	}else{
						// 		$data['error'] = "Registration  Fail! Subscription Error ID : ".$this->authorize_arb->getError();//array("message"=>"Registration  Fail!".$this->authorize_net->getError());
						// 		echo json_encode($data);
						// 	}
						// }else{
						// 	$data['error'] = "Registration  Fail! Transaction Error ID : ".$this->authorize_net->getError();//array("message"=>"Registration  Fail!".$this->authorize_net->getError());
						// 	echo json_encode($data);
						// }
								$data['sucess'] = "WELCOME TO  NETWORK Your Registration Completed succesfully! Transaction ID : ".$charge->id;
								echo json_encode($data);


						} catch(\Stripe\Error\Card $e) {
						  	$body = $e->getJsonBody();
						  	$err  = $body['error'];
							$data = array("error"=>$err['message']);
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\RateLimit $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\InvalidRequest $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Authentication $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\ApiConnection $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Base $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (Exception $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						}
				}else{	
						$insertArr = array(
								'parent_id'=>$parentUserID,
								'package'=>$_POST['packag'],
								'first_name'=>$_POST['fname'],
								'middle_name'=>$_POST['mname'],
								'last_name'=>$_POST['lname'],
								'user_name'=>$_POST['uname'],
								'user_email'=>$_POST['fieldemail'],
								'user_password'=>md5($_POST['password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>$_POST['address2'],
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phonecarrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>4,
								'ssn'=>$_POST['ssn'],
						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['fieldemail'],$_POST['password']);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");
						if(!empty($_POST['userchild']) && $_POST['userchild'] == 'L'){
							$updArr = array('lft_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}elseif(!empty($_POST['userchild']) &&$_POST['userchild'] == 'R'){
							$updArr = array('rght_user'=>$last_id);
							$this->db->update('user_master',$updArr,array('user_id'=>$parentUserID));
						}
						$expiry_year = $_POST['month'].'/'.$_POST['year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['packag'],
										'name_on_card'=>$_POST['nameoncard'],
										'card_no'=>$_POST['cardno'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvvno'],
										'billing_zip'=>$_POST['billingzip'],
										//'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										//'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();
						if($_POST['packag'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['packag'];
						}
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);						

						$this->getSponsorToSponsorQV($sponser,$_POST['packag'],$last_id);
						
						$this->getParentToParentReferralBinary($parentUserID,$_POST['packag'],$last_id);

						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['packag']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['packag']);
						
						$this->send_user_email($_POST['uname'],$_POST['password'],$_POST['fieldemail']);
						$this->sendMail($last_id,$_POST['password']);						
						$data['sucess'] = "WELCOME TO  NETWORK Your Registration Completed succesfully!";
						echo json_encode($data);
				}
			}
			$existUserNameInClient = count($this->mdl_common->allSelects('SELECT * From user_master where user_name="'.$_POST['uname'].'"'));
			if($existUserNameInClient == 0){	
				$this->insertIntoClientTableForAffiliate($_POST);	
			}
		}else{
			$data['error'] = "User allready Exist !";
			echo json_encode($data);
		}
	}
	
	function updateUser(){

	}

	function deleteUser(){

	}

	function month(){
		 for($i=1;$i<=12;$i++){
            $selected   =   '';
            if($expiry_month == $i)
                $selected   =   'selected="selected"';
            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
        }
	}
	
	function year(){

	}

	function insertPkg(){
		$user = json_decode(file_get_contents("php://input"),true);
		//$column_names = array('first_name', 'middle_name', 'last_name', 'user_name', 'user_email','user_password','dob','address1','address2','city','state','zip','country','sponsor_id','package');
		//if(!empty($user['pckage_name']) && !empty($user['pckage_price']) && !empty($user['discount']) && !empty($user['status']) && !empty($user['bv']) && !empty($user['qv']) && !empty($user['status'])){
			$insertArr = array(
					'package_name'=>$user['pckage_name'],
					'entry_ammout'=>$user['pckage_price'],
					'binary_point'=>$user['bv'],
					'qv_point'=>$user['qv_point'],
					//'exit_price'=>$user['qv'],
					'descount_percent'=>$user['discount'],
					'st_package_amount'=>$user['st_package_amount'],
					'package_status'=>$user['status'],
				);
		//$this->db->insert('package_info',$insertArr);
		if(!$this->db->insert('package_info',$insertArr)){
			$data = array('message'=>'Package Not Created');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Package Created Successfully');
			echo json_encode($data);
		}
	}

	function getPackage(){
		header('Content-Type: application/json');
		
		$getReferrals = $this->mdl_common->allSelects('Select * from package_info  order by package_id desc');
		foreach ($getReferrals as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);			
	}

	function getPackageById($id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('Select * from package_info where package_status = "active" and package_id='.$id.' order by package_id desc');
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
	}

	function updatePackage($id){
		$user = json_decode(file_get_contents("php://input"),true);
		//if(!empty($user['package_name']) && !empty($user['entry_ammout']) && !empty($user['descount_percent']) && !empty($user['referrals_amount']) && !empty($user['Binary_point']) && !empty($user['exit_price'])){
			$updateArr = array(
					'package_name'=>$user['package_name'],
					'entry_ammout'=>$user['entry_ammout'],
					'descount_percent'=>$user['descount_percent'],
					'referrals_amount'=>$user['referrals_amount'],
					'Binary_point'=>$user['Binary_point'],
					'st_package_amount'=>$user['st_package_amount'],
					'qv_point'=>$user['qv_point'],
					//'exit_price'=>$user['exit_price'],
				);
		//$this->db->update('package_info',$updateArr, array('package_id'=>$user['package_id']));
		if(!$this->db->update('package_info',$updateArr, array('package_id'=>$user['package_id']))){
			$data = array('message'=>'Package Not Updated!');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Package updated Successfully');
			echo json_encode($data);
		}
	}  

	function deletePackage($id){
		return $this->db->update('package_info',array('package_status'=>'deleted'),array('package_id'=>$id));
		//return $this->db->delete('package_info',array('package_id'=>$id));
	}

	/*function getCashout(){
		header('Content-Type: application/json');
		
		$getReferrals = $this->mdl_common->allSelects('Select a.*, b.* from user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id where a.user_type = "user" order by user_id desc');
		foreach ($getReferrals as $value) {
			$arrCas[] = $value;
		}
		echo json_encode($arrCas);		
	}*/

	function check_user($userName){
		echo false;
	}

	function getPlatform(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM new_platform');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}
	function getLead(){
	
		

		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM new_leads as a LEFT JOIN user_master as c on c.user_id=a.user_id WHERE  a.send_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}	
		}else{
			
			$contentData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM new_leads as a LEFT JOIN user_master as c on c.user_id=a.user_id');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}	
		}	
	}

	function getLead2(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM new_leads as a LEFT JOIN user_master as c on c.user_id=a.user_id');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}

	function getDeposit2(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id WHERE a.deposit_status = "Pending"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}	
	}
	function getDeposit(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*,c.user_name, d.user_name as reseller_name FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id WHERE a.deposit_status = "Pending" AND a.deposit_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*,c.user_name, d.user_name as reseller_name  FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id WHERE a.deposit_status = "Pending"');
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

	function getApproveDeposit(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id WHERE a.deposit_status = "Approve" AND a.bank_cheque_status = "Deposited"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}	
	}

	function isVoucherCode(){
		  $data = array('status' => true);
		  $value  = json_decode(file_get_contents("php://input"),true);
		  //$date = date("y-m-d");
			if(!empty($value['voucher']) && $value['voucher'] != null){
			  $this->db->where('voucher_code',$value['voucher']);
			  //$this->db->where('voucher_validity >=',$date);
			  $this->db->where('voucher_status','active');
			  $this->db->where('used','un_used');
			  $user = $this->db->get('voucher_info')->result_array();
			  
			  if(count($user) == 0){
			   $data['status'] = false;
			  }
			}else{
				 $data = array('status' => true);
			}	  
		  echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	function getUserName(){
		header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.user_name as sponsor_name From user_master as a Right JOIN user_master as b on a.sponsor_id= b.user_id where a.user_type="user"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
	function platformsList(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN platforms_list as b on b.user_id=a.user_id');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	

	function addPlatform(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
			$imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'platforms'.$date.'.png';
			//$image = 'platforms'.$date.$_FILES[ 'file' ][ 'name' ];
			
			$insertArr = array(
			
				'platforms_image' => $image,
				'platforms_name'=>$_POST['platforms_name'],
				'platforms_url'=>$_POST['platforms_url'],	
				'platforms_comment'=>$_POST['platforms_comment'],
			);

			$configVideo = array(
					'upload_path' => './uploads/',
					'max_size' => '8000240',
					'allowed_types' => 'png|gif|jpg|jpeg',
					'overwrite'=> FALSE,
					'remove_spaces' => TRUE,
					'file_name'=> $image
			);

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array('message'=>'Platform Error.....!');
				echo json_encode($data);
			} else {
			   $this->db->insert('platforms_list',$insertArr); 
			   $data = array('message'=>'Platform Added Sucessfully');
			   echo json_encode($data);
			}	 
		}else{ 
				$data = array('message'=>'No Files Error.....!');
				echo json_encode($data);
		}
	} 
	
	function editPlatform(){					
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
			$imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'platforms'.$date.'.png';
			//$image = 'platforms'.$date.$_FILES[ 'file' ][ 'name' ];
			
			$insertArr = array(
				
				'platforms_image' => $image,
				'platforms_name'=>$_POST['platforms_name'],
				'platforms_url'=>$_POST['platforms_url'],					
			);

			$configVideo = array(
					'upload_path' => './uploads/',
					'max_size' => '8000240',
					'allowed_types' => 'png|gif|jpg|jpeg',
					'overwrite'=> FALSE,
					'remove_spaces' => TRUE,
					'file_name'=> $image
			);

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array('message'=>'Platform Error.....!');
				echo json_encode($data);
			}else{
			   $this->db->update('platforms_list',$insertArr, array('id'=>$_POST['id'])); 
			   $data = array('message'=>'Platform updated Sucessfully');
			   echo json_encode($data);
			}				            
		}else{ 
			$data = array('message'=>'No Files Error.....!');
			echo json_encode($data);
		}
	}
	
	function getPlatformsById($id){
		$getData = $this->mdl_common->allSelects('Select * from platforms_list WHERE id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function getPlatformsImageById($id){
		$getData = $this->mdl_common->allSelects('Select * from new_platform WHERE id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function updatePlatforms(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'platforms_name'=>$_POST['platforms_name'],
			'platforms_url'=>$_POST['platforms_url'],
		);
		$this->db->update('platforms_list',$updateArr, array('id'=>$_POST['id']));
	}

	function deletePlatforms($id){
		return $this->db->delete('platforms_list',array('id'=>$id));
	}
	
	function getLeadsCommentById($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*,c.user_name FROM new_leads as a LEFT JOIN user_master as c on c.user_id=a.user_id WHERE a.id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}

	function updateLeadsStatus(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			
			'leads_status'=>$_POST['status'],
			'status_lead'=>'Approve'
		);
		$insertArr = array(
							'leads_id'=>$_POST['id'],
							'comment'=>$_POST['status'],
							);
		$this->db->insert('leads_status_history',$insertArr);
		
		if(!$this->db->update('new_leads',$updateArr, array('id'=>$_POST['id']))){
			$data = array('message'=>'Leads status Not updated! Error..');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Lead status updated succesfully.');
			echo json_encode($data);
		}
	}

	function getDepositImageById($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*,c.user_name,c.package, d.user_name as reseller_name FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id  WHERE deposit_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}


	function getTotal(){
		header('Content-Type: application/json');

		$this->db->select_sum('total_balance');
		$query = $this->db->get('earning_info'); 
		$data = $query->result_array();
		echo json_encode($data);
		
		
	}
	
	function getPendingTotal(){
		header('Content-Type: application/json');

		$this->db->select_sum('cashout_ammount');
		$this->db->where('cashout_status', 'pending'); 
		$query = $this->db->get('cashout_info'); 
		$data = $query->result_array();
		echo json_encode($data);
	}
 
	function getApproveTotal(){
		header('Content-Type: application/json');

		$this->db->select_sum('cashout_ammount');
		$this->db->where('cashout_status', 'approve'); 
		$query = $this->db->get('cashout_info'); 
		$data = $query->result_array();
		echo json_encode($data);		
	}
	
	
	function productOrderSummary(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id  LEFT JOIN store_user_info as e on e.id=b.purchase_user_id ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function newProductOrderSummary(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		//a.delivery_status = "Processing"  where user_id = '.$_POST['parent']
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id LEFT JOIN store_user_info as e on e.id=b.purchase_user_id  where a.delivery_status = "Processing"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			//echo json_encode($arr);
		}
	}


	function productOrderSummaryView($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id WHERE a.purchase_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	
	function editReferrals($id){
		$getData = $this->mdl_common->allSelects('Select * from user_master WHERE user_id='.$id.' and user_type ="user"');
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function updateReferrals(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
			$first_name = $_POST['first_name'];
		}else{
			$first_name = "";
		}
		if(isset($_POST['middle_name'])&&!empty($_POST['middle_name'])){
			$middle_name = $_POST['middle_name'];
		}else{
			$middle_name = "";
		}
		if(isset($_POST['last_name'])&&!empty($_POST['last_name'])){
			$last_name = $_POST['last_name'];
		}else{
			$last_name = "";
		}
		if(isset($_POST['user_name'])&&!empty($_POST['user_name'])){
			$user_name = $_POST['user_name'];
		}else{
			$user_name = "";
		}
		if(isset($_POST['user_email'])&&!empty($_POST['user_email'])){
			$user_email = $_POST['user_email'];
		}else{
			$user_email = "";
		}
		if(isset($_POST['dob'])&&!empty($_POST['dob'])){
			$dob = $_POST['dob'];
		}else{
			$dob = "";
		}
		if(isset($_POST['address1'])&&!empty($_POST['address1'])){
			$address1 = $_POST['address1'];
		}else{
			$address1 = "";
		}
		if(isset($_POST['address2'])&&!empty($_POST['address2'])){
			$address2 = $_POST['address2'];
		}else{
			$address2 = "";
		}
		if(isset($_POST['city'])&&!empty($_POST['city'])){
			$city = $_POST['city'];
		}else{
			$city = "";
		}
		if(isset($_POST['state'])&&!empty($_POST['state'])){
			$state = $_POST['state'];
		}else{
			$state = "";
		}
		if(isset($_POST['zip'])&&!empty($_POST['zip'])){
			$zip = $_POST['zip'];
		}else{
			$zip = "";
		}
		if(isset($_POST['contact_no'])&&!empty($_POST['contact_no'])){
			$contact_no = $_POST['contact_no'];
		}else{
			$contact_no = "";
		}
		if(isset($_POST['country'])&& !empty($_POST['country'])){
			$country = $_POST['country'];
		}else{
			$country = "";
		}

		if(isset($_POST['user_id'])&&!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];	
				$updateArr = array(
					'first_name'=>$first_name,
					'middle_name'=>$middle_name,
					'last_name'=>$last_name,
					'user_name'=>$user_name,
					'user_email'=>$user_email,
					'dob'=>$dob,
					'address1'=>$address1,
					'address2'=>$address2,
					'city'=>$city,
					'state'=>$state,
					'zip'=>$zip,
					'contact_no'=>$contact_no,
					'country'=>$country
				);
				$this->db->update('user_master',$updateArr, array('user_id'=>$_POST['user_id']));

				$report['error'] = $this->db->_error_number();
    			$report['message'] = $this->db->_error_message();
    			if (!$report['error']) {
				 	 $data = array('message'=>'Report Updated succesfully!');
					echo json_encode($data);
				} else {
				 
					$data = array('message'=>'This User Report  allready exists! Please Enter unique Value ! Email : '.$user_email.' & User Name : '.$user_name);
					echo json_encode($data);
				}
		}else{
			$data = array('message'=>'Report not updated Successfully!');
			echo json_encode($data);
		}
	}

	function deleteReferrals($id){
		return $this->db->delete('user_master',array('user_id'=>$id));
	}
	
	function directorCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 7) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
			//Earning Details in one table	
			$earning_details_by_user = array(
					'user_id'=>$cur_user_id,
					'ref_id'=>$last_id,
					'description'=>'Director Coded Bonus  amount',
					'amount'=>$codedBonus,
					//'message'=>"",
					//'e_d_b_u_date'=>$value['created_at'],
				);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);
			//end
		}else{
			$parentID = $this->session->userdata('sponsor_id');
			$parentLevel = $this->mdl_common->countUserLevel('earning_info',$parentID);
			if(!empty($level) && $level < 7 && $package == 5 && !empty($parentLevel) && $parentLevel >= 7){					
				$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$parentLevel);
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$parentID);
					
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$totalBalance= $total['total_balance'] + $codedBonus;
						$updattotalarr = array(
							'total_balance'=>$totalBalance,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
					}
				}else{
					$totalBalance = $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
				}
				$insertCodedBounsArr = array(
										'parent_id'=>$parentID,
										'user_id'=>$cur_user_id,
										'coded_bonus'=>$codedBonus,
									);
				$this->db->insert('coded_bonus_info',$insertCodedBounsArr);

				//Earning Details in one table	
				$earning_details_by_user = array(
						'user_id'=>$parentID,
						'ref_id'=>$cur_user_id,
						'description'=>'Director Coded Bonus amount',
						'amount'=>$codedBonus,
						//'message'=>"",
						//'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end
			}				
		}
	}

	function regionalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 8) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function nationalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 9) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function internationalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 10) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function vpCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 11) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function pCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 12) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}
	
	function crownAmbassadorCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 13) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}
	 
	function codedMaching($package){
		$cur_user_id = $this->session->userdata('user_id');
		$parentID = $this->session->userdata('sponsor_id');

		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		$parentLevel = $this->mdl_common->countUserLevel('earning_info',$parentID);
		if(!empty($level) && $level >= 7 && $package == 5 && !empty($parentLevel) && $parentLevel > $level){
				$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$parentLevel)*2/100;
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$parentID);
					
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$totalBalance= $total['total_balance'] + $codedBonus;
						$updattotalarr = array(
							'total_balance'=>$totalBalance,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
					}
				}
				$insertCodedBounsArr = array(
										'parent_id'=>$parentID,
										'user_id'=>$cur_user_id,
										'coded_bonus'=>$codedBonus,
									);
				$this->db->insert('coded_matching_info',$insertCodedBounsArr);
		}
	}
	
	function userChildBinaryDetails(){
		$user = $_POST['user_name'];
		if(isset($user) && !empty($user) && $user != "Add User"){
			$userId = $this->mdl_common->getUserId($user);

			$lftChild = $this->mdl_common->leftChild($userId);
			$rghtChild = $this->mdl_common->rightChild($userId);
			
			$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
			$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
			$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
			$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary - $totalLeftDeductBinary;

			$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
			$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
			$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
			$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary - $totalRightDeductBinary;
				
			echo 'Name : '.$user.',<br/> Bottom : ' .$rightUserTotal.' ,<br/> Top : '.$leftUserTotal;			
		}else{
			echo "Add New User";
		}
	}
	
	function unilevelQVDetails(){
		$user = $_POST['user_name'];
		if(isset($user) && !empty($user) && $user != null){
			$userId = $this->mdl_common->getUserId($user);
			$totalMemberSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id='.$userId));
			if(isset($userId) && !empty($userId)){
				$sponsorTotalQV = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$userId);
				echo 'Name : '.$user.', Total QV : '.$sponsorTotalQV.', Referrals: '.$totalMemberSponsored;			
			}				
		}else{
			echo "Empry User Data!";
		}
	}
	
	function sendMail($user_id=null,$password=null){
		$this->mdl_common->sendSponserToSponserMailForNewMember($user_id, $user_id, 1);
		
		$to_email ="dcruz@aleconinc.com";
		$subject	=	'New User Registraion';
		$mail_content = $this->mdl_common->mailContentForNewReg($user_id);
		$mail_body	=	$this->adminMailBody($mail_content);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <info@xonnova.com>' . "\r\n";
		//$headers .= 'Cc: info@xonnova.com' . "\r\n";
		mail($to_email,$subject,$mail_content,$headers);
		//sendMail($to_email,$subject,$mail_body);
		//sendLocalMail($to_email,$subject,$mail_body);
	}
	
	public function send_user_email($user_name=null,$password=null,$user_email) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'Xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Xonnova network Welcome mail');
        $html = $this->mdl_common->userMailBody($user_name,$password);
        $this->email->message($html);

        $this->email->send();
    }
	
	function adminMailBody($mail_content){
		//$userData = $this->mdl_common->allSelects('SELECT a.*,b.* from user_master as a RIGHT JOIN package_info as b on b.package_id=a.package WHERE user_id='.$user_id);		
		$mail_body = "";
		$mail_body .= '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New User Request</title>
		</head>		
		<body>
			<div style="width:100%;" align="center"><span><img src="http://luxoprinting.com/xonnova/assets/img/logo.png" alt="Image Not Found"/></span></div><br/>
			<h4>New User Signup Details <h4> <br/>';
			 $mail_body .= $mail_content;

		    $mail_body .= 'Thanks,<br />				
						</body>
						</html>		
						';
		return $mail_body;		
	}
}