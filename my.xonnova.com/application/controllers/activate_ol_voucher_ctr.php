<?php
/**
* 
*/
class Activate_ol_voucher_ctr extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		
	}









	function activateOlVoucher(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['shipping_method'])&&!empty($_POST['shipping_method'])){
		}else{
			$data = array("message"=>"Shipping method Required !"); 
			echo json_encode($data);
			return  ;
		}

		$shippingMethod = $_POST['shipping_method'];
		if($shippingMethod == null){
			$data = array('message'=>' Shipping method required.');
			echo json_encode($data);	
			return;
		}
		if($shippingMethod == 'FIRST CLASS'){
				$shippingCost = 3.97 ;
		}else{
				$shippingCost = 9.97 ;
		}
		
		$ammount = 15 + $shippingCost;

		$productID = 98; 
		$qty = 1;
		$total_withoutshipp = 15;
	
		$total_amt = $ammount;


		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}



		
		 // $userName = $this->mdl_common->getSIMusername($this->session->userdata('user_id'));
		 // $userPhone = $this->mdl_common->getSIMuserphone($this->session->userdata('user_id'));
		 // $userEmail = $this->mdl_common->getSIMuseremail($this->session->userdata('user_id'));
		$userName = $this->session->userdata('user_name');
		$userPhone = $this->session->userdata('contact_no');
		$userEmail = $this->session->userdata('user_email'); 
			
				
		$this->load->library('authorize_net');
						

		if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
			$card_no = $_POST['card_no'];
		}else{
			$data = array("message"=>"Card # Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
			$expiryYear = $_POST['expiry_year'];
		}else{
			$data = array("message"=>"Expiry Year Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
			$expiryMonth = $_POST['expiry_month'];
		}else{
			$data = array("message"=>"Expiry Month Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
			$cvvNo = $_POST['cvv_no'];
		}else{
			$data = array("message"=>"CVV # Required !"); 
			echo json_encode($data);
			return false ;
		}

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


		// if(isset($_POST['attq3'])&&!empty($_POST['attq3'])){
		// 	$question3 = $_POST['attq3'];
		// }else{
		// 	$data = array("message"=>"Question # 2 Required !"); 
		// 	echo json_encode($data);
		// 	return false ;
		// }
		if(isset($_POST['dobATTSim'])&&!empty($_POST['dobATTSim'])){
			$dob = $_POST['dobATTSim'];
		}else{
			$data = array("message"=>"Date Of Birth Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['attpin'])&&!empty($_POST['attpin'])){
			$simNumber = $_POST['attpin'];
		}else{
			$data = array("message"=>"Voucher # Required !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('user_id',$this->session->userdata('user_id'));
		$this->db->where('sim_no',$_POST['attpin']);
		$rs2	=	$this->db->get('activate_platform_voucher');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 == 0){
			$data = array("message"=>"This Voucher # is not assigned to you ! !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('ol_voucher',$_POST['attpin']);
		$rs2	=	$this->db->get('activate_platform');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' An Activation request for this Voucher # has already been sent by you.');
			echo json_encode($data);	
			return;
		}

		$this->db->where('voucher_no',$_POST['attpin']);
		$rs2	=	$this->db->get('prepaid_voucher');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' An Activation request for this Voucher # has already been sent by you.');
			echo json_encode($data);	
			return;
		}

		// if(isset($_POST['imei'])&&!empty($_POST['imei'])){
		// }else{
		// 	$data = array("message"=>"IMEI # Required !"); 
		// 	echo json_encode($data);
		// 	return false ;
		// }

		if(isset($_POST['s_address1'])&&!empty($_POST['s_address1'])){
		}else{
			$data = array("message"=>"Shipping Address Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_address2']) && !empty($_POST['s_address2'])){
		}else{
			$_POST['s_address2'] = '';
		}

		if(isset($_POST['s_city'])&&!empty($_POST['s_city'])){
			
		}else{
			$data = array("message"=>" Shipping City Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_state'])&&!empty($_POST['s_state'])){
			
		}else{
			$data = array("message"=>"Shipping State Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_zip'])&&!empty($_POST['s_zip'])){
			
		}else{
			$data = array("message"=>"Shipping Zip # Required !"); 
			echo json_encode($data);
			return false ;
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


		$auth_net = array(
			'x_card_num'			=> trim($card_no), // Visa
			'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
			'x_card_code'			=> trim($cvvNo),
			'x_description'			=> 'Activate Platform Xonnova Network transaction',
			'x_amount'				=> $ammount,
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
				'user_name'=>$userName,
				'user_phone'=>$userPhone,
				'user_email'=>$userEmail,
				// 'q1'=>$_POST['q1'],
				'q2'=>'SmartMark',
				'q3'=>100,
				'q4'=>$ammount,
				'ol_voucher'=>$simNumber,
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

				//'imei'=>$_POST['imei'],
				's_address1'=>$_POST['s_address1'],
				's_address2'=>$_POST['s_address2'],
				's_city'=>$_POST['s_city'],
				's_state'=>$_POST['s_state'],
				's_zip'=>$_POST['s_zip'],
				's_country'=>'USA',
				'shipping_method'=>$shippingMethod,
			);
			$this->db->insert('activate_platform',$insertarr);
			$last_id =  $this->db->insert_id();
			$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'),$productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	

			$data = array("messagee"=>"Your Activation Submitted succesfully &   Transaction ID : ".$this->authorize_net->getTransactionId());
			echo json_encode($data);
		}else{
			$data = array("message"=>"Activation  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
			echo json_encode($data);
		}		
	}



	function activateOlVoucherStore(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$ammount = 13.97;
		$productID = 98; 
		$qty = 1;
		$total_withoutshipp = 10;
		$shippingCost = 3.97;
		$total_amt = $ammount;




		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		
		 // $userName = $this->mdl_common->getSIMusername($this->session->userdata('user_id'));
		 // $userPhone = $this->mdl_common->getSIMuserphone($this->session->userdata('user_id'));
		 // $userEmail = $this->mdl_common->getSIMuseremail($this->session->userdata('user_id'));
		$userName = $this->session->userdata('user_name');
		$userPhone = $this->session->userdata('contact_no');
		$userEmail = $this->session->userdata('user_email'); 
			
				
		$this->load->library('authorize_net');
						

		if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
			$card_no = $_POST['card_no'];
		}else{
			$data = array("message"=>"Card # Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
			$expiryYear = $_POST['expiry_year'];
		}else{
			$data = array("message"=>"Expiry Year Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
			$expiryMonth = $_POST['expiry_month'];
		}else{
			$data = array("message"=>"Expiry Month Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
			$cvvNo = $_POST['cvv_no'];
		}else{
			$data = array("message"=>"CVV # Required !"); 
			echo json_encode($data);
			return false ;
		}

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

		if(isset($_POST['user_emailATTSim'])&&!empty($_POST['user_emailATTSim'])){
			$email = $_POST['user_emailATTSim'];
		}else{
			$data = array("message"=>"Email Required !"); 
			echo json_encode($data);
			return false ;
		}


		// if(isset($_POST['attq3'])&&!empty($_POST['attq3'])){
		// 	$question3 = $_POST['attq3'];
		// }else{
		// 	$data = array("message"=>"Question # 2 Required !"); 
		// 	echo json_encode($data);
		// 	return false ;
		// }
		if(isset($_POST['dobATTSim'])&&!empty($_POST['dobATTSim'])){
			$dob = $_POST['dobATTSim'];
		}else{
			$data = array("message"=>"Date Of Birth Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['attpin'])&&!empty($_POST['attpin'])){
			$simNumber = $_POST['attpin'];
		}else{
			$data = array("message"=>"Voucher # Required !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('user_id',$this->session->userdata('user_id'));
		$this->db->where('sim_no',$_POST['attpin']);
		$rs2	=	$this->db->get('activate_platform_voucher');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 == 0){
			$data = array("message"=>"This Voucher # is not assigned to you ! !"); 
			echo json_encode($data);
			return false ;
		}


		$this->db->where('ol_voucher',$_POST['attpin']);
		$rs2	=	$this->db->get('activate_platform');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' An Activation request for this Voucher # has already been sent by you.');
			echo json_encode($data);	
			return;
		}

		$this->db->where('voucher_no',$_POST['attpin']);
		$rs2	=	$this->db->get('prepaid_voucher');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' An Activation request for this Voucher # has already been sent by you.');
			echo json_encode($data);	
			return;
		}

		// if(isset($_POST['imei'])&&!empty($_POST['imei'])){
		// }else{
		// 	$data = array("message"=>"IMEI # Required !"); 
		// 	echo json_encode($data);
		// 	return false ;
		// }

		if(isset($_POST['s_address1'])&&!empty($_POST['s_address1'])){
		}else{
			$data = array("message"=>"Shipping Address Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_address2']) && !empty($_POST['s_address2'])){
		}else{
			$_POST['s_address2'] = '';
		}

		if(isset($_POST['s_city'])&&!empty($_POST['s_city'])){
			
		}else{
			$data = array("message"=>" Shipping City Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_state'])&&!empty($_POST['s_state'])){
			
		}else{
			$data = array("message"=>"Shipping State Required !"); 
			echo json_encode($data);
			return false ;
		}

		if(isset($_POST['s_zip'])&&!empty($_POST['s_zip'])){
			
		}else{
			$data = array("message"=>"Shipping Zip # Required !"); 
			echo json_encode($data);
			return false ;
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


		$auth_net = array(
			'x_card_num'			=> trim($card_no), // Visa
			'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
			'x_card_code'			=> trim($cvvNo),
			'x_description'			=> 'Activate Platform Xonnova Network transaction',
			'x_amount'				=> $ammount,
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
				'q3'=>100,
				'q4'=>$ammount,
				'ol_voucher'=>$simNumber,
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

				'race'=>$_POST['race'],
				'gender'=>$_POST['gender'],
				'pref_lang'=>$_POST['pref_lang'],
				'home_owner'=>$_POST['home_owner'],
				'bus_owner'=>$_POST['bus_owner'],
				'industry'=>$_POST['industry'],


				//'imei'=>$_POST['imei'],
				's_address1'=>$_POST['s_address1'],
				's_address2'=>$_POST['s_address2'],
				's_city'=>$_POST['s_city'],
				's_state'=>$_POST['s_state'],
				's_zip'=>$_POST['s_zip'],
				's_country'=>'USA',
				//'shipping_method'=>$shippingMethod,
			);
			$this->db->insert('activate_platform',$insertarr);
			$last_id =  $this->db->insert_id();
			$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'),$productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	

			$data = array("messagee"=>"Your Activation Submitted succesfully &   Transaction ID : ".$this->authorize_net->getTransactionId());
			echo json_encode($data);

			
		}else{
			$data = array("message"=>"Activation  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
			echo json_encode($data);
		}		
	}

	function send_user_email_on_purchase($order_id=null, $user_name=null, $user_email=null, $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'Xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Xonnova network Purchase Mail');
        
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