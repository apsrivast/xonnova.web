<?php
/**
* 
*/
class User_shipping extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}

	function getShippingList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];

		

		$userName = $this->mdl_common->getUserNameById($this->session->userdata('user_id'));
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From shipping_management_table WHERE user_name = "'.$userName.'" AND  created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From shipping_management_table WHERE user_name = "'.$userName.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}

	
	


}