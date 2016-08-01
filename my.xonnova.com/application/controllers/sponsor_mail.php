<?php
/**
* 
*/
class Sponsor_mail extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		//header('Content-Type: application/json');
	}
	
	function sendWelcomeNote($sponsorID, $userID){
			$UserName = $this->mdl_common->getUserNameById($sponsorID);
			$to_email = $this->mdl_common->getSIMuseremail($userID);
			$sponsor_email = $this->mdl_common->getSIMuseremail($sponsorID);
			$sponsor_phone = $this->mdl_common->getSIMuserphone($sponsorID);
			$sponsor_full_name = $this->mdl_common->getuserFullName($sponsorID);

			$config['protocol'] = 'sendmail';
	        $config['mailpath'] = '/usr/sbin/sendmail';
	        $config['charset'] = 'iso-8859-1';
	        $config['wordwrap'] = TRUE;
	        $config['mailtype'] = 'html';
	        $this->email->initialize($config);
	        $this->email->from('info@xonnova.com', 'xonnova Network');
	        $this->email->to($to_email);
	        $this->email->subject('Welcome Note');
	        $mail_body	='<div>
	        				<p>Hello my name is '.$sponsor_full_name.', and I am part of your support team, and my username is '.$UserName.' please feel free to contact me if you have any questions at '.$sponsor_email.' or call me at '.$sponsor_phone.' any time you need me. I want to welcome you to the xonnova Network Family.</p>
        				</div>';
	        $this->email->message($mail_body);
	        $this->email->send();
	}
}