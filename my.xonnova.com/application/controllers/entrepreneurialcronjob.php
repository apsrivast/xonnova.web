<?php
/**
* 
*/
class Entrepreneurialcronjob extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function countEnterpreneurialMember($user_id,$rulepercent,$requireMember) {
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
		$x = $requireMember * $rulepercent / 100;
		$y = explode('.', $x);
		$z = $y[0];
		$total = null;
		$total1 = null;
		$allSponsor = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE subscription_status = "active" AND created_at < "'.$recurringStartDate.'" AND sponsor_id='.$user_id);
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

	

	function payEntrepreneurial2(){
		$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
		if(isset($selectearningtotal) && !empty($selectearningtotal)){
			foreach ($selectearningtotal as $total) {						
				$totalreferralAmount= $total['total_balance'] + 120;
				$updattotalarr = array(
					'total_balance'=>$totalreferralAmount,
					'module'=>1,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
			}
		}else{
			$updattotalarr = array(
				'total_balance'=>120,
				'module'=>1,
			);
			$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
		}

		$insertArr = array(
				'user_id'=>$value['user_id'],
				'module_id'=>1,
				'module_bonus'=>120,
				'rule_percent'=>40,
			);
		$this->db->insert('interpreneurial_bonus_deduct', $insertArr);

		//Earning Details in one table	
		$earning_details_by_user = array(
				'user_id'=>$value['user_id'],
				//'ref_id'=>$rghtChild,
				'description'=>'First Module Bonus  Amount',
				'amount'=>120,
				//'message'=>"",
				'e_d_b_u_date'=>$value['created_at'],
			);
		$this->db->insert('earning_details_by_user',$earning_details_by_user);
		//end
	}		
	
	function payEntrepreneurial($id, $module, $amount, $rule){		
		$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$id);
		
				//Earning Details in one table
				if($module == 1){
				$description = 'First Module Bonus  Amount';
				}else if ($module == 2){
				$description = '2nd Module Bonus  Amount';
				}else if ($module == 3){
				$description = '3rd Module Bonus  Amount';
				}else if ($module == 4){
				$description = '4th Module Bonus  Amount';
				}else if ($module == 5){
				$description = '5th Module Bonus  Amount';
				}
				$payDate = date('Y-m-d H:i:s', mktime(date("H") - 2, date("i"), date("s"), date("m"), date("d") + 10, date("Y")));
				$earning_details_by_user = array(
				'user_id'=>$id,
				//'ref_id'=>$rghtChild,
				'description'=>$description,
				'amount'=>$amount,
				//'message'=>"",
				'e_d_b_u_date'=>$payDate,
				);
				$this->db->insert('earning_details_by_user',$earning_details_by_user);
				//end
	}
	
	function payEntrepreneurialBonusModule(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM interpreneurial_bonus_module WHERE module_status= 1 ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {

				$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$value['user_id']);
					
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {						
						$totalreferralAmount= $total['total_balance'] + $value['module_bonus'];
						$updattotalarr = array(
							'total_balance'=>$totalreferralAmount,
							'module'=>$value['module_id'], 
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
					}
				}else{
					$updattotalarr = array(
						'total_balance'=>$value['module_bonus'], 
						'module'=>$value['module_id'], 
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
				}

				$updattotalarr2 = array('module_status'=> 2);
				$this->db->update('interpreneurial_bonus_module',$updattotalarr2,array('user_id'=>$value['user_id']));


		   	}			
		}
	}

	function entrepreneurialHistory($id, $module, $totalSponsored, $totalMember){		
				$arr = array(
				'user_id'=>$id,
				'module_id'=>$module,
				'total_sponsor'=>$totalSponsored,
				'total_member'=>$totalMember,
				);
				$this->db->insert('entrepreneurial_history',$arr);
	}

	function interpreneurialBonusModuleByMonthOldFun(){
		$recurringStartDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
		$recurringStartDate1 = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE created_at <= "'.$recurringStartDate.'"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
		   		$totalSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE created_at <= "'.$recurringStartDate.'" AND  sponsor_id ='.$value['user_id']));
		   		$curentModule = $this->entrepreneurial_mdl->getModuleID($value['user_id']);
		   		$nxtModule = $curentModule + 1;
		   		$rulePercent = $this->entrepreneurial_mdl->getRulePercentOfModule($nxtModule);
		   		$requiredMember = $this->entrepreneurial_mdl->getRequiredTeamMember($nxtModule);
		   		$totalMember = $this->countEnterpreneurialMember($value['user_id'],$rulePercent,$requiredMember);		
		   		$personalSponsorMemberR = $this->entrepreneurial_mdl->getPresonalSponsorMember($nxtModule);
		   		$modulePaymentAmount = $this->entrepreneurial_mdl->getModuleAmount($nxtModule);
		   		if($curentModule == 0 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
							'molude_created_at'=>$recurringStartDate1
	   					);
	   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 1 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 2 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 3 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 4 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else{

		   		}
		   		echo ' User ID :'.$value['user_id'].' User name :'.$value['user_name'].', Module current : '.$curentModule.' Sponsor Member : '.$totalSponsored.' module Payment :'.$modulePaymentAmount.' Total Member '.$totalMember.', Date :'.$recurringStartDate1.'<br>';
			}			
		}
	}
	
	function interpreneurialBonusModule(){
		$recurringStartDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
		$recurringStartDate1 = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE created_at <= "'.$recurringStartDate.'" AND user_type="user"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$totalSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE created_at <= "'.$recurringStartDate.'" AND subscription_status = "active" AND  sponsor_id ='.$value['user_id']));

				$totalModule = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info ORDER BY e_id DESC');
				if(!empty($totalModule)){
					foreach ($totalModule as $key => $module) {
						$totalMember = $this->countEnterpreneurialMember($value['user_id'],$module['rule_percent'],$module['total_member_in_team']);
						if((!empty($totalSponsored) && $totalSponsored >= $module['p_sponsor_user']) && (!empty($totalMember) && $totalMember >= $module['total_member_in_team'])){
							$thisMonthModule = count($this->mdl_common->allSelects('SELECT * FROM interpreneurial_bonus_module WHERE user_id='.$value['user_id'].' AND module_status="1" '));
							if(empty($thisMonthModule) && $thisMonthModule < 1){
								$updattotalarr = array('module'=>$module['e_id']);
								$insertArr = array(
				   						'user_id'=>$value['user_id'],
				   						'module_id'=>$module['e_id'],
				   						'module_bonus'=>$module['payment'],
				   						'rule_percent'=>$module['rule_percent'],
				   					);
				   				$this->db->insert('interpreneurial_bonus_module', $insertArr);					
				   				$this->payEntrepreneurial($value['user_id'], $module['e_id'], $module['payment'], $module['rule_percent']);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
				   				$this->entrepreneurialHistory($value['user_id'], $module['e_id'], $totalSponsored, $totalMember);
				   				echo 'user id'.$value['user_id'].', '.$module['payment'].', '.$thisMonthModule.'<br/>';
							}
						}
					}
				}	   		
			}			
		}
	}
}