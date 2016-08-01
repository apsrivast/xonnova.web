<?php
/**
* 
*/
class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function membershipReport(){
		$id = $this->session->userdata('user_id');
		if(isset($id) && !empty($id)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package  LEFT JOIN new_member_status_info as d on d.user_id=a.user_id where a.shipping_status="approved" and a.user_id='.$id);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}else{

		}
	}
}