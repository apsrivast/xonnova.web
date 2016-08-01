<?php
/**
* 
*/
class Platform extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){

	}

	function updatePlatforms($id=null){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['id']) && !empty($_POST['platform_status'])){
			$updateArr = array(
				'platform_status'=>$_POST['platform_status'],
			);
			if(!$this->db->update('new_platform',$updateArr, array('id'=>$_POST['id']))){
				$data = array('message'=>'Platform Not Updated!');
			}else{
				$data = array('message'=>'Platform Update Sucess!');
			}
			echo json_encode($data);
		}else{
			$data = array('message'=>'Error! Invalid Data!');
			echo json_encode($data);
		}
	}



	function getMapping(){
		$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name, c.platforms_name From  platform_user_mapping as a LEFT JOIN user_master as b on a.mapping_user_id = b.user_id LEFT JOIN platforms_list as c on a.mapping_platform_id = c.id');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function getUserName(){
		$list = $this->mdl_common->allSelects('SELECT user_id, user_name From user_master  WHERE user_type = "user"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}


	function getPlatformName(){
		$list = $this->mdl_common->allSelects('SELECT id, platforms_name From platforms_list ');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	

	function addMapping(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST) && !empty($_POST)){
			foreach($_POST['mapping_user_id'] as $id ){
				foreach($_POST['mapping_platform_id'] as $platform ){
						$Arr = array(
								'mapping_user_id'=>$id,
								'mapping_platform_id'=>$platform,
							);
						$this->db->insert('platform_user_mapping',$Arr);
				}
			}
			$data = array('message'=>'Successfully Added.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Added.');
			echo json_encode($data);
		}
	}

	function deleteMapping(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('platform_user_mapping',array('mapping_id'=>$_POST['mapping_id']));
	}
	
	
	function getPlatformsListForUser(){
		header('Content-Type: application/json');
		/* $contentData = $this->mdl_common->allSelects('SELECT b.* FROM platform_user_mapping as a RIGHT JOIN platforms_list as b on a.mapping_platform_id = b.id WHERE a.mapping_user_id ='.$this->session->userdata('user_id')); */
		$contentData = $this->mdl_common->allSelects('SELECT * FROM platforms_list ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}
}