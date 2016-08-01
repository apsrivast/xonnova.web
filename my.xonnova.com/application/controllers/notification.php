<?php
/**
* 
*/
class Notification extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function getNewMemberNotification(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package where created_at BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}	
		}else{
			$newDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package where shipping_status="not approved"  ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}
	}

	function getNewUserSignupsCount(){
		header('Content-Type: application/json');

		$total = $this->mdl_common->allSelects('SELECT COUNT(*) as total FROM  shipping_management_table WHERE type="Registration" AND status="not shipped"');
		if(!empty($total)){
			foreach($total as $value){
				echo json_encode($value['total']);				
			}			
		}else{
			echo json_encode('NA');
		}
	}

	function getTotalUpgradeUser(){
		header('Content-Type: application/json');
		$upgradeDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$countUpgradeUser = $this->mdl_common->allSelects('SELECT COUNT(*) as totalUpgrade FROM  shipping_management_table WHERE type="Upgrade" AND status="not shipped"');
		
		if(!empty($countUpgradeUser)){
			foreach($countUpgradeUser as $value){
				echo json_encode($value['totalUpgrade']);				
			}
		}else{
			echo json_encode('NA');
		}
	}

	function newOrderTab(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$contentData =count($this->mdl_common->allSelects('SELECT a.*, b.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id where a.delivery_status = "Processing"'));
		echo json_encode($contentData);
	}
}