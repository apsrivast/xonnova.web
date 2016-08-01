<?php

class Cashout extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}


	function cashoutAmountFuncApprove($id){
		header('Content-Type: application/json'); 
		$contentData = $this->mdl_common->allSelects('SELECT * FROM cashout_info  where cashout_status="approve" and user_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}


	function getBankInfoForCashout(){
		$cur_user_id = $this->session->userdata('user_id');

		$list = $this->mdl_common->allSelects('SELECT * From user_cashout_info where user_id= '.$cur_user_id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}

	function updateBankinfo(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'bank_name'=>$_POST['bank_name'],
			'bank_routing'=>$_POST['bank_routing'],
			'bank_account'=>$_POST['bank_account'],
			'bank_address'=>$_POST['bank_address'],
		);
		
		if(!$this->db->update('user_cashout_info',$updateArr, array('user_id'=>$_POST['user_id']))){
			$data = array('message'=>'Cashout Bank Information Not updated! Error..');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Cashout Bank Information updated succesfully.');
			echo json_encode($data);
		}
	}


	function getRejectedCashoutList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From cashout_info as a RIGHT JOIN user_master as b on a.user_id = b.user_id where a.cashout_status="Reject" AND a.cashout_entry_date BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From cashout_info as a RIGHT JOIN user_master as b on a.user_id = b.user_id where a.cashout_status="Reject"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}



	function rejCashList($id){
			header('Content-Type: application/json'); 
			$contentData = $this->mdl_common->allSelects('SELECT * FROM cashout_info  where  cashout_id = '.$id);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);			
			}else{
				return false;
			}
		}


	function rejectAmountStatus(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['cashout_id'])){
			$updateArr = array(
				'cashout_status'=>'Reject',
				'reject_comment'=>$_POST['comment']
			);
			if(!$this->db->update('cashout_info',$updateArr, array('cashout_id'=>$_POST['cashout_id']))){
				$data = array('message'=>'Cashout Not Reject! Error..');
				echo json_encode($data);				
			}else{
					$amountTotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$_POST['user_id']);
					if(isset($amountTotal) && !empty($amountTotal)){
						foreach ($amountTotal as $total) {						
							$Amount= $total['total_balance'] + $_POST['cashout_ammount'];
							$updattotalarr = array(
								'total_balance'=>$Amount,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$_POST['user_id']));
						}
					}else{
						$Amount = $_POST['cashout_ammount'];
						$updattotalarr = array(
							'total_balance'=>$Amount,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$_POST['user_id']));
					}
					
					
					$earning_details_by_user = array(
								'user_id'=>$_POST['user_id'],
								//'ref_id'=>$last_id,
								'type_id'=>'6',
								'description'=>'Cashout Rejected ',
								'amount'=>$_POST['cashout_ammount'],
								'current_balance'=>$this->mdl_common->getTotalBalance($_POST['user_id']),
								//'message'=>"",
								//'e_d_b_u_date'=>$value['created_at'],
							);
					$this->db->insert('earning_details_by_user',$earning_details_by_user);

					
					
					$useremail = $this->mdl_common->allSelects('SELECT user_email, user_name  from user_master where user_id = '.$_POST['user_id']);
					foreach ($useremail as $usermail) {
						$this->send_cashout_mail($usermail['user_email'], $usermail['user_name'], $_POST['comment']);	
					}
				
				$data = array('message'=>'Cashout Rejected');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'Error...  Comment Required');
			echo json_encode($data);	
		}
	}


	function send_cashout_mail(  $user_email=null,  $userName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Cashout Rejected');
     
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Cashout request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }

	
	function cashoutAmountFunc($id){
		header('Content-Type: application/json'); 
		$contentData = $this->mdl_common->allSelects('SELECT * FROM cashout_info  where cashout_status="pending" and user_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}

	function updateAmountStatus(){
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'cashout_status'=>'Approve'
		);
		
		if(!$this->db->update('cashout_info',$updateArr, array('cashout_id'=>$_POST['cashout_id']))){
			$data = array('message'=>'Cashout status Not updated! Error..');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Cashout status updated succesfully.');
			echo json_encode($data);
		}
	}


	
	function getCashoutInfoById($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_cashout_info  where user_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}

	function getCashout(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.user_name,a.image, b.*, c.total_balance FROM user_master as a RIGHT JOIN cashout_info as b on b.user_id=a.user_id LEFT JOIN earning_info AS c ON c.user_id=b.user_id  where b.cashout_status = "pending" order by b.cashout_entry_date');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}
	function getApproveCashout(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.user_name,a.image, b.*, c.total_balance FROM user_master as a RIGHT JOIN cashout_info as b on b.user_id=a.user_id LEFT JOIN earning_info AS c ON c.user_id=b.user_id  where b.cashout_status = "approve" order by b.cashout_entry_date');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			return false;
		}
	}
	
	function uploadCashoutProof(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			//$image = 'cashout'.$date.'.png';
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_cashout'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_cashout'.$date.'.png';
			}
			
	      	$configVideo = array(
	            	'upload_path' => './assets/cashout/',
		            'max_size' => '800024000',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            $data = array('massage'=>'error');
					echo json_encode($data);
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	 
	    }else{ $data = array('massage'=>'error');
					echo json_encode($data);}       
	}


	function userCashoutInformation(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		if($_POST['amount'] < 250){
			$data = array('message'=>'The Minimum Amount to send cashout request is 250$ or above.');
			echo json_encode($data);	
			return;
		}
		
		$this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		$user = $this->db->get('earning_info')->result_array();
		foreach ($user as $key => $xyz) {
			 $xyz['total_balance'];
		}
		
		if($_POST['amount'] > $xyz['total_balance']){
			$data = array("message"=>"Amount Not Exceed Total Balance");
			echo json_encode($data);
		}else{

			$amount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$this->session->userdata('user_id'));
			if(isset($amount) && !empty($amount)){
				foreach ($amount as $total) {						
					$totalBalance= $total['total_balance'] - $_POST['amount'];
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$this->session->userdata('user_id')));
				}
			}
			if(isset($_POST['cashout_method']) && !empty($_POST['cashout_method']) && $_POST['cashout_method'] == 'Wire'){
				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'first_name'=>$_POST['first_name'],
					'last_name'=>$_POST['last_name'],
					'amount'=>$_POST['amount'],
					'address'=>$_POST['address'],
					'city'=>$_POST['city'],
					'state'=>$_POST['state'],
					'zip'=>$_POST['zip'],
					'phone'=>$_POST['phone'],
					'ssn'=>$_POST['ssn'],
					'bank_name'=>$_POST['bank_name'],
					'bank_routing'=>$_POST['bank_routing'],
					'bank_account'=>$_POST['bank_account'],
					'bank_address'=>$_POST['bank_address'],
					'method'=>$_POST['cashout_method'],
					//'subject'=>$_POST['subject'],
					//'message'=>$_POST['message'],
					'id_image' => $_POST['id_proof'],
					'w_form_image' => $_POST['w_form'],				
				);

				$this->db->insert('user_cashout_info',$inserArr);			
				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'amount'=>$_POST['amount'],
					//'subject'=>$_POST['subject'],
					//'message'=>$_POST['message'],
				);
				$this->db->insert('user_cashout_info_next',$inserArr);

				//Earning Details in one table	
				$earning_details_by_user = array(
						'user_id'=>$this->session->userdata('user_id'),
						//'ref_id'=>$rghtChild,
						'description'=>'Cashout Request Amount',
						'amount'=> -$_POST['amount'],
						'message'=>'Cashout Request Amount',
						'current_balance'=>$this->mdl_common->getTotalBalance($this->session->userdata('user_id')),
						//'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end

				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'cashout_ammount '=>$_POST['amount'],
				);
				$this->db->insert('cashout_info',$inserArr);

				
				$data = array("message"=>"cashout request submitted successfully!");
				echo json_encode($data);
			}
			else{
				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'first_name'=>$_POST['first_name'],
					'last_name'=>$_POST['last_name'],
					'amount'=>$_POST['amount'],
					'address'=>$_POST['address'],
					'city'=>$_POST['city'],
					'state'=>$_POST['state'],
					'zip'=>$_POST['zip'],
					'phone'=>$_POST['phone'],
					'ssn'=>$_POST['ssn'],
					//'bank_name'=>$_POST['bank_name'],
					//'bank_routing'=>$_POST['bank_routing'],
					//'bank_account'=>$_POST['bank_account'],
					//'bank_address'=>$_POST['bank_address'],
					'method'=>$_POST['cashout_method'],
					//'subject'=>$_POST['subject'],
					//'message'=>$_POST['message'],
					'id_image' => $_POST['id_proof'],
					'w_form_image' => $_POST['w_form'],				
				);

				$this->db->insert('user_cashout_info',$inserArr);			
				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'amount'=>$_POST['amount'],
					//'subject'=>$_POST['subject'],
					//'message'=>$_POST['message'],
				);
				$this->db->insert('user_cashout_info_next',$inserArr);

				//Earning Details in one table	
				$earning_details_by_user = array(
						'user_id'=>$this->session->userdata('user_id'),
						//'ref_id'=>$rghtChild,
						'description'=>'Cashout Request Amount',
						'amount'=> -$_POST['amount'],
						//'message'=>$_POST['message'],
						'current_balance'=>$this->mdl_common->getTotalBalance($this->session->userdata('user_id')),
						//'e_d_b_u_date'=>$value['created_at'],
					);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end

				$inserArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'cashout_ammount '=>$_POST['amount'],
				);
				$this->db->insert('cashout_info',$inserArr);

				
				$data = array("message"=>"cashout request submitted successfully!");
				echo json_encode($data);
			}
		}			
	}

	function userCashoutInformationExist(){
		  $data = array('status' => false);
		  $this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		  $user = $this->db->get('user_cashout_info')->result_array();
		  
		  if(count($user) == 0){
		   $data['status'] = true;
		  }
		  echo json_encode($data , JSON_FORCE_OBJECT);
	}

	function userCashoutNextOut(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if($_POST['amount'] < 250){
			$data = array('message'=>'The Minimum Amount to send cashout request is 250$ or above.');
			echo json_encode($data);	
			return;
		}
		
		$this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		$user = $this->db->get('earning_info')->result_array();
		foreach ($user as $key => $xyz) {
			 $xyz['total_balance'];
		}
		
		if($_POST['amount'] > $xyz['total_balance']){
			$data = array("message"=>"Amount Not Exceed Total Balance");
			echo json_encode($data);
		}else{
			$amount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$this->session->userdata('user_id'));
			if(isset($amount) && !empty($amount)){
				foreach ($amount as $total) {						
					$totalBalance= $total['total_balance'] - $_POST['amount'];
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$this->session->userdata('user_id')));
				}
			}

			$inserArr = array(
				'user_id'=>$this->session->userdata('user_id'),
				'amount'=>$_POST['amount'],
				//'subject'=>$_POST['subject'],
				//'message'=>$_POST['message'],
			);
			$this->db->insert('user_cashout_info_next',$inserArr);
			$inserArr = array(
				'user_id'=>$this->session->userdata('user_id'),
				'cashout_ammount '=>$_POST['amount'],
			);
			$this->db->insert('cashout_info',$inserArr);


			

			//Earning Details in one table	
			$earning_details_by_user = array(
					'user_id'=>$this->session->userdata('user_id'),
					//'ref_id'=>$rghtChild,
					'description'=>'Cashout Request Amount',
					'amount'=> -$_POST['amount'],
					'current_balance'=>$this->mdl_common->getTotalBalance($this->session->userdata('user_id')),
					//'message'=>"",
					//'e_d_b_u_date'=>$value['created_at'],
				);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);
			//end
			$data = array("message"=>"cashout request submitted successfully!");
			echo json_encode($data);
		}
	}

	function userCashoutEarningInformation(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, a.image , b.total_balance From  user_master as a  LEFT JOIN earning_info as b on b.user_id=a.user_id  where a.user_id = '.$this->session->userdata('user_id'));
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{
		}
	}

	function isAmountExist() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);

		$this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		$user = $this->db->get('earning_info')->result_array();
		foreach ($user as $key => $xyz) {
			 $xyz['total_balance'];
		}
		
		if($value['amount'] > $xyz['total_balance']){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
}