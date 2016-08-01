<?php

/**
* 
*/
class UserLoginStatus extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}

	function cancelSubscriptionList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level RIGHT JOIN payment_info as d on d.user_id=a.user_id WHERE  a.user_status = "inactive"AND a.login_status = "inactive"');
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

		if(isset($_POST['admin_password']) && !empty($_POST['admin_password'])){
		}else{
			$data = array("message"=>"Password field is required !");
			echo json_encode($data);
			return  ;

		}

		if($_POST['admin_password'] == "0nL3gacyvision2020!"){
		}else{
			$data = array("message"=>"Password is worng !");
			echo json_encode($data);
			return  ;

		}

		
		$userId = $this->mdl_common->getUserId($_POST['user_name']);
		$userStatus = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE login_status="active" AND user_name="'.$_POST['user_name'].'"'));
		if(!empty($_POST['user_name']) && $userId > 1 && !empty($userStatus)){
				$sponser = $this->mdl_common->getAllSponsor($userId);
				$packageId = $this->mdl_common->getPackageId($_POST['user_name']);
				$currency = $this->mdl_common->sponsorCountry($sponser);
				$userCurrency = $this->mdl_common->sponsorCountry($userId);
				
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					//$packageReferralAmount = $this->mdl_common->packageReferralAmount($packageId);
				}else{
					//$packageReferralAmount = 0;
				}
				//for deduct call onlegacy_mdl
				$packageReferralAmount = $this->onlegacy_mdl->packageReferralAmount($packageId,$currency,$userCurrency);
				//for deduct call onlegacy_mdl
				$binaryPoint = $this->onlegacy_mdl->packageBinaryPoint($packageId,$userCurrency);
				//for deduct call onlegacy_mdl
				$QvPoint = $this->onlegacy_mdl->packageQVPoint($packageId,$currency);
				$parentUser = $this->mdl_common->getAllParent($userId);

				$insertCancleSubArr = array(
						'user_id'=>$userId,
					);
				$this->db->insert('cancle_subscription_info', $insertCancleSubArr);
				$cancle_last_id =  $this->db->insert_id();

				$cancleUpdateArr = array('sub_status'=>'inactive');
				// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
				// if(isset($selectearningtotal) && !empty($selectearningtotal)){
				// 	foreach ($selectearningtotal as $total) {						
				// 		$x = $total['total_balance'] - $packageReferralAmount;
				// 		$updattotalarr = array(
				// 			'total_balance'=>$x,
				// 		);
				// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				// 	}
				// }else{
				// 	$x = 0 - $packageReferralAmount;
				// 	$updattotalarr = array(
				// 		'total_balance'=>$x,
				// 	);
				// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				// }
				$incriptionList = 1 ;
				if(!empty($parentUser)){
					$this->deductParentToParentReferralBinary($packageId,$incriptionList,$userId);
				}
				$this->getSponsorToSponsorQV($packageId,$incriptionList,$userId);
				//Earning Details in one table	
				// $earning_details_by_user = array(
				// 		'user_id'=>$sponser,
				// 		'ref_id'=>$userId,
				// 		'type_id'=>'1',
				// 		'description'=>'Cancelled Referral amount from '.$_POST['user_name'],
				// 		'amount'=> -$packageReferralAmount,
				// 		'current_balance'=>$this->mdl_common->getTotalBalance($sponser),
				// 	);
				// $this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end

				////bonus 2
				//$this->mdl_common->insertCancelledMentorBonusAmount($userId, $userId, $packageReferralAmount);
				////bonus 3
				$this->mdl_common->insertCancelledMentorBonusAmount($sponser, $userId, $packageReferralAmount);
				$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($packageId) - $this->mdl_common->packageLeadershipAmount($incriptionList);
				$this->mdl_common->insertCancelledLeadershipBonus($sponser, $userId, $LeadershipAmount, 0);
				//$this->mdl_common->insertCancelledLeadershipBonus($userId, $userId, $LeadershipAmount, 0);
				////bonus 5

				$sponserId = $this->mdl_common->getAllParent($userId);
		    	$amount = $this->mdl_common->matrix_bonus_amount($packageId) - $this->mdl_common->matrix_bonus_amount($incriptionList);
		    	$level = $this->mdl_common->matrix_bonus_level($packageId);
		    	$count = 0;
				if($sponserId > 1){
					$this->mdl_common->cancelledMatrixBonus($sponserId, $amount, $level, $count, $userId);
				}

				
				$this->db->update('shipping_management_table',array('shipping_show_status'=>'2'),array('user_id'=>$userId));
				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				$this->db->update('user_master',array('subscription_status'=>'inactive','user_status'=>'inactive','login_status'=>'inactive'),array('user_id'=>$userId));
				$this->db->update('user_master',array('sponsor_id'=>$sponser),array('sponsor_id'=>$userId));
				$this->db->update('earning_info',array('sponser_id'=>$sponser),array('sponser_id'=>$userId));
				
				$data = array('message'=>'User : '.$_POST['user_name'].' Account Cancelled Successfully');
				echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry This is an invalid user!');
			echo json_encode($data);
		}
	}


	function deductParentToParentReferralBinary($packageId,$incriptionList,$childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllParent($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){
				$currency = $this->mdl_common->sponsorCountry($sponser);
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv > 1){
					if(!empty($currency) && $currency == "MEX"){
						//for deduct call onlegacy_mdl
						$binaryPoint = $this->onlegacy_mdl->packageBinaryPoint($packageId,$currency) - $this->onlegacy_mdl->packageBinaryPoint($incriptionList,$currency);
					}else{
						//for deduct call onlegacy_mdl
						$binaryPoint = $this->onlegacy_mdl->packageBinaryPoint($packageId,$currency) - $this->onlegacy_mdl->packageBinaryPoint($incriptionList,$currency);
					}
				}else{
					$binaryPoint = 0;
				}	
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point from earning_info where user_id = '.$sponser);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$totalBinaryPoint = $total['referral_binary_point'] - $binaryPoint;
							$updattotalarr = array(
								'referral_binary_point'=>$totalBinaryPoint,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						}
					}else{
						$totalBinaryPoint = 0 - $binaryPoint;
						$updattotalarr = array(
							'referral_binary_point'=>$totalBinaryPoint,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					}

					$insertRichtBinamry1 = array(
							'parent_id'=>$parent,
							'user_id'=>$user,
							'binary_point'=>$binaryPoint,
							//'ammount'=>$totalAmount1,
						);

					$this->db->insert('binary_deduction',$insertRichtBinamry1);
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$user = $this->mdl_common->getAllParent($user);
		}
	}
	
	function getSponsorToSponsorQV($packageId,$incriptionList,$childUser){
		$parent = $this->mdl_common->getAllSponsor($childUser);
		$user = $childUser;
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){
				$currency = $this->mdl_common->sponsorCountry($sponser);
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv > 1){
					if(!empty($currency) && $currency == "MEX"){
						//for deduct call onlegacy_mdl
						$QvPoint = $this->onlegacy_mdl->packageQVPoint($packageId,$currency) - $this->onlegacy_mdl->packageQVPoint($incriptionList,$currency);
					}else{
						//for deduct call onlegacy_mdl
						$QvPoint = $this->onlegacy_mdl->packageQVPoint($packageId,$currency) - $this->onlegacy_mdl->packageQVPoint($incriptionList,$currency);
					}
				}else{
					$QvPoint = 0;
				}
				$x = 0 - $QvPoint;
				$insertBinamry = array(
						'sponsor_id'=>$sponser,
						'user_id'=>$user,
						'qv_point'=>$x
					);
				$this->db->insert('unilevel_binary_info',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			$user = $this->mdl_common->getAllSponsor($user);
		}
	}


	function cancelUpgradeList(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.user_name FROM cancle_upgrade_info as a LEFT JOIN user_master as b on b.user_id=a.user_id');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{

		}
	}


	function cancelUpgrade(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['admin_password']) && !empty($_POST['admin_password'])){
		}else{
			$data = array("message"=>"Password field is required !");
			echo json_encode($data);
			return  ;

		}

		if($_POST['admin_password'] == "0nL3gacyvision2020!"){
		}else{
			$data = array("message"=>"Password is worng !");
			echo json_encode($data);
			return  ;

		}


		$userId = $this->mdl_common->getUserId($_POST['user_name']);
		$sponser = $this->mdl_common->getAllSponsor($userId);
		$packageId = $this->mdl_common->getPackageId($_POST['user_name']);
		$currency = $this->mdl_common->sponsorCountry($sponser);
		$userCurrency = $this->mdl_common->sponsorCountry($userId);
		$packageAmount = $this->mdl_common->planPrice($packageId,$userCurrency);

		$incriptionList = 1 ;
		$currentAmount = $this->mdl_common->planPrice($incriptionList,$userCurrency);
		//for deduct call onlegacy_mdl
		$referralAmount =  $this->onlegacy_mdl->packageReferralAmount($incriptionList,$currency,$userCurrency);
		
		$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
		if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
			//$packageReferralAmount = $this->mdl_common->packageReferralAmount($packageId) - $this->mdl_common->packageReferralAmount($incriptionList);//live
		}else{
			//$packageReferralAmount = 0;
		}
		//for deduct call onlegacy_mdl
		$packageReferralAmount = $this->onlegacy_mdl->packageReferralAmount($packageId,$currency,$userCurrency) - $this->onlegacy_mdl->packageReferralAmount($incriptionList,$currency,$userCurrency);//live
		//for deduct call onlegacy_mdl
		$binaryPoint = $this->onlegacy_mdl->packageBinaryPoint($packageId,$userCurrency) - $this->onlegacy_mdl->packageBinaryPoint($incriptionList,$userCurrency);
		//for deduct call onlegacy_mdl
		$QvPoint = $this->onlegacy_mdl->packageQVPoint($packageId,$currency) - $this->onlegacy_mdl->packageQVPoint($incriptionList,$currency);

		$parentUser = $this->mdl_common->getAllParent($userId);
		//$userStatus = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE login_status="active" AND user_name="'.$_POST['user_name'].'"'));
		if(!empty($_POST['user_name']) && $userId > 1 ){
				$insertCancleSubArr = array(
						'user_id'=>$userId,
					);
				$this->db->insert('cancle_upgrade_info', $insertCancleSubArr);
				//$cancle_last_id =  $this->db->insert_id();

				//$cancleUpdateArr = array('sub_status'=>'inactive');
				// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
				// if(isset($selectearningtotal) && !empty($selectearningtotal)){
				// 	foreach ($selectearningtotal as $total) {						
				// 		$x = $total['total_balance'] - $packageReferralAmount;
				// 		$updattotalarr = array(
				// 			'total_balance'=>$x,
				// 		);
				// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				// 	}
				// }else{
				// 	$x = 0 - $packageReferralAmount;
				// 	$updattotalarr = array(
				// 		'total_balance'=>$x,
				// 	);
				// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				// }
				if(!empty($parentUser)){
					$this->deductParentToParentReferralBinary($packageId,$incriptionList,$userId);
				}
				$this->getSponsorToSponsorQV($packageId,$incriptionList,$userId);
				
				//Earning Details in one table	
				// $earning_details_by_user = array(
				// 		'user_id'=>$sponser,
				// 		'ref_id'=>$userId,
				// 		'type_id'=>'1',
				// 		'description'=>'Cancelled Referral amount from '.$_POST['user_name'],
				// 		'amount'=> -$packageReferralAmount,
				// 		'current_balance'=>$this->mdl_common->getTotalBalance($sponser),
				// 	);
				// $this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end


				////bonus 2
				//$this->mdl_common->insertCancelledMentorBonusAmount($userId, $userId, $packageReferralAmount);
				////bonus 3
				$this->mdl_common->insertCancelledMentorBonusAmount($sponser, $userId, $packageReferralAmount);
				$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($packageId) - $this->mdl_common->packageLeadershipAmount($incriptionList);
				$this->mdl_common->insertCancelledLeadershipBonus($sponser, $userId, $LeadershipAmount, 0);
				//$this->mdl_common->insertCancelledLeadershipBonus($userId, $userId, $LeadershipAmount, 0);
				////bonus 5

				$sponserId = $this->mdl_common->getAllParent($userId);
		    	$amount = $this->mdl_common->matrix_bonus_amount($packageId) - $this->mdl_common->matrix_bonus_amount($incriptionList);
		    	$level = $this->mdl_common->matrix_bonus_level($packageId);
		    	$count = 0;
				if($sponserId > 1){
					$this->mdl_common->cancelledMatrixBonus($sponserId, $amount, $level, $count, $userId);
				}
				

				$userLevel = $this->mdl_common->getUserLevel($userId);
				if($userLevel < 6){
					$levelUpdateArr = array('level'=>$incriptionList);
					$this->db->update('earning_info',$levelUpdateArr, array('user_id'=>$userId));
				}

				//$referralAmount = $currentReferralAmmount;
				$updateEarningInfoArr = array(
						'total_amount'=>$currentAmount,
						'referrals_earning'=>$referralAmount,
					);
				$this->db->update('earning_info',$updateEarningInfoArr,array('user_id'=>$userId));
				
				$updatePackageArr = array('package'=>$incriptionList);
				$this->db->update('user_master',$updatePackageArr,array('user_id'=>$userId));
				$this->db->update('shipping_management_table',array('shipping_show_status'=>'2'),array('user_id'=>$userId));
				//$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
				//$this->db->update('user_master',array('package'=>$degradedPackageId),array('user_id'=>$userId));
				//$this->db->update('user_master',array('sponsor_id'=>$sponser),array('sponsor_id'=>$userId));
				//$this->db->update('earning_info',array('sponser_id'=>$degradedPackageId),array('user_id'=>$userId));
				
				$data = array('message'=>'This User : '.$_POST['user_name'].' Account is Degraded Sucessfully!');
				echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry This is an invalid user!');
			echo json_encode($data);
		}
	}
}