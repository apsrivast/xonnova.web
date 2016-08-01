<?php
/**
* 
*/
class Member extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	
	function FounderMemberListShow(){
		header('Content-Type: application/json');
		$this->db->where('user_id',$this->session->userdata('user_id'));
	
		$rs2	=	$this->db->get('founder_member');
		$UserInfo2	=	$rs2->num_rows();	
		if(!empty($UserInfo2) && $UserInfo2 > 0){
			$data['member'] = '2';	
			echo json_encode($data);		
		}else{
			$data['member'] = '1';	
			echo json_encode($data);		
		}		
	}


	function addFounders(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"user_name field is required !");
			echo json_encode($data);
			return  ;
		}
		
		$userId = $this->mdl_common->sponserID($_POST['user_name']);
		$insertArr = array(
			'user_id'=>$userId,
			'user_name'=>$_POST['user_name'],
		);
			

		if(!$this->db->insert('founder_member',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'Founder Member Added successfully ! ');
			echo json_encode($data );
		}
	}

	
	function getFoundersList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT * FROM founder_member where  f_m_date BETWEEN "'.$from.'" AND "'.$to.'" ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}	
		}else{
			
			$contentData = $this->mdl_common->allSelects('SELECT * FROM founder_member');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}
	}


	function deleteFounder(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('founder_member',array('f_m_id'=>$_POST['f_m_id']));
	}





	
	function viewFailMemberReport($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*, b.package_name, c.user_name from store_user_info as a right join package_info as b on a.package_id = b.package_id left join user_master as c on a.sponsor_id = c.user_id WHERE a.id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}

	function getFailMemberReport(){
		header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('Select * From store_user_info as a where  fail_status = 1 and NOT EXISTS (SELECT user_name FROM  user_master as b WHERE a.u_name = b.user_name) ');
		if(isset($getPackage) && !empty($getPackage)){
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}
	}
	

	function updateFailMember($id){
		$this->db->update('store_user_info',array('fail_status'=> 2),array('id'=>$id));
		$data = array('message'=>' Updated Successfully.');
		echo json_encode($data);
	}
	
	function getNewMemberList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package where created_at BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}	
		}else{
			$newDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package where  created_at > "'.$newDate.'" ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}
	}

	function updateRank(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['user_name']) && !empty($_POST['user_name']) && !empty($_POST['level'])){
			$userID = $this->mdl_common->getUserId($_POST['user_name']);
			$currentPackage = $this->mdl_common->getPackageById($userID);
			$newPackage = null;
			$curlevel = $this->mdl_common->countUserLevel('earning_info',$userID);
			$newlevel = $_POST['level'];
			
			$this->db->update('earning_info',array('level'=>$_POST['level']),array('user_id'=>$userID));
			if($_POST['level'] > 5){
				$this->db->update('user_master',array('package'=>5),array('user_id'=>$userID));
				$newPackage = 5;
			}else{
				$this->db->update('user_master',array('package'=>$_POST['level']),array('user_id'=>$userID));
				$newPackage = $_POST['level'];
			}
			$insertArr = array(
					'user_id'=>$userID,
					'pre_package'=>$currentPackage,
					'new_package'=>$newPackage,
					'new_level'=>$newlevel,
					'pre_level'=>$curlevel
				);
			$this->db->insert('update_user_rank_info',$insertArr);
			$data = array('message'=>$_POST['user_name'].' This user rank updated Successfully.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'This is Invalid User!');
			echo json_encode($data);
		}
	}

	function getLevel(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From level_configuration');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getNewMemberListByID($id=null){
		header('Content-Type: application/json');
		if(isset($id) && !empty($id)){
			$newDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.* FROM user_master as a RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=a.package where a.shipping_status="not approved" and a.user_id='.$id.' ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}else{

		}
	}

	function updataNewMemberStatus(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['shipping_comments'])){
			$shipmessage = $_POST['shipping_comments'];
		}else{
			$shipmessage ="";
		}
		if(isset($_POST['user_id']) && !empty($_POST['user_id']) && !empty($_POST['address1'])){
			$address = 'Address : '.$_POST['address1'].', '.$_POST['address2'].', zip-code : '.$_POST['zip'].', Contact-no. : '.$_POST['contact_no'].', Country : '.$_POST['country_name'].', State : '.$_POST['state'].', City : '.$_POST['city'];
			$exist = count($this->mdl_common->allSelects('SELECT * FROM new_member_status_info WHERE shipping_status = "approved" AND user_id='.$_POST['user_id']));
			if(isset($exist) && !empty($exist) && $exist !=0){
				$data = array('message'=>'This user : '.$_POST['user_name'].' product is allrady shipped!');
				echo json_encode($data);
			}else{
				$insertShipping = array(
					'user_id'=>$_POST['user_id'],
					'shipping_id'=>$_POST['shipping_id'],
					'shipping_by'=>$_POST['shipping_by'],
					'shipping_comments'=>$shipmessage,
					'shipping_address'=>$address, 
					'shipping_status'=>'2',
					'shipping_date'=>$_POST['shipping_date']
				);
				$this->db->insert('new_member_status_info',$insertShipping);

				$this->db->update('user_master',array('shipping_status'=>'approved'),array('user_id'=>$_POST['user_id']));
				
				$data = array('message'=>'This user : '.$_POST['user_name'].' Product Shipped Successfully.');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'This is Invalid User!');
			echo json_encode($data);
		}
	}
	
	function getUpgradeStatusByID($id=null){
		header('Content-Type: application/json');
		if(isset($id) && !empty($id)){
			$newDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.*,d.* FROM user_master as a RIGHT JOIN upgrade_user_details as d on d.user_id=a.user_id RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as b on b.package_id=d.package_id where d.shipping_status="not approved" and d.upgrade_id='.$id.' ORDER BY a.user_id DESC ');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}			
		}else{

		}
	}
	
	function updateUpgradeStatus(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['shipping_comments'])){
			$shipmessage = $_POST['shipping_comments'];
		}else{
			$shipmessage ="";
		}
		if(isset($_POST['user_id']) && !empty($_POST['user_id']) && !empty($_POST['address1']) && !empty($_POST['upgrade_id'])){
			$address = 'Address : '.$_POST['address1'].', '.$_POST['address2'].', zip-code : '.$_POST['zip'].', Contact-no. : '.$_POST['contact_no'].', Country : '.$_POST['country_name'].', State : '.$_POST['state'].', City : '.$_POST['city'];
			$exist = count($this->mdl_common->allSelects('SELECT * FROM upgrade_user_details WHERE shipping_status="approved" AND upgrade_id='.$_POST['upgrade_id'].' AND user_id='.$_POST['user_id']));
			if(isset($exist) && !empty($exist) && $exist !=0){
				$data = array('message'=>'This user : '.$_POST['user_name'].' product is allrady shipped!'.$exist);
				echo json_encode($data);
			}else{
				$insertShipping = array(
					'user_id'=>$_POST['user_id'],
					'shipping_id'=>$_POST['shipping_id'],
					'shipping_by'=>$_POST['shipping_by'],
					'shipping_comments'=>$shipmessage,
					'shipping_address'=>$address, 
					'shipping_status'=>'3',
					'shipping_date'=>$_POST['shipping_date']
				);
				$this->db->insert('new_member_status_info',$insertShipping);

				$this->db->update('upgrade_user_details',array('shipping_status'=>'approved'),array('upgrade_id'=>$_POST['upgrade_id']));
				
				$data = array('message'=>'This user : '.$_POST['user_name'].' Product Shipped Successfully.');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'This is Invalid User!');
			echo json_encode($data);
		}
	}

}