<?php
/**
* 
*/
class AddEvent extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function eventCount(){
		header('Content-Type: application/json');
		$contentData = count($this->mdl_common->allSelects('SELECT * FROM event_status_by_user'));
		if(!empty($contentData)){
			$data = array('eventRegCount'=>$contentData);
		}else{
			$data = array('eventRegCount'=>$contentData);
		}
		echo json_encode($data);
	}

	function eventRegistrationList(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM event_status_by_user as a RIGHT JOIN event_info as b on b.event_id=a.event_id WHERE a.user_event_status!="deleted" ORDER BY user_event_status_id DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	
	function deleteEvent($where){
		if(!empty($where)){
			if(!$this->db->delete('event_status_by_user',array('user_id'=>$where))){
				$data = array('sucess'=>$this->db->_error_message());
			}else{
				$event_fee = 100;
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$where);
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$x = $total['total_balance'] + $event_fee;
						$updattotalarr = array(
							'total_balance'=>$x,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$where));
					}
				}else{
					$x = 0 + $event_fee;
					$updattotalarr = array(
						'total_balance'=>$x,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$where));
				}
				//Earning Details in one table	
				$earning_details_by_user = array(
						'user_id'=>$where,
						'ref_id'=>$where,
						'type_id'=>'1',
						'description'=>'Event participation fee refund by MLM network',
						'amount'=>$event_fee,
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end
				$data = array('sucess'=>'Registration delete Sucessfully');
			}
			echo json_encode($data);
		}else{
			$data = array('sucess'=>'Sorry....');
			echo json_encode($data);
		}
	}
}