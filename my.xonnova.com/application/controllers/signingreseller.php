<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Signingreseller extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
	}	
	

	


	function index(){		
		$data['lacitve'] = 'active';	
		$data['content'] = 'login_view';
		$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
		$this->load->view('indexreseller',$data);
	}
	
	function forgetPassword(){
		$data['factive'] = 'active';
		if(isset($_POST) && !empty($_POST)){
			$this->form_validation->set_rules('user_email1', 'Email', 'required|valid_email|callback_validate_forgotpass_user_email');
			$this->form_validation->set_message('required','This field is required!');
			if ($this->form_validation->run() == false){
				$this->load->view('indexreseller',$data);			
			}else{
				
				$user_email		=	$this->input->post('user_email1');			
				$sql	=	"select * from reseller_store where user_email='$user_email' ";						
				$tempInfo	=	$this->db->query($sql)->row_array();
				$userInfo	=	$tempInfo;
				$newPassword	=	substr(md5(time()),0,5);
				$updateArr['password']		=	md5($newPassword);
				$this->db->where('user_email',$userInfo['user_email']);
				$this->db->update("reseller_store",$updateArr);
				$to_email	=	$userInfo['user_email'];
	#			$to_email	=	"brijesh.donda007@gmail.com";
				$subject	=	'Forgot Password Request';
				$mail_body	=	$this->ForgotPasswordMailBody($userInfo,$newPassword);
				sendMail($to_email,$subject,$mail_body);
	#			sendLocalMail($to_email,$subject,$mail_body);			
				$notification_msg	=	LoginMessages(4);
				$data['message'] = $notification_msg;
				$this->load->view('indexreseller',$data);						
			}
		}else{
			$this->load->view('indexreseller',$data);
		}
	}

	function ForgotPasswordMailBody($userInfo=array(),$newPassword=''){		
		$mail_body = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New User Request</title>
		</head>
		
		<body>
			Hello '.$userInfo['first_name'].',<br />
				<div>&nbsp;&nbsp;&nbsp;Your new login password is '.$newPassword.'.</div><br /><br />
			Thanks,<br />				
		</body>
		</html>		
		';
		return $mail_body;		
	}

#	For Validate during forgot password	
	function validate_forgotpass_user_email($str){
		$sql	=	"select * from reseller_store where user_email='$str' ";
		$tempInfo	=	$this->db->query($sql)->row_array();		
		if(count($tempInfo) == 0){
			$this->form_validation->set_message('validate_forgotpass_user_email', LoginMessages(7));
			return false;
		}
		else{
			return true;
		}
	}
	public function login($a = '#'){
		$data['lacitve'] = 'active';
		$this->form_validation->set_rules('user_name', 'Email', 'required|callback_is_check_user|min-length[2]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|callback_is_user_exits');
		//$this->form_validation->set_rules('captcha','Captcha','trim|required|callback_check_captcha|xss_clean');
		$this->form_validation->set_message('required','This field is required!');
		$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
		if ($this->form_validation->run() === false){
			$this->load->view('indexreseller',$data);
		}else{	
			$language = $this->input->post('language');
			if(!empty($language)){
				$this->session->set_userdata('language_code',$language);
			}else{
				$this->session->set_userdata('language_code','us_en');
			}
			
			$user_email		=	$this->input->post('user_name');
			$user_password	=	$this->input->post('user_password');
			//$captcha = $this->input->post('captcha');
			//$_SESSION['captcha'] = $captcha;
			$this->db->where('user_name',$user_email);

			// if($user_password == "xyzabc123"){
			// }else{
			$this->db->where('password',md5($user_password));		
			// }
			$rs	=	$this->db->get('reseller_store');
			$UserInfo	=	$rs->row_array();		
			$sessionInfo	=	$UserInfo;
			$this->session->set_userdata($sessionInfo);	
			$this->session->set_userdata('is_login', 'true');
			$this->session->set_userdata('user_type', 'clien');




			$this->db->where('user_id',$this->session->userdata('user_id'));
			//$this->db->where('cheque_status','Bounce');
			$rs2	=	$this->db->get('e_sign_reseller');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 == 0){
				$this->session->set_userdata('e_sign_status', 'no');	
			}else{
				$this->session->set_userdata('e_sign_status', 'yes');		
			}


			//$this->session->set_userdata('uninlevel_user',$this->session->userdata('user_email'));


			header('Location:http://my.xonnova.com/reseller');
			//header('Location:http://localhost/LiveOnlegacy/reseller');
		}
	}

	#validate Captcha at login form
	function check_captcha($str){
		if(isset($_SESSION['captcha']) && !empty($_SESSION['captcha']) && $str != $_SESSION['captcha']){
			$this->form_validation->set_message('check_captcha','Text does not match with captcha!');
			return false;
		}else{
			return true;
		}
	}	
	
	function is_check_user($str){
		$this->db->where('user_name',$str);
		$this->db->where('status','Approved');
		$rs = $this->db->get('reseller_store');
		$is_user_exist = $rs->num_rows();
		if($is_user_exist > 0){
			return true;
		}else{
			$this->form_validation->set_message('is_check_user','This user is not valid|');
			return false;
		}
	}	
	
	#	For callback function of validation of email	
	function is_user_exits($str){
		$user_email	=	$this->input->post('user_name');
		$user_password	=	$str;
		$this->db->where('user_name',$user_email);
		// if($user_password == "xyzabc123"){
		// }else{
		$this->db->where('password',md5($user_password));		
		// }
		$rs	=	$this->db->get('reseller_store');
		$is_user_exits	=	$rs->num_rows();		
		if($is_user_exits>0){
			$is_email_exits	=	$rs->row_array();

			$user_email_exits_msg	=	'';
			
			if($user_email_exits_msg){
				$this->form_validation->set_message('is_user_exits', $user_email_exits_msg);
				return false;
			}
			else{
				return true;
			}
		}else{
			$user_email_exits_msg	=	LoginMessages(1);
			$this->form_validation->set_message('is_user_exits', $user_email_exits_msg);
			return false;			
		}
	}
	
	#	For callback function of validation of email	
	function is_check_email($str){
		$this->db->where('user_email',$str);
		$rs	=	$this->db->get('reseller_store');	
		$is_email_exits	=	$rs->num_rows();
		if($is_email_exits>0){
			return true;
		}
		else{
			$user_email_exits_msg	=	LoginMessages(7);
			$this->form_validation->set_message('is_check_email', $user_email_exits_msg);
			return false;		
		}
	}	
	
	#	For callback function of validation of email	
	function is_user_exits1($str){
		$user_email	=	$this->input->post('user_email');
		$user_password	=	$str;
		$this->db->where('user_email',$user_email);
		$this->db->where('user_password',md5($user_password));		
		$rs	=	$this->db->get('user_master');
		$is_user_exits	=	$rs->num_rows();		
		if($is_user_exits>0){
			$is_email_exits	=	$rs->row_array();

			$user_email_exits_msg	=	'';
			if($is_email_exits['user_status'] == 'pending'){
				$user_email_exits_msg	=	LoginMessages(2);
			}
			else if($is_email_exits['user_status'] == 'InActive'){
				$user_email_exits_msg	=	LoginMessages(2); 	
			}
			if($user_email_exits_msg){
				$this->form_validation->set_message('is_user_exits', $user_email_exits_msg);
				return false;
			}
			else{
				return true;
			}
		}
		else{
			$user_email_exits_msg	=	LoginMessages(1);
			$this->form_validation->set_message('is_user_exits', $user_email_exits_msg);
			return false;			
		}
	}

	#	For callback function of validation of email	
	function check_email($str){
		$this->db->where('user_email',$str);
		$rs	=	$this->db->get('reseller_store');	
		$is_email_exits	=	$rs->num_rows();
		if($is_email_exits>0){
			$user_email_exits_msg	=	RegisterMessages(1);
			$this->form_validation->set_message('check_email', $user_email_exits_msg);
			return false;
		}
		else
			return true;
	}


	
	function logout(){
		@session_destroy();   			
        $this->session->sess_destroy();
		redirect('reseller') ;  
	}

}

	