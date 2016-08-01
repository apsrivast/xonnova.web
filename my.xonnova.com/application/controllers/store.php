<?php
/**
* 
*/
class Store extends CI_Controller
{
	
	function __construct() {
		parent::__construct();
		header('Content-Type: application/json');
	}

	function index(){
		echo $this->session->userdata('country');
	}

	function getProduct(){
		$userID = $this->session->userdata('user_id');
		$level = $this->mdl_common->getLelevel($userID);

		$getPackage = $this->mdl_common->allSelects('SELECT * From product_info');
		foreach ($getPackage as $key => $value) {
			$levelPrice = $this->mdl_common->getLevelSalePrice($level,$value['p_id']);
			if(!empty($levelPrice)){
				$value['level_price'] = $levelPrice;				
			}else{
				$value['level_price'] = $value['us_product_price'];
			}

			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function getProductById($id){
		$userID = $this->session->userdata('user_id');
		$level = $this->mdl_common->getLelevel($userID);
		$totalCredit = $this->getTotalWallet($userID) - $this->getTotalDeductWallet($userID);
		$getPackage = $this->mdl_common->allSelects('SELECT * From product_info WHERE p_id='.$id);
		foreach ($getPackage as $key => $value) {
			$levelPrice = $this->mdl_common->getLevelSalePrice($level,$value['p_id']);
			if(!empty($levelPrice)){
				$value['level_price'] = $levelPrice;				
			}else{
				$value['level_price'] = $value['us_product_price'];
			}
			$value['store_credit'] = $totalCredit;
			$arr[] = $value;
		}
		echo json_encode($arr);
	}

	function buyProductBycard(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userID = $this->session->userdata('user_id');
		$userName = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$contact = $this->session->userdata('contact_no');
		$firstName = $this->session->userdata('first_name');
		$lastName = $this->session->userdata('last_name');
		$total_amt = 0;
		$shippingCost = 0;
		$qty = 1;
		if(!empty($_POST['country'])){
			$country = $_POST['country'];
		}else{
			$data = array("err"=>"Country is required!");
			echo json_encode($data);
			return false;
		}
		if(!empty($_POST['address1'])){
			$address1 = $_POST['address1'];
		}else{
			$data = array("err"=>"Address is required!");
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['address2'])){
			$address2 = $_POST['address2'];
		}else{
			$address2 = " ";
		}

		if(!empty($_POST['city'])){
			$city = $_POST['city'];
		}else{
			$data = array("err"=>"City is required!");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['state'])){
			$state = $_POST['state'];
		}else{
			$data = array("err"=>"State is required!");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['zip'])){
			$zip = $_POST['zip'];
		}else{
			$data = array("err"=>"Zip is required!");
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['shipping_price'])){
			$shippingCost = $_POST['shipping_price'];
		}

		if(!empty($_POST['level_price'])){
			$level_price = $_POST['level_price'];
			$total_amt =  $_POST['level_price'] * $qty;

			$proPrice = $total_amt + $shippingCost;
		}else{
			$data = array("err"=>"Sorry! you don't have enough Store credit to by this product.");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['us_product_price'])){
			$us_product_price = $_POST['us_product_price'];
		}else{
			$data= array("err"=>"Sorry you can't buy this product, contact admin !");
			echo json_encode($data);
			return false;
		}
		if(isset($_POST['name_on_card']) && !empty($_POST['name_on_card'])){
			$name_on_card = $_POST['name_on_card'];
		}else{
			$data = array("err"=>"Name on Card field is required !");
			echo json_encode($data);
			return  false;
		}
		if(isset($_POST['card_no']) && !empty($_POST['card_no'])){
			$card_no = $_POST['card_no'];
		}else{
			$data = array("err"=>"Card # field is required !");
			echo json_encode($data);
			return  false;
		}
		if(isset($_POST['expiry_year']) && !empty($_POST['expiry_year'])){
			$expiry_year = $_POST['expiry_year'];
		}else{
			$data = array("err"=>"Expiry Year field is required !");
			echo json_encode($data);
			return  false;
		}
		if(isset($_POST['expiry_month']) && !empty($_POST['expiry_month'])){
			$expiry_month = $_POST['expiry_month'];
		}else{
			$data = array("err"=>"Expiry Month field is required !");
			echo json_encode($data);
			return  false;
		}
		if(isset($_POST['cvv_no']) && !empty($_POST['cvv_no'])){
			$cvv_no = $_POST['cvv_no'];
		}else{
			$data = array("err"=>"CVV # field is required !");
			echo json_encode($data);
			return  false;
		}
		if(isset($_POST['billing_zip']) && !empty($_POST['billing_zip'])){
			$billing_zip = $_POST['billing_zip'];
		}else{
			$data = array("err"=>"Billing Zip field is required !");
			echo json_encode($data);
			return  false;
		}

		$stripeValue = $this->mdl_common->getStripeValue();
		if($stripeValue == 2){
			//AIM payment Method
			$this->load->library('authorize_net');

			$auth_net = array(
				'x_card_num'			=> trim($card_no), // Visa
				'x_exp_date'			=> trim($expiry_year).'/'.trim($expiry_month),
				'x_card_code'			=> trim($cvv_no),
				'x_description'			=> 'Peoduct Sale',
				'x_amount'				=> trim($proPrice),
				'x_first_name'			=> $firstName,
				'x_last_name'			=> $lastName,
				'x_address'				=> $address1.''.$address2,
				'x_city'				=> $city,
				'x_state'				=> $state,
				'x_zip'					=> $zip,
				'x_country'				=> $country,
				'x_phone'				=> trim($contact),
				'x_email'				=> $email,
				'x_customer_ip'			=> $this->input->ip_address(),
			);

			$this->authorize_net->setData($auth_net);
			if($this->authorize_net->authorizeAndCapture()){
				$insertArr = array(
					'p_id'=>$_POST['p_id'],
					'user_id'=>$userID,
					'purchase_user_id'=>$userID,
					'user_name'=>$userName,
					'p_qty'=>$qty,
					'subtotal'=>$proPrice,
					'name_on_card'=>$name_on_card,
					'card_no'=>$card_no,
					'card_expiry'=> $expiry_year.'/'.$expiry_month,
					'card_ccv'=>$cvv_no,
					'transaction_id'=>$this->authorize_net->getTransactionId(),
				);
				$this->db->insert('product_purchase_info',$insertArr);
				$last_id =  $this->db->insert_id();

				$insertUser = array(
						'order_id'=>$last_id,
						'p_id'=>$_POST['p_id'],
						'user_id'=>$userID,
						'purchase_user_id'=>$userID,
						'address1'=>$address1,
						'address2'=>$address2,
						'country'=>$country,
						'city'=>$city,
						'state'=>$state,
						'zip'=>$zip,
						'contact_no'=>$contact,
						'user_name'=>$userName,
						'first_name'=>$firstName,
						'last_name'=>$lastName,
						'user_email'=>$email,
					);
				
				$this->db->insert('user_purchase_info',$insertUser);
				$insertUser = array(
					'user_name'=>$userName,
					'ship_address'=>$address1.' '.$address2,
					'country'=>$country,
					'city'=>$city,
					'zip'=>$zip,
					'type'=>'Order',
					'product'=>$_POST['p_id'],
					'quantity'=>$qty,
				);
				$this->db->insert('shipping_management_table',$insertUser);

				$this->getSponsorToSponsorQV($_POST['p_id'],$qty);
				$this->getProductSaleParentToParentBinary($_POST['p_id'],$qty);
				$this->getProductSaleBonus($_POST['p_id'],$qty);
				$this->send_user_email_on_purchase($last_id, $userName, $email, $_POST['p_id'], $qty, $level_price, $shippingCost, $proPrice);

				$data= array("sucess"=>"Your order submited sucessfully Transaction Id :".$this->authorize_net->getTransactionId());
				echo json_encode($data);
				//$this->authorize_net->getTransactionId()
			}else{
				$data['err'] = 'Transaction Error ID : '.$this->authorize_net->getError();
				echo json_encode($data);
			}
		}elseif($stripeValue == 1){
			try {
			  	include('./stripe/init.php');
				\Stripe\Stripe::setApiKey('sk_test_qyP0kgR3NUVz3ZTQ58Plh3kG');
				$myCard = array('number' => $card_no, 'exp_month' => $expiry_month, 'exp_year' => $expiry_year);
				$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $proPrice * 100, 'currency' => 'usd', "metadata" => array("user_name" => $userName)));

				$insertArr = array(
					'p_id'=>$_POST['p_id'],
					'user_id'=>$userID,
					'purchase_user_id'=>$userID,
					'user_name'=>$userName,
					'p_qty'=>$qty,
					'subtotal'=>$proPrice,
					'name_on_card'=>$name_on_card,
					'card_no'=>$card_no,
					'card_expiry'=> $expiry_year.'/'.$expiry_month,
					'card_ccv'=>$cvv_no,
					'transaction_id'=>$charge->id,
				);
				$this->db->insert('product_purchase_info',$insertArr);
				$last_id =  $this->db->insert_id();

				$insertUser = array(
						'order_id'=>$last_id,
						'p_id'=>$_POST['p_id'],
						'user_id'=>$userID,
						'purchase_user_id'=>$userID,
						'address1'=>$address1,
						'address2'=>$address2,
						'country'=>$country,
						'city'=>$city,
						'state'=>$state,
						'zip'=>$zip,
						'contact_no'=>$contact,
						'user_name'=>$userName,
						'first_name'=>$firstName,
						'last_name'=>$lastName,
						'user_email'=>$email,
					);
				
				$this->db->insert('user_purchase_info',$insertUser);
				$insertUser = array(
					'user_name'=>$userName,
					'ship_address'=>$address1.' '.$address2,
					'country'=>$country,
					'city'=>$city,
					'zip'=>$zip,
					'type'=>'Order',
					'product'=>$_POST['p_id'],
					'quantity'=>$qty,
				);
				$this->db->insert('shipping_management_table',$insertUser);

				$this->getSponsorToSponsorQV($_POST['p_id'],$qty);
				$this->getProductSaleParentToParentBinary($_POST['p_id'],$qty);
				$this->getProductSaleBonus($_POST['p_id'],$qty);
				$this->send_user_email_on_purchase($last_id, $userName, $email, $_POST['p_id'], $qty, $level_price, $shippingCost, $proPrice);

				$data= array("sucess"=>"Your order submited sucessfully Transaction  ID : ".$charge->id);
				echo json_encode($data);
			} catch(\Stripe\Error\Card $e) {
			  	$body = $e->getJsonBody();
			  	$err  = $body['error'];
				$data = array("err"=>$err['message']);
				echo json_encode($data);
				return  ;
			} catch (\Stripe\Error\RateLimit $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			} catch (\Stripe\Error\InvalidRequest $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			} catch (\Stripe\Error\Authentication $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			} catch (\Stripe\Error\ApiConnection $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			} catch (\Stripe\Error\Base $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			} catch (Exception $e) {
			  	$data = array("err"=>"payment error");
				echo json_encode($data);
				return  ;
			}
		}else{
			$data= array("err"=>"Sorry you can't buy this product, contact admin !");
			echo json_encode($data);
		}
	}

	function buyProductByStoreCredit(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userID = $this->session->userdata('user_id');
		$userName = $this->session->userdata('user_name');
		$email = $this->session->userdata('user_email');
		$contact = $this->session->userdata('contact_no');
		$firstName = $this->session->userdata('first_name');
		$lastName = $this->session->userdata('last_name');
		$total_amt = 0;
		$shippingCost = 0;
		$store_credit = $_POST['store_credit'];
		$qty = 1;
		
		if(!empty($_POST['country'])){
			$country = $_POST['country'];
		}else{
			$data = array("err"=>"Country is required!");
			echo json_encode($data);
			return false;
		}
		if(!empty($_POST['address1'])){
			$address1 = $_POST['address1'];
		}else{
			$data = array("err"=>"Address is required!");
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['address2'])){
			$address2 = $_POST['address2'];
		}else{
			$address2 = " ";
		}

		if(!empty($_POST['city'])){
			$city = $_POST['city'];
		}else{
			$data = array("err"=>"City is required!");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['state'])){
			$state = $_POST['state'];
		}else{
			$data = array("err"=>"State is required!");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['zip'])){
			$zip = $_POST['zip'];
		}else{
			$data = array("err"=>"Zip is required!");
			echo json_encode($data);
			return false;
		}

		if(!empty($_POST['shipping_price'])){
			$shippingCost = $_POST['shipping_price'];
		}

		if(!empty($_POST['store_credit'])){
			$store_credit = $_POST['store_credit'];
			$total_amt =  $_POST['store_price'] * $qty;

			$proPrice = $total_amt + $shippingCost;
		}else{
			$data = array("err"=>"Sorry! you don't have enough Store credit to by this product.");
			echo json_encode($data);
			return false;
		}
		
		if(!empty($_POST['store_price'])){
			$store_price = $_POST['store_price'];
		}else{
			$data= array("err"=>"Sorry you can't buy this product, contact admin !");
			echo json_encode($data);
			return false;
		}

		

		if(!empty($proPrice) && !empty($userID) && !empty($userName) && !empty($qty) && !empty($_POST['p_id']) && ($store_credit >= $proPrice)){
			$insertStoreCredit = array(
							'credit'=>$proPrice, 
							'wallet_type'=>'2', 
							'user_id'=>$userID
						);
			
			if(!$this->db->insert('store_credit_report_info',$insertStoreCredit)){
				$data= array("err"=>"Sorry ...".$this->db->_error_message());
				echo json_encode($data);
			}else{
				$insertArr = array(
					'p_id'=>$_POST['p_id'],
					'user_id'=>$userID,
					'purchase_user_id'=>$userID,
					'user_name'=>$userName,
					'p_qty'=>$qty,
					'subtotal'=>$proPrice,
				);
				$this->db->insert('product_purchase_info',$insertArr);
				$last_id =  $this->db->insert_id();

				$insertUser = array(
						'order_id'=>$last_id,
						'p_id'=>$_POST['p_id'],
						'user_id'=>$userID,
						'purchase_user_id'=>$userID,
						'address1'=>$address1,
						'address2'=>$address2,
						'country'=>$country,
						'city'=>$city,
						'state'=>$state,
						'zip'=>$zip,
						'contact_no'=>$contact,
						'user_name'=>$userName,
						'first_name'=>$firstName,
						'last_name'=>$lastName,
						'user_email'=>$email,
					);
				
				$this->db->insert('user_purchase_info',$insertUser);
				$insertUser = array(
					'user_name'=>$userName,
					'ship_address'=>$address1.' '.$address2,
					'country'=>$country,
					'city'=>$city,
					'zip'=>$zip,
					'type'=>'Order',
					'product'=>$_POST['p_id'],
					'quantity'=>$qty,
				);
				$this->db->insert('shipping_management_table',$insertUser);

				$this->getSponsorToSponsorQV($_POST['p_id'],$qty);
				$this->getProductSaleParentToParentBinary($_POST['p_id'],$qty);
				$this->getProductSaleBonus($_POST['p_id'],$qty);
				$this->send_user_email_on_purchase($last_id, $userName, $email, $_POST['p_id'], $qty, $store_price, $shippingCost, $proPrice);

				$data= array("sucess"=>"Your order submited sucessfully");
				echo json_encode($data);
			}
		}else{
			$data= array("err"=>"You dont have sufficient balance!");
			echo json_encode($data);
		}
	}

	function getTotalWallet($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductWallet($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
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
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$userChild = $this->mdl_common->getAllParent($cur_user);
		}
	}
	
	function getSponsorToSponsorQV($pid,$qty){
		$user = $this->session->userdata('user_id');
		$parent = $this->mdl_common->getAllSponsor($user);
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){	
				//$binaryPoint1 = $this->mdl_common->getSaleQV($pid);
				$binaryPoint1 = $this->mdl_common->getSaleBinary($pid);
				$binaryPoint = $binaryPoint1*$qty;
				
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
	
	function getProductSaleBonus($pid, $qty){
		$sponser = $this->session->userdata('user_id');
		$country = $this->session->userdata('country');
		$level = $this->mdl_common->getLelevel($sponser);
		$price = $this->mdl_common->getProductPrice($pid,$country);
		$levelSatePrice = $this->mdl_common->getLevelSalePrice($level,$pid);
		$productLevelSalePrice = $qty*$price - $levelSatePrice*$qty;
		if(isset($levelSatePrice) && !empty($levelSatePrice) && $levelSatePrice > 0){
			$selectearningtotal = $this->mdl_common->allSelects('SELECT pro_sales_earning, total_balance, bonus from earning_info where user_id = '.$sponser);
					
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {
					$totalProductSaleEarning = $total['pro_sales_earning'] + $productLevelSalePrice;
					$totalTotalReferalEarning = $total['total_balance'] + $productLevelSalePrice;
					$totalBonusEarning = $total['bonus'] + $productLevelSalePrice;
					$updattotalarr = array(
						'bonus'=>$totalBonusEarning,
						'total_balance'=>$totalTotalReferalEarning,
						'pro_sales_earning'=>$totalProductSaleEarning,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				}
			}else{
				$totalProductSaleEarning = $productLevelSalePrice;
				$totalTotalReferalEarning = $productLevelSalePrice;
				$totalBonusEarning = $productLevelSalePrice;
				$updattotalarr = array(
					'pro_sales_earning'=>$totalProductSaleEarning,
					'total_balance'=>$totalTotalReferalEarning,
					'bonus'=>$totalBonusEarning
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
			}

			$parent = $this->mdl_common->getAllParent($sponser);
			if(empty($parent) && $parent == null){
				$parent = 0;
			}

			$insertArr = array(
				'parent_id'=>$parent,
				'user_id'=>$sponser,
				'sale_bonus'=>$productLevelSalePrice,
			);
			$this->db->insert('product_sale_bonus',$insertArr);
			//Earning Details in one table	
			$earning_details_by_user = array(
					'user_id'=>$sponser,
					//'ref_id'=>$last_id,
					'type_id'=>'6',
					'description'=>'Product Sale Bonus '.$this->session->userdata('user_name'),
					'amount'=>$productLevelSalePrice,
					'current_balance'=>$totalTotalReferalEarning,
					'message'=>"Product Sale Bonus",
				);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);
			//end
		}
	}

	function send_user_email_on_purchase($order_id=null, $user_name=null, $user_email=null, $product_id=null, $qty=null, $total=null, $shippingCost=null, $total_amt=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'Xonnova Product');
        $this->email->to($user_email);

        $this->email->subject('Onlegacy network Purchase Mail');
        //$html = $this->mdl_common->userMailBody($user_name,$password);
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