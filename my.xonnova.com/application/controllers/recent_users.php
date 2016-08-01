<?php 
/**
* 
*/
class Recent_users extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	function getRecentUsers(){
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$getUsers = $this->mdl_common->allSelects('SELECT * From user_master where user_type="user" order by created_at desc LIMIT 0, 5');
		if(isset($getUsers) && !empty($getUsers)){
			foreach ($getUsers as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}
		else{
		}
	}
}