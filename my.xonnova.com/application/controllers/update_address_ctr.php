<?php
/**
* 
*/
class Update_address_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function updateOrderAddress(){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
						// 'first_name'=>$_POST['first_name'],
						// 'last_name'=>$_POST['last_name'],
						'address1'=>$_POST['address1'],
						'address2'=>$_POST['address2'],
						'city'=>$_POST['city'],
						'state'=>$_POST['state'],
						'zip'=>$_POST['zip'],
		);
		if(!$this->db->update('user_purchase_info',$updateArr, array('user_purchase_id'=>$_POST['user_purchase_id']))){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);				
		}else{
			$data = array('message'=>'Edited');
			echo json_encode($data);
		}
	}

	function updateMemberAddress(){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArrr = array(
						// 'first_name'=>$_POST['first_name'],
						// 'last_name'=>$_POST['last_name'],
						//'ship_address'=>$_POST['ship_address'],
						//'address2'=>$_POST['address2'],
						'city'=>$_POST['city'],
						'state'=>$_POST['state'],
						'zip'=>$_POST['zip'],
		);
		$this->db->update('user_master',$updateArrr, array('user_id'=>$_POST['user_id']));
		$updateArr = array(
						// 'first_name'=>$_POST['first_name'],
						// 'last_name'=>$_POST['last_name'],
						'ship_address'=>$_POST['ship_address'],
						//'address2'=>$_POST['address2'],
						// 'city'=>$_POST['city'],
						// 'state'=>$_POST['state'],
						// 'zip'=>$_POST['zip'],
		);
		if(!$this->db->update('shipping_management_table',$updateArr, array('id'=>$_POST['id']))){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);				
		}else{
			$data = array('message'=>'Edited');
			echo json_encode($data);
		}
	}


	function updateSimShippingAddress(){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
						// 'first_name'=>$_POST['first_name'],
						// 'last_name'=>$_POST['last_name'],
						's_address1'=>$_POST['s_address1'],
						's_address2'=>$_POST['s_address2'],
						's_city'=>$_POST['s_city'],
						's_state'=>$_POST['s_state'],
						's_zip'=>$_POST['s_zip'],
		);
		if(!$this->db->update('activate_platform',$updateArr, array('id'=>$_POST['id']))){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);				
		}else{
			$data = array('message'=>'Edited');
			echo json_encode($data);
		}
	}


	
}