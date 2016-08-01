<?php
/**
* 
*/
class Level extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		//header('Content-Type: application/json');
	}
	
	function myLevel($a){
		//header('Content-Type: application/json');
		$query = "SELECT * FROM user_master  WHERE user_id = '".$a."'";
		$tree = $this->mdl_common->allSelects($query);
		$m = "";
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $key => $value4) {	
				$m .='[';
					$left4 = $this->mdl_common->leftChild($value4['user_id']);
					$right4 = $this->mdl_common->rightChild($value4['user_id']);
					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
					if(!empty($Ltree5) && !empty($left4)){
						foreach ($Ltree5 as $key => $value5) {
							$m .='{
								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
								
							$m .=']},';
						}
					}else{
						$m .='{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
					}
					if(!empty($Rtree5) && !empty($right4)){
						foreach ($Rtree5 as $key => $value5) {
							$m .= '{
								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
								
							$m .=']}';
						}
					}else{
						$m .= '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"}';
					}
				$m .= ']';
			}
		}
		echo $m;
	}
	
	function myUnilevelLevel($a){
		$query = "SELECT * FROM user_master  WHERE user_id = '".$a."'";
		$tree = $this->mdl_common->allSelects($query);
		$m = "";
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $key => $value4) {	
				$m .='[';
					$query = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value4["user_id"]."'";
					$tree = $this->mdl_common->allSelects($query);
					$count = count($tree);
					$i = null;
					if(isset($tree) && !empty($tree)){
						foreach ($tree as $key => $value) {
							$m .= '{
								"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
								
							$m .=']}';
							$i++;
							if($i != $count){
								$m .=',';
							}
						}
					}		
				$m .= ']';
			}
		}
		echo $m;
	}
	
	function getSponsorUser(){		
		$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.sponsor_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 ');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
			$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
			$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;
			$x = $discountPercentOfPackage/2;
			$restBV = $levelExitPrice*$x/100;
			//print_r($user);
			//echo count($user) - 1 . ' : '.$value['sponsor_id'] .' <br>' ;
			/* for($i=count($user)-1; $i>=1;$i--){
				echo $user[$i].'<br>';
			}exit; and a.sponsor_id=2 */
			//$sponsor = count($this->mdl_common->allSelects('SELECT * FROM user_master where sponsor_id='.$value['sponsor_id']));
			echo '<br>'.$value['sponsor_id'].'  : ='. count($user) .'<br>';
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
							//$Qv .= $totalQV1.',';
							$Qv2 += $totalQV1;
						}
					}
				}
				if(!empty($Qv1)){
					$total2 = $Qv2 + $Qv1 ;
					echo '<br> Total := '.$total2.'  : ='. count($user) .'<br>';
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6);
						$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}
				/*if(!empty($user[0]) && !empty($user[1]) && !empty($user[2])){
					$totalQV = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[0]);
					$totalQV1 = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[1]);
					$totalQV2 = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[2]);
					if((!empty($totalQV) && !empty($totalQV1) && !empty($totalQV2) && !empty($level) && !empty($discountPercentOfPackage) && !empty($package) && !empty($levelExitPrice) && !empty($currentUserTotalBinaryPercent)) || ($level > 0 && $package > 0 && $levelExitPrice > 0 && $discountPercentOfPackage > 0 && $currentUserTotalBinaryPercent > 0)){
						 echo $totalQV.' : '.$user[0].'<br> :';
						echo $totalQV1.' : '.$user[1].'<br> ';
						echo $totalQV2.' : '.$user[2].'<br>'; 
						if($totalQV > $currentUserTotalBinaryPercent && $totalQV1 > $currentUserTotalBinaryPercent && $totalQV2 > $restBV && $level < 6){
							$updArr = array('level'=>6);
							$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
						}elseif($totalQV > $currentUserTotalBinaryPercent && $totalQV1 > $restBV && $totalQV2 > $currentUserTotalBinaryPercent && $level < 6){
							$updArr = array('level'=>6);
							$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
						}elseif($totalQV > $restBV && $totalQV1 > $currentUserTotalBinaryPercent && $totalQV2 > $currentUserTotalBinaryPercent && $level < 6){
							$updArr = array('level'=>6);
							$this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
						}						
					}
					
				}*/			
			} 
		}
	}
	
	function index(){
		$xata = $this->mdl_common->getTotalMemberInTeam(2);
		echo $xata.'<br/>';
	}
	
	function getLevel(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM level_configuration');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getLevelById($id){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM level_configuration where l_conf_id='.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	
	function updateLevel($id){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$error = false;
		if(empty($_POST['level_name'])){
			$data = array('error_level_name'=>'This field is required!');
			//$error = false;
		}elseif(empty($_POST['level_bonus'])){
			$data = array('error_level_bonus'=>'This field is required!');
			//$error = false;
		}elseif(empty($_POST['level_discount_percent'])){
			$data = array('error_level_discount_percent'=>'This field is required!');
			//$error = false;
		}elseif(empty($_POST['exit_qv'])){
			$data = array('error_exit_qv'=>'This field is required!');
			//$error = false;
		}elseif(empty($_POST['level_name'])){
			$data = array('error_level_name'=>'This field is required!');
			//$error = false;
		}else{
			$error = true;
		}
		if($error){
			$updateArr = array(
				'level_name'=>trim($_POST['level_name']),
				'level_bonus'=>trim($_POST['level_bonus']),
				'level_discount_percent'=>trim($_POST['level_discount_percent']),
				'exit_qv'=>trim($_POST['exit_qv'])
				//'level_binary_point'=>trim($_POST['level_binary_point']),
				//'max_daily_earning'=>trim($_POST['max_daily_earning']),
				//'product_discount_percent'=>trim($_POST['product_discount_percent']),
				//'product_binary_point'=>trim($_POST['product_binary_point'])
			);
			if(!$this->db->update('level_configuration',$updateArr,array('l_conf_id'=>$_POST['l_conf_id']))){
				$data = array('errormess'=> $this->db->_error_message());
			}else{
				$data = array('message'=>'Update success!');
			}	
		}else{
			$data = array('errormess'=>$error);
		}
		echo json_encode($data);
	}

	/* function updateLevel($id){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'level_name'=>trim($_POST['level_name']),
			'level_bonus'=>trim($_POST['level_bonus']),
			'max_daily_earning'=>trim($_POST['max_daily_earning']),
			'level_discount_percent'=>trim($_POST['level_discount_percent']),
			'level_binary_point'=>trim($_POST['level_binary_point']),
			'product_discount_percent'=>trim($_POST['product_discount_percent']),
			'product_binary_point'=>trim($_POST['product_binary_point'])
		);
		$this->db->update('level_configuration',$updateArr,array('l_conf_id'=>$_POST['l_conf_id']));
	} */
}