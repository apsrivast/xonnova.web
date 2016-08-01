<?php
/**
* 
*/
class UserReferrals extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getReferrals(){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('Select * from user_master where sponsor_id ='.$this->session->userdata('user_id').'  order by user_id desc');
		if(isset($getReferrals) && !empty($getReferrals)){
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
		}else{

		}		
	}

	function editReferrals($id){
		$getData = $this->mdl_common->allSelects('Select * from user_master WHERE user_id='.$id.' and user_type ="user"');
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}

	function updateReferrals(){
		$user = json_decode(file_get_contents("php://input"),true);
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		$updateArr = array(
				'first_name'=>$user['first_name'],
				'middle_name'=>$user['middle_name'],
				'last_name'=>$user['last_name'],
				'user_name'=>$user['user_name'],
				'user_email'=>$user['user_email'],
				'dob'=>$user['dob'],
				'address1'=>$user['address1'],
				'address2'=>$user['address2'],
				'city'=>$user['city'],
				'state'=>$user['state'],
				'zip'=>$user['zip'],
				'country'=>$user['country'],
				'updated_at'=>$lastDate,
			);
		$this->db->update('user_master',$updateArr, array('user_id'=>$user['user_id']));
	}

	function deleteReferrals($id){
		return $this->db->delete('user_master',array('user_id'=>$id));
	}

}