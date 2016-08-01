<?php
/**
* 
*/
class Product_reseller extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}


	function buySimForBOCard(){

		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(!empty($_POST['qty']) && $_POST['qty'] > 0 ){
			$userID = $this->session->userdata('user_id');
			$productID = $_POST['p_id'];
			$level = $this->mdl_common->getLelevel($userID);
			$levelPrice = $this->mdl_common->getLevelSalePrice($level,$productID);
			$qty = $_POST['qty'];

			$shippingMethod = $_POST['shipping_method'];
			if($shippingMethod == null){
				$data = array('message'=>' Shipping method required.');
				echo json_encode($data);	
				return;
			}
			if($shippingMethod == 'FIRST CLASS'){
					$shippingCost = 3.97 - 1 + $qty;
			}else{
					$shippingCost = 9.97 ;
			}

			


			//$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
			$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					
					//$shippingCost = $value['shipping_price'] - 1 + $qty;
					$total_amt = $qty * $levelPrice + $shippingCost;
					$total_withoutshipp = $qty * $levelPrice;

					$this->load->library('authorize_net');

					$auth_net = array(
						'x_card_num'			=> trim($_POST['card_no']), // Visa
						'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
						'x_card_code'			=> trim($_POST['cvv_no']),
						'x_description'			=> 'Installation Kit, xonnova Network',
						'x_amount'				=> trim($total_amt),
						'x_first_name'			=> $this->session->userdata('first_name'),
						'x_last_name'			=> $this->session->userdata('last_name'),
						'x_address'				=> $this->session->userdata('address1').', '.$this->session->userdata('address2'),
						'x_city'				=> $this->session->userdata('city'),
						'x_state'				=> $this->session->userdata('state'),
						'x_zip'					=> $this->session->userdata('zip'),
						'x_country'				=> 'USA',
						'x_phone'				=> trim($this->session->userdata('contact_no')),
						'x_email'				=> $this->session->userdata('user_email'),
						'x_customer_ip'			=> $this->input->ip_address(),
					);

					$this->authorize_net->setData($auth_net);
					if($this->authorize_net->authorizeAndCapture()){
						$insertArr = array(
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'p_qty'=>$qty,
								'subtotal'=>$total_amt,
								'shipping_method'=>$shippingMethod,
								'card_no'=>$_POST['card_no'],
								'card_ccv'=>$_POST['cvv_no'],
								'card_expiry'=>trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
								'transaction_id'=>$this->authorize_net->getTransactionId(),
							);
						$this->db->insert('product_purchase_info',$insertArr);
						$last_id =  $this->db->insert_id();

						$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address1'),
								'address2'=>$this->session->userdata('address2'),
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
						$this->db->insert('user_purchase_info',$insertUser);

			

						$insertUserShipping = array(
							'user_id'=>$userID,
							'user_name'=>$this->session->userdata('user_name'),
							'ship_address'=>$this->session->userdata('address1'),
							'country'=>'usa',
							'city'=>$this->session->userdata('city'),
							'zip'=>$this->session->userdata('zip'),
							'type'=>'Order',
							'product'=>$productID,
							'quantity'=>$qty,
							'shipping_method'=>$shippingMethod,
						);
						$this->db->insert('shipping_management_table',$insertUserShipping);

						$this->getSponsorToSponsorQV($productID,$qty);
						$this->getProductSaleParentToParentBinary($productID,$qty);		

						$this->getSponsorToSponsorSelesBackoffice($this->session->userdata('sponsor_id'), $qty, $this->session->userdata('user_name'));
						
						$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	


						$data = array('messagee'=>'Your order has been submitted successfully. You will receive a notification email when your order is shipped. Transaction ID : '.$this->authorize_net->getTransactionId());
						echo json_encode($data);


					}else{
						$data = array('message'=>'Error ! '.$this->authorize_net->getError());
						echo json_encode($data);
					}
				}
			}else{
				$data = array('message'=>' No Product');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Qty Required !');
			echo json_encode($data);	
		}
	}


	function getSimListForStorestore(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_info where p_id = "107" ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function userPackage(){
		header('Content-Type: application/json');
		
		$packageId = $this->mdl_common->getPackageById($this->session->userdata('user_id'));
		//$contentData = $this->mdl_common->allSelects('SELECT package_name FROM package_info where package_id = '.$packageId);
		if($packageId == 5 || $packageId == 6){
			
			$data = 'Total System';
			
		}else{
			$data = 'Not Found';
		}
		echo json_encode($data);
	}



	function isBuyPromoPack(){
		header('Content-Type: application/json');
		$this->db->where('user_id',$this->session->userdata('user_id'));
		$rs2	=	$this->db->get('is_buy_promo_pack');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 == 0){
			echo json_encode('no');	
		}else{
			echo json_encode('yes');		
		}
	}

	function isBuyPromoPackCtr(){
		$this->db->where('user_id',$this->session->userdata('user_id'));
		$rs2	=	$this->db->get('is_buy_promo_pack');
		$UserInfo2	=	$rs2->num_rows();	
		if($UserInfo2 == 0){
			return 'no';
		}else{
			return 'yes';	
		}
	}


			


	function buyPromoPackForBackoffice(){

		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

	
		
		$packageId = $this->mdl_common->getPackageById($this->session->userdata('user_id'));
		// $contentData = $this->mdl_common->allSelects('SELECT package_name FROM package_info where package_id = '.$packageId);
		// if(isset($contentData) && !empty($contentData)){
		// 	foreach ($contentData as $key => $value) {
		// 		$p_name = $value['package_name'];
		// 	}
		if($packageId == 5 || $packageId == 6){
			$p_name = 'Total System';
		}else{
			$p_name = 'Not Found';
		}

		if($p_name != 'Total System'){
			$data = array('message'=>' Your Package is Not Total System !');
			echo json_encode($data);	
			return;
		}


		// $this->db->where('user_id',$this->session->userdata('user_id'));
		// $rs2	=	$this->db->get('promo_pack_user');
		// $UserInfo2	=	$rs2->num_rows();	
		// if($UserInfo2 == 0){
		// 		$data = array('message'=>' Your Package is Not Total System ! ');
		// 		echo json_encode($data);	
		// 		return;
		// }

		$isBuy = $this->isBuyPromoPackCtr();
		if($isBuy == 'yes'){
			$data = array('message'=>' only one Promo Pack!');
			echo json_encode($data);	
			return;
		}


		



		// if(!empty($_POST['qty']) && $_POST['qty'] > 0 ){
			$userID = $this->session->userdata('user_id');
			$productID = 106;//$_POST['p_id'];
			//$level = $this->mdl_common->getLelevel($userID);
			$levelPrice = 299;//$this->mdl_common->getLevelSalePrice($level,$productID);
			$qty = 1;//$_POST['qty'];
			$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
			//$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
			//if(isset($contentData) && !empty($contentData)){
				//foreach ($contentData as $value) {
					
					$shippingCost = 0;//$value['shipping_price'] - 1 + $qty;
					$total_amt = $qty * $levelPrice + $shippingCost;
					$total_withoutshipp = $qty * $levelPrice;
					
					if($userStoreCredit >= $total_amt){

						$insertUserpack = array(
								
								'user_id'=>$userID,
								
							);
						$this->db->insert('is_buy_promo_pack',$insertUserpack);
						
						$insertArr = array(
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'p_qty'=>$qty,
								'subtotal'=>$total_amt,
							);
						$this->db->insert('product_purchase_info',$insertArr);
						$last_id =  $this->db->insert_id();

						$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address1'),
								'address2'=>$this->session->userdata('address2'),
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
						$this->db->insert('user_purchase_info',$insertUser);

						$Arr = array(
							'user_id'=>$userID,
							'credit'=>$total_amt,
							'wallet_type'=>'2',
							'message'=>'Purchase From Store Promo Pack',
						);
						$this->db->insert('store_credit_report_info',$Arr);

						$insertUserShipping = array(
							'user_id'=>$userID,
							'user_name'=>$this->session->userdata('user_name'),
							'ship_address'=>$this->session->userdata('address1'),
							'country'=>'usa',
							'city'=>$this->session->userdata('city'),
							'zip'=>$this->session->userdata('zip'),
							'type'=>'Order',
							'product'=>$productID,
							'quantity'=>$qty,
						);
						$this->db->insert('shipping_management_table',$insertUserShipping);

						$this->getSponsorToSponsorQV($productID,$qty);
						//$this->getProductSaleParentToParentBinary($productID,$qty);		

						//$this->getSponsorToSponsorSelesBackoffice($this->session->userdata('sponsor_id'), $qty, $this->session->userdata('user_name'));
						$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	


						$data = array('message'=>'Your order has been submitted successfully. You will receive a notification email when your order is shipped.');
						echo json_encode($data);


					}else{
						$data = array('message'=>'Sorry, Your order can not be processed due to insufficient store credits.');
						echo json_encode($data);
					}
				// }
			// }else{
			// 	$data = array('message'=>' No Product');
			// 	echo json_encode($data);
			// }
		// }else{
		// 	$data = array('message'=>' Qty Required !');
		// 	echo json_encode($data);	
		// }
	}

	
function getSponsorToSponsorSelesBackoffice( $sponsor_id, $qty, $userName){
		if($sponsor_id == 0){
		return;
		}
		$this->getEnringInfo($sponsor_id, $qty/2, $userName);
	
		$sponsor1 = $this->mdl_common->getAllSponsor($sponsor_id);
		if($sponsor1 == 0){
		return;
		}
		$this->getEnringInfo($sponsor1, $qty/2, $userName);

		$sponsor2 = $this->mdl_common->getAllSponsor($sponsor1);
		if($sponsor2 == 0){
		return;
		}
		$this->getEnringInfo($sponsor2, $qty/2, $userName);

		$sponsor3 = $this->mdl_common->getAllSponsor($sponsor2);
		if($sponsor3 == 0){
		return;
		}
		$this->getEnringInfo($sponsor3, $qty/2, $userName);

		$sponsor4 = $this->mdl_common->getAllSponsor($sponsor3);
		if($sponsor4 == 0){
		return;
		}
		$this->getEnringInfo($sponsor4, $qty/2, $userName);

		$sponsor5 = $this->mdl_common->getAllSponsor($sponsor4);
		if($sponsor5 == 0){
		return;
		}
		$this->getEnringInfo($sponsor5, $qty/2, $userName);
	}
	


	function getlevelPrice(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$productID = 98;
		$level = $this->mdl_common->getLelevel($userID);
		$levelPrice = $this->mdl_common->getLevelSalePrice($level,$productID);
		echo json_encode($levelPrice);
	}


	

	function getonchangetotalprice($qty , $method){
		header('Content-Type: application/json');
		if($method == 'FIRST%20CLASS'){
				$shippingCost = 3.97 - 1 + $qty;
		}else{
				$shippingCost = 9.97 ;
		}

		$userID = $this->session->userdata('user_id');
		$productID = 98;
		$level = $this->mdl_common->getLelevel($userID);
		$levelPrice = $this->mdl_common->getLevelSalePrice($level,$productID);
		//$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
		//foreach ($contentData as $value) {
					
			//$shippingCost = $value['shipping_price'] - 1 + $qty;
			$total_amt = $qty * $levelPrice + $shippingCost;
		//}
		
		echo json_encode($total_amt);
	}


	function buySimForBackoffice(){

		$_POST = json_decode(file_get_contents("php://input"),true);
		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(!empty($_POST['qty']) && $_POST['qty'] > 0 ){
			$userID = $this->session->userdata('user_id');
			$productID = $_POST['p_id'];
			$level = $this->mdl_common->getLelevel($userID);
			$levelPrice = $this->mdl_common->getLevelSalePrice($level,$productID);
			$qty = $_POST['qty'];

			$shippingMethod = $_POST['shipping_method'];
			if($shippingMethod == null){
				$data = array('message'=>' Shipping method required.');
				echo json_encode($data);	
				return;
			}
			if($shippingMethod == 'FIRST CLASS'){
					$shippingCost = 3.97 - 1 + $qty;
			}else{
					$shippingCost = 9.97 ;
			}


			$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
			$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					
					//$shippingCost = $value['shipping_price'] - 1 + $qty;
					$total_amt = $qty * $levelPrice + $shippingCost;
					$total_withoutshipp = $qty * $levelPrice;
					
					if($userStoreCredit >= $total_amt){
						
						$insertArr = array(
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'p_qty'=>$qty,
								'subtotal'=>$total_amt,
								'shipping_method'=>$shippingMethod,
							);
						$this->db->insert('product_purchase_info',$insertArr);
						$last_id =  $this->db->insert_id();

						$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								//'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address1'),
								'address2'=>$this->session->userdata('address2'),
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
						$this->db->insert('user_purchase_info',$insertUser);

						$Arr = array(
							'user_id'=>$userID,
							'credit'=>$total_amt,
							'wallet_type'=>'2',
							'message'=>'Purchase From Store',
						);
						$this->db->insert('store_credit_report_info',$Arr);

						$insertUserShipping = array(
							'user_id'=>$userID,
							'user_name'=>$this->session->userdata('user_name'),
							'ship_address'=>$this->session->userdata('address1'),
							'country'=>'usa',
							'city'=>$this->session->userdata('city'),
							'zip'=>$this->session->userdata('zip'),
							'type'=>'Order',
							'product'=>$productID,
							'quantity'=>$qty,
							'shipping_method'=>$shippingMethod,
						);
						$this->db->insert('shipping_management_table',$insertUserShipping);

						$this->getSponsorToSponsorQV($productID,$qty);
						$this->getProductSaleParentToParentBinary($productID,$qty);		

						$this->getSponsorToSponsorSelesBackoffice($this->session->userdata('sponsor_id'), $qty, $this->session->userdata('user_name'));
						
						$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	


						$data = array('message'=>'Your order has been submitted successfully. You will receive a notification email when your order is shipped.');
						echo json_encode($data);


					}else{
						$data = array('message'=>'Sorry, Your order can not be processed due to insufficient store credits.');
						echo json_encode($data);
					}
				}
			}else{
				$data = array('message'=>' No Product');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Qty Required !');
			echo json_encode($data);	
		}
	}


	function getProductSaleParentToParentBinary($pid,$qty){
		$userChild = $this->session->userdata('user_id');
		$parent = $this->mdl_common->getAllParent($userChild);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$cur_user = $userChild;
			if($sponser > 0){				
				$binaryPoint1 = $this->mdl_common->getSaleBinary($pid);
				$binaryPoint = $binaryPoint1*$qty;
				
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point, pro_sales_binary, bonus from earning_info where user_id = '.$sponser);
							
				if(isset($selectearningtotal) && !empty($selectearningtotal)){
					foreach ($selectearningtotal as $total) {
						$totalSaleBinaryPoint = $total['pro_sales_binary'] + $binaryPoint;
						$totalBinaryPoint = $total['referral_binary_point'] + $binaryPoint;
						$updattotalarr = array(
							'pro_sales_binary'=>$totalSaleBinaryPoint,
							'referral_binary_point'=>$totalBinaryPoint
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
					}
				}else{
					$totalBinaryPoint = $binaryPoint;
					
					$updattotalarr = array(					
						'pro_sales_binary'=>$totalBinaryPoint
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$parent));
				}

				$insertArr = array(
					'parent_id'=>$sponser,
					'user_id'=>$cur_user,
					'sale_binary_point'=>$binaryPoint,
				);
				$this->db->insert('product_sale_binary',$insertArr);
				
				$insertArr = array(
					'parent_id'=>$sponser,
					'user_id'=>$cur_user,
					'referral_binary'=>$binaryPoint,
				);
				$this->db->insert('referrals_binary',$insertArr);
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$userChild = $this->mdl_common->getAllParent($cur_user);
		}
	}

	function getSponsorToSponsorQV($pid,$qty){
		$user = $this->session->userdata('user_id');
		$binaryPoint1 = $this->mdl_common->getSaleQV($pid);
		$binaryPoint = $binaryPoint1*$qty;
		$insertBinamry = array(
				'sponsor_id'=>$user,
				'user_id'=>$user,
				'qv_point'=>$binaryPoint
			);
		$this->db->insert('unilevel_binary_info',$insertBinamry);

		$parent = $this->mdl_common->getAllSponsor($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){	
				
				
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
	function storeCredit(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
		echo json_encode($userStoreCredit);
	}
	
	
	function getTotalActive(){
		header('Content-Type: application/json');
		$contentData = count($this->mdl_common->allSelects('SELECT * FROM activate_platform  where sim_status = "Approve" and user_id = '.$this->session->userdata('user_id')));
		echo json_encode($contentData);
	}

	function usernewOrderTab(){
		header('Content-Type: application/json');
		$contentData = count($this->mdl_common->allSelects('SELECT * FROM product_purchase_info where delivery_status = "Shipped" and  user_id = '.$this->session->userdata('user_id')));
		echo json_encode($contentData);
	}
	
	
	function getOrderStatusStore(){
		header('Content-Type: application/json');
		$userID = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_purchase_info where delivery_status = "Shipped" and user_id = '.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
		
	}
	
	function getResellerSimNo(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform_sim where user_id = '.$this->session->userdata('user_id'));
		
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	

	function getResellerActivation(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform where user_id = '.$this->session->userdata('user_id'));
		
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	


	function getResellerApprovePhone(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform where sim_status = "Approve" AND user_id = '.$this->session->userdata('user_id'));
		
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	
	function getResellerWaitingPhone(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM activate_platform where sim_status = "Waiting" AND user_id = '.$this->session->userdata('user_id'));
		
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	

	function getSimListForStore(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_info where p_id = "98" ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function buySimForStore2(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}
		if(!empty($_POST['qty']) && $_POST['qty'] > 0 ){
			$userID = $this->session->userdata('user_id');
			$productID = $_POST['p_id'];
			$qty = $_POST['qty'];
			$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
			$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$shippingCost = $value['shipping_price'];
					$total_amt = $qty * $value['store_price'] + $shippingCost;
					//$shippingCost = 0;
					$total_withoutshipp = $qty * $value['store_price'];
					//$total_amt = $qty * $value['store_price'];
					if($userStoreCredit >= $total_amt){
						// $userStoreData = $this->mdl_common->allSelects('SELECT * FROM   reseller_store where user_id = '.$_POST['p_id']);
						// foreach ($userStoreData as $userStoreValue) {
						// }
						$insertArr = array(
								'p_id'=>$productID,
								'user_id'=>$userID,
								'purchase_user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'p_qty'=>$qty,
								'subtotal'=>$total_amt,
							);
						$this->db->insert('product_purchase_info',$insertArr);
						$last_id =  $this->db->insert_id();

						$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address'),
								// 'address2'=>$address2,
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
						$this->db->insert('user_purchase_info',$insertUser);

						$Arr = array(
							'user_id'=>$userID,
							'credit'=>$total_amt,
							'wallet_type'=>'2',
							'message'=>'Purchase From Store',
						);
						$this->db->insert('store_credit_report_info',$Arr);

						$insertUserShipping = array(
							'user_id'=>$userID,
							'user_name'=>$this->session->userdata('user_name'),
							'ship_address'=>$this->session->userdata('address'),
							'country'=>'usa',
							'city'=>$this->session->userdata('city'),
							'zip'=>$this->session->userdata('zip'),
							'type'=>'Order',
							'product'=>$productID,
							'quantity'=>$qty,
						);
						$this->db->insert('shipping_management_table',$insertUserShipping);

						$this->getSponsorToSponsorSeles($this->session->userdata('refer_id'), $this->session->userdata('founder_id'), $qty, $this->session->userdata('user_name'));
						$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	


						$data = array('message'=>'Your order confirmed sucessfully!');
						echo json_encode($data);


					}else{
						$data = array('message'=>'Sorry, Your order can not be processed due to insufficient store credits.');
						echo json_encode($data);
					}
				}
			}else{
				$data = array('message'=>' No Product');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Qty Required !');
			echo json_encode($data);	
		}
	}
	function buySimForStore(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if($this->session->userdata('user_id') == null){
			$data = array('message'=>'Your session is time out please login again .');
			echo json_encode($data);	
			return;
		}

		if(isset($_POST['method'])&&!empty($_POST['method'])){
		}else{
			$data = array("message"=>"Payment Method Required !"); 
			echo json_encode($data);
			return  ;
		}

		if(!empty($_POST['qty']) && $_POST['qty'] > 0 ){
			$userID = $this->session->userdata('user_id');
			$productID = $_POST['p_id'];
			$qty = $_POST['qty'];
			$userStoreCredit = $this->getTotalStoreCredit($userID) - $this->getTotalDeductStoreCredit($userID);
			$contentData = $this->mdl_common->allSelects('SELECT * FROM  product_info where p_id = '.$productID);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$shippingCost = $value['shipping_price'];
					$total_amt = $qty * $value['store_price'] + $shippingCost;
					//$shippingCost = 0;
					$total_withoutshipp = $qty * $value['store_price'];
					//$total_amt = $qty * $value['store_price'];
					if($_POST['method'] == "CC"){
						if(isset($_POST['card_no'])&&!empty($_POST['card_no'])){
						}else{
							$data = array("message"=>"Card # Required !"); 
							echo json_encode($data);
							return  ;
						}
						if(isset($_POST['expiry_year'])&&!empty($_POST['expiry_year'])){
						}else{
							$data = array("message"=>"Expiry Year  Required !"); 
							echo json_encode($data);
							return  ;
						}
						if(isset($_POST['expiry_month'])&&!empty($_POST['expiry_month'])){
						}else{
							$data = array("message"=>"Expiry Month  Required !"); 
							echo json_encode($data);
							return  ;
						}
						if(isset($_POST['cvv_no'])&&!empty($_POST['cvv_no'])){
						}else{
							$data = array("message"=>"Cvv # Required !"); 
							echo json_encode($data);
							return  ;
						}
						$this->load->library('authorize_net_upgrade');

						$auth_net = array(
							'x_card_num'			=> trim($_POST['card_no']), // Visa
							'x_exp_date'			=> trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
							'x_card_code'			=> trim($_POST['cvv_no']),
							'x_description'			=> 'INSTALLATION KIT Reseller',
							'x_amount'				=> trim($total_amt),
							// 'x_first_name'			=> $value['first_name'],
							// 'x_last_name'			=> $value['last_name'],
							// 'x_address'				=> $value['address1'].''.$value['address2'],
							// 'x_city'				=> $value['city'],
							// 'x_state'				=> $value['state'],
							// 'x_zip'					=> $value['zip'],
							// 'x_country'				=> $value['country'],
							// 'x_phone'				=> trim($value['contact_no']),
							// 'x_email'				=> $value['user_email'],
							'x_customer_ip'			=> $this->input->ip_address(),
						);

						$this->authorize_net_upgrade->setData($auth_net);
						if($this->authorize_net_upgrade->authorizeAndCapture()){

							$insertArr = array(
									'p_id'=>$productID,
									'user_id'=>$userID,
									'purchase_user_id'=>$userID,
									'user_name'=>$this->session->userdata('user_name'),
									'p_qty'=>$qty,
									'subtotal'=>$total_amt,
									'transaction_id'=>$this->authorize_net_upgrade->getTransactionId(),
									'card_no'=>trim($_POST['card_no']),
									'card_expiry'=>trim($_POST['expiry_year']).'/'.trim($_POST['expiry_month']),
									'card_ccv'=>trim($_POST['cvv_no']),
								);
							$this->db->insert('product_purchase_info',$insertArr);
							$last_id =  $this->db->insert_id();
							$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address'),
								// 'address2'=>$address2,
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
							$this->db->insert('user_purchase_info',$insertUser);

							

							$insertUserShipping = array(
								'user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'ship_address'=>$this->session->userdata('address'),
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'type'=>'Order',
								'product'=>$productID,
								'quantity'=>$qty,
							);
							$this->db->insert('shipping_management_table',$insertUserShipping);

							$this->getSponsorToSponsorSeles($this->session->userdata('refer_id'), $this->session->userdata('founder_id'), $qty, $this->session->userdata('user_name'));
							$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	
								
							
								
							$data = array('message'=>'Your order confirmed sucessfully! Transaction ID : '.$this->authorize_net_upgrade->getTransactionId());
							echo json_encode($data);

						}else{
							$data = array('message'=>'Card Error ! '.$this->authorize_net_upgrade->getError());
							echo json_encode($data);
							return;
						}

					}else{	
						if($userStoreCredit >= $total_amt){
							$insertArr = array(
									'p_id'=>$productID,
									'user_id'=>$userID,
									'purchase_user_id'=>$userID,
									'user_name'=>$this->session->userdata('user_name'),
									'p_qty'=>$qty,
									'subtotal'=>$total_amt,
								);
							$this->db->insert('product_purchase_info',$insertArr);
							$last_id =  $this->db->insert_id();

							$Arr = array(
								'user_id'=>$userID,
								'credit'=>$total_amt,
								'wallet_type'=>'2',
								'message'=>'Purchase From Store',
							);
							$this->db->insert('store_credit_report_info',$Arr);

							$insertUser = array(
								'order_id'=>$last_id,
								'p_id'=>$productID,
								'user_id'=>$userID,
								'purchase_user_id'=>$userID,
								'address1'=>$this->session->userdata('address'),
								// 'address2'=>$address2,
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'state'=>$this->session->userdata('state'),
								'contact_no'=>$this->session->userdata('contact_no'),
								'user_name'=>$this->session->userdata('user_name'),
								'first_name'=>$this->session->userdata('first_name'),
								'last_name'=>$this->session->userdata('last_name'),
								'user_email'=>$this->session->userdata('user_email'),
							);
							$this->db->insert('user_purchase_info',$insertUser);

							

							$insertUserShipping = array(
								'user_id'=>$userID,
								'user_name'=>$this->session->userdata('user_name'),
								'ship_address'=>$this->session->userdata('address'),
								'country'=>'usa',
								'city'=>$this->session->userdata('city'),
								'zip'=>$this->session->userdata('zip'),
								'type'=>'Order',
								'product'=>$productID,
								'quantity'=>$qty,
							);
							$this->db->insert('shipping_management_table',$insertUserShipping);

							$this->getSponsorToSponsorSeles($this->session->userdata('refer_id'), $this->session->userdata('founder_id'), $qty, $this->session->userdata('user_name'));
							$this->send_user_email_on_purchase($last_id, $this->session->userdata('user_name'), $this->session->userdata('user_email'), $productID, $qty, $total_withoutshipp, $shippingCost, $total_amt);	
							
							$data = array('message'=>'Your order confirmed sucessfully!');
							echo json_encode($data);
						}else{
							$data = array('message'=>'Sorry, Your order can not be processed due to insufficient store credits.');
							echo json_encode($data);
							return;
						}
					}	
	
				}
			}else{
				$data = array('message'=>' No Product');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>' Qty Required !');
			echo json_encode($data);	
		}
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
				//'ref_id'=>$last_id,
				'type_id'=>'9',
				'description'=>'Refer INSTALLATION KIT '.$userName,
				'amount'=>$referralAmount,
				'current_balance'=>$this->mdl_common->getTotalBalance($sponser),
				//'message'=>"",
				//'e_d_b_u_date'=>$value['created_at'],
			);
		$this->db->insert('earning_details_by_user',$earning_details_by_user);
	}





	function getSponsorToSponsorSeles($refer_id, $founder_id, $qty, $userName){

		
		if($refer_id == $founder_id){
			//$this->getEnringInfo($refer_id, $qty, $userName);
			$this->getEnringInfo($founder_id, 2*$qty, $userName);	
		}else{
			$this->getEnringInfo($refer_id, $qty, $userName);
			$this->getEnringInfo($founder_id, $qty, $userName);
		}
	
		$sponsor1 = $this->mdl_common->getAllSponsor($founder_id);
		if($sponsor1 == 0){
		return;
		}
		$this->getEnringInfo($sponsor1, $qty/2, $userName);

		$sponsor2 = $this->mdl_common->getAllSponsor($sponsor1);
		if($sponsor2 == 0){
		return;
		}
		$this->getEnringInfo($sponsor2, $qty/2, $userName);

		$sponsor3 = $this->mdl_common->getAllSponsor($sponsor2);
		if($sponsor3 == 0){
		return;
		}
		$this->getEnringInfo($sponsor3, $qty/2, $userName);

		$sponsor4 = $this->mdl_common->getAllSponsor($sponsor3);
		if($sponsor4 == 0){
		return;
		}
		$this->getEnringInfo($sponsor4, $qty/2, $userName);
		
	}
	


	function getTotalStoreCredit($id){
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductStoreCredit($id){
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function send_user_email_on_purchase($order_id=null, $user_name=null, $user_email=null, $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('xonnova network Purchase Mail');
        
        $mail_body	=	$this->mailBody($order_id, $user_name, $product_id, $qty, $total, $shippingCost, $total_amt);
        $this->email->message($mail_body);

        $this->email->send();
    }

   function mailBody($order_id=null, $user_name=null,  $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null){
		$productName = $this->mdl_common->getProductName($product_id);		
		$mail_body = '
						<div>
						<h3>Order confirmation</h3>
						<h1 style="font-size:70px;">Thank you</h1>
						<p>Bellow are important detail about your order. Question? We are always here to help you. Simply contact our chat support at any time from your backoffice.</p>

						<p>Order number: "'.$order_id.'" </p>
						<p>Username: "'.$user_name.'"</p>

						<h4>Your recent order</h4>

						<table width="100%" cellspacing="0" cellpadding="10px"  height="100px" style="border:2px solid rgb(0,0,0);">
							<tbody>
								<tr style="background-color:#c0c0c0;" >
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										Product name
									</td>
									<td  align="center" style="border:0 1px 0 1px solid rgb(0,0,0);">
										Quantity
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" width="10%">
										
									</td>

									<td  align="center" style="border:0 0 1px 1px solid rgb(0,0,0);">
										Price
									</td>
									
								</tr>
								<tr>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);">
										'.$productName.'
									</td>
									<td  align="center" style="border:1px solid rgb(0,0,0);">
										'.$qty.'
									</td>
									<td  align="center" style="border-bottom:1px solid rgb(0,0,0);" >
										
									</td>

									<td  align="center" style="border:1px solid rgb(0,0,0);">
										$'.$total.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Subtotal:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$'.$total.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Shipping & Handling:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$'.$shippingCost.'
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5;">
									<td  align="right" colspan="2" >
										Tex:
									</td>
									<td  align="center" >
										
									</td>
									
									<td  align="center">
										$0.00
									</td>
									
								</tr>
								<tr style="background-color:#f5f5f5; ">
									<td  align="right" colspan="2"  style="border-top:1px solid rgb(0,0,0);">
										Order Total:
									</td>
									<td  align="center" style="border-top:1px solid rgb(0,0,0);">
										
									</td>
									
									<td  align="center" style="border-top:1px solid rgb(0,0,0);">
										<h2 style="color:#7db738; ">$'.$total_amt.'</h2>
									</td>
									
								</tr>
							</tbody>
						</table>
					</div>

					';
		
		return $mail_body;		
	}
	
	
	




	

	
	
}