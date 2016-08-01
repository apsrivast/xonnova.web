<?php
/**
* 
*/
class User_menu extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function deleteMenuMapping(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('user_menu_mapping',array('map_id'=>$_POST['map_id']));
	}
	
	function getMenuMappingList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT DISTINCT a.map_id,  c.menu_label, d.sub_menu_label From user_menu_mapping as a LEFT JOIN user_menu_table as c on c.menu_id = a.menu_id  LEFT JOIN user_sub_menu_table as d on d.sub_menu_id = a.sub_menu_id  ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}

	

	function addMenuUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if(isset($_POST['menu_id'])&&!empty($_POST['menu_id'])){
		}else{
			$data = array("message"=>"Menu  Required !"); 
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['sub_menu_id'])&&!empty($_POST['sub_menu_id'])){
		}else{
			$data = array("message"=>"Sub Menu  Required !"); 
			echo json_encode($data);
			return  ;
		}

		foreach ($_POST['sub_menu_id'] as $value) {
			$Arr = array(
				'menu_id'=>$_POST['menu_id'],
				'sub_menu_id'=>$value,
			);
			
			if(!$this->db->insert('user_menu_mapping',$Arr)){
				$data = array('message'=>$this->db->_error_message());
				echo json_encode($data);
				return  ;
			}
		}

		$data = array("messagee"=>"Menu Added To User !"); 
		echo json_encode($data);
		

	}

	function getSubMenuList($id){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * From user_sub_menu_table WHERE menu_id = '.$id);
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
			
			$arr[] = array('sub_menu_id'=>'0','menu_id'=>$id,'sub_menu_label'=>'NO SUB MENU','sub_menu_url'=>'');
			echo json_encode($arr);
		}
	}


	function getMenuList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * From user_menu_table ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}
}