<?php
/**
* 
*/
class EntrepreneurialReport extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function entrepreneurialHistory(){
		
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT *  From entrepreneurial_history WHERE user_id ='.$this->session->userdata('user_id').'  AND created_at BETWEEN "'.$from.'" AND "'.$to.'"');
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

	function getEntrepreneurialReport($userId = null){
		$post = json_decode(file_get_contents("php://input"),true);
		if(!empty($userId)){
			$id = $userId;
		}else{
			$id = $this->session->userdata('user_id');
		}
		//$id = 1;
		if(!empty($id)){
			$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
	   		$userName = $this->mdl_common->getUserNameById($id);
			$totalPaidBonus = $this->paidEntrepreneurialBonus($id);
			$totalTeamMember = $this->entrepreneurial_mdl->getTotalMemberInTeam($id);
			$totalDirectSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE created_at <= "'.$recurringStartDate.'" AND subscription_status="active" AND sponsor_id ='.$id));
	   		$curentModule = $this->entrepreneurial_mdl->getModuleID($id);
	   		$nxtModule = $curentModule + 1;
	   		

	   		$currentModuleName = $this->entrepreneurial_mdl->getModuleName($curentModule);
	   		$nextModuleName = $this->entrepreneurial_mdl->getModuleName($nxtModule);
	   		$moduleAmount = $this->entrepreneurial_mdl->getModuleAmount($nxtModule);

	   		$rulePercent = $this->entrepreneurial_mdl->getRulePercentOfModule($nxtModule);
	   		$requiredSponsor = $this->entrepreneurial_mdl->getPresonalSponsorMember($nxtModule);
	   		$requiredMember = $this->entrepreneurial_mdl->getRequiredTeamMember($nxtModule);
	   		
	   		$totalQualifiedMember = $this->countEnterpreneurialMember($id,$rulePercent,$requiredMember);		
	   		$missingQualifiedMember = $requiredMember - $totalQualifiedMember;
	   		$missingDirectSponsor =  $requiredSponsor - $totalDirectSponsored;
			$data = array(
						'user_name'=>$userName,
						'total_paid_bonus'=>$totalPaidBonus,
						'total_team_member'=>$totalTeamMember,
						'total_direct_sponsor'=>$totalDirectSponsored,
						'current_module'=>$currentModuleName,
						'next_module'=>$nextModuleName,
						'rule_percent'=>$rulePercent,
						'required_sponsor'=>$requiredSponsor,
						'required_member'=>$requiredMember,
						'total_qualified_member'=>$totalQualifiedMember,
						'missing_qualified_member'=>$missingQualifiedMember,
						'missing_direct_sponsor'=>$missingDirectSponsor,
						'module_amount'=>$moduleAmount,
				);
			echo json_encode($data);
		}else{

		}
	}

	function paidEntrepreneurialBonus($where){
		$contentData = $this->mdl_common->allSelects('SELECT SUM(module_bonus) as total FROM interpreneurial_bonus_module WHERE user_id='.$where);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 'NA';
		}
	}

	function entrepreneurialTeamMember(){
		header('Content-Type: application/json');
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
		$contentData = $this->mdl_common->allSelects('SELECT * From user_master WHERE created_at <= "'.$recurringStartDate.'" AND subscription_status="active" AND sponsor_id ='.$this->session->userdata('user_id'));
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function TotalTeamMember($id = null){
		header('Content-Type: application/json');
		//$id = $this->session->userdata('user_id');
		
		$contentData = $this->mdl_common->allSelects('SELECT user_id, user_name, subscription_status  From user_master WHERE subscription_status="active" AND sponsor_id ='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				 $arr[]=$value;
			}
			return $arr;
		}else{

		}
	}

	function getTotalMemeber(){
		//$x = [];
		$id = 1;
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_id='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$x[] =  $this->TotalTeamMember($value['user_id']);
			}
			echo json_encode($x);
		}else{

		}
	}

	function countEnterpreneurialMember($user_id,$rulepercent,$requireMember) {
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
		$x = $requireMember * $rulepercent / 100;
		$y = explode('.', $x);
		$z = $y[0];
		$total = null;
		$total1 = null;
		$allSponsor = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE subscription_status = "active" AND created_at <= "'.$recurringStartDate.'" AND sponsor_id='.$user_id);
	    if(!empty($allSponsor)){
	    	$countAllSponsor = count($allSponsor);
	    	foreach ($allSponsor as $key => $value) {
	    		$totalMember = $this->entrepreneurial_mdl->getTotalMemberInTeam($value['user_id']);
	    		if($totalMember >= $z){
	    			$total += $z;
	    		}else{
	    			$total1 += $totalMember;
	    		}
	    	}
	    	$a = $total + $total1;
	    	return $a;
	    }else{
	    	return 0;
	    }
	}


	// admin

	function entrepreneurialBonus1(){
		//header('Content-Type: application/json');
		$getPackage = $this->mdl_common->allSelects('SELECT * From user_master WHERE user_type="user"');
		$arr = null;
		$arr = '[';
		$i = 1;
		foreach ($getPackage as $key => $value) {
			$arr .= "{'user_id'=>'".$value['user_id']."','user_name'=>'".$value['user_name']."','card_no'=>'".$this->getCardNo($value['user_id'])."','transaction_arb_id'=>'".$this->getSubscriptionArbID($value['user_id'])."','subscription_status'=>'".$value['subscription_status']."'}";
			if($i < count($getPackage)){
				$arr .= ",";
			}
			$i++;
		}
		$arr .= ']';
		echo json_encode($arr);
	}

	function entrepreneurialBonus(){
		header('Content-Type: application/json');
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));

		$getPackage = $this->mdl_common->allSelects('SELECT a.*, b.* From user_master as a RIGHT JOIN payment_info as b on b.user_id=a.user_id WHERE created_at <= "'.$recurringStartDate.'" AND b.transaction_arb_id != "" ORDER BY user_name ASC');
		foreach ($getPackage as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getCardNo($where){
		$contentData = $this->mdl_common->allSelects("SELECT * FROM `payment_info` WHERE transaction_arb_id != '' AND user_id =".$where);
		if(!empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				return $value['card_no'];
			}
		}else{
			return "NA";
		}
	}

	function getSubscriptionArbID($where){
		$contentData = $this->mdl_common->allSelects("SELECT * FROM `payment_info` WHERE transaction_arb_id != '' AND user_id =".$where);
		if(!empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				return $value['transaction_arb_id'];
			}
		}else{
			return "NA";
		}
	}



}