<?php
class Sim_activation extends CI_Controller
{
	function __Construct()
	{
		parent::__Construct();
	}

function getTransferSimList()
{
	header('Content-Type: application/json'); 

		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		
		if(isset($from) && !empty($from) && isset($to) && !empty($to))
		{
			$list = $this->mdl_common->allSelects('SELECT * From transfer_sim  WHERE  transfer_date  BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list))
			{
				foreach ($list as $key => $value)
				{
					$arr[] = $value;
				}
				echo json_encode($arr);
			}
			else
			{
				
				return false;
			}
		}
		else
		{
			
			$contentData = $this->mdl_common->allSelects('SELECT * FROM transfer_sim');
			if(isset($contentData) && !empty($contentData))
			{
			foreach ($contentData as $value)
			 {
				$arr[] = $value;
			 }
			echo json_encode($arr);			
		}
		else
		{
			return false;
			
		}
	
	}
}

}
?>