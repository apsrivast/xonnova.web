<?php
/**
* 
*/
class Activate_platform extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		
	}
	function activatePlatform(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		
		// $simOrdered = $this->mdl_common->isUserOrderSim($this->session->userdata('user_id'));
			
		// if(isset($simOrdered) && !empty($simOrdered)){
		// 	$data = array('message'=>'Already Submited ..');
		// 	echo json_encode($data);
		// }else{
		
		$userName = $this->mdl_common->getSIMusername($this->session->userdata('user_id'));
		$userPhone = $this->mdl_common->getSIMuserphone($this->session->userdata('user_id'));
		$userEmail = $this->mdl_common->getSIMuseremail($this->session->userdata('user_id'));
			
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

						if(isset($_POST['user_emailATTSim'])&&!empty($_POST['user_emailATTSim'])){
							$email = $_POST['user_emailATTSim'];
						}else{
							$email = '';
							$data = array("message"=>"Email Required !"); 
							echo json_encode($data);
							return false ;
						}


					$auth_net = array(
						'x_card_num'			=> trim($card_no), // Visa
						'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
						'x_card_code'			=> trim($cvvNo),
						'x_description'			=> 'Activate Platform TestOnlegacy Network transaction',
						'x_amount'				=> 15,
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

						$insertarr = array(
							'user_id'=>$this->session->userdata('user_id'),
							'user_name'=>$userName,
							'user_phone'=>$userPhone,
							'user_email'=>$userEmail,
							// 'q1'=>$_POST['q1'],
							'q2'=>'ATT',
							'q3'=>$question3,
							'q4'=>15,
							'sim'=>$simNumber,

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
						$data = array("message"=>"Your Registration Completed succesfully & Success!  Transaction ID : ".$this->authorize_net->getTransactionId());
						echo json_encode($data);
					}else{
						$data = array("message"=>"Registration  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
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

									
								

								$auth_net = array(
									'x_card_num'			=> trim($card_no), // Visa
									'x_exp_date'			=> trim($expiryYear).'/'.trim($expiryMonth),
									'x_card_code'			=> trim($cvvNo),
									'x_description'			=> 'Activate Platform TestOnlegacy Network transaction',
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
										'user_name'=>$userName,
										'user_phone'=>$userPhone,
										'user_email'=>$userEmail,
										'q1'=>$_POST['q1'],
										'q2'=>'Simple Mobile',
										'q3'=>$question3,
										'q4'=>$q4,
										'sim'=>$simNumber,

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
									$data = array("message"=>"Your Registration Completed succesfully & Success!  Transaction ID : ".$this->authorize_net->getTransactionId());
									echo json_encode($data);
								}else{
									$data = array("message"=>"Registration  Fail!  Transaction Error ID : ".$this->authorize_net->getError()); 
									echo json_encode($data);
								}		



						}

					}
				}
					
			
			
		// }
		

	}


	function activatePlatformReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM  activate_platform');
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
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform  where id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}
}