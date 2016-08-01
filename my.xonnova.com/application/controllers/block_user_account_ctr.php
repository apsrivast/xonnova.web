<?php
/**
* 
*/
class Block_user_account_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}


	function deleteUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->update('user_master',array('login_status'=>'active'),array('user_id'=>$_POST['user_id']));
		$this->db->delete('block_user_account',array('block_id'=>$_POST['block_id']));
	}


	function addUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);


		if(isset($_POST['admin_password']) && !empty($_POST['admin_password'])){
		}else{
			$data = array("message"=>"Password field is required !");
			echo json_encode($data);
			return  ;

		}

		if($_POST['admin_password'] == "0nL3gacyvision2020!"){
		}else{
			$data = array("message"=>"Password is worng !");
			echo json_encode($data);
			return  ;

		} 

		
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}


		$userId = $this->mdl_common->sponserID($_POST['user_name']);
		$insertArr = array(
		
			'user_name'=>$_POST['user_name'],
			'user_id'=>$userId, 	

		);
			

		if(!$this->db->insert('block_user_account',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
			
			$this->db->update('user_master',array('login_status'=>'inactive'),array('user_id'=>$userId));
           	$data = array('message' => 'User Account Block successfully ! ');
			echo json_encode($data );
		}
	}



	function getList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From block_user_account  AND block_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT * From block_user_account ');
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