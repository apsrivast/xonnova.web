<?php

/**
* 
*/
class UserEvent extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	function getUserData(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_id='.$userID);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function confirmEvent(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['event_id'])){
			$event_id = $_POST['event_id'];
		}else{
			$event_id = "";
		}
		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
		}
		if(!empty($_POST['user_name'])){
			$user_name = $_POST['user_name'];
		}else{
			$user_name = "";
		}
		if(!empty($_POST['user_email'])){
			$user_email = $_POST['user_email'];
		}else{
			$user_email = "";
		}
		if(!empty($_POST['contact_no'])){
			$contact_no = $_POST['contact_no'];
		}else{
			$contact_no = "";
		}
		$insertEventArr = array(
				'event_id'=>1,
				'user_id'=>$user_id,
				'user_name'=>$user_name,
				'user_email'=>$user_email,
				'contact_no'=>$contact_no,
			);
		$uniqueData = $this->mdl_common->allSelects("SELECT * FROM event_status_by_user WHERE user_id=".$user_id);
		if(!empty($uniqueData)){
			$data = array('err'=>'Your participation already confirmed');
		}else{
			if(!$this->db->insert('event_status_by_user',$insertEventArr)){
				$data = array('err'=>'Sorry...'.$this->db->_error_message());
			}else{
				$event_fee = 100;
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$user_id);
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$x = $total['total_balance'] - $event_fee;
						$updattotalarr = array(
							'total_balance'=>$x,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$user_id));
					}
				}else{
					$x = 0 - $event_fee;
					$updattotalarr = array(
						'total_balance'=>$x,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$user_id));
				}
				//Earning Details in one table	
				$earning_details_by_user = array(
						'user_id'=>$user_id,
						'ref_id'=>$user_id,
						'type_id'=>'1',
						'description'=>'Event participation fee deduct  from '.$user_name,
						'amount'=>$event_fee,
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end
				$this->send_user_email($user_name,$user_email);
				$data = array('sucess'=>"Your participation has been confirmed");
			}			
		}

		echo json_encode($data);
	}
	
	function eventStatus(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$uniqueData = $this->mdl_common->allSelects("SELECT * FROM event_status_by_user WHERE user_id=".$userID);
		if(!empty($uniqueData)){
			$data = array('status'=>"You have already Registred for event");
		}else{
			$data = array('status'=>"Las Vegas, November 10, 2015");
		}
		echo json_encode($data);
	}
	
	public function send_user_email($user_name=null,$user_email=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('xonnova Network Event Registration');
        $html = $this->mdl_common->eventMailBody($user_name);
        $this->email->message($html);

        $this->email->send();
    }

	
}