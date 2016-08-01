<?php
/**
* 
*/
class Product extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function rejectOrderForBackOffice(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if($_POST['delivery_status'] == 'Rejected'){
			$data = array("message"=>"Order already Rejected .");
    		echo json_encode($data);
    		return;
		}

		$userId = $_POST['user_id'];
		$purchaseId = $_POST['purchase_id'];

		$updattotalarr = array(
			'delivery_status'=>'Rejected',
			'reject_comment'=>$_POST['reject_comment']
		);
		$this->db->update('product_purchase_info',$updattotalarr,array('purchase_id'=>$purchaseId));

		$Arr = array(
			'user_id'=>$userId,
			'credit'=>$_POST['subtotal'],
			'wallet_type'=>'1',
			'message'=>'Rejected Order, Product Name '.$_POST['product_name'],
		);
		$this->db->insert('store_credit_report_info',$Arr);


		$this->send_order_reject_mail($_POST['user_email'], $_POST['product_name'], $_POST['reject_comment']);

		$parentUser = $this->mdl_common->getAllParent($userId);
		if(!empty($parentUser)){
			$bv = $_POST['product_binary_point'] * $_POST['p_qty'];
			$this->deductParentToParentOrderBinary($bv,$userId);
		}
		$qv = $_POST['product_qv_point'] * $_POST['p_qty'];
		$this->deductSponsorToSponsorOrderQV($qv,$userId);

		 if($_POST['p_id'] == 98){
			$userName = $this->mdl_common->getUserNameById($userId);
			$sponsor_id = $this->mdl_common->getAllSponsor($userId);
			$qty = 0 - $_POST['p_qty'];
			$this->deductSponsorToSponsorSelesBackoffice($sponsor_id, $qty, $userName);
		}
		$data = array("message"=>"Order Rejected Sucessfully.");
    	echo json_encode($data);
	} 
	function send_order_reject_mail(  $user_email=null,  $productName=null,  $comment=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to($user_email);

        $this->email->subject('Order Rejected');
     
        $mail_body	='<div>
        					<p>Hello , </p>
        					<p>Product Name: '.$productName.', </p>
        					<p>Your Order request has been rejected. </p>
        					<p>Comment by Admin</p>
        					<p>'.$comment.'</p>
        					<p>If you have any questions, please get in touch and we will assist you.</p>
        					<p>Team xonnova</p>

        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }
	function deductSponsorToSponsorOrderQV($QvPoint,$childUser){
		$parent = $this->mdl_common->getAllSponsor($childUser);
		$user = $childUser;
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			$x = 0 - $QvPoint;
			if($sponser > 0){					
				$insertBinamry = array(
						'sponsor_id'=>$sponser,
						'user_id'=>$user,
						'qv_point'=>$x
					);
				$this->db->insert('unilevel_binary_info',$insertBinamry);
			}
			$parent = $this->mdl_common->getAllSponsor($sponser);
			$user = $this->mdl_common->getAllSponsor($user);
		}
	}

	function deductParentToParentOrderBinary($binaryPoint,$childUser){
		$parent = $this->mdl_common->getAllParent($childUser);
		$user = $childUser;
		for($i=$parent; $i>=1; $i--){
			$sponser = $parent; 
			$child = $user;
			if($sponser > 0){				
				$selectearningtotal = $this->mdl_common->allSelects('SELECT referral_binary_point from earning_info where user_id = '.$sponser);
					if(isset($selectearningtotal) && !empty($selectearningtotal)){
						foreach ($selectearningtotal as $total) {						
							$totalBinaryPoint = $total['referral_binary_point'] - $binaryPoint;
							$updattotalarr = array(
								'referral_binary_point'=>$totalBinaryPoint,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
						}
					}else{
						$totalBinaryPoint = 0 - $binaryPoint;
						$updattotalarr = array(
							'referral_binary_point'=>$totalBinaryPoint,
						);
						$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
					}

					$insertRichtBinamry1 = array(
							'parent_id'=>$parent,
							'user_id'=>$user,
							'binary_point'=>$binaryPoint,
							//'ammount'=>$totalAmount1,
						);

					$this->db->insert('binary_deduction',$insertRichtBinamry1);
			}
			$parent = $this->mdl_common->getAllParent($sponser);
			$user = $this->mdl_common->getAllParent($user);
		}
	}

	function deductSponsorToSponsorSelesBackoffice( $sponsor_id, $qty, $userName){
		if($sponsor_id == 0){
		return;
		}
		$this->deductEnringInfo($sponsor_id, $qty/2, $userName);
	
		$sponsor1 = $this->mdl_common->getAllSponsor($sponsor_id);
		if($sponsor1 == 0){
		return;
		}
		$this->deductEnringInfo($sponsor1, $qty/2, $userName);

		$sponsor2 = $this->mdl_common->getAllSponsor($sponsor1);
		if($sponsor2 == 0){
		return;
		}
		$this->deductEnringInfo($sponsor2, $qty/2, $userName);

		$sponsor3 = $this->mdl_common->getAllSponsor($sponsor2);
		if($sponsor3 == 0){
		return;
		}
		$this->deductEnringInfo($sponsor3, $qty/2, $userName);

		$sponsor4 = $this->mdl_common->getAllSponsor($sponsor3);
		if($sponsor4 == 0){
		return;
		}
		$this->deductEnringInfo($sponsor4, $qty/2, $userName);

		$sponsor5 = $this->mdl_common->getAllSponsor($sponsor4);
		if($sponsor5 == 0){
		return;
		}
		$this->deductEnringInfo($sponsor5, $qty/2, $userName);
	}

	function deductEnringInfo($sponser, $referralAmount, $userName){
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
				'description'=>'Rejected INSTALLATION KIT '.$userName,
				'amount'=>$referralAmount,
				'current_balance'=>$this->mdl_common->getTotalBalance($sponser),
				//'message'=>"",
				//'e_d_b_u_date'=>$value['created_at'],
			);
		$this->db->insert('earning_details_by_user',$earning_details_by_user);
	}

	
	function deletePackageDescription($id){
		$user = json_decode(file_get_contents("php://input"),true);
		$this->db->delete('package_description',array('level'=>$user['level']));
	}

	function updatePackageDescription($id){
		$user = json_decode(file_get_contents("php://input"),true);
			$updateArr = array(
					'value'=>$user['value'],
			);
		$this->db->update('package_description',$updateArr, array('id'=>$id, 'level'=>$user['level']));
	} 

	function addPackageDescription($id){
		$user = json_decode(file_get_contents("php://input"),true);
			$date = date("ymdHis");
	        $level = 'level_'.$date;
			$updateArr = array(
					'id'=>$id,
					'level'=>$level,
					'value'=>$user['value'],
			);
		$this->db->insert('package_description',$updateArr);
	}

	function getPackageDescriptionById($id){
		header('Content-Type: application/json');
		$getReferrals = $this->mdl_common->allSelects('SELECT * from package_description where id='.$id);
		if(isset($getReferrals) && !empty($getReferrals)){
			foreach ($getReferrals as $value) {
				$arrRef[] = $value;
			}
			echo json_encode($arrRef);
		}else{
			
		}	
	}

	function getCategory(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_category');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
		
	}

	function getCategoryById($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_category where category_id = '.$id);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function addCategory(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		//cat_parent_id
		if(isset($_POST['cat_parent_id']) && !empty($_POST['cat_parent_id'])){
			$insertArr = array(
				'cat_parent_id'=>$_POST['cat_parent_id'],
				'category_name'=>$_POST['category_name'],
				'category_status'=>$_POST['category_status'],
				'category_desc'=>$_POST['category_desc'],
				'category_type'=>$_POST['category_type']
			);

			if(!$this->db->insert('product_category',$insertArr)){
				return json_encode('false');
			}else{
				return json_encode('false');
			}
		}else{
			$insertArr = array(
				'category_name'=>$_POST['category_name'],
				'category_status'=>$_POST['category_status'],
				'category_desc'=>$_POST['category_desc'],
				'category_type'=>$_POST['category_type']
			);
			if(!$this->db->insert('product_category',$insertArr)){
				return json_encode('false');
			}else{
				return json_encode('false');
			}
		}
		
	}

	function updateCategory(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'category_name'=>$_POST['category_name'],
				'category_status'=>$_POST['category_status'],
				'category_desc'=>$_POST['category_desc']
			);
		$this->db->update('product_category',$updateArr, array('category_id'=>$_POST['category_id']));
	}
	
	function getRootCatetory(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_category where category_type = "1"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			//echo json_encode('error')
		}
	}
	
	function getSubCatetory(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_category where category_type = "2"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			//echo json_encode('error')
		}
	}
	
	function deleteCategory($id){
		return $this->db->delete('product_category',array('category_id'=>$id));
	}

	function addProduct(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $image = 'product_'.$date.$_FILES[ 'file' ][ 'name' ];
		    $configVideo = array(
					'upload_path' => './assets/uploads/',
					'max_size' => '8000240',
					'allowed_types' => 'png|gif|jpg|jpeg',
					'overwrite'=> FALSE,
					'remove_spaces' => TRUE,
					'file_name'=> $image
			);

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array("message"=>"No files");
    			echo json_encode($data);
				
			} else {
				if(!empty($_POST['shipping_price'])){
					$shipping =$_POST['shipping_price'];
				}else{
					$shipping = 0;
				}
				if(!empty($_POST['country']) && $_POST['country'] == "US"){
					$insertArr = array(
						'product_image' => $image,
						'cat_id'=>$_POST['product_category'],
						'product_name'=>$_POST['product_name'],
						'country'=>$_POST['country'],
						'us_product_price'=>$_POST['us_product_price'],
						'shipping_price'=>$shipping,
						'product_qty'=>$_POST['product_qty'],
						'product_binary_point'=>$_POST['product_binary_point'],
						'product_qv_point'=>$_POST['product_qv_point'],
						'product_status'=>$_POST['product_status'],
						'product_desc'=>$_POST['product_desc'],

						'reward_points'=>$_POST['reward_points'],
					);
				}elseif (!empty($_POST['country']) && $_POST['country'] == "MEX") {
					$insertArr = array(
						'product_image' => $image,
						'cat_id'=>$_POST['product_category'],
						'product_name'=>$_POST['product_name'],
						'country'=>$_POST['country'],
						'mexico_product_price'=>$_POST['mexico_product_price'],
						'shipping_price'=>$shipping,
						'product_qty'=>$_POST['product_qty'],
						'product_binary_point'=>$_POST['product_binary_point'],
						'product_status'=>$_POST['product_status'],
						'product_desc'=>$_POST['product_desc'],

						'reward_points'=>$_POST['reward_points'],
					);
				}
				
			   	$this->db->insert('product_info',$insertArr); 

			   	$last_id =  $this->db->insert_id();
				$insertData = array(
					'p_id'=>$last_id,
					'cat_id'=>$_POST['product_category']
				);
				$this->db->insert('product_category_map',$insertData);
				if(isset($_POST['checked']) && !empty($_POST['checked']) && $_POST['checked'] !=null){
					if(!empty($_POST['member_price'])){
						$levelPrice = array(
							'member_price'=>$_POST['member_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['representative_price'])){
						$levelPrice = array(
							'representative_price'=>$_POST['representative_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['partner_price'])){
						$levelPrice = array(
							'partner_price'=>$_POST['partner_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['brand_partner_price'])){
						$levelPrice = array(
							'brand_partner_price'=>$_POST['brand_partner_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['team_partner_price'])){
						$levelPrice = array(
							'team_partner_price'=>$_POST['team_partner_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}

					
					
					if(!empty($_POST['team_lead_price'])){
						$levelPrice = array(
							'team_lead_price'=>$_POST['team_lead_price'],
						);
						$this->db->update('product_info',$levelPrice,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['director_price'])){
						$levelPrice1 = array(
							'director_price'=>$_POST['director_price'],
						);	
						$this->db->update('product_info',$levelPrice1,array('p_id'=>$last_id));					
					}
					if(!empty($_POST['regional_price'])){
						$levelPrice2 = array(
							'regional_price'=>$_POST['regional_price'],
						);	
						$this->db->update('product_info',$levelPrice2,array('p_id'=>$last_id));					
					}
					if(!empty($_POST['national_price'])){
						$levelPrice3 = array(
							'national_price'=>$_POST['national_price'],
						);	
						$this->db->update('product_info',$levelPrice3,array('p_id'=>$last_id));					
					}
					if(!empty($_POST['international_price'])){
						$levelPrice4 = array(
							'international_price'=>$_POST['international_price'],
						);	
						$this->db->update('product_info',$levelPrice4,array('p_id'=>$last_id));					
					}
					/* if(!empty($_POST['VP_price'])){
						$levelPrice5 = array(
							'VP_price'=>$_POST['VP_price'],
						);	
						$this->db->update('product_info',$levelPrice5,array('p_id'=>$last_id));					
					} */
					if(!empty($_POST['p_price'])){
						$levelPrice6 = array(
							'p_price'=>$_POST['p_price']
						);
						$this->db->update('product_info',$levelPrice6,array('p_id'=>$last_id));						
					}
					
					if(!empty($_POST['ambassador_price'])){
						$levelPrice6 = array(
							'ambassador_price'=>$_POST['ambassador_price']
						);
						$this->db->update('product_info',$levelPrice6,array('p_id'=>$last_id));						
					}

					if(!empty($_POST['crown_ambassador_price'])){
						$levelPrice6 = array(
							'crown_ambassador_price'=>$_POST['crown_ambassador_price']
						);
						$this->db->update('product_info',$levelPrice6,array('p_id'=>$last_id));						
					}
					if(!empty($_POST['store_price'])){
						$levelPrice6 = array(
							'store_price'=>$_POST['store_price']
						);
						$this->db->update('product_info',$levelPrice6,array('p_id'=>$last_id));						
					}
				}

			   	$data = array("message"=>"Product Added Sucessfully.");
    			echo json_encode($data);
				 
			}		            
		}
	}
	function getProduct(){
		header('Content-Type: application/json');
		//$contentData = $this->mdl_common->allSelects('SELECT * FROM product_info WHERE product_status="active" ORDER BY p_id desc');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM product_info WHERE product_status !="deleted" ORDER BY p_id desc');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{

		}
	}
	
	function getProductByCat(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$category = $_POST['product_category'];
		if(!empty($category)){
			$getData = $this->mdl_common->allSelects('Select * from product_info WHERE product_status !="deleted" AND cat_id='.$category.' order by p_id desc');
			if(!empty($getData)){
				foreach ($getData as $value) {
					$arrRef[] = $value;
				}
				echo json_encode($arrRef);
			}else{
				
			}			
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT * FROM product_info WHERE product_status !="deleted" order by p_id desc');
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				
			}
		}
	}
	
	function getProductById($id){
		$getData = $this->mdl_common->allSelects('Select * from product_info WHERE  p_id='.$id);
		foreach ($getData as $value) {
			$arrRef[] = $value;
		}
		echo json_encode($arrRef);
	}
	
	function updateImage(){
		
		if(!empty($_FILES)) {
	        $date = date("ymdHis");
	        $image = 'product'.$date.$_FILES[ 'file' ][ 'name' ];

	        $insertArr = array(
				'product_image' => $image,
			);

	        $configVideo = array(
	            	'upload_path' => './assets/uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            echo 'No files';
	        } else {
	    	   $this->db->update('product_info',$insertArr, array('p_id'=>$_POST['p_id'])); 
			   $data = array('message'=>' updated Sucessfully');
			   echo json_encode($data);
			}				            
		}else{ 
			$data = array('message'=>'No Files Error.....!');
			echo json_encode($data);
		}

	}

	function updateProduct(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['shipping_price'])){
			$shipping =$_POST['shipping_price'];
		}else{
			$shipping = 0;
		}
		if(isset($_POST['country']) && !empty($_POST['country']) && $_POST['country'] == "US"){
			$updateArr = array(
				'cat_id'=>$_POST['product_category'],
				'product_name'=>$_POST['product_name'],
				'country'=>$_POST['country'],
				'us_product_price'=>$_POST['us_product_price'],
				'shipping_price'=>$shipping,
				'product_qty'=>$_POST['product_qty'],
				'product_binary_point'=>$_POST['product_binary_point'],
				'product_qv_point'=>$_POST['product_qv_point'],
				'product_status'=>$_POST['product_status'],
				'product_desc'=>$_POST['product_desc'],

				'reward_points'=>$_POST['reward_points'],
			);
			$this->db->update('product_info',$updateArr, array('p_id'=>$_POST['p_id']));
			if(isset($_POST['checked1']) && !empty($_POST['checked1']) && $_POST['checked1'] == 1){
				$levelPrice = array(
					'member_price'=>$_POST['member_price'],
					'representative_price'=>$_POST['representative_price'],
					'partner_price'=>$_POST['partner_price'],
					'brand_partner_price'=>$_POST['brand_partner_price'],
					'team_partner_price'=>$_POST['team_partner_price'],
					
					'team_lead_price'=>$_POST['team_lead_price'],
					'director_price'=>$_POST['director_price'],
					'regional_price'=>$_POST['regional_price'],
					'national_price'=>$_POST['national_price'],
					'international_price'=>$_POST['international_price'],
					//'VP_price'=>$_POST['VP_price'],
					'p_price'=>$_POST['p_price'],
					
					'ambassador_price'=>$_POST['ambassador_price'],
					'crown_ambassador_price'=>$_POST['crown_ambassador_price'],
					'store_price'=>$_POST['store_price'],
				);
				$this->db->update('product_info',$levelPrice,array('p_id'=>$_POST['p_id']));
			}
			$data = array('message'=>'Product Updated Sucessfully');
			echo json_encode($data);
		}elseif(isset($_POST['country']) && !empty($_POST['country']) && $_POST['country'] == "MEX"){
			$updateArr = array(
				'cat_id'=>$_POST['product_category'],
				'product_name'=>$_POST['product_name'],
				'country'=>$_POST['country'],
				'mexico_product_price'=>$_POST['mexico_product_price'],
				'shipping_price'=>$shipping,
				'product_qty'=>$_POST['product_qty'],
				'product_binary_point'=>$_POST['product_binary_point'],
				'product_status'=>$_POST['product_status'],
				'product_desc'=>$_POST['product_desc'],


				'reward_points'=>$_POST['reward_points'],
			);
			$this->db->update('product_info',$updateArr, array('p_id'=>$_POST['p_id']));
			if(isset($_POST['checked1']) && !empty($_POST['checked1']) && $_POST['checked1'] == 1){
				$levelPrice = array(
					'member_price'=>$_POST['member_price'],
					'representative_price'=>$_POST['representative_price'],
					'partner_price'=>$_POST['partner_price'],
					'brand_partner_price'=>$_POST['brand_partner_price'],
					'team_partner_price'=>$_POST['team_partner_price'],
					
					'team_lead_price'=>$_POST['team_lead_price'],
					'director_price'=>$_POST['director_price'],
					'regional_price'=>$_POST['regional_price'],
					'national_price'=>$_POST['national_price'],
					'international_price'=>$_POST['international_price'],
					//'VP_price'=>$_POST['VP_price'],
					'p_price'=>$_POST['p_price'],
					'ambassador_price'=>$_POST['ambassador_price'],
					'crown_ambassador_price'=>$_POST['crown_ambassador_price'],
					'store_price'=>$_POST['store_price'],
				);
				$this->db->update('product_info',$levelPrice,array('p_id'=>$_POST['p_id']));
			}
			$data = array('message'=>'Product Updated Sucessfully');
			echo json_encode($data);
		}else{
				$data = array('message'=>'Product NOT Updated Error....');
				echo json_encode($data);
		}
	}

	function deletePproduct(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(!empty($_POST['p_id'])){
			$id = $_POST['p_id'];
			$this->db->update('product_info',array('product_status'=>'deleted'),array('p_id'=>$id));
			echo $id;
		}else{
			
		}
	}
}