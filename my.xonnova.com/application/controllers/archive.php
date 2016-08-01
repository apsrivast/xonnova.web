<?php
/**
* 
*/
class Archive extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}


	function getVoucherOrderFromActivation($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE order_no='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}


	function getVoucherFromActivation($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE shipping_no='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}


	function insertVoucher($where,$userID){
		$user_name = $this->mdl_common->getSIMusername($userID);
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_voucher_to_shipp WHERE shipp_id='.$where.' AND user_id='.$userID);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE sim_no="'.$value['sim_no'].'"'));
				if(empty($uniqueSimNo)){
					$insertSimArr = array(
						'user_id'=>$userID,
						'user_name'=>$user_name,
						'sim_no'=>$value['sim_no'],
						//'user_id'=>$userID,
					);
					$this->db->insert('activate_platform_voucher',$insertSimArr);					
				}
			}
		}else{
			
		}
	}


	function insertVoucherOrder($where,$userID, $user_name){
		//$user_name = $this->mdl_common->getSIMusername($userID);
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_voucher_to_shipp WHERE order_id='.$where.' AND user_id='.$userID);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE sim_no="'.$value['sim_no'].'"'));
				if(empty($uniqueSimNo)){
					$insertSimArr = array(
						'user_id'=>$userID,
						'user_name'=>$user_name,
						'sim_no'=>$value['sim_no'],
						//'user_id'=>$userID,
					);
					$this->db->insert('activate_platform_voucher',$insertSimArr);					
				}
			}
		}else{
			
		}
	}

	function addVoucher(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE sim_no="'.$_POST['si_no'].'"'));
		if(empty($uniqueSimNo)){
		}else{
			$data = array('err'=>'Sorry sim # exist');
			echo json_encode($data);
			return ;
		}


		if(!empty($_POST['si_no'])){
			$sim_no = $_POST['si_no'];
		}else{
			$data = array('err'=>'Sorry sim no is required');
			$sim_no = "";
		}

		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
		}
		if(!empty($_POST['id'])){
			$shipp_id = $_POST['id'];
		}else{
			$shipp_id = "";
		}
		$addSim = array(
			'user_id'=>$user_id,
			'shipp_id'=>$shipp_id,
			'sim_no'=>$sim_no,
		);
		if(!$this->db->insert('add_voucher_to_shipp',$addSim)){
			$data = array('err'=>$this->db->_error_message());
		}else{
			$last_id = $this->db->insert_id();
			$data = array('last_id'=>$last_id,'sim_no'=>$sim_no);
		}
		echo json_encode($data);
	}


	function getVoucher($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_voucher_to_shipp WHERE shipp_id='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}


	function deletePrevVoucher($sim_no){
		$this->db->delete('add_voucher_to_shipp',array('sim_no'=>$sim_no));
		$this->db->delete('activate_platform_voucher',array('sim_no'=>$sim_no));
		echo $sim_no; 
	}


	function deleteVoucher(){
		$sim_no = $_POST['sim_no'];
		$this->db->delete('add_voucher_to_shipp',array('a_s_t_s_id'=>$sim_no));
		$this->mdl_common->deleteSimFromVoucher($sim_no);
		echo $sim_no;
	}


	function addVoucherOrder(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_voucher WHERE sim_no="'.$_POST['si_no'].'"'));
		if(empty($uniqueSimNo)){
		}else{
			$data = array('err'=>'Sorry sim # exist');
			echo json_encode($data);
			return ;
		}


		if(!empty($_POST['si_no'])){
			$sim_no = $_POST['si_no'];
		}else{
			$data = array('err'=>'Sorry sim no is required');
			$sim_no = "";
		}

		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
		}
		if(!empty($_POST['purchase_id'])){
			$order_id = $_POST['purchase_id'];
		}else{
			$order_id = "";
		}
		$addSim = array(
			'user_id'=>$user_id,
			'order_id'=>$order_id,
			'sim_no'=>$sim_no,
		);
		if(!$this->db->insert('add_voucher_to_shipp',$addSim)){
			$data = array('err'=>$this->db->_error_message());
		}else{
			$last_id = $this->db->insert_id();
			$data = array('last_id'=>$last_id,'sim_no'=>$sim_no);
		}
		echo json_encode($data);
	}


	function getVoucherOrder($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_voucher_to_shipp WHERE order_id='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
	
	//to Deposit archive report
	function depositArchiveView(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*, d.user_name as reseller_name  FROM user_master as a RIGHT JOIN deposit_info as b on b.user_id=a.user_id  LEFT JOIN reseller_store as d on d.user_id=a.user_id WHERE b.deposit_status="Approve" AND b.deposit_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT a.* , b.*, d.user_name as reseller_name  FROM user_master AS a RIGHT JOIN deposit_info AS b ON b.user_id = a.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id WHERE b.deposit_status="Approve" ORDER BY b.deposit_created_at DESC');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}

	function getDepositImageById($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*,c.user_name, d.user_name as reseller_name  FROM deposit_info as a LEFT JOIN user_master as c on c.user_id=a.user_id LEFT JOIN reseller_store as d on d.user_id=a.user_id WHERE deposit_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function updateDepositStatus($id){
	  	header('Content-Type: application/json');
	  	$_POST = json_decode(file_get_contents("php://input"),true);
	  	$updateArr = array(
	   		'deposit_status'=>'Approve'
	  	);
	  	if((isset($_POST['user_id']) && !empty($_POST['user_id'])) && !empty($_POST['deposit_id']) && !empty($_POST['bank_amount']) && !empty($_POST['deposit_status']) && $_POST['deposit_status'] != "Approve"){
		   	if(!$this->db->update('deposit_info',$updateArr, array('deposit_id'=>$id))){
			    $data = array('message'=>'Deposit Not updated! Error..');
			    echo json_encode($data);    
		   	}else{
			     $Arr = array(
			      'user_id'=>$_POST['user_id'],
			      'admin_id'=>$this->session->userdata('user_id'),
			      'credit'=>$_POST['bank_amount'],
			      'wallet_type'=>'1',
			      'message'=>'Deposit Approve',
			     );
		    	$this->db->insert('store_credit_report_info',$Arr);
	    		$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$_POST['user_id']));
		    	
		    	if(empty($existUser) && $existUser == 0){
			     	$insertwallete = array(
				      	'user_id'=>$_POST['user_id'],
				      	'admin_id'=>$this->session->userdata('user_id'),
			     	);
		     		$this->db->insert('store_credit_report_user_map_info',$insertwallete);
		    	}

	    		$data = array('message'=>'Deposit approved succesfully.');
	    		echo json_encode($data);
	   		}
	  	}else{
	   		$data = array('message'=>'Error this Data is invalid!');
	   		echo json_encode($data);
	  	}
 	}
	//end
	function updateArchiveReport(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
			return false;
		}
		if(!empty($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = "";
			return false;
		}
		if(!empty($_POST['type'])){
			$type = $_POST['type'];
		}else{
			$type = "";
			return false;
		}
		if(!empty($_POST['archive_member_status'])){
			$archive_member_status = $_POST['archive_member_status'];
		}else{
			$archive_member_status = "";
			$data = array('err'=>'Shipping Status Field is required!');
			echo json_encode($data);
			return false;
		}
		if(!empty($_POST['shipping_code'])){
			$shipping_code = $_POST['shipping_code'];
		}else{
			$shipping_code = "";
			$data = array('err'=>'Shipping ID Field is required!');
			echo json_encode($data);
			return false;
		}
		if(!empty($_POST['shipe_via'])){
			$shipe_via = $_POST['shipe_via'];
		}else{
			$shipe_via = "";
			$data = array('err'=>'Shipping By Field is required!');
			echo json_encode($data);
			return false;
		}

		/*if(!empty($_POST['updated_at'])){
			$updated_at = $_POST['updated_at'];
		}else{
			$updated_at = "";
			return false;
		}*/

		if(!empty($_POST['shipp_date'])){
			$updated_at = $_POST['shipp_date'];
		}else{
			$updated_at = "";
			$data = array('err'=>'Shipping Date Field is required!');
			echo json_encode($data);
			return false;
		}
		if(!empty($_POST['comments'])){
			$shipping_comments = $_POST['comments'];
		}else{
			$shipping_comments = "";
		}

		$updateArr = array(
			'archive_member_status'=>$archive_member_status,
			'shipping_code'=>$shipping_code,
			'shipe_via'=>$shipe_via,
			'updated_at'=>$updated_at,
			'comments'=>$shipping_comments,
		);

		$delivery_status = $this->mdl_common->getShippingStatusFromShipping($id);

		if(!$this->db->update('shipping_management_table',$updateArr, array('id'=>$id))){
			$data = array('err'=>'Member status Not updated! Error..'.$this->db->_error_message());
			echo json_encode($data);							
		}else{	
			if($type == 'Registration'){
				$this->db->update('user_master',array('shipping_status'=>'approved'),array('user_id'=>$user_id));				
			}elseif($type == 'Upgrade'){
				$package_id = $this->mdl_common->getShipPackageID($id);
				$this->db->update('upgrade_user_details',array('shipping_status'=>'approved'),array('user_id'=>$_POST['user_id'],'package_id'=>$package_id));
			}else{

			}		
			
			$this->db->update('shipping_management_table',array('status'=>'shipped'),array('id'=>$id));
			$this->insertSim($id,$user_id);
			$this->insertVoucher($id,$user_id);
			$this->send_user_email($_POST['user_name'],$_POST['user_email'],$_POST['package_name'],$updated_at,$shipping_code);
			
			$count = 0 ;
			if($delivery_status == 'not shipped'){
				if(isset($_POST['no_of_voucher'])&&!empty($_POST['no_of_voucher'])){
					$list = $this->mdl_common->allSelects('SELECT * From activate_platform_voucher WHERE user_id = 0 LIMIT '.$_POST['no_of_voucher']);
					if(isset($list) && !empty($list)){
						foreach ($list as $key => $value) {
							$updatearr = array(							
													'user_id'=>$_POST['user_id'],
													'shipping_no'=>$id,
													'user_name'=>$_POST['user_name'],
													'sim_date'=>date("Y-m-d H:i:s"),	
												);						
							$this->db->update('activate_platform_voucher',$updatearr,array('sim_id'=>$value['sim_id']));
							$count ++ ;	
						}
					}
				}
			}


			$data = array('sucess'=>'Member Shipping  status updated succesfully.Total # of Vouchers '.$count);
			echo json_encode($data);
		}

	}
	
	public function send_user_email($user_name,$user_email,$packageId,$shipDate,$shipId) {
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('shipping@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);
        //$this->email->to('kaushalkumar.sharma@hotmail.com');

        $this->email->subject('xonnova Orders shipped');
        $html = $this->mdl_common->shippingMailBody($user_name,$packageId,$shipDate,$shipId);
        $this->email->message($html);

        $this->email->send();
    }
	/* function getUserEmail($user_name){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_name="'.$user_name.'"');
		if(!empty($contentData)){
			foreach($contentData as $value){
				return $value['user_email'];
			}
		}else{
			return false;
		}
	}
	
	function getPackageName($packageId){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE user_name="'.$user_name.'"');
		if(!empty($contentData)){
			foreach($contentData as $value){
				return $value['user_email'];
			}
		}else{
			return false;
		}
	} */
	function insertSim($where,$userID){
		$user_name = $this->mdl_common->getSIMusername($userID);
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_sim_to_shipp WHERE shipp_id='.$where.' AND user_id='.$userID);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_sim WHERE sim_no="'.$value['sim_no'].'"'));
				if(empty($uniqueSimNo)){
					$insertSimArr = array(
						'user_id'=>$userID,
						'user_name'=>$user_name,
						'sim_no'=>$value['sim_no'],
						//'user_id'=>$userID,
					);
					$this->db->insert('activate_platform_sim',$insertSimArr);					
				}
			}
		}else{
			
		}
	}

	function insertSimOrder($where,$userID, $user_name){
		//$user_name = $this->mdl_common->getSIMusername($userID);
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_sim_to_shipp WHERE order_id='.$where.' AND user_id='.$userID);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_sim WHERE sim_no="'.$value['sim_no'].'"'));
				if(empty($uniqueSimNo)){
					$insertSimArr = array(
						'user_id'=>$userID,
						'user_name'=>$user_name,
						'sim_no'=>$value['sim_no'],
						//'user_id'=>$userID,
					);
					$this->db->insert('activate_platform_sim',$insertSimArr);					
				}
			}
		}else{
			
		}
	}
	
	function addSim(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_sim WHERE sim_no="'.$_POST['sim_no'].'"'));
		if(empty($uniqueSimNo)){
		}else{
			$data = array('err'=>'Sorry sim # exist');
			echo json_encode($data);
			return ;
		}

		if(!empty($_POST['sim_no'])){
			$sim_no = $_POST['sim_no'];
		}else{
			$data = array('err'=>'Sorry sim no is required');
			$sim_no = "";
		}

		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
		}
		if(!empty($_POST['id'])){
			$shipp_id = $_POST['id'];
		}else{
			$shipp_id = "";
		}
		$addSim = array(
			'user_id'=>$user_id,
			'shipp_id'=>$shipp_id,
			'sim_no'=>$sim_no,
		);
		if(!$this->db->insert('add_sim_to_shipp',$addSim)){
			$data = array('err'=>$this->db->_error_message());
		}else{
			$last_id = $this->db->insert_id();
			$data = array('last_id'=>$last_id,'sim_no'=>$sim_no);
		}
		echo json_encode($data);
	}

	function addSimOrder(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$uniqueSimNo = count($this->mdl_common->allSelects('SELECT * FROM activate_platform_sim WHERE sim_no="'.$_POST['sim_no'].'"'));
		if(empty($uniqueSimNo)){
		}else{
			$data = array('err'=>'Sorry sim # exist');
			echo json_encode($data);
			return ;
		}
		
		if(!empty($_POST['sim_no'])){
			$sim_no = $_POST['sim_no'];
		}else{
			$data = array('err'=>'Sorry sim no is required');
			$sim_no = "";
		}

		if(!empty($_POST['user_id'])){
			$user_id = $_POST['user_id'];
		}else{
			$user_id = "";
		}
		if(!empty($_POST['purchase_id'])){
			$order_id = $_POST['purchase_id'];
		}else{
			$order_id = "";
		}
		$addSim = array(
			'user_id'=>$user_id,
			'order_id'=>$order_id,
			'sim_no'=>$sim_no,
		);
		if(!$this->db->insert('add_sim_to_shipp',$addSim)){
			$data = array('err'=>$this->db->_error_message());
		}else{
			$last_id = $this->db->insert_id();
			$data = array('last_id'=>$last_id,'sim_no'=>$sim_no);

			if($_POST['p_id'] == 108){
				$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher WHERE user_id = '.$user_id.' AND order_id = '.$order_id.' AND status = "Pending" LIMIT 1');
				if(isset($list) && !empty($list)){
					foreach ($list as $key => $value) {
						$updatearr = array(							
												'sim_no'=>$sim_no,
												'update_date'=>date("Y-m-d H:i:s"),	
												'status'=>'Approve',	
											);						
						$this->db->update('prepaid_voucher',$updatearr,array('prepaid_id'=>$value['prepaid_id']));
					}
				}
			}

		}
		echo json_encode($data);
	}

	

	function getSimOrder($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_sim_to_shipp WHERE order_id='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}
	
	function getSim($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM add_sim_to_shipp WHERE shipp_id='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			
		}
	}

	
	function deleteSimOrde($no){
		//$sim_no = $_POST['sim_no'];
		$this->db->delete('add_sim_to_shipp',array('a_s_t_s_id'=>$no));
		$this->mdl_common->deleteSimFromSim($no);
		
		echo $sim_no;
	}

	function deleteSim(){
		$sim_no = $_POST['sim_no'];
		$this->mdl_common->deleteSimFromSim($sim_no);
		$this->mdl_common->deleteSimFromPrePaidVoucher($sim_no);
		$this->db->delete('add_sim_to_shipp',array('a_s_t_s_id'=>$sim_no));
		echo $sim_no;
	}
	
	function deletePrevSim($sim_no){
		$this->db->delete('add_sim_to_shipp',array('sim_no'=>$sim_no));
		$this->db->delete('activate_platform_sim',array('sim_no'=>$sim_no));
		$list = $this->mdl_common->allSelects('SELECT * From prepaid_voucher WHERE  sim_no = '.$sim_no);
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$updatearr = array(							
										'sim_no'=>'',
										'update_date'=>date("Y-m-d H:i:s"),	
										'status'=>'Pending',	
									);						
				$this->db->update('prepaid_voucher',$updatearr,array('prepaid_id'=>$value['prepaid_id']));
			}
		}
		echo $sim_no; 
	}
	
	function archiveReportEditView($where){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM shipping_management_table as a RIGHT JOIN country_info as b on b.c_code=a.country RIGHT JOIN package_info as c on c.package_id=a.shipping_package_id RIGHT JOIN user_master as d on d.user_id=a.user_id WHERE  a.id='.$where);
		if(isset($contentData) && !empty($contentData) && !empty($where)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			echo "OK";
		}
	}
	
	function archiveReportView(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			//$contentData = $this->mdl_common->allSelects("SELECT a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE a.type = 'Upgrade' AND a.shipping_show_status='1' AND `updated_at` BETWEEN '".$from."' AND '".$to."' GROUP BY a.user_id ORDER BY a.shipping_package_id DESC");
			//$contentData = $this->mdl_common->allSelects("SELECT a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE a.shipping_package_id >2 AND a.shipping_show_status='1' AND `updated_at` BETWEEN '".$from."' AND '".$to."' GROUP BY a.user_id ORDER BY a.shipping_package_id DESC");
			$contentData = $this->mdl_common->allSelects("SELECT a . * , b . * , c . *
															FROM shipping_management_table a
															INNER JOIN (
															SELECT user_id, MAX( shipping_package_id ) AS MaxPkg
															FROM shipping_management_table
															GROUP BY user_id
															)groupedtt ON a.user_id = groupedtt.user_id
															AND a.shipping_package_id = groupedtt.MaxPkg
															LEFT JOIN country_info AS b ON b.c_code = a.country
															LEFT JOIN package_info AS c ON c.package_id = a.shipping_package_id
															WHERE a.shipping_package_id >2
															AND a.`archive_member_status` = 'not shipped'
															AND a.`shipping_show_status` = '1'
															AND a.`updated_at` BETWEEN '".$from."' AND '".$to."' GROUP BY a.user_id ORDER BY a.shipping_package_id DESC");
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			//$contentData = $this->mdl_common->allSelects('SELECT  a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE type = "Upgrade" AND a.shipping_show_status="1" AND a.archive_member_status ="not shipped" ORDER BY a.created_at DESC');
			$contentData = $this->mdl_common->allSelects('SELECT a . * , b . * , c . *
															FROM shipping_management_table a
															INNER JOIN (

															SELECT user_id, MAX( shipping_package_id ) AS MaxPkg
															FROM shipping_management_table
															GROUP BY user_id
															)groupedtt ON a.user_id = groupedtt.user_id
															AND a.shipping_package_id = groupedtt.MaxPkg
															LEFT JOIN country_info AS b ON b.c_code = a.country
															LEFT JOIN package_info AS c ON c.package_id = a.shipping_package_id
															WHERE a.shipping_package_id >2
															AND a.`archive_member_status` = "not shipped"
															AND a.`shipping_show_status` = "1"
															GROUP BY `user_id`');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}
	
	function memberShippingArchiveReportView(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects("SELECT a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE shipping_package_id >2 AND a.shipping_show_status='1' AND a.archive_member_status ='shipped' AND  `updated_at` BETWEEN '".$from."' AND '".$to."' GROUP BY a.user_id ORDER BY a.shipping_package_id DESC");
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT  a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE shipping_package_id >2 AND a.shipping_show_status="1" AND a.archive_member_status ="shipped" ORDER BY a.created_at DESC');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}

	function getUserPackageShippingStatus($userID=null,$arvId=null){	
		$currentPackage = $this->getPackageIDFromArchID($userID,$arvId);

		$contentData = $this->mdl_common->allSelects('SELECT  a.*, c.* FROM shipping_management_table as a LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE type = "Upgrade" AND a.shipping_show_status="1" AND a.user_id='.$userID.' AND a.shipping_package_id < '.$currentPackage);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;				
			}
			echo json_encode($arr);
		}else{
			$data = array('err'=>'Sorry... Not found previous package!');
			echo json_encode($data);
		}
	}

	function getPackageIDFromArchID($userID,$where){
		if(!empty($userID) && !empty($where)){
	    	$query = "SELECT shipping_package_id FROM shipping_management_table WHERE user_id='".$userID."' AND id  = ".$where;
			$result = $this->db->query($query);
			$data = $result->result_array();
			if(isset($data) && !empty($data)){
				foreach ($data as $key => $value) {
					return $value['shipping_package_id'];
				}
			}else{
				return 0;
			}    		
    	}
	}
	function archiveReportView1(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id WHERE  WHERE type = "Upgrade" AND a.shipping_show_status="1" AND a.updated_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.* FROM shipping_management_table as a LEFT JOIN country_info as b on b.c_code=a.country LEFT JOIN package_info as c on c.package_id=a.shipping_package_id  WHERE type = "Upgrade" AND a.shipping_show_status="1"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}

	function productOrderSummary(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name, f.user_name as reseller_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id  LEFT JOIN store_user_info as e on e.id=b.purchase_user_id LEFT JOIN reseller_store as f on f.user_id=a.user_id WHERE a.purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.product_name, e.u_name, f.user_name as reseller_name FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id  LEFT JOIN store_user_info as e on e.id=b.purchase_user_id LEFT JOIN reseller_store as f on f.user_id=a.user_id ORDER BY a.purchase_at DESC');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}

	function productOrderSummaryView($id){
		$getData = $this->mdl_common->allSelects('SELECT a.*, b.*,c.user_name as siteName, d.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id LEFT JOIN user_master as c on c.user_id=a.user_id  LEFT JOIN product_info as d on d.p_id=a.p_id WHERE a.purchase_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function updateOrderStatus(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(!empty($_POST['delivery_status'])){
			$delivery_status = $_POST['delivery_status'];
		}else{
			$data = array('message'=>'Delivery Status Field must be Selected!');
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['shipped_via'])){
			$shipped_via = $_POST['shipped_via'];
		}else{
			$data = array('message'=>'Shipping by can not be empty!');
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['tracking_id'])){
			$tracking_id = $_POST['tracking_id'];
		}else{
			$data = array('message'=>'Tracking ID can not be empty!');
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['shipping_date'])){
			$shipDate = $_POST['shipping_date'];
		}else{
			$data = array('message'=>'Shipping Date cannot be empty!');
			echo json_encode($data);
			return false;
		}

		$updateArr = array(
			'delivery_status'=>$_POST['delivery_status'],
			'shipped_via'=>$_POST['shipped_via'],
			'tracking_id'=>$_POST['tracking_id'],
			'shipping_date'=>$_POST['shipping_date'],
		);

		$delivery_status = $this->mdl_common->getShippingStatusFromProduct($_POST['purchase_id']);

		if(!$this->db->update('product_purchase_info',$updateArr, array('purchase_id'=>$_POST['purchase_id']))){
			$data = array('message'=>'Order status Not updated! Error..');
			echo json_encode($data);
		}else{
			$this->insertSimOrder($_POST['purchase_id'],$_POST['user_id'],$_POST['user_name']);
			$this->insertVoucherOrder($_POST['purchase_id'],$_POST['user_id'],$_POST['user_name']);

			$count = 0 ;
			if($delivery_status == 'Not Shipped' || $delivery_status == 'Processing'){
				if(isset($_POST['no_of_voucher'])&&!empty($_POST['no_of_voucher'])){
					$list = $this->mdl_common->allSelects('SELECT * From activate_platform_voucher WHERE user_id = 0 LIMIT '.$_POST['no_of_voucher']);
					if(isset($list) && !empty($list)){
						foreach ($list as $key => $value) {
							$updatearr = array(							
													'user_id'=>$_POST['user_id'],
													'order_no'=>$_POST['purchase_id'],
													'user_name'=>$_POST['user_name'],
													'sim_date'=>date("Y-m-d H:i:s"),	
												);						
							$this->db->update('activate_platform_voucher',$updatearr,array('sim_id'=>$value['sim_id']));
							$count ++ ;	
						}
					}
				}
			}


			$data = array('message'=>'Order status updated succesfully. Total # of Vouchers '.$count);

			//$data = array('message'=>'Order status updated succesfully.');
			echo json_encode($data);
		}
	}
	function getNewMemberSummary(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN new_member_status_info as b on b.user_id=a.user_id RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as d on d.package_id=a.package WHERE a.user_type="user" AND a.shipping_status="approved" AND b.shipping_create_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN new_member_status_info as b on b.user_id=a.user_id RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as d on d.package_id=a.package WHERE a.user_type="user" AND a.shipping_status="approved"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}
	}

	function getNewMemberSummaryByID($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.*, c.*, d.* FROM user_master as a RIGHT JOIN new_member_status_info as b on b.user_id=a.user_id RIGHT JOIN country_info as c on c.c_code=a.country RIGHT JOIN package_info as d on d.package_id=a.package WHERE a.user_type="user" AND a.shipping_status="approved" AND a.user_id='.$id);
		if(isset($contentData) && !empty($contentData) && !empty($id)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function updateNewMemberSummary(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['shipping_comments'])){
			$shipmessage = $_POST['shipping_comments'];
		}else{
			$shipmessage ="";
		}

		if(!empty($_POST['shipping_status'])){
			$status = $_POST['shipping_status'];
		}else{
			$status ="";
		}

		if(!empty($_POST['s_id'])){
			$s_id = $_POST['s_id'];

		}else{
			$s_id = "";
		}

		if(!empty($_POST['address1'])){
			$address1 = $_POST['address1'];

		}else{
			$address1 = "";
		}

		if(!empty($_POST['s_id']) && !empty($_POST['user_id']) && !empty($_POST['address1'])){
			$address = 'Address : '.$_POST['address1'].', '.$_POST['address2'].', zip-code : '.$_POST['zip'].', Contact-no. : '.$_POST['contact_no'].', Country : '.$_POST['country_name'].', State : '.$_POST['state'].', City : '.$_POST['city'];
			
			$insertShipping = array(
				'user_id'=>$_POST['user_id'],
				'shipping_id'=>$_POST['shipping_id'],
				'shipping_by'=>$_POST['shipping_by'],
				'shipping_comments'=>$shipmessage,
				'shipping_address'=>$address, 
				'shipping_status'=>$status,
				'shipping_date'=>$_POST['shipping_date']
			);
			$this->db->update('new_member_status_info',$insertShipping,array('s_id'=>$s_id));
			/*if($status != 2 ){
				$shipping_status = "not approved";
				$this->db->update('user_master',array('shipping_status'=>$shipping_status),array('user_id'=>$_POST['user_id']));
			}else{
				$shipping_status = "approved";
				$this->db->update('user_master',array('shipping_status'=>$shipping_status),array('user_id'=>$_POST['user_id']));
			}*/
			
			$data = array('message'=>'This user : '.$_POST['user_name'].' Product Shipped Status updated Successfully.');
			echo json_encode($data);
			
		}else{
			$data = array('message'=>'This is Invalid User!');
			echo json_encode($data);
		}
	}


	function upgradeUserList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT  DISTINCT  a.*, b.*, c.*, d.*, e.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id RIGHT JOIN upgrade_user_details as c on c.user_id=a.user_id LEFT JOIN package_info as d on d.package_id=c.package_id LEFT JOIN level_configuration as e on e.l_conf_id=b.level WHERE c.shipping_status="approved" AND c.upgrade_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{

			}
		}else{
			$getPackage = $this->mdl_common->allSelects('SELECT  DISTINCT  a.*, b.*, c.*, d.*, e.* From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id RIGHT JOIN upgrade_user_details as c on c.user_id=a.user_id LEFT JOIN package_info as d on d.package_id=c.package_id LEFT JOIN level_configuration as e on e.l_conf_id=b.level WHERE c.shipping_status="approved"');
			if(isset($getPackage) && !empty($getPackage)){
				foreach ($getPackage as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);			
			}else{

			}
		}
	}

	function getUpgradeListById($id=null){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.*,c.*,d.*,e.* FROM user_master as a Right JOIN upgrade_user_details as b on b.user_id=a.user_id Right join package_info as c on c.package_id=b.package_id right join country_info as d on d.c_code=a.country Right join new_member_status_info as e on e.user_id=b.user_id Where b.shipping_status="approved" AND b.upgrade_id='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function updateUpgradeArchiveReport(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['shipping_comments'])){
			$shipmessage = $_POST['shipping_comments'];
		}else{
			$shipmessage ="";
		}

		if(!empty($_POST['s_id'])){
			$s_id = $_POST['s_id'];

		}else{
			$s_id = "";
		}

		if(!empty($_POST['shipping_status'])){
			$status = $_POST['shipping_status'];
		}else{
			$status ="";
		}
		if(!empty($s_id) && !empty($_POST['user_id']) && !empty($_POST['address1']) && !empty($_POST['upgrade_id'])){
			$address = 'Address : '.$_POST['address1'].', '.$_POST['address2'].', zip-code : '.$_POST['zip'].', Contact-no. : '.$_POST['contact_no'].', Country : '.$_POST['country_name'].', State : '.$_POST['state'].', City : '.$_POST['city'];
			$insertShipping = array(
				'user_id'=>$_POST['user_id'],
				'shipping_id'=>$_POST['shipping_id'],
				'shipping_by'=>$_POST['shipping_by'],
				'shipping_comments'=>$shipmessage,
				'shipping_address'=>$address, 
				'shipping_status'=>$status,
				'shipping_date'=>$_POST['shipping_date']
			);
			$this->db->update('new_member_status_info',$insertShipping,array('s_id'=>$s_id));

			//$this->db->update('upgrade_user_details',array('shipping_status'=>'approved'),array('upgrade_id'=>$_POST['upgrade_id']));
			
			$data = array('message'=>'This user : '.$_POST['user_name'].' Product Shipped Updated Sucessfully Successfully.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'This is Invalid User!');
			echo json_encode($data);
		}
	}

	function insertAllUser(){
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master  WHERE user_type="user"');
		$i=0;
		foreach ($contentData as  $value) {
		    if($value['shipping_status'] !=null && $value['shipping_status']=='approved'){
		    	$ship = 'shipped';
		    	$insertShippingStatus = array(
			      'user_id'=>$value['user_id'],
			      'user_name'=>$value['user_name'],
			      'ship_address'=>$value['address1'].' ' .$value['address2'],
			      'country'=>$value['country'],
			      'state'=>$value['state'],
			      'city'=>$value['city'],
			      'contact_no'=>$value['contact_no'],
			      'zip'=>$value['zip'],
			      'type'=>'Registration',
			      'shipping_package_id'=>$value['package'],
			      'archive_member_status'=>$ship,
			      'status'=>$ship,
			    );
			    $this->db->insert('shipping_management_table',$insertShippingStatus);
		    }else{
		    	$ship = 'not shipped';
		    	$insertShippingStatus = array(
			      'user_id'=>$value['user_id'],
			      'user_name'=>$value['user_name'],
			      'ship_address'=>$value['address1'].' ' .$value['address2'],
			      'country'=>$value['country'],
			      'state'=>$value['state'],
			      'city'=>$value['city'],
			      'zip'=>$value['zip'],
			      'type'=>'Registration',
			      'shipping_package_id'=>$value['package'],
			      'contact_no'=>$value['contact_no'],
			      'archive_member_status'=>$ship,
			      'status'=>$ship,
			    );
			    $this->db->insert('shipping_management_table',$insertShippingStatus);
		    }
		    $i++;
		    echo $i.'<br>';
	   	}	   
	}

	function updateShippingData(){
   		$contentData = $this->mdl_common->allSelects('SELECT * FROM  new_member_status_info');
   		$i=0;
   		foreach ($contentData as  $value) {
   			$insertShippingStatus = array(
			  'shipping_code'=>$value['shipping_id'],
			  'shipe_via'=>$value['shipping_by'],
			  'updated_at'=>$value['shipping_date'],
			  'comments'=>$value['shipping_comments'],
		    );
		    $this->db->update('shipping_management_table',$insertShippingStatus,array('user_id'=>$value['user_id']));
   			$i++;
		    echo $i.'<br>';
   		}
   	}
	
	function updateShippingData1(){
   		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM  new_member_status_info as a RIGHT JOIN upgrade_user_details as b on b.user_id=a.user_id  WHERE b.shipping_status="approved"');
   		$i=0;
   		foreach ($contentData as  $value) {
   			$insertShippingStatus = array(
			  'shipping_code'=>$value['shipping_id'],
			  'shipping_package_id'=>$value['package_id'],
			  'shipe_via'=>$value['shipping_by'],
			  'updated_at'=>$value['shipping_date'],
			  'comments'=>$value['shipping_comments'],
			  'archive_member_status'=>'Shipped',
			  'status'=>'Shipped',
		    );
		    $this->db->update('shipping_management_table',$insertShippingStatus,array('user_id'=>$value['user_id'],'type'=>'Upgrade'));
   			$i++;
		    echo $i.'<br>';
   		}
   	}
	
   	function insertUpgrade(){
   		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.* FROM user_master as a RIGHT JOIN upgrade_user_details as b on b.user_id=a.user_id');
   		$i=0;
		foreach ($contentData as  $value) {
		    if($value['shipping_status'] !=null && $value['shipping_status']=='approved'){
		    	$ship = 'shipped';
		    	$insertShippingStatus = array(
			      'user_id'=>$value['user_id'],
			      'user_name'=>$value['user_name'],
			      'ship_address'=>$value['address1'].' ' .$value['address2'],
			      'country'=>$value['country'],
			      'state'=>$value['state'],
			      'city'=>$value['city'],
			      'contact_no'=>$value['contact_no'],
			      'zip'=>$value['zip'],
			      'type'=>'Upgrade',
			      'shipping_package_id'=>$value['package'],
			      /*'archive_member_status'=>$ship,
			      'status'=>$ship,
			       'shipping_code'=>$value['shipping_id'],
				  'shipe_via'=>$value['shipping_by'],
				  'updated_at'=>$value['shipping_date'],
				  'comments'=>$value['shipping_comments'],*/
			    );
			    $this->db->insert('shipping_management_table',$insertShippingStatus);
		    }else{
		    	$ship = 'not shipped';
		    	$insertShippingStatus = array(
			      'user_id'=>$value['user_id'],
			      'user_name'=>$value['user_name'],
			      'ship_address'=>$value['address1'].' ' .$value['address2'],
			      'country'=>$value['country'],
			      'state'=>$value['state'],
			      'city'=>$value['city'],
			      'zip'=>$value['zip'],
			      'type'=>'Upgrade',
			      'shipping_package_id'=>$value['package'],
			      'contact_no'=>$value['contact_no'],
			      /*'archive_member_status'=>$ship,
			      'status'=>$ship,*/
			    );
			    $this->db->insert('shipping_management_table',$insertShippingStatus);
		    }
		    $i++;
		    echo $i.'<br>';
	   	}	  

   	}
}