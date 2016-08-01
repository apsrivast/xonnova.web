<?php
/**
* 
*/
class Tools extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}
	
	function getTrainingVideosTutorials(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT a.*, b.* FROM videos_category_info as a RIGHT JOIN  videos_tutorial_info as b on b.cat_id=a.v_c_id ORDER BY b.v_t_created_at DESC');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}

	function addVideosTutorials(){
		if(!empty($_FILES)) {
			$date = date("ymdHis");
		    $file = 'tutorials_'.$date.$_FILES['file']['name'];

		    $configVideo['upload_path'] = './tutorials/videos/';
	        $configVideo['max_size'] = '200240';
	        $configVideo['allowed_types'] = 'avi|flv|wmv|mp3|mkv|mp4';
	        $configVideo['overwrite'] = FALSE;
	        $configVideo['remove_spaces'] = TRUE;
	        $configVideo['file_name'] = $file;

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array('err'=>"Sorry... ".$this->upload->display_errors());
			}else{
				if(!empty($_POST['country'])){
					$country = $_POST['country'];
				}else{
					$country = "";
				}
				if(!empty($_POST['video_message'])){
					$message = $_POST['video_message'];
				}else{
					$message = "";
				}

				if(!empty($_POST['category_name'])){
					$category = $_POST['category_name'];
				}else{
					$category = "";
				}
				$insertArr = array(
								'cat_id'=>$category,
								'message'=>$message,
								'country_code'=>$country,
								//'video_subject'=>$name,
								'file_name'=>$file,
								'url'=>base_url().'tutorials/videos/'.$file,
								'tutorial_type'=>'1'
							);
				if(!$this->db->insert('videos_tutorial_info',$insertArr)){
					$data = array('err'=>'Sorry Error... '.$file.$this->db->_error_number().' =>'.$this->db->_error_message());
				}else{
					$data = array('sucess'=>'Tutorials Uploaded Successfully!');
				}
			}
		}else{
			$data = array('err'=>'Sorry....  Browse field is required!');
		}
		echo json_encode($data);
	}

	function addVideosCategory(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['category_name'])){
			$category = $_POST['category_name'];
		}else{
			$category = "";
		}

		if(!empty($_POST['message'])){
			$message = $_POST['message'];
		}else{
			$message = "";
		}
		if(isset($category) && !empty($category)){
			$insertCategory = array(
					'category_name'=>$category,
					'message'=>$message,
				);
			if(!$this->db->insert('videos_category_info',$insertCategory)){
				$data = array('err'=>"Sorry .... Category Not Created");
			}else{
				$data = array('sucess'=>"Category Created Sucessfully");
			}
		}else{
			$data = array('err'=>'Error ... !');
		}
		echo json_encode($data);
	}

	function getVideosCategory(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_category_info ORDER BY v_c_created_at DESC');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
	
	function getTrainingVideosTutorials2(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT a.*, b.* FROM videos_category_info as a RIGHT JOIN  videos_tutorial_info as b on b.cat_id=a.v_c_id ORDER BY b.v_t_created_at DESC');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}

	function addVideosTutorials2(){
		if(!empty($_FILES)) {
			$date = date("ymdHis");
		    $file = 'tutorials_'.$date.$_FILES['file']['name'];

		    $configVideo['upload_path'] = './tutorials/videos/';
	        $configVideo['max_size'] = '200240';
	        $configVideo['allowed_types'] = 'avi|flv|wmv|mp3|mkv|mp4';
	        $configVideo['overwrite'] = FALSE;
	        $configVideo['remove_spaces'] = TRUE;
	        $configVideo['file_name'] = $file;

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array('err'=>"Sorry... ".$this->upload->display_errors());
			}else{
				if(!empty($_POST['country'])){
					$country = $_POST['country'];
				}else{
					$country = "";
				}
				if(!empty($_POST['video_message'])){
					$message = $_POST['video_message'];
				}else{
					$message = "";
				}

				if(!empty($_POST['category_name'])){
					$category = $_POST['category_name'];
				}else{
					$category = "";
				}
				$insertArr = array(
								'cat_id'=>$category,
								'message'=>$message,
								'country_code'=>$country,
								//'video_subject'=>$name,
								'file_name'=>$file,
								'url'=>base_url().'tutorials/videos/'.$file,
								'tutorial_type'=>'1'
							);
				if(!$this->db->insert('videos_tutorial_info',$insertArr)){
					$data = array('err'=>'Sorry Error... '.$file.$this->db->_error_number().' =>'.$this->db->_error_message());
				}else{
					$data = array('sucess'=>'Tutorials Uploaded Successfully!');
				}
			}
		}else{
			$data = array('err'=>'Sorry....  Browse field is required!');
		}
		echo json_encode($data);
	}

	function addVideosCategory2(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['category_name'])){
			$category = $_POST['category_name'];
		}else{
			$category = "";
		}

		if(!empty($_POST['message'])){
			$message = $_POST['message'];
		}else{
			$message = "";
		}
		if(isset($category) && !empty($category)){
			$insertCategory = array(
					'category_name'=>$category,
					'message'=>$message,
				);
			if(!$this->db->insert('videos_category_info',$insertCategory)){
				$data = array('err'=>"Sorry .... Category Not Created");
			}else{
				$data = array('sucess'=>"Category Created Sucessfully");
			}
		}else{
			$data = array('err'=>'Error ... !');
		}
		echo json_encode($data);
	}

	function getVideosCategory2(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_category_info ORDER BY v_c_created_at DESC');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
}