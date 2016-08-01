<?php
/**
* 
*/
class Add_menu extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function deleteDepartmentMenuMapping(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('menu_department_mapping',array('map_id'=>$_POST['map_id']));
	}
	
	function getDepartmentMenuMappingList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT DISTINCT a.map_id, b.department_name, c.menu_label, d.sub_menu_label From menu_department_mapping as a LEFT JOIN menu_add_department as b on a.department_id= b.department_id LEFT JOIN menu_table as c on c.menu_id = a.menu_id  LEFT JOIN sub_menu_table as d on d.sub_menu_id = a.sub_menu_id  ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}

	

	function addMenuDepartment(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['department_id'])&&!empty($_POST['department_id'])){
		}else{
			$data = array("message"=>"Department  Required !"); 
			echo json_encode($data);
			return  ;
		}
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
				'department_id'=>$_POST['department_id'],
				'menu_id'=>$_POST['menu_id'],
				'sub_menu_id'=>$value,
			);
			
			if(!$this->db->insert('menu_department_mapping',$Arr)){
				$data = array('message'=>$this->db->_error_message());
				echo json_encode($data);
				return  ;
			}
		}

		$data = array("messagee"=>"Menu Added To Department !"); 
		echo json_encode($data);
		

	}

	function getSubMenuList($id){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * From sub_menu_table WHERE menu_id = '.$id);
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

	function getDepartmentList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * From menu_add_department ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}

	function addDepartment(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['department_name'])&&!empty($_POST['department_name'])){
		}else{
			$data = array("message"=>"Department Name Required !"); 
			echo json_encode($data);
			return  ;
		}
		

		$insertArr = array(
				'department_name'=>$_POST['department_name'],
		);
		if(!$this->db->insert('menu_add_department',$insertArr)){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);
		}else{
			$data = array("messagee"=>"Department Added !"); 
			echo json_encode($data);
		}

	}
	function getEmployeeMenuMappingList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT b.user_name, c.menu_label From menu_employee_mapping as a LEFT JOIN user_master as b on a.user_id= b.user_id LEFT JOIN menu_table as c on c.menu_id = a.menu_id ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}

	function empMenu(){
		//header('Content-Type: application/json');
		//$userId = $this->session->userdata('user_id');
		$userId = 252;
		$contentData = $this->mdl_common->allSelects('SELECT menu_id FROM menu_employee_mapping WHERE user_id='.$userId);
		if(!empty($contentData)){
			$data = "[{";
			$i = 0;
			$j = 0;
			foreach ($contentData as $key => $value) {
				$count = count($contentData);
				$contentData2 = $this->mdl_common->allSelects('SELECT * FROM menu_table WHERE menu_id='.$value['menu_id']);
				if(!empty($contentData2)){
					foreach ($contentData2 as $key2 => $value2) {
						$data .="label:'".$value2['menu_label']."',";
						$data .="iconClasses:'".$value2['menu_icon_class']."',";
						$data .="html:'".$value2['menu_html']."',";
						
						$contentData3 = $this->mdl_common->allSelects('SELECT * FROM sub_menu_table WHERE menu_id='.$value['menu_id']);
						if(!empty($contentData3)){
							$data .= "children: [{";
							$count2 = count($contentData3);	
							foreach ($contentData3 as $key3 => $value3) {
								$data .="label:'".$value3['sub_menu_label']."',";
								$data .="url:'".$value3['sub_menu_url']."'";
								$j++;
								if($j != $count2){
									$data .="},{";
								}
							}
							$j =0;
							$data .= "}]";
						}else{
							$data .="url:'".$value2['menu_url']."'";
						}
					}
				}
				$i++;
				if($i != $count){
					$data .="},{";
				}
			}
			$data .= "}]";
			echo $data;
		}
	}
	
	function getEmployeeList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects(' SELECT b.user_name, c.department_name From menu_add_employee as a LEFT JOIN user_master as b on a.user_id= b.user_id LEFT JOIN menu_add_department as c on c.department_id = a.department_id ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}


	function getMenuList(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT * From menu_table ');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
		echo json_encode($arr);
		}else{
		}
	}

	function addMenu(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['menu'])&&!empty($_POST['menu'])){
		}else{
			$data = array("message"=>"Menu  Required !"); 
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['employee'])&&!empty($_POST['employee'])){
		}else{
			$data = array("message"=>"Employee  Required !"); 
			echo json_encode($data);
			return  ;
		}

		foreach ($_POST['menu'] as $value) {
			$Arr = array(
				'user_id'=>$_POST['employee'],
				'menu_id'=>$value,
			);
			$this->db->insert('menu_employee_mapping',$Arr);
		}

		$data = array("messagee"=>"Menu Added To Employee !"); 
		echo json_encode($data);
		

	}


	
	function addEmployee(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['department_id'])&&!empty($_POST['department_id'])){
		}else{
			$data = array("message"=>"Department Name Required !"); 
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['employee_name'])&&!empty($_POST['employee_name'])){
			$_POST['employee_name'] = preg_replace('/\s+/', '', $_POST['employee_name']);
		}else{
			$data = array("message"=>"Employee Name Required !"); 
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['employee_pass'])&&!empty($_POST['employee_pass'])){
		}else{
			$data = array("message"=>"Employee Password Required !"); 
			echo json_encode($data);
			return  ;
		}

		$insertArr = array(
				'user_name'=>$_POST['employee_name'],
				'user_email'=>$_POST['employee_name'].'@gmail.com',
				'user_password'=>md5($_POST['employee_pass']),
				'parent_id'=> -100,
				'lft_user'=> -100,
				'rght_user'=> -100,
				'user_type'=>'employee',
				'form_status'=>10,
		);
		if(!$this->db->insert('user_master',$insertArr)){
			$data = array('message'=>$this->db->_error_message());
			echo json_encode($data);
		}else{
			$last_id =  $this->db->insert_id();
			$insertArray = array(
				'user_id'=>$last_id,
				'department_id'=>$_POST['department_id'],
			);
			$this->db->insert('menu_add_employee',$insertArray);
			$data = array("messagee"=>"Employee Added !"); 
			echo json_encode($data);
		}

	}

	

	

	
}