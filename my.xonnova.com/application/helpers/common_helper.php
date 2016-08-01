<?php
#Creating Pagination Link
function pagiationData($str,$num,$start,$segment,$perpage=20){
	$CI=& get_instance();
	$config['base_url'] = site_url('/').$str;
	$config['total_rows'] = $num;
	if($perpage)
		$config['per_page'] = $perpage;
	else
		$config['per_page'] = $CI->session->userdata('per_page');
	$config['uri_segment'] = $segment;
	$config['full_tag_open'] = '&nbsp;';
	$config['full_tag_close'] = '&nbsp;';
	
	$config['first_tag_open'] = '&nbsp;';
	$config['first_tag_close'] = '&nbsp;';
	$config['next_tag_open'] = '&nbsp;';
	$config['next_tag_close'] = '&nbsp;';
	$config['num_tag_open'] = '&nbsp;';
	$config['num_tag_close'] = '&nbsp;';
	$config['last_tag_open'] = '&nbsp;';
	$config['last_tag_close'] = '&nbsp;';
	$config['prev_tag_open'] = '&nbsp;';
	$config['prev_tag_close'] = '&nbsp;';
	$config['cur_tag_open'] = '&nbsp;';
	$config['cur_tag_close'] = '&nbsp;';
	
	$CI->pagination->initialize($config); 
	$query = $CI->db->last_query()." LIMIT ".$start." , ".$config['per_page'];
	$res = $CI->db->query($query);

	$data['listArr'] = $res->result_array();
	$data['num'] = $res->num_rows();
	$data['Total'] = $num;
	$data['links'] =  $CI->pagination->create_links();
	$ofpage = ($start + $data['num']);
	$data['pageinfo'] = 'Showing '.$start.'-'.$ofpage.' of '.$data['Total'];
	return $data;
}
#	To Get current logged in user type
function usertype(){
	$ci = & get_instance();
	$type = $ci->session->userdata('user_type');
	return $type;
}
	
function SetMsg($var,$msg){
	$ci = & get_instance();
	$ci->session->set_flashdata($var,$msg);
}

function GetMsg($var){
	$ci = & get_instance();	
	return $ci->session->flashdata($var);
}

//return single error message after form validation	
function GetFormError(){
	$CI =& get_instance();
	$errorarr=$CI->form_validation->_error_array;
	if(count($errorarr)===0)
	{
	   return FALSE;
	}
	else
	{
		foreach ($errorarr as $key => $val)
		{
			return $val;
		}
	}
}

#To check if user login as vendor or admin than redirect him back to default screen
function IsAdminUserLoggedin(){	
	$CI= & get_instance();
	$user_id=$CI->session->userdata('user_id');			
	$user_type=$CI->session->userdata('user_type');			
	if($user_id == '' && $user_type !='admin'){		
		redirect("signing");		
	}
}

function isAdminUserlogin(){
	$CI= & get_instance();
	$user_id=$CI->session->userdata('user_id');			
	$user_type=$CI->session->userdata('user_type');	
	if($user_id<=0){
			redirect("admin_login");
	}
}

//All the Message for the Login Panel		
function LoginMessages($msg_id=0){
	$MsgArr=array(
						1=>'Invalid Username/Password Combination', //Login Failure
						2=>'Your account is not activated.', //For inactive Account
						3=>'Your account is deleted please contact administrator.', //For deleted Accounts
						4=>'Your password key is generated and sent to the your email address..', //For deleted Accounts
						5=>'Invalid Access key to change password', //Fake Activation Key to Set new Password
						6=>'Activation key is Expired',
						7=>'Email Address not Exists.',
						8=>'Activation key is not valid or it is expire.',
						9=>'Account is activates successfully.Now you can login.',
						10=>'Password Recovered Successfully, Login to Access.',
						11=>"You don't have access.To access vendor part.",
						12=>"You don't have access.To access admin part.",						
						13=>"Please login to access this part.",
					);
	#pre($MsgArr);				
	return $MsgArr[$msg_id];
}

function RegisterMessages($msg_id=0){
	$MsgArr=array(
						1=>'User already exixts', //Login Failure
						2=>'Your account is not activated.', //For inactive Account
						3=>'Your account is deleted please contact administrator.', //For deleted Accounts
						4=>'Your password key is generated and sent to the your email address..', //For deleted Accounts
						5=>'Invalid Access key to change password', //Fake Activation Key to Set new Password
						6=>'Activation key is Expired',
						7=>'Email Address not Exists.',
						8=>'Activation key is not valid or it is expire.',
						9=>'Account is activates successfully.Now you can login.',
						10=>'Password Recovered Successfully, Login to Access.',
						11=>"You don't have access.To access vendor part.",
						12=>"You don't have access.To access admin part.",						
						13=>"Please login to access this part.",
					);
	#pre($MsgArr);				
	return $MsgArr[$msg_id];
}

//All the Message for the User Page		
function UserMessages($msg_id=0){
	$MsgArr=array(
						1=>'User Created Successfully.', 
						2=>'User Information Update Successfully.', 
						3=>'User Deleted Successfully.', 
					);
	#pre($MsgArr);				
	return $MsgArr[$msg_id];
}

//All the Message for the Service
function ServiceMessages($msg_id=0){
	$MsgArr=array(
						1=>'Service Created Successfully.', 
						2=>'Service Information Update Successfully.', 
						3=>'Service Deleted Successfully.', 
					);
	#pre($MsgArr);				
	return $MsgArr[$msg_id];
}

//All the Message for the Package
function PackageMessages($msg_id=0){
	$MsgArr=array(
						1=>'Package Created Successfully.', 
						2=>'Package Information Update Successfully.', 
						3=>'Package Deleted Successfully.', 
					);
	#pre($MsgArr);				
	return $MsgArr[$msg_id];
}

/*
++++++++++++++++++++++++++++++++++++++++++++++
	Valid Image file extension function
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/	
function ValidImageExt(){
	$dropdown = array('gif'=>'gif',						  
					  'jpg'=>'jpg',
					  'jpeg'=>'jpeg',
					  'png'=>'png',
					  'bmp'=>'bmp',
					  );
	return $dropdown;
}

//Print prev screen for array	
function pre($str){
	echo '<pre>';
	print_r($str);
	echo '</pre>';
}
	
function last_query() //print last executed query
{
	$CI= & get_instance();
	pre($CI->db->last_query());
}

/*
++++++++++++++++++++++++++++++++++++++++++++++
	To Check Wheather user is login or not
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/		
function IsUserLogin(){
	$CI= & get_instance();
	$user_id=$CI->session->userdata('user_id');			
	$user_type=$CI->session->userdata('user_type');			
	if($user_id == '' && $user_type != 'user'){		
		redirect("signing");		
	}
}

function IsAdminLogin(){
	$CI= & get_instance();
	$user_id=$CI->session->userdata('user_id');			
	$user_type=$CI->session->userdata('user_type');			
	if($user_id == '' && $user_type !='admin'){		
		redirect("signing");		
	}
}

/*
++++++++++++++++++++++++++++++++++++++++++++++
	Upload File shortcut function.
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/	
function uploadFile($uploadFile,$filetype,$folder,$fileName=''){
	$CI=& get_instance();
	$resultArr = array();
	$config['max_size'] = '1024000';
	if($filetype == 'img') 	$config['allowed_types'] = 'gif|jpg|png|jpeg';
	if($filetype == 'All') 	$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|zip|xls';
	if($filetype == 'csv') 	$config['allowed_types'] = 'csv';
	if($filetype == 'swf') 	$config['allowed_types'] = 'swf';
	if($filetype == 'mp3') 	$config['allowed_types'] = 'mp3|wma|wav|.ra|.ram|.rm|.mid|.ogg';
	if($filetype == '*') 	$config['allowed_types'] = '*';
	
	if(strpos($folder,'application/views') !== FALSE)
		$config['upload_path'] = './'.$folder.'/';
	else
		$config['upload_path'] = './uploads/'.$folder.'/';

	if($fileName != "")
		$config['file_name'] = $fileName;
	
	$CI->load->library('upload', $config);
	$CI->upload->initialize($config);
	
	if(!$CI->upload->do_upload($uploadFile))
	{
		$resultArr['success'] = false;
		$resultArr['error'] = $CI->upload->display_errors();
	}	else	{
		$resArr = $CI->upload->data();
		$resultArr['success'] = true;
		
		if(strpos($folder,'application/views') !== FALSE){
			$resultArr['path'] = $folder."/".$resArr['file_name'];
		}
		else {
			$resultArr['path'] = "uploads/".$folder."/".$resArr['file_name'];
		}
	}
	return $resultArr;
}

/*
++++++++++++++++++++++++++++++++++++++++++++++
	Mail send shortcut function.
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function sendMail($toEmail,$subject,$mail_body,$from_email='',$from_name = '',$bcc_email='',$file_path = ''){
	$from_name = 'xonnova Network ';
	$C =& get_instance();
	$C->load->library('email');
	$config['mailtype'] = 'html';
	$config['protocol'] = 'sendmail';
	$config['mailpath'] = '/usr/sbin/sendmail';
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	
	$C->email->initialize($config);
	if($from_email){
		$C->email->from($from_email,$from_name);
	}
	else{
		$C->email->from('info@xonnova.com',$from_name);
	}
	$C->email->to($toEmail);
	if($bcc_email){
		$C->email->bcc($bcc_email);		
	}
	$C->email->subject($subject);
	$C->email->message($mail_body);
	$C->email->send();
#	echo $C->email->print_debugger();
#	unset($C);
}
/*
++++++++++++++++++++++++++++++++++++++++++++++
	Sending Mail from local
	Pass parameters according described in functions
	parameters.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function sendLocalMail($emailId,$subject,$mail_body){
	$C= & get_instance();	
	$C->load->helper('phpmailer');
	$mail = new PHPMailer();	
	$mail->IsSMTP();
	$mail->IsHTML(true); // send as HTML	
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port 
	$mail->Username   = "";		       // GMAIL username
	$mail->Password   = "";            // GMAIL password	
	$mail->From       = '';
	$mail->FromName   = "Cooling BIDS";
	$mail->Subject    = $subject;
	$mail->Body       = $mail_body;           //HTML Body
	
	$emails  = explode(",",$emailId);
	foreach($emails as $email)
		   $mail->AddAddress($email);
	if(!$mail->Send())
		echo "Mailer Error: " . $mail->ErrorInfo;
}