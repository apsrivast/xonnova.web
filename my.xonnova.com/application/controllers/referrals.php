<?php 
/**
* 
*/
class Referrals extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}


	function getReferrals(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$getReferrals = $this->mdl_common->allSelects('SELECT * from user_master where user_type = "user" and sponsor_id = "1" and updated_at > "'.$lastDate.'" order by user_id desc');
		if(isset($getReferrals) && !empty($getReferrals)){
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
		}else{
			
		}
		
	}
	function getReferrals2(){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('Select * from user_master where user_type = "user" order by user_id desc');
		foreach ($getReferrals as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
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