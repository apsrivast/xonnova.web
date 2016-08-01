<?php
/**
* 
*/
class Followup_leads extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}
	
	function getNewLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From soler_form as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE followup_status = 1 AND a.send_date BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY s_f_id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From soler_form as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE followup_status = 1 ORDER BY s_f_id DESC');
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


	
	function getNewLeadsListByID($id){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From soler_form as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE s_f_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateNewLeadsListByID(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			
			

			if(isset($_POST['comment'])&&!empty($_POST['comment'])){
						$insertArr = array(
									'leads_id'=>$_POST['s_f_id'],
									'comment'=>$_POST['comment'],
									);
						$this->db->insert('leads_status_history',$insertArr);
			}else{
				$_POST['comment'] = '';
			}
			if(isset($_POST['followup_date'])&&!empty($_POST['followup_date'])){
			}else{
				$_POST['followup_date'] = '';
			}

			$Arr = array(
					
					'emp_id'=>$this->session->userdata('user_id'),
					'lead_id'=>$_POST['s_f_id'],
					'status'=>$_POST['status'],
					'comment'=>$_POST['comment'],
					'followup_date'=>$_POST['followup_date'],
				);
			
			if(!$this->db->insert('new_leads_followup_table',$Arr)){
				

			    $data = array('message' => "This Lead has Already been Taken By Another Employee");
				echo json_encode($data );
			}else{
				$Arr = array(
					'followup_status'=>"Approve",
				);
				$this->db->update('soler_form',$Arr,array('s_f_id'=>$_POST['s_f_id']));

	           $data = array('message'=>'Successfully Updated.');
				echo json_encode($data);
			}
			

			
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	function getColdLeadsList(){
		
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Cold" AND b.send_date BETWEEN "'.$from.'" AND "'.$to.'" AND a.emp_id = '.$this->session->userdata('user_id'));
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Cold" AND a.emp_id = '.$this->session->userdata('user_id'));
			
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
	
	function getColdLeadsListByID($id){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.followup_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateColdLeadsListByID(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			if(isset($_POST['comment'])&&!empty($_POST['comment'])){

			}else{
				$_POST['comment'] = '';
			}
			if(isset($_POST['followup_date'])&&!empty($_POST['followup_date'])){
			}else{
				$_POST['followup_date'] = '';
			}

			$Arr = array(
					'status'=>$_POST['status'],
					'comment'=>$_POST['comment'],
					'followup_date'=>$_POST['followup_date'],
				);
			$this->db->update('new_leads_followup_table',$Arr,array('followup_id'=>$_POST['followup_id']));

			$data = array('message'=>'Successfully Updated.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	function getWarmLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status="Warm" AND a.followup_date BETWEEN "'.$from.'" AND "'.$to.'" AND a.emp_id = '.$this->session->userdata('user_id'));
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status="Warm" AND a.emp_id = '.$this->session->userdata('user_id'));
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
	
	function getWarmLeadsListByID($id){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.followup_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateWarmLeadsListByID(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			if(isset($_POST['comment'])&&!empty($_POST['comment'])){
						$insertArr = array(
									'leads_id'=>$_POST['s_f_id'],
									'comment'=>$_POST['comment'],
									);
						$this->db->insert('leads_status_history',$insertArr);
			}else{
				$_POST['comment'] = '';
			}
			if(isset($_POST['followup_date'])&&!empty($_POST['followup_date'])){
			}else{
				$_POST['followup_date'] = '';
			}

			$Arr = array(
					'status'=>$_POST['status'],
					'comment'=>$_POST['comment'],
					'followup_date'=>$_POST['followup_date'],
				);
			$this->db->update('new_leads_followup_table',$Arr,array('followup_id'=>$_POST['followup_id']));

			$data = array('message'=>'Successfully Updated.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	function getHotLeadsList(){
		
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Hot" AND a.followup_date BETWEEN "'.$from.'" AND "'.$to.'" AND a.emp_id = '.$this->session->userdata('user_id'));
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Hot" AND a.emp_id = '.$this->session->userdata('user_id'));
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
	
	function getHotLeadsListByID($id){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.followup_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateHotLeadsListByID(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			if(isset($_POST['comment'])&&!empty($_POST['comment'])){
				$insertArr = array(
									'leads_id'=>$_POST['s_f_id'],
									'comment'=>$_POST['comment'],
									);
						$this->db->insert('leads_status_history',$insertArr);
			}else{
				$_POST['comment'] = '';
			}
			if(isset($_POST['followup_date'])&&!empty($_POST['followup_date'])){
			}else{
				$_POST['followup_date'] = '';
			}

			$Arr = array(
					'status'=>$_POST['status'],
					'comment'=>$_POST['comment'],
					'followup_date'=>$_POST['followup_date'],
				);
			$this->db->update('new_leads_followup_table',$Arr,array('followup_id'=>$_POST['followup_id']));

			$data = array('message'=>'Successfully Updated.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	function getClosedLeadsList(){
		

		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Closed" AND b.send_date BETWEEN "'.$from.'" AND "'.$to.'" AND a.emp_id = '.$this->session->userdata('user_id'));
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.status = "Closed" AND a.emp_id = '.$this->session->userdata('user_id'));
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
	
	function getClosedLeadsListByID($id){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=b.user_id WHERE a.followup_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateClosedLeadsListByID(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			if(isset($_POST['comment'])&&!empty($_POST['comment'])){
			}else{
				$_POST['comment'] = '';
			}
			if(isset($_POST['followup_date'])&&!empty($_POST['followup_date'])){
			}else{
				$_POST['followup_date'] = '';
			}

			$Arr = array(
					'status'=>$_POST['status'],
					'comment'=>$_POST['comment'],
					'followup_date'=>$_POST['followup_date'],
				);
			$this->db->update('new_leads_followup_table',$Arr,array('followup_id'=>$_POST['followup_id']));

			$data = array('message'=>'Successfully Updated.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	function getEmployeeLeadsList(){
		

		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name as emp_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=a.emp_id WHERE  b.send_date BETWEEN "'.$from.'" AND "'.$to.'" ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.*, c.user_name as emp_name From new_leads_followup_table as a LEFT JOIN soler_form as b on b.s_f_id=a.lead_id LEFT JOIN user_master as c on c.user_id=a.emp_id ');
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