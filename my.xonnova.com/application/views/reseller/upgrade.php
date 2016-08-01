<?php
/**
* 
*/
class Upgrade extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}
	
	function getTotalUpgradeUser(){
		header('Content-Type: application/json');
		$upgradeDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		//$countUpgradeUser = count($this->mdl_common->allSelects('SELECT DISTINCT * From upgrade_user_details where upgrade_at > "'.$upgradeDate.'"'));
		$countUpgradeUser = $this->mdl_common->allSelects('SELECT COUNT( b.user_id ) as totalUpgrade
															FROM user_master a
															INNER JOIN upgrade_user_details AS b ON b.user_id = a.user_id
															WHERE b.shipping_status = "not approved"');
		
		if(!empty($countUpgradeUser)){
			foreach($countUpgradeUser as $value){
				echo json_encode($value['totalUpgrade']);				
			}
		}else{
			
		}
	}

	function newUpgradeUserList(){
		header('Content-Type: application/json');
		$upgradeDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		//$getPackage = $this->mdl_common->allSelects('SELECT  DISTINCT  a.*, b.*, c.*, d.*, e.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id RIGHT JOIN upgrade_user_details as c on c.user_id=a.user_id LEFT JOIN package_info as d on d.package_id=c.package_id LEFT JOIN level_configuration as e on e.l_conf_id=b.level WHERE upgrade_at > "'.$upgradeDate.'"');
		$getPackage = $this->mdl_common->allSelects('SELECT  DISTINCT  a.*, b.*, c.*, d.*, e.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id RIGHT JOIN upgrade_user_details as c on c.user_id=a.user_id LEFT JOIN package_info as d on d.package_id=c.package_id LEFT JOIN level_configuration as e on e.l_conf_id=b.level WHERE c.shipping_status = "not approved"');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}
	
	function getCurrentUser(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master where user_id='.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getEncriptionSystem(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From package_info where package_status="active"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	public function uniqueuser() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}

	function getPackageStoreCreditById(){
		header('Content-Type: application/json');
		$packageId = $this->mdl_common->getPackageById($this->session->userdata('user_id'));
		$packageCreditAmount = $this->onlegacy_mdl->packageStoreCredit($packageId);
		echo json_encode ($packageCreditAmount);
	}
	function getonchangePackageStoreCreditById($id){
		header('Content-Type: application/json');
		$packageCreditAmount = $this->onlegacy_mdl->packageStoreCredit($id);
		echo json_encode ($packageCreditAmount);
	}

	function getTotalStoreCreditById(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				//$arr=$value['total'];
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}
	function getTotalDeductStoreCreditById(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				//$arr=$value['total'];
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}
	function getTotalStoreCredit($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductStoreCredit($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}
	
	function upgradeUserByUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		if(isset($_POST['user_name'])&&!empty($_POST['user_name'])){
			$user_name = $_POST['user_name'];
			$userId = $this->mdl_common->sponserID($_POST['user_name']);
			$packageId = $this->mdl_common->getPackageId($_POST['user_name']);
			$packageAmount = $this->mdl_common->planPrice($packageId);

			$packageReferralAmount = $this->mdl_common->packageReferralAmount($packageId);
			$existBinary = $this->mdl_common->packageBinaryPoint($packageId);
		}else{
			$user_name = "";
			$userId = 0;
			$packageId = 0;
			$packageAmount = 0;
			$existBinary = 0;
		}

		if(isset($_POST['incriptionList'])&&!empty($_POST['incriptionList'])){
			$incriptionList = $_POST['incriptionList'];
			$currentAmount = $this->mdl_common->planPrice($_POST['incriptionList']);
			$currentBinary = $this->mdl_common->packageBinaryPoint($_POST['incriptionList']);
			$currentReferralAmmount = $this->mdl_common->packageReferralAmount($_POST['incriptionList']);
		}else{
			$incriptionList = "";
			$currentAmount = 0;
			$currentBinary = 0;
			$currentReferralAmmount = 0;
		}
	
		
		if($userId > 0 && $currentAmount > 0 && $packageId > 0 && $incriptionList > $packageId){
			$voucherUser = count($this->mdl_common->allSelects('SELECT * From voucher_details WHERE user_id='.$userId));
			$cardPayment = count($this->mdl_common->allSelects('SELECT * From payment_info WHERE user_id='.$userId));
			$referralAmount1 = $currentReferralAmmount - $packageReferralAmount;
			$binary_point = $currentBinary - $existBinary;
			$amount = $currentAmount - $packageAmount;
			//echo $amount; exit();
			if((!empty($voucherUser) && $voucherUser > 0)&& (empty($cardPayment) && $cardPayment == 0)){
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						if(!empty($_POST['checked']) && !empty($_POST['voucher_code'])){
							$checkVoucherCode = $this->mdl_common->isVoucherCodeExist($_POST['voucher_code']);
							if($checkVoucherCode == true){
									$insertArr = array(
										'user_id'=>$userId,
										'package_id'=>$incriptionList,
										'amount'=>$amount,
										'binary_point'=>$binary_point,	
										'upgrade_type'=>'voucher'									
									);
									$this->db->insert('upgrade_user_details',$insertArr);
									$this->mdl_common->insertShippingStatusforUpgread($userId,$incriptionList);

									$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);						
									$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
									$updattotalarr = array(
										'total_balance'=>$totalreferralAmount,
									);
									$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
									
									$insertReferralBonus = array(
											'parent_id'=>$value['sponsor_id'],
											'user_id'=>$userId,
											'referral_bonus'=>$referralAmount1,
										);
									$this->db->insert('referral_bonus',$insertReferralBonus);

									//Earning Details in one table	
									$earning_details_by_user = array(
											'user_id'=>$value['sponsor_id'],
											'ref_id'=>$userId,
											'description'=>'Upgrade Referral amount from .'.$value['user_name'],
											'amount'=>$referralAmount1,
											//'message'=>"",
											//'e_d_b_u_date'=>$value['created_at'],
										);
									$this->db->insert('earning_details_by_user',$earning_details_by_user);
									//end

									$paymentInfoLastId = $this->db->insert_id();
									if($value['level'] < 6){
										$levelUpdateArr = array('level'=>$incriptionList);
										$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
									}

									$referralAmount = $currentReferralAmmount;
									$updateEarningInfoArr = array(
											'total_amount'=>$currentAmount,
											'referrals_earning'=>$referralAmount,
										);
									$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
									
									$updatePackageArr = array('package'=>$incriptionList);
									//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
												
									$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
									$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
									$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
									$voucherinsertarr = array(
											'user_id'=>$userId,
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

									$data = array("message"=>"Your Package Upgraded sucessfully!"); 
									echo json_encode($data);
							}else{
								$data = array("message"=>"Sorry.... Upgrade is Not Success, Vouchere code is invalid!"); 
								echo json_encode($data);
							}
						
						}else{
							$packageCreditAmount = $this->onlegacy_mdl->packageStoreCredit($packageId);
							$currentCreditAmount = $this->onlegacy_mdl->packageStoreCredit($incriptionList);
							$creditAmount = $currentCreditAmount - $packageCreditAmount;
							$userStoreCredit = $this->getTotalStoreCredit($userId) - $this->getTotalDeductStoreCredit($userId);
							if($userStoreCredit >= $creditAmount){
									$insertArr = array(
										'user_id'=>$userId,
										'package_id'=>$incriptionList,
										'amount'=>$creditAmount,
										'binary_point'=>$binary_point,	
										'upgrade_type'=>'store credit'									
									);
									$this->db->insert('upgrade_user_details',$insertArr);

									$this->mdl_common->insertShippingStatusforUpgread($userId, $incriptionList);

									$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);						
									$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
									$updattotalarr = array(
										'total_balance'=>$totalreferralAmount,
									);
									$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
									
									$insertReferralBonus = array(
											'parent_id'=>$value['sponsor_id'],
											'user_id'=>$userId,
											'referral_bonus'=>$referralAmount1,
										);
									$this->db->insert('referral_bonus',$insertReferralBonus);

									//Earning Details in one table	
									$earning_details_by_user = array(
											'user_id'=>$value['sponsor_id'],
											'ref_id'=>$userId,
											'description'=>'Upgrade Referral amount from .'.$value['user_name'],
											'amount'=>$referralAmount1,
											//'message'=>"",
											//'e_d_b_u_date'=>$value['created_at'],
										);
									$this->db->insert('earning_details_by_user',$earning_details_by_user);
									//end

									$paymentInfoLastId = $this->db->insert_id();
									if($value['level'] < 6){
										$levelUpdateArr = array('level'=>$incriptionList);
										$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
									}

									$referralAmount = $currentReferralAmmount;
									$updateEarningInfoArr = array(
											'total_amount'=>$currentAmount,
											'referrals_earning'=>$referralAmount,
										);
									$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
									
									$updatePackageArr = array('package'=>$incriptionList);
									//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
												
									$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
									$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
									$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
								
									$Arr = array(
										'user_id'=>$userId,
										//'admin_id'=>$this->session->userdata('user_id'),
										'credit'=>$creditAmount,
										'wallet_type'=>'2',
										'message'=>'Upgrade',
									);
									$this->db->insert('store_credit_report_info',$Arr);
									$data = array("message"=>"Your Package Upgraded sucessfully!"); 
									echo json_encode($data);
							}else{
								$data = array("message"=>"Sorry.... Upgrade is Not Success, Store credit is Less Then Package Amount!"); 
								echo json_encode($data);
							}

						}						
					}
				}
			}else{
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						if(!empty($_POST['checked']) && !empty($_POST['voucher_code'])){
							$checkVoucherCode = $this->mdl_common->isVoucherCodeExist($_POST['voucher_code']);
							if($checkVoucherCode == true){
									$insertArr = array(
										'user_id'=>$userId,
										'package_id'=>$_POST['incriptionList'],
										'amount'=>$amount,
										'binary_point'=>$binary_point,
										'upgrade_type'=>'voucher'
									);
									$this->db->insert('upgrade_user_details',$insertArr);
									$this->mdl_common->insertShippingStatusforUpgread($userId,$incriptionList);
									$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);					
									$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
									$updattotalarr = array(
										'total_balance'=>$totalreferralAmount,
									);
									$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
									
									$insertReferralBonus = array(
											'parent_id'=>$value['sponsor_id'],
											'user_id'=>$userId,
											'referral_bonus'=>$referralAmount1,
										);
									$this->db->insert('referral_bonus',$insertReferralBonus);

									//Earning Details in one table	
									$earning_details_by_user = array(
											'user_id'=>$value['sponsor_id'],
											'ref_id'=>$userId,
											'description'=>'Upgrade Referral amount from .'.$value['user_name'],
											'amount'=>$referralAmount1,
											//'message'=>"",
											//'e_d_b_u_date'=>$value['created_at'],
										);
									$this->db->insert('earning_details_by_user',$earning_details_by_user);
									//end

									if($value['level'] < 6){
										$levelUpdateArr = array('level'=>$incriptionList);
										$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
									}
									$referralAmount = $currentReferralAmmount;
									$updateEarningInfoArr = array(
											'total_amount'=>$currentAmount,
											'referrals_earning'=>$referralAmount,
										); 
									$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
									
									$updatePackageArr = array('package'=>$incriptionList);
									//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
									
									$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
									$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
									$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
									

									$data = array('message'=>'Your Package Upgraded sucessfully!');
									echo json_encode($data);
							}else{
								$data = array('message'=>'Sorry Voucher code is invalid!');
								echo json_encode($data);
							}
						}else{
							$packageCreditAmount = $this->onlegacy_mdl->packageStoreCredit($packageId);
							$currentCreditAmount = $this->onlegacy_mdl->packageStoreCredit($incriptionList);
							$creditAmount = $currentCreditAmount - $packageCreditAmount;
							$userStoreCredit = $this->getTotalStoreCredit($userId) - $this->getTotalDeductStoreCredit($userId);
							if($userStoreCredit >= $creditAmount){
									$insertArr = array(
										'user_id'=>$userId,
										'package_id'=>$incriptionList,
										'amount'=>$creditAmount,
										'binary_point'=>$binary_point,	
										'upgrade_type'=>'store credit'									
									);
									$this->db->insert('upgrade_user_details',$insertArr);
									$this->mdl_common->insertShippingStatusforUpgread($userId, $incriptionList);

									$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);						
									$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
									$updattotalarr = array(
										'total_balance'=>$totalreferralAmount,
									);
									$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
									
									$insertReferralBonus = array(
											'parent_id'=>$value['sponsor_id'],
											'user_id'=>$userId,
											'referral_bonus'=>$referralAmount1,
										);
									$this->db->insert('referral_bonus',$insertReferralBonus);

									//Earning Details in one table	
									$earning_details_by_user = array(
											'user_id'=>$value['sponsor_id'],
											'ref_id'=>$userId,
											'description'=>'Upgrade Referral amount from .'.$value['user_name'],
											'amount'=>$referralAmount1,
											//'message'=>"",
											//'e_d_b_u_date'=>$value['created_at'],
										);
									$this->db->insert('earning_details_by_user',$earning_details_by_user);
									//end

									$paymentInfoLastId = $this->db->insert_id();
									if($value['level'] < 6){
										$levelUpdateArr = array('level'=>$incriptionList);
										$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
									}

									$referralAmount = $currentReferralAmmount;
									$updateEarningInfoArr = array(
											'total_amount'=>$currentAmount,
											'referrals_earning'=>$referralAmount,
										);
									$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
									
									$updatePackageArr = array('package'=>$incriptionList);
									//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
												
									$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
									$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
									$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
								
									$Arr = array(
										'user_id'=>$userId,
										//'admin_id'=>$this->session->userdata('user_id'),
										'credit'=>$creditAmount,
										'wallet_type'=>'2',
										'message'=>'Upgrade',
									);
									$this->db->insert('store_credit_report_info',$Arr);
									$data = array("message"=>"Your Package Upgraded sucessfully!"); 
									echo json_encode($data);
							}else{
								$data = array("message"=>"Sorry.... Upgrade is Not Success, Store credit is Less Then Package Amount!"); 
								echo json_encode($data);
							}

						}			
					}
				}
			}
		}else{
			$data = array('message'=>'You Cannot Downgrade your package!');
			echo json_encode($data);
		}
	}
	
	function upgradeUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));
		if(isset($_POST['user_name'])&&!empty($_POST['user_name'])){
			$user_name = $_POST['user_name'];
			$userId = $this->mdl_common->sponserID($_POST['user_name']);
			$packageId = $this->mdl_common->getPackageId($_POST['user_name']);
			$packageAmount = $this->mdl_common->planPrice($packageId);
			$packageReferralAmount = $this->mdl_common->packageReferralAmount($packageId);
			$existBinary = $this->mdl_common->packageBinaryPoint($packageId);
		}else{
			$user_name = "";
			$userId = 0;
			$packageId = 0;
			$packageAmount = 0;
			$existBinary = 0;
		}

		if(isset($_POST['incriptionList'])&&!empty($_POST['incriptionList'])){
			$incriptionList = $_POST['incriptionList'];
			$currentAmount = $this->mdl_common->planPrice($_POST['incriptionList']);
			$currentBinary = $this->mdl_common->packageBinaryPoint($_POST['incriptionList']);
			$currentReferralAmmount = $this->mdl_common->packageReferralAmount($_POST['incriptionList']);
		}else{
			$incriptionList = "";
			$currentAmount = 0;
			$currentBinary = 0;
			$currentReferralAmmount = 0;
		}
		if(isset($_POST['name_on_card'])&&!empty($_POST['name_on_card'])){
			$name_on_card = $_POST['name_on_card'];
		}else{
			$name_on_card = "";
		}
		if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
			$card_no = $_POST['card_no'];
		}else{
			$card_no = "";
		}
		if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
			$expiry_month = $_POST['expiry_month'];
		}else{
			$expiry_month = "";
		}
		if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
			$expiry_year = $_POST['expiry_year'];
		}else{
			$expiry_year = "";
		}
		if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
			$cvv_no = $_POST['cvv_no'];
		}else{
			$cvv_no = "";
		}
		if(isset($_POST['billing_zip'])&&!empty($_POST['billing_zip'])){
			$billing_zip = $_POST['billing_zip'];
		}else{
			$billing_zip = "";
		}
		if($userId > 0 && $currentAmount > 0 && $packageId > 0 && $incriptionList > $packageId){
			$voucherUser = count($this->mdl_common->allSelects('SELECT * From voucher_details WHERE user_id='.$userId));
			$cardPayment = count($this->mdl_common->allSelects('SELECT * From payment_info WHERE user_id='.$userId));
			$referralAmount1 = $currentReferralAmmount - $packageReferralAmount;
			$amount = $currentAmount - $packageAmount;
			$binary_point = $currentBinary - $existBinary;
			if((!empty($voucherUser) && $voucherUser > 0)&& (empty($cardPayment) && $cardPayment == 0)){
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						//AIM payment Method
						$this->load->library('authorize_net');

						$auth_net = array(
							'x_card_num'			=> trim($_POST['card_no']), // Visa
							'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
							'x_card_code'			=> trim($_POST['cvv_no']),
							'x_description'			=> 'Onlegacy Network transaction',
							'x_amount'				=> trim($amount),
							'x_first_name'			=> $value['first_name'],
							'x_last_name'			=> $value['last_name'],
							'x_address'				=> $value['address1'].''.$value['address2'],
							'x_city'				=> $value['city'],
							'x_state'				=> $value['state'],
							'x_zip'					=> $value['zip'],
							'x_country'				=> $value['country'],
							'x_phone'				=> trim($value['contact_no']),
							'x_email'				=> $value['user_email'],
							'x_customer_ip'			=> $this->input->ip_address(),
						);

						$this->authorize_net->setData($auth_net);

						//ARB payment method
						$this->load->library('authorize_arb');

						// Start with a create object
						$this->authorize_arb->startData('create');

						$refId = substr(md5( microtime() . 'ref' ), 0, 20);
						$this->authorize_arb->addData('refId', $refId);
						$total_amt = $amount;
						$subscription_data = array(			
							'name' => $_POST['name_on_card'].'Upgrade Onlegacy Subscription',
							'paymentSchedule' => array(
								'interval' => array(
									'length' => 1,
									'unit' => 'months',
									),
								'startDate' => $recurringStartDate,
								'totalOccurrences' => 9999,
								'trialOccurrences' => 1,
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
								'firstName' => $value['user_name'],
								'lastName' => $value['last_name'],				
								),
						);
						
						$this->authorize_arb->addData('subscription', $subscription_data);
						
						if( $this->authorize_arb->send() && $this->authorize_net->authorizeAndCapture() ){
							$insertArr = array(
									'user_id'=>$userId,
									'package_id'=>$incriptionList,
									'amount'=>$amount,
									'binary_point'=>$binary_point,
									'name_on_card'=>$_POST['name_on_card'],
									'card_no'=>$_POST['card_no'],
									'ref_id'=>$refId,
									'transaction_id'=>$this->authorize_net->getTransactionId(),
									'subscription_id'=>$this->authorize_arb->getId(),
								);
							$this->db->insert('upgrade_user_details',$insertArr);														$this->mdl_common->insertShippingStatusforUpgread($userId, $incriptionList);
							$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);						
							$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
							$updattotalarr = array(
								'total_balance'=>$totalreferralAmount,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
							
							$insertReferralBonus = array(
									'parent_id'=>$value['sponsor_id'],
									'user_id'=>$userId,
									'referral_bonus'=>$referralAmount1,
								);
							$this->db->insert('referral_bonus',$insertReferralBonus);

							//Earning Details in one table	
							$earning_details_by_user = array(
									'user_id'=>$value['sponsor_id'],
									'ref_id'=>$userId,
									'description'=>'Upgrade Referral amount from .'.$value['user_name'],
									'amount'=>$referralAmount1,
									//'message'=>"",
									//'e_d_b_u_date'=>$value['created_at'],
								);
							$this->db->insert('earning_details_by_user',$earning_details_by_user);
							//end

							$card_insert = array(
								'user_id'=>$userId,
								'package'=>$incriptionList,
								'ammount'=>$amount,
								'name_on_card'=>$_POST['name_on_card'],
								'card_no'=>$_POST['card_no'],
								'expiry_date'=>$expiry_year,
								'cvv_no'=>$_POST['cvv_no'],
								'transaction_id'=>$this->authorize_net->getTransactionId(),
								'transaction_arb_id'=>$this->authorize_arb->getId(),
								'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
								'ref_id'=>$refId,
							   );
							$this->db->insert('payment_info',$card_insert);
							if($value['level'] < 6){
								$levelUpdateArr = array('level'=>$incriptionList);
								$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
							}

							$referralAmount = $currentReferralAmmount;
							$updateEarningInfoArr = array(
									'total_amount'=>$currentAmount,
									'referrals_earning'=>$referralAmount,
								);
							$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
							
							$updatePackageArr = array('package'=>$incriptionList);
							//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
										
							$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
							$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
							$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
							

							$data = array('message'=>'Your Package Upgraded sucessfully!');
							echo json_encode($data);
						}else{
							$data = array('message'=>'This card is invalid! ');
							echo json_encode($data);
						}						
					}
				}
			}else{
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						//AIM payment Method
						$this->load->library('authorize_net');

						$auth_net = array(
							'x_card_num'			=> trim($_POST['card_no']), // Visa
							'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
							'x_card_code'			=> trim($_POST['cvv_no']),
							'x_description'			=> 'Onlegacy Network transaction',
							'x_amount'				=> trim($amount),
							'x_first_name'			=> $value['first_name'],
							'x_last_name'			=> $value['last_name'],
							'x_address'				=> $value['address1'].''.$value['address2'],
							'x_city'				=> $value['city'],
							'x_state'				=> $value['state'],
							'x_zip'					=> $value['zip'],
							'x_country'				=> $value['country'],
							'x_phone'				=> trim($value['contact_no']),
							'x_email'				=> $value['user_email'],
							'x_customer_ip'			=> $this->input->ip_address(),
						);

						$this->authorize_net->setData($auth_net);
						if($this->authorize_net->authorizeAndCapture()){
							$insertArr = array(
									'user_id'=>$userId,
									'package_id'=>$_POST['incriptionList'],
									'amount'=>$amount,
									'binary_point'=>$binary_point,
									'name_on_card'=>$_POST['name_on_card'],
									'card_no'=>$_POST['card_no'],
									'transaction_id'=>$this->authorize_net->getTransactionId(),
								);
							$this->db->insert('upgrade_user_details',$insertArr);														$this->mdl_common->insertShippingStatusforUpgread($userId, $incriptionList);
							$sponsorTotalBalance =  $this->mdl_common->getTotalBalance($value['sponsor_id']);					
							$totalreferralAmount= $sponsorTotalBalance + $referralAmount1;
							$updattotalarr = array(
								'total_balance'=>$totalreferralAmount,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
							
							$insertReferralBonus = array(
									'parent_id'=>$value['sponsor_id'],
									'user_id'=>$userId,
									'referral_bonus'=>$referralAmount1,
								);
							$this->db->insert('referral_bonus',$insertReferralBonus);

							//Earning Details in one table	
							$earning_details_by_user = array(
									'user_id'=>$value['sponsor_id'],
									'ref_id'=>$userId,
									'description'=>'Upgrade Referral amount from .'.$value['user_name'],
									'amount'=>$referralAmount1,
									//'message'=>"",
									//'e_d_b_u_date'=>$value['created_at'],
								);
							$this->db->insert('earning_details_by_user',$earning_details_by_user);
							//end

							$card_insert = array(
								'user_id'=>$userId,
								'package'=>$_POST['incriptionList'],
								'ammount'=>$amount,
								'name_on_card'=>$_POST['name_on_card'],
								'card_no'=>$_POST['card_no'],
								'expiry_date'=>$expiry_year,
								'cvv_no'=>$_POST['cvv_no'],
								'transaction_id'=>$this->authorize_net->getTransactionId(),
								'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
							   );
							$this->db->insert('payment_info',$card_insert);
							if($value['level'] < 6){
								$levelUpdateArr = array('level'=>$incriptionList);
								$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
							}
							$referralAmount = $currentReferralAmmount;
							$updateEarningInfoArr = array(
									'total_amount'=>$currentAmount,
									'referrals_earning'=>$referralAmount,
								); 
							$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
							
							$updatePackageArr = array('package'=>$incriptionList);
							//$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
							
							$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
							$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
							$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
							

							$data = array('message'=>'Your Package Upgraded sucessfully! Transaction ID : '.$this->authorize_net->getTransactionId());
							echo json_encode($data);

						}else{
							$data = array('message'=>'This card is invalid!');
							echo json_encode($data);
						}
					}
				}
			}
		}else{
			$data = array('message'=>'You Cannot Downgrade your package!');
			echo json_encode($data);
		}
	}
	
	function upgradeUser1(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") + 1, date("d"), date("Y")));
		if(isset($_POST['user_name'])&&!empty($_POST['user_name'])){
			$user_name = $_POST['user_name'];
			$userId = $this->mdl_common->sponserID($_POST['user_name']);
			$packageId = $this->mdl_common->getPackageId($_POST['user_name']);
			$packageAmount = $this->mdl_common->planPrice($packageId);
			$existBinary = $this->mdl_common->packageBinaryPoint($packageId);
		}else{
			$user_name = "";
			$userId = 0;
			$packageId = 0;
			$packageAmount = 0;
			$existBinary = 0;
		}

		if(isset($_POST['incriptionList'])&&!empty($_POST['incriptionList'])){
			$incriptionList = $_POST['incriptionList'];
			$currentAmount = $this->mdl_common->planPrice($_POST['incriptionList']);
			$currentBinary = $this->mdl_common->packageBinaryPoint($_POST['incriptionList']);
			$currentReferralAmmount = $this->mdl_common->packageReferralAmount($_POST['incriptionList']);
		}else{
			$incriptionList = "";
			$currentAmount = 0;
			$currentBinary = 0;
			$currentReferralAmmount = 0;
		}
		if(isset($_POST['name_on_card'])&&!empty($_POST['name_on_card'])){
			$name_on_card = $_POST['name_on_card'];
		}else{
			$name_on_card = "";
		}
		if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
			$card_no = $_POST['card_no'];
		}else{
			$card_no = "";
		}
		if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
			$expiry_month = $_POST['expiry_month'];
		}else{
			$expiry_month = "";
		}
		if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
			$expiry_year = $_POST['expiry_year'];
		}else{
			$expiry_year = "";
		}
		if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
			$cvv_no = $_POST['cvv_no'];
		}else{
			$cvv_no = "";
		}
		if(isset($_POST['billing_zip'])&&!empty($_POST['billing_zip'])){
			$billing_zip = $_POST['billing_zip'];
		}else{
			$billing_zip = "";
		}
		if($userId > 0 && $currentAmount > 0 && $packageId > 0 && $incriptionList > $packageId){
			$voucherUser = count($this->mdl_common->allSelects('SELECT * From voucher_details WHERE user_id='.$userId));
			$cardPayment = count($this->mdl_common->allSelects('SELECT * From payment_info WHERE user_id='.$userId));
			$amount = $currentAmount - $packageAmount;
			$binary_point = $currentBinary - $existBinary;
			if((!empty($voucherUser) && $voucherUser > 0)&& (empty($cardPayment) && $cardPayment == 0)){
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						//AIM payment Method
						$this->load->library('authorize_net');

						$auth_net = array(
							'x_card_num'			=> trim($_POST['card_no']), // Visa
							'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
							'x_card_code'			=> trim($_POST['cvv_no']),
							'x_description'			=> 'Onlegacy Network transaction',
							'x_amount'				=> trim($amount),
							'x_first_name'			=> $value['first_name'],
							'x_last_name'			=> $value['last_name'],
							'x_address'				=> $value['address1'].''.$value['address2'],
							'x_city'				=> $value['city'],
							'x_state'				=> $value['state'],
							'x_zip'					=> $value['zip'],
							'x_country'				=> $value['country'],
							'x_phone'				=> trim($value['contact_no']),
							'x_email'				=> $value['user_email'],
							'x_customer_ip'			=> $this->input->ip_address(),
						);

						$this->authorize_net->setData($auth_net);

						//ARB payment method
						$this->load->library('authorize_arb');

						// Start with a create object
						$this->authorize_arb->startData('create');

						$refId = substr(md5( microtime() . 'ref' ), 0, 20);
						$this->authorize_arb->addData('refId', $refId);
						$total_amt = $amount;
						$subscription_data = array(			
							'name' => $_POST['name_on_card'].'Upgrade Onlegacy Subscription',
							'paymentSchedule' => array(
								'interval' => array(
									'length' => 1,
									'unit' => 'months',
									),
								'startDate' => $recurringStartDate,
								'totalOccurrences' => 9999,
								'trialOccurrences' => 1,
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
								'firstName' => $value['user_name'],
								'lastName' => $value['last_name'],				
								),
						);
				
						$this->authorize_arb->addData('subscription', $subscription_data);
						
						if( $this->authorize_arb->send() && $this->authorize_net->authorizeAndCapture() ){
							$insertArr = array(
									'user_id'=>$userId,
									'package_id'=>$_POST['incriptionList'],
									'amount'=>$amount,
									'binary_point'=>$binary_point,
									'name_on_card'=>$_POST['name_on_card'],
									'card_no'=>$_POST['card_no'],
									'ref_id'=>$refId,
									'transaction_id'=>$this->authorize_net->getTransactionId(),
									'subscription_id'=>$this->authorize_arb->getId(),
								);
							$this->db->insert('upgrade_user_details',$insertArr);
													
							$totalreferralAmount= $value['total_balance'] + $amount;
							$updattotalarr = array(
								'total_balance'=>$totalreferralAmount,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
							
							$card_insert = array(
								'user_id'=>$userId,
								'package'=>$_POST['incriptionList'],
								'ammount'=>$amount,
								'name_on_card'=>$_POST['name_on_card'],
								'card_no'=>$_POST['card_no'],
								'expiry_date'=>$expiry_year,
								'cvv_no'=>$_POST['cvv_no'],
								'transaction_id'=>$this->authorize_net->getTransactionId(),
								'transaction_arb_id'=>$this->authorize_arb->getId(),
								'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
								'ref_id'=>$refId,
							   );
							$this->db->insert('payment_info',$card_insert);
							if($value['level'] < 6){
								$levelUpdateArr = array('level'=>$incriptionList);
								$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
							}

							$referralAmount = $currentReferralAmmount;
							$updateEarningInfoArr = array(
									'total_amount'=>$currentAmount,
									'referrals_earning'=>$referralAmount,
								);
							$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
							
							$updatePackageArr = array('package'=>$incriptionList);
							$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
										
							$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
							$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
							$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
							

							$data = array('message'=>'Your Package Upgraded sucessfully!');
							echo json_encode($data);
						}else{
							$data = array('message'=>'This card is invalid! ');
							echo json_encode($data);
						}						
					}
				}
			}else{
				$existUserDetail = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id='.$userId);
				if(isset($existUserDetail) && !empty($existUserDetail)){
					foreach ($existUserDetail as $key => $value) {
						//AIM payment Method
						$this->load->library('authorize_net');

						$auth_net = array(
							'x_card_num'			=> trim($_POST['card_no']), // Visa
							'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
							'x_card_code'			=> trim($_POST['cvv_no']),
							'x_description'			=> 'Onlegacy Network transaction',
							'x_amount'				=> trim($amount),
							'x_first_name'			=> $value['first_name'],
							'x_last_name'			=> $value['last_name'],
							'x_address'				=> $value['address1'].''.$value['address2'],
							'x_city'				=> $value['city'],
							'x_state'				=> $value['state'],
							'x_zip'					=> $value['zip'],
							'x_country'				=> $value['country'],
							'x_phone'				=> trim($value['contact_no']),
							'x_email'				=> $value['user_email'],
							'x_customer_ip'			=> $this->input->ip_address(),
						);

						$this->authorize_net->setData($auth_net);
						if($this->authorize_net->authorizeAndCapture()){
							$insertArr = array(
									'user_id'=>$userId,
									'package_id'=>$_POST['incriptionList'],
									'amount'=>$amount,
									'binary_point'=>$binary_point,
									'name_on_card'=>$_POST['name_on_card'],
									'card_no'=>$_POST['card_no'],
									'transaction_id'=>$this->authorize_net->getTransactionId(),
								);
							$this->db->insert('upgrade_user_details',$insertArr);
													
							$totalreferralAmount= $value['total_balance'] + $amount;
							$updattotalarr = array(
								'total_balance'=>$totalreferralAmount,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['sponsor_id']));
							
							$card_insert = array(
								'user_id'=>$userId,
								'package'=>$_POST['incriptionList'],
								'ammount'=>$amount,
								'name_on_card'=>$_POST['name_on_card'],
								'card_no'=>$_POST['card_no'],
								'expiry_date'=>$expiry_year,
								'cvv_no'=>$_POST['cvv_no'],
								'transaction_id'=>$this->authorize_net->getTransactionId(),
								'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
							   );
							$this->db->insert('payment_info',$card_insert);
							if($value['level'] < 6){
								$levelUpdateArr = array('level'=>$incriptionList);
								$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
							}
							$referralAmount = $currentReferralAmmount;
							$updateEarningInfoArr = array(
									'total_amount'=>$currentAmount,
									'referrals_earning'=>$referralAmount,
								); 
							$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
							
							$updatePackageArr = array('package'=>$incriptionList);
							$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
							
							$this->insertPoint($value['parent_id'],$value['sponsor_id'],$binary_point,$userId);
							$this->getSponsorToSponsorQV($value['sponsor_id'],$binary_point,$userId);
							$this->getParentToParentReferralBinary($value['parent_id'],$binary_point,$userId);
							

							$data = array('message'=>'Your Package Upgraded sucessfully! Transaction ID : '.$this->authorize_net->getTransactionId());
							echo json_encode($data);

						}else{
							$data = array('message'=>'This card is invalid!');
							echo json_encode($data);
						}
					}
				}
			}
		}else{
			$data = array('message'=>'You Cannot Downgrade your package!');
			echo json_encode($data);
		}
	}

	function insertPoint($parentId,$sponser,$binaryPoint,$last_id){
		$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point from earning_info where user_id = '.$parentId);
				
		if(isset($selectearningtotal) && !empty($selectearningtotal)){
			foreach ($selectearningtotal as $total) {						
				$totalBinaryPoint = $total['referral_binary_point'] + $binaryPoint;
				$updattotalarr = array(
					'referral_binary_point'=>$totalBinaryPoint,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentId));
			}
		}else{
			$totalBinaryPoint = $binaryPoint;
			$updattotalarr = array(
				'referral_binary_point'=>$totalBinaryPoint
			);
			$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentId));
		}
		
		$insertBinamry = array(
				'parent_id'=>$parentId,
				'user_id'=>$last_id,
				'referral_binary'=>$binaryPoint
			);
		$this->db->insert('referrals_binary',$insertBinamry);
		
		$insertBinamry = array(
			'sponsor_id'=>$sponser,
			'user_id'=>$last_id,
			'qv_point'=>$binaryPoint
		);
		$this->db->insert('unilevel_binary_info',$insertBinamry);
	}

	function getParentToParentReferralBinary($parntUser,$binaryPoint,$childUser){
		$parent = $this->mdl_common->getAllParent($parntUser);
		$user = $this->mdl_common->getAllParent($childUser);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){				
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

	function getSponsorToSponsorQV($parntUser,$binaryPoint,$childUser){
		$parent = $this->mdl_common->getAllSponsor($parntUser);
		$user = $this->mdl_common->getAllSponsor($childUser);
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
	function upgradeUserList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT  DISTINCT  a.*, b.*, c.*, d.*, e.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id RIGHT JOIN upgrade_user_details as c on c.user_id=a.user_id LEFT JOIN package_info as d on d.package_id=c.package_id LEFT JOIN level_configuration as e on e.l_conf_id=b.level');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}
	
	function cancelSubscription(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userId = $this->mdl_common->getUserId($_POST['user_name']);
		$subscription_id = $this->mdl_common->getSubscriptionId($userId);
		if(isset($_POST['user_name']) && !empty($_POST['user_name']) && $userId > 1){
			if(!empty($subscription_id) && $subscription_id != null){
				// Load the ARB lib
				$this->load->library('authorize_arb');
				
				// Start with a cancel object
				$this->authorize_arb->startData('cancel');
				
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				$this->authorize_arb->addData('subscriptionId', $subscription_id);
				
				if( $this->authorize_arb->send() ){
					$insertCancleSubArr = array(
							'user_id'=>$userId,
							'subscription_id'=>$subscription_id
						);
					$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
					$cancle_last_id =  $this->db->insert_id();

					$cancleUpdateArr = array(
							'sub_status'=>'inactive'
						);

					$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
					$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
					
					$canclationRefId = $this->authorize_arb->getRefId();
					$updateCancleSubRefIdArr = array('ref_id'=>$canclationRefId);
					$this->db->update('cancle_subscription_info', $canclationRefId, array('c_s_id'=>$cancle_last_id));
					$data = array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getRefId());
					echo json_encode($data);
				}else{
					$data = array('message'=>'Cancelation Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}			
			}else{
				$insertCancleSubArr = array(
						'user_id'=>$userId,
					);
				$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
				$cancle_last_id =  $this->db->insert_id();

				$cancleUpdateArr = array(
						'sub_status'=>'inactive'
					);

				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
				$data = array('message'=>'This User : '.$_POST['user_name'].'  have no any active subscription & Account is deactivated!');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'This User Name field is cannot be empty!');
			echo json_encode($data);
		}
	}
	
	function cancelUserSubscription(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userId = $_POST['user_id'];
		$subscription_id = $this->mdl_common->getSubscriptionId($userId);
		$userName = $_POST['user_name'];
		if(isset($_POST['user_id']) && !empty($_POST['user_id']) && $userId > 1 && !empty($userName) && $userName != null){
			if(!empty($subscription_id) && $subscription_id != null){
				// Load the ARB lib
				$this->load->library('authorize_arb');
			
				// Start with a cancel object
				$this->authorize_arb->startData('cancel');
				
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				
				$this->authorize_arb->addData('subscriptionId', $subscription_id);
				
				if( $this->authorize_arb->send() ){
					$insertCancleSubArr = array(
							'user_id'=>$userId,
							'subscription_id'=>$subscription_id
						);
					$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
					$cancle_last_id =  $this->db->insert_id();

					$cancleUpdateArr = array(
							'sub_status'=>'inactive'
						);

					$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
					$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
					
					$canclationRefId = $this->authorize_arb->getRefId();
					$updateCancleSubRefIdArr = array('ref_id'=>$canclationRefId);
					$this->db->update('cancle_subscription_info', $canclationRefId, array('c_s_id'=>$cancle_last_id));
					$data = array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getRefId());
					echo json_encode($data);
				}else{
					$data = array('message'=>'Cancelation Fail!' . $this->authorize_arb->getError());
					echo json_encode($data);
				}			
			}else{
				$insertCancleSubArr = array(
						'user_id'=>$userId,
					);
				$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
				$cancle_last_id =  $this->db->insert_id();

				$cancleUpdateArr = array(
						'sub_status'=>'inactive'
					);

				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
				$data = array('message'=>'You have no any active subscription & Your Account is deactivated!');
				echo json_encode($data);
			}			
		}else{
			$data = array('message'=>'This User name  field is cannot be empty!');
			echo json_encode($data);
		}
	}
	
	function cancelSubscription1(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userId = $this->mdl_common->getUserId($_POST['user_name']);
		$subscription_id = $this->mdl_common->getSubscriptionId($userId);
		if(isset($_POST['user_name']) && !empty($_POST['user_name']) && $userId > 1 && !empty($subscription_id) && $subscription_id != null){
			// Load the ARB lib
			$this->load->library('authorize_arb');
			
			// Start with a cancel object
			$this->authorize_arb->startData('cancel');
			
			$refId = substr(md5( microtime() . 'ref' ), 0, 20);
			$this->authorize_arb->addData('refId', $refId);
			
			$this->authorize_arb->addData('subscriptionId', $subscription_id);
			
			if( $this->authorize_arb->send() ){
				$insertCancleSubArr = array(
						'user_id'=>$userId,
						'subscription_id'=>$subscription_id
					);
				$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
				$cancle_last_id =  $this->db->insert_id();

				$cancleUpdateArr = array(
						'sub_status'=>'inactive'
					);

				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
				
				$canclationRefId = $this->authorize_arb->getRefId();
				$updateCancleSubRefIdArr = array('ref_id'=>$canclationRefId);
				$this->db->update('cancle_subscription_info', $canclationRefId, array('c_s_id'=>$cancle_last_id));
				$data = array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getRefId());
				echo json_encode($data);
			}else{
				$data = array('message'=>'Cancelation Fail!' . $this->authorize_arb->getError());
				echo json_encode($data);
			}			
		}else{
			$data = array('message'=>'This User have no any active SUSCRIPTION!');
			echo json_encode($data);
		}
	}
	
	function cancelUserSubscription1(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userId = $_POST['user_id'];
		$subscription_id = $this->mdl_common->getSubscriptionId($userId);
		//echo json_encode($subscription_id);exit;
		if(isset($_POST['user_id']) && !empty($_POST['user_id']) && $userId > 1 && !empty($subscription_id) && $subscription_id != null){
			// Load the ARB lib
			$this->load->library('authorize_arb');
			
			// Start with a cancel object
			$this->authorize_arb->startData('cancel');
			
			$refId = substr(md5( microtime() . 'ref' ), 0, 20);
			$this->authorize_arb->addData('refId', $refId);
			
			$this->authorize_arb->addData('subscriptionId', $subscription_id);
			
			if( $this->authorize_arb->send() ){
				$insertCancleSubArr = array(
						'user_id'=>$userId,
						'subscription_id'=>$subscription_id
					);
				$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
				$cancle_last_id =  $this->db->insert_id();

				$cancleUpdateArr = array(
						'sub_status'=>'inactive'
					);

				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				$this->db->update('user_master',array('user_status'=>'inactive'),array('user_id'=>$userId));
				
				$canclationRefId = $this->authorize_arb->getRefId();
				$updateCancleSubRefIdArr = array('ref_id'=>$canclationRefId);
				$this->db->update('cancle_subscription_info', $canclationRefId, array('c_s_id'=>$cancle_last_id));
				$data = array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getRefId());
				echo json_encode($data);
			}else{
				$data = array('message'=>'Cancelation Fail!' . $this->authorize_arb->getError());
				echo json_encode($data);
			}			
		}else{
			$data = array('message'=>'You have no any active SUSCRIPTION!');
			echo json_encode($data);
		}
	}
	
	function activateSubscription(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);

		$userId = $this->mdl_common->getUserId($_POST['user_name']);
		if(isset($_POST['user_name']) && !empty($_POST['user_name']) && $userId > 0){
			$subscription_id = $this->mdl_common->getReactivateSubscriptionId($userId);
			$inactiveSub_ID = $this->mdl_common->getInactiveSubscriptionId($userId);
			if(!empty($subscription_id)){
				$this->load->library('authorize_arb');
				//AIM payment Method
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'Onlegacy Network  transaction',
					'x_amount'				=> 1,
					'x_first_name'			=>  $_POST['user_name'],
					'x_last_name'			=>  $_POST['user_name'],
					'x_customer_ip'			=> $this->input->ip_address(),
				);

				$this->authorize_net->setData($auth_net);

				//ARB payment method		
				// Start with an update object
				$this->authorize_arb->startData('update');
				// Locally-defined reference ID (can't be longer than 20 chars)
				$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				$this->authorize_arb->addData('refId', $refId);
				$this->authorize_arb->addData('subscriptionId', $subscription_id);
				
				// The subscription ID that we're editing
				//$this->authorize_arb->addData('subscriptionId', $subscription_id);
				$amount = 29.00;
				$subscription_data = array(			
					'name' => $_POST['name_on_card'].'Updated Onlegacy Subscription',
					'paymentSchedule' => array(
						'totalOccurrences' => 9999,
						'trialOccurrences' => 1,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => $_POST['card_no'],
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => $_POST['cvv_no'],
							),
						),			
					'billTo' => array(
						'firstName' => $_POST['user_name'],
						'lastName' => $_POST['user_name'],				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);
				
				// Send request
				if( $this->authorize_arb->send() && $this->authorize_net->authorizeAndCapture()){
					$insertReactivationArr = array(
							'user_id'=>$userId,
							'subscription_id'=>$subscription_id,
							'old_subscription_id'=>$subscription_id,
							'name_on_card'=>$_POST['name_on_card'],
							'card_no'=>$_POST['card_no'],
							'expiry_date'=>$_POST['expiry_month'].'-'.$_POST['expiry_year'],
							'ref_id'=>$refId,
							're_sub_amount'=>$amount,
						);
					$this->db->insert('reactivation_info',$insertReactivationArr);

					$this->db->update('user_master',array('user_status'=>'active'),array('user_id'=>$userId));
					$this->db->update('payment_info',array('transaction_id'=>$this->authorize_net->getTransactionId(),'transaction_aim_id'=>$this->authorize_net->getTransactionId(),'transaction_arb_id'=>$subscription_id,'sub_status'=>'active'),array('user_id'=>$userId));
					
					$this->session->set_userdata('user_status','active');

					$data =  array('message'=>'This user Suscription Update  is Success! Ref ID: ' . $subscription_id.', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Suscription Update is Fail!' . $this->authorize_arb->getError().', Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);
				}
				//$data =  array('message'=>'This user SUSCRIPTION is already Active');
				//echo json_encode($data);
			}elseif($inactiveSub_ID){
				//AIM payment Method
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'Onlegacy Network  transaction',
					'x_amount'				=> 1,
					'x_first_name'			=>  $_POST['user_name'],
					'x_last_name'			=>  $_POST['user_name'],
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
					'name' => $_POST['name_on_card'].'Updated Onlegacy SUSCRIPTION',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => date('Y-m-d'),
						'totalOccurrences' => 9999,
						'trialOccurrences' => 1,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => $_POST['card_no'],
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => $_POST['cvv_no'],
							),
						),			
					'billTo' => array(
						'firstName' => $_POST['user_name'],
						'lastName' => $_POST['user_name'],				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);
				
				// Send request
				if( $this->authorize_arb->send() && $this->authorize_net->authorizeAndCapture()){
					$insertReactivationArr = array(
							'user_id'=>$userId,
							'subscription_id'=>$this->authorize_arb->getId(),
							'old_subscription_id'=>$subscription_id,
							'name_on_card'=>$_POST['name_on_card'],
							'card_no'=>$_POST['card_no'],
							'expiry_date'=>$_POST['expiry_month'].'-'.$_POST['expiry_year'],
							'ref_id'=>$refId,
							're_sub_amount'=>$amount,
						);
					$this->db->insert('reactivation_info',$insertReactivationArr);

					$this->db->update('user_master',array('user_status'=>'active'),array('user_id'=>$userId));
					$this->db->update('payment_info',array('transaction_id'=>$this->authorize_net->getTransactionId(),'transaction_aim_id'=>$this->authorize_net->getTransactionId(),'transaction_arb_id'=>$this->authorize_arb->getId(),'sub_status'=>'active'),array('user_id'=>$userId));
					
					$this->session->set_userdata('user_status','active');

					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError().', Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);
				}
			}else{
				//AIM payment Method
				$this->load->library('authorize_net');

				$auth_net = array(
					'x_card_num'			=> trim($_POST['card_no']), // Visa
					'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
					'x_card_code'			=> trim($_POST['cvv_no']),
					'x_description'			=> 'Onlegacy Network  transaction',
					'x_amount'				=> 1,
					'x_first_name'			=>  $_POST['user_name'],
					'x_last_name'			=>  $_POST['user_name'],
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
					'name' => $_POST['name_on_card'].'Updated Onlegacy Subscription',
					'paymentSchedule' => array(
						'interval' => array(
							'length' => 1,
							'unit' => 'months',
							),
						'startDate' => date('Y-m-d'),
						'totalOccurrences' => 9999,
						'trialOccurrences' => 1,
						),
					'amount' => $amount,
					'trialAmount' => 0,
					'payment' => array(
						'creditCard' => array(
							'cardNumber' => $_POST['card_no'],
							'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
							'cardCode' => $_POST['cvv_no'],
							),
						),			
					'billTo' => array(
						'firstName' => $_POST['user_name'],
						'lastName' => $_POST['user_name'],				
						),
				);
				
				$this->authorize_arb->addData('subscription', $subscription_data);
				
				// Send request
				if( $this->authorize_arb->send() && $this->authorize_net->authorizeAndCapture()){
					$insertReactivationArr = array(
							'user_id'=>$userId,
							'subscription_id'=>$this->authorize_arb->getId(),
							'old_subscription_id'=>$subscription_id,
							'name_on_card'=>$_POST['name_on_card'],
							'card_no'=>$_POST['card_no'],
							'expiry_date'=>$_POST['expiry_month'].'-'.$_POST['expiry_year'],
							'ref_id'=>$refId,
							're_sub_amount'=>$amount,
						);
					$this->db->insert('reactivation_info',$insertReactivationArr);

					$this->db->insert('payment_info',array(
													'user_id'=>$userId,
													'ammount'=>$amount,
													'name_on_card'=>$_POST['name_on_card'],
													'card_no'=>$_POST['card_no'],
													'cvv_no'=>$_POST['cvv_no'],
													'transaction_id'=>$this->authorize_net->getTransactionId(),
													'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
													'transaction_arb_id'=>$this->authorize_arb->getId(),
													'ref_id'=>$refId,
													'sub_status'=>'active'
													)
					);
					$this->db->update('user_master',array('user_status'=>'active'),array('user_id'=>$userId));
					
					$this->session->set_userdata('user_status','active');

					$data =  array('message'=>'Success! Ref ID: ' . $this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId());
					echo json_encode($data);
				}else{
					$data =  array('message'=>'Fail!' . $this->authorize_arb->getError().', Transaction Error ID : '.$this->authorize_net->getError());
					echo json_encode($data);
				}
			}
			
		}else{
			$data = array('message'=>'This is an Invalid user!');
			echo json_encode($data);
		}
	}
	
	function cancelUserSubscriptionList(){
		header('Content-Type: application/json');
		$sponser = $this->session->userdata('user_id');
		if(isset($sponser) && !empty($sponser)){
			$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=a.package RIGHT JOIN payment_info as d on d.user_id=a.user_id WHERE  a.user_status = "inactive" and a.sponsor_id='.$sponser);
			if(isset($getPackage) && !empty($getPackage)){
				foreach ($getPackage as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);			
			}else{

			}			
		}
	}
	
	function cancelSubscriptionList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level RIGHT JOIN payment_info as d on d.user_id=a.user_id WHERE  a.user_status = "inactive"');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}
	
	function activeSuscriptionList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=a.package RIGHT JOIN payment_info as d on d.user_id=a.user_id');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}

	function notSusUserList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_master.user_id NOT IN (SELECT user_id FROM payment_info)');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}

}