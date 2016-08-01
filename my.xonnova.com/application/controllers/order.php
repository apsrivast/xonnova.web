<?php
/**
* 
*/
class Order extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function getOrderStatus(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM shipping_management_table as a RIGHT JOIN package_info as b on b.package_id=a.shipping_package_id WHERE a.archive_member_status="shipped" AND user_id='.$userID);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
	
	function totalOrders(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$contentData = count($this->mdl_common->allSelects('SELECT a.*, b.* FROM shipping_management_table as a RIGHT JOIN package_info as b on b.package_id=a.shipping_package_id WHERE a.archive_member_status="shipped" AND a.user_id='.$userID));
		if(!empty($contentData)){
			$data = array('total'=>$contentData);
		}else{
			$data = array('total'=>'0');			
		}
		echo json_encode($data);
	}
}