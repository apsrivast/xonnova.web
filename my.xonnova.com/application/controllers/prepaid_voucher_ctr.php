<?php
/**
* 
*/
class Prepaid_voucher_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function getUserAllVoucherList(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$list = $this->mdl_common->allSelects('SELECT sim_no From activate_platform_voucher WHERE  user_id = '.$userID);
		if(isset($list) && !empty($list)){
			$list2 = $this->mdl_common->allSelects('SELECT sim_no From activate_platform_voucher 
													WHERE  sim_no 
													NOT IN (
												    SELECT ol_voucher 
												    FROM activate_platform) 
													AND	sim_no 
													NOT IN (
												    SELECT voucher_no 
												    FROM prepaid_voucher) 
													AND user_id = '.$userID);
			if(isset($list2) && !empty($list2)){
				foreach ($list2 as $key2 => $value2) {
					$value2['status'] = 'Assigned';
					$arr[] = $value2;
				}
			}

			$list3 = $this->mdl_common->allSelects('SELECT voucher_no as sim_no From prepaid_voucher 
													WHERE  voucher_no 
													NOT IN (
												    SELECT ol_voucher 
												    FROM activate_platform) 
													AND user_id = '.$userID);
			if(isset($list3) && !empty($list3)){
				foreach ($list3 as $key3 => $value3) {
					$value3['status'] = 'Prepaid Activated';
					$arr[] = $value3;
				}
			}

			$list4 = $this->mdl_common->allSelects('SELECT ol_voucher as sim_no From activate_platform 
													WHERE   ol_voucher != "" 
													AND user_id = '.$userID);
			if(isset($list4) && !empty($list4)){
				foreach ($list4 as $key4 => $value4) {
					$value4['status'] = 'Activated';
					$arr[] = $value4;
				}
			}
			
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	

	function prepaidVoucherSim(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$ammount = 0;

		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$userName = $this->session->userdata('user_name');
		$userPhone = $this->session->userdata('contact_no');
		$userEmail = $this->session->userdata('user_email'); 

		if(isset($_POST['first_name'])&&!empty($_POST['first_name'])){
			$firstName = $_POST['first_name'];
		}else{
			$data = array("message"=>"First Name Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['middle_name']) && !empty($_POST['middle_name'])){
			$middleName = $_POST['middle_name'];
		}else{
			$middleName = '';
		}

		if(isset($_POST['last_name'])&&!empty($_POST['last_name'])){
			$lastName = $_POST['last_name'];
		}else{
			$data = array("message"=>"Last Name Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['address1'])&&!empty($_POST['address1'])){
			$address1 = $_POST['address1'];
		}else{
			$data = array("message"=>"Address Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['address2']) && !empty($_POST['address2'])){
			$address2 = $_POST['address2'];
		}else{
			$address2 = '';
		}

		if(isset($_POST['city'])&&!empty($_POST['city'])){
			$city = $_POST['city'];
		}else{
			$data = array("message"=>"City Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['state'])&&!empty($_POST['state'])){
			$state = $_POST['state'];
		}else{
			$data = array("message"=>"State Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['zip'])&&!empty($_POST['zip'])){
			$zip = $_POST['zip'];
		}else{
			$data = array("message"=>"Zip # Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['attphone'])&&!empty($_POST['attphone'])){
			$phone = $_POST['attphone'];
		}else{
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
			$data = array("message"=>"Email Required !"); 
			echo json_encode($data);
			return false ;
		}


		if(isset($_POST['dobATTSim'])&&!empty($_POST['dobATTSim'])){
			$dob = $_POST['dobATTSim'];
		}else{
			$data = array("message"=>"Date Of Birth Required !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('user_id',$this->session->userdata('user_id'));
		$this->db->where('sim_no',$_POST['sim_no']);
		$rs2	=	$this->db->get('prepaid_voucher');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 == 0){
			$data = array("message"=>"This SIM # is not assigned to you ! !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('sim',$_POST['sim_no']);
		$rs2	=	$this->db->get('activate_platform');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' An Activation request for this SIM # has already been sent by you.');
			echo json_encode($data);	
			return;
		}


		if(isset($_POST['area_code'])&&!empty($_POST['area_code'])){
			$areaCode = $_POST['area_code'];
		}else{
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


			$insertarr = array(
				'user_id'=>$this->session->userdata('user_id'),
				'user_name'=>$userName,
				'user_phone'=>$userPhone,
				'user_email'=>$userEmail,
				
				'q2'=>'SmartMark',
				'q3'=>100,
				'q4'=>$ammount,
				'ol_voucher'=>$_POST['voucher_no'],
				'sim'=>$_POST['sim_no'],
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

				'race'=>$_POST['race'],
				'gender'=>$_POST['gender'],
				'pref_lang'=>$_POST['pref_lang'],
				'home_owner'=>$_POST['home_owner'],
				'bus_owner'=>$_POST['bus_owner'],
				'industry'=>$_POST['industry'],
				'shipping_status'=>'shipped',

							'phone_brand'=>$_POST['phone_brand'],
							'phone_type'=>$_POST['phone_type'],
							'phone_imei'=>$_POST['phone_imei'],
							'annual_income'=>$_POST['annual_income'],
							'health_insurance'=>$_POST['health_insurance'],
							'dental_insurance'=>$_POST['dental_insurance'],
							'life_insurance'=>$_POST['life_insurance'],
			);
			
			if(!$this->db->insert('activate_platform',$insertarr)){
				$data = array('message'=>$this->db->_error_message());
				echo json_encode($data);
			}else{
				$data = array("messagee"=>"Your Registration Completed succesfully  !  ");
				echo json_encode($data);
			}
	}

	

	function getUserVoucherList(){
		$userID = $this->session->userdata('user_id');
		$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher WHERE sim_no NOT IN (
	    SELECT sim 
	    FROM activate_platform) AND status = "Approve" AND user_id = '.$userID);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateSim(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['sim_no']) && !empty($_POST['sim_no'])){
		}else{
			$data = array("message"=>"SIM # field is required !");
			echo json_encode($data);
			return  ;
		}
		$Date = date('Y-m-d H:i:s');
		$insertArr = array(
			'sim_no'=>$_POST['sim_no'], 	
			'status'=>'Approve',
			'update_date'=>$Date,
		);

		if(!$this->db->update('prepaid_voucher',$insertArr,array('prepaid_id'=>$_POST['prepaid_id']))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('messagee' => 'SIM # Added successfully ! ');
			echo json_encode($data );
		}
	}



	function getPrepaidVoucher($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * From prepaid_voucher  where 	prepaid_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getPrepaidVoucherList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher   WHERE status = "Pending" AND prepaid_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher WHERE status = "Pending"');
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

	
	function getVoucherList(){
		$userId = $this->session->userdata('user_id');
		$list = $this->mdl_common->allSelects('SELECT sim_no as voucher_id, sim_no as voucher_no From activate_platform_voucher  WHERE sim_no NOT IN (
	    SELECT ol_voucher 
	    FROM activate_platform) AND sim_no NOT IN (
	    SELECT voucher_no 
	    FROM prepaid_voucher) AND user_id='.$userId);

		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			$arr[] = array('voucher_id'=>'','voucher_no'=>'no voucher');
			echo json_encode($arr);
		}
	}

	function prepaidVoucherActivation(){

		$_POST = json_decode(file_get_contents("php://input"),true);

		$userID = $this->session->userdata('user_id');
		if($userID == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		$productID = 108;
		$qty = count($_POST['voucher']);

		if($qty > 5){
			$data = array('message'=>'Only 5 Voucher ');
			echo json_encode($data);	
			return;
		}
		if($_POST['voucher'][0] == null){
			$data = array('message'=>'select voucher ');
			echo json_encode($data);	
			return;
		}

		

		$shippingMethod = $_POST['shipping_method'];
		if($shippingMethod == null){
			$data = array('message'=>' Shipping method required.');
			echo json_encode($data);	
			return;
		}
		if($shippingMethod == 'FIRST CLASS'){
				$shippingCost = 3.97 - 1 + $qty;
		}else{
				$shippingCost = 9.97 ;
		}

		$total_withoutshipp = $qty * 15 ;
		
		$total_amt = $qty * 15 + $shippingCost;

		$this->load->library('authorize_net');

		$auth_net = array(
			'x_card_num'			=> trim($_POST['card_no']), // Visa
			'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
			'x_card_code'			=> trim($_POST['cvv_no']),
			'x_description'			=> 'xonnova Network transaction',
			'x_amount'				=> $total_amt,
			// 'x_first_name'			=> $this->session->userdata('first_name'),
			// 'x_last_name'			=> $this->session->userdata('last_name'),
			// 'x_address'				=> $this->session->userdata('address1').''.$this->session->userdata('address2'),
			// 'x_city'				=> $this->session->userdata('city'),
			// 'x_state'				=> $this->session->userdata('state'),
			// 'x_zip'					=> $this->session->userdata('zip'),
			// 'x_country'				=> 'USA',
			// 'x_phone'				=> trim($this->session->userdata('contact_no')),
			'x_email'				=> $this->session->userdata('user_email'),
			'x_customer_ip'			=> $this->input->ip_address(),
		);

		$this->authorize_net->setData($auth_net);
		if($this->authorize_net->authorizeAndCapture()){					
			$insertArr = array(
					'p_id'=>$productID,
					'user_id'=>$userID,
					//'purchase_user_id'=>$userID,
					'user_name'=>$this->session->userdata('user_name'),
					'p_qty'=>$qty,
					'subtotal'=>$total_amt,
					'shipping_method'=>$shippingMethod,
					'card_no'=>$_POST['card_no'],
					'card_expiry'=>$_POST['expiry_year'].'/'.$_POST['expiry_month'],
					'card_ccv'=>$_POST['cvv_no'],
					'transaction_id'=>$this->authorize_net->getTransactionId(),

				);
			$this->db->insert('product_purchase_info',$insertArr);
			$last_id =  $this->db->insert_id();

			$insertUser = array(
					'order_id'=>$last_id,
					'p_id'=>$productID,
					'user_id'=>$userID,
					//'purchase_user_id'=>$userID,
					'address1'=>$this->session->userdata('address1'),
					'address2'=>$this->session->userdata('address2'),
					'country'=>'usa',
					'city'=>$this->session->userdata('city'),
					'zip'=>$this->session->userdata('zip'),
					'state'=>$this->session->userdata('state'),
					'contact_no'=>$this->session->userdata('contact_no'),
					'user_name'=>$this->session->userdata('user_name'),
					'first_name'=>$this->session->userdata('first_name'),
					'last_name'=>$this->session->userdata('last_name'),
					'user_email'=>$this->session->userdata('user_email'),
				);
			$this->db->insert('user_purchase_info',$insertUser);
			foreach ($_POST['voucher'] as $value) {
				$Arr = array(
					'user_id'=>$userID,
					'user_name'=>$this->session->userdata('user_name'),
					'order_id'=>$last_id,
					'voucher_no'=>$value,
				);
				 $this->db->insert('prepaid_voucher',$Arr);
			}
			$insertUserShipping = array(
				'user_id'=>$userID,
				'user_name'=>$this->session->userdata('user_name'),
				'ship_address'=>$this->session->userdata('address1'),
				'country'=>'usa',
				'city'=>$this->session->userdata('city'),
				'zip'=>$this->session->userdata('zip'),
				'type'=>'Order',
				'product'=>$productID,
				'quantity'=>$qty,
				'shipping_method'=>$shippingMethod,
			);
			$this->db->insert('shipping_management_table',$insertUserShipping);

			$data = array('messagee'=>'Your activation has been submitted successfully. You will receive a notification email when your order is shipped. Your Transaction Id -- '.$this->authorize_net->getTransactionId());
			echo json_encode($data);	
			$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	

			return;
		}else{
			$data = array('message'=>' Transaction  Error -- '.$this->authorize_net->getError());
			echo json_encode($data);	
			return;
		}
	}

	function send_user_email_on_purchase($order_id=null, $user_name=null, $user_email=null, $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('xonnova network Purchase Mail');
        
        $mail_body	=	$this->mailBody($order_id, $user_name, $product_id, $qty, $total, $shippingCost, $total_amt);
        $this->email->message($mail_body);

        $this->email->send();
    }

   	function mailBody($order_id=null, $user_name=null,  $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null){
		$productName = $this->mdl_common->getProductName($product_id);		
		$mail_body = '
						<div>
						<h3>Order confirmation</h3>
						<h1 style="font-size:70px;">Thank you</h1>
						<p>Bellow are important detail about your order. Question? We are always here to help you. Simply contact our chat support at any time from your backoffice.</p>

						<p>Order number: "'.$order_id.'" </p>
						<p>Username: "'.$user_name.'"</p>

						<h4>Your recent order</h4>

						<table width="100%" cellspacing="0" cellpadding="10px"  height="100px" style="border:2px solid rgb(0,0,0);">
							<tbody>
								<tr style="background-color:#c0c0c0;" >
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										Product name
									</td>
									<td  align="center" style="border:0 1px 0 1px solid rgb(0,0,0);">
										Quantity
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" width="10%">
										
									</td>

									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										Price
									</td>
									
								</tr>
								<tr>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										'.$productName.'
									</td>
									<td  align="center" style="border:1px solid rgb(0,0,0);">
										'.$qty.'
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" >
										
									</td>

									<td  align="center" style="border:1px solid rgb(0,0,0);">
										$'.$total.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Subtotal:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$'.$total.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Shipping & Handling:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$'.$shippingCost.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Tex:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$0.00
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5; ">
									<td  align="right" colspan="2"  style="border-top:1px solid rgb(0,0,0);">
										Order Total:
									</td>
									<td  align="center" style="border-top:1px solid rgb(0,0,0);">
										
									</td>
									
									<td  align="center" style="border-top:1px solid rgb(0,0,0);">
										<h2 style="color:#7db738; ">$'.$total_amt.'</h2>
									</td>
									
								</tr>
							</tbody>
						</table>
					</div>

					';
		
		return $mail_body;		
	}
}