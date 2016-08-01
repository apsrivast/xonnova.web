<?php
/**
* 
*/
class Changes_card extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}


	function changesCardSubscriptionByAdmin(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		// if($_POST['user_name']){
		// 	$data = array('message'=>'Your session is time out please login again .');
		// 	echo json_encode($data);	
		// 	return;
		// }

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"user name field is required !");
			echo json_encode($data);
			return  ;
		}

		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));

		//$userId = $this->mdl_common->getUserId($_POST['user_name']);
		//$userId =$this->session->userdata('user_id');
		$userId = $this->mdl_common->sponserID($_POST['user_name']);
		$UserName = $_POST['user_name'];//$this->mdl_common->getUserNameById($userId);
		
			$subscription_id = $this->mdl_common->getReactivateSubscriptionId($userId);
			
			if(!empty($subscription_id)){
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'xonnova Network  transaction',
					'x_amount'				=> 29,
					'x_first_name'			=>  $UserName,
					'x_last_name'			=>  $UserName,
					'x_customer_ip'			=> $this->input->ip_address(),
				);

				$this->authorize_net->setData($auth_net);

				//ARB payment method
				$this->load->library('authorize_arb');	
				// Start with an update object
				$this->authorize_arb->startData('create');
				
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				// The subscription ID that we're editing
				//$this->authorize_arb->addData('subscriptionId', $subscription_id);
				$amount = 29.00;
				$subscription_data = array(			
					'name' => $_POST['name_on_card'].' Change Card Details, xonnova',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => $recurringStartDate,
						'totalOccurrences' => 9999,
						'trialOccurrences' => 0,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => trim($_POST['card_no']),
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => trim($_POST['cvv_no']),
							),
						),			
					'billTo' => array(
						'firstName' => $UserName,
						'lastName' => $UserName,				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);

				if(!$this->authorize_net->authorizeAndCapture()){
					$data = array('message'=>' Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);	
					return;
				}
				$updatearr = array(
					'updated_at'=>date('Y-m-d'),
					'transaction_id'=>$this->authorize_net->getTransactionId(),
					'name_on_card'=>$_POST['name_on_card'],
					'card_no'=>$_POST['card_no'],
					'cvv_no'=>$_POST['cvv_no'],					
					'expiry_date'=>$_POST['expiry_year'].'-'.$_POST['expiry_month'],
				);
				$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));			
				
				$list = $this->mdl_common->allSelects('SELECT * From payment_info where user_id= '.$userId);
				if(!empty($list)){
					foreach ($list as $key => $value) {
							$insertReactivationArr = array(
								'user_id'=>$userId,
								'old_subscription_id'=>$subscription_id,
								'old_transaction_id'=>$value['transaction_id'],								
								'name_on_card'=>$value['name_on_card'],
								'card_no'=>$value['card_no'],
								'cvv_no'=>$value['cvv_no'],
								'expiry_date'=>$value['expiry_date'],
								're_sub_amount'=>$amount,
								'ref_id'=>$value['ref_id'],
							);
							$this->db->insert('change_card_info',$insertReactivationArr);
					}					
				}
				
				if( $this->authorize_arb->send() ){
					$updateReactivationArr = array(
						'subscription_id'=>$this->authorize_arb->getId(),
					);
					$this->db->update('change_card_info',$updateReactivationArr,array('user_id'=>$userId));
					
					$updatearr = array(
						'transaction_arb_id'=>$this->authorize_arb->getId(),
						'ref_id'=>$refId,
					);				
					$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));					
				
					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}
			}else{
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'xonnova Network  transaction',
					'x_amount'				=> 29,
					'x_first_name'			=>  $UserName,
					'x_last_name'			=>  $UserName,
					'x_customer_ip'			=> $this->input->ip_address(),
				);

				$this->authorize_net->setData($auth_net);

				//ARB payment method
				$this->load->library('authorize_arb');	
				// Start with an update object
				$this->authorize_arb->startData('create');
				
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				// The subscription ID that we're editing
				//$this->authorize_arb->addData('subscriptionId', $subscription_id);
				$amount = 29.00;
				$subscription_data = array(			
					'name' => $_POST['name_on_card'].' Change Card Details, xonnova',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => $recurringStartDate,
						'totalOccurrences' => 9999,
						'trialOccurrences' => 0,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => trim($_POST['card_no']),
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => trim($_POST['cvv_no']),
							),
						),			
					'billTo' => array(
						'firstName' => $UserName,
						'lastName' => $UserName,				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);

				if(!$this->authorize_net->authorizeAndCapture()){
					$data = array('message'=>' Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);	
					return;
				}
				$updatearr = array(
					'updated_at'=>date('Y-m-d'),
					'transaction_id'=>$this->authorize_net->getTransactionId(),
					'name_on_card'=>$_POST['name_on_card'],
					'card_no'=>$_POST['card_no'],
					'cvv_no'=>$_POST['cvv_no'],					
					'expiry_date'=>$_POST['expiry_year'].'-'.$_POST['expiry_month'],
				);
				$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));			
				
				$list = $this->mdl_common->allSelects('SELECT * From payment_info where user_id= '.$userId);
				if(!empty($list)){
					foreach ($list as $key => $value) {
							$insertReactivationArr = array(
								'user_id'=>$userId,
								'old_subscription_id'=>$subscription_id,
								'old_transaction_id'=>$value['transaction_id'],								
								'name_on_card'=>$value['name_on_card'],
								'card_no'=>$value['card_no'],
								'cvv_no'=>$value['cvv_no'],
								'expiry_date'=>$value['expiry_date'],
								're_sub_amount'=>$amount,
								'ref_id'=>$value['ref_id'],
							);
							$this->db->insert('change_card_info',$insertReactivationArr);
					}					
				}
				
				if( $this->authorize_arb->send() ){
					$updateReactivationArr = array(
						'subscription_id'=>$this->authorize_arb->getId(),
					);
					$this->db->update('change_card_info',$updateReactivationArr,array('user_id'=>$userId));
					
					$updatearr = array(
						'transaction_arb_id'=>$this->authorize_arb->getId(),
						'ref_id'=>$refId,
					);				
					$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));					
				
					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}
			}
	}




	function suscriptionChangeList(){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name , d.account From change_card_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  LEFT JOIN arb_mapping_info as d  on a.old_subscription_id = d.arb_id WHERE a.change_status = "Pending"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}


	function updateChangeCardList(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'change_status'=>'Approve',
		);
		
		if(!$this->db->update('change_card_info',$updateArr, array('change_card_id'=>$_POST['change_card_id']))){
			$data = array('message'=>'not Approved');
			echo json_encode($data);
		}else{
			$data = array('message'=>' Approved');
			echo json_encode($data);
		}
	}

	function suscriptionDeactivateList(){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, c.transaction_arb_id , d.account From deactivate_subscription as a LEFT JOIN user_master as b on a.user_id = b.user_id LEFT JOIN payment_info as c  on a.user_id = c.user_id LEFT JOIN arb_mapping_info as d  on c.transaction_arb_id = d.arb_id WHERE a.deactivate_status = "Pending"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}


	function updatesuScriptionDeactivateList(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'deactivate_status'=>'Approve',
		);
		
		if(!$this->db->update('deactivate_subscription',$updateArr, array('deactivate_id'=>$_POST['deactivate_id']))){
			$data = array('message'=>'not Approved');
			echo json_encode($data);
		}else{

			$this->db->update('payment_info',array('sub_status'=>'inactive'),array('user_id'=>$_POST['user_id']));
			$this->db->update('user_master',array('user_status'=>'inactive','login_status'=>'inactive'),array('user_id'=>$_POST['user_id']));
			$data = array('message'=>' Approved');
			echo json_encode($data);
		}
	}



	function deactivateSubscription(){ 
	
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		$subscription_id = $this->mdl_common->getReactivateSubscriptionId($this->session->userdata('user_id'));
			
		if(!empty($subscription_id)){
		$arr = array(
				'user_id'=>$this->session->userdata('user_id'),
			);
		$this->db->insert('deactivate_subscription',$arr);

		// $list = $this->mdl_common->allSelects('SELECT * From payment_info where user_id= '.$this->session->userdata('user_id'));
		// foreach ($list as $key => $value) {
		// 		$insertReactivationArr = array(
		// 			'user_id'=>$this->session->userdata('user_id'),
					
		// 			'old_subscription_id'=>$value['transaction_arb_id'],
		// 			'old_transaction_id'=>$value['transaction_id'],
					
		// 			'name_on_card'=>$value['name_on_card'],
		// 			'card_no'=>$value['card_no'],
				
		// 			'ref_id'=>$value['ref_id'],
					
		// 		);
		// 		$this->db->insert('change_card_info',$insertReactivationArr);
		// }


		$data =  array('message'=>'Your Deactivation request has been submitted and is in progress.');
		echo json_encode($data);
		}else{
			$data = array('message'=>'This is an Invalid user!');
			echo json_encode($data);
		}
	}


	function changesCardSubscription(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));

		//$userId = $this->mdl_common->getUserId($_POST['user_name']);
		$userId =$this->session->userdata('user_id');
		$UserName = $this->mdl_common->getUserNameById($userId);
		
			$subscription_id = $this->mdl_common->getReactivateSubscriptionId($userId);
			
			if(!empty($subscription_id)){
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'xonnova Network  transaction',
					'x_amount'				=> 29,
					'x_first_name'			=>  $UserName,
					'x_last_name'			=>  $UserName,
					'x_customer_ip'			=> $this->input->ip_address(),
				);

				$this->authorize_net->setData($auth_net);

				//ARB payment method
				$this->load->library('authorize_arb');	
				// Start with an update object
				$this->authorize_arb->startData('create');
				
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				// The subscription ID that we're editing
				//$this->authorize_arb->addData('subscriptionId', $subscription_id);
				$amount = 29.00;
				$subscription_data = array(			
					'name' => $_POST['name_on_card'].' Change Card Details, xonnova',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => $recurringStartDate,
						'totalOccurrences' => 9999,
						'trialOccurrences' => 0,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => trim($_POST['card_no']),
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => trim($_POST['cvv_no']),
							),
						),			
					'billTo' => array(
						'firstName' => $UserName,
						'lastName' => $UserName,				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);

				if(!$this->authorize_net->authorizeAndCapture()){
					$data = array('message'=>' Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);	
					return;
				}
				$updatearr = array(
							'updated_at'=>date('Y-m-d'),
							'transaction_id'=>$this->authorize_net->getTransactionId(),
							'name_on_card'=>$_POST['name_on_card'],
							'card_no'=>$_POST['card_no'],
							'cvv_no'=>$_POST['cvv_no'],							
							'expiry_date'=>$_POST['expiry_year'].'-'.$_POST['expiry_month'],
						);
				
				$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));
				
				$list = $this->mdl_common->allSelects('SELECT * From payment_info where user_id= '.$userId);
				if(!empty($list)){
					foreach ($list as $key => $value) {
							$insertReactivationArr = array(
								'user_id'=>$userId,
								'old_subscription_id'=>$subscription_id,
								'old_transaction_id'=>$value['transaction_id'],								
								'name_on_card'=>$value['name_on_card'],
								'card_no'=>$value['card_no'],
								'cvv_no'=>$value['cvv_no'],
								'expiry_date'=>$value['expiry_date'],
								're_sub_amount'=>$amount,
								'ref_id'=>$value['ref_id'],
							);
							$this->db->insert('change_card_info',$insertReactivationArr);
					}					
				}
					
				if($this->authorize_arb->send()){					
					$updateReactivationArr = array(
						'subscription_id'=>$this->authorize_arb->getId(),
					);
					$this->db->update('change_card_info',$updateReactivationArr,array('user_id'=>$userId));	
					
					$updatearr = array(
						'updated_at'=>date('Y-m-d'),
						'transaction_arb_id'=>$this->authorize_arb->getId(),
						'ref_id'=>$refId,
					);				
					$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));
					
				
					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}
			}else{
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'xonnova Network  transaction',
					'x_amount'				=> 29,
					'x_first_name'			=>  $UserName,
					'x_last_name'			=>  $UserName,
					'x_customer_ip'			=> $this->input->ip_address(),
				);

				$this->authorize_net->setData($auth_net);

				//ARB payment method
				$this->load->library('authorize_arb');	
				// Start with an update object
				$this->authorize_arb->startData('create');
				
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				// The subscription ID that we're editing
				//$this->authorize_arb->addData('subscriptionId', $subscription_id);
				$amount = 29.00;
				$subscription_data = array(			
					'name' => $_POST['name_on_card'].' Change Card Details, xonnova',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => $recurringStartDate,
						'totalOccurrences' => 9999,
						'trialOccurrences' => 0,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => trim($_POST['card_no']),
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => trim($_POST['cvv_no']),
							),
						),			
					'billTo' => array(
						'firstName' => $UserName,
						'lastName' => $UserName,				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);

				if(!$this->authorize_net->authorizeAndCapture()){
					$data = array('message'=>' Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);	
					return;
				}
				$updatearr = array(
							'updated_at'=>date('Y-m-d'),
							'transaction_id'=>$this->authorize_net->getTransactionId(),
							'name_on_card'=>$_POST['name_on_card'],
							'card_no'=>$_POST['card_no'],
							'cvv_no'=>$_POST['cvv_no'],							
							'expiry_date'=>$_POST['expiry_year'].'-'.$_POST['expiry_month'],
						);
				
				$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));
				
				$list = $this->mdl_common->allSelects('SELECT * From payment_info where user_id= '.$userId);
				if(!empty($list)){
					foreach ($list as $key => $value) {
							$insertReactivationArr = array(
								'user_id'=>$userId,
								'old_subscription_id'=>$subscription_id,
								'old_transaction_id'=>$value['transaction_id'],								
								'name_on_card'=>$value['name_on_card'],
								'card_no'=>$value['card_no'],
								'cvv_no'=>$value['cvv_no'],
								'expiry_date'=>$value['expiry_date'],
								're_sub_amount'=>$amount,
								'ref_id'=>$value['ref_id'],
							);
							$this->db->insert('change_card_info',$insertReactivationArr);
					}					
				}
					
				if($this->authorize_arb->send()){					
					$updateReactivationArr = array(
						'subscription_id'=>$this->authorize_arb->getId(),
					);
					$this->db->update('change_card_info',$updateReactivationArr,array('user_id'=>$userId));	
					
					$updatearr = array(
						'updated_at'=>date('Y-m-d'),
						'transaction_arb_id'=>$this->authorize_arb->getId(),
						'ref_id'=>$refId,
					);				
					$this->db->update('payment_info',$updatearr,array('user_id'=>$userId));
					
				
					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}
			}
	}

	
	


}