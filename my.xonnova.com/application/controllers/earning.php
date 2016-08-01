<?php 
/**
* 
*/
class Earning extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getEarning(){
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id');
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

	function getReferralBinaryList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT DISTINCT a.*,b.referral_binary as rbv, b.created_at as rdate from user_master as a LEFT JOIN referrals_binary as b on b.user_id=a.user_id  where a.parent_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getReferralBonusList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT DISTINCT a.*,b.* from user_master as a LEFT JOIN referral_bonus as b on b.user_id=a.user_id where a.sponsor_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getProductBonusList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT a.*, b.* from user_master as a LEFT JOIN  product_sale_bonus as b on b.user_id=a.user_id where b.user_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getRewardBonusList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT a.*, b.* from user_master as a LEFT JOIN  cron_job_qv_info as b on b.user_id=a.user_id where b.parent_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getCreditBonusList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT a.*, b.* from user_master as a LEFT JOIN  add_credit as b on b.user_id=a.user_id where b.user_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getdeductBonusList($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT a.*, b.* from user_master as a LEFT JOIN  deduct_credit as b on b.user_id=a.user_id where b.user_id='.$id);
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

	function getRewardBonus($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(ammount) as total from binary_deduction where parent_id='.$id);
		if(!empty($total)){
			foreach ($total as $value) {
				$total = $value['total']/2;
				//$arr = '{"total":"'.$total.'"}';
				echo json_encode($total);
			}		
		}else{
			
		}
	}

	function getCreditBonus($id){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(credit) as total from add_credit where user_id='.$id);
		if(!empty($total)){
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
			
		}
	}

	function getDeductBonus($id){
		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(credit) as binary_point FROM deduct_credit where user_id='.$id);
		
		echo json_encode($totalRightDeductBinary);
	}
}