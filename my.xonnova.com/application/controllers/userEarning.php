<?php
/**
* 
*/
class UserEarning extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getEarning(){
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id where a.user_id='.$this->session->userdata('user_id'));
		foreach ($contentData as $value) {
			$arr[]=$value;
		}
		echo json_encode($arr);
	}

	function getEarningsById($id){
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id where b.sponser_id='.$id);
		foreach ($contentData as $value) {
			$arr[]=$value;
		}
		echo json_encode($arr);
	}

	function getTotalBanlance($id){
		$contentData = $this->mdl_common->allSelects('SELECT * from earning_info where user_id='.$id);
		foreach ($contentData as $value) {
			$arr[]=$value;
		}
		echo json_encode($arr);
	}

	function getRewardPoint(){
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id where a.user_id='.$this->session->userdata('user_id'));
		foreach ($contentData as $value) {
			$arr[]=$value;
		}
		echo json_encode($arr);
	}
	function getleftBinary($id){
		$userId = $id;

		$lftChild = $this->mdl_common->leftChild($userId);
		

		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary - $totalLeftDeductBinary;

		
		echo json_encode($leftUserTotal);
	}
	function getrightBinary($id){
		$userId = $id;

		$rghtChild = $this->mdl_common->rightChild($userId);

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary - $totalRightDeductBinary;
			
	
		echo json_encode($rightUserTotal);
	}

	function getReferralBonus($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(referral_bonus) as total from referral_bonus where parent_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}
	function getProductBonus($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(sale_bonus) as total from product_sale_bonus where user_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}
}