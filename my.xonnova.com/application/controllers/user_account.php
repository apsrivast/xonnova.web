<?php


class User_account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

	}

function getUserList()
{
	
		$_POST = json_decode(file_get_contents("php://input"),true);
		$search = $_POST['search'];
		
		
			$list = $this->mdl_common->allSelects('SELECT * From user_register ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		
	
	
}
function getaccView($id)
{
header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_register where userid ='.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
}

function getreferredList()
{
	$userid = $this->session->userdata('user_id');
	
    header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM reseller_store where refer_id ='.$userid);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
}
function getReferredView($id)
{
	header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM reseller_store where user_id ='.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}


}
function getAmount(){

		

	if($this->session->userdata('user_id') == null)
		{
  		 $data = array('mess' => 'Login In Again');
  		 echo json_encode($data);
   			return  ;
 		 }
		
		if(isset($_POST['bank_amount']) && !empty($_POST['bank_amount']) && $_POST['bank_amount'] > 0){
		}else{
			$data = array('mess' => 'Amount field is required !');
			echo json_encode($data);
			return  ;
		}

		if(!empty($_FILES))
		 { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'deposit'.$date.'.png';
			 if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = 'deposit'.$date.'.pdf';
			}else{
				$image = 'deposit'.$date.'.png';
		 }
			
			
		$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'deposit_image' => $image,
				'bank_deposit' => $_POST['question'],
				'bank_amount'=>$_POST['bank_amount']
				// 'package_id'=>$_POST['package_id'],
				
				
			);
	      	$configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	          
	            $data = array('mess' => 'Not a valid files, only png|gif|jpg|jpeg|pdf ');
				echo json_encode($data , JSON_FORCE_OBJECT);
	        } else {
	           
	           if(!$this->db->insert('deposit_info',$insertArr)){
				    $data = array('mess' => $this->db->_error_message());
					echo json_encode($data , JSON_FORCE_OBJECT);
				}else{
		           	$data = array('mess' => 'Amount and image uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);
				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}

function getDeposit(){

	if($this->session->userdata('user_id') == null){
   $data = array('mess' => 'Login In Again');
   echo json_encode($data);
   return  ;
  }
		// $isTranaactionId = $this->onlegacy_mdl->isTranaactionId($_POST['transaction_id']);
		// if($isTranaactionId){
		// }else{
		// 	$data = array('mess' => 'Transaction Id allready Submitted !');
		// 	echo json_encode($data);
		// 	return  ;
		// }
		
		

		// $isTranaactionId = $this->onlegacy_mdl->isTranaactionId($_POST['transaction_id']);
		// if($isTranaactionId){
		// }else{
		// 	$data = array('mess' => 'Transaction Id allready Submitted !');
		// 	echo json_encode($data);
		// 	return  ;
		// }
		
		if(isset($_POST['deposit_amount']) && !empty($_POST['deposit_amount']) && $_POST['deposit_amount'] > 0){
		}else{
			$data = array('mess' => 'Amount field is required !');
			echo json_encode($data);
			return  ;
		}
			if(isset($_POST['Tid']) && !empty($_POST['Tid']) && $_POST['Tid'] > 0){
		}else{
			$data = array('mess' => 'Transaction id field is required !');
			echo json_encode($data);
			return  ;
		}
	if(isset($_POST['bank_name']) && !empty($_POST['bank_name'])){
		}else{
			$data = array('mess' => 'Name field is required !');
			echo json_encode($data);
			return  ;
		}
	



		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'deposit_bank'.$date.'.png';
			 if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = 'deposit_bank'.$date.'.pdf';
			}else{
				$image = 'deposit_bank'.$date.'.png';
			}
			
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'deposit_image' => $image,
				'bank_deposit' => $_POST['selectbank'],
				'bank_amount'=>$_POST['deposit_amount'],
				 'transaction_id'=>$_POST['Tid'],
				 'bankname'=>$_POST['bank_name']
				
				
			);
	      	$configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	          
	            $data = array('mess' => 'Not a valid files, only png|gif|jpg|jpeg|pdf ');
				echo json_encode($data , JSON_FORCE_OBJECT);
	        } else {
	           
	           if(!$this->db->insert('deposit_info',$insertArr)){
				    $data = array('mess' => $this->db->_error_message());
					echo json_encode($data , JSON_FORCE_OBJECT);
				}else{
		           	$data = array('mess' => ' Bank deposit uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);
				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}
	
	function getDetail(){

		// $isTranaactionId = $this->onlegacy_mdl->isTranaactionId($_POST['transaction_id']);
		// if($isTranaactionId){
		// }else{
		// 	$data = array('mess' => 'Transaction Id allready Submitted !');
		// 	echo json_encode($data);
		// 	return  ;
		// }
		
		

		// $isTranaactionId = $this->onlegacy_mdl->isTranaactionId($_POST['transaction_id']);
		// if($isTranaactionId){
		// }else{
		// 	$data = array('mess' => 'Transaction Id allready Submitted !');
		// 	echo json_encode($data);
		// 	return  ;
		// }
		if($this->session->userdata('user_id') == null){
   		$data = array('mess' => 'Login In Again');
  		 echo json_encode($data);
  		 return  ;
  		}
		
		if(isset($_POST['totalamount']) && !empty($_POST['totalamount']) && $_POST['totalamount'] > 0){
		}else{
			$data = array('mess' => 'Amount field is required !'.$_POST['totalamount']);
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['Bank_name']) && !empty($_POST['Bank_name'])){
		}else{
			$data = array('mess' => 'Bank name field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['selectbank']) && !empty($_POST['selectbank'])){
		}else{
			$data = array('mess' => 'Bank selection field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['account_no']) && !empty($_POST['account_no'])){
		}else{
			$data = array('mess' => 'Bank Account number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['routing']) && !empty($_POST['routing'])){
		}else{
			$data = array('mess' => 'Routing number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address']) && !empty($_POST['address'])){
		}else{
			$data = array('mess' => 'Address field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['esign']) && !empty($_POST['esign'])){
		}else{
			$data = array('mess' => 'Bank esign field is required !');
			echo json_encode($data);
			return  ;
		}
		$xyz = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAxUlEQVR4nO3BMQEAAADCoPVPbQhfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOA1v9QAATX68/0AAAAASUVORK5CYII=';
		if(isset($_POST['esign']) && !empty($_POST['esign']) && $_POST['esign'] != $xyz){
		}else{
			$data = array("mess"=>"Signture field is required !");
			echo json_encode($data);
			return  ;
		}

		
		if(isset($_POST['Branch']) && !empty($_POST['Branch'])){
		}else{
			$data = array('mess' => 'Branch name  field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array('mess' => 'City name field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array('mess' => 'Branch name  field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array('mess' => 'zip name field is required !');
			echo json_encode($data);
			return  ;
		}




		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'voided_img'.$date.'.png';
			 if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = 'voided_img'.$date.'.pdf';
			}else{
				$image = 'voided_img'.$date.'.png';
			}
			
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'deposit_image' => $image,
				'bank_deposit' => $_POST['selectbank'],
				'bank_amount'=>$_POST['totalamount'],
				 'bankname'=>$_POST['Bank_name'],
				 'Routing_no'=>$_POST['routing'],
				 'Billing_addr'=>$_POST['address'],
				 'Account_no'=>$_POST['account_no'],
				 'Esign'=>$_POST['esign'],
				 'Branch_name'=>$_POST['Branch'],
				 'city'=>$_POST['city'],
				 'state'=>$_POST['state'],
				 'zip'=>$_POST['zip']
				 
				
				
			);
	      	$configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	          
	            $data = array('mess' => 'Not a valid files, only png|gif|jpg|jpeg|pdf ');
				echo json_encode($data , JSON_FORCE_OBJECT);
	        } else {
	           
	           if(!$this->db->insert('deposit_info',$insertArr)){
				    $data = array('mess' => $this->db->_error_message());
					echo json_encode($data , JSON_FORCE_OBJECT);
				}else{
		           	$data = array('mess' => 'details uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);

				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}	
}




?>