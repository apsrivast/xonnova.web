<?php
/**
* 
*/
class Testpk extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		echo "Kaushal Test";
	}
	
	function downLine2($id, $spc){
		$spc++;
		$getOne = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$id);
		foreach ($getOne as $key => $value) {
			for($i = 0; $i < $spc; $i++){
				echo '=====';
			}
			echo $value['user_name'].'<br>';
			$getTwo = $this->mdl_common->allSelects('SELECT user_id From user_master WHERE sponsor_id = '.$value['user_id']);
			if(isset($getTwo) && !empty($getTwo)){
				$this->downLine2($value['user_id'],$spc);
			 }
		}
	}
	
	function countRank($startId){		
	
		echo  $this->mdl_common->countTotalUnilevelMember1(27);
		//echo  $this->mdl_common->countUnilevelUserRank(27,6);
		//echo  "sdf fdsgads";
	}
	
	
	function addPromoPackList(){		
	    $LIst = $this->mdl_common->allSelects("SELECT user_id, user_name FROM user_master WHERE  package > 4");
		foreach ($LIst as $total) {						
			$insertArr = array(
				'user_id'=>$total['user_id'],
				'user_name'=>$total['user_name'],
			);
			if(!$this->db->insert('promo_pack_user',$insertArr)){
			    $data = array('message' => $this->db->_error_message());
				echo $total['user_id'].'   '.$total['user_name'].'     '.$this->db->_error_message().' <br>';
			}else{
				echo $total['user_id'].'   '.$total['user_name'].'  successfully ! <br>';
			}
		}
	}
	
	
	
	/* function addFounderList(){		
	    $LIst = $this->mdl_common->allSelects("SELECT user_id, user_name FROM user_master WHERE  package = 5");
		foreach ($LIst as $total) {						
			$insertArr = array(
				'user_id'=>$total['user_id'],
				'user_name'=>$total['user_name'],
			);
			if(!$this->db->insert('founder_member',$insertArr)){
			    $data = array('message' => $this->db->_error_message());
				echo $total['user_id'].'   '.$total['user_name'].'     '.$this->db->_error_message().' <br>';
			}else{
				echo $total['user_id'].'   '.$total['user_name'].'  successfully ! <br>';
			}
		}
	} */

	
	
	function parentToparentUser($startId){		
	

	    $LIst = $this->mdl_common->allSelects("SELECT user_id, parent_id, user_name FROM user_master WHERE  user_id = ".$startId);
	    if(isset($LIst) && !empty($LIst)){
			foreach ($LIst as $total) {						
				$this->parentToparentUser($total['parent_id']);
				$LIst2 = $this->mdl_common->allSelects("SELECT referral_binary_point FROM earning_info WHERE  user_id = ".$startId);
			    if(isset($LIst2) && !empty($LIst2)){
					foreach ($LIst2 as $total2) {		

					echo $total['user_id'].'   '.$total['user_name'].'   '.$total2['referral_binary_point'].'<br>';
					}
				}
			
			}
		}else{

		}
	}
	
	function sponsorTosponsorUser($startId){	
	    $LIst = $this->mdl_common->allSelects("SELECT user_id, sponsor_id, user_name FROM user_master WHERE  user_id = ".$startId);
	    if(isset($LIst) && !empty($LIst)){
			foreach ($LIst as $total) {						
				$this->sponsorTosponsorUser($total['sponsor_id']);
				echo $total['user_id'].'   '.$total['user_name'].'<br>';
			}
		}else{
		}
	}
	
	function sponsorToForLevel($startId){	
	    $LIst = $this->mdl_common->allSelects("SELECT user_id, sponser_id , level FROM earning_info WHERE  user_id = ".$startId);
	    if(isset($LIst) && !empty($LIst)){
			foreach ($LIst as $total) {						
				$this->sponsorToForLevel($total['sponser_id']);
				echo $total['user_id'].'   '.$total['level'].'<br>';
			}
		}else{
		}
	}
	
	
	
	
	function countUnilevelUserRank($startId){		
		// $directDescendents = $this->db->query("SELECT user_id, level FROM earning_info WHERE level=".$level." and sponser_id = ?", array( $startId ));
	 //    $count = $directDescendents->num_rows($directDescendents);
	 //    $row = $directDescendents->result_array($directDescendents);
	 //    foreach ($row as $key => $value) {
	 //        $count += $this->countUnilevelUserRank($value['user_id'],$level);
	 //    }
	 //    return $count;

	    $LIst = $this->mdl_common->allSelects("SELECT  a.user_id, a.level, b.user_name From earning_info as a RIGHT JOIN user_master as b on a.user_id = b.user_id  WHERE  a.sponser_id = ".$startId);
	    if(isset($LIst) && !empty($LIst)){
			foreach ($LIst as $total) {						
				$this->countUnilevelUserRank($total['user_id']);
				echo $total['user_id'].'      '.$total['user_name'].'     '.$total['level'].'<br>';
			}
		}else{

		}
	}
	
	function index1($a,$b,$c){
		echo  $totalMember = $this->countEnterpreneurialMember($a,$b,$c);
	}
	
	
	function cancelSubscriptionCancle($userId){
		$cancleUpdateArr = array('sub_status'=>'active');
		$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$userId));
		$this->db->update('user_master',array('package'=>1,'subscription_status'=>'active','user_status'=>'active','login_status'=>'active'),array('user_id'=>$userId));
		$this->db->update('earning_info',array('level'=>1),array('user_id'=>$userId));

		$LIst = $this->mdl_common->allSelects('SELECT user_id from referral_bonus where parent_id = '.$userId);
		foreach ($LIst as $total) {						
			$this->db->update('user_master',array('sponsor_id'=>$userId),array('user_id'=>$total['user_id']));
			$this->db->update('earning_info',array('sponser_id'=>$userId),array('user_id'=>$total['user_id']));
			echo $total['user_id'].'<br>';
		}
	}

	function countEnterpreneurialMember($user_id,$rulepercent,$requireMember) {
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d") - 19, date("Y")));
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
	
	
	function getTotal($id){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id='.$id);
		echo '<table width="100%" cellspacing="0" cellpadding="10px"  height="100px" style="border:2px solid rgb(0,0,0);">
							<thead>
								<tr>
									<th>user id</th>
									<th>name</th>
									<th>current Module</th>
									<th>Total Sponsor</th>
									<th>payment</th>
									<th>total Member</th>
									<th>Date</th>
							</thead>
							<tbody>
								';
					
						$this->interpreneurialBonusModule($id);
			echo '</tbody>
						</table><br>';
		if(!empty($contentData)){
			echo '<table width="100%" cellspacing="0" cellpadding="10px"  height="100px" style="border:2px solid rgb(0,0,0);">
							<thead>
								<tr>
									<th>user id</th>
									<th>name</th>
									<th>current Module</th>
									<th>Total Sponsor</th>
									<th>payment</th>
									<th>total Member</th>
									<th>Date</th>
							</thead>
							<tbody>
								';
					foreach ($contentData as $key => $value) {
						$this->interpreneurialBonusModule($value['user_id']);
					}
			echo '</tbody>
						</table>';
		}
	}

	function interpreneurialBonusModule($id){
		$recurringStartDate = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d") - 19, date("Y")));
		$recurringStartDate1 = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_id ='.$id.' AND created_at <= "'.$recurringStartDate.'"');
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
	   				//$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				//$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					//$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				//$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 1 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				//$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				//$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
				//	$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				//$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 2 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				//$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				//$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					//$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				//$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 3 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				//$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				//$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					//$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				//$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else if($curentModule == 4 && $totalMember >= $requiredMember && $totalSponsored >= $personalSponsorMemberR){
		   			$updattotalarr = array('module'=>$nxtModule);
					$insertArr = array(
	   						'user_id'=>$value['user_id'],
	   						'module_id'=>$nxtModule,
	   						'module_bonus'=>$modulePaymentAmount,
	   						'rule_percent'=>$rulePercent,
	   					);
	   				//$this->db->insert('interpreneurial_bonus_module', $insertArr);					
	   				//$this->payEntrepreneurial($value['user_id'], $nxtModule, $modulePaymentAmount, $rulePercent);
					//$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
	   				//$this->entrepreneurialHistory($value['user_id'], $nxtModule, $totalSponsored, $totalMember);
		   		}else{

		   		}

		   		echo '<tr style="background-color:#c0c0c0;" >
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										'.$value['user_id'].'
									</td>
									<td  align="center" style="border:0 1px 0 1px solid rgb(0,0,0);">
										'.$value['user_name'].'
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" width="10%">
										'.$curentModule.'
									</td>

									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										'.$totalSponsored.'
									</td>
									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										'.$modulePaymentAmount.'
									</td>
									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										'.$totalMember.'
									</td>
									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										'.$recurringStartDate1.'
									</td>
									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										<a href="'.$value['user_id'].'" target="__blank" class="btn btn-pirmary">View</a>
									</td>
								</tr>
							';
			}			
		}
	}
}