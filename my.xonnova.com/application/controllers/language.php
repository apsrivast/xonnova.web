<?php
/**
* 
*/
class Language extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function menuLabel(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM content_language_info WHERE label_status="active" AND label_type="1"');
		$cuntry = strtolower($this->session->userdata('language_code'));

		if(!empty($contentData) && !empty($cuntry)){
			$data = '{';
			$i = 0;
			if($cuntry == "es"){
				foreach ($contentData as $key => $value) {
					$count = count($contentData);
					//$arr[]=$value;
					$data .='"'.$value['label_code'].'":"'.$value['es_label'].'"';
					$i++;
					if($i != $count){
						$data .=',';
					}
				}
			}else{
				foreach ($contentData as $key => $value) {
					$count = count($contentData);
					//$arr[]=$value;
					$data .='"'.$value['label_code'].'":"'.$value['us_label'].'"';
					$i++;
					if($i != $count){
						$data .=',';
					}
				}
			}
			
			$data .= '}';
			echo $data;
		}else{

		}
	}

	function contentLabel(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM content_language_info WHERE label_status="active" AND label_type="2"');
		$cuntry = strtolower($this->session->userdata('language_code'));

		if(!empty($contentData) && !empty($cuntry)){
			$data = '{';
			$i = 0;
			if($cuntry == "es"){
				foreach ($contentData as $key => $value) {
					$count = count($contentData);
					//$arr[]=$value;
					$data .='"'.$value['label_code'].'":"'.$value['es_label'].'"';
					$i++;
					if($i != $count){
						$data .=',';
					}
				}
			}else{
				foreach ($contentData as $key => $value) {
					$count = count($contentData);
					//$arr[]=$value;
					$data .='"'.$value['label_code'].'":"'.$value['us_label'].'"';
					$i++;
					if($i != $count){
						$data .=',';
					}
				}
			}
			
			$data .= '}';
			echo $data;
		}else{

		}
	}
}