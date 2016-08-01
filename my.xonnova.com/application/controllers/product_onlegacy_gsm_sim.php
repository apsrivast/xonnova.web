<?php
/**
* 
*/
class Product_onlegacy_gsm_sim extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	
	function checkUserHaveAccount(){
		$userid = $this->session->userdata('user_id');
		echo $this->onlegacy_mdl->getUserHaveAccount($userid);
	}

	function newOrderForTelekloud(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		if($_POST['group_id'] == '22'){
			$this->form_validation->set_rules('gsm_sim', 'SIM #', 'trim|required|xss_clean');	
		}else{
			$this->form_validation->set_rules('cdma_esn', 'ESN', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cdma_mdn', 'MDN', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lte_device', '4G LTE Device', 'trim|required|xss_clean');
		}
		$this->form_validation->set_rules('number_port', 'Number Port', 'trim|required|xss_clean');	

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_phone', 'Phone #', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|xss_clean');

		$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');

		$this->form_validation->set_rules('race', 'Race', 'trim|required|xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pref_lang', 'Preferred language', 'trim|required|xss_clean');
		$this->form_validation->set_rules('home_owner', 'Home owner', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bus_owner', 'Business  owner', 'trim|required|xss_clean');
		$this->form_validation->set_rules('health_insurance', 'health insurance', 'trim|required|xss_clean');
		$this->form_validation->set_rules('dental_insurance', 'dental insurance', 'trim|required|xss_clean');
		$this->form_validation->set_rules('life_insurance', 'life insurance', 'trim|required|xss_clean');


		$this->form_validation->set_rules('name_on_card', 'Name on Card', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('card_no', 'Card #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_month', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_year', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('cvv_no', 'CVV #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('billing_zip', 'Billing Zip', 'trim|required|xss_clean');	
			
		//$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');	
		
		
		
		//$this->form_validation->set_message('is_unique','This %s Value already Exist!');

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['gsm_sim']) && !empty($_POST['gsm_sim'])){
		}else	$_POST['gsm_sim'] = '';
		
		if(isset($_POST['cdma_esn']) && !empty($_POST['cdma_esn'])){
		}else	$_POST['cdma_esn'] = '';
		
		if(isset($_POST['cdma_mdn']) && !empty($_POST['cdma_mdn'])){
		}else 	$_POST['cdma_mdn'] = '';

		if(isset($_POST['lte_device']) && !empty($_POST['lte_device'])){
		}else 	$_POST['lte_device'] = '';

		if(isset($_POST['account_no']) && !empty($_POST['account_no'])){
		}else	$_POST['account_no'] = '';
		
		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else	$_POST['ssn'] = '';
		
		if(isset($_POST['pin_no']) && !empty($_POST['pin_no'])){
		}else 	$_POST['pin_no'] = '';

		if(isset($_POST['mobile_no']) && !empty($_POST['mobile_no'])){
		}else 	$_POST['mobile_no'] = '';

		if(isset($_POST['lte_sim_no']) && !empty($_POST['lte_sim_no'])){
		}else 	$_POST['lte_sim_no'] = '';

		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else	$_POST['address2'] = '';

		$_POST['user_account_no'] =  $this->onlegacy_mdl->telekloudAccountNumber($userid);
		if($_POST['group_id'] == '22'){
			$_POST['queueid'] =  $this->addNewOrderForTeleTwoOne($_POST);
		}else{
			$_POST['queueid'] =  $this->addNewOrderForTele($_POST);
		}

		$_POST['orderstatus'] = (string)$this->onlegacy_mdl->searchQueue($_POST['queueid']);
		
		if($_POST['orderstatus'] == '0'){
			$_POST['order_id'] = (string)$this->onlegacy_mdl->searchQueueOrderId($_POST['queueid']);
		}else{
			$data = array('message'=>$_POST['orderstatus']);
			echo json_encode($data);	
			return;
		}

		$_POST['paid_amount'] = $this->onlegacy_mdl->getReccuringAmount($_POST['product_id']) + $this->onlegacy_mdl->getActivationAmount($_POST['product_id']);
		$_POST['recurring_amount'] = $this->onlegacy_mdl->getReccuringAmount($_POST['product_id']);
		$insertArr = array(
				//t_o_id
				'user_id'=>$userid,
				'user_account_no'=>$_POST['user_account_no'],
				'group_id'=>$_POST['group_id'],
				'product_id'=>$_POST['product_id'],
				'order_id'=>$_POST['order_id'],
				'gsm_sim'=>$_POST['gsm_sim'],
				'cdma_esn'=>$_POST['cdma_esn'],
				'cdma_mdn'=>$_POST['cdma_mdn'],
				'lte_device'=>$_POST['lte_device'],
				'account_no'=>$_POST['account_no'],
				'ssn'=>$_POST['ssn'],
				'pin_no'=>$_POST['pin_no'],
				'mobile_no'=>$_POST['mobile_no'],
				'lte_sim_no'=>$_POST['lte_sim_no'],
				'number_port'=>$_POST['number_port'],

				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'user_phone'=>$_POST['user_phone'],
				'user_email'=>$_POST['user_email'],

				'address1'=>$_POST['address1'],
				'address2'=>$_POST['address2'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state'],
				'country'=>$_POST['country'],
				'zip'=>$_POST['zip'],

				'race'=>$_POST['race'],
				'gender'=>$_POST['gender'],
				'pref_lang'=>$_POST['pref_lang'],
				'home_owner'=>$_POST['home_owner'],
				'bus_owner'=>$_POST['bus_owner'],
				'health_insurance'=>$_POST['health_insurance'],
				'dental_insurance'=>$_POST['dental_insurance'],
				'life_insurance'=>$_POST['life_insurance'],

				'name_on_card'=>$_POST['name_on_card'],
				'card_no'=>$_POST['card_no'],
				'expiry_month'=>$_POST['expiry_month'],
				'expiry_year'=>$_POST['expiry_year'],
				'cvv_no'=>$_POST['cvv_no'],
				'billing_zip'=>$_POST['billing_zip'],

				'paid_amount'=>$_POST['paid_amount'],
				'recurring_amount'=>$_POST['recurring_amount'],
				//transaction_id
				//transaction_arb_id
				//t_o_time
		);
		$this->db->insert('telekloud_order',$insertArr);
		$last_id =  $this->db->insert_id();

		//AIM payment Method
		//$this->onlegacy_mdl->getReccuringAmount($_POST['product_id']);
		//$this->onlegacy_mdl->getActivationAmount($_POST['product_id']);
		$amount = $_POST['paid_amount'];
		$recamount = $_POST['recurring_amount'];
		$this->load->library('authorize_net');
		$auth_net = array(
			'x_card_num'			=> trim($_POST['card_no']), // Visa
			'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
			'x_card_code'			=> trim($_POST['cvv_no']),
			'x_description'			=> 'xonnova Network transaction',
			'x_amount'				=> trim($amount),
			'x_first_name'			=> $_POST['first_name'],
			'x_last_name'			=> $_POST['last_name'],
			'x_address'				=> $_POST['address1'].''.$_POST['address2'],
			'x_city'				=> $_POST['city'],
			'x_state'				=> $_POST['state'],
			'x_zip'					=> $_POST['zip'],
			'x_country'				=> $_POST['country'],
			'x_phone'				=> trim($_POST['user_phone']),
			'x_email'				=> $_POST['user_email'],
			'x_customer_ip'			=> $this->input->ip_address(),
		);

		$this->authorize_net->setData($auth_net);
		
		// Send request
		if($this->authorize_net->authorizeAndCapture()){	
			$upArr = array(
				'transaction_id'=>$this->authorize_net->getTransactionId(),
			);
			$this->db->update('telekloud_order',$upArr,array('t_o_id'=>$last_id));
		}else{
			$upArr = array(
				'transaction_id'=>$this->authorize_net->getError(),
			);
			$this->db->update('telekloud_order',$upArr,array('t_o_id'=>$last_id));
		}

		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));
		//ARB payment method
		$this->load->library('authorize_arb');
		
		$this->authorize_arb->startData('create');
		$refId = substr(md5( microtime() . 'ref' ), 0, 20);
		$this->authorize_arb->addData('refId', $refId);
		$subscription_data = array(			
			'name' => $_POST['name_on_card'].'xonnova Subscription',
			'paymentSchedule' => array(
				'interval' => array(
					'length' => 1,
					'unit' => 'months',
					),
				'startDate' => $recurringStartDate,
				'totalOccurrences' => 9999,
				'trialOccurrences' => 1,
				),
			'amount' => $recamount,
			'trialAmount' => 0,
			'payment' => array(
				'creditCard' => array(
					'cardNumber' => $_POST['card_no'],
					'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
					'cardCode' => $_POST['cvv_no'],
					),
				),			
			'billTo' => array(
				'firstName' => $this->input->post('first_name'),
				'lastName' => $this->input->post('last_name'),				
				),
		);
		$this->authorize_arb->addData('subscription', $subscription_data);

		if($this->authorize_arb->send()){
			$upArr = array(
				'transaction_arb_id'=>$this->authorize_arb->getId(),
			);
			$this->db->update('telekloud_order',$upArr,array('t_o_id'=>$last_id));
		}else{
			$upArr = array(
				'transaction_arb_id'=>$this->authorize_arb->getError(),
			);
			$this->db->update('telekloud_order',$upArr,array('t_o_id'=>$last_id));
		}
		
		
		$data['message'] = "Your Order Completed succesfully";
		echo json_encode($data);
	}

	
	function addNewOrderForTeleTwoOne($post){

		$request = "<TELEKLOUD>
		<auth>
			<VARID>2777866318</VARID>
			<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
			<USER>info@onlegacynetwork.com</USER>
			<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
		</auth>
		<service>CUSTOMER_ORDER</service>
		<CUSTOMER_ACCOUNT_NUMBER>".$post['user_account_no']."</CUSTOMER_ACCOUNT_NUMBER>
		<DATA1>".$post['product_id']."</DATA1>
		<DATA2>".$post['gsm_sim']."</DATA2>
		<DATA3></DATA3>
		<DATA4>".$post['number_port']."</DATA4>
		<DATA5>".$post['account_no']."</DATA5>
		<DATA6>".$post['pin_no']."</DATA6>
		<DATA7>".$post['ssn']."</DATA7>
		<DATA8>".$post['mobile_no']."</DATA8>
		</TELEKLOUD>";
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec($curl);
		curl_close ($curl);
		$xml = simplexml_load_string($response);
		return $xml->queueid;
		//return $this->onlegacy_mdl->searchQueue($xml->queueid);
		
	}

	function addNewOrderForTele($post){
		$request = "<TELEKLOUD>
		<auth>
			<VARID>2777866318</VARID>
			<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
			<USER>info@onlegacynetwork.com</USER>
			<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
		</auth>
		<service>CUSTOMER_ORDER</service>
		<CUSTOMER_ACCOUNT_NUMBER>".$post['user_account_no']."</CUSTOMER_ACCOUNT_NUMBER>
		<DATA1>".$post['product_id']."</DATA1>
		<DATA2>".$post['cdma_esn']."</DATA2>
		<DATA3>".$post['cdma_mdn']."</DATA3>
		<DATA4>".$post['number_port']."</DATA4>
		<DATA5>".$post['account_no']."</DATA5>
		<DATA6>".$post['pin_no']."</DATA6>
		<DATA7>".$post['ssn']."</DATA7>
		<DATA8>".$post['mobile_no']."</DATA8>
		<DATA9>".$post['lte_device']."</DATA9>
		<DATA10>".$post['lte_sim_no']."</DATA10>
		</TELEKLOUD>";
		 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
		$response = curl_exec($curl);
		curl_close ($curl);
		$xml = simplexml_load_string($response);
		return $xml->queueid;
		//return $this->onlegacy_mdl->searchQueue($xml->queueid);
	}

	function getGroupId($id){
		echo $this->onlegacy_mdl->getGroupId($id);
	}

	function paymentMethodOnlegacyMobile(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('name_on_card', 'Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('card_no', 'Card #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_month', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_year', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('cvv_no', 'CVV #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('billing_zip', 'Billing Zip', 'trim|required|xss_clean');			

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}

		$_POST['account_no'] =  $this->onlegacy_mdl->telekloudAccountNumber($userid);
		
		$response =  $this->addCustomerPaymentMethodToTeleKloud($_POST);
		$data['message'] = $response;
		echo json_encode($data);
		return;
		
		if($_POST['account_no'] == 0){
			$data = array('message'=>'The data you entered is not correct. Please retry');
			echo json_encode($data);	
			return;
		}


		$insertArr = array(
				'user_id'=>$userid,
				'name_on_card'=>$_POST['name_on_card'],
				'card_no'=>$_POST['card_no'],
				'expiry_month'=>$_POST['expiry_month'],
				'expiry_year'=>$_POST['expiry_year'],
				'cvv_no'=>$_POST['cvv_no'],
				'billing_zip'=>$_POST['billing_zip'],
		);

		if(!$this->db->insert('telekloud_payment_method',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['message'] = "Your Payment Method Completed succesfully";
		echo json_encode($data);
	}

	function addCustomerPaymentMethodToTeleKloud($post){

		$request = "<TELEKLOUD>
					    <auth>
					    		<VARID>2777866318</VARID>
								<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
								<USER>info@onlegacynetwork.com</USER>
								<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
					    </auth>
					    <service>CUSTOMER_PAYMENT_METHOD</service>
					    <CUSTOMER_ACCOUNT_NUMBER>".$post['account_no']."</CUSTOMER_ACCOUNT_NUMBER>
					    <DATA1></DATA1>
					    <DATA2>CC</DATA2>
					    <DATA4>".$post['card_no']."</DATA4>
					    <DATA5>".$post['cvv_no']."</DATA5>
					    <DATA6>".$post['expiry_month']."</DATA6>
					    <DATA7>".$post['expiry_year']."</DATA7>
					    <DATA8></DATA8>
					    <DATA9></DATA9>
					    <DATA10>1</DATA10>
					    <DATA11>2</DATA11>
		</TELEKLOUD>";


	     
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
	    $response = curl_exec($curl);
	    curl_close ($curl);
	    //show the response
	    header ("content-type: text/xml");
	    return $response; 
	}



	function addCustomerTelekloud(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|xss_clean');	
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|xss_clean');	
		$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');			
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|numeric|exact_length[5]|xss_clean');	
		$this->form_validation->set_rules('contact_no', 'Contact #', 'trim|required|numeric|exact_length[10]|is_unique[telekloud_master.contact_no]|xss_clean');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[telekloud_master.user_email]|xss_clean');	
		$this->form_validation->set_rules('user_password', 'Password', 'trim|required|numeric|exact_length[8]|xss_clean');	
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[user_password]|xss_clean');
		$this->form_validation->set_message('is_unique','This %s Value already Exist!');

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['company']) && !empty($_POST['company'])){
		}else	$_POST['company'] = '';
		
		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else	$_POST['ssn'] = '';
		
		if(isset($_POST['driver_license']) && !empty($_POST['driver_license'])){
		}else 	$_POST['driver_license'] = '';

		$_POST['unit_no'] =  $userid;
		
		$_POST['account_no'] =  $this->addCustomerToTeleKloud($_POST);
		
		if($_POST['account_no'] == 0){
			$data = array('message'=>'The data you entered is not correct. Please retry');
			echo json_encode($data);	
			return;
		}


		$insertArr = array(
				'user_id'=>$userid,
				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'address'=>$_POST['address'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state'],
				'country'=>$_POST['country'],
				'zip'=>$_POST['zip'],
				'contact_no'=>$_POST['contact_no'],
				'user_email'=>$_POST['user_email'],
				'user_password'=>$_POST['user_password'],
				'ssn'=>$_POST['ssn'],
				'company'=>$_POST['company'],
				'driver_license'=>$_POST['driver_license'],
				'account_no'=>$_POST['account_no'],
		);

		if(!$this->db->insert('telekloud_master',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['messagee'] = "Your Registration Completed succesfully";
		echo json_encode($data);
	}

	function addCustomerToTeleKloud($post){
			$request = "<TELEKLOUD>
							<auth>
								<VARID>2777866318</VARID>
								<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
								<USER>info@onlegacynetwork.com</USER>
								<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
							</auth>
							<service>CUSTOMER_CUSTOMER</service>
							<CUSTOMER_ACCOUNT_NUMBER></CUSTOMER_ACCOUNT_NUMBER>
							<DATA1>".$post['company']."</DATA1>
							<DATA2>".$post['first_name']."</DATA2>
							<DATA3>".$post['last_name']."</DATA3>
							<DATA4>".$post['address']."</DATA4>
							<DATA5>APT</DATA5>
							<DATA6>".$post['unit_no']."</DATA6>
							<DATA7>".$post['zip']."</DATA7>
							<DATA8>".$post['user_email']."</DATA8>
							<DATA9>".$post['contact_no']."</DATA9>
							<DATA10>".$post['user_password']."</DATA10>
							<DATA11></DATA11>
							<DATA12></DATA12>
							<DATA13></DATA13>
							<DATA14></DATA14>
							<DATA15>1</DATA15>
							<DATA16>".$post['city']."</DATA16>
							<DATA17>".$post['country']."</DATA17>
							<DATA18>".$post['state']."</DATA18>
						</TELEKLOUD>";

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
			$response = curl_exec($curl);
			curl_close ($curl);
					 
			

			sleep(15);
			$request = "
				<TELEKLOUD>
					<auth>
						<VARID>2777866318</VARID>
						<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
						<USER>info@onlegacynetwork.com</USER>
						<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
					</auth>
					<service>SEARCH_CUSTOMER</service>
					<DATA8>".$post['user_email']."</DATA8>
					<DATA9>".$post['contact_no']."</DATA9>
				</TELEKLOUD>";
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			$response = curl_exec($curl);
			curl_close ($curl);

			$xml = simplexml_load_string($response);
			if(isset($xml->SEARCH_CUSTOMER->CUSTOMER_ACCOUNT)){
				$number =  $xml->SEARCH_CUSTOMER->CUSTOMER_ACCOUNT->attributes();
				return $number;
			}else{
				return 0;
			}		
	}





	function buyOnlegacyGsmSimForBOCard(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_phone', 'Phone #', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|xss_clean');

		$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');
		$this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');

		$this->form_validation->set_rules('name_on_card', 'Name on Card', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('card_no', 'Card #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_month', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('expiry_year', 'Expiry Date', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('cvv_no', 'CVV #', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('billing_zip', 'Billing Zip', 'trim|required|xss_clean');	

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}

		// if(isset($_POST['name_on_card']) && !empty($_POST['name_on_card'])){
		// }else{
		// 	$data = array("error"=>"Name on Card field is required !");
		// 	echo json_encode($data);
		// 	return  ;
		// }

		// if(isset($_POST['billing_zip']) && !empty($_POST['billing_zip'])){
		// }else{
		// 	$data = array("error"=>"Billing ZIP field is required !");
		// 	echo json_encode($data);
		// 	return  ;
		// }
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else	$_POST['address2'] = '';

		$userID = $this->session->userdata('user_id');
		$total_amt = 20;
		$this->load->library('authorize_net');
		$auth_net = array(
			'x_card_num'			=> trim($_POST['card_no']), // Visa
			'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
			'x_card_code'			=> trim($_POST['cvv_no']),
			'x_description'			=> 'GSM SIM, xonnova Network',
			'x_amount'				=> trim($total_amt),
			//'x_first_name'			=> $this->session->userdata('first_name'),
			//'x_last_name'			=> $this->session->userdata('last_name'),
			//'x_address'				=> $this->session->userdata('address1').', '.$this->session->userdata('address2'),
			//'x_city'				=> $this->session->userdata('city'),
			//'x_state'				=> $this->session->userdata('state'),
			//'x_zip'					=> $this->session->userdata('zip'),
			'x_country'				=> 'USA',
			//'x_phone'				=> trim($this->session->userdata('contact_no')),
			//'x_email'				=> $this->session->userdata('user_email'),
			'x_customer_ip'			=> $this->input->ip_address(),
		);

		$this->authorize_net->setData($auth_net);
		if($this->authorize_net->authorizeAndCapture()){
			$insertArr = array(
					'user_id'=>$userID,
					'group_id'=>$_POST['group_id'],
					'first_name'=>$_POST['first_name'],
					'last_name'=>$_POST['last_name'],
					'user_phone'=>$_POST['user_phone'],
					'user_email'=>$_POST['user_email'],

					'address1'=>$_POST['address1'],
					'address2'=>$_POST['address2'],
					'city'=>$_POST['city'],
					'state'=>$_POST['state'],
					'country'=>$_POST['country'],
					'zip'=>$_POST['zip'],

					'subtotal'=>$total_amt,
					'name_on_card'=>$_POST['name_on_card'],
					'card_no'=>$_POST['card_no'],
					'card_ccv'=>$_POST['cvv_no'],
					'billing_zip'=>$_POST['billing_zip'],
					'card_expiry'=>trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'transaction_id'=>$this->authorize_net->getTransactionId(),
				);
			$this->db->insert('gsm_sim_purchase_info',$insertArr);

			//$this->email_on_purchase($this->session->userdata('user_name'), $this->session->userdata('user_email'), $total_amt);	
			$this->getSponsorToSponsorQV(0);
			$this->getProductSaleParentToParentBinary(0);	

			$data = array('messagee'=>'Your request has been submitted successfully.  Transaction ID : '.$this->authorize_net->getTransactionId());
			echo json_encode($data);
		}else{
			$data = array('message'=>'Error ! '.$this->authorize_net->getError());
			echo json_encode($data);
		}
	}

	function getProductSaleParentToParentBinary($binaryPoint){
		$userChild = $this->session->userdata('user_id');
		$parent = $this->mdl_common->getAllParent($userChild);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$cur_user = $userChild;
			if($sponser > 0){				
				// $binaryPoint1 = $this->mdl_common->getSaleBinary($pid);
				// $binaryPoint = $binaryPoint1*$qty;
				
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point, pro_sales_binary, bonus from earning_info where user_id = '.$sponser);
							
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {
						$totalSaleBinaryPoint = $total['pro_sales_binary'] + $binaryPoint;
						$totalBinaryPoint = $total['referral_binary_point'] + $binaryPoint;
						$updattotalarr = array(
							'pro_sales_binary'=>$totalSaleBinaryPoint,
							'referral_binary_point'=>$totalBinaryPoint
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
					}
				}else{
					$totalBinaryPoint = $binaryPoint;
					
					$updattotalarr = array(					
						'pro_sales_binary'=>$totalBinaryPoint
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
				}

				$insertArr = array(
					'parent_id'=>$sponser,
					'user_id'=>$cur_user,
					'sale_binary_point'=>$binaryPoint,
				);
				$this->db->insert('product_sale_binary',$insertArr);

				$insertArr = array(
					'parent_id'=>$sponser,
					'user_id'=>$cur_user,
					'referral_binary'=>$binaryPoint,
				);
				$this->db->insert('referrals_binary',$insertArr);

				
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$userChild = $this->mdl_common->getAllParent($cur_user);
		}
	}

	function getSponsorToSponsorQV($binaryPoint){
		$user = $this->session->userdata('user_id');
		// $binaryPoint1 = $this->mdl_common->getSaleQV($pid);
		// $binaryPoint = $binaryPoint1*$qty;
		// $insertBinamry = array(
		// 		'sponsor_id'=>$user,
		// 		'user_id'=>$user,
		// 		'qv_point'=>$binaryPoint
		// 	);
		// $this->db->insert('unilevel_binary_info',$insertBinamry);

		$parent = $this->mdl_common->getAllSponsor($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){	
				
				
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

	function email_on_purchase( $user_name=null, $user_email=null,  $total_amt=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('xonnova network Purchase Mail');
        
        $mail_body	=	$this->mailBody( $user_name,  $total_amt);
        $this->email->message($mail_body);

        $this->email->send();
    }

   function mailBody( $user_name=null,   $total_amt=null){
		$mail_body = '
						<div>
						<h3>Order confirmation</h3>
						<h1 style="font-size:70px;">Thank you</h1>
						<p>Bellow are important detail about your order. Question? We are always here to help you. Simply contact our chat support at any time from your backoffice.</p>

						
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
										GSM SIM
									</td>
									<td  align="center" style="border:1px solid rgb(0,0,0);">
										1
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" >
										
									</td>

									<td  align="center" style="border:1px solid rgb(0,0,0);">
										$'.$total_amt.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Subtotal:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$'.$total_amt.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Shipping & Handling:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$0.00
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

	function finalPrice($id){
		echo $this->onlegacy_mdl->getReccuringAmount($id) + $this->onlegacy_mdl->getActivationAmount($id);
	}
}