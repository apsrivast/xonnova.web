<?php
/**
* 
*/
class Site_info extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		$data['folder'] = directory_map(FCPATH, 1);
		$this->load->view('site_info_view',$data);
	}

	public function deleteFolder(){
		$data['folder'] = directory_map(FCPATH, 1);
		$this->form_validation->set_rules('folder_name','Name','trim|required|callback_check_folder|xss_clean');
		$this->form_validation->set_message('required','This field is required!');
		if ($this->form_validation->run() === false){
			
			$this->load->view('site_info_view',$data);
		}else{
			$folder = $this->input->post('folder_name');
			$data['message'] = "Folder Deleted sucessfully!";
			if (file_exists(FCPATH.$folder)) {
				$this->mdl_common->deletesite(FCPATH.$folder);
			}
			$this->load->view('site_info_view',$data);
		}
	}

	function check_folder($str){
		if (file_exists(FCPATH.$str)) {
			return true;
		}elseif(empty($str) && $str == ""){
			$this->form_validation->set_message('check_folder','This field is required!');
			return false;
		}else{
			$this->form_validation->set_message('check_folder','This folder is NOT exists!');
			return false;
		}
	}
}