<?php
/**
* 
*/
class News_section_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}
	
	function getNewsTotalCount(){
		header('Content-Type: application/json');
		$total1 = count($this->mdl_common->allSelects('SELECT * From news_section '));
		$total2 = count($this->mdl_common->allSelects('SELECT * From news_user_mapping  WHERE user_id = '.$this->session->userdata('user_id')));
		$total = $total1 - $total2;
		echo json_encode($total);
	}


	function editNewsSection(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['news_title']) && !empty($_POST['news_title'])){
		}else{
			$data = array("message"=>"Title field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['news_content']) && !empty($_POST['news_content'])){
		}else{
			$data = array("message"=>"Content field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['news_priority']) && !empty($_POST['news_priority'])){
		}else{
			$data = array("message"=>"Priority field is required !");
			echo json_encode($data);
			return  ;
		}
		$insertArr = array(
		
			'news_title'=>$_POST['news_title'],
			'news_content'=>$_POST['news_content'], 	
			'news_priority'=>$_POST['news_priority'],

		);

		if(!$this->db->update('news_section',$insertArr,array('news_id'=>$_POST['news_id']))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'News Edited successfully ! ');
			echo json_encode($data );
		}
	}



	function getNewsUserList(){
		header('Content-Type: application/json');
		// $list = $this->mdl_common->allSelects('SELECT * From news_section ORDER BY news_priority DESC ');
		$list = $this->mdl_common->allSelects('SELECT * From news_section  WHERE status = "act"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}



	function getNewsUserListByID($id){
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * From news_section where news_id ='.$id );
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}


	function addNews(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['news_title']) && !empty($_POST['news_title'])){
		}else{
			$data = array("message"=>"Title field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['news_content']) && !empty($_POST['news_content'])){
		}else{
			$data = array("message"=>"Content field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['news_priority']) && !empty($_POST['news_priority'])){
		}else{
			$data = array("message"=>"Priority field is required !");
			echo json_encode($data);
			return  ;
		}
		$insertArr = array(
		
			'news_title'=>$_POST['news_title'],
			'news_content'=>$_POST['news_content'], 	
			'news_priority'=>$_POST['news_priority'],

		);
			

		if(!$this->db->insert('news_section',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'News Added successfully ! ');
			echo json_encode($data );
		}
	}


	function getNewsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From news_section   WHERE status = "act"  AND news_datetime BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From news_section WHERE status = "act"');
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


	function deleteNews(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$insertArr = array(
			'status'=>'inact',
		);
		$this->db->update('news_section',$insertArr,array('news_id'=>$_POST['news_id']));
		//$this->db->delete('news_section',array('news_id'=>$_POST['news_id']));
	}

	
	


}