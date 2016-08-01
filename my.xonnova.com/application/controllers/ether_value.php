<?php
/**
* 
*/
class Ether_Value extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * FROM ether_value');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}	
			echo json_encode($arr);
		}
	}

	function addEtherValueForAdmin()
	{

		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if(!empty($_POST['e_value']))
		{
			$DataExist = count($this->mdl_common->allSelects('SELECT * FROM ether_value'));
			$arr = array(
				'e_value' => $_POST['e_value'],
			);
			if(!empty($DataExist) && $DataExist >0){
				$this->db->update('ether_value',$arr);
			}else{
				$this->db->insert('ether_value',$arr);
			}
			$data = array('message'=>'Value added successfully.');
				echo json_encode($data);
		}
		else
		{
			$data = array('message'=>'We are sorry!.');
			echo json_encode($data);
		}
	}
}
