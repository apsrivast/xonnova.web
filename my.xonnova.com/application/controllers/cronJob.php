<?php

/**
* 
*/
class CronJob extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}



	function getStripeData(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM stripe_rate LIMIT 0 , 1');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);		
		}else{

		}
	}
	
	function updateStripeSettings(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if((isset($_POST['value']))  &&(isset($_POST['id']) && !empty($_POST['id']))){
			$updateArr = array(
					'value'=>$_POST['value'],
				);
			if(!$this->db->update('stripe_rate',$updateArr,array('id'=>$_POST['id']))){
				$data = array('message'=>'Error... Stripe Setting Not Updated!');
			}else{
				$data = array('message'=>'Stripe Setting Updated sucessfully!');				
			}
		}else{
			$data = array('message'=>'This field is required!');
		}
		echo json_encode($data);
	}


	function getConversionRateData(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM conversion_rate LIMIT 0 , 1');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);		
		}else{

		}
	}
	
	function updateConversionRateSettings(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if((isset($_POST['us_rate']) && !empty($_POST['us_rate'])) && (isset($_POST['mx_rate']) && !empty($_POST['mx_rate']))&&(isset($_POST['id']) && !empty($_POST['id']))){
			$updateArr = array(
					'us_rate'=>$_POST['us_rate'],
					'mx_rate'=>$_POST['mx_rate']
				);
			if(!$this->db->update('conversion_rate',$updateArr,array('id'=>$_POST['id']))){
				$data = array('message'=>'Error... Conversion Rate Setting Not Updated!');
			}else{
				$data = array('message'=>'Conversion Rate Setting Updated sucessfully!');				
			}
		}else{
			$data = array('message'=>'This field is required!');
		}
		echo json_encode($data);
	}
	
	function getCronjobData(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM chron_job_info LIMIT 0 , 1');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);		
		}else{

		}
	}
	
	function updateCronJobSettings(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if((isset($_POST['binary_conversion_price']) && !empty($_POST['binary_conversion_price'])) && (isset($_POST['conversion_binary_point']) && !empty($_POST['conversion_binary_point']))&&(isset($_POST['id']) && !empty($_POST['id']))){
			$updateArr = array(
					'binary_conversion_price'=>$_POST['binary_conversion_price'],
					'conversion_binary_point'=>$_POST['conversion_binary_point']
				);
			if(!$this->db->update('chron_job_info',$updateArr,array('id'=>$_POST['id']))){
				$data = array('message'=>'Error... CronJob Setting Not Updated!');
			}else{
				$data = array('message'=>'CronJob Setting Updated sucessfully!');				
			}
		}else{
			$data = array('message'=>'This field is required!');
		}
		echo json_encode($data);
	}
	 
	function autoBinaryConversion(){
		$contentData = $this->mdl_common->allSelects('SELECT * From user_master');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$totalBinary = $this->mdl_common->getTotalBinary($value['user_id']);
				$currency = $this->mdl_common->sponsorCountry($value['user_id']);
				$binaryConversionPrice = $this->mdl_common->binaryConversionPrice($currency);
				$binaryConversionRate = $this->mdl_common->binaryConversionRate();
				
				$lftChild = $this->mdl_common->leftChild($value['user_id']);
				$rghtChild = $this->mdl_common->rightChild($value['user_id']);

				$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$value['user_id'].' and user_id='.$lftChild);
				$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$value['user_id'].' and user_id='.$lftChild);
				$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$value['user_id'].' and user_id='.$lftChild);
				$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary - $totalLeftDeductBinary;

				$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$value['user_id'].' and user_id='.$rghtChild);
				$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$value['user_id'].' and user_id='.$rghtChild);
				$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$value['user_id'].' and user_id='.$rghtChild);
				$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary - $totalRightDeductBinary;
				
				if($totalBinary >= $binaryConversionRate && $totalBinary > $leftUserTotal && $totalBinary > $rightUserTotal){
					if($rightUserTotal >= $binaryConversionRate && $leftUserTotal >= $binaryConversionRate  && $rightUserTotal < $leftUserTotal){
						$x = $rightUserTotal/$binaryConversionRate;
						$y = explode('.', $x);
						$multiplide = $y[0];
						$totalSingleUserBinary = $binaryConversionRate * $multiplide;

						$totalAmount = $multiplide * $binaryConversionPrice;

						$totalAmount = $this->mdl_common->MatchingBonusAmount($totalAmount, $value['user_id']);

						
						$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance, referral_binary_point from earning_info where user_id = '.$value['user_id']);
							
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount= $total['total_balance'] + $totalAmount;
								
								$totalBinaryPoint = $total['referral_binary_point'] - $totalSingleUserBinary * 2;
								$updattotalarr = array(
									//'total_balance'=>$totalreferralAmount,
									'referral_binary_point'=>$totalBinaryPoint
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$totalreferralAmount= $totalAmount;
								
							$totalBinaryPoint = 0 - $totalSingleUserBinary * 2;
							$updattotalarr = array(
								//'total_balance'=>$totalreferralAmount,
								'referral_binary_point'=>$totalBinaryPoint
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

						$insertRichtBinamry = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$rghtChild,
								'binary_point'=>$totalSingleUserBinary,
								'ammount'=>$totalAmount,
							);
						$this->db->insert('binary_deduction',$insertRichtBinamry);

						$insertLeftBinamry = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$lftChild,
								'binary_point'=>$totalSingleUserBinary,
								'ammount'=>$totalAmount,
							);
						$this->db->insert('binary_deduction',$insertLeftBinamry);
						
						$insertQvarr = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$rghtChild,
								'binary_point'=>$totalSingleUserBinary,
								'ammount'=>$totalAmount,
							);
						$this->db->insert('cron_job_qv_info',$insertQvarr);

						//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								'ref_id'=>$rghtChild,
								'description'=>'Binary Bonus',
								'amount'=>$totalAmount,
								//'message'=>"",
								'e_d_b_u_date'=>date('Y-m-d H:i:s', mktime(date("00"), date("00"), date("00"), date("m"), date("d") - 1, date("Y"))),
							);
						$this->db->insert('earning_details_by_user_pending',$earning_details_by_user);
						//end
                                                $this->binaryMatchingBonus($totalAmount, $value['user_id']);
					}elseif($leftUserTotal >= $binaryConversionRate && $rightUserTotal >= $binaryConversionRate && $leftUserTotal < $rightUserTotal){
						$x1 = $leftUserTotal/$binaryConversionRate;
						$y1 = explode('.', $x1);
						$multiplide1 = $y1[0];
						$totalSingleUserBinary1 = $binaryConversionRate * $multiplide1;
						$totalAmount1 = $multiplide1 * $binaryConversionPrice;

						$totalAmount1 = $this->mdl_common->MatchingBonusAmount($totalAmount1, $value['user_id']);


						$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance, referral_binary_point from earning_info where user_id = '.$value['user_id']);
							
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount1= $total['total_balance'] + $totalAmount1;
								
								$totalBinaryPoint1 = $total['referral_binary_point'] - $totalSingleUserBinary1 * 2;
								$updattotalarr = array(
									//'total_balance'=>$totalreferralAmount1,
									'referral_binary_point'=>$totalBinaryPoint1,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$totalreferralAmount1= $totalAmount1;
								
							$totalBinaryPoint1 = 0 - $totalSingleUserBinary1 * 2;
							$updattotalarr = array(
								//'total_balance'=>$totalreferralAmount1,
								'referral_binary_point'=>$totalBinaryPoint1,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

						$insertRichtBinamry1 = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$rghtChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('binary_deduction',$insertRichtBinamry1);

						$insertLeftBinamry1 = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$lftChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('binary_deduction',$insertLeftBinamry1);
						
						$insertQvarr = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$lftChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('cron_job_qv_info',$insertQvarr);

						//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								'ref_id'=>$lftChild,
								'description'=>'Binary Bonus',
								'amount'=>$totalAmount1,
								//'message'=>"",
								'e_d_b_u_date'=>date('Y-m-d H:i:s', mktime(date("00"), date("00"), date("00"), date("m"), date("d") - 1, date("Y"))),
							);
						$this->db->insert('earning_details_by_user_pending',$earning_details_by_user);
						//end
                                                $this->binaryMatchingBonus($totalAmount1, $value['user_id']);
					}elseif($leftUserTotal >= $binaryConversionRate && $rightUserTotal >= $binaryConversionRate && $leftUserTotal == $rightUserTotal){
						$x1 = $leftUserTotal/$binaryConversionRate;
						$y1 = explode('.', $x1);
						$multiplide1 = $y1[0];
						
						$totalSingleUserBinary1 = $binaryConversionRate * $multiplide1;
						$totalAmount1 = $multiplide1 * $binaryConversionPrice;

						$totalAmount1 = $this->mdl_common->MatchingBonusAmount($totalAmount1, $value['user_id']);

						$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance, referral_binary_point from earning_info where user_id = '.$value['user_id']);
							
						if(isset($selectearningtotal) && !empty($selectearningtotal)){
							foreach ($selectearningtotal as $total) {						
								$totalreferralAmount1= $total['total_balance'] + $totalAmount1;
								
								$totalBinaryPoint1 = $total['referral_binary_point'] - $totalSingleUserBinary1 * 2;
								$updattotalarr = array(
									//'total_balance'=>$totalreferralAmount1,
									'referral_binary_point'=>$totalBinaryPoint1,
								);
								$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
							}
						}else{
							$totalreferralAmount1= $totalAmount1;
								
							$totalBinaryPoint1 = 0 - $totalSingleUserBinary1 * 2;
							$updattotalarr = array(
								//'total_balance'=>$totalreferralAmount1,
								'referral_binary_point'=>$totalBinaryPoint1,
							);
							$this->db->update('earning_info',$updattotalarr,array('user_id'=>$value['user_id']));
						}

						$insertRichtBinamry1 = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$rghtChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('binary_deduction',$insertRichtBinamry1);

						$insertLeftBinamry1 = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$lftChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('binary_deduction',$insertLeftBinamry1);
						
						$insertQvarr = array(
								'parent_id'=>$value['user_id'],
								'user_id'=>$rghtChild,
								'binary_point'=>$totalSingleUserBinary1,
								'ammount'=>$totalAmount1,
							);
						$this->db->insert('cron_job_qv_info',$insertQvarr);

						//Earning Details in one table	
						$earning_details_by_user = array(
								'user_id'=>$value['user_id'],
								'ref_id'=>$rghtChild,
								'description'=>'Binary Bonus',
								'amount'=>$totalAmount1,
								//'message'=>"",
								'e_d_b_u_date'=>date('Y-m-d H:i:s', mktime(date("00"), date("00"), date("00"), date("m"), date("d") - 1, date("Y"))),
							);
						$this->db->insert('earning_details_by_user_pending',$earning_details_by_user);
						//end
                                                $this->binaryMatchingBonus($totalAmount1, $value['user_id']);
					}					
				}
			}
		}
	}

        function binaryMatchingBonus($amount, $childUser){
		$user = $childUser;
		$parent = $this->mdl_common->getAllSponsor($user);
		for ($i=1; $i < 3; $i++) { 
			$percentOfBinaryMaching = 10/$i;
			$binaryMatchingBonusAmount = $amount * $percentOfBinaryMaching / 100;
			//Earning Details in one table	
			$earning_details_by_user = array(
					'user_id'=>$parent,
					'ref_id'=>$user,
					'description'=>'Binary Matching Bonus',
					'amount'=>$binaryMatchingBonusAmount,
					'type_id'=>"9",
					'e_d_b_u_date'=>date('Y-m-d H:i:s', mktime(date("00"), date("00"), date("00"), date("m"), date("d") - 1, date("Y"))),
				);
			$this->db->insert('earning_details_by_user_pending',$earning_details_by_user);
			//end
			echo "user ID =>".$user.", parent ID =>".$parent." , percent =>".$percentOfBinaryMaching." => ".$binaryMatchingBonusAmount."<br/>";
			$parent = $this->mdl_common->getAllSponsor($parent);
			$user = $this->mdl_common->getAllSponsor($user);
		}
	}
}