<?php
/**
* 
*/
class Bug_user extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}


	function submitBug(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['bug_title']) && !empty($_POST['bug_title'])){
		}else{
			$data = array("message"=>"Title field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['bug_description']) && !empty($_POST['bug_description'])){
		}else{
			$data = array("message"=>"Description field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bug_image']) && !empty($_POST['bug_image'])){
		}else{
			$_POST['bug_image'] = "NoImage";
		}
		$insertArr = array(
			'user_id'=>$this->session->userdata('user_id'),
			'bug_title'=>$_POST['bug_title'],
			'bug_description'=>$_POST['bug_description'], 	
			'bug_image'=>$_POST['bug_image'],

		);
			

		if(!$this->db->insert('bug_report',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'Bug Added successfully ! ');
			echo json_encode($data );
		}
	}

	


	function getBugUserList(){
		$list = $this->mdl_common->allSelects('SELECT * From bug_report  WHERE user_id='.$this->session->userdata('user_id'));
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
		
	}



	function uploadBug(){
		header('Content-Type: application/json');
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    //$imageFiles = $_FILES[ 'file' ][ 'name' ];
			//$image = 'cashout'.$date.'.png';
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_bug'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_bug'.$date.'.png';
			}
			
	      	$configVideo = array(
	            	'upload_path' => './assets/cashout/',
		            'max_size' => '800024000',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	 
	    }else{
		}       
	}
	
	
	function getPendingBugList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id   WHERE a.bug_status = "Pending"  AND a.bug_time BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.bug_status = "Pending" ');
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

	function getApprovedBugList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id   WHERE a.bug_status = "Approve"  AND a.bug_time BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.bug_status = "Approve" ');
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


	function getrejectedBugList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id   WHERE a.bug_status = "Reject"  AND a.bug_time BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.bug_status = "Reject" ');
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


	function bugByUser($id){
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From bug_report as a LEFT JOIN user_master as b on a.user_id = b.user_id  WHERE a.bug_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}
	
	
	
	function rejectUserBug($id){
		header('Content-Type: application/json');
		
			$updateArr = array(
				'bug_status'=>'Reject',
			);
			if(!$this->db->update('bug_report',$updateArr, array('bug_id'=>$id))){
				$data = array('message'=>'not rejected.');
				echo json_encode($data);				
			}else{
				$data = array('message'=>'rejected');
				echo json_encode($data);
			}
		
	}




	function approveUserBug($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['bug_reward_point'])){
			$updateArr = array(
				'bug_reward_point'=>$_POST['bug_reward_point'],
				'bug_status'=>'Approve',
			);
			if(!$this->db->update('bug_report',$updateArr, array('bug_id'=>$id))){
				$data = array('message'=>'not Approve.');
				echo json_encode($data);				
			}else{

				$Arr = array(
					'user_id'=>$_POST['user_id'],
					'credit'=>$_POST['bug_reward_point'],
					'wallet_type'=>'1',
					'message'=>'BY Bug Approved',
				);
				$this->db->insert('reward_points_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM reward_points_report_user_map_info WHERE user_id='.$_POST['user_id']));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$_POST['user_id'],
					);
					$this->db->insert('reward_points_report_user_map_info',$insertwallete);
				}




				$data = array('message'=>'Approve');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Reward Point Required');
			echo json_encode($data);	
		}
	}





	

	


	
	


}