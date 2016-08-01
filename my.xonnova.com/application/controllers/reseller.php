<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Reseller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}	

	function index(){
		$userType = $this->session->userdata('user_type');

		if(isset($userType) && !empty($userType) && $userType == 'clien'){
			$data['cur_user_id']	=	$this->session->userdata('user_id');
			$data['content'] = 'reseller/body';
			$this->load->view('reseller/layout',$data);
		}else{
			$data['lacitve'] = 'active';
			//$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
			//$data['content'] = 'login_view';
			$this->load->view('indexreseller',$data);
		}
	}
}