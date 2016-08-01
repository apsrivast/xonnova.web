<?php
/**
* 
*/
class Ticket_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}
	function send_user_bug_mail(  $user_id=null,  $ticket_id=null,  $comment=null) {
		$userName = $this->mdl_common->getUserNameById($user_id);
		$user_email = $this->mdl_common->getUserEmailInUserMaster($user_id);
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject(' xonnova Network');
        
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your  request has been approve for ticket # '.$ticket_id.' </p>
        					<p>Comment by Admin</p>';

		foreach ($comment as $key => $value) {
		$mail_body	.='<p>'.$value['comment'].'<p>';
		}

        $mail_body	.='		<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';

       
        $this->email->message($mail_body);

        $this->email->send();
    }

   

	function sendUserMail(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$toUserName = $this->mdl_common->getUserNameById($_POST['user_id']);

		$list = $this->mdl_common->allSelects('SELECT *  From ticket_comment  WHERE 	ticket_id = '.$_POST['ticket_id']);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			//echo json_encode($arr);
			$this->send_user_bug_mail($_POST['user_id'], $_POST['ticket_id'], $arr);
			$updateArr = array(
				'ticket_status'=>'mail send',
			);

			$this->db->update('ticket_no',$updateArr, array('ticket_id'=>$_POST['ticket_id']));
			$data = array("messagee"=>"Mail send to ".$toUserName); 
			echo json_encode($data);

		}else{
			$data = array("message"=>"No Comment"); 
			echo json_encode($data);

		}
	
		
	}

	function addTicket(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		// if(isset($_POST['bug_title']) && !empty($_POST['bug_title'])){
		// }else{
		// 	$data = array("message"=>"Title field is required !");
		// 	echo json_encode($data);
		// 	return  ;
		// }

		if(isset($_POST['department_id'])&&!empty($_POST['department_id'])){
		}else{
			$data = array("message"=>"Department  Required !"); 
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['user_name'])&&!empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"User Name  Required !"); 
			echo json_encode($data);
			return  ;
		}
		$userId =  $this->mdl_common->getUserId($_POST['user_name']);

		
		if(isset($_POST['bug_text']) && !empty($_POST['bug_text'])){
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
			'user_id'=>$userId,
			'department_id'=>$_POST['department_id'],
			'bug_text'=>$_POST['bug_text'], 	
			'bug_image'=>$_POST['bug_image'],

		);
			

		if(!$this->db->insert('ticket_no',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
			$last_id =  $this->db->insert_id();
           	$data = array('messagee' => 'Ticket Added successfully ! Ticket # = '.$last_id  );
			echo json_encode($data );
		}
	}

	function addFirstComment($id){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		if(isset($_POST['comment'])&&!empty($_POST['comment'])){
		}else{
			$data = array("message"=>"Comment  Required !"); 
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ticket_status'])&&!empty($_POST['ticket_status'])){
		}else{
			$data = array("message"=>"Status  Required !"); 
			echo json_encode($data);
			return  ;
		}

		$userId = $this->session->userdata('user_id');
		$Arr = array(
			'ticket_id'=>$id,
			'employee_id'=>$userId,
		);
		
		if(!$this->db->insert('ticket_employee',$Arr)){
			$data = array('message'=>'Already taken by another employee');
			echo json_encode($data);
			return  ;
		}

		$updateArr = array(
			'ticket_status'=>$_POST['ticket_status'],
			'employee_id'=>$userId,
		);

		$this->db->update('ticket_no',$updateArr, array('ticket_id'=>$id));

		$Arr = array(
			'ticket_id'=>$id,
			'comment'=>$_POST['comment'],
			'employee_id'=>$userId,
		);
		$this->db->insert('ticket_comment',$Arr);
	
		$data = array("messagee"=>"Comment Added !"); 
		echo json_encode($data);
	}
	

	function addComment($id){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		if(isset($_POST['comment'])&&!empty($_POST['comment'])){
		}else{
			$data = array("message"=>"Comment  Required !"); 
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['ticket_status'])&&!empty($_POST['ticket_status'])){
			$updateArr = array(
				'ticket_status'=>$_POST['ticket_status'],
			);
			$this->db->update('ticket_no',$updateArr, array('ticket_id'=>$id));
		}

		$userId = $this->session->userdata('user_id');

		$Arr = array(
			'ticket_id'=>$id,
			'comment'=>$_POST['comment'],
			'employee_id'=>$userId,
		);
		
		if(!$this->db->insert('ticket_comment',$Arr)){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);
			return  ;
		}
		$data = array("messagee"=>"Comment Added !"); 
		echo json_encode($data);
	}

	function getTickeCommentByID($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name From ticket_comment as a LEFT JOIN user_master as b on a.employee_id = b.user_id  where a.ticket_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getTickeByID($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name From ticket_no as a LEFT JOIN user_master as b on a.user_id = b.user_id  where a.ticket_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	
	function getTicketListByEmployee(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$userId = $this->session->userdata('user_id');
		$departmentId =  $this->mdl_common->getDepartmentMappingId($userId);

		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*,  d.user_name  From ticket_no as a LEFT JOIN user_master as d on a.user_id = d.user_id   WHERE  a.ticket_time BETWEEN "'.$from.'" AND "'.$to.'" AND a.department_id = '.$departmentId.' AND a.ticket_status = "Waiting" AND a.employee_id = '.$userId);
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*,  d.user_name  From ticket_no as a LEFT JOIN user_master as d on a.user_id = d.user_id WHERE 	a.department_id = '.$departmentId.' AND a.ticket_status = "Waiting" AND a.employee_id = '.$userId);
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


	function getTicketListByDepartment(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$userId = $this->session->userdata('user_id');
		$departmentId =  $this->mdl_common->getDepartmentMappingId($userId);

		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*,  d.user_name  From ticket_no as a LEFT JOIN user_master as d on a.user_id = d.user_id   WHERE  a.ticket_time BETWEEN "'.$from.'" AND "'.$to.'" AND a.department_id = '.$departmentId.' AND a.ticket_status = "Pending"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*,  d.user_name  From ticket_no as a LEFT JOIN user_master as d on a.user_id = d.user_id WHERE 	a.department_id = '.$departmentId.' AND a.ticket_status = "Pending"');
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

	function getTicketList(){
		$_POST = json_decode(file_get_contents("php://input"),true);


		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.department_name, c.user_name as employee_name, d.user_name  From ticket_no as a LEFT JOIN menu_add_department as b on a.department_id= b.department_id LEFT JOIN user_master as c on a.employee_id= c.user_id  LEFT JOIN user_master as d on a.user_id= d.user_id   WHERE  a.ticket_time BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.department_name, c.user_name as employee_name, d.user_name  From ticket_no as a LEFT JOIN menu_add_department as b on a.department_id= b.department_id LEFT JOIN user_master as c on a.employee_id= c.user_id  LEFT JOIN user_master as d on a.user_id= d.user_id');
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