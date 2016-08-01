<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}	

	function index(){
		$userType = $this->session->userdata('user_type');

		if(isset($userType) && !empty($userType) && $userType == 'admin'){
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'user') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'user/body';
			return $this->load->view('user/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'client') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'emp') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'employee') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'shipping') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}elseif (isset($userType) && !empty($userType) && $userType == 'support') {
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'admin/body';
			return $this->load->view('admin/layout',$data);
		}else{
			$data['lacitve'] = 'active';
			$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
			//$data['content'] = 'login_view';
			return $this->load->view('index',$data);
		}
	}	
}