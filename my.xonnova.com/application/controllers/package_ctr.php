<?php
/**
* 
*/
class Package_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function deleteMexPackageDescription(){
		$user = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('package_description_mex',array('primary_id'=>$user['primary_id']));
	}

	function updateMexPackageDescription(){
		$user = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
					'value'=>$user['value'],
			);
		$this->db->update('package_description_mex',$updateArr, array('primary_id'=>$user['primary_id']));
	} 

	function addMexPackageDescription($id){
		$user = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
					'id'=>$id,
					'value'=>$user['value'],
			);
		$this->db->insert('package_description_mex',$updateArr);
	}

	function getMexPackageDescriptionById($id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('SELECT * from package_description_mex where id='.$id);
		if(isset($getReferrals) && !empty($getReferrals)){
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
		}else{
			
		}	
	}

	

	function deletePackageDescription(){
		$user = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('upgrade_package_description',array('upgrade_package_id'=>$user['upgrade_package_id']));
	}

	function updatePackageDescription(){
		$user = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
					'value'=>$user['value'],
			);
		$this->db->update('upgrade_package_description',$updateArr, array('upgrade_package_id'=>$user['upgrade_package_id']));
	} 

	function addPackageDescription($old,$id){
		$user = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
					'old_package_id'=>$old,
					'new_package_id'=>$id,
					'value'=>$user['value'],
			);
		$this->db->insert('upgrade_package_description',$updateArr);
	}

	function getUpgradePackageDescription($old,$id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('SELECT * from upgrade_package_description where old_package_id = '.$old.' AND	new_package_id='.$id);
		if(isset($getReferrals) && !empty($getReferrals)){
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
		}else{
			
		}	
	}

	
	function getUpgradePackage(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT DISTINCT a.old_package_id, a.new_package_id,	b.package_name as old, c.package_name From upgrade_package_description as a LEFT JOIN package_info as b on a.old_package_id= b.package_id LEFT JOIN package_info as c on c.package_id = a.new_package_id  ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}


	

	
}