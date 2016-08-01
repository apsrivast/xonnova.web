<?php
/**
* 
*/
class New_send_leads_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}


	function getMerchantLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Merchant"  AND a.s_f_time BETWEEN "'.$from.'" AND "'.$to.'"  ORDER BY a.s_f_status DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Merchant" ORDER BY a.s_f_status DESC');
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



	function getSolorLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Solar"  AND a.s_f_time BETWEEN "'.$from.'" AND "'.$to.'"  ORDER BY a.s_f_status DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Solar" ORDER BY a.s_f_status DESC');
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


	function approveLeadsListById(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			's_f_status'=>'Approved',
		);
		if(!$this->db->update('soler_form',$updateArr, array('s_f_id'=>$_POST['s_f_id']))){
			$data = array('message'=>'Leads Status NOT Approved');
			echo json_encode($data);				
		}else{
			$data = array('message'=>'Leads Status  Approved');
			echo json_encode($data);
		}
	}

	function rejectLeadsListById(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			's_f_status'=>' Rejected',
			'reject_comment'=>$_POST['reject_comment'],
		);
		if(!$this->db->update('soler_form',$updateArr, array('s_f_id'=>$_POST['s_f_id']))){
			$data = array('message'=>'Leads Status NOT Rejected');
			echo json_encode($data);				
		}else{
			$email = $this->mdl_common->getSIMuseremail($_POST['user_id']);
			$this->send_reject_mail($email, $_POST['username'], $_POST['reject_comment']);
			$data = array('message'=>'Leads Status Rejected');
			echo json_encode($data);
		}
	}
	
	function getPrintingLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Printing"  AND a.s_f_time BETWEEN "'.$from.'" AND "'.$to.'"  ORDER BY a.s_f_status DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.s_f_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Printing" ORDER BY a.s_f_status DESC');
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



	function redeemRewardPoint( $userid){
		$userName = $this->mdl_common->getUserNameById($userid);

		$this->creditwallet($userid, 3420, $userName);
		$amount = 489;
		$sponsor_id = $this->mdl_common->getAllSponsor($userid);
		if($sponsor_id == 0){
		return;
		}
		$this->creditwallet($sponsor_id, $amount, $userName);
	
		$sponsor1 = $this->mdl_common->getAllSponsor($sponsor_id);
		if($sponsor1 == 0){
		return;
		}
		$this->creditwallet($sponsor1, $amount, $userName);

		$sponsor2 = $this->mdl_common->getAllSponsor($sponsor1);
		if($sponsor2 == 0){
		return;
		}
		$this->creditwallet($sponsor2, $amount, $userName);

		$sponsor3 = $this->mdl_common->getAllSponsor($sponsor2);
		if($sponsor3 == 0){
		return;
		}
		$this->creditwallet($sponsor3, $amount, $userName);

		$sponsor4 = $this->mdl_common->getAllSponsor($sponsor3);
		if($sponsor4 == 0){
		return;
		}
		$this->creditwallet($sponsor4, $amount, $userName);

		$sponsor5 = $this->mdl_common->getAllSponsor($sponsor4);
		if($sponsor5 == 0){
		return;
		}
		$this->creditwallet($sponsor5, $amount, $userName);

		$sponsor6 = $this->mdl_common->getAllSponsor($sponsor5);
		if($sponsor6 == 0){
		return;
		}
		$this->creditwallet($sponsor6, $amount, $userName);
	}

	function creditwallet($sponser, $referralAmount, $userName) {
		$Arr = array(
				'user_id'=>$sponser,
				'admin_id'=>1,
				'credit'=>$referralAmount,
				'wallet_type'=>'1',
				'message'=>'Refer Restaurant Lead '.$userName,
			);
		$this->db->insert('reward_points_report_info',$Arr);
		$existUser = count($this->mdl_common->allSelects('SELECT user_id FROM reward_points_report_user_map_info WHERE user_id='.$sponser));
		if(empty($existUser) && $existUser == 0){
			$insertwallete = array(
				'user_id'=>$sponser,
				'admin_id'=>1,
			);
			$this->db->insert('reward_points_report_user_map_info',$insertwallete);
		}
	}

	function redeemMony( $userid){
		$userName = $this->mdl_common->getUserNameById($userid);

		$this->getEnringInfo($userid, 40, $userName);
		$amount = 5;
		$sponsor_id = $this->mdl_common->getAllSponsor($userid);
		if($sponsor_id == 0){
		return;
		}
		$this->getEnringInfo($sponsor_id, $amount, $userName);
	
		$sponsor1 = $this->mdl_common->getAllSponsor($sponsor_id);
		if($sponsor1 == 0){
		return;
		}
		$this->getEnringInfo($sponsor1, $amount, $userName);

		$sponsor2 = $this->mdl_common->getAllSponsor($sponsor1);
		if($sponsor2 == 0){
		return;
		}
		$this->getEnringInfo($sponsor2, $amount, $userName);

		$sponsor3 = $this->mdl_common->getAllSponsor($sponsor2);
		if($sponsor3 == 0){
		return;
		}
		$this->getEnringInfo($sponsor3, $amount, $userName);

		$sponsor4 = $this->mdl_common->getAllSponsor($sponsor3);
		if($sponsor4 == 0){
		return;
		}
		$this->getEnringInfo($sponsor4, $amount, $userName);

		$sponsor5 = $this->mdl_common->getAllSponsor($sponsor4);
		if($sponsor5 == 0){
		return;
		}
		$this->getEnringInfo($sponsor5, $amount, $userName);

		$sponsor6 = $this->mdl_common->getAllSponsor($sponsor5);
		if($sponsor6 == 0){
		return;
		}
		$this->getEnringInfo($sponsor6, $amount, $userName);
	}

	function getEnringInfo($sponser, $referralAmount, $userName){
		$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
		if(isset($selectearningtotal) && !empty($selectearningtotal)){
			foreach ($selectearningtotal as $total) {						
				$totalreferralAmount= $total['total_balance'] + $referralAmount;
				$updattotalarr = array(
					'total_balance'=>$totalreferralAmount,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
			}
		}else{
			$totalreferralAmount = $referralAmount;
			$updattotalarr = array(
				'total_balance'=>$totalreferralAmount,
			);
			$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
		}
		$earning_details_by_user = array(
				'user_id'=>$sponser,
				'type_id'=>'9',
				'description'=>'Refer Restaurant Lead '.$userName,
				'amount'=>$referralAmount,
			);
		$this->db->insert('earning_details_by_user',$earning_details_by_user);
	}

	function redeemRestaurantLeadsListById(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->session->userdata('user_id');
		if($id != $_POST['user_id']){
			$data = array('message'=>'This is NOT Your Lead');
			echo json_encode($data);
			return;				
		}

		$isRedeemed = $this->mdl_common->leadIsRedeemed($_POST['s_f_id']);
		if($isRedeemed){
			$data = array('message'=>'Already  Redeemed ');
			echo json_encode($data);
			return;				
		}
		if(!isset($_POST['redeem_option'])){
			$data = array('message'=>'Redeem option is  required');
			echo json_encode($data);
			return;				
		}

		if($_POST['redeem_option'] == ''){
			$data = array('message'=>'Redeem option is  required');
			echo json_encode($data);
			return;				
		}

		if($_POST['industry'] != 'Restaurant'){
			$data = array('message'=>'Not A Restaurant lead');
			echo json_encode($data);
			return;				
		}

		if($_POST['restaurant_lead_status'] != 'Approved'){
			$data = array('message'=>'Lead Not Approved');
			echo json_encode($data);
			return;				
		}


		$updateArr = array(
			'restaurant_lead_status'=>' Redeemed',
			'redeem_option'=>$_POST['redeem_option'],
			'redeem_status'=>1,
		);
		if(!$this->db->update('soler_form',$updateArr, array('s_f_id'=>$_POST['s_f_id']))){
			$data = array('message'=>'Lead NOT Redeemed');
			echo json_encode($data);				
		}else{
			if($_POST['redeem_option'] == 'Reward points'){
				$this->redeemRewardPoint($_POST['user_id']);		
			}else{
				$this->redeemMony($_POST['user_id']);
			}

			$data = array('messagee'=>'Lead Redeemed');
			echo json_encode($data);
		}
	}

	function getRestaurantLeadsListBYUSER(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->session->userdata('user_id');
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT s_f_id, business_name, business_email, phone_no, s_f_time, restaurant_lead_status From soler_form     WHERE industry = "Restaurant" AND user_id = '.$id.' AND s_f_time BETWEEN "'.$from.'" AND "'.$to.'"  ');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT s_f_id, business_name, business_email, phone_no, s_f_time, restaurant_lead_status From soler_form     WHERE industry = "Restaurant" AND user_id = '.$id);
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

	function approveRestaurantLeadsListById(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'restaurant_lead_status'=>'Approved',
			's_f_status'=>'Approved',
		);
		if(!$this->db->update('soler_form',$updateArr, array('s_f_id'=>$_POST['s_f_id']))){
			$data = array('message'=>'Leads Status NOT Approved');
			echo json_encode($data);				
		}else{
			$data = array('message'=>'Leads Status  Approved');
			echo json_encode($data);
		}
	}

	function rejectRestaurantLeadsListById(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
			'restaurant_lead_status'=>' Rejected',
			's_f_status'=>' Rejected',
			'reject_comment'=>$_POST['reject_comment'],
		);
		if(!$this->db->update('soler_form',$updateArr, array('s_f_id'=>$_POST['s_f_id']))){
			$data = array('message'=>'Leads Status NOT Rejected');
			echo json_encode($data);				
		}else{
			$email = $this->mdl_common->getSIMuseremail($_POST['user_id']);
			$this->send_reject_mail($email, $_POST['username'], $_POST['reject_comment']);
			$data = array('message'=>'Leads Status Rejected');
			echo json_encode($data);
		}
	}

	function send_reject_mail(  $user_email=null,  $userName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);
        $this->email->subject('Lead Rejected');
        $mail_body	='<div>
        					<p>Hello '.$userName.', </p>
        					<p>Your Lead request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);
        $this->email->send();
    }

	function getRestaurantLeadsListById($id){
		$list = $this->mdl_common->allSelects('SELECT a.*,  b.user_name as username From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.s_f_id = '.$id);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function getRestaurantLeadsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.restaurant_lead_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Restaurant"  AND a.s_f_time BETWEEN "'.$from.'" AND "'.$to.'"  ORDER BY a.restaurant_lead_status DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			$list = $this->mdl_common->allSelects('SELECT a.s_f_id, a.business_name, a.business_email, a.phone_no, a.s_f_time, a.restaurant_lead_status, b.user_name From soler_form as a LEFT JOIN user_master as b on a.user_id = b.user_id    WHERE a.industry = "Restaurant" ORDER BY a.restaurant_lead_status DESC');
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

	function submitMerchant(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('owner_business', 'Business owner', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('processes_cc', 'Currently processes credit cards', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_name', 'Business  Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_type', 'Business  Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('terminal_type', 'Terminal  Type', 'trim|required|xss_clean');


		$this->form_validation->set_rules('first_name', 'Owner First Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('last_name', 'Owner Last Name', 'trim|required|xss_clean');

	
		$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');	
		
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_email', 'Email', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('day', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('time', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zone', 'Date and time to reach', 'trim|required|xss_clean');	
		//$this->form_validation->set_rules('leadimageone', 'electric bill Pictures', 'trim|required|xss_clean');		

		$this->form_validation->set_rules('prefer_lang', 'Prefer language', 'trim|required|xss_clean');
		$this->form_validation->set_rules('merchant_talk', 'Have you talked to the client about Merchant services', 'trim|required|xss_clean');
		$this->form_validation->set_rules('merchant_interested', 'Is the client interested in getting Merchant Services', 'trim|required|xss_clean');

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['client_contract']) && !empty($_POST['client_contract'])){
		}else	$_POST['client_contract'] = '';

		if(isset($_POST['client_contract_long']) && !empty($_POST['client_contract_long'])){
		}else	$_POST['client_contract_long'] = '';

		if(isset($_POST['client_signup_today']) && !empty($_POST['client_signup_today'])){
		}else	$_POST['client_signup_today'] = '';

		if(isset($_POST['client_mex_offer']) && !empty($_POST['client_mex_offer'])){
			if ($_POST['client_mex_offer'] > 300){
				$data = array("message"=> 'do not allow numbers above $300');
				echo json_encode($data);
				return  ;
			}
		}else	$_POST['client_mex_offer'] = '';

		if(isset($_POST['average_sales']) && !empty($_POST['average_sales'])){
		}else	$_POST['average_sales'] = '';

		if(isset($_POST['contract_guarantee']) && !empty($_POST['contract_guarantee'])){
		}else	$_POST['contract_guarantee'] = '';


		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else	$_POST['address2'] = '';

		if(isset($_POST['other_lang']) && !empty($_POST['other_lang'])){
		}else	$_POST['other_lang'] = '';

		if(isset($_POST['leadimageone']) && !empty($_POST['leadimageone'])){
		}else	$_POST['leadimageone'] = '';




		$insertArr = array(
				'user_id'=>$userid,
				'industry'=>$_POST['industry'],
				'owner_business'=>$_POST['owner_business'],
				'processes_cc'=>$_POST['processes_cc'],

				'business_name'=>$_POST['business_name'],
				'business_type'=>$_POST['business_type'],
				'terminal_type'=>$_POST['terminal_type'],

				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				
				'address1'=>$_POST['address1'],
				'address2'=>$_POST['address2'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state'],
				'zip'=>$_POST['zip'],
				'phone_no'=>$_POST['phone_no'],
				'business_email'=>$_POST['business_email'],
				'call_time'=>$_POST['day'].' '.$_POST['time'].' '.$_POST['zone'],
				'leadimageone'=>$_POST['leadimageone'],

				'prefer_lang'=>$_POST['prefer_lang'],
				'other_lang'=>$_POST['other_lang'],
				'merchant_talk'=>$_POST['merchant_talk'],
				'merchant_interested'=>$_POST['merchant_interested'],

				'client_contract'=>$_POST['client_contract'],
				'client_contract_long'=>$_POST['client_contract_long'],
				'client_signup_today'=>$_POST['client_signup_today'],
				'client_mex_offer'=>$_POST['client_mex_offer'],
				'average_sales'=>$_POST['average_sales'],
				'contract_guarantee'=>$_POST['contract_guarantee'],
				
		);

		if(!$this->db->insert('soler_form',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['message'] = "Your lead submitted succesfully";
		echo json_encode($data);
	}

	function submitSolar(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('owner_house', 'Homeowner', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('electric_bill', 'Electric bill over $125 per month', 'trim|required|xss_clean');	

		$this->form_validation->set_rules('first_name', 'Owner First Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('last_name', 'Owner Last Name', 'trim|required|xss_clean');

	
		$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');	
		
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_email', 'Email', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('day', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('time', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zone', 'Date and time to reach', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('leadimageone', 'electric bill Pictures', 'trim|required|xss_clean');		

		$this->form_validation->set_rules('prefer_lang', 'Prefer language', 'trim|required|xss_clean');
		$this->form_validation->set_rules('solar_talk', 'Have you talked to the client about solar', 'trim|required|xss_clean');
		$this->form_validation->set_rules('solar_interested', 'Is the client interested in getting solar at his/her home', 'trim|required|xss_clean');

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else	$_POST['address2'] = '';

		if(isset($_POST['other_lang']) && !empty($_POST['other_lang'])){
		}else	$_POST['other_lang'] = '';



		$insertArr = array(
				'user_id'=>$userid,
				'industry'=>$_POST['industry'],
				'owner_house'=>$_POST['owner_house'],
				'electric_bill'=>$_POST['electric_bill'],

				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				
				'address1'=>$_POST['address1'],
				'address2'=>$_POST['address2'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state'],
				'zip'=>$_POST['zip'],
				'phone_no'=>$_POST['phone_no'],
				'business_email'=>$_POST['business_email'],
				'call_time'=>$_POST['day'].' '.$_POST['time'].' '.$_POST['zone'],
				'leadimageone'=>$_POST['leadimageone'],

				'prefer_lang'=>$_POST['prefer_lang'],
				'other_lang'=>$_POST['other_lang'],
				'solar_talk'=>$_POST['solar_talk'],
				'solar_interested'=>$_POST['solar_interested'],
				
		);

		if(!$this->db->insert('soler_form',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['message'] = "Your lead submitted succesfully";
		echo json_encode($data);
	}

	function submitRestaurant(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_name', 'Restaurant Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('first_name', 'Owner First Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('last_name', 'Owner Last Name', 'trim|required|xss_clean');

		$this->form_validation->set_rules('system_work', 'Has the restaurant owner seen our video of how the system works', 'trim|required|xss_clean');	

		$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean');	
		
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_email', 'Email', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('day', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('time', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zone', 'Date and time to reach', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('leadimageone', 'Pictures 1', 'trim|xss_clean');		

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['leadimageone']) && !empty($_POST['leadimageone'])){
		}else	$_POST['leadimageone'] = '';

		if(isset($_POST['address2']) && !empty($_POST['address2'])){
		}else	$_POST['address2'] = '';

		if(isset($_POST['leadimagetwo']) && !empty($_POST['leadimagetwo'])){
		}else	$_POST['leadimagetwo'] = '';

		if(isset($_POST['leadimagethree']) && !empty($_POST['leadimagethree'])){
		}else	$_POST['leadimagethree'] = '';

		if(isset($_POST['leadimagefour']) && !empty($_POST['leadimagefour'])){
		}else	$_POST['leadimagefour'] = '';

		if(isset($_POST['leadimagefive']) && !empty($_POST['leadimagefive'])){
		}else	$_POST['leadimagefive'] = '';


		$insertArr = array(
				'user_id'=>$userid,
				'industry'=>$_POST['industry'],
				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'system_work'=>$_POST['system_work'],
				'business_name'=>$_POST['business_name'],
				'address1'=>$_POST['address1'],
				'address2'=>$_POST['address2'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state'],
				'zip'=>$_POST['zip'],
				'phone_no'=>$_POST['phone_no'],
				'business_email'=>$_POST['business_email'],
				'call_time'=>$_POST['day'].' '.$_POST['time'].' '.$_POST['zone'],
				'leadimageone'=>$_POST['leadimageone'],
				'leadimagetwo'=>$_POST['leadimagetwo'],
				'leadimagethree'=>$_POST['leadimagethree'],
				'leadimagefour'=>$_POST['leadimagefour'],
				'leadimagefive'=>$_POST['leadimagefive'],
		);

		if(!$this->db->insert('soler_form',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['message'] = "Your lead submitted succesfully";
		echo json_encode($data);
	}
	function uploadimage(){
		header('Content-Type: application/json');
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			//$image = 'cashout'.$date.'.png';
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_leads'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_leads'.$date.'.png';
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
	            $data = array('massage'=>'');
					echo json_encode($data);
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	 
	    }else{ $data = array('massage'=>'');
					echo json_encode($data);
		}       
	}

	function submitPrinting(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userid = $this->session->userdata('user_id');
		if($userid == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_name', 'Business Name', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('phone_no', 'Phone Number', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('business_email', 'Email', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('day', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('time', 'Date and time to reach', 'trim|required|xss_clean');
		$this->form_validation->set_rules('zone', 'Date and time to reach', 'trim|required|xss_clean');			

		if ($this->form_validation->run() === false){
			$data = array("message"=> validation_errors());
			echo json_encode($data);
			return  ;
		}


		$insertArr = array(
				'user_id'=>$userid,
				'industry'=>$_POST['industry'],
				'first_name'=>$_POST['first_name'],
				'last_name'=>$_POST['last_name'],
				'business_name'=>$_POST['business_name'],
				'phone_no'=>$_POST['phone_no'],
				'business_email'=>$_POST['business_email'],
				'call_time'=>$_POST['day'].' '.$_POST['time'].' '.$_POST['zone'],
		);

		if(!$this->db->insert('soler_form',$insertArr)){
		    $data = array('message' => $this->db->_error_message());
			echo json_encode($data );
			return;
		}
		
		$data['message'] = "Your lead submitted succesfully";
		echo json_encode($data);
	}
}