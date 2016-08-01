<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_common extends CI_Model {
	function __construct(){
        parent::__construct();
    }

    function xoApp($email, $pass){
		$servername = "localhost";
		$username = "danicruz_xoapp";
		$password = "skills@123";
		$dbname = "danicruz_xoapp";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$sql = "INSERT INTO admin (email, password, created_at, updated_at) VALUES ('".$email."', '".sha1($pass)."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
		$conn->query($sql);
		$conn->close();			
	}


    function SBparentId($where){
		$query = "SELECT sb_parent_id FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['sb_parent_id'];
		}			
	}


   
	function SBleftChild($where){
		$query = "SELECT sb_top_id FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['sb_top_id'];
		}			
	}
	function SBmidChild($where){
		$query = "SELECT sb_mid_id FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['sb_mid_id'];
		}			
	}
	
	function SBrightChild($where){
		$query = "SELECT sb_bottum_id FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['sb_bottum_id'];
		}			
	}



    function SBdownLineChildUser($id, $name){
		echo 'var SBtreeData = {"id":'.$id.',"name":"'.$name.'","image":"avatar_default.png","children":[';
		echo $this->SBdownLineChild($id);
		echo ']};';
	}



    function SBdownLineChild($id){
    	$left = $this->SBleftChild($id);/////top
    	$mid = $this->SBmidChild($id);
		$right = $this->SBrightChild($id);//////bottum
    	$Ltree1 = $this->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$left);
    	$Mtree1 = $this->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$mid);
		$Rtree1 = $this->allSelects("SELECT user_id, user_name FROM user_master  WHERE user_id = ".$right);

		if(!empty($Ltree1) && !empty($left)){
			foreach ($Ltree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				$this->SBdownLineChild($value1['user_id']);
				echo ']},';
			}
		}else{
			echo '{"id":"L'.$id.'","name":"Add New User","parent_id":'.$id.',"position_tree":"L","image":"0"},';
		}

		if(!empty($Mtree1) && !empty($mid)){
			foreach ($Mtree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				$this->SBdownLineChild($value1['user_id']);
				echo ']},';
			}
		}else{
			echo '{"id":"M'.$id.'","name":"Add New User","parent_id":'.$id.',"position_tree":"M","image":"0"},';
		}

		if(!empty($Rtree1) && !empty($right)){
			foreach ($Rtree1 as $key => $value1) {
				echo '{"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$id.',"image":"1","children":[';
				$this->SBdownLineChild($value1['user_id']);
				echo ']},';
			}
		}else{
			echo '{"id":"R'.$id.'","name":"Add User","parent_id":'.$id.',"position_tree":"R","image":"0"},';
		}	
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function getStripeValue(){
		$temp = $this->allSelects('SELECT * from stripe_rate where id = 1');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	
				return $total['value'] ;
			}
		}else{
			return 1;
		}
	}

    function pendingBalance($id=null){
		$temp = $this->allSelects('SELECT sum(amount) as amount from earning_details_by_user_pending where user_id = '.$id);
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	
				return $total['amount'] ;
			}
		}else{
			return 0;
		}
	}

	function getPackageByIdForBonus($where){
		 $query = "SELECT * FROM user_master WHERE user_id = '".$where."'";
		  $result = $this->db->query($query);
		  $data = $result->result_array();

		  if(isset($data) && !empty($data)){
		   foreach ($data as $key => $value) {
		    return $value['package'];
		   }   
		  }else{
		   return 1;
		  }
	}

    function insertCancelledMatrixBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Cancelled Matrix Bonus from '.$userName,
					'amount'=> -$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}	
	}	

	function insertCancelledLeadershipBonusAmount($sId, $userId, $amount){		
			if($amount != 0){
				$userName = $this->getUserNameById($userId);
				$arr2 = array(
						'user_id'=>$sId,
						'ref_id'=>$userId,
						'type_id'=>'1',
						'description'=>'Cancelled Leadership Bonus from '.$userName,
						'amount'=> -$amount,
					);
				$this->db->insert('earning_details_by_user_pending',$arr2);
			}		
	}

    function insertCancelledMentorBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Cancelled Mentor Bonus from '.$userName,
					'amount'=> -$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}

	function insertUpgradeMatrixBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Upgrade Matrix Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}		

	function insertUpgradeLeadershipBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Upgrade Leadership Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}	

    function insertUpgradeMentorBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Upgrade Mentor Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}	
	}

    function insertMentorBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Mentor Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}   

	function insertLeadershipBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Leadership Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}

	function insertMatrixBonusAmount($sId, $userId, $amount){		
		if($amount != 0){
			$userName = $this->getUserNameById($userId);
			$arr2 = array(
					'user_id'=>$sId,
					'ref_id'=>$userId,
					'type_id'=>'1',
					'description'=>'Matrix Bonus from '.$userName,
					'amount'=>$amount,
				);
			$this->db->insert('earning_details_by_user_pending',$arr2);
		}		
	}	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function approvedBalance($id=null){
    	$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -14 day'));
		$temp = $this->allSelects('SELECT sum(amount) as amount from earning_details_by_user where user_id = '.$id.' and e_d_b_u_date < "'.$date.'"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return $total['amount'] ;
			}
		}else{
			return 0;
		}
	}


    function get_residual_amount($id=null){
    	$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -10 day'));
		$temp = $this->allSelects('SELECT sum(amount) as amount from residual_matrix_bonus where user_id = '.$id.' and r_m_b_time > "'.$date.'"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return $total['amount'] ;
			}
		}else{
			return 0;
		}
	}

	function get_matching_amount($id=null){
    	$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -10 day'));
		$temp = $this->allSelects('SELECT sum(amount) as amount from matching_bonus where user_id = '.$id.' and m_b_time > "'.$date.'"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return $total['amount'] ;
			}
		}else{
			return 0;
		}
	}

    function get_first_matching_amount($id=null){
    	$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -5 day'));
		$temp = $this->allSelects('SELECT sum(amount) as amount from residual_matrix_bonus where user_id = '.$id.' and r_m_b_time > "'.$date.'"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return $total['amount'] * 40 / 100;
			}
		}else{
			return 0;
		}
	}

	function get_second_matching_amount($id=null){
    	$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -5 day'));
		$temp = $this->allSelects('SELECT sum(amount) as amount from residual_matrix_bonus where user_id = '.$id.' and r_m_b_time > "'.$date.'"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return $total['amount'] * 20 / 100;
			}
		}else{
			return 0;
		}
	}

    function get_subscription_status($id=null){
		$temp = $this->allSelects('SELECT subscription_status from user_master where user_id = '.$id);
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	

				return ($total['subscription_status'] == 'active' ? true : false);
			}
		}else{
			return false;
		}
	}


    function cancelledMatrixBonus($sponserId, $amount, $level, $count, $userid){
		if($count < $level){
			$this->insertCancelledMatrixBonusAmount($sponserId,  $userid, $amount);
			$sponserId = $this->getAllParent($sponserId);
			$count++;
			if($sponserId > 1){
				$this->cancelledMatrixBonus($sponserId, $amount, $level, $count, $userid);
			}
		}
	}	

	function insertCancelledLeadershipBonus($sponserId, $userid, $amount,  $count){
		if($count < 3){
			$sponserId = $this->getAllSponsor($sponserId);
			$this->insertCancelledLeadershipBonusAmount($sponserId,  $userid, $amount);
			$count++;
			if($sponserId > 1){
				$this->insertCancelledLeadershipBonus($sponserId, $userid, $amount,  $count);
			}
		}
	}

    function upgradeMatrixBonus($sponserId, $amount, $level, $count, $userid){
		if($count < $level){
			$this->insertUpgradeMatrixBonusAmount($sponserId,  $userid, $amount);
			$sponserId = $this->getAllParent($sponserId);
			$count++;
			if($sponserId > 1){
				$this->upgradeMatrixBonus($sponserId, $amount, $level, $count, $userid);
			}
		}
	}


	function insertUpgradeLeadershipBonus($sponserId, $userid, $amount,  $count){
		if($count < 3){
			$sponserId = $this->getAllSponsor($sponserId);
			$this->insertUpgradeLeadershipBonusAmount($sponserId,  $userid, $amount);
			$count++;
			if($sponserId > 1){
				$this->insertUpgradeLeadershipBonus($sponserId, $userid, $amount,  $count);
			}
		}
	}


    function MatchingBonusAmount($amount,  $userid){
     	$packageId = $this->getUserPackageById($userid);
     	$CronjobAmount = $this->limitCronjobAmount($packageId);
		return ($amount > $CronjobAmount ? $CronjobAmount : $amount);	
	}


	function limitCronjobAmount($id=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
					return $value['limit_cronjob_amount'];
			}			
		}else{
			return 0;
		}
	}

    function packageLeadershipAmount2($id=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
					return $value['Binary_point'] * 5 / 100;
			}			
		}else{
			return 0;
		}
	}
 
	function packageLeadershipAmount($id=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
					return $value['leadership_amount'];
			}			
		}else{
			return 0;
		}
	}

    function insertLeadershipBonus($sponserId, $userid, $amount,  $count){
		if($count < 3){
			$sponserId = $this->getAllSponsor($sponserId);
			$this->insertLeadershipBonusAmount($sponserId,  $userid, $amount);
			$count++;
			if($sponserId > 1){
				$this->insertLeadershipBonus($sponserId, $userid, $amount,  $count);
			}
		}
	}	

    function insertMatrixBonus($userid, $package){
    	$sponserId = $this->getAllParent($userid);
    	$amount = $this->matrix_bonus_amount($package);
    	$level = $this->matrix_bonus_level($package);
    	$count = 0;
		if($sponserId > 1){
			$this->matrixBonus($sponserId, $amount, $level, $count, $userid);
		}
	}

	function matrix_bonus_amount($id=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
					return $value['matrix_bonus_amount'];
			}			
		}else{
			return 0;
		}
	}

	function matrix_bonus_level($id=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				return $value['matrix_bonus_level'];
			}			
		}else{
			return 0;
		}
	}

	function matrixBonus($sponserId, $amount, $level, $count, $userid){
		if($count < $level){
			$this->insertMatrixBonusAmount($sponserId,  $userid, $amount);
			$sponserId = $this->getAllParent($sponserId);
			$count++;
			if($sponserId > 1){
				$this->matrixBonus($sponserId, $amount, $level, $count, $userid);
			}
		}
	}	

///////////////////////////////////////////////////////////////////////////////////////////////////////

    function leadIsRedeemed($id){
		$query = "SELECT redeem_status FROM soler_form WHERE s_f_id = ".$id;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if($value['redeem_status'] == 1){
					return true;
				}else{
					return false;
				}
			}			
		}else{
			return true;
		}
	}


    function getuserFullName($where){
		$query = "SELECT * FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['first_name'].' '.$value['middle_name'].' '.$value['last_name'];
			}			
		}else{
			return ' ';
		}
	}


	function getAmountEarned($new_id, $level){
		if($level < 4 ){
			$packageid = $this->getPackageByIdForBonus($new_id);
			return $this->packageLeadershipAmount($packageid);
		}else return 0;
	}



	function sendSponserToSponserMailForNewMember($user_id, $new_id, $level){
		//getAllSponsor getUserNameById getSIMuseremail getSIMuserphone
		$sponserId = $this->getAllSponsor($user_id);
		if($sponserId > 1){	
			$UserName = $this->getUserNameById($new_id);
			$to_email = $this->getSIMuseremail($sponserId);


			$sponsorUserName = $this->getuserFullName($sponserId);

			$AmountEarned = $this->getAmountEarned($new_id, $level);

			

			$config['protocol'] = 'sendmail';
	        $config['mailpath'] = '/usr/sbin/sendmail';
	        $config['charset'] = 'iso-8859-1';
	        $config['wordwrap'] = TRUE;
	        $config['mailtype'] = 'html';
	        $this->email->initialize($config);
	        $this->email->from('info@xonnova.com', 'xonnova Network');
	        $this->email->to($to_email);
	        $this->email->subject('New User Registraion In Your UniLevel');
	         $mail_body	=
        				'<div>
					<table width="100%" cellspacing="0" cellpadding="0" style="background-color:rgb(250,250,250);">
						<tbody>
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" style="border:1px solid rgb(221,221,221);width:580px;background-color:rgb(255,255,255);">
										<tbody>
											<tr>
												<td align="left">
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="80px">
														<tbody>
															<tr>
																<td valign="middle" align="center">
																	<table cellpadding="10">
																		<tbody><tr>
																			<td>
																				
																			</td>
																		</tr>
																	</tbody></table>
																</td>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="8">
																		<tbody><tr>
																				<td style="color:rgb(255,255,255);background-color:rgb(71,71,71);">
																					<b>Xonnova</b></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td style="color:rgb(0,0,0);">
																	<div style="color:#500050;font-weight:bold;font-size:16px;">
																		Congratulations '.$sponsorUserName.'!
																	</div>
																	<br>
																	A person has join under your unilevel on level '.$level.'. And you have earn $'.$AmountEarned.'. Make sure to keep the good work. Send that person a welcome message by clicking <a href="http://my.xonnova.com/sponsor_mail/sendWelcomeNote/'.$sponserId.'/'.$new_id.'">Here</a>.
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="2px" cellpadding="2px" style="border-bottom-width:1px;border-bottom-style:dashed;border-bottom-color:rgb(204,204,204);">
														<tbody>
															<tr>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<br>
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="5">
																		<tbody><tr>
																			<td style="color:rgb(255,255,255);font-weight:bold;background-color:rgb(51,51,51);">
																				Access your backoffice now</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td style="color:rgb(0,0,0);">

																Access your backoffice to see your commissions right away.
																<br>
																<br>
																<a target="_blank" href="https://my.xonnova.com">https://my.xonnova.com</a>&nbsp;<br><br>
																	<br>
																						<br>
																		<span style="color:rgb(255,0,0);">To login to your account you must be using a compatible browser such as Firefox and Google Chrome. Please do not use Internet Explorer (its very obsolete).</span>
																	
																</td>
																
															</tr>
														</tbody>
													</table>

												

													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle"><br></td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="0px" height="5px" style="background-color:rgb(71,71,71);">
														<tbody>
															<tr>
																	<td></td>
																</tr>
															</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="10" height="30px" style="background-color:rgb(228,228,228);">
														<tbody>
															<tr>
																<td width="100%" style="font-size:11px;line-height:14px;">
																	  <br>
																	    
																</td>
																<td width="80">
																	
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>';
	        $this->email->message($mail_body);
	        $this->email->send();
	        $sms_body	='Congratulations! '.$UserName.' has been registered under your team.';
	        //getSIMuserphone
	        $sponsor_phone = $this->getSIMuserphone($sponserId);
	        $find = array("-"," ","[","]","(",")","+");
			$sponsor_phone = str_replace($find,'',$sponsor_phone);
			$sponsor_phone = substr($sponsor_phone, -10);
			$sms_subject = 'New Registraion In Your UniLevel';
	        $this->sendSMSToMobileforSponsorUser($sponsor_phone, $sms_subject , $sms_body);
	        $level = $level + 1;
			$this->sendSponserToSponserMailForNewMember($sponserId, $new_id, $level);
		}
	}

	function sendSponserToSponserMailForNewMember2222($user_id, $new_id, $level){
		//getAllSponsor getUserNameById getSIMuseremail getSIMuserphone
		$sponserId = $this->getAllSponsor($user_id);
		if($sponserId > 1){	
			$UserName = $this->getUserNameById($new_id);
			$to_email = $this->getSIMuseremail($sponserId);

			$config['protocol'] = 'sendmail';
	        $config['mailpath'] = '/usr/sbin/sendmail';
	        $config['charset'] = 'iso-8859-1';
	        $config['wordwrap'] = TRUE;
	        $config['mailtype'] = 'html';
	        $this->email->initialize($config);
	        $this->email->from('info@xonnova.com', 'xonnova Network');
	        $this->email->to($to_email);
	        $this->email->subject('New User Registraion In Your UniLevel');
	        $mail_body	='<div>
        					<p>Congratulations! '.$UserName.' has been registered under your team on your '.$level.' level. 
        					<a href="http://my.xonnova.com/sponsor_mail/sendWelcomeNote/'.$sponserId.'/'.$new_id.'">Please Click Here</a>
        					 to send him/her a congratulations note and welcome him/her to the family </p>
        				</div>';
	        $this->email->message($mail_body);
	        $this->email->send();
	        $sms_body	='Congratulations! '.$UserName.' has been registered under your team.';
	        //getSIMuserphone
	        $sponsor_phone = $this->getSIMuserphone($sponserId);
	        $find = array("-"," ","[","]","(",")","+");
			$sponsor_phone = str_replace($find,'',$sponsor_phone);
			$sponsor_phone = substr($sponsor_phone, -10);
			$sms_subject = 'New Registraion In Your UniLevel';
	        $this->sendSMSToMobileforSponsorUser($sponsor_phone, $sms_subject , $sms_body);
	        $level = $level + 1;
			$this->sendSponserToSponserMailForNewMember($sponserId, $new_id, $level);
		}
	}
	function sendSMSToMobileforSponsorUser($to=null, $subject=null, $message=null){
	  sendMail( $to.'@message.alltel.com', $subject, $message );
	  sendMail( $to.'@txt.att.net', $subject, $message );
	  sendMail( $to.'@myboostmobile.com', $subject, $message );
	  sendMail( $to.'@messaging.sprintpcs.com', $subject, $message );
	  sendMail( $to.'@tmomail.net', $subject, $message );
	  sendMail( $to.'@email.uscc.net', $subject, $message );
	  sendMail( $to.'@vtext.com', $subject, $message );
	  sendMail( $to.'@vmobl.com', $subject, $message );
	}

    function getpercent($userId){
		$package = $this->getUserPackageById($userId);
		$levelExitPrice = $this->getLevelExitPrice($package);
		$level = $this->countUserLevel('earning_info',$userId);
		$level1 = $level;
		if($level1 < 6){
			$total = $this->getUserQV($userId);
			return number_format($total / $levelExitPrice * 100) ;
		}elseif($level1 == 6){
			$total = $this->countUnilevelUserRank($userId, $level);
			return number_format($total / 2 * 100) ;
		}elseif($level1 > 6 && $level1 < 13){
			$total = $this->countUnilevelUserRank($userId, $level);
			return number_format($total / 5 * 100) ;
		}
	}
	function getUserQV($where){
		$allData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id ='.$where);
		//$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 WHERE a.user_id ='.$where);
		$dateTime = date('Y-m-d H:i:s');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
			$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
			$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;
			$x = $discountPercentOfPackage/2;
			$restBV = $levelExitPrice*$x/100;
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
							$Qv2 += $totalQV1;
						}
					}
				}
			}
		}

		if(!empty($Qv1)){
			$total2 = $Qv2 + $Qv1 ;
			if(!empty($total2) && $total2 > 0){
				return  $total2;
			}else{
				return 0;
			}
		}else{			
			if(!empty($Qv2)){
				return $Qv2;
			}else{
				return  0;
			}
		}
	}


    function rankNameForUser($id){
		$query = "SELECT level_name FROM earning_info as a LEFT JOIN level_configuration as b on a.level = b.l_conf_id WHERE a.user_id = ".$id;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['level_name'];
			}			
		}else{
			return 'NA';
		}
	}


	function getDownlineList($id, $level){
	  $getOne = $this->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$id);
	  foreach ($getOne as $key => $value) {
	   $value['level_name'] = $this->rankNameForUser($value['user_id']);
	   $value['contact_no'] = $this->getSIMuserphone($value['user_id']);
	   $value['user_email'] = $this->getSIMuseremail($value['user_id']);
	   //$value['percent'] = $this->getpercent($value['user_id']);

	   	$user_level = $this->getLelevel($value['user_id']) + 1;
	   	if($level < 6){
	   		$value['percent'] = 'NA';
	   	}elseif($level == $user_level){
	   		$value['percent'] = $this->getpercent($value['user_id']).' %';
	   	}else{
	   		$value['percent'] = 'NA';
	   	}


	   $arr[] = $value;
	   $getTwo = $this->allSelects('SELECT user_id From user_master WHERE sponsor_id = '.$value['user_id']);
	   if(isset($getTwo) && !empty($getTwo)){
	     $list = $this->getDownlineList($value['user_id'], $level);
	     foreach ($list as $keyTwo => $valueTwo) {
	     	$valueTwo['level_name'] = $this->rankNameForUser($valueTwo['user_id']);
	     	$valueTwo['contact_no'] = $this->getSIMuserphone($valueTwo['user_id']);
	   		$valueTwo['user_email'] = $this->getSIMuseremail($valueTwo['user_id']);
	     	//$valueTwo['percent'] = $this->getpercent($valueTwo['user_id']);
	     	$user_level2 = $this->getLelevel($valueTwo['user_id']) + 1;
		   	if($level < 6){
		   		$valueTwo['percent'] = 'NA';
		   	}elseif($level == $user_level2){
		   		$valueTwo['percent'] = $this->getpercent($valueTwo['user_id']).' %';
		   	}else{
		   		$valueTwo['percent'] = 'NA';
		   	}

	      $arr[] = $valueTwo;   
	     }
	    }
	  }
	  return $arr;  
	}



    function getDownlineList2222222($id){
	  $getOne = $this->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$id);
	  foreach ($getOne as $key => $value) {
	   $value['level_name'] = $this->rankNameForUser($value['user_id']);
	   $value['percent'] = $this->getpercent($value['user_id']);
	   $arr[] = $value;
	   $getTwo = $this->allSelects('SELECT user_id From user_master WHERE sponsor_id = '.$value['user_id']);
	   if(isset($getTwo) && !empty($getTwo)){
	     $list = $this->getDownlineList($value['user_id']);
	     foreach ($list as $keyTwo => $valueTwo) {
	     	$valueTwo['level_name'] = $this->rankNameForUser($valueTwo['user_id']);
	     	$valueTwo['percent'] = $this->getpercent($valueTwo['user_id']);
	      $arr[] = $valueTwo;   
	     }
	    }
	  }
	  return $arr;  
	}

    function userMenu($userId){
    	$data = "var USER_MENU =";

    	$country = $this->sponsorCountry($userId);
		
		$contentData = $this->allSelects('SELECT DISTINCT menu_id FROM user_menu_mapping ');
		if(!empty($contentData)){
			$data .= "[{";
			$i = 0;
			$j = 0;
			foreach ($contentData as $key => $value) {
				$count = count($contentData);
				$contentData2 = $this->allSelects('SELECT * FROM user_menu_table WHERE menu_id ='.$value['menu_id']);
				if(!empty($contentData2)){
					foreach ($contentData2 as $key2 => $value2) {
						if($country == 'MEX'){
							$data .="label:'".$value2['mex_menu_label']."',";
						}else{
							$data .="label:'".$value2['menu_label']."',";
						}
						
						$data .="iconClasses:'".$value2['menu_icon_class']."',";
						$data .="html:'<span></span>',";
						
						$contentData5 = $this->allSelects('SELECT DISTINCT sub_menu_id FROM user_menu_mapping WHERE  menu_id ='.$value['menu_id'].' AND sub_menu_id > 0 ORDER BY map_id');
						if(!empty($contentData5)){
							$data .= "children: [{";
							$count2 = count($contentData5);
							foreach ($contentData5 as $key5 => $value5) {
								$contentData3 = $this->allSelects('SELECT * FROM user_sub_menu_table WHERE sub_menu_id='.$value5['sub_menu_id']);
									foreach ($contentData3 as $key3 => $value3) {
										if($country == 'MEX'){
											$data .="label:'".$value3['mex_sub_menu_label']."',";
										}else{
											$data .="label:'".$value3['sub_menu_label']."',";
										}
										
										$data .="url:'".$value3['sub_menu_url']."'";
									}
								$j++;
								if($j != $count2){
									$data .="},{";
								}
							}

							$j =0;
							$data .= "}]";
						}else{
							$data .="url:'".$value2['menu_url']."'";
						}


					}
				}
				$i++;
				if($i != $count){
					$data .="},{";
				}
			}
			//$data .= "}];";

		$data .= "},{
	        label: 'Sign Out',
	        iconClasses: 'glyphicon glyphicon-cog',
	        html: '<span></span>',
	        url: BASE_URL+'signing/logout'
	      }];";

			echo $data;
		}else{
			$data .= "'ok';";
			echo $data;
		}
	}

    function operatorRate($column){
		$query = "SELECT ".$column." FROM mxtopup_rate WHERE id = 1";
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value[$column];
			}			
		}else{
			return 0.00;
		}
	}
	

     function getCountryByUserNameInUserMaster($user){
		$query = "SELECT country FROM user_master WHERE user_name = '".$user."'";
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['country'];
			}			
		}else{
			return "US";
		}
	}

	
	function getUSAmountFromMex($where){
		$query = "SELECT us_rate FROM conversion_rate ";
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return  $where / $value['us_rate']  ;		
			}			
		}else{
			return 0;
		}
	}

    function getPackageAmount($user){
		$query = "SELECT package,country FROM user_master WHERE user_name = '".$user."'";
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return  $this->planPrice($value['package'],$value['country']);		
			}			
		}else{
			return 0;
		}
	}


    function getDepartmentMappingId($userId){
		$query = "SELECT department_id FROM menu_add_employee WHERE user_id = ".$userId;
		$result = $this->db->query($query);
		$data = $result->result_array();

		
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['department_id'];
			}			
		}else{
			return 0;
		}
	}


    function empMenu($userId){
    	echo 'var EMP_MENU =';

    	$departmentId = $this->mdl_common->getDepartmentMappingId($userId);
		
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT menu_id FROM menu_department_mapping WHERE department_id='.$departmentId);
		if(!empty($contentData)){
			$data = "[{";
			$i = 0;
			$j = 0;
			foreach ($contentData as $key => $value) {
				$count = count($contentData);
				$contentData2 = $this->mdl_common->allSelects('SELECT * FROM menu_table WHERE menu_id ='.$value['menu_id']);
				if(!empty($contentData2)){
					foreach ($contentData2 as $key2 => $value2) {
						$data .="label:'".$value2['menu_label']."',";
						$data .="iconClasses:'".$value2['menu_icon_class']."',";
						$data .="html:'".$value2['menu_html']."',";
						
						$contentData5 = $this->mdl_common->allSelects('SELECT DISTINCT sub_menu_id FROM menu_department_mapping WHERE department_id ='.$departmentId.' AND menu_id ='.$value['menu_id'].' AND sub_menu_id > 0');
						if(!empty($contentData5)){
							$data .= "children: [{";
							$count2 = count($contentData5);
							foreach ($contentData5 as $key5 => $value5) {
								$contentData3 = $this->mdl_common->allSelects('SELECT * FROM sub_menu_table WHERE sub_menu_id='.$value5['sub_menu_id']);
									foreach ($contentData3 as $key3 => $value3) {
										$data .="label:'".$value3['sub_menu_label']."',";
										$data .="url:'".$value3['sub_menu_url']."'";
									}
								$j++;
								if($j != $count2){
									$data .="},{";
								}
							}

							$j =0;
							$data .= "}]";
						}else{
							$data .="url:'".$value2['menu_url']."'";
						}


					}
				}
				$i++;
				if($i != $count){
					$data .="},{";
				}
			}
			$data .= "}];";
			echo $data;
		}else{
			echo "'ok';";
		}
	}


    function deleteSimFromPrePaidVoucher($where){
		$query = "SELECT sim_no FROM add_sim_to_shipp WHERE a_s_t_s_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				
				$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher WHERE  sim_no = '.$value['sim_no']);
				if(isset($list) && !empty($list)){
					foreach ($list as $key2 => $value2) {
						$updatearr = array(							
												'sim_no'=>'',
												'update_date'=>date("Y-m-d H:i:s"),	
												'status'=>'Pending',	
											);						
						$this->db->update('prepaid_voucher',$updatearr,array('prepaid_id'=>$value2['prepaid_id']));
					}
				}
			}			
		}
	}


    function noOfVoucher($where){
		$query = "SELECT n_of_voucher FROM package_info WHERE package_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['n_of_voucher'];
			}			
		}else{
			return 0;
		}
	}
    function insertVoucherForUser($userId=null, $noOfVoucher=null, $shippingno=null){
    	if($noOfVoucher < 1 || $userId < 1){
    		return ;
    	}
    	$UserName = $this->getUserNameById($userId);
		$list = $this->allSelects('SELECT * From activate_platform_voucher WHERE user_id = 0 LIMIT '.$noOfVoucher);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$updatearr = array(							
										'user_id'=>$userId,
										'user_name'=>$UserName,
										'shipping_no'=>$shippingno,
										'sim_date'=>date("Y-m-d H:i:s"),	
									);						
				$this->db->update('activate_platform_voucher',$updatearr,array('sim_id'=>$value['sim_id']));
			}
		}
    }


    function deleteSimFromVoucher($where){
		$query = "SELECT sim_no FROM add_voucher_to_shipp WHERE a_s_t_s_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				$this->db->delete('activate_platform_voucher',array('sim_no'=>$value['sim_no']));
			}			
		}
	}

	function deleteSimFromSim($where){
		$query = "SELECT sim_no FROM add_sim_to_shipp WHERE a_s_t_s_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				$this->db->delete('activate_platform_sim',array('sim_no'=>$value['sim_no']));
			}			
		}
	}


    function getShippingStatusFromShipping($where){
		$query = "SELECT * FROM shipping_management_table WHERE id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['archive_member_status'];
			}			
		}else{
			return false;
		}
	}


    function getShippingStatusFromProduct($where){
		$query = "SELECT * FROM product_purchase_info WHERE purchase_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['delivery_status'];
			}			
		}else{
			return false;
		}
	}


    function downLine3($id){
		$getOne = $this->mdl_common->allSelects('SELECT user_name, user_id From user_master WHERE sponsor_id = '.$id);
		foreach ($getOne as $key => $value) {
			echo '{"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
			
			$getTwo = $this->mdl_common->allSelects('SELECT user_id From user_master WHERE sponsor_id = '.$value['user_id']);
			if(isset($getTwo) && !empty($getTwo)){
				$this->downLine3($value['user_id']);
			 }
			echo ']';
			echo'},';
		}
		
	}


    function getUserEmailInUserMaster($where){
		$query = "SELECT * FROM user_master WHERE user_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_email'];
			}			
		}else{
			return false;
		}
	}
	
	function getProductPrice($pid,$country){
		$country = strtoupper($country);
		if(!empty($pid) && !empty($country)){
			if($country == 'US'){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['us_product_price'];
					}			
				}else{
					return 0;
				}
			}elseif($country == 'MEX'){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['mexico_product_price'];
					}			
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	function getLevelSalePrice($level,$pid){
		if(!empty($level) || !empty($pid)){
			if($level == 1){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['member_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 2){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['representative_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 3){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['partner_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 4){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['brand_partner_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 5){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['team_partner_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 6){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['team_lead_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 7){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['director_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 8){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['regional_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 9){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['national_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 10){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['international_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 11){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['p_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 12){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['ambassador_price'];
					}			
				}else{
					return 0;
				}
			}elseif($level == 13){
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();

				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						return $value['crown_ambassador_price'];
					}			
				}else{
					return 0;
				}
			}else{
				$query = "SELECT * FROM product_info WHERE p_id = ".$pid;
				$result = $this->db->query($query);
				$data = $result->result_array();
				$country = strtoupper($this->session->userdata('country'));
				if(isset($data) && !empty($data)){
					foreach ($data as $key => $value) {
						if(!empty($country) && $country == 'MEX'){
							return $value['mexico_product_price'];							
						}else{
							return $value['us_product_price'];
						}
					}			
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}		
	}
	
	
	
	function getLelevel($where){
		$query = "SELECT * FROM earning_info WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['level'];
			}			
		}else{
			return 0;
		}
	}
	
	
	 function getSaleQV($where){
		$query = "SELECT * FROM product_info WHERE p_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['product_qv_point'];
			}			
		}else{
			return 0;
		}
	}
	
	
	function getSaleBinary($where){
		$query = "SELECT * FROM product_info WHERE p_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['product_binary_point'];
			}			
		}else{
			return 0;
		}
	}
	
	
	
	function getSIMusernameStore($where){
		$query = "SELECT * FROM reseller_store WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_name'];
			}			
		}else{
			return false;
		}
	}

	function getSIMuserphoneStore($where){
		$query = "SELECT * FROM reseller_store WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['contact_no'];
			}			
		}else{
			return false;
		}
	}
	
	function getSIMuseremailStore($where){
		$query = "SELECT * FROM reseller_store WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_email'];
			}			
		}else{
			return false;
		}
	}

	
	
	function storePassword($where){
		$query = "SELECT password FROM reseller_store WHERE user_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();
			
			foreach ($data as $key => $value) {
				return $value['password'];
			}			
	}
	
	function resellerID($where){
		$query = "SELECT user_id FROM reseller_store WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_id'];
			}			
		}else{
			return 111000;
		}
	}	
	
	 function shippingMailBody($user_name,$package,$shipdate,$trackingId){
		$body = '<div>Dear  '.$user_name.'.</div><br/>
				<div>Your Order has been shipped. The details are as follows - </div><br/>
				<div>Package/Product - '.$package.'</div><br/>
				<div>Ship date: '.$shipdate.'</div><br/>
				<div>Tracking id: '.$trackingId.'</div><br/>
				<div>In case you have any queries, please get in touch with us at shipping@xonnova.com</div><br/>
				<div>Thank you.</div><br/>
				<div>Team xonnova</div><br/>
				';
		return $body;
	}
	
	function getProductName($where){
		$query = "SELECT product_name FROM product_info WHERE p_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['product_name'];
			}			
		}else{
			return 0;
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
		        	//echo $value['user_id'].' => '.$value['sponser_id'].' => '.$value['level'].'<br>'; 
		    		$insertArr = array(
		    				'user_id'=>$userID,
		    				'direct_sponsor'=>$directSponsor,
		    				'unilevel_member'=>$value['user_id'],
		    				'unilevel_member_sponsor'=>$value['sponser_id'],
		    				'member_rank'=>$value['level'],
		    				'count_member_status'=>'1',
		    				'unilevel_rant_created'=>date('Y-m-d H:i:s'),
		    			);
		    		$this->db->insert('count_unilevel_leg_rank',$insertArr);
		    	}
		    }	    	    	
	    }
	}
	
	function getTransactionId($where){
		$query = "SELECT * FROM `payment_info` WHERE transaction_id !='' AND user_id = ".$where." AND sub_status = 'active'";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['transaction_id'];
			}		
		}else{
			return 0;
		}
	}

    function getUserLevel($where){
		$query = "SELECT * FROM earning_info WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['level'];
			}			
		}else{
			return false;
		}
	}
	
	 function selectChildUser($where){
		$query = "SELECT lft_user, rght_user FROM user_master WHERE user_type='user' AND user_id=".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data) && !empty($where)){
			foreach ($data as $key => $value) {
				if(!empty($value['lft_user'])){
					return $value['lft_user'];					
				}elseif(!empty($value['rght_user'])){
					return $value['rght_user'];	
				}else{
					return false;
				}
			}			
		}else{
			return false;
		}
	}
	
	function getNewTeamBV1($where){
		$query = "SELECT SUM(referral_binary) as totalBV FROM referrals_binary WHERE parent_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(!empty($value['totalBV'])){
					return $value['totalBV'];					
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	
	function getNewTeamBV($where){
		$query = "SELECT * FROM earning_info WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['referral_binary_point'];
			}			
		}else{
			return 0;
		}
	}
	function getShipPackageID($where){
		$query = "SELECT * FROM shipping_management_table WHERE id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['shipping_package_id'];
			}			
		}else{
			return false;
		}
	}
	function userJoinDate($where){
		$query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['created_at'];
			}			
		}else{
			return false;
		}
	}
	function insertShippingStatus($id=null, $condition=null){
		$contentData = $this->allSelects('SELECT * FROM user_master WHERE user_id='.$id);
	    if(!empty($contentData) && !empty($id) && !empty($condition)){
	      if($condition == 'Registration'){
	       $type = 'Registration';
	      }else{
	       $type = 'Upgrade';
	      }
	      foreach ($contentData as  $value) {
	       $insertShippingStatus = array(
		     'user_id'=>$value['user_id'],
	         'user_name'=>$value['user_name'],
	         'ship_address'=>$value['address1'],
			 'contact_no'=>$value['contact_no'],
	         'country'=>$value['country'],
			 'state'=>$value['state'],
	         'city'=>$value['city'],
	         'zip'=>$value['zip'],
	         'type'=>$type,
	         'shipping_package_id'=>$value['package'],
	         
	       );
	       $this->db->insert('shipping_management_table',$insertShippingStatus);
	       $shipping_id =  $this->db->insert_id();
		   $noOfVoucher = $this->noOfVoucher($value['package']);
		   $this->insertVoucherForUser($id, $noOfVoucher, $shipping_id);
	      }    
		}
    }

    function insertShippingStatusforUpgread($id=null, $package=null){
		$contentData = $this->allSelects('SELECT * FROM user_master WHERE user_id='.$id);
	    if(!empty($contentData) && !empty($id)){	   
			foreach ($contentData as  $value) {
			   $insertShippingStatus = array(
				 'user_id'=>$value['user_id'],
				 'user_name'=>$value['user_name'],
				 'ship_address'=>$value['address1'],
				 'country'=>$value['country'],
				 'contact_no'=>$value['contact_no'],
				 'state'=>$value['state'],
				 'city'=>$value['city'],
				 'zip'=>$value['zip'],
				 'type'=>'Upgrade',
				 'shipping_package_id'=>$package,	         
			   );
			   $this->db->insert('shipping_management_table',$insertShippingStatus);
			   $shipping_id =  $this->db->insert_id();
		       $noOfVoucher = $this->noOfVoucher($package) - $this->noOfVoucher($value['package']);
			   $this->insertVoucherForUser($id, $noOfVoucher, $shipping_id);
			}    
	 	 }
    }	
	
	function isUserExistInClient($where){
		$query = "SELECT id FROM store_user_info WHERE u_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			return false;			
		}else{
			return true;
		}
	}
	
	function getUserIdByArbId($where){
		$query = "SELECT user_id FROM payment_info WHERE transaction_arb_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
					return $value['user_id'];	
			}			
		}else{
			return false;
		}
	}
	
	function mailContentForNewReg($where){
		$query = 'SELECT a.*,b.* from user_master as a RIGHT JOIN package_info as b on b.package_id=a.package WHERE user_id='.$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				$mail_content = '
						<div style="width:100%;" align="center"><span><img src="http://luxoprinting.com/xonnova/assets/img/logo.png" alt="Image Not Found"/></span></div><br/>
						<h4>New User Signup Details <h4> <br/>
						<div>User ID  : '.$value['user_id'].'.</div><br/>
						<div>User Name : '.$value['user_name'].'.</div><br/>
						<div>Sponsor Name : '.$this->getUserNameById($value['sponsor_id']).'.</div><br/>
						<div>Full Name : '.$value['first_name'].' '.$value['middle_name'].' '.$value['last_name'].'.</div><br/>
						<div>Last Name : '.$value['last_name'].'.</div><br/>
						<div>Address : '.$value['address1'].$value['address2'].'.</div><br/>
						<div>City :  '.$value['city'].'.</div><br/>
						<div>State :  '.$value['state'].'.</div><br/>
						<div>country :  '.$value['country'].'.</div><br/>
						<div>Zip :  '.$value['zip'].'.</div><br/>
						<div>E-mail ID : '.$value['user_email'].'.</div><br/>
						<div>Mobile :  '.$value['contact_no'].'.</div><br/>
						<div>Package :  '.$value['package_name'].' - $'.$value['entry_ammout'].'.</div><br/>
						<div style="width:100%;" align="center">
							<span style="margin:auto; float:none;"><strong>xonnova, Inc.</strong></span><br/>
							<span style="margin:auto; float:none;"><strong>'.$value['created_at'].'</strong></span><br/>
							<span style="margin:auto; float:none;"><strong>Place : California</strong></span><br/>
						</div><br/>';
				return $mail_content;
			}		
		}else{
			return null;
		}
	}
	
	function getSIMusername($where){
		$query = "SELECT * FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_name'];
			}			
		}else{
			return false;
		}
	}
	function getSIMuserphone($where){
		$query = "SELECT contact_no FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['contact_no'];
			}			
		}else{
			return 'NA';
		}
	}
	function getSIMuseremail($where){
		$query = "SELECT user_email FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_email'];
			}			
		}else{
			return 'NA';
		}
	}
	
	function isUserOrderSim($id){
		$query = "SELECT user_id FROM activate_platform WHERE user_id = ".$id;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['user_id'];
			}		
		}else{
			return null;
		}
	}
	
	#====================================================================================================
	#Des : for exist user
 	#====================================================================================================
	 function isUserExist($where){
		$query = "SELECT user_id FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			return false;			
		}else{
			return true;
		}
	}
	function isEmailExist($where){
		$query = "SELECT user_id FROM user_master WHERE user_email = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			return false;			
		}else{
			return true;
		}
	}

	function isVoucherCodeExist2222($where){
		return true;			
	}
	
	function checkVoucherCode2222($where){		  
		return $where;
	}



	function isVoucherCodeExist($where){
		  
		  $this->db->where('voucher_code',$where);
		  $this->db->where('voucher_status','active');
		  $this->db->where('used','un_used');
		  $data = $this->db->get('voucher_info')->result_array();
		  	if(isset($data) && !empty($data)){
				return true;			
			}else{
				return false;
			}
	}
	
	function checkVoucherCode($where){		  
		  $this->db->where('voucher_code',$where);
		  $this->db->where('voucher_status','active');
		  $this->db->where('used','un_used');
		  $data = $this->db->get('voucher_info')->result_array();
		  	if(isset($data) && !empty($data)){
				foreach ($data as $key => $value){
					return $value['voucher_code'];
				}		
			}else{
				return '0';
			}
	}
	#====================================================================================================
	#Des : Insert record in perticular table base on parameters
 	#====================================================================================================
	function AddRecord($table_name='',$insertArr=array()){
		$this->db->insert($table_name,$insertArr);	  
	  	return $this->db->insert_id();
	}	
	#====================================================================================================
	#Des : Update record in perticular table base on parameters
 	#====================================================================================================
	function UpdateRecord($common_key_name='',$common_key_val='',$table_name='',$updateArr=array()){
		$this->db->where($common_key_name,$common_key_val);
		$this->db->update($table_name,$updateArr);	  
		return true;
	}	

	function Update_user_package($updateArr,$table_name,$id){
		$this->db->where('user_id',$id);
		$this->db->update($table_name,$updateArr);	  
		return true;
	}	

	function updateData($updateArr,$table_name,$condition){
		$this->db->where($condition);
		$this->db->update($table_name,$updateArr);	  
		return true;
	}
	#====================================================================================================
	#Des : To Get result in perticular table base on parameters
 	#====================================================================================================
	function GetRecords($common_key_name='',$common_key_val='',$table_name='',$is_sigle_rec=false){
		$this->db->where($common_key_name,$common_key_val);
		$rs	=	$this->db->get($table_name);	  
		if($rs->num_rows()>0){
			if($is_sigle_rec)
				return $rs->row_array();
			else
				return $rs->result_array();
		}
		else
			return false;
	}
	#=====================================================================================					SELECT all from table
	#=====================================================================================
	function GetAll($table_name){
		$this->db->select('*');
		$rs	=	$this->db->get($table_name);	  
		if($rs->num_rows()>0){
			return $rs->result_array();
		}
		else{
			return false;
		}
	}
	#=====================================================================================			Des : To Insert record table base on parameters
 	#=====================================================================================
	public function allInserts($tablename,$data){
    	$this->db->insert($tablename,$data);
    }
	#====================================================================================================
				#Des : To Insert record table base on parameters return last inserted id
 	#====================================================================================================
	public function allInsertsRetID($tablename,$data){
		$this->db->insert($tablename,$data);  
		return $this->db->insert_id();
	}
	#====================================================================================================
	#Des : To execute given query
 	#====================================================================================================
	public function allQueries($querystring){
		$this->db->query($querystring);
	}
	#====================================================================================================
			#Des : To execute given query and return result in form of array
 	#====================================================================================================
	public function allSelects($sqlquery){
		$query = $this->db->query($sqlquery);
		return $query->result_array();
	}
	#====================================================================================================
		#Des : To execute given query and return result in form of single record
 	#====================================================================================================
	public function allSelectsSingleRec($sqlquery){
		$query = $this->db->query($sqlquery);		
		return $query->row_array();
	}
	#=====================================================================================	Delete data from table
	#=====================================================================================
	function delete($id,$table){
		$this->db->where('id',$id);
		return $this->db->delete($table);
	}
	#=====================================================================================Last week days
	#=====================================================================================
    function givedate($weekday) {
		$now = time();
		$last = strtotime("$weekday this week");
		$next = strtotime("last $weekday");
	    if($now < $last) {
	        $date = date("Y-m-d",$next);
	    }
	    else {
	        $date = date("Y-m-d",$last);
	    }
	    return $date;
	}
	
	function lastWeekDate(){
		$Current = Date('N');

		$DaysToSunday = 7 - $Current; 

		$DaysFromMonday = $Current - 1; 

		$Sunday = Date('d/m/y', StrToTime("+ {$DaysToSunday} Days")) . "<br>"; 

		$date = Date('Y/m/d', StrToTime("- {$DaysFromMonday} Days"));

		$mod_date = strtotime($date."- 7 days");

		return $last_week_monday=date("Y/m/d",$mod_date);
	}
	#=====================================================================================Create Copy Dir to another folder
	#=====================================================================================
	function xcopy($source, $dest, $permissions = 0755){
	    // Check for symlinks
	    if (is_link($source)) {
	        return symlink(readlink($source), $dest);
	    }

	    // Simple copy for a file
	    if (is_file($source)) {
	        return copy($source, $dest);
	    }

	    // Make destination directory
	    if (!is_dir($dest)) {
	        mkdir($dest, $permissions);
	    }

	    // Loop through the folder
	    $dir = dir($source);
	    while (false !== $entry = $dir->read()) {
	        // Skip pointers
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }

	        // Deep copy directories
	        $this->xcopy("$source/$entry", "$dest/$entry");
	    }

	    // Clean up
	    $dir->close();
	    return true;
	}
	
	function GetData($condition,$table_name){
		$this->db->where($condition);			
		$this->db->order_by("user_id", "desc");	
		$rs	=	$this->db->get($table_name);	  
		if($rs->num_rows()>0){
			return $rs->result_array();
		}
		else{
			return false;
		}
	}
	#=====================================================================================Two table join pagination
	#=====================================================================================
	function getTwoTablePagination($condition = 'all', $start =0, $limit =20,$table1, $table2,$where){

		if($condition == 'all')
		{			
			$this->db->select("$table1.*, $table2.*");
			$this->db->from($table1);
			$this->db->join($table2,$table1.'.'.$where.'= '.$table2.'.'.$where,'right');
			$this->db->order_by($table1.'.created_at','DESC');
			$this->db->limit($limit,$start);
			$query = $this->db->get();
			return $query->result_array();
		}
		elseif(is_array($condition)) 
		{
			$whereauto = implode($this->db->where($condition)->ar_where,'');
			$mysqlquery = "SELECT $table1. * , $table2.* FROM $table1 RIGHT JOIN $table2 ON".$table2.".".$where." = ".$table1.".".$where." WHERE ";
			$finalquery = $mysqlquery . $whereauto . " limit ".$start." , ".$limit."";
			$result = $this->db->query($finalquery);
			$arr_result = $result->result_array();
			$this->db->where($condition)->ar_where = array();
			return $arr_result;
		}
	}
	#=====================================================================================Single table pagination
	#=====================================================================================
	function getOneTablePagination($condition = 'all', $start =0, $limit =20,$table1,$where){
		if($condition == 'all')
		{			
			$this->db->select("*");
			$this->db->from($table1);
			$this->db->order_by('created_at','DESC');
			$this->db->limit($limit,$start);
			$query = $this->db->get();
			return $query->result_array();
		}
		elseif(is_array($condition)) 
		{
			$whereauto = implode($this->db->where($condition)->ar_where,'');
			$mysqlquery = "SELECT * FROM $table1  WHERE ";
			$finalquery = $mysqlquery . $whereauto . " limit ".$start." , ".$limit."";
			$result = $this->db->query($finalquery);
			$arr_result = $result->result_array();
			$this->db->where($condition)->ar_where = array();
			return $arr_result;
		}
	}
	#=====================================================================================Get left Position from user id.
	#=====================================================================================
	function leftPosition($where){
		$query = "SELECT lft_user FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['lft_user'];
			}			
		}else{
			return 0;
		}
	}
	
	function getPackageId($where){
		 $query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
		  $result = $this->db->query($query);
		  $data = $result->result_array();

		  if(isset($data) && !empty($data)){
		   foreach ($data as $key => $value) {
		    return $value['package'];
		   }   
		  }else{
		   return false;
		  }
	}
	
	function getPackageById($where){
		 $query = "SELECT * FROM user_master WHERE user_id = '".$where."'";
		  $result = $this->db->query($query);
		  $data = $result->result_array();

		  if(isset($data) && !empty($data)){
		   foreach ($data as $key => $value) {
		    return $value['package'];
		   }   
		  }else{
		   return false;
		  }
	}
	
	function getUserPackageById($where){
		 $query = "SELECT * FROM user_master WHERE user_id = ".$where;
		  $result = $this->db->query($query);
		  $data = $result->result_array();

		  if(isset($data) && !empty($data)){
		   foreach ($data as $key => $value) {
		    return $value['package'];
		   }   
		  }else{
		   return false;
		  }
	}
	#============================================================================
	function getUserId($where){
	  $query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
	  $result = $this->db->query($query);
	  $data = $result->result_array();

	  if(isset($data) && !empty($data)){
	   foreach ($data as $key => $value) {
	    return $value['user_id'];
	   }   
	  }else{
	   return false;
	  }
	}
	#=====================================================================================Get Right Position from user id.
	#=====================================================================================
	function rghtPosition($where){
		$query = "SELECT rght_user FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['rght_user'];
			}			
		}else{
			return 0;
		}
	}
	#=====================================================================================Get Right Position from user id.
	#=====================================================================================
	function getUserEmail($where){
		$query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_email'];
			}			
		}else{
			return false;
		}
	}

	function getTotalBinary($where){
		$query = "SELECT * FROM earning_info WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['referral_binary_point'];
			}			
		}else{
			return false;
		}
	}

	function getDiscountPercentOfPackage($where){
		$query = "SELECT * FROM package_info WHERE package_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['descount_percent'];
			}			
		}else{
			return false;
		}
	}
	
	function getCodedBonus($query){
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['level_bonus']) && !empty($value['level_bonus'])){
					return $value['level_bonus'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	
	function getLevelExitPrice($where){
		$query = "SELECT * FROM package_info WHERE package_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['exit_price'];
			}			
		}else{
			return false;
		}
	}
	
	function countTotalChildren($startId) {
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE parent_id = ?", array( $startId ));
	    $count = $directDescendents->num_rows($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count += $this->countTotalChildren($value['user_id']);
	    }
	    return $count;
	}
	
	function getTotalMemberInTeam($startId) {
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE sponsor_id = ?", array( $startId ));
	    $count = $directDescendents->num_rows($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count += $this->getTotalMemberInTeam($value['user_id']);
	    }
	    return $count;
	}
	
	function getSponsorUser($startId){
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE sponsor_id =".$startId);
		$user = "";
	    $row = $directDescendents->result_array($directDescendents);
		if(!empty($row)){
			foreach ($row as $key => $value) {
				$user .= $value['user_id'].',';
			}
			return $user;			
		}else{
			return '';
		}
	}
	
	function getCurrentModule($where){
		$query = "SELECT * FROM earning_info WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['module']) && !empty($value['module'])){
					return $value['module'];
				}else{
					return 0;
				}
			}			
		}
	}
	#=====================================================================================Get sponsor Id from user name.
	#=====================================================================================
	function sponserID($where){
		$query = "SELECT user_id FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_id'];
			}			
		}else{
			return 1;
		}
	}
	
	function getUserSponserIDByName($where){
		$query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['sponsor_id'];
			}			
		}else{
			return 1;
		}
	}
	
	function sponsorCountry($sponsor){
		$this->db->where(array('user_id'=>$sponsor,'user_status'=>'active'));
		$result = $this->db->get('user_master');
		$contentData =$result->result_array();
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {				
				return $value['country'];
			}			
		}else{
			return "US";
		}
	}	
	#=====================================================================================Get user password  from user id.
	#=====================================================================================
	function userPassword($where){
		$query = "SELECT user_password FROM user_master WHERE user_id = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();
			
			foreach ($data as $key => $value) {
				return $value['user_password'];
			}			
	}
	#=====================================================================================Get user Left Child  from user id.
	#=====================================================================================
	function leftChild($where){
		$query = "SELECT * FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['lft_user'];
		}			
	}
	#=====================================================================================Get user Right Child  from user id.
	#=====================================================================================
	function rightChild($where){
		$query = "SELECT * FROM user_master WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
			
		foreach ($data as $key => $value) {
			return $value['rght_user'];
		}			
	}
	#=====================================================================================Get cashout document
	#=====================================================================================
	function cashoutDoc($id){
		$query = "SELECT id_proof,w9form FROM messages WHERE user_id = ".$id." ORDER BY   send_at ASC  LIMIT 1  ";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if((isset($value['id_proof']) && !empty($value['id_proof'])) && (isset($value['w9form']) && !empty($value['w9form']))){
					return true;
				}else{
					return false;
				}
			}			
		}

	}
	#=====================================================================================Get Id proof
	#=====================================================================================
	function totalSaleBinary($query){
		//$query = "SELECT * FROM messages WHERE user_id = ".$id." ORDER BY   send_at ASC  LIMIT 1  ";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['sale_binary_point']) && !empty($value['sale_binary_point'])){
					return $value['sale_binary_point'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	#=====================================================================================Get Id proof
	#=====================================================================================
	function totalReferralBinary($query){
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['referral_binary']) && !empty($value['referral_binary'])){
					return $value['referral_binary'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	function totalQv($query){
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['qv_point']) && !empty($value['qv_point'])){
					return $value['qv_point'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	function totalQVBinary($query){
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['qv_point']) && !empty($value['qv_point'])){
					return $value['qv_point'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	
	#=====================================================================================Get Id proof
	#=====================================================================================
	function totalRightBinaryDeduction($query){
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['binary_point']) && !empty($value['binary_point'])){
					return $value['binary_point'];
				}else{
					return 0;
				}
			}			
		}else{
			return 0;
		}
	}
	#=====================================================================================Get Id proof
	#=====================================================================================
	function userIdProof($id){
		$query = "SELECT id_proof FROM messages WHERE user_id = ".$id." ORDER BY   send_at ASC  LIMIT 1  ";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['id_proof']) && !empty($value['id_proof'])){
					return $value['id_proof'];
				}else{
					return false;
				}
			}			
		}
	}
	#=====================================================================================Get w9 form info
	#=====================================================================================
	function userw9form($id){
		$query = "SELECT w9form FROM messages WHERE user_id = ".$id." ORDER BY   send_at ASC  LIMIT 1  ";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['w9form']) && !empty($value['w9form'])){
					return $value['w9form'];
				}else{
					return false;
				}
			}			
		}
	}
	#=====================================================================================Get planPrice
	#=====================================================================================	
	function planPrice($id,$currency = null){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency == "MEX"){
				return $value['mex_entry_amount'];				
			}else{
				return $value['entry_ammout'];
			}
		}
	}
	#=====================================================================================Get exitPrice
	#=====================================================================================
	function exitPrice($id){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			return $value['exit_price'];
		}
	}

	function packageDiscount($id){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			return $value['descount_percent'];
		}
	}

	function packageBinaryPoint($id,$currency = null){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency = "MEX"){
				return $value['mx_bv_point'];				
			}else{
				return $value['Binary_point'];				
			}
		}
	}
	
	function packageBinaryPointByCurrency($id,$currency){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				if(!empty($currency) && $currency == "MEX"){
					return $value['mx_bv_point'];										
				}else{
					return $value['Binary_point'];					
				}
			}			
		}
	}

	function packageReferralAmount($id=null,$currency=null,$userCurrency=null){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				if(!empty($currency) && $currency == "MEX" && !empty($userCurrency) && $userCurrency == "MEX"){
					return $value['mex_referral_amount'];					
				}elseif(!empty($currency) && $currency != "MEX" && !empty($userCurrency) && $userCurrency !="MEX"){
					return $value['referrals_amount'];
				}elseif(!empty($currency) && $currency != "MEX" && !empty($userCurrency) && $userCurrency =="MEX"){
					$rate = $this->packageConversionRate(1,$currency);
					$price =   $value['mex_referral_amount'] * $rate;
					return $price;
				}elseif(!empty($currency) && $currency == "MEX" && !empty($userCurrency) && $userCurrency !="MEX"){
					$rate = $this->packageConversionRate(1,$currency);
					$price =  $value['referrals_amount'] * $rate;
					return $price;
				}else{
					return $value['referrals_amount'];
				}
			}			
		}else{
			return 0;
		}
	}

	function packageConversionRate($id=null,$currency=null){
		$this->db->where(array('id'=>$id));
		$result = $this->db->get('conversion_rate');
		$data =$result->result_array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				if(!empty($currency) && $currency == "MEX"){
					return $value['us_rate'];
				}else{
					return $value['mx_rate'];					
				}
			}			
		}else{
			return 0;
		}
	}

	function parentID($table){
		$useridq = "SELECT * FROM  $table where user_id > 0";
		$result1 = $this->db->query($useridq);
		$userid = $result1->result_array();
		foreach($userid as $key => $id){
			$query1 = "SELECT * FROM $table where parent_id='".$id['user_id']."'";
			$query = $this->db->query($query1);
			$parent = $query->result_array();

		 $count =  count($parent);
			if($count == 3) {
				// return false;
			}
			else{
				 return $parent_id = $id['user_id'];
			}
		}
	}

	function levelID($table,$condition){
		$this->db->where($condition);
		$rs = $this->db->get($table);
		if($rs->num_rows()>0){
			$result = $rs->result_array();
			foreach ($result as $key => $value) {
				return $value['user_id'];
			}
		}
		else{
			return false;
		}
	}
	
	function countLevel($table,$id){		
		$query = "SELECT * FROM $table WHERE parent_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		$membercount = count($childresult);
		$membercount1 = null;
		foreach ($childresult as $key => $value) {
			$childquery = "SELECT * from $table WHERE parent_id = ".$value['user_id'];
			$child1 = $this->db->query($childquery);
			$childresult1 = $child1->result_array();
			$membercount += count($childresult1);
		}
		return $membercount;
	}

	function countUserLevel($table,$id){
		$query = "SELECT * FROM $table WHERE user_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		if(!empty($childresult)){
			foreach ($childresult as $key => $value) {
				if(!empty($value['level'])){
					return $value['level'];					
				}else{
					return 1;
				}
			}			
		}else{
			return 1;
		}
	}

	function countChildren($table,$id){		
		$query = "SELECT * FROM $table WHERE parent_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		$membercount = count($childresult);
		$membercount1 = null;
		foreach ($childresult as $key => $value) {
			$childquery = "SELECT * from $table WHERE parent_id = ".$value['user_id']." LIMIT 2";
			$child1 = $this->db->query($childquery);
			$childresult1 = $child1->result_array();
			$membercount += count($childresult1);
		}
		return $membercount;

	}

	function countUnilevelUserRank($startId,$level){		
		$directDescendents = $this->db->query("SELECT user_id, level FROM earning_info WHERE level=".$level." and sponser_id = ?", array( $startId ));
	    $count = $directDescendents->num_rows($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count += $this->countUnilevelUserRank($value['user_id'],$level);
	    }
	    return $count;
	}
	
	function countTotalUnilevelMember($startId,$level) {
	    $directDescendents = $this->db->query("SELECT a.user_id as user_id, b.level as level FROM user_master as a LEFT JOIN earning_info as b on b.user_id=a.parent_id WHERE a.parent_id = ".$startId);
	    $count = $directDescendents->num_rows($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count += $this->countTotalUnilevelMember($value['user_id'],$value['level']);
	    }
	    return $count;
	}
	
	function getMyChildren($table, $id){
		$query = "SELECT * FROM $table WHERE parent_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		if(isset($childresult) && !empty($childresult)){
			return $membercount = count($childresult);
		}else{
			return 0;
		}			
	}

	function levelCreated($table,$id){
		$query = "SELECT * FROM $table WHERE user_id = ".$id;
		$result1 = $this->db->query($query);
		$result = $result1->result_array();
		foreach ($result as $value) {
			
			if(isset($value['created_at']) && !empty($value['created_at'])){
				return  $value['created_at'];
			}else{
				return  false;
			}
		}
	}

	function countall($table){		
		$query = "SELECT * FROM $table";
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		$membercount = 0;
		$membercount1 = null;
		foreach ($childresult as $key => $value) {
			$childquery = "SELECT * from $table WHERE parent_id = ".$value['user_id'];
			$child1 = $this->db->query($childquery);
			$childresult1 = $child1->result_array();
			$membercount += count($childresult1);
			return $membercount;
		}
		//return $membercount;
	}
	function getReferrals($table, $where){
		$query = "SELECT count(sponsor_id) as referrals FROM $table WHERE sponsor_id = ".$where;
		$result1 = $this->db->query($query);
		$result = $result1->result_array();
		foreach ($result as $value) {
			
			if(isset($value['referrals']) && !empty($value['referrals'])){
				return  $value['referrals'];
			}else{
				return  false;
			}
		}
	}
#+++++++++++++++++++++++++++++Get All Parent to Parent ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function getAllParent($id){
		$query = "SELECT * FROM user_master WHERE user_id = ".$id;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return  $value['parent_id'];
			} 			
		}else{
			return 0;
		}
    }
	
	function getAllSponsor($id){
		$query = "SELECT * FROM user_master WHERE user_id = ".$id;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return  $value['sponsor_id'];
			} 			
		}else{
			return 0;
		}
		
    }
	
	function getCurrentRankById($where){
		$query = $this->db->query('SELECT * FROM `level_configuration` WHERE l_conf_id='.$where);
		$result = $query->result_array();
		foreach ($result as $key => $value) {
			return $value['level_name'];
		}
	}
	#=====================================================================================			Display Binary Tree view
	#=====================================================================================
	function binaryTree(){
		echo 'var treeData = {"id":215,"name":"Aliva","image":"avatar_default.png","level":0,
			"children":[{
				"id":576,"name":"Aliva1","parent_id":215,"level":0,"image":"avatar_default.png",
				"children":[{
						"id":1823,"name":"Aliva2","parent_id":576,"image":"avatar_default.png","level":0
					},{
					"id":1824,"name":"Aliva5","parent_id":576,"image":"avatar_default.png","level":0
					},{
						"id":1825,"name":"daniel2","parent_id":576,"level":0,"position_tree":"1","image":"avatar_default.png"
					}]
			},{
				"id":577,"name":"daniel1","parent_id":215,"level":0,"position_tree":"1","image":"avatar_default.png",
				"children":[
				{"id":600,"name":"daniel4","parent_id":577,"level":1,"position_tree":"1","image":"avatar_default.png"},
				{"id":601,"name":"daniel5","parent_id":577,"level":1,"position_tree":"1","image":"avatar_default.png"},
				{"id":602,"name":"daniel6","parent_id":577,"level":1,"position_tree":"0","image":"0"}]
			},{
				"id":578,"name":"daniel","parent_id":215,"level":0,"position_tree":"1","image":"avatar_default.png",
				"children":[{
						"id":610,"name":"daniel9","parent_id":578,"level":1,"position_tree":"1","image":"avatar_default.png"
					},{
						"id":611,"name":"daniel8","parent_id":578,"level":1,"position_tree":"1","image":"avatar_default.png"
					},{
						"id":612,"name":"daniel7","parent_id":578,"level":1,"position_tree":"0","image":"0"
					}]
			}]
		};';
	}
	
	function deletesite($path){
	    if (is_dir($path) === true)
	    {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

	        foreach ($files as $file)
	        {
	            if (in_array($file->getBasename(), array('.', '..')) !== true)
	            {
	                if ($file->isDir() === true)
	                {
	                	//var_dump($file->getPathName());exit;
	                    rmdir($file->getPathName());

	                }

	                else if (($file->isFile() === true) || ($file->isLink() === true))
	                {
	                    unlink($file->getPathname());
	                }
	            }
	        }

	        return rmdir($path);
	    }

	    else if ((is_file($path) === true) || (is_link($path) === true))
	    {
	        return unlink($path);
	    }

	    return false;
	}
	
	function getSubscriptionId($where){
		$query = "SELECT * FROM `payment_info` WHERE transaction_arb_id !='' AND user_id = ".$where." AND sub_status = 'active'";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['transaction_arb_id'];
			}		
		}else{
			return null;
		}
	}

	function getReactivateSubscriptionId($where){
		$query = "SELECT * FROM `payment_info` WHERE transaction_arb_id !='' AND user_id = ".$where." AND sub_status = 'active' ORDER BY payment_at DESC LIMIT 1";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['transaction_arb_id'];
			}		
		}else{
			return null;
		}
	}
	
	function getInactiveSubscriptionId($where){
		$query = "SELECT * FROM `payment_info` WHERE transaction_arb_id !='' AND user_id = ".$where." AND sub_status = 'inactive' ORDER BY payment_at DESC LIMIT 1";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['transaction_arb_id'];
			}		
		}else{
			return null;
		}
	}
	function binaryConversionPrice($currency=null){
		$query = "SELECT * FROM chron_job_info LIMIT 0 , 1";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				if(!empty($currency) && $currency == "MEX"){
					return $value['mex_binary_conversion_price'];
				}else{
					return $value['binary_conversion_price'];
				}
			}		
		}else{
			return 10;
		}
	}

	function binaryConversionRate(){
		$query = "SELECT * FROM chron_job_info LIMIT 0 , 1";
	 	$result = $this->db->query($query);
	  	$data = $result->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['conversion_binary_point'];
			}		
		}else{
			return 330;
		}
	}
	
	function getUserNameById($where){
		$query = "SELECT * FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_name'];
			}			
		}else{
			return false;
		}
	}
	
	function getUserEmailById($where){
		$query = "SELECT * FROM user_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['user_name'];
			}			
		}else{
			return false;
		}
	}
	
	function getLevelExitQv($where){
		if(!empty($where)){
			$query = "SELECT * FROM level_configuration WHERE l_conf_id = ".$where;
			$result = $this->db->query($query);
			$data = $result->result_array();

			if(isset($data) && !empty($data)){
				foreach ($data as $key => $value) {
					return $value['exit_qv'];
				}			
			}else{
				return false;
			}
		}
	}
	
	function getDiscountPercentOfLevel($where){
		if(!empty($where)){
			$query = "SELECT * FROM level_configuration WHERE l_conf_id = ".$where;
			$result = $this->db->query($query);
			$data = $result->result_array();

			if(isset($data) && !empty($data)){
				foreach ($data as $key => $value) {
					return $value['level_discount_percent'];
				}			
			}else{
				return false;
			}			
		}
	}

	function packageQVPoint($id,$currency = null){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency =="MEX"){
				return $value['mx_qv_point'];					
			}else{
				return $value['qv_point'];
			}
		}
	}
	
	function packageQVPointByCurrency($id,$currency){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				if(!empty($currency) && $currency == "MEX"){
					return $value['mx_qv_point'];					
				}else{
					return $value['qv_point'];
				}
			}			
		}
	}
	
	function getTotalBalance($where){
		$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$where);
					
		if(isset($selectearningtotal) && !empty($selectearningtotal)){
			foreach ($selectearningtotal as $total) {						
				return $total['total_balance'];
			}
		}else{
			return 0;
		}
	}
	
	function getParentUser($startId){
	    $directDescendents = $this->db->query("SELECT * FROM user_master WHERE user_id =".$startId);
		
	    $row = $directDescendents->result_array($directDescendents);
		if(!empty($row)){
			foreach ($row as $key => $value) {
				return $value['parent_id'];
			}			
		}else{
			return 0;
		}
	}

	function getTotalChildren($startId) {
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE parent_id = ?", array( $startId ));
	    $count = $this->getCurrentChildren($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count .= ','.$this->countTotalChildren($value['user_id']);
	    }
	    return $count;
	}

	function getCurrentChildren($directDescendents){
		$row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count .= $value['lft_user'].','.$value['rght_user'];
	    }
	    return $count;
	}
	
	function getModuleID($where){
		$this->db->where('user_id',$where);
	  	$data = $this->db->get('earning_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				if($value['module']){
					return $value['module'];					
				}else{
					return 0;
				}
			}		
		}else{
			return 1;
		}
	}
	
	function getRulePercentOfModule($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['rule_percent'];
			}		
		}else{
			return '0';
		}
	}

	function getRequiredTeamMember($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['total_member_in_team'];
			}		
		}else{
			return '0';
		}
	}

	function getPresonalSponsorMember($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['p_sponsor_user'];
			}		
		}else{
			return '0';
		}
	}

	function getModuleAmount($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['payment'];
			}		
		}else{
			return '0';
		}
	}



	function getuserFullNameForMail($where){
		$query = "SELECT * FROM user_master WHERE user_name = '".$where."'";
		$result = $this->db->query($query);
		$data = $result->result_array();

		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['first_name'].', '.$value['last_name'];
			}			
		}else{
			return ' ';
		}
	}

	function getTotalEtherWalletBalance($userId){
		$contentData = $this->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$userId.' AND wallet_type="1"');
		if(!empty($contentData) ){
			foreach ($contentData as $value) {
				$data=$value['total'];
				return $data;
			}
		}else{
			return 0;
		}
	}

	function getEtherConversionRates() {
		$contentData = $this->allSelects('SELECT * FROM ether_conversionrate');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr = array(
					'ether_rate' => $value['ether_rate'],
					'conversion_charge' => $value['conversion_charge']
				);

				return $arr; 
			}
		}
		else {
			return 0;
		}
	}

	function getEarningTotalBalance($userId) {
		$userId = $this->session->userdata('user_id');
		$selectearningtotal = $this->allSelects('SELECT total_balance from earning_info where user_id ='.$userId);
		if(!empty($selectearningtotal)){
			foreach ($selectearningtotal as $value) {
				$data=$value['total_balance'];
				return $data;
			}

		}else{
			return 0;
		}
	}

	function getTotalDeductById($userId){
		$userId = $this->session->userdata('user_id');
		$contentData = $this->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$userId.' AND wallet_type="2"');			
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$arr = $value['total'];
				return $arr;
			}
		}else{
			return 0;
		}
	}

	function getCurrentBalanceFromEarningById($userId){
		$userId = $this->session->userdata('user_id');
		$curBalance = $this->allSelects('SELECT SUM(amount) as total FROM earning_details_by_user WHERE user_id='.$userId);
		if(!empty($curBalance)){
			foreach ($curBalance as $value) {
				$arr = $value['total'];
				return $arr;
			}
		}
		else{
			return 0;
		}
	}


	function userMailBody($user_name, $password){

		$UserName = $this->getuserFullNameForMail($user_name);
		$body = '
				<div>
					<table width="100%" cellspacing="0" cellpadding="0" style="background-color:rgb(250,250,250);">
						<tbody>
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" style="border:1px solid rgb(221,221,221);width:580px;background-color:rgb(255,255,255);">
										<tbody>
											<tr>
												<td align="left">
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="80px">
														<tbody>
															<tr>
																<td valign="middle" align="center">
																	<table cellpadding="10">
																		<tbody><tr>
																			<td>
																				
																			</td>
																		</tr>
																	</tbody></table>
																</td>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="8">
																		<tbody><tr>
																				<td style="color:rgb(255,255,255);background-color:rgb(71,71,71);">
																					<b>Xonnova</b></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td style="color:rgb(0,0,0);">
																	<div style="color:#500050;font-weight:bold;font-size:16px;">
																		Congratulations '.$UserName.'!
																	</div>
																	<br>
																	Welcome to Xonnova online business platform. Right now you are just one step away from financial freedom. This means that if you follow our simple steps, you will learn how to take your business to a completely new level. If you would like to share your replicated link with others you can share this link here <a target="_blank" href="https://xonnova.com/user/'.$user_name.'">https://xonnova.com/user/'.$user_name.'</a>


																	<br><br>If you have any question, please do not hesitate to contact your upline or your closest leader to give you the proper training.

																	<br><br>Here, we will give you the contact information to stay in touch with us at all times:
																	
																	<br>Customer service email: <a target="_blank" href="mailto:info@xonnova.com">info@xonnova.com</a>
																	
																	<br>Any comment to improve: <a target="_blank" href="mailto:improvement@xonnova.com">improvement@xonnova.com</a>
																	<br><br>On the below part of this email, you will find some useful links to access your website, and platforms without any complication.
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="2px" cellpadding="2px" style="border-bottom-width:1px;border-bottom-style:dashed;border-bottom-color:rgb(204,204,204);">
														<tbody>
															<tr>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<br>
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="5">
																		<tbody><tr>
																			<td style="color:rgb(255,255,255);font-weight:bold;background-color:rgb(51,51,51);">
																				Access your backoffice now</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td style="color:rgb(0,0,0);"><a target="_blank" href="https://my.xonnova.com">https://my.xonnova.com</a>&nbsp;<br><br>
																	Username: <b>'.$user_name.'</b>
																	<br>
																	Password:  <b>'.$password.'</b><br>
																						<br>
																		<span style="color:rgb(255,0,0);">To login to your account you must be using a compatible browser such as Firefox and Google Chrome. Please do not use Internet Explorer (its very obsolete).</span>
																	
																</td>
																
															</tr>
														</tbody>
													</table>

													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="5">
																		<tbody><tr>
																			<td style="color:rgb(255,255,255);font-weight:bold;background-color:rgb(51,51,51);">
																				Some very important bullet points:</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td style="color:rgb(0,0,0);">
																	<div style="font-weight:bold;">
																			Before you get started, make sure you understand the following question: </div>


																		<br><br>
																		<b>Q:</b> When and how will I get paid?
																		<br>
																		<b>A:</b> After 14 days of a commission earned, you can cash out and receive a PayPal transfer on the following Friday
																		<br><br>


																		<b>Q:</b> What countries can I promote the service in? 
																		<br>
																		<b>A:</b> Due to the fact that our platform is an online platform, you can promote in any country in which is legal to use mobile applications.
																		<br><br>



																		<b>Q:</b> Will I get paid the same if I affiliate people from other countries? 
																		<br>
																		<b>A:</b> YES. We charge in USD for that reason you will get paid in USD everywhere you are.
																		<br><br>


																		<b>Q:</b> How much will it cost me to cashout?
																		<br>
																		<b>A:</b> Cashout cost is 3% or $5, whichever is higher.
																		<br><br>


																		<b>Q:</b> How many times can I cashout a month?
																		<br>
																		<b>A:</b> We deposit every Friday; therefore, you can cashout every week if you want to.
																		<br>

																		

																</td>
																
															</tr>
														</tbody>
													</table>

													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle"><br></td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="0px" height="5px" style="background-color:rgb(71,71,71);">
														<tbody>
															<tr>
																	<td></td>
																</tr>
															</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="10" height="30px" style="background-color:rgb(228,228,228);">
														<tbody>
															<tr>
																<td width="100%" style="font-size:11px;line-height:14px;">
																	  <br>
																	    
																</td>
																<td width="80">
																	
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			';
		return $body;
	}
	
	
	function userMailBody2222($user_name, $password){
		$body = '
				<div>
					<table width="100%" cellspacing="0" cellpadding="0" style="background-color:rgb(250,250,250);">
						<tbody>
							<tr>
								<td align="center">
									<table cellspacing="0" cellpadding="0" style="border:1px solid rgb(221,221,221);width:580px;background-color:rgb(255,255,255);">
										<tbody>
											<tr>
												<td align="left">
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="80px">
														<tbody>
															<tr>
																<td valign="middle" align="center">
																	<table cellpadding="10">
																		<tbody><tr>
																			<td>
																				<img src="http://my.xonnova.com/assets/img/logo.png">
																			</td>
																		</tr>
																	</tbody></table>
																</td>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="8">
																		<tbody><tr>
																				<td style="color:rgb(255,255,255);background-color:rgb(71,71,71);">
																					<b>xonnova Network</b></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td>
																	<div style="font-weight:bold;font-size:16px;">
																		Congratulations '.$user_name.'!
																	</div>
																	<br>
																	Welcome to xonnova Netowork Business Platform.
																	Right now you are just one step away from financial freedom. This means that if you follow out 30-day calendar, you will learn the steps to take your business to a completely new level.
																	If you would like to share your replicated link with others you can share this link here <a target="_blank" href="https://xonnova.com/user/'.$user_name.'">https://xonnova.com/user/'.$user_name.'</a><br><br>If you have any question, please do not hesitate to contact your upline or your closest leader to give you the proper training.&nbsp;<br><br>Here, we will give you the contact information to stay in touch with us at all times:<br>Customer service number 844-xonnova<br>Customer service email: <a target="_blank" href="mailto:info@xonnova.com">info@xonnova.com</a><br>Shipping questions email: <a target="_blank" href="mailto:shipping@xonnova.com">shipping@xonnova.com</a><br>Network questions email: <a target="_blank" href="mailto:ff@xonnova.com">ff@xonnova.com</a><br>Complaints about your leader: <a target="_blank" href="mailto:uplinecomplaint@xonnova.com">uplinecomplaint@xonnova.com</a><br>Any comment to improve: <a target="_blank" href="mailto:improvement@xonnova.com">improvement@xonnova.com</a><br><br>On the below part of this email, you will find some useful links to access your website, and platforms without any complication.
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="2px" cellpadding="2px" style="border-bottom-width:1px;border-bottom-style:dashed;border-bottom-color:rgb(204,204,204);">
														<tbody>
															<tr>
																<td>&nbsp;</td>
															</tr>
														</tbody>
													</table>
													<br>
													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="5">
																		<tbody><tr>
																			<td style="color:rgb(255,255,255);font-weight:bold;background-color:rgb(51,51,51);">
																				Access your backoffice now</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td><a target="_blank" href="https://my.xonnova.com">https://my.xonnova.com</a>&nbsp;<br><br>
																	Username: <b>'.$user_name.'</b>
																	<br>
																	Password:  <b>'.$password.'</b><br>
																						<br>
																		<span style="color:rgb(255,0,0);">To login to your account you must be using a compatible browser such as Firefox and Google Chrome. Please do not use Internet Explorer (its very obsolete).</span>
																	
																</td>
																<td>
																	<img width="250px" src="https://my.xonnova.com/assets/img/demo/computer1-welcome-email.jpg">
																</td>
															</tr>
														</tbody>
													</table>

													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle">
																	<table width="100%" cellpadding="5">
																		<tbody><tr>
																			<td style="color:rgb(255,255,255);font-weight:bold;background-color:rgb(51,51,51);">
																				The first steps to follow:</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellpadding="10">
														<tbody>
															<tr>
																<td>
																	<div style="font-weight:bold;">
																			Before you get started, make sure to follow these easy 5 steps to get ready to get started:&nbsp;</div>
																		<br><b>Step 1:</b> Understand your business<br><font color="#1155cc"><b><u><a target="_blank" href="https://www.youtube.com/watch?v=3cEAUOJ1epo">https://www.youtube.com/watch?v=3cEAUOJ1epo</a></u></b></font><br><br><b>
																		Step 2:</b> Understand your backoffice
																		<br><b style="color:rgb(17,85,204);"><u><a target="_blank" href="https://www.youtube.com/watch?v=3cEAUOJ1epo">https://www.youtube.com/watch?v=3cEAUOJ1epo</a></u></b><br><br><b>
																		Step 3.</b>&nbsp;Read out My First 30 program <b>Here</b>&nbsp;<br><br><b>Step 4.</b> Request your platforms <b><a target="_blank" href="https://my.xonnova.com/#/new-platforms">Here</a></b><br><br><b>Step 5.</b> Request your payout card <a target="_blank" href="https://attapay.net/user/xonnova"><b>Here</b></a>

																</td>
																<td>
																	<img width="250px" src="https://my.xonnova.com/assets/img/demo/computer2-welcome-email.jpg">
																</td>
															</tr>
														</tbody>
													</table>

													<table width="100%" cellspacing="0" cellpadding="0" border="0" height="40px">
														<tbody>
															<tr>
																<td width="100%" valign="middle"><br></td>
															</tr>
														</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="0px" height="5px" style="background-color:rgb(71,71,71);">
														<tbody>
															<tr>
																	<td></td>
																</tr>
															</tbody>
													</table>
													<table width="100%" cellspacing="0px" cellpadding="10" height="30px" style="background-color:rgb(228,228,228);">
														<tbody>
															<tr>
																<td width="100%" style="font-size:11px;line-height:14px;">
																	Call US!   <br>
																	17000 Ventura Blvd, ENCINO, CA, 91316        
																</td>
																<td width="80">
																	<img src="http://my.xonnova.com/assets/img/logo.png">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr></tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			';
		return $body;
	}
	
	function eventMailBody($user_name){
		$body = '<div>Hello  '.$user_name.'.</div><br/>
				<div>Your participation in the event is confirmed. </div><br/>
				<div>The event details are as follows -</div><br/>
				<div>Date: 11/10/2015</div><br/>
				<div>Venue: Hotel MGM Grand, Las Vegas, 3799 S Las Vegas Blvd, Las Vegas, NV 89109, United States</div><br/>
				<div>Phone:+1 702-891-1111</div><br/>
				<div>In case you need any further information, please email us - info@xonnova.com</div><br/>
				';
		return $body;
	}
}
?>