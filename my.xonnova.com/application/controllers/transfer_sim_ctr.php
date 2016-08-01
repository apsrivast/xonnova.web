<?php
/**
* 
*/
class Transfer_sim_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	

	function editTransferSim($id){
		$_POST = json_decode(file_get_contents("php://input"),true);



		if($this->session->userdata('user_id') == null){
			$data = array('message'=>' Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim   WHERE sim_id = '.$id);
		foreach ($list as $key => $value) {
			$userid = $value['user_id'];
		}

		if($this->session->userdata('user_id') != $userid){
			$data = array('message'=>' This SIM # is not assigned to you !!.');
			echo json_encode($data);	
			return;
		}


		$this->db->where('sim',$_POST['sim_no']);
		$rs2	=	$this->db->get('activate_platform');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 != 0){
			$data = array('message'=>' This SIM can not be transferred. An Activation request for this SIM # has already been sent by you.');
			echo json_encode($data);	
			return;
		}



		$ToUserName = $this->mdl_common->getUserNameById($_POST['to_user_id']);
		$insertArr = array(
			'user_id'=>$_POST['to_user_id'],
			'user_name'=>$ToUserName,
		);
		if(!$this->db->update('activate_platform_sim',$insertArr,array('sim_id'=>$id))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{


			$insertArrr = array(
				'to_user_id'=>$_POST['to_user_id'],
				'to_user_name'=>$ToUserName,
				'transfer_sim_no'=>$_POST['sim_no'], 	
				'from_user_id'=>$_POST['user_id'],
				'from_user_name'=>$_POST['user_name'],

			);
				

			$this->db->insert('transfer_sim',$insertArrr);



           	$data = array('message' => 'SIM # Transfer successfully ! ');
			echo json_encode($data );
		}
	}




	function sponserbyUser(){
		$getPackage = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getSponsorToSponsor(){
		$User = $this->session->userdata('user_id');
		$parent = $this->mdl_common->getAllSponsor($User);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			if($sponser > 1){	

			$getPackage = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE user_id = '.$parent);
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}				
				
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			//$User = $this->mdl_common->getAllSponsor($User);
		}
		echo json_encode($arr);
	}


	function getTransferSim($id){
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim   WHERE sim_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}


	function getTransferSimList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim   WHERE  user_id= '.$userid.'  AND sim_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From activate_platform_sim   WHERE user_id = '.$userid);
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