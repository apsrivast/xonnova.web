<?php

/**
* 
*/
class PackageCtr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	
	function getMexPackage(){
		$getPackage = $this->mdl_common->allSelects('Select * From package_info where mex_package_status = "active"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
	function insertPkg(){
		$user = json_decode(file_get_contents("php://input"),true);
		$insertArr = array(
			'package_name'=>$user['pckage_name'],
			'entry_ammout'=>$user['pckage_price'],
			'binary_point'=>$user['bv'],
			'qv_point'=>$user['qv_point'],
			'referrals_amount'=>$user['referral_amount'],
			'st_package_amount'=>$user['st_package_amount'],
			'descount_percent'=>$user['discount'],
			'package_status'=>$user['status'],
			'mex_package_name'=>$user['mex_package_name'],
			'mex_package_cost'=>$user['mex_package_cost'],
			'mex_entry_amount'=>$user['mex_entry_amount'],
			'mex_st_package_amount'=>$user['mex_st_package_amount'],
			'mex_referral_amount'=>$user['mex_referral_amount'],
			'mx_qv_point'=>$user['mx_qv_point'],
			'mx_bv_point'=>$user['mx_bv_point'],
			//'mex_descount_percent'=>$user['mex_descount_percent'],
			'mex_package_status'=>$user['mex_package_status'],
		);
		if(!$this->db->insert('package_info',$insertArr)){
			$data = array('message'=>'Package Not Created'.$this->db->_error_message());
			echo json_encode($data);
		}else{
			$data = array('message'=>'Package Created Successfully');
			echo json_encode($data);
		}
	}

	function getPackage(){
		header('Content-Type: application/json');
		
		$getReferrals = $this->mdl_common->allSelects('Select * from package_info  order by package_id desc');
		foreach ($getReferrals as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);			
	}

	function getPackageById($id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('Select * from package_info where  package_id='.$id.' order by package_id desc');
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
	}

	function getMexPackageById($id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('Select * from package_info where package_id='.$id.' order by package_id desc');
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
	}

	function updatePackage($id){
		$user = json_decode(file_get_contents("php://input"),true);
		//if(!empty($user['package_name']) && !empty($user['entry_ammout']) && !empty($user['descount_percent']) && !empty($user['referrals_amount']) && !empty($user['Binary_point']) && !empty($user['exit_price'])){
			$updateArr = array(
					'package_name'=>$user['package_name'],
					'entry_ammout'=>$user['entry_ammout'],
					'descount_percent'=>$user['descount_percent'],
					'referrals_amount'=>$user['referrals_amount'],
					'Binary_point'=>$user['Binary_point'],
					'qv_point'=>$user['qv_point'],
					'st_package_amount'=>$user['st_package_amount'],
                                        'matrix_bonus_amount'=>$user['matrix_bonus_amount'],
					'matrix_bonus_level'=>$user['matrix_bonus_level'],
                                        'leadership_amount'=>$user['leadership_amount'],
				);
		//$this->db->update('package_info',$updateArr, array('package_id'=>$user['package_id']));
		if(!$this->db->update('package_info',$updateArr, array('package_id'=>$user['package_id']))){
			$data = array('message'=>'Package Not Updated!');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Package updated Successfully');
			echo json_encode($data);
		}
	}  

	function updateMEXPackage($id){
		$user = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'mex_package_name'=>$user['mex_package_name'],
			'mex_entry_amount'=>$user['mex_entry_amount'],
			'mex_referral_amount'=>$user['mex_referral_amount'],
			'mx_bv_point'=>$user['mx_bv_point'],
			'mx_qv_point'=>$user['mx_qv_point'],
			'mex_package_cost'=>$user['mex_package_cost'],
			'mex_st_package_amount'=>$user['mex_st_package_amount'],
		);
		if(!$this->db->update('package_info',$updateArr, array('package_id'=>$user['package_id']))){
			$data = array('message'=>'Package Not Updated!');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Package updated Successfully');
			echo json_encode($data);
		}
	}  

	function deletePackage($id){
		return $this->db->update('package_info',array('package_status'=>'deleted'),array('package_id'=>$id));
		//return $this->db->delete('package_info',array('package_id'=>$id));
	}

	function deleteMexPackage($id){
		return $this->db->update('package_info',array('mex_package_status'=>'deleted'),array('package_id'=>$id));
		//return $this->db->delete('package_info',array('package_id'=>$id));
	}

	function check_user($userName){
		echo false;
	}
}