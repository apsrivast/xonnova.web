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


	function editTraningVideobyID($id){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_tutorial_info Where v_t_id = '.$id);
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}



	function editTraningVideo($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);

			$updateArr = array(
							'cat_id'=>$_POST['cat_id'],
							'message'=>$_POST['message'],
							'country_code'=>$_POST['country_code'],
							'url'=>$_POST['url'],
			);
			if(!$this->db->update('videos_tutorial_info',$updateArr, array('v_t_id'=>$id))){
				$data = array('message'=>$this->db->_error_message());
				echo json_encode($data);				
			}else{
				$data = array('messagee'=>'Edited');
				echo json_encode($data);
			}
	}

	function getMMCategoryParentID(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM materials_category_info Where c_type = 1');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}

	function getTVCategoryParentID(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_category_info Where c_type = 1');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
	
	
	function addVideosUrlTutorialsfield(){
		$_POST = json_decode(file_get_contents("php://input"),true);
	
			

		   
	       
				if(!empty($_POST['country'])){
					$country = $_POST['country'];
				}else{
					$data = array('err'=>'Sorry....  country field is required!');
					echo json_encode($data);
					return ;
				}
				if(!empty($_POST['video_message'])){
					$message = $_POST['video_message'];
				}else{
					$message = "";
				}

				if(!empty($_POST['category_name'])){
					$category = $_POST['category_name'];
				}else{
					$data = array('err'=>'Sorry....  category field is required!');
					echo json_encode($data);
					return ;
				}

				if(!empty($_POST['filefield'])){
					$file = $_POST['filefield'];
				}else{
					$data = array('err'=>'Sorry....  video field is required!');
					echo json_encode($data);
					return ;
				}
				
				$y = explode('.', $_POST['filefield']);
				

				$date = date("ymdHis");
				$filename = './tutorials/videos/'.$_POST['filefield'];

				if(preg_match("/^mp4$/i", $y[1])){
					if (file_exists($filename)) {
					   rename('./tutorials/videos/'.$_POST['filefield'], './tutorials/videos/'.$date.".mp4");
					   $file = $date.".mp4";
					} else {
					   
					    $data = array('err'=>'Sorry....  The file  does not exist!');
						echo json_encode($data);
						return ;
					}
					
				}elseif(preg_match("/^wmv$/i", $y[1])){
					/* if (file_exists($filename)) {
					   rename('./tutorials/videos/'.$_POST['filefield'], './tutorials/videos/'.$date.".wmv");
					   $file = $date.".wmv";
					} else { */
					   
					    /* $data = array('err'=>'Sorry....  The file  does not exist!'); */
						$data = array('err'=>'Sorry....  This Player Support only Mp4');
						echo json_encode($data);
						return ;
					/* } */
					
				}else{
					$data = array('err'=>'Sorry....  This Player Support only Mp4');
					echo json_encode($data);
					return ;

				}
				
				
				$insertArr = array(
								'cat_id'=>$category,
								'message'=>$message,
								'country_code'=>$country,
								//'video_subject'=>$name,
								'file_name'=>$file,
								'url'=>base_url().'tutorials/videos/'.$file,
								'tutorial_type'=>'2'
							);
				if(!$this->db->insert('videos_tutorial_info',$insertArr)){
					$data = array('err'=>'Sorry Error... '.$file.$this->db->_error_number().' =>'.$this->db->_error_message());
				}else{
					$data = array('sucess'=>'Tutorials Uploaded Successfully!');
				}
			
		
		echo json_encode($data);
	}
	
	
	function getTrainingTutorialsVideoUserSide($id){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_tutorial_info Where cat_id = '.$id);
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}


	function getTrainingTutorialsCatgeryUserSide(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM videos_category_info ');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}

	

	function getMarketingMaterialsUserSide($id){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM materials_tutorial_info Where cat_id = '.$id);
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}


	function getMarketingMaterialsCatgeryUserSide(){
		header('Content-Type: application/json');
		$query = $this->mdl_common->allSelects('SELECT * FROM materials_category_info ');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}



	function deleteTrainingVideos(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('videos_tutorial_info',array('v_t_id'=>$_POST['v_t_id']));
	}

	function deleteMarketingMaterials(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('materials_tutorial_info',array('v_t_id'=>$_POST['v_t_id']));
	}


	
	function getTrainingVideosCategory(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM videos_category_info');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
		
	}

	function getTrainingVideosCategoryById($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM videos_category_info where v_c_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function updateTrainingVideosCategory(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'category_name'=>$_POST['category_name'],
				'category_status'=>$_POST['category_status'],
				'message'=>$_POST['message']
			);
		$this->db->update('videos_category_info',$updateArr, array('v_c_id'=>$_POST['v_c_id']));
	}
	function deleteTrainingVideosCategory($id){
		return $this->db->delete('videos_category_info',array('v_c_id'=>$id));
	}
	function getMarketingMaterialsCategory(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM materials_category_info');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
		
	}

	function getMarketingMaterialsCategoryById($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM materials_category_info where v_c_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function updateMarketingMaterialsCategory(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'category_name'=>$_POST['category_name'],
				'category_status'=>$_POST['category_status'],
				'message'=>$_POST['message']
			);
		$this->db->update('materials_category_info',$updateArr, array('v_c_id'=>$_POST['v_c_id']));
	}
	function deleteMarketingMaterialsCategory($id){
		return $this->db->delete('materials_category_info',array('v_c_id'=>$id));
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

	function addVideosUrlTutorials(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		// if(!empty($_POST['category_name'])){
		// 	$category = $_POST['category_name'];
		// }else{
		// 	$category = "";
		// }

		if(!empty($_POST['video_message2'])){
			$message = $_POST['video_message2'];
		}else{
			$message = "";
		}
		if(isset($_POST) && !empty($_POST)){
			$insertArr = array(
								'cat_id'=>$_POST['category_name2'],
								'message'=>$message,
								'country_code'=>$_POST['country2'],
								//'video_subject'=>$name,
								//'file_name'=>$file,path2
								'url'=>$_POST['path2'],
								'tutorial_type'=>'1'
							);
				if(!$this->db->insert('videos_tutorial_info',$insertArr)){
					$data = array('err'=>'Sorry Error... ');
				}else{
					$data = array('sucess'=>'Tutorials Uploaded Successfully!');
				}
			
		}else{
			$data = array('err'=>'Error ... !');
		}
		echo json_encode($data);
	}
	function addVideosTutorials(){
		if(!empty($_FILES)) {
			$date = date("ymdHis");
		    $file = 'tutorials_'.$date.$_FILES['file']['name'];

		    $configVideo['upload_path'] = './tutorials/videos/';
	        $configVideo['max_size'] = '2000240000';
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
								'tutorial_type'=>'2'
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
		if(!empty($_POST['c_type'])){
		}else{
			$data = array('err'=>'Tpye required ... !');
			echo json_encode($data);
			return;
		}
		if(!empty($_POST['p_id'])){
		}else{
			$_POST['p_id']=0;
		}
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
					'c_type'=>$_POST['c_type'],
					'p_id'=>$_POST['p_id'],
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
		$query = $this->mdl_common->allSelects('SELECT a.*, b.* FROM materials_category_info as a RIGHT JOIN  materials_tutorial_info as b on b.cat_id=a.v_c_id ORDER BY b.v_t_created_at DESC');
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

		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$file = 'tutorials'.$date.'.pdf';
			}else{
				$file = 'tutorials'.$date.'.png';
			}

		    $configVideo['upload_path'] = './tutorials/videos/';
	        $configVideo['max_size'] = '20024000';
	        $configVideo['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
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
				if(!$this->db->insert('materials_tutorial_info',$insertArr)){
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
		if(!empty($_POST['c_type'])){
		}else{
			$data = array('err'=>'Tpye required ... !');
			echo json_encode($data);
			return;
		}
		if(!empty($_POST['p_id'])){
		}else{
			$_POST['p_id']=0;
		}
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
					'c_type'=>$_POST['c_type'],
					'p_id'=>$_POST['p_id'],
					'category_name'=>$category,
					'message'=>$message,
				);
			if(!$this->db->insert('materials_category_info',$insertCategory)){
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
		$query = $this->mdl_common->allSelects('SELECT * FROM materials_category_info ORDER BY v_c_created_at DESC');
		if(!empty($query)){
			foreach ($query as $key => $value) {
				$arr[]= $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
}