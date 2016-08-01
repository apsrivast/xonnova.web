<?php 
/**
* 
*/
class User extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function depositbank1(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('mess'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		

		if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])){
		}else{
			$data = array('mess' => 'Check number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_deposit']) && !empty($_POST['bank_deposit'])){
		}else{
				 $data = array('mess' => 'Bank Deposited field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['date_deposit']) && !empty($_POST['date_deposit'])){
		}else{
				 $data = array('mess' => 'Date Deposited field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_amount']) && !empty($_POST['bank_amount'] ) && $_POST['bank_amount'] > 0){
		}else{
				 $data = array('mess' => 'Amount field is required !');
		
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['terms_cond']) && !empty($_POST['terms_cond'] )){
		}else{
				 $data = array('mess' => 'terms and conditions field is required !');
		
			echo json_encode($data);
			return  ;
		}

			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'file_to_upload'=>'Deposit',
				'transaction_id'=>$_POST['transaction_id'],
				'bank_deposit'=>$_POST['bank_deposit'],
				'date_of_deposit'=>$_POST['date_deposit'],
				'bank_amount'=>$_POST['bank_amount'],
				'terms_cond'=>$_POST['terms_cond'],					
			);
	    
	       
           if(!$this->db->insert('deposit_info',$insertArr)){
			    $data = array('mess' => $this->db->_error_message());
				echo json_encode($data , JSON_FORCE_OBJECT);
			}else{
	           	$data = array('mess' => 'deposit uploaded successfully ! ');
				echo json_encode($data , JSON_FORCE_OBJECT);
			}
	}

	function userdeposit(){
		if($this->session->userdata('user_id') == null){
			$data = array('mess'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['file_to_upload']) && !empty($_POST['file_to_upload'])){
		}else{
			$data = array('mess' => 'File to upload: field is required !');
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])){
		}else{
			$data = array('mess' => 'Check number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['routing_no']) && !empty($_POST['routing_no'])){
		}else{
				 $data = array('mess' => 'Routing Number field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['account_no']) && !empty($_POST['account_no'])){
		}else{
				 $data = array('mess' => 'Account Number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_amount']) && !empty($_POST['bank_amount'] ) && $_POST['bank_amount'] > 0){
		}else{
				 $data = array('mess' => 'Amount field is required !');
		
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_deposit']) && !empty($_POST['bank_deposit'])){
		}else{
				 $data = array('mess' => 'Bank Deposited field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['date_deposit']) && !empty($_POST['date_deposit'])){
		}else{
				 $data = array('mess' => 'Date Deposited field is required !');
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

		if(isset($_POST['terms_cond']) && !empty($_POST['terms_cond'] )){
		}else{
				 $data = array('mess' => 'terms and conditions field is required !');
		
			echo json_encode($data);
			return  ;
		}

		if(!empty($_FILES)) { 
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
				'file_to_upload'=>$_POST['file_to_upload'],
				'transaction_id'=>$_POST['transaction_id'],
				'Routing_no'=>$_POST['routing_no'],
				'Account_no'=>$_POST['account_no'],
				'bank_amount'=>$_POST['bank_amount'],
				'date_of_deposit'=>$_POST['date_deposit'],
				'bank_deposit'=>$_POST['bank_deposit'],
				'terms_cond'=>$_POST['terms_cond'],
				'Esign'=>$_POST['esign'],
				
				
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
		           	$data = array('mess' => 'deposit uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);
				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}

	function depositbank(){
		if($this->session->userdata('user_id') == null){
			$data = array('mess'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['file_to_upload']) && !empty($_POST['file_to_upload'])){
		}else{
			$data = array('mess' => 'File to upload: field is required !');
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])){
		}else{
			$data = array('mess' => 'Check number field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_amount']) && !empty($_POST['bank_amount'] ) && $_POST['bank_amount'] > 0){
		}else{
				 $data = array('mess' => 'Amount field is required !');
		
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_deposit']) && !empty($_POST['bank_deposit'])){
		}else{
				 $data = array('mess' => 'Bank Deposited field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['date_deposit']) && !empty($_POST['date_deposit'])){
		}else{
				 $data = array('mess' => 'Date Deposited field is required !');
			echo json_encode($data);
			return  ;
		}

		/*$xyz = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAxUlEQVR4nO3BMQEAAADCoPVPbQhfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOA1v9QAATX68/0AAAAASUVORK5CYII=';
		if(isset($_POST['esign']) && !empty($_POST['esign']) && $_POST['esign'] != $xyz){
		}else{
			$data = array("mess"=>"Signture field is required !");
			echo json_encode($data);
			return  ;
		}*/

		if(isset($_POST['terms_cond']) && !empty($_POST['terms_cond'] )){
		}else{
				 $data = array('mess' => 'terms and conditions field is required !');
		
			echo json_encode($data);
			return  ;
		}

		if(!empty($_FILES)) { 
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
				'file_to_upload'=>$_POST['file_to_upload'],
				'transaction_id'=>$_POST['transaction_id'],
				'bank_amount'=>$_POST['bank_amount'],
				'date_of_deposit'=>$_POST['date_deposit'],
				'bank_deposit'=>$_POST['bank_deposit'],
				'terms_cond'=>$_POST['terms_cond'],
				//'Esign'=>$_POST['esign'],
				
				
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
		           	$data = array('mess' => 'deposit uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);
				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}




	function getTotalHoldingTankSB(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT user_id From user_master where sb_parent_id = 0 and user_type="user"  AND sponsor_id='.$this->session->userdata('user_id')));
		echo json_encode($total);
	}


	function myLevel($id){
    	$left = $this->mdl_common->SBleftChild($id);/////top
    	$mid = $this->mdl_common->SBmidChild($id);
		$right = $this->mdl_common->SBrightChild($id);//////bottum
    	$Ltree1 = $this->mdl_common->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$left);
    	$Mtree1 = $this->mdl_common->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$mid);
		$Rtree1 = $this->mdl_common->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$right);

		echo '[';
		if(!empty($Ltree1) && !empty($left)){
			foreach ($Ltree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				
				echo ']},';
			}
		}else{
			echo '{"id":"L'.$id.'","name":"Add New User","parent_id":'.$id.',"position_tree":"L","image":"0"},';
		}

		if(!empty($Mtree1) && !empty($mid)){
			foreach ($Mtree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				
				echo ']},';
			}
		}else{
			echo '{"id":"M'.$id.'","name":"Add New User","parent_id":'.$id.',"position_tree":"M","image":"0"},';
		}

		if(!empty($Rtree1) && !empty($right)){
			foreach ($Rtree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				
				echo ']}';
			}
		}else{
			echo '{"id":"R'.$id.'","name":"Add User","parent_id":'.$id.',"position_tree":"R","image":"0"}';
		}
		echo ']';	
	}



	function userChildBinaryDetailsSB(){
		$user = $_POST['user_name'];
		if(isset($user) && !empty($user) && $user != "Add User"){
			echo 'Name : '.$user;			
		}else{
			echo "Add New User";
		}
	}

	function boardlevelSearch(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['boardlevel_user'])){
			$user_email = $this->mdl_common->getUserId($_POST['boardlevel_user']);
				if(!empty($user_email) && $user_email != false){
					$this->session->set_userdata('sb_id',$user_email);
					$this->session->set_userdata('sb_name',$_POST['boardlevel_user']);
					$data = array('message'=>'Please wait...');
					echo json_encode($data);					
				}else{
					$data = array('err'=>'User name does not exist!');
					echo json_encode($data);
				}			
		}else{
			$data = array('err'=>'User name is Required!');
			echo json_encode($data);
		}
	}

	function boardlevelSearchByUser(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userID = $this->session->userdata('user_id');
		if(!empty($_POST['boardlevel_user'])){
				$userInMyTree = $this->countParentToParent($userID,$_POST['boardlevel_user']);
				if($userInMyTree == true){
					$user_email = $this->mdl_common->getUserId($_POST['boardlevel_user']);
					if(!empty($user_email) && $user_email != false){
						$this->session->set_userdata('sb_id',$user_email);
						$this->session->set_userdata('sb_name',$_POST['boardlevel_user']);
						$data = array('message'=>'Please wait...');
						echo json_encode($data);					
					}else{
						$data = array('err'=>'User name does not exist!');
						echo json_encode($data);
					}						
				}else{
					$data = array('err'=>'This is an Invalid User!');
					echo json_encode($data);
				}
		}else{
			$data = array('err'=>'User name is Required!');
			echo json_encode($data);
		}
	}

	function countParentToParent($parntUser,$user1){
		$childUser = $this->mdl_common->getUserId($user1);
		if(!empty($childUser)){
			$parent = $this->mdl_common->SBparentId($childUser);
			$countUser = $childUser;
			for($i=$parent; $i>=1; $i--){
				$sponser = $parent;
				if($sponser > 0){		
					$countUser .= 	','.$sponser;
					$parent = $this->mdl_common->SBparentId($sponser);
				}
			}
			$ar = explode(',', $countUser);
			//print_r($ar);
			if (in_array($parntUser, $ar)) {
			    return true;
			}else{
				return false;
			}			
		}else{
			return false;
		}
	}






	function getUserSB(){
		header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('SELECT user_id, user_name From user_master where sb_parent_id = 0 and user_type="user" and sponsor_id ='.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}




	function addHoldingSB(){
		header('Content-Type: application/json');
		if(!empty($_POST['user_name']) && !empty($_POST['child_position']) && !empty($_POST['user_position'])){
			$position = $this->mdl_common->getUserId($_POST['user_position']);
			$user = $_POST['user_name'];
			$parentIdOfNewUser = $this->mdl_common->SBparentId($user);
			$childPosition = $_POST['child_position'];


			$lftPosition = $this->mdl_common->SBleftChild($position);/////top
	    	$midPosition = $this->mdl_common->SBmidChild($position);
			$rghtPosition = $this->mdl_common->SBrightChild($position);//////bottum
			
			if(!empty($childPosition) && $childPosition == 'L'){
				if(!empty($parentIdOfNewUser) && $parentIdOfNewUser != 0){
					$data['error'] = "This user have already Placed";
						echo json_encode($data);
				}else{
					if($lftPosition != 0){
						$data['error'] = "This user have already Top Child!";
						echo json_encode($data);
					}else{
						$holding = array(
							'sb_parent_id'=>$position,
						);
						$this->db->update('user_master',$holding,array('user_id'=>$user));
						
						$updLeft = array(
								'sb_top_id'=>$user,
							);
						$this->db->update('user_master',$updLeft,array('user_id'=>$position));

						$data['sucess'] = "User Added to Top Position in tree";
						echo json_encode($data);
					}					
				}
			}elseif(!empty($childPosition) && $childPosition == 'R'){
				if(!empty($parentIdOfNewUser) && $parentIdOfNewUser != 0){
					$data['error'] = "This user have already Placed";
						echo json_encode($data);
				}else{
					if($rghtPosition != 0){
						$data['error'] = "This user have already Bottom Child!";
						echo json_encode($data);
					}else{
						$holding = array(
							'sb_parent_id'=>$position,
						);

						$this->db->update('user_master',$holding,array('user_id'=>$user));
						$updRght = array(
								'sb_bottum_id'=>$user,
							);
						$this->db->update('user_master',$updRght,array('user_id'=>$position));
						
						$data['sucess'] = "User Added to Bottom Position in tree";
						echo json_encode($data);
					}
				}
			}else{
				if(!empty($parentIdOfNewUser) && $parentIdOfNewUser != 0){
					$data['error'] = "This user have already Placed";
						echo json_encode($data);
				}else{
					if($midPosition != 0){
						$data['error'] = "This user have already Mid Child!";
						echo json_encode($data);
					}else{
						$holding = array(
							'sb_parent_id'=>$position,
						);

						$this->db->update('user_master',$holding,array('user_id'=>$user));
						$updRght = array(
								'sb_mid_id'=>$user,
							);
						$this->db->update('user_master',$updRght,array('user_id'=>$position));
						
						$data['sucess'] = "User Added to Mid Position in tree";
						echo json_encode($data);
					}
				}
			}			
		}else{
			$data['error'] ="Error... User not Added to position!";
			echo json_encode($data);
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////




	function getUserName(){
		header('Content-Type: application/json');
		$total = $this->session->userdata('user_name');
		echo json_encode($total);
	}
	
	function platformstwo2(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM new_platform where user_id='.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			$arr = 'yes';
			echo json_encode($arr);
		}else{
			$arr = 'no';
			echo json_encode($arr);
		}		
	}
	
	function getTotalHoldingTank(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT * From user_master where parent_id = 0  AND sponsor_id='.$this->session->userdata('user_id')));
		
		// $total = $this->mdl_common->getTotalMemberInTeam($this->session->userdata('user_id'));
		echo json_encode($total);
	}
	
	function index(){
		$getPackage = $this->mdl_common->allSelects('SELECT * From package_info where package_status = "active"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
	function getSponserNameAutoSuggest(){
	  $query = $this->mdl_common->allSelects('SELECT user_name FROM user_master');
	  foreach ($query as $key => $value) {
	   $arr[]= $value;
	  }
	  echo json_encode($arr);
	 }
	
	function depositList(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM  deposit_info where user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}
	
	function viewLeadsCommentHistory($id){
		header('Content-Type: application/json');
		$getHistory = $this->mdl_common->allSelects('SELECT * From leads_status_history where leads_id='.$id);
		if(isset($getHistory) && !empty($getHistory)){
			foreach ($getHistory as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}	
	}
	function leadtwoUpdatecomment(){
		$_POST = json_decode(file_get_contents("php://input"),true);
			$Arr = array(
				'comments'=>$_POST['comments'],
			);
		
			$this->db->update('new_leads',$Arr, array('id'=>$_POST['id']));
	}	
	
	function usernewOrderTab(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		$contentData = count($this->mdl_common->allSelects('SELECT a.*, b.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id where a.delivery_status = "Processing" and a.user_id = '.$this->session->userdata('user_id')));
		echo json_encode($contentData);
	}
	
	function addHolding(){
		header('Content-Type: application/json');
		if(!empty($_POST['user_name']) && !empty($_POST['child_position']) && !empty($_POST['user_position'])){
			$position = $this->mdl_common->getUserId($_POST['user_position']);
			$user = $_POST['user_name'];
			$parentIdOfNewUser = $this->mdl_common->getParentUser($user);
			$childPosition = $_POST['child_position'];
			$lftPosition = $this->mdl_common->leftPosition($position);
			$rghtPosition = $this->mdl_common->rghtPosition($position);
			
			$packageId = $this->mdl_common->getUserPackageById($_POST['user_name']);
			$binaryPoint = $this->mdl_common->packageBinaryPoint($packageId);
			$qvPoint = $this->mdl_common->packageQVPoint($packageId);
			
			if(!empty($childPosition) && $childPosition == 'L'){
				//echo $position.' '.$_POST['user_name'].' '.$childPosition; exit();
				if(!empty($parentIdOfNewUser) && $parentIdOfNewUser != 0){
					$data['error'] = "This user have already Placed";
						echo json_encode($data);
				}else{
					if($lftPosition != 0){
						$data['error'] = "This user have already Top Child!";
						echo json_encode($data);
					}else{
						$holding = array(
							'parent_id'=>$position,
							'position'=>$childPosition,
						);
						$this->db->update('user_master',$holding,array('user_id'=>$user));
						
						$updLeft = array(
								'lft_user'=>$user,
							);
						$this->db->update('user_master',$updLeft,array('user_id'=>$position));
						
						$sponsor = $this->mdl_common->getAllSponsor($user);
						
						$this->getParentToParentReferralBinary($position,$packageId,$user);
						
						$checkExistTeam = $this->mdl_common->selectChildUser($user);
						if($checkExistTeam){
							$this->getParentToParentReferralBinaryExistTeam($user);							
						}


						//////////////////////////////////////////////////////////////////////////////////////////////////
						$this->mdl_common->insertMatrixBonus($user, $packageId);
					
						$data['sucess'] = "User Added to Top Position in tree";
						echo json_encode($data);
					}					
				}
			}else{
				if(!empty($parentIdOfNewUser) && $parentIdOfNewUser != 0){
					$data['error'] = "This user have already Placed";
						echo json_encode($data);
				}else{
					if($rghtPosition != 0){
						$data['error'] = "This user have already Bottom Child!";
						echo json_encode($data);
					}else{
						$holding = array(
							'parent_id'=>$position,
							'position'=>$childPosition,
						);

						$this->db->update('user_master',$holding,array('user_id'=>$user));
						$updRght = array(
								'rght_user'=>$user,
							);
						$this->db->update('user_master',$updRght,array('user_id'=>$position));
						
						$sponsor = $this->mdl_common->getAllSponsor($user);
						
						$this->getParentToParentReferralBinary($position,$packageId,$user);
						
						$checkExistTeam = $this->mdl_common->selectChildUser($user);
						if($checkExistTeam){
							$this->getParentToParentReferralBinaryExistTeam($user);							
						}


						//////////////////////////////////////////////////////////////////////////////////////////////////
						$this->mdl_common->insertMatrixBonus($user, $packageId);


						$data['sucess'] = "User Added to Bottom Position in tree";
						echo json_encode($data);
					}
				}
			}			
		}else{
			$data['error'] ="Error... User not Added to position!";
			echo json_encode($data);
		}
	}
	
	function getParentToParentReferralBinary($parntUser,$packageID,$childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllParent($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){	
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$currency = $this->mdl_common->sponsorCountry($sponser);
					if($currency =="MEX"){
						$binaryPoint = $this->onlegacy_mdl->getMEXPackageBinaryPoint($packageID);
					}else{
						$binaryPoint = $this->onlegacy_mdl->getUSPackageBinaryPoint($packageID);
					}
				}else{
					$binaryPoint = 0;
				}		
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point from earning_info where user_id = '.$sponser);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$totalBinaryPoint = $total['referral_binary_point'] + $binaryPoint;
							$updattotalarr = array(
								'referral_binary_point'=>$totalBinaryPoint,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						}
					}else{
						$totalBinaryPoint = $binaryPoint;
						$updattotalarr = array(
							'referral_binary_point'=>$totalBinaryPoint,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					}

					$insertBinamry = array(
							'parent_id'=>$sponser,
							'user_id'=>$user,
							'referral_binary'=>$binaryPoint
						);
					$this->db->insert('referrals_binary',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$user = $this->mdl_common->getAllParent($user);
		}
	}
	
	function getSponsorToSponsorQV($parntUser,$packageID,$childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllSponsor($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){
				$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$parentCurrency = $this->mdl_common->sponsorCountry($sponser);
					if($parentCurrency =="MEX"){
						$binaryPoint = $this->onlegacy_mdl->getMEXPackageQvPoint($packageID);
					}else{
						$binaryPoint = $this->onlegacy_mdl->getUSPackageQvPoint($packageID);
					}
				}else{
					$binaryPoint = 0;
				}	
				$insertBinamry = array(
						'sponsor_id'=>$sponser,
						'user_id'=>$user,
						'qv_point'=>$binaryPoint
					);
				$this->db->insert('unilevel_binary_info',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			$user = $this->mdl_common->getAllSponsor($user);
		}
	}
	
	function getParentToParentReferralBinaryExistTeam($childUser){
		$TotalBV1 = $this->mdl_common->getNewTeamBV($childUser);
		
		$user = $childUser;
		$parent = $this->mdl_common->getAllParent($user);
		
		for($i=$parent; $i>=1; $i--){
			if($parent > 0){
				$sponsorPackageForQv = $this->mdl_common->getPackageById($parent);
				if(!empty($sponsorPackageForQv) && $sponsorPackageForQv >= 3){
					$TotalBV = $TotalBV1;
				}else{
					$TotalBV = 0;
				}
				$selectearningtotal = $this->mdl_common->allSelects('SELECT * from earning_info where user_id = '.$parent);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$total = $total['referral_binary_point'] + $TotalBV;
							$updattotalarr = array(
								'referral_binary_point'=>$total,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
						}
					}else{
						$updattotalarr = array(
							'referral_binary_point'=>$TotalBV,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
					}

					$insertBinamry = array(
							'parent_id'=>$parent,
							'user_id'=>$user,
							'referral_binary'=>$TotalBV
						);
					$this->db->insert('referrals_binary',$insertBinamry);
				//echo $user.' => '.$TotalBV.'<br>';
			}
			$parent = $this->mdl_common->getAllParent($parent);
			$user = $this->mdl_common->getAllParent($user);
		}			
	}
	
	public function isUniqueParent() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$this->db->where('sponsor_id',$this->session->userdata('user_id'));
		// $this->db->where('lft_user','0');
		// $this->db->or_where('rght_user','0');
		//$where = "name='Joe' AND status='boss' OR status='active'";
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}


	public function isUniqueChild() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$this->db->where('sponsor_id',$this->session->userdata('user_id'));
		$this->db->where('parent_id','0');
		// $this->db->or_where('rght_user','0');
		//$where = "name='Joe' AND status='boss' OR status='active'";
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}

	function getCurrentUser(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master where user_id='.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getEncriptionSystem(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From package_info where package_status="active"');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getUser(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master where parent_id = 0 and user_type="user" and sponsor_id ='.$this->session->userdata('user_id'));
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getProduct(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From product_info');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	/* function addHolding(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST)){
			$position = $_POST['user_position'];
			$user = $_POST['user_name'];

			$holding = array(
					'parent_id'=>$position,
				);
			$this->db->update('user_master',$holding,array('user_id'=>$user));
		}else{

		}
	} */
	
	function addHoldingPopup(){
		
	}
	
	function addHoldingAccept(){
		$parent = $_POST['parent_id'];
		$user = $_POST['user_id'];
		$username = $_POST['user_name'];
		$position =$_POST['position'];
		if((isset($user) && !empty($user)) && (isset($parent) && !empty($parent)) && (isset($username) && !empty($username)) && (isset($position) && !empty($position))){
			if($position == 'L'){
				$arr = array(
						'lft_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}elseif($position == 'R'){
				$arr = array(
						'rght_user'=>$user,
					);
				$this->db->update('user_master',$arr,array('user_id'=>$parent));
				$arrp = array('parent_id'=>$parent);
				$this->db->update('user_master',$arrp,array('user_id'=>$user));
				echo 'User Assign succesfully';
			}else{
				echo 'Position Not Found!';
			}
		}else{
			echo 'Position Not Found! Error...';
		}
	}

	function getVoucher(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From voucher_info');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function addVoucher(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST) && !empty($_POST)){
			$inserArr = array(
				'voucher_name'=>trim($_POST['voucher_name']),
				'voucher_code'=>trim($_POST['voucher_code']),
				'voucher_desc'=>trim($_POST['voucher_desc']),
				'voucher_validity'=>trim($_POST['validity']),
				'voucher_status'=>trim('active'),
			);
			$this->db->insert('voucher_info',$inserArr);
			return true;
		}else{
			return false;
		}
	}

	function getPosition(){
		header('Content-Type: application/json');

		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getMember(){
		header('Content-Type: application/json');
		$total = count($this->mdl_common->allSelects('SELECT * From user_master where user_type="user" AND sponsor_id='.$this->session->userdata('user_id')));
		//$total = $this->mdl_common->getTotalMemberInTeam($this->session->userdata('user_id'));
		echo json_encode($total);
	}

	function getTotalEarning(){
		header('Content-Type: application/json');
		$total = $this->mdl_common->allSelects('SELECT SUM(total_balance) as total from earning_info where user_id='.$this->session->userdata('user_id'));
		foreach ($total as $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}
	
    function isUniqueValue() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) > 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	function isUniqueValue1() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_email',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) > 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	function isUniqueValue2() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	function insertIntoClientTable($post){
		//$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($post['sponsor_id'])&&!empty($post['sponsor_id'])){
			$sponsorId = $this->mdl_common->sponserID($post['sponsor_id']);
		}else{
			$sponsorId = '';
		}
		if(isset($post['package'])&&!empty($post['package'])){
			$package = $post['package'];
		}else{
			$package = '';
		}
		if(isset($post['first_name'])&&!empty($post['first_name'])){
			$firstName = $post['first_name'];
		}else{
			$firstName = '';
		}

		// if(isset($post['middle_name']) && !empty($post['middle_name'])){
		// 	$middleName = $post['middle_name'];
		// }else{
		// 	$middleName = '';
		// }

		if(isset($post['last_name'])&&!empty($post['last_name'])){
			$lastName = $post['last_name'];
		}else{
			$lastName = '';
		}
		if(isset($post['user_name'])&&!empty($post['user_name'])){
			$userName = $post['user_name'];
		}else{
			$userName = '';
		}
		if(isset($post['user_email'])&&!empty($post['user_email'])){
			$userEmail = $post['user_email'];
		}else{
			$userEmail = '';
		}
		if(isset($post['user_password'])&&!empty($post['user_password'])){
			$userPassword = $post['user_password'];
		}else{
			$userPassword = '';
		}
		if(isset($post['dob'])&&!empty($post['dob'])){
			$dob = $post['dob'];
		}else{
			$dob = '';
		}

		if(isset($post['address1'])&&!empty($post['address1'])){
			$address1 = $post['address1'];
		}else{
			$address1 = '';
		}

		// if(isset($_POST['address2']) && !empty($_POST['address2'])){
		// 	$address2 = $_POST['address2'];
		// }else{
		// 	$address2 = '';
		// }

		if(isset($post['city'])&&!empty($post['city'])){
			$city = $post['city'];
		}else{
			$city = '';
		}

		if(isset($post['state'])&&!empty($post['state'])){
			$state = $post['state'];
		}else{
			$state = '';
		}

		if(isset($post['zip'])&&!empty($post['zip'])){
			$zip = $post['zip'];
		}else{
			$zip = '';
		}
		if(isset($post['phone'])&&!empty($post['phone'])){
			$phone = $post['phone'];
		}else{
			$phone = '';
		}
		if(isset($post['country'])&&!empty($post['country'])){
			$country = $post['country'];
		}else{
			$country = '';
		}
		$insertArr = array(
				'sponsor_id'=>$sponsorId,
				'package_id'=>$package,//create
				'f_name'=>$firstName,
				//'middle_name'=>$middleName,
				'l_name'=>$lastName,
				'u_name'=>$userName,
				'u_email'=>$userEmail,
				'u_pass'=>$userPassword,
				'u_dob'=>$dob,//create
				'u_address'=>$address1,
				//'address2'=>$post['address2'],
				'u_city'=>$city,
				'u_state'=>$state,
				'u_zip'=>$zip,
				'u_contact'=>$phone,
				'u_country'=>$country,
				'fail_status'=>1,
		);
		$this->db->insert('store_user_info',$insertArr);

	}
	function userNameSpace($str){
		  return ( ! preg_match("/^([a-zA-Z0-9])+$/i", $str)) ? FALSE : TRUE;
		 }

	function insertUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['country']) && !empty($_POST['country'])){
		}else{
			$data = array("error"=>"Country field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
		}else{
			$data = array("error"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['middle_name']) && !empty($_POST['middle_name'])){
		}else{
			$_POST['middle_name'] = '';
		}
		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
		}else{
			$data = array("error"=>"Last Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$uname = $this->userNameSpace($_POST['user_name']);
			if($uname){
			}else{
				$data = array("error"=>"User Name field without space !");
				echo json_encode($data);
				return  ;
			}
		}else{
			$data = array("error"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['user_email']) && !empty($_POST['user_email'])){
		}else{
			$data = array("error"=>"Email field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['ssn']) && !empty($_POST['ssn'])){
		}else{
			$_POST['ssn'] = '';
		}
		if(isset($_POST['user_password']) && !empty($_POST['user_password'])){
		}else{
			$data = array("error"=>"Password field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['dob']) && !empty($_POST['dob'])){
		}else{
			$data = array("error"=>"Birth Date field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address1']) && !empty($_POST['address1'])){
		}else{
			$data = array("error"=>"Address field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else{
			$_POST['address2'] = '';
		}

		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("error"=>"City field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("error"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("error"=>"Zip Code field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone']) && !empty($_POST['phone'])){
		}else{
			$data = array("error"=>"Phone # field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['phone_carrier']) && !empty($_POST['phone_carrier'])){
		}else{
			$data = array("error"=>"Phone Carrier # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['sponsor_id']) && !empty($_POST['sponsor_id'])){
		}else{
			$data = array("error"=>"Sponser Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['package']) && !empty($_POST['package'])){
		}else{
			$data = array("error"=>"Package field is required !");
			echo json_encode($data);
			return  ;
		}
		
		$sponser = $this->mdl_common->sponserID($_POST['sponsor_id']);
		$currency = $this->mdl_common->sponsorCountry($sponser);
		$data = array("sponser"=>$_POST['sponsor_id']);
		$recuringAmount = $this->mdl_common->planPrice(1,$_POST['country']);
		$amount = $this->mdl_common->planPrice($_POST['package'],$_POST['country']);
		
		$sponsorPackageForQv = $this->mdl_common->getPackageById($sponser);
		if(!empty($sponsorPackageForQv) && $sponsorPackageForQv > 1){
			$qvPoint = $this->mdl_common->packageQVPoint($_POST['package']);
			$binaryPoint = $this->mdl_common->packageBinaryPoint($_POST['package']);
		}else{
			$qvPoint = 0;
			$binaryPoint = 0;
		}
		$referralAmount = $this->mdl_common->packageReferralAmount($_POST['package'],$currency,$_POST['country']);
		
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") +1, date("d"), date("Y")));
		$existUserName = $this->mdl_common->isUserExist($_POST['user_name']);
		$existUserEmail = $this->mdl_common->isEmailExist($_POST['user_email']);
		if($existUserName == true && $existUserEmail == true){
			
		
			if((isset($_POST['voucher_code']) && !empty($_POST['voucher_code']) && $_POST['voucher_code'] !=null) || (isset($_POST['checked']) && !empty($_POST['checked']))){
				$existVoucherCode = $this->mdl_common->isVoucherCodeExist($_POST['voucher_code']);
				if($existVoucherCode == true){
					/////////////////////////for no bonus/////////////////////////////////////////////////////////////
					$_POST['package'] = 1;
					$referralAmount = $this->mdl_common->packageReferralAmount($_POST['package'],$currency,$_POST['country']);
					$insertArr = array(
							'package'=>$_POST['package'],
							'first_name'=>$_POST['first_name'],
							'middle_name'=>$_POST['middle_name'],
							'last_name'=>$_POST['last_name'],
							'user_name'=>$_POST['user_name'],
							'user_email'=>$_POST['user_email'],
							'user_password'=>md5($_POST['user_password']),
							'dob'=>$_POST['dob'],
							'address1'=>$_POST['address1'],
							'address2'=>trim($_POST['address2']),
							'city'=>$_POST['city'],
							'state'=>$_POST['state'],
							'zip'=>$_POST['zip'],
							'contact_no'=>$_POST['phone'],
							'phone_carrier'=>$_POST['phone_carrier'],
							'country'=>$_POST['country'],
							'sponsor_id'=>$sponser,
							'form_status'=>5,
							'ssn'=>$_POST['ssn'],
					);
					$this->db->insert('user_master',$insertArr);
					$last_id =  $this->db->insert_id();

					//for apps table
					$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);
					
					$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

					$this->mdl_common->insertShippingStatus($last_id,"Registration");
					if($_POST['package'] > 5){
						$levelRank = 5;
					}else{
						$levelRank = $_POST['package'];
					}
					$earnings = array(
									'user_id'=>$last_id,
									'sponser_id'=>$sponser,
									'total_amount'=>$amount,
									'referrals_earning'=>$referralAmount,
									'level'=>$levelRank,
								   );
					$this->db->insert('earning_info',$earnings);

					// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
							
					// if(isset($selectearningtotal) && !empty($selectearningtotal)){
					// 	foreach ($selectearningtotal as $total) {						
					// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
					// 		$updattotalarr = array(
					// 			'total_balance'=>$totalreferralAmount,
					// 		);
					// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// 	}
					// }else{
					// 	$totalreferralAmount = $referralAmount;
					// 	$updattotalarr = array(
					// 		'total_balance'=>$totalreferralAmount,
					// 	);
					// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					// }
					
					// $inserBonus = array(
					// 		'parent_id'=>$sponser,
					// 		'user_id'=>$last_id,
					// 		'referral_bonus'=>$referralAmount
					// 	);
					// $this->db->insert('referral_bonus',$inserBonus);
					
					// //Earning Details in one table	
					// $earning_details_by_user = array(
					// 		'user_id'=>$sponser,
					// 		'ref_id'=>$last_id,
					// 		'type_id'=>'1',
					// 		'description'=>'Referral amount from '.$_POST['user_name'],
					// 		'amount'=>$referralAmount,
					// 		//'message'=>"",
					// 		//'e_d_b_u_date'=>$value['created_at'],
					// 	);
					// $this->db->insert('earning_details_by_user',$earning_details_by_user);
					// //end



					////bonus 2
					//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
					////bonus 3
					$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
					$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
					$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
					//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
					////bonus 5
					$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);




					$voucherinsertarr = array(
							'user_id'=>$last_id,
							'voucher_code'=>$_POST['voucher_code'],
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->insert('voucher_details',$voucherinsertarr);
					$voucherupdatearr = array(
							'used'=>'is_used',
							'voucher_status'=>'inactive'
						);
					$this->db->update('voucher_info',$voucherupdatearr,array('voucher_code'=>$_POST['voucher_code']));
					
					$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
					$this->sendMail($last_id);
					$data['message'] = "Your Registration Completed succesfully";
					echo json_encode($data);
				}else{
					$data = array("error"=>"Voucher Code Not Exist !");
					echo json_encode($data);
				}	
			}else{
				if(isset($_POST['name_on_card']) && !empty($_POST['name_on_card'])){
				}else{
					$data = array("error"=>"Name on Card field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['card_no']) && !empty($_POST['card_no'])){
				}else{
					$data = array("error"=>"Card # field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['expiry_year']) && !empty($_POST['expiry_year'])){
				}else{
					$data = array("error"=>"Expiry Year field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['expiry_month']) && !empty($_POST['expiry_month'])){
				}else{
					$data = array("error"=>"Expiry Month field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['cvv_no']) && !empty($_POST['cvv_no'])){
				}else{
					$data = array("error"=>"CVV # field is required !");
					echo json_encode($data);
					return  ;
				}
				if(isset($_POST['billing_zip']) && !empty($_POST['billing_zip'])){
				}else{
					$data = array("error"=>"Billing Zip field is required !");
					echo json_encode($data);
					return  ;
				}
				
				// //AIM payment Method
				// $this->load->library('authorize_net');

				// $auth_net = array(
				// 	'x_card_num'			=> trim($_POST['card_no']), // Visa
				// 	'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
				// 	'x_card_code'			=> trim($_POST['cvv_no']),
				// 	'x_description'			=> 'xonnova network transaction',
				// 	'x_amount'				=> trim($amount),
				// 	//'x_amount'				=> 29,
				// 	'x_first_name'			=> $_POST['first_name'],
				// 	'x_last_name'			=> $_POST['last_name'],
				// 	'x_address'				=> $_POST['address1'].''.$_POST['address2'],
				// 	'x_city'				=> $_POST['city'],
				// 	'x_state'				=> $_POST['state'],
				// 	'x_zip'					=> $_POST['zip'],
				// 	'x_country'				=> $_POST['country'],
				// 	'x_phone'				=> trim($_POST['phone']),
				// 	'x_email'				=> $_POST['user_email'],
				// 	'x_customer_ip'			=> $this->input->ip_address(),
				// );

				// $this->authorize_net->setData($auth_net);
				
				// // Send request
				// if($this->authorize_net->authorizeAndCapture() ){						
				// 	//ARB Payment method
				// 	$this->load->library('authorize_arb');

					
				// 	// Start with a create object
				// 	$this->authorize_arb->startData('create');

				// 	$refId = substr(md5( microtime() . 'ref' ), 0, 20);
				// 	$this->authorize_arb->addData('refId', $refId);
				// 	$total_amt = $amount + $recuringAmount;
				// 	$subscription_data = array(			
				// 		'name' => $_POST['name_on_card'].'xonnova Subscription',
				// 		'paymentSchedule' => array(
				// 			'interval' => array(
				// 				'length' => 1,
				// 				'unit' => 'months',
				// 				),
				// 			'startDate' => $recurringStartDate,
				// 			'totalOccurrences' => 9999,
				// 			'trialOccurrences' => 0,
				// 			),
				// 		'amount' => 29.00,
				// 		'trialAmount' => 0,
				// 		'payment' => array(
				// 			'creditCard' => array(
				// 				'cardNumber' => $_POST['card_no'],
				// 				'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
				// 				'cardCode' => $_POST['cvv_no'],
				// 				),
				// 			),			
				// 		'billTo' => array(
				// 			'firstName' => $_POST['user_name'],
				// 			'lastName' => $_POST['last_name'],				
				// 			),
				// 	);
			
				// 	$this->authorize_arb->addData('subscription', $subscription_data);

				$stripeValue = $this->mdl_common->getStripeValue();	
				if($stripeValue == 2){

					//AIM payment Method
					$this->load->library('authorize_net');

					$auth_net = array(
						'x_card_num'			=> trim($_POST['card_no']), // Visa
						'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
						'x_card_code'			=> trim($_POST['cvv_no']),
						'x_description'			=> 'xonnova network transaction',
						'x_amount'				=> trim($amount),
						//'x_amount'				=> 29,
						'x_first_name'			=> $_POST['first_name'],
						'x_last_name'			=> $_POST['last_name'],
						'x_address'				=> $_POST['address1'].''.$_POST['address2'],
						'x_city'				=> $_POST['city'],
						'x_state'				=> $_POST['state'],
						'x_zip'					=> $_POST['zip'],
						'x_country'				=> $_POST['country'],
						'x_phone'				=> trim($_POST['phone']),
						'x_email'				=> $_POST['user_email'],
						'x_customer_ip'			=> $this->input->ip_address(),
					);

					$this->authorize_net->setData($auth_net);
					
					// Send request
					if($this->authorize_net->authorizeAndCapture() ){						
						//ARB Payment method
						$this->load->library('authorize_arb');

						
						// Start with a create object
						$this->authorize_arb->startData('create');

						$refId = substr(md5( microtime() . 'ref' ), 0, 20);
						$this->authorize_arb->addData('refId', $refId);
						$total_amt = $amount + $recuringAmount;
						$subscription_data = array(			
							'name' => $_POST['name_on_card'].'xonnova Subscription',
							'paymentSchedule' => array(
								'interval' => array(
									'length' => 1,
									'unit' => 'months',
									),
								'startDate' => $recurringStartDate,
								'totalOccurrences' => 9999,
								'trialOccurrences' => 0,
								),
							'amount' => 29.00,
							'trialAmount' => 0,
							'payment' => array(
								'creditCard' => array(
									'cardNumber' => $_POST['card_no'],
									'expirationDate' => $_POST['expiry_year'].'-'.$_POST['expiry_month'],
									'cardCode' => $_POST['cvv_no'],
									),
								),			
							'billTo' => array(
								'firstName' => $_POST['user_name'],
								'lastName' => $_POST['last_name'],				
								),
						);
				
						$this->authorize_arb->addData('subscription', $subscription_data);

						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>trim($_POST['address2']),
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>6,
								'ssn'=>$_POST['ssn'],

						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										'transaction_id'=>$this->authorize_net->getTransactionId(),
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$this->authorize_net->getTransactionId(),
										'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();


						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);

						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance, referral_binary_point from earning_info where user_id = '.$sponser);
								
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }
						
						$insertBinamry = array(
								'parent_id'=>$sponser,
								'user_id'=>$last_id,
								'referral_binary'=>$binaryPoint
							);
						$this->db->insert('referrals_binary',$insertBinamry);
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['user_name'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end




						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);



						
						/* $this->directorCodedBonus($_POST['package'], $last_id);
						$this->regionalCodedBonus($_POST['package'], $last_id);
						$this->nationalCodedBonus($_POST['package'], $last_id);
						$this->internationalCodedBonus($_POST['package'], $last_id);
						$this->vpCodedBonus($_POST['package'], $last_id);
						$this->pCodedBonus($_POST['package'], $last_id);
						$this->codedMaching($_POST['package']); */
						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id);
							if($this->authorize_arb->send()){	
									$arr = array(
										'transaction_arb_id'=>$this->authorize_arb->getId(),
									);
									$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
								$data['message'] = "WELCOME TO xonnova NETWORK Your Registration Completed succesfully!   Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId();
								//$datauser = $_POST['first_name'];
								echo json_encode($data);
							}else{
								$data['error'] = 'Registration  Fail! Subscription Error ID : '.$this->authorize_arb->getError();
								echo json_encode($data);
							}
					}else{
						$data['error'] = 'Registration  Fail! Transaction Error ID : '.$this->authorize_net->getError();
						echo json_encode($data);
					}

				}elseif($stripeValue == 1){

					try {
					  	include('./stripe/init.php');
						\Stripe\Stripe::setApiKey('sk_live_1DZ70B8dI9zquSk4yCAUZ5Z4');
						$myCard = array('number' => $_POST['card_no'], 'exp_month' => $_POST['expiry_month'], 'exp_year' => $_POST['expiry_year']);
						$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $amount * 100, 'currency' => 'usd', "metadata" => array("user_name" => $_POST['user_name'])));



						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>trim($_POST['address2']),
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>6,
								'ssn'=>$_POST['ssn'],

						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();


						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);

						// $selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance, referral_binary_point from earning_info where user_id = '.$sponser);
								
						// if(isset($selectearningtotal) && !empty($selectearningtotal)){
						// 	foreach ($selectearningtotal as $total) {						
						// 		$totalreferralAmount= $total['total_balance'] + $referralAmount;
						// 		$updattotalarr = array(
						// 			'total_balance'=>$totalreferralAmount,
						// 		);
						// 		$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// 	}
						// }else{
						// 	$totalreferralAmount = $referralAmount;
						// 	$updattotalarr = array(
						// 		'total_balance'=>$totalreferralAmount,
						// 	);
						// 	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						// }
						
						$insertBinamry = array(
								'parent_id'=>$sponser,
								'user_id'=>$last_id,
								'referral_binary'=>$binaryPoint
							);
						$this->db->insert('referrals_binary',$insertBinamry);
						// $inserBonus = array(
						// 		'parent_id'=>$sponser,
						// 		'user_id'=>$last_id,
						// 		'referral_bonus'=>$referralAmount
						// 	);
						// $this->db->insert('referral_bonus',$inserBonus);
						
						// //Earning Details in one table	
						// $earning_details_by_user = array(
						// 		'user_id'=>$sponser,
						// 		'ref_id'=>$last_id,
						// 		'type_id'=>'1',
						// 		'description'=>'Referral amount from '.$_POST['user_name'],
						// 		'amount'=>$referralAmount,
						// 		//'message'=>"",
						// 		//'e_d_b_u_date'=>$value['created_at'],
						// 	);
						// $this->db->insert('earning_details_by_user',$earning_details_by_user);
						// //end




						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);



						
						/* $this->directorCodedBonus($_POST['package'], $last_id);
						$this->regionalCodedBonus($_POST['package'], $last_id);
						$this->nationalCodedBonus($_POST['package'], $last_id);
						$this->internationalCodedBonus($_POST['package'], $last_id);
						$this->vpCodedBonus($_POST['package'], $last_id);
						$this->pCodedBonus($_POST['package'], $last_id);
						$this->codedMaching($_POST['package']); */
						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id);
						// 	if($this->authorize_arb->send()){	
						// 			$arr = array(
						// 				'transaction_arb_id'=>$this->authorize_arb->getId(),
						// 			);
						// 			$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
						// 		$data['message'] = "WELCOME TO xonnova NETWORK Your Registration Completed succesfully!   Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId();
						// 		//$datauser = $_POST['first_name'];
						// 		echo json_encode($data);
						// 	}else{
						// 		$data['error'] = 'Registration  Fail! Subscription Error ID : '.$this->authorize_arb->getError();
						// 		echo json_encode($data);
						// 	}
						// }else{
						// 	$data['error'] = 'Registration  Fail! Transaction Error ID : '.$this->authorize_net->getError();
						// 	echo json_encode($data);
						// }
						$data['message'] = "WELCOME TO  NETWORK Your Registration Completed succesfully!   Transaction ID : ".$charge->id;
						//$datauser = $_POST['first_name'];
						echo json_encode($data);

						} catch(\Stripe\Error\Card $e) {
						  	$body = $e->getJsonBody();
						  	$err  = $body['error'];
							$data = array("error"=>$err['message']);
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\RateLimit $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\InvalidRequest $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Authentication $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\ApiConnection $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (\Stripe\Error\Base $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						} catch (Exception $e) {
						  	$data = array("error"=>"payment error");
							echo json_encode($data);
							return  ;
						}
				}else{
						$insertArr = array(
								'package'=>$_POST['package'],
								'first_name'=>$_POST['first_name'],
								'middle_name'=>$_POST['middle_name'],
								'last_name'=>$_POST['last_name'],
								'user_name'=>$_POST['user_name'],
								'user_email'=>$_POST['user_email'],
								'user_password'=>md5($_POST['user_password']),
								'dob'=>$_POST['dob'],
								'address1'=>$_POST['address1'],
								'address2'=>trim($_POST['address2']),
								'city'=>$_POST['city'],
								'state'=>$_POST['state'],
								'zip'=>$_POST['zip'],
								'contact_no'=>$_POST['phone'],
								'phone_carrier'=>$_POST['phone_carrier'],
								'country'=>$_POST['country'],
								'sponsor_id'=>$sponser,
								'form_status'=>6,
								'ssn'=>$_POST['ssn'],

						);
						$this->db->insert('user_master',$insertArr);
						$last_id =  $this->db->insert_id();

						//for apps table
						$this->mdl_common->xoApp($_POST['user_email'],$_POST['user_password']);

						$this->getSponsorToSponsorQV($sponser,$_POST['package'],$last_id);

						$this->mdl_common->insertShippingStatus($last_id,"Registration");

						$expiry_year = $_POST['expiry_month'].'/'.$_POST['expiry_year'];
						
						$card_insert = array(
										'user_id'=>$last_id,
										'ammount'=>$amount,
										'package'=>$_POST['package'],
										'name_on_card'=>$_POST['name_on_card'],
										'card_no'=>$_POST['card_no'],
										'expiry_date'=>$expiry_year,
										'cvv_no'=>$_POST['cvv_no'],
										'billing_zip'=>$_POST['billing_zip'],
										//'transaction_id'=>$charge->id,
										//'transaction_arb_id'=>$this->authorize_arb->getId(),
										//'transaction_aim_id'=>$charge->id,
										//'ref_id'=>$refId,
									   );
						$this->db->insert('payment_info',$card_insert);
						$lasttransactionID = $this->db->insert_id();


						if($_POST['package'] > 5){
							$levelRank = 5;
						}else{
							$levelRank = $_POST['package'];
						}
						
						$earnings = array(
										'user_id'=>$last_id,
										'sponser_id'=>$sponser,
										'total_amount'=>$amount,
										'referrals_earning'=>$referralAmount,
										'level'=>$levelRank,
									   );
						$this->db->insert('earning_info',$earnings);
						
						$insertBinamry = array(
								'parent_id'=>$sponser,
								'user_id'=>$last_id,
								'referral_binary'=>$binaryPoint
							);
						$this->db->insert('referrals_binary',$insertBinamry);
						////bonus 2
						//$this->mdl_common->insertMentorBonusAmount($last_id, $last_id, $referralAmount);
						////bonus 3
						$this->mdl_common->insertMentorBonusAmount($sponser, $last_id, $referralAmount);
						$LeadershipAmount = $this->mdl_common->packageLeadershipAmount($_POST['package']);
						$this->mdl_common->insertLeadershipBonus($sponser, $last_id, $LeadershipAmount, 0);
						//$this->mdl_common->insertLeadershipBonus($last_id, $last_id, $LeadershipAmount, 0);
						////bonus 5
						$this->mdl_common->insertMatrixBonus($last_id, $_POST['package']);

						$this->send_user_email($_POST['user_name'],$_POST['user_password'],$_POST['user_email']);
						$this->sendMail($last_id);
						// 	if($this->authorize_arb->send()){	
						// 			$arr = array(
						// 				'transaction_arb_id'=>$this->authorize_arb->getId(),
						// 			);
						// 			$this->db->update('payment_info',$arr,array('p_id'=>$lasttransactionID));
						// 		$data['message'] = "WELCOME TO xonnova NETWORK Your Registration Completed succesfully!   Subscription ID:".$this->authorize_arb->getId().', Transaction ID : '.$this->authorize_net->getTransactionId();
						// 		//$datauser = $_POST['first_name'];
						// 		echo json_encode($data);
						// 	}else{
						// 		$data['error'] = 'Registration  Fail! Subscription Error ID : '.$this->authorize_arb->getError();
						// 		echo json_encode($data);
						// 	}
						// }else{
						// 	$data['error'] = 'Registration  Fail! Transaction Error ID : '.$this->authorize_net->getError();
						// 	echo json_encode($data);
						// }
						$data['message'] = "WELCOME TO  NETWORK Your Registration Completed succesfully!    ";
						echo json_encode($data);
				}
			}
			$existUserNameInClient = count($this->mdl_common->allSelects('SELECT * From user_master where user_name="'.$_POST['user_name'].'"'));
			if($existUserNameInClient == 0){	
				$this->insertIntoClientTable($_POST);	
			}
		}else{
			$data = array("error"=>"User allready Exist !");
			echo json_encode($data);
		}	
	}
	
	function directorCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 7) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}else{
			$parentID = $this->session->userdata('sponsor_id');
			$parentLevel = $this->mdl_common->countUserLevel('earning_info',$parentID);
			if(!empty($level) && $level < 7 && $package == 5 && !empty($parentLevel) && $parentLevel >= 7){					
				$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$parentLevel);
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$parentID);
					
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$totalBalance= $total['total_balance'] + $codedBonus;
						$updattotalarr = array(
							'total_balance'=>$totalBalance,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
					}
				}else{
					$totalBalance = $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
				}
				$insertCodedBounsArr = array(
										'parent_id'=>$parentID,
										'user_id'=>$cur_user_id,
										'coded_bonus'=>$codedBonus,
									);
				$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
			}				
		}
	}

	function regionalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 8) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function nationalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 9) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function internationalCodedBonus($package, $last_id){
		$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 10) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function vpCodedBonus($package, $last_id){
			$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 11) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}

	function pCodedBonus($package, $last_id){
			$cur_user_id = $this->session->userdata('user_id');
		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		if((isset($level) && !empty($level) && $level == 12) && ($package == 5)){
			$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$level);
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$cur_user_id);
				
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalBalance= $total['total_balance'] + $codedBonus;
					$updattotalarr = array(
						'total_balance'=>$totalBalance,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
				}
			}else{
				$totalBalance = $codedBonus;
				$updattotalarr = array(
					'total_balance'=>$totalBalance,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$cur_user_id));
			}
			$insertCodedBounsArr = array(
								'parent_id'=>$cur_user_id,
								'user_id'=>$last_id,
								'coded_bonus'=>$codedBonus,
							);
			$this->db->insert('coded_bonus_info',$insertCodedBounsArr);
		}
	}
	
	function codedMaching($package){
		$cur_user_id = $this->session->userdata('user_id');
		$parentID = $this->session->userdata('sponsor_id');

		$level = $this->mdl_common->countUserLevel('earning_info',$cur_user_id);
		$parentLevel = $this->mdl_common->countUserLevel('earning_info',$parentID);
		if(!empty($level) && $level >= 7 && $package == 4 && !empty($parentLevel) && $parentLevel > $level){
				$codedBonus = $this->mdl_common->getCodedBonus("SELECT * FROM level_configuration WHERE l_conf_id=".$parentLevel)*2/100;
				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$parentID);
					
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$totalBalance= $total['total_balance'] + $codedBonus;
						$updattotalarr = array(
							'total_balance'=>$totalBalance,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parentID));
					}
				}
				$insertCodedBounsArr = array(
										'parent_id'=>$parentID,
										'user_id'=>$cur_user_id,
										'coded_bonus'=>$codedBonus,
									);
				$this->db->insert('coded_matching_info',$insertCodedBounsArr);
		}
	}
	
	function updateUser(){

	}

	function deleteUser(){

	}

	function month(){
		 for($i=1;$i<=12;$i++){
            $selected   =   '';
            if($expiry_month == $i)
                $selected   =   'selected="selected"';
            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
        }
	}
	
	function year(){

	}
	
	function uploadPlatformsIdProof1(){
			$date = date("ymdHis");
		    $image = 'platformsId'.$date.$_FILES[ 'file' ][ 'name' ];
			
			
	      	$configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            echo 'No files';
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	        
	}
	
	function uploadPlatformsIdProof(){
			$date = date("ymdHis");
			$result = explode('.', $_FILES[ 'file' ][ 'name' ]);
			
		    $image = 'platformsId'.$date.'.png';
	      	$configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            echo 'No files';
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	        
	}


	function getPlatformsListForUser(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM platforms_list');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}

	function platformstwo(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		//print_r($_POST['platforms_name']);
		$platformsname = $_POST['platforms_name'];
		
		foreach($platformsname as $key => $value) {
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'platforms_name' => $value,
				'platform_image' => $_POST['picID'],
				'platform_image2' => $_POST['picIDBack'],
				'platform_image3' => $_POST['picCard'],
				'platform_image4' => $_POST['picCardBack'],
				'platform_image5' => $_POST['picAddress'],
				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'user_name'=>$_POST['user_name'],
				
				'user_email'=>$_POST['user_email'],
				'phone'=>$_POST['mobile_no'],
			);
			$this->db->insert('new_platform',$insertArr);	
			
		}
		$data = array('message'=>'Platforms added successfully!');
		echo json_encode($data);
	}

	function leadtwo(){
		$_POST = json_decode(file_get_contents("php://input"),true);
			if(isset($_POST['comments']) && !empty($_POST['comments']) && $_POST['comments'] !=null){
				$comment = $_POST['comments'];

			}else{
				$comment = null;
			}

			if(isset($_POST['picID']) && !empty($_POST['picID']) && $_POST['picID'] !=null){
				$picID = $_POST['picID'];

			}else{
				$picID = null;
			}

			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'business_image' => $picID,
				'business_name'=>$_POST['business_name'],
				'owner_name'=>$_POST['owner_name'],
				'type_business'=>$_POST['type_business'],
				'business_email'=>$_POST['business_email'],
				'equipment'=>$_POST['equipment'],
				'internet'=>$_POST['internet'],
				'comments'=>$comment,
				'contect_no'=>$_POST['contect_no'],
			);
			$this->db->insert('new_leads',$insertArr); 
	}


	function leads(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $image = 'leads'.$date.$_FILES[ 'file' ][ 'name' ];
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'business_image' => $image,
				'business_name'=>$_POST['business_name'],
				'owner_name'=>$_POST['owner_name'],
				'type_business'=>$_POST['type_business'],
				'business_email'=>$_POST['business_email'],
				'equipment'=>$_POST['equipment'],
				'internet'=>$_POST['internet'],
				'comments'=>$_POST['comments'],
			);
		      $configVideo = array(
		            	'upload_path' => './uploads/',
			            'max_size' => '8000240',
			            'allowed_types' => 'png|gif|jpg|jpeg',
			            'overwrite'=> FALSE,
			            'remove_spaces' => TRUE,
			            'file_name'=> $image
		        );

		        $this->load->library('upload', $configVideo);
		        $this->upload->initialize($configVideo);
		        if (!$this->upload->do_upload('file')) {
		            echo 'No files';
		        } else {
		           $this->db->insert('new_leads',$insertArr); 
		        }	        
		            
			 }
			 else{ echo 'No files';}
	}


	function platforms(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $image = 'platform'.$date.$_FILES[ 'file' ][ 'name' ];
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'platform_image' => $image,
				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'user_name'=>$_POST['user_name'],
				//'user_password'=>md5($_POST['user_password']),
				'user_email'=>$_POST['user_email'],
				'phone'=>$_POST['phone'],
				
			);
		      $configVideo = array(
		            	'upload_path' => './uploads/',
			            'max_size' => '8000240',
			            'allowed_types' => 'png|gif|jpg|jpeg',
			            'overwrite'=> FALSE,
			            'remove_spaces' => TRUE,
			            'file_name'=> $image
		        );

		        $this->load->library('upload', $configVideo);
		        $this->upload->initialize($configVideo);
		        if (!$this->upload->do_upload('file')) {
		            echo 'No files';
		        } else {
		           $this->db->insert('new_platform',$insertArr); 
		        }	        
		            
			 }
			 else{ echo 'No files';}
	}
	function userdeposit_old(){
		if($this->session->userdata('user_id') == null){
			$data = array('mess'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['transaction_id']) && !empty($_POST['transaction_id'])){
		}else{
				 $data = array('mess' => 'Transaction Id field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['date_deposit']) && !empty($_POST['date_deposit'])){
		}else{
				 $data = array('mess' => 'Date Deposited field is required !');
			
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_deposit']) && !empty($_POST['bank_deposit'])){
		}else{
				 $data = array('mess' => 'Bank Deposited field is required !');
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['bank_amount']) && !empty($_POST['bank_amount'] ) && $_POST['bank_amount'] > 0){
		}else{
				 $data = array('mess' => 'Amount field is required !');
		
			echo json_encode($data);
			return  ;
		}

		if(!empty($_FILES)) { 
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
				'transaction_id'=>$_POST['transaction_id'],
				'date_of_deposit'=>$_POST['date_deposit'],
				'bank_deposit'=>$_POST['bank_deposit'],
				'bank_amount'=>$_POST['bank_amount'],
				'package_id'=>$_POST['package_id'],
				
				
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
		           	$data = array('mess' => 'deposit uploaded successfully ! ');
					echo json_encode($data , JSON_FORCE_OBJECT);
				}
	        }	        
	            
		} else{ 
			
			 $data = array('mess' => 'No files ');
			echo json_encode($data , JSON_FORCE_OBJECT);
		}
	}
	function userdeposit2(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'deposit'.$date.'.png';
			//$image = 'deposit'.$date.$_FILES[ 'file' ][ 'name' ];
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'deposit_image' => $image,
				'transaction_id'=>$_POST['transaction_id'],
				'date_of_deposit'=>$_POST['date_deposit'],
				'bank_deposit'=>$_POST['bank_deposit'],
				'bank_amount'=>$_POST['bank_amount'],
				
				
			);
	      $configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            echo 'No files';
	        } else {
	           $this->db->insert('deposit_info',$insertArr); 
	        }	        
	            
		} else{ 
			echo 'No files';
		}
	}

	function isVoucherCode(){
		  $data = array('status' => true);
		  $value  = json_decode(file_get_contents("php://input"),true);
			if(!empty($value['voucher']) && $value['voucher'] != null){
				  $this->db->where('voucher_code',$value['voucher']);
				  $this->db->where('used','un_used');
				  $user = $this->db->get('voucher_info')->result_array();
				  
				  if(count($user) == 0){
				   $data['status'] = false;
				  }
			}else{
				 $data = array('status' => true);
			}	  
		  echo json_encode($data , JSON_FORCE_OBJECT);
	}
	 
	function platformsList(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM platforms_list where user_id='.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}
	
	/* function productOrderSummary(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id  where a.user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function newProductOrderSummary(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id  where a.purchase_at > "'.$lastDate.'" and a.user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			//echo json_encode($arr);
		}
	} */
	
	function productOrderSummary(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id LEFT JOIN store_user_info as e on e.id=b.purchase_user_id  where a.user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function newProductOrderSummary(){
		header('Content-Type: application/json');
		$lastDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d") - 1, date("Y")));
		
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id LEFT JOIN store_user_info as e on e.id=b.purchase_user_id  where a.delivery_status = "Processing" and a.user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			//echo json_encode($arr);
		}
	}

	function userproductOrderSummaryView($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id WHERE a.purchase_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function userRank(){
		header('Content-Type: application/json');
		$level = $this->mdl_common->countUserLevel('earning_info',$this->session->userdata('user_id'));
		$data = $this->mdl_common->allSelects('SELECT * FROM level_configuration where l_conf_id = '.$level);
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				$arr[] = $value; 
			}
			echo json_encode($arr);
		}else{

		}
	}
	function leadsList(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* From new_leads_followup_table as a LEFT JOIN new_leads as b on b.id=a.lead_id  WHERE b.user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}		
	}
	
	function getRankDetails(){
		$cur_user_id = $this->session->userdata('user_id');
		
		$lftChild = $this->mdl_common->leftChild($cur_user_id);
		$rghtChild = $this->mdl_common->rightChild($cur_user_id);
		
		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$cur_user_id.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$cur_user_id.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$cur_user_id.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary - $totalLeftDeductBinary;

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$cur_user_id.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$cur_user_id.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$cur_user_id.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary - $totalRightDeductBinary;
			
		$totalBinary = $leftUserTotal + $rightUserTotal;
		
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id WHERE a.user_id = '.$cur_user_id);
			if(isset($contentData) && !empty($contentData)){
				foreach($contentData as $value){
					if($value['level'] <6){
						
					}elseif($value['level'] == 6){
						
					}elseif($value['level'] == 7){
						
					}elseif($value['level'] == 8){
						
					}elseif($value['level'] == 9){
						
					}elseif($value['level'] == 10){
						
					}elseif($value['level'] == 11){
						
					}elseif($value['level'] == 12){
						
					}
				}
			}
			echo json_encode($arr);				
	}
	
	function sendMail($user_id){
		$this->mdl_common->sendSponserToSponserMailForNewMember($user_id, $user_id, 1);
		
		$to_email ="dcruz@aleconinc.com";
		$subject	=	'New User Registraion';
		$mail_content = $this->mdl_common->mailContentForNewReg($user_id);
		$mail_body	=	$this->adminMailBody($mail_content);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <info@xonnova.com>' . "\r\n";
		//$headers .= 'Cc: info@xonnova.com' . "\r\n";
		mail($to_email,$subject,$mail_body,$headers);
		//sendMail($to_email,$subject,$mail_body);
		//sendLocalMail($to_email,$subject,$mail_body);
	}
	
	public function send_user_email($user_name=null,$password=null,$user_email) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'Xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Xonnova network Welcome mail');
        $html = $this->mdl_common->userMailBody($user_name,$password);
        $this->email->message($html);

        $this->email->send();
    }
	
	function adminMailBody($mail_content){
		//$userData = $this->mdl_common->allSelects('SELECT a.*,b.* from user_master as a RIGHT JOIN package_info as b on b.package_id=a.package WHERE user_id='.$user_id);		
		$mail_body = "";
		$mail_body .= '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>New User Request</title>
		</head>		
		<body>
			<div style="width:100%;" align="center"><span><img src="http://luxoprinting.com/xonnova/assets/img/logo.png" alt="Image Not Found"/></span></div><br/>
			<h4>New User Signup Details <h4> <br/>';
			 $mail_body .= $mail_content;

		    $mail_body .= 'Thanks,<br />				
						</body>
						</html>		
						';
		return $mail_body;		
	}
	
}