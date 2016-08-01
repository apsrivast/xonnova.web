<?php
/**
* 
*/
class Reseller_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}

	function userPdfByIDSmart_Mark($user_id){
		include('./mpdf/mpdf.php');
		$list = $this->mdl_common->allSelects('SELECT DISTINCT  pdf From e_sign_pdf WHERE  pdf !="" AND user_id = '.$user_id.'  LIMIT 1');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
				$mpdf->WriteHTML($value['pdf']);
				$mpdf->Output();
			}
		}else{
			echo 'no pdf for this user';
		}
	}

	function userPdfByIDPRIVACY_POLICY($user_id){
		include('./mpdf/mpdf.php');
		$list = $this->mdl_common->allSelects('SELECT DISTINCT  pdf2 From e_sign_pdf WHERE  pdf2 !="" AND user_id = '.$user_id.'  LIMIT 1');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$mpdf2=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
				$mpdf2->WriteHTML($value['pdf2']);
				$mpdf2->Output();
			}
		}else{
			echo 'no pdf for this user';
		}
	}
	function userPdfByIDTERMS_N_CONDITIONS($user_id){
		include('./mpdf/mpdf.php');
		$list = $this->mdl_common->allSelects('SELECT DISTINCT  pdf3 From e_sign_pdf WHERE  pdf3 !="" AND user_id = '.$user_id.'  LIMIT 1');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$mpdf3=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
				$mpdf3->WriteHTML($value['pdf3']);
				$mpdf3->Output();
			}
		}else{
			echo 'no pdf for this user';
		}
	}

	function resendStoreAgreementApproved($id){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
		foreach ($userid as $user) {
				$this->send_deposit_mail_approved($user['user_email'], $user['first_name'] , $user['pass']);	
		}
		$data = array('message'=>'Store  Agreement  Approved Mail Send');
		echo json_encode($data);
	}
	function resendStoreUserApproved($id){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
		foreach ($userid as $user) {
				$this->send_deposit_mail($user['user_email'], $user['user_name'], $user['first_name'] , $user['pass']);	
		}
		$data = array('message'=>'Store User Approved Mail Send');
		echo json_encode($data);
	}


	function userPdf(){
		include('./mpdf/mpdf.php');
		$i = 0;
				

		$list = $this->mdl_common->allSelects('SELECT DISTINCT  user_id, pdf, pdf2, pdf3 From e_sign_pdf WHERE  pdf !="" ORDER BY user_id LIMIT 400, 25');
		foreach ($list as $key => $value) {

			$time = date('YmdHis');
			$time = 'Time'.$time; 
		
			$pdfname = './userpdf/'.$value['user_id'].'_1_Smart_Mark_'.''.$time.'_'.$i.'.pdf';
			$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf->WriteHTML($value['pdf']);
			$mpdf->Output($pdfname,'F');

			$time2 = date('YmdHis');
			$time2 = 'Time'.$time2; 

			$pdfname2 = './userpdf/'.$value['user_id'].'_2_PRIVACY_POLICY_'.''.$time2.'_'.$i.'.pdf';
			$mpdf2=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf2->WriteHTML($value['pdf2']);
			$mpdf2->Output($pdfname2,'F');

			$time3 = date('YmdHis');
			$time3 = 'Time'.$time3; 

			$pdfname3 = './userpdf/'.$value['user_id'].'_3_TERMS_N_CONDITIONS_'.''.$time3.'_'.$i.'.pdf';
			$mpdf3=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf3->WriteHTML($value['pdf3']);
			$mpdf3->Output($pdfname3,'F');

			$i++;
		}


		echo '17';
	}

	function userPdf2(){
		include('./mpdf/mpdf.php');
		$i = 0;
				

		$list = $this->mdl_common->allSelects('SELECT DISTINCT  user_id, pdf, pdf2, pdf3 From e_sign_pdf WHERE  pdf !="" ORDER BY user_id LIMIT 425, 25');
		foreach ($list as $key => $value) {

			$time = date('YmdHis');
			$time = 'Time'.$time; 
		
			$pdfname = './userpdf/'.$value['user_id'].'_1_Smart_Mark_'.''.$time.'_'.$i.'.pdf';
			$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf->WriteHTML($value['pdf']);
			$mpdf->Output($pdfname,'F');

			$time2 = date('YmdHis');
			$time2 = 'Time'.$time2; 

			$pdfname2 = './userpdf/'.$value['user_id'].'_2_PRIVACY_POLICY_'.''.$time2.'_'.$i.'.pdf';
			$mpdf2=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf2->WriteHTML($value['pdf2']);
			$mpdf2->Output($pdfname2,'F');

			$time3 = date('YmdHis');
			$time3 = 'Time'.$time3; 

			$pdfname3 = './userpdf/'.$value['user_id'].'_3_TERMS_N_CONDITIONS_'.''.$time3.'_'.$i.'.pdf';
			$mpdf3=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf3->WriteHTML($value['pdf3']);
			$mpdf3->Output($pdfname3,'F');

			$i++;
		}


		echo '18';
	}

	function userPdf3(){
		include('./mpdf/mpdf.php');
		$i = 0;
				

		$list = $this->mdl_common->allSelects('SELECT DISTINCT  user_id, pdf, pdf2, pdf3 From e_sign_pdf WHERE  pdf !="" ORDER BY user_id LIMIT 450, 25');
		foreach ($list as $key => $value) {

			$time = date('YmdHis');
			$time = 'Time'.$time; 
		
			$pdfname = './userpdf/'.$value['user_id'].'_1_Smart_Mark_'.''.$time.'_'.$i.'.pdf';
			$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf->WriteHTML($value['pdf']);
			$mpdf->Output($pdfname,'F');

			$time2 = date('YmdHis');
			$time2 = 'Time'.$time2; 

			$pdfname2 = './userpdf/'.$value['user_id'].'_2_PRIVACY_POLICY_'.''.$time2.'_'.$i.'.pdf';
			$mpdf2=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf2->WriteHTML($value['pdf2']);
			$mpdf2->Output($pdfname2,'F');

			$time3 = date('YmdHis');
			$time3 = 'Time'.$time3; 

			$pdfname3 = './userpdf/'.$value['user_id'].'_3_TERMS_N_CONDITIONS_'.''.$time3.'_'.$i.'.pdf';
			$mpdf3=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf3->WriteHTML($value['pdf3']);
			$mpdf3->Output($pdfname3,'F');

			$i++;
		}


		echo '19';
	}

	function userPdf4(){
		include('./mpdf/mpdf.php');
		$i = 0;
				

		$list = $this->mdl_common->allSelects('SELECT DISTINCT  user_id, pdf, pdf2, pdf3 From e_sign_pdf WHERE  pdf !="" ORDER BY user_id LIMIT 475, 25');
		foreach ($list as $key => $value) {

			$time = date('YmdHis');
			$time = 'Time'.$time; 
		
			$pdfname = './userpdf/'.$value['user_id'].'_1_Smart_Mark_'.''.$time.'_'.$i.'.pdf';
			$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf->WriteHTML($value['pdf']);
			$mpdf->Output($pdfname,'F');

			$time2 = date('YmdHis');
			$time2 = 'Time'.$time2; 

			$pdfname2 = './userpdf/'.$value['user_id'].'_2_PRIVACY_POLICY_'.''.$time2.'_'.$i.'.pdf';
			$mpdf2=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf2->WriteHTML($value['pdf2']);
			$mpdf2->Output($pdfname2,'F');

			$time3 = date('YmdHis');
			$time3 = 'Time'.$time3; 

			$pdfname3 = './userpdf/'.$value['user_id'].'_3_TERMS_N_CONDITIONS_'.''.$time3.'_'.$i.'.pdf';
			$mpdf3=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
			$mpdf3->WriteHTML($value['pdf3']);
			$mpdf3->Output($pdfname3,'F');

			$i++;
		}


		echo '20';
	}



	



	function editReferAStoreReport($id){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$insertArr = array(
			'user_name'=>$_POST['user_name'],
			'user_email'=>$_POST['user_email'],
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'],
			'contact_no'=>$_POST['contact_no'],
			'state'=>$_POST['state'],
			'city'=>$_POST['city'],
			'zip'=>$_POST['zip'], 	
			'business_name'=>$_POST['business_name'],
			'owner_name'=>$_POST['owner_name'],
			'address'=>$_POST['address'], 	
		);
		if(!$this->db->update('reseller_store',$insertArr,array('user_id'=>$id))){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => ' Edited successfully ! ');
			echo json_encode($data );
		}
	}
	
	function getdealercode($id){
			//header('Content-Type: application/json');
			$list = $this->mdl_common->allSelects('SELECT dealer_code From reseller_store where user_id='.$id);
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr = $value['dealer_code'];
				}
				echo json_encode($arr);
			}else{
				
			}
		
	}
	
	
	function mailpdfagrrementcopy($id){
		//header('Content-Type: application/json');
		$html = json_decode(file_get_contents("php://input"),true);

		// $list = $this->mdl_common->allSelects('SELECT max(dealler_no) as maxdealer From reseller_store ');
		// foreach ($list as $key => $value) {
		// 	$arr = $value['maxdealer']+1;
		// }
		//$data = 'Dealer3501'; 
		$list = $this->mdl_common->allSelects('SELECT dealer_code From reseller_store where user_id='.$id);	
		foreach ($list as $key => $value) {
			$data = $value['dealer_code'];
		}
		
		$time = date('YmdHis');
		$time = 'Time'.$time; 
		$pdfname = './dealerpdf/'.$data.''.$time.'.pdf';
		include('./mpdf/mpdf.php');
		$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
		// $mpdf->WriteHTML(utf8_encode($html));
		$mpdf->WriteHTML($html['agrmcontantpdf']);
		
		$mpdf->Output($pdfname,'F');
		


		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to('gustavo@xonnova.com');
        $this->email->subject('Dealer Agreement');
        $mail_body	='<div><p>Team xonnova</p></div>';
        $this->email->message($mail_body);
		$this->email->attach($pdfname); 
        $this->email->send();
	

		exit;
		
	}
	
	
	function approvereferAStoreReportArg($id){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		
			$list = $this->mdl_common->allSelects('SELECT max(dealler_no) as maxdealer From reseller_store ');
			foreach ($list as $key => $value) {
				$arr = $value['maxdealer']+1;
			}

			$updateArr = array(
				'login_status'=>'Approved',
				'dealer_code'=>'Dealer'.$arr,
				'dealler_no'=>$arr,
			);
		
			/* $updateArr = array(
				'dealer_code'=>$_POST['dealer_code'],
				'login_status'=>'Approved',
			); */
			if(!$this->db->update('reseller_store',$updateArr, array('user_id'=>$id))){
				$data = array('message'=>' Not Approved! Error..');
				echo json_encode($data);				
			}else{
				$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
				foreach ($userid as $user) {
					
						$this->send_deposit_mail_approved($user['user_email'], $user['first_name'] , $user['pass']);	
						
						$emailId = $this->mdl_common->getUserEmailInUserMaster($user['refer_id']);

						$this->send_refer_user_mail_approved($emailId, $user['first_name'] );
				}
				$data = array('message'=>'Approved ');
				echo json_encode($data);
			}
	
	}

	function send_refer_user_mail_approved(  $user_email=null,  $userName=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Account Activated');
     
        $mail_body	='<div>
        					<p>Dear , </p>
        					<p>Your referred Store "'.$userName.'"  account has been approved. </p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }

	
	
	function getmaxdealercode(){
			//header('Content-Type: application/json');
			$list = $this->mdl_common->allSelects('SELECT max(dealler_no) as maxdealer From reseller_store ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr = $value['maxdealer']+1;
				}
				echo json_encode($arr);
			}else{
				
			}
		
	}
	
	function mailpdfagrrement(){
		//header('Content-Type: application/json');
		$html = json_decode(file_get_contents("php://input"),true);

		$list = $this->mdl_common->allSelects('SELECT max(dealler_no) as maxdealer From reseller_store ');
		foreach ($list as $key => $value) {
			$arr = $value['maxdealer']+1;
		}
		$data = 'Dealer'.$arr; 
		
		$time = date('YmdHis');
		$time = 'Time'.$time; 
		$pdfname = './dealerpdf/'.$data.''.$time.'.pdf';
		include('./mpdf/mpdf.php');
		$mpdf=new mPDF('','', 0, '', 15, 15, 10, 10, 9, 9);
		// $mpdf->WriteHTML(utf8_encode($html));
		$mpdf->WriteHTML($html['agrmcontantpdf']);
		
		$mpdf->Output($pdfname,'F');
		


		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to('gustavo@xonnova.com');
        $this->email->subject('Dealer Agreement');
        $mail_body	='<div><p>Team xonnova</p></div>';
        $this->email->message($mail_body);
		$this->email->attach($pdfname); 
        $this->email->send();
	

		exit;
		
	}
	
	
	function blockResellerList(){
			//header('Content-Type: application/json');
			$list = $this->mdl_common->allSelects('SELECT * From block_reseller');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		
	}


	

	function blockReseller(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['admin_password']) && !empty($_POST['admin_password'])){
		}else{
			$data = array("message"=>"Password field is required !");
			echo json_encode($data);
			return  ;

		}

		if($_POST['admin_password'] == "0nL3gacyvision2020!"){
		}else{
			$data = array("message"=>"Password is worng !");
			echo json_encode($data);
			return  ;

		} 
		
		if(!empty($_POST['user_name']) ){
			$this->db->where('user_name',$_POST['user_name']);
			$rs2	=	$this->db->get('reseller_store');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$userId = $this->mdl_common->resellerID($_POST['user_name']);	
			}else{
				$data = array("message"=>"user not exist !");
				echo json_encode($data);
				return  ;		
			}

				$insertCancleSubArr = array(
						'user_id'=>$userId,
						'user_name'=>$_POST['user_name'],
					);
				$this->db->insert('block_reseller', $insertCancleSubArr);
				
				
				$updateEarningInfoArr = array(
						'status'=>'Pending',
						'login_status'=>'Pending',
					);
				$this->db->update('reseller_store',$updateEarningInfoArr,array('user_id'=>$userId));
				
				
				$data = array('message'=>'This User : '.$_POST['user_name'].' Account is Block Sucessfully!');
				echo json_encode($data);
		}else{
			$data = array('message'=>'User Name required!');
			echo json_encode($data);
		}
	}
	
	
	
	
	function getrejectedAStoreList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Rejected"   AND join_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Rejected"  ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}
	}
	
	
	function rejectferAStoreReport($id){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['comment'])){
			$updateArr = array(
				'user_reject_comment'=>$_POST['comment'],
				'status'=>'Rejected',
			);
			if(!$this->db->update('reseller_store',$updateArr, array('user_id'=>$id))){
				$data = array('message'=>' Not Rejected! Error..');
				echo json_encode($data);				
			}else{
				$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
				foreach ($userid as $user) {
					
						$this->send_reject_mail($user['user_email'], $user['user_name'],  $_POST['comment']);	
					
				}
				$data = array('message'=>'Rejected ');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Error...  Comment Required');
			echo json_encode($data);	
		}	
	
	}

	function send_reject_mail(  $user_email=null,  $userName=null,  $pass=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Account Rejected');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Account request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$pass.'</p>
        					<p>In case you have any queries, please contact us at - </p>
        					<p>ws@xonnova.com</p>
        					<p>Thank you.</p>
        					
        					
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }

    function rejectDocAStoreReport($id){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['comment'])){
			$updateArr = array(
				'doc_reject_comment'=>$_POST['comment'],
				'status'=>'Rejected',
			);
			if(!$this->db->update('reseller_store',$updateArr, array('user_id'=>$id))){
				$data = array('message'=>' Not Rejected! Error..');
				echo json_encode($data);				
			}else{
				$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
				foreach ($userid as $user) {
					
						$this->send_reject_doc_mail($user['user_email'], $user['user_name'],  $_POST['comment']);	
					
				}
				$data = array('message'=>'Rejected ');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Error...  Comment Required');
			echo json_encode($data);	
		}	
	
	}

	function send_reject_doc_mail(  $user_email=null,  $userName=null,  $pass=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Agreement Rejected');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Agreement request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$pass.'</p>
        					<p>In case you have any queries, please contact us at - </p>
        					<p>ws@xonnova.com</p>
        					<p>Thank you.</p>
        					
        					
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }


	
	
	function send_deposit_mail_approved(  $user_email=null,  $userName=null,  $pass=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Account Activated');
     
        $mail_body	='<div>
        					<p>Dear  '.$userName.', </p>
        					<p>xonnova Network is delighted to confirm that your application to become an Installation Kit Installer in CITY, STATE has been approved and subject to the completion of the next three steps:</p>
        					<p>1.	Bank Deposit: Feel free to walk in any Bank of the West nationwide, or wire from your bank to:</p>
        					
        					<p align="center">xonnova Network<p/>
							<p align="center">1231 8th Suite 300</p>
							<p align="center">Modesto Ca 95354</p>
							<p align="center">US Bank</p>
							<p align="center">Checking Account: 157507209532</p>
							<p align="center">Routing Number: 121122676</p>









        					<p>2.	Upload deposit receipt in your back office: Dashboard/Money/Upload Deposit.</p>
        					<p>3.	Minimum purchase order of 20 Installation Kits at $25 each. </p>
        					<p>A Dealer Code will be emailed to you upon receipt of deposit. You must use your dealer code when activating installation kits to customers. </p>
        					<p>Everyone here at xonnova Network wishes you the best success in this business venture. If you should have any questions, feel free to email our Communications Department at ws@xonnova.com We will be prompt in getting right back to you.</p>
        					<p>Warm regards,</p>
        					
        					
        					<p>xonnova Network Communication Team</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }



	function referAStoreReportArgByUser($id){
		//header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * From e_sign_reseller   WHERE user_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
		
	}


	function getreferAStoreArgList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Approved"  AND  login_status = "Pending" AND join_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Approved" AND  login_status = "Pending"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}
	}



	function approvereferAStoreReport($id){
		//header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		
			$updateArr = array(
				//'dealer_code'=>$_POST['dealer_code'],
				'status'=>'Approved',
			);
			if(!$this->db->update('reseller_store',$updateArr, array('user_id'=>$id))){
				$data = array('message'=>' Not Approved! Error..');
				echo json_encode($data);				
			}else{
				$userid = $this->mdl_common->allSelects('SELECT * from reseller_store where user_id = '.$id);
				foreach ($userid as $user) {
					
						$this->send_deposit_mail($user['user_email'], $user['user_name'], $user['first_name'] , $user['pass']);	
					
				}
				$data = array('message'=>'Approved ');
				echo json_encode($data);
			}
	
	}


				
	

	function send_deposit_mail(  $user_email=null,  $userName=null, $firstName=null, $pass=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('ws@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Account Activated');
     
        $mail_body	='<div>
        					<p>Dear  '.$firstName.', </p>
        					<p>Welcome to xonnova Network’s Reseller Program. Your Store Login has been created. You can login through by using the following access credentials in order to complete the necessary application: </p>
        					
        					<p>URL- https://my.xonnova.com/reseller</p>
        					<p>Username- '.$userName.', </p>
        					<p>Password- '.$pass.', </p>
        					<p>If you have any questions, feel free to contact us at: ws@xonnova.com</p>
        					
        					<p>Thank you.</p>
        					
        					
        					<p>xonnova Network Communication Team</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }


	function referAStoreReportByUser($id){
		//header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE user_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
		
	}


	function getapprovedreferAStoreList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Approved" AND  login_status = "Approved"  AND join_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Approved" AND  login_status = "Approved"  ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}
	}


	function getreferAStoreList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store   WHERE status = "Pending"  AND join_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From reseller_store  WHERE status = "Pending"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}
	}





	function addAStoreReseller(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
		}else{
			$data = array("message"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['password']) && !empty($_POST['password'])){
		}else{
			$data = array("message"=>"Password field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['user_email']) && !empty($_POST['user_email'])){
		}else{
			$data = array("message"=>"User Email field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
		}else{
			$data = array("message"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
		}else{
			$data = array("message"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['contact_no']) && !empty($_POST['contact_no'])){
		}else{
			$data = array("message"=>"Phone field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("message"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['country']) && !empty($_POST['country'])){
		}else{
			$data = array("message"=>"Country field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("message"=>"City field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("message"=>"Zip field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['business_name']) && !empty($_POST['business_name'])){
		}else{
			$data = array("message"=>"Business Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['owner_name']) && !empty($_POST['owner_name'])){
		}else{
			$data = array("message"=>"Owner Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address']) && !empty($_POST['address'])){
		}else{
			$data = array("message"=>"Address field is required !");
			echo json_encode($data);
			return  ;
		}



		// $this->db->where('user_id',$this->session->userdata('user_id'));
		
		// $rs2	=	$this->db->get('founder_member');
		// $UserInfo2	=	$rs2->num_rows();	
		// if($UserInfo2 > 0){
		// 	$founder_id = $this->session->userdata('user_id');
		// }else{
		// 	$list = $this->mdl_common->allSelects('SELECT a.user_id From founder_member as a LEFT JOIN user_master as b on a.user_id = b.user_id  WHERE b.zip = "'.$_POST['zip'].'" OR b.city = "'.$_POST['city'].'" OR b.state = "'.$_POST['state'].'" LIMIT 1');
		// 	if(isset($list) && !empty($list)){
		// 		foreach ($list as $key => $value) {
		// 			$founder_id = $value['user_id'];
		// 		}
		// 	}else{
		// 		$founder_id = 1;
		// 	}
		// }

		$founder_id = $this->getfounderID($this->session->userdata('user_id'));
		if(isset($founder_id) && !empty($founder_id)){
		}else{
			$founder_id = 1;
		}

		// $data = array('message' => $founder_id);
		// echo json_encode($data );



		
		$insertArr = array(
			'user_name'=>$_POST['user_name'],
			'password'=>MD5($_POST['password']), 
			'pass'=>$_POST['password'], 	
			'user_email'=>$_POST['user_email'],
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'],
			'contact_no'=>$_POST['contact_no'],
			'state'=>$_POST['state'],
			'country'=>$_POST['country'],
			'city'=>$_POST['city'],
			'zip'=>$_POST['zip'], 	
			'business_name'=>$_POST['business_name'],
			'owner_name'=>$_POST['owner_name'],
			'address'=>$_POST['address'], 	
			'refer_id'=>$this->session->userdata('user_id'),
			'founder_id'=>$founder_id,
		);
			

		if(!$this->db->insert('reseller_store',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('messagee' => ' Added successfully ! ');
			echo json_encode($data );
		}
	}


	function getfounderID($userId){
		$this->db->where('user_id',$userId);
		$rs2	=	$this->db->get('founder_member');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 > 0){
			 return $userId;
		}else{
			$sponsor = $this->mdl_common->getAllSponsor($userId);
			return $this->getfounderID($sponsor);
		}

	}

	
	


}