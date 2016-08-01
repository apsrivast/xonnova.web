<?php
/**
* 
*/
class Test extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	function index(){
		$contentData = $this->mdl_common->allSelects("SELECT *
FROM `cashout_info`
WHERE `cashout_status` = 'approve'
ORDER BY `cashout_info`.`user_id` ASC ");
		$contentData = $this->mdl_common->allSelects("SELECT b.user_id,a.user_name,a.address1,a.address2,a.country,a.state,a.city,a.zip,a.contact_no,b.ssn, (SELECT SUM(cashout_ammount) FROM cashout_info WHERE cashout_status='approve' AND user_id=b.user_id) as toal FROM user_master as a RIGHT JOIN user_cashout_info as b on b.user_id=a.user_id ORDER BY b.user_id ASC");
		$contentData = $this->mdl_common->allSelects("SELECT DISTINCT c.user_id, a.user_name, a.address1, a.address2, a.country, a.state, a.city, a.zip, a.contact_no,(SELECT DISTINCT ssn
FROM `user_cashout_info` WHERE user_id=c.user_id ) as ssn, ( SELECT SUM( cashout_ammount )
FROM cashout_info
WHERE cashout_status = "approve"
AND user_id = a.user_id
) AS total
FROM user_master AS a 
LEFT JOIN cashout_info AS c ON c.user_id = a.user_id
WHERE c.cashout_status = "approve"
ORDER BY c.user_id ASC ");
	}
	
	function indexmp(){
		$contentData = $this->mdl_common->allSelects("SELECT *
															FROM `payment_info`
															WHERE `transaction_arb_id` != ''
															AND `payment_at` <= '2015-11-22'
															AND `transaction_arb_id` NOT
															IN (

															SELECT arb_id
															FROM arblist
															)");
		if(!empty($contentData)){
			$i = 0;
			foreach($contentData as $key=>$value){
				$userMasterData = array(
									'user_status'=>'inactive',
									'subscription_status'=>'inactive'
								);
				$this->db->update('user_master',$userMasterData,array('user_id'=>$value['user_id']));
				$cancleUpdateArr = array(
								'sub_status'=>'inactive'
						);
				$this->db->update('payment_info',$cancleUpdateArr,array('user_id'=>$value['user_id']));
				echo $i++ ;
				echo '<br/>' ;
			}
		}
	}
	
	function upgradeArbStatusByVoucher(){
		$contentData = $this->mdl_common->allSelects("SELECT DISTINCT user_id FROM `voucher_details` WHERE user_id > 1 AND created_at <= '2015-11-22' ");
		if(!empty($contentData)){
			$i = 0;
			foreach($contentData as $key=>$value){
				$userMasterData = array(
									'user_status'=>'inactive',
									'subscription_status'=>'inactive'
								);
				$this->db->update('user_master',$userMasterData,array('user_id'=>$value['user_id']));
				echo $i++ ;
				echo '<br/>' ;
			}
		}
	}
	
	function index65(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM `user_master` WHERE `package`=1 AND `user_type`="user"');
		if(!empty($contentData)){
			foreach($contentData as $key=>$value){
				$totalCount = $this->mdl_common->allSelects('SELECT sum() as totalBinary from unilevel_binary_info WHERE user_id='.$value['user_id']);
				if(!empty($totalCount)){
					foreach($totalCount as $totalBinary){
						echo $totalBinary['totalBinary'];
					}
				}
			}
		}
	}
	
	function index1(){
		echo count($this->mdl_common->allSelects("SELECT a. * , b.user_id, b.payment_at, c.user_name, b.sub_status FROM `card_detail` AS a LEFT JOIN payment_info AS b ON b.transaction_arb_id = a.`arb_id` LEFT JOIN user_master AS c ON c.user_id = b.user_id WHERE b.sub_status = 'active' AND c.subscription_status = 'active'"));
	}
	function getArbActiveUser(){
		$contentData = $this->mdl_common->allSelects("SELECT a. * , b.user_id, b.payment_at, c.user_name, b.sub_status
														FROM `card_detail` AS a
														LEFT JOIN payment_info AS b ON b.transaction_arb_id = a.`arb_id`
														LEFT JOIN user_master AS c ON c.user_id = b.user_id
														WHERE b.sub_status = 'active'
														AND c.subscription_status = 'active'
														ORDER BY `a`.`acc` ASC "
														);
		if(!empty($contentData)){
			echo '<table>
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>ARB Acount</th>
                                <th>ARB ID</th>
								<th>ARB Status</th>
								<th>Date</th>
                            </tr>
                        </thead>
                        <tbody>';
			$i = 1;
			foreach($contentData as $value){
				echo '<tr align="center">';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$value['user_id'].'</td>';
				echo '<td>'.$value['user_name'].'</td>';
				echo '<td>'.$value['acc'].'</td>';
				echo '<td>'.$value['arb_id'].'</td>';
				echo '<td>'.$value['sub_status'].'</td>';
				echo '<td>'.$value['payment_at'].'</td>';
				echo '</tr>';
				$i++;
			}
			echo '</tbody>
				</table>';
		}
	}
	function processUserLevel($startId){	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
		$coutnLevel = $this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND unilevel_rant_created >='.date('Y-m-d'));	
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
				if(empty($coutnLevel)){	
					echo $this->getSponsorToBottom($value['user_id'],$startId,$value['user_id']);	
				}	    		
	    	}
	    }
	}
	
	function getSponsorToBottom($startId=null,$userID=null,$directSponsor=null){	    	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
	    $i = null;
	    if(!empty($row)){
		    foreach ($row as $key => $value) {
		    	if(!empty($value['user_id'])){
		        	$this->getSponsorToBottom($value['user_id'],$userID,$directSponsor);	  		
		        	echo $value['user_id'].' => '.$value['sponser_id'].' => '.$value['level'].'<br>'; 
		    	}
		    }	    	    	
	    }
	}
	
	function countUserLevel($startId){	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
	    $i = null;
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
				$level = 6;
				$coutnLevel = $this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND direct_sponsor='.$value['user_id'].' AND member_rank >='.$level.' AND unilevel_rant_created >='.date('Y-m-d'));	
	    		if(!empty($coutnLevel)){
	    			$x = count($coutnLevel);	   
	    			if(!empty($x) && $x >= 1){
	    				$i++;
	    			} 			
	    		}
	    	}
	    }
	    echo $i;
	}
	
	
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
	
	function index17897($a,$b,$c){
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