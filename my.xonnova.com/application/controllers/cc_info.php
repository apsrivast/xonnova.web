<?php
/**
* 
*/
class Cc_info extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}



	function getPaymentList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From payment_info as a LEFT JOIN user_master as b on a.user_id = b.user_id   WHERE  a.payment_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From payment_info as a LEFT JOIN user_master as b on a.user_id = b.user_id  ');
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