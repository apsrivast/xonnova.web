<?php

class Solar extends CI_Controller
{
	
	function __Construct()
	{
		parent::__Construct();
	}

	function getList()
	{
			$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From soler_form  WHERE  s_f_time  BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{

		header('Content-Type: application/json'); 
		$contentData = $this->mdl_common->allSelects('SELECT * FROM soler_form');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}

	}
	function getSolar($id)
	{
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * FROM soler_form where s_f_id ='.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}
}





?>