<?php
/**
* 
*/
class Earningreport extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	
	function entrepreneurialBonusByUser3(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN payment_info as b on b.user_id=a.user_id where b.transaction_arb_id != "" and a.sponsor_id ='.$this->session->userdata('user_id'));
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	

	function entrepreneurialBonusByUser4(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.* , b.* From voucher_details as a LEFT JOIN user_master as b on b.user_id=a.user_id  where b.sponsor_id ='.$this->session->userdata('user_id'));
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	function entrepreneurialBonusByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN payment_info as b on b.user_id=a.user_id where b.transaction_arb_id != "" and a.sponsor_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function entrepreneurialBonus(){
		header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN payment_info as b on b.user_id=a.user_id where b.transaction_arb_id != ""');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
	function entrepreneurialBonusByUser2($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.* , b.* From voucher_details as a LEFT JOIN user_master as b on b.user_id=a.user_id  where b.sponsor_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function entrepreneurialBonus2(){
		header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('SELECT a.* , b.* From voucher_details as a LEFT JOIN user_master as b on b.user_id=a.user_id');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	function index(){
		$this->getReferralEArningQuery();
		$this->getDeductEArningQuery();
		$this->getCreditEArningQuery();
		$this->getCronEArningQuery();
		$this->getModuleEArningQuery();
		$this->getProductEArningQuery();
		$this->getCashoutEArningQuery();
	}

	function getEarningReport(){
		$contentData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level,  b.referral_binary_point, b.total_balance FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getReferralEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM referral_bonus');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$earning_details_by_user = array(
						'user_id'=>$value['parent_id'],
						'ref_id'=>$value['user_id'],
						'description'=>'Referral amount',
						'amount'=>$value['referral_bonus'],
						'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
			}
		}else{

		}
	}

	function getReferralEArningQuery1(){
		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.* FROM user_master as a RIGHT JOIN  referral_bonus as b on b.parent_id=a.user_id WHERE a.user_id='.$valuea['user_id']);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$earning_details_by_user = array(
						'user_id'=>$value['parent_id'],
						'ref_id'=>$value['user_id'],
						'description'=>'Referral amount from '.$value['user_name'],
						'amount'=>$value['referral_bonus'],
						'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
			}
		}else{

		}			
	}

	function getCashoutEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM cashout_info ');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$earning_details_by_user = array(
							'user_id'=>$value['user_id'],
							//'ref_id'=>$value['user_id'],
							'description'=>'Cashout Request Amount',
							'amount'=>$value['cashout_ammount'],
							'e_d_b_u_date'=>$value['cashout_entry_date'],
						);
					$this->db->insert('earning_details_by_user',$earning_details_by_user);
					//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
				}
		}else{

		}			
	}

	function getProductEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_sale_bonus');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$earning_details_by_user = array(
							'user_id'=>$value['user_id'],
							//'ref_id'=>$value['user_id'],
							'description'=>'Product Sale Bonus amount',
							'amount'=>$value['sale_bonus'],
							'e_d_b_u_date'=>$value['created_at'],
						);
					$this->db->insert('earning_details_by_user',$earning_details_by_user);
					//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
				}
		}else{

		}			
	}

	function getDeductEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM deduct_credit');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$earning_details_by_user = array(
						'user_id'=>$value['user_id'],
						'ref_id'=>$value['admin_id'],
						'description'=>'Deduct amount By admin ',
						'amount'=>$value['credit'],
						'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
			}
		}else{

		}			
	}

	function getCreditEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_credit');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$earning_details_by_user = array(
						'user_id'=>$value['user_id'],
						'ref_id'=>$value['admin_id'],
						'description'=>'Credit amount By admin ',
						'amount'=>$value['credit'],
						'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
			}
		}else{

		}
	}

	function getCronEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM cron_job_qv_info');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$earning_details_by_user = array(
							'user_id'=>$value['parent_id'],
							'ref_id'=>$value['user_id'],
							'description'=>'Reward amount By cronJob ',
							'amount'=>$value['ammount'],
							'e_d_b_u_date'=>$value['deducted_at'],
						);
					$this->db->insert('earning_details_by_user',$earning_details_by_user);
					//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
				}
				
		}else{

		}
	}

	function getModuleEArningQuery(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM  interpreneurial_bonus_module');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$earning_details_by_user = array(
							'user_id'=>$value['user_id'],
							//'ref_id'=>$value['user_id'],
							'description'=>'Reward amount By  Module ',
							'amount'=>$value['module_bonus'],
							'e_d_b_u_date'=>$value['molude_created_at'],
						);
					$this->db->insert('earning_details_by_user',$earning_details_by_user);
					//$insertQuery .= '('.$value['parent_id'].',"Referral amount",'.$value['referral_bonus'].','.$value['created_at'].'),';
				}
		}else{

		}			
	}

	function getEarningReportByUser($id){
		$getDate = date('Y-m-d H:i:s');	
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a LEFT JOIN earning_details_by_user as b on b.user_id=a.user_id WHERE b.e_d_b_u_date <= "'.$getDate.'" and b.user_id='.$id.' ORDER BY b.e_d_b_u_date DESC');
		//$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a LEFT JOIN earning_details_by_user as b on b.user_id=a.user_id WHERE  b.user_id='.$id.' ORDER BY b.e_d_b_u_date DESC');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[]=$value;
				}
			echo json_encode($arr);
		}else{

		}
	}
}