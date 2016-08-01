<?php
/**
* 
*/
class Ether_conversion_rate extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index() {
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * FROM ether_conversionrate');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}	
			echo json_encode($arr);
		}
	}

	function addEtherConversionRate() {

		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['ether_rate']) && !empty($_POST['conversion_charge']))
		{
			$DataExist = count($this->mdl_common->allSelects('SELECT * FROM ether_conversionrate'));
			$arr = array(
				'ether_rate' => $_POST['ether_rate'],
				'conversion_charge' => $_POST['conversion_charge'],
			);
			if(!empty($DataExist) && $DataExist >0){
				$this->db->update('ether_conversionrate',$arr);
			}
			else {
				$this->db->insert('ether_conversionrate',$arr);
			}
			$data = array('message'=>'Value updated successfully.');
			echo json_encode($data);
		}
	}
}