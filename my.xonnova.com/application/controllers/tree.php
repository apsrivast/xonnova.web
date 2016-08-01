<?php 
/**
* 
*/
class Tree extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function getTree(){
		header('Content-Type: application/json');
		$data = "";
 		$query = "SELECT * FROM user_master  WHERE user_id = '".$this->session->userdata('user_id')."'";
		$tree = $this->mdl_common->allSelects($query);
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $key => $value) {			
					$data .= '{"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
					"children":[';
					$query1 = "SELECT   * FROM user_master  WHERE parent_id = '".$value["user_id"]."'";
					$tree1 = $this->mdl_common->allSelects($query1);
					foreach ($tree1 as $key => $value1) {
						$data .= '{
							"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
							$query2 = "SELECT   * FROM user_master  WHERE parent_id = '".$value1["user_id"]."'";
								$tree2 = $this->mdl_common->allSelects($query2);
								if(isset($tree2) && !empty($tree2)){
									foreach ($tree2 as $key => $value2) {
										$data .= '{
											"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
											
										$data .=']},';
									}
								}
						$data .= ']},';						
					}
					$data .= ']';
				$data .= '};';
			}
			echo json_encode($data);
		}
	}

	function unilevelSearch(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['unilevel_user'])){
			$user_email = $this->mdl_common->getUserEmail($_POST['unilevel_user']);
				if(!empty($user_email) && $user_email != false){
					$this->session->set_userdata('uninlevel_user',$user_email);
					$data = array('message'=>'Please wait...');
					echo json_encode($data);					
				}else{
					$data = array('message'=>'User name does not exist!');
					echo json_encode($data);
				}			
		}else{
			$data = array('message'=>'User name is Required!');
			echo json_encode($data);
		}
	}
	
	function boardlevelSearch(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['boardlevel_user'])){
			$user_email = $this->mdl_common->getUserEmail($_POST['boardlevel_user']);
				if(!empty($user_email) && $user_email != false){
					$this->session->set_userdata('boardlevel_user',$user_email);
					$data = array('message'=>'Please wait...');
					echo json_encode($data);					
				}else{
					$data = array('message'=>'User name does not exist!');
					echo json_encode($data);
				}			
		}else{
			$data = array('message'=>'User name is Required!');
			echo json_encode($data);
		}
	}
	
	function unilevelSearchByUser(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userID = $this->session->userdata('user_id');
		if(!empty($_POST['unilevel_user']) ){
			$userInMyTree = $this->countParentToParent($userID,$_POST['unilevel_user']);
			if($userInMyTree == true){
			    $user_email = $this->mdl_common->getUserEmail($_POST['unilevel_user']);
				if(!empty($user_email) && $user_email != false){
					$this->session->set_userdata('uninlevel_user',$user_email);
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

	function boardlevelSearchByUser(){ 
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userID = $this->session->userdata('user_id');
		if(!empty($_POST['boardlevel_user'])){
				$userInMyTree = $this->countParentToParent($userID,$_POST['boardlevel_user']);
				if($userInMyTree == true){
					$user_email = $this->mdl_common->getUserEmail($_POST['boardlevel_user']);
					if(!empty($user_email) && $user_email != false){
						$this->session->set_userdata('boardlevel_user',$user_email);
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
			$parent = $this->mdl_common->getAllParent($childUser);
			$countUser = $childUser;
			for($i=$parent; $i>=1; $i--){
				$sponser = $parent;
				if($sponser > 0){		
					$countUser .= 	','.$sponser;
				}
				$parent = $this->mdl_common->getAllParent($sponser);
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

	function countSponserToSponser($parntUser,$user1){
		$childUser = $this->mdl_common->getUserId($user1);
		if(!empty($childUser)){
			$parent = $this->mdl_common->getAllSponsor($childUser);
			$countUser = $childUser;
			for($i=$parent; $i>=1; $i--){
				$sponser = $parent;
				if($sponser > 0){		
					$countUser .= 	','.$sponser;
				}
				$parent = $this->mdl_common->getAllSponsor($sponser);
			}
			$ar = explode(',', $countUser);
			print_r($ar);
			if (in_array($parntUser, $ar)) {
			    return true;
			}else{
				return false;
			}			
		}else{
			return false;
		}
	}
}