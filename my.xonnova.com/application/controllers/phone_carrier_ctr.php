<?php
/**
* 
*/
class Phone_carrier_ctr extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}

	function index(){
	}

	function updatePhoneCarrier(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							
		if(isset($_POST['contact_no']) && !empty($_POST['contact_no'])){
		}else{
			$data = array("mess"=>"Phone # field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone_carrier']) && !empty($_POST['phone_carrier'])){
		}else{
			$data = array("mess"=>"Phone Carrier field is required !");
			echo json_encode($data);
			return  ;
		}

		$last_id = $this->session->userdata('user_id');
		$Arr = array(
				'contact_no'=>$_POST['contact_no'],
				'phone_carrier'=>$_POST['phone_carrier'],
			);
		$this->db->update('user_master',$Arr,array('user_id'=>$last_id));

		$this->session->set_userdata('phone_carrier', $_POST['phone_carrier']);
	
		$data = array('message'=>'Successfully Updated.');
		echo json_encode($data);
	}
}