<?php
/**
* 
*/
class TransferEarning extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}



	function getBuyStoreCreditUserInfoList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From store_credit_user_info  WHERE  time  BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From store_credit_user_info ');
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


	function getBuyStoreCreditUserInfoByID($id){
		header('Content-Type: application/json');
		$list = $this->mdl_common->allSelects('SELECT * From store_credit_user_info  WHERE id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}


	function uploadBuyStoreProof(){
		header('Content-Type: application/json');
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			//$image = 'cashout'.$date.'.png';
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_buyStore'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_buyStore'.$date.'.png';
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
	            $data = array('massage'=>'error Not upload');
					echo json_encode($data);
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	 
	    }else{ $data = array('massage'=>'error');
					echo json_encode($data);
		}       
	}

	function userBuyStoreInformation(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		
		if($this->session->userdata('user_id') == null){
			$data = array('err'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
		}else{
			$data = array("err"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
		}else{
			$data = array("err"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address']) && !empty($_POST['address'])){
		}else{
			$data = array("err"=>"Address  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("err"=>"City  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("err"=>"State  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("err"=>"Zip  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['phone']) && !empty($_POST['phone'])){
		}else{
			$data = array("err"=>"Phone  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else{
			$data = array("err"=>"SSN  field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['id_proof2']) && !empty($_POST['id_proof2'])){
		}else{
			$data = array("err"=>"ID proof   is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['w_form2']) && !empty($_POST['w_form2'])){
		}else{
			$data = array("err"=>"W9 proof  is required !");
			echo json_encode($data);
			return  ;
		}


		$insertArr = array(
			'user_id'=>$this->session->userdata('user_id'),
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'],
			'address'=>$_POST['address'],
			'city'=>$_POST['city'],
			'state'=>$_POST['state'],
			'zip'=>$_POST['zip'],
			'phone'=>$_POST['phone'],
			'ssn'=>$_POST['ssn'],
			'id_image' => $_POST['id_proof2'],
			'w_form_image' => $_POST['w_form2'],				
		);

		if(!$this->db->insert('store_credit_user_info',$insertArr)){
		    $data = array('err' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'BUY Store Credit Information uploaded successfully ! ');
			echo json_encode($data );
		}
	}


	function userBuyStoreInformationExist(){
		  $data = array('status' => false);
		  $this->db->where(array('user_id'=>$this->session->userdata('user_id')));
		  $user = $this->db->get('store_credit_user_info')->result_array();
		  
		  if(count($user) == 0){
		   $data['status'] = true;
		  }
		  echo json_encode($data , JSON_FORCE_OBJECT);
	}



	

	function sponserbyUser(){
		$getPackage = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getSponsorToSponsor(){
		$User = $this->session->userdata('user_id');
		$parent = $this->mdl_common->getAllSponsor($User);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			if($sponser > 0){	

			$getPackage = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE user_id = '.$parent);
			foreach ($getPackage as $key => $value) {
				$arr[] = $value;
			}				
				
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			$User = $this->mdl_common->getAllSponsor($User);
		}
		echo json_encode($arr);
	}

	function getTotalStoreCredit($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductStoreCredit($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function transferStoreCreditByEarning(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$sendUserId = $this->mdl_common->getUserId($_POST['user_name']);
	
		$currency = $this->mdl_common->sponsorCountry($sendUserId);
		
		if($currency == "MEX"){
				$data = array('message'=>'To transfer to this user, please use MEX wallet');
				echo json_encode($data);
				return false;
		}
		
		$lastNameArr = $this->mdl_common->allSelects('SELECT last_name FROM user_master WHERE user_id='.$sendUserId);
		if(!empty($lastNameArr)){
			foreach ($lastNameArr as $key => $value) {
				
				$lastName = $value['last_name'];
			}
		}else{
			$lastName = null;
		}
		if($lastName != $_POST['last_name']){
				$data = array('message'=>'Last Name NOT match !.');
				echo json_encode($data);
		}else{
		
			$userId = 	$this->session->userdata('user_id');	
			
			$fromUserCurrency = $this->mdl_common->sponsorCountry($userId);
			$userStoreCredit = $this->getTotalStoreCredit($userId) - $this->getTotalDeductStoreCredit($userId);						
			if(!empty($fromUserCurrency) && $fromUserCurrency == "MEX"){
				$transferAmount = $_POST['credit'] * 1 ;				
			}else{
				$transferAmount = $_POST['credit'];
			}	

			if($_POST['credit'] <= $userStoreCredit){
				$toUserName = $this->mdl_common->getUserNameById($sendUserId);
				$Arr = array(
						'user_id'=>$this->session->userdata('user_id'),
						'admin_id'=>1,
						'credit'=>$_POST['credit'],
						'wallet_type'=>'2',
						'store_type'=> '2',
						'message'=>"transfer Store Credit to user ".$toUserName,
					);
				$this->db->insert('store_credit_report_info',$Arr);

				$UserName = $this->mdl_common->getUserNameById($this->session->userdata('user_id'));
				$Arr = array(
						'user_id'=>$sendUserId,
						'admin_id'=>1,
						'credit'=>$transferAmount,
						'wallet_type'=>'1',
						'store_type'=> '2',
						'message'=>"transfer Store Credit by user  ".$UserName,
					);
				$this->db->insert('store_credit_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$sendUserId));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$sendUserId,
						'admin_id'=>1,
					);
					$this->db->insert('store_credit_report_user_map_info',$insertwallete);
				}

				$data = array('message'=>'Thank you! Store Credits have been successfully transferred.');
				echo json_encode($data);
			}else{
				$data = array('message'=>'We are sorry! You have insufficient credits to transfer.');
				echo json_encode($data);
			}
		}	
	}

	function transferStoreCreditByEarning2(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		//$totalBalance =  $this->mdl_common->getTotalBalance($this->session->userdata('user_id'));
		$userId = 	$this->session->userdata('user_id');					
		$userStoreCredit = $this->getTotalStoreCredit($userId) - $this->getTotalDeductStoreCredit($userId);						

		if($_POST['credit'] <= $userStoreCredit){
			$toUserName = $this->mdl_common->getUserNameById($_POST['user_id']);
			$Arr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'admin_id'=>1,
					'credit'=>$_POST['credit'],
					'wallet_type'=>'2',
					'store_type'=> '2',
					'message'=>"transfer Store Credit to user ".$toUserName,
				);
			$this->db->insert('store_credit_report_info',$Arr);

			$UserName = $this->mdl_common->getUserNameById($this->session->userdata('user_id'));
			$Arr = array(
					'user_id'=>$_POST['user_id'],
					'admin_id'=>$userId,
					'credit'=>$_POST['credit'],
					'wallet_type'=>'1',
					'store_type'=> '2',
					'message'=>"transfer Store Credit by user  ".$UserName,
				);
			$this->db->insert('store_credit_report_info',$Arr);
			$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$_POST['user_id']));
			if(empty($existUser) && $existUser == 0){
				$insertwallete = array(
					'user_id'=>$_POST['user_id'],
					'admin_id'=>$userId,
				);
				$this->db->insert('store_credit_report_user_map_info',$insertwallete);
			}

			$data = array('message'=>'Thank you! Store Credits have been successfully transferred.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'We are sorry! You have insufficient credits to transfer.');
			echo json_encode($data);
		}
	}

	function buyStoreCreditByEarning(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		//$id = $this->mdl_common->getUserId($_POST['user_name']);
		$userID = $this->session->userdata('user_id');
		$totalBalance =  $this->mdl_common->getTotalBalance($this->session->userdata('user_id'));						
								
		$currency = $this->mdl_common->sponsorCountry($userID);
		if(!empty($currency) && $currency == "MEX"){
			$creditAmount = $_POST['credit'] * 0.055 ;
		}else{
			$creditAmount = $_POST['credit'];
		}
		
		if(!empty($creditAmount) && $_POST['credit'] <= $totalBalance){

			$Amount= $totalBalance - $_POST['credit'];
			$updattotalarr = array(
				'total_balance'=>$Amount,
			);
			$this->db->update('earning_info',$updattotalarr,array('user_id'=>$this->session->userdata('user_id')));
			
			$Arr = array(
				'user_id'=>$this->session->userdata('user_id'),
				'admin_id'=>1,
				'credit'=>$creditAmount,
				'wallet_type'=>'1',
				'store_type'=> '1',
				'message'=>"Buy US Store Credit",
			);
			$this->db->insert('store_credit_report_info',$Arr);

			$earning_details_by_user = array(
					'user_id'=>$this->session->userdata('user_id'),
					'description'=>'Buy US Store Credit',
					'amount'=> -$_POST['credit'],
					'current_balance'=>$this->mdl_common->getTotalBalance($this->session->userdata('user_id')),
			);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);

			$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$this->session->userdata('user_id')));
			if(empty($existUser) && $existUser == 0){
				$insertwallete = array(
					'user_id'=>$this->session->userdata('user_id'),
					'admin_id'=>1,
				);
				$this->db->insert('store_credit_report_user_map_info',$insertwallete);
			}

			$data = array('message'=>'Thank you! Store Credits have been successfully added to your account.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'We are sorry! You have insufficient balance to buy credits.');
			echo json_encode($data);
		}
	}
	
	function getBuyStoreCreditList(){
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.* FROM user_master as a RIGHT JOIN store_credit_report_info as b on b.user_id=a.user_id WHERE b.store_type="1" AND b.wallet_type="1" AND b.user_id='.$userId.' ORDER BY wallet_credited_at DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getTransferStoreCreditList(){
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.* FROM user_master as a RIGHT JOIN store_credit_report_info as b on b.user_id=a.user_id WHERE b.store_type="2" AND b.wallet_type="2" AND b.user_id='.$userId.' ORDER BY wallet_credited_at DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

}