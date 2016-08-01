<?php
/**
* 
*/
class Daily_report_for_admin extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}


	function getInsertDailyReportForTable($date){
		

		$from = date($date);

		$to = date('Y-m-d', strtotime($date . ' +1 day'));



		
		$totalU = $this->mdl_common->allSelects('SELECT SUM(amount) as total from upgrade_user_details where upgrade_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($totalU) && !empty($totalU) && $totalU != null){
			foreach ($totalU as $value) {
				if(!empty($value['total'])){
					$totalUpgrade = $value['total'];
				}else{
					$totalUpgrade = 0;
				}
			}		
		}else{
			$totalUpgrade = 0;
		}


		$totalP = $this->mdl_common->allSelects('SELECT SUM(subtotal) as total from product_purchase_info where purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($totalP) && !empty($totalP) && $totalP != null){
			foreach ($totalP as $value) {
				//$totalProduct = $value['total'];
				if(!empty($value['total'])){
					$totalProduct = $value['total'];
				}else{
					$totalProduct = 0;
				}
			}		
		}else{
			$totalProduct = 0;
		}



		$totalR = $this->mdl_common->allSelects('SELECT SUM(entry_ammout) as total from shipping_management_table as a LEFT JOIN  package_info as b on a.shipping_package_id = b.package_id where a.type = "Registration" AND a.created_at BETWEEN "'.$from.'" AND "'.$to.'"');


		//$totalR = $this->mdl_common->allSelects('SELECT SUM(total_amount) as total from earning_info where eaning_created >="'.$Date.'"');
		if(isset($totalR) && !empty($totalR) && $totalR != null){
			foreach ($totalR as $value) {
				//$totalRegistration = $value['total'];
				if(!empty($value['total'])){
					$totalRegistration = $value['total'];
				}else{
					$totalRegistration = 0;
				}
			}		
		}else{
			$totalRegistration = 0;
		}


		$totalIncome = $totalUpgrade + $totalProduct + $totalRegistration;


		$totalF = $this->mdl_common->allSelects('SELECT SUM(referral_bonus) as total from referral_bonus where  created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($totalF) && !empty($totalF) && $totalF != null){
			foreach ($totalF as $value) {
				//$totalFastStart = $value['total'];
				if(!empty($value['total'])){
					$totalFastStart = $value['total'];
				}else{
					$totalFastStart = 0;
				}
			}		
		}else{
			$totalFastStart = 0;
		}

	

		$totalCoded = 0;

		$totalB = $this->mdl_common->allSelects('SELECT SUM(ammount) as total from binary_deduction where  	deducted_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($totalB) && !empty($totalB) && $totalB != null){
			foreach ($totalB as $value) {
				//$totalBinary = $value['total']/2;
				if(!empty($value['total'])){
					$totalBinary = $value['total']/2;
				}else{
					$totalBinary = 0;
				}
			}		
		}else{
			$totalBinary = 0;
		}



		

		$totalE = $this->mdl_common->allSelects('SELECT SUM(module_bonus) as total from interpreneurial_bonus_module where  	molude_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($totalE) && !empty($totalE) && $totalE != null){
			foreach ($totalE as $value) {
				//$totalEntrepreneurial = $value['total'];
				if(!empty($value['total'])){
					$totalEntrepreneurial = $value['total'];
				}else{
					$totalEntrepreneurial = 0;
				}
			}		
		}else{
			$totalEntrepreneurial = 0;
		}

		$totalMatching = 0;


		$totalPaid = $totalFastStart + $totalCoded + $totalBinary  + $totalEntrepreneurial + $totalMatching;

		$totalProfit = $totalIncome - $totalPaid;



		$insertArr = array(
				'total_income'=>$totalIncome,
				'fast_start'=>$totalFastStart,
				'bv'=>$totalBinary,
				'coded'=>$totalCoded,
				'entrepreneurial'=>$totalEntrepreneurial,
				'matching'=>$totalMatching,
				'total_paid'=>$totalPaid,
				'total_profit'=>$totalProfit,
				'date'=>$date,
			);
		
		$this->db->insert('daily_report_for_admin', $insertArr);
				  
	
		echo $date;

		
	}


	function getTotalTotalIncome($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(total_income) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(total_income) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalFastStart($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(fast_start) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(fast_start) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalBinary($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(bv) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(bv) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalCoded($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(coded) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(coded) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalEntrepreneurial($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(entrepreneurial) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(entrepreneurial) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalMatching($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(matching) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(matching) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function getTotalTotalPaid($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(total_paid) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(total_paid) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}

	function TotalTotalProfit($from=null,$to=null){
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT SUM(total_profit) as total From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT SUM(total_profit) as total From daily_report_for_admin');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					echo json_encode($value['total']); 
				}
				
			}else{
				return false;
			}
		}
	}


	function getProductAmount($date){
		$from = date($date);
		$from = date('Y-m-d H:i:s', strtotime($date . ' +2 hours'));

		$to = date('Y-m-d H:i:s', strtotime($from . ' +1 day'));
		
		// $list = $this->mdl_common->allSelects('SELECT a.subtotal, b.user_name From product_purchase_info as a RIGHT JOIN user_master as b on a.user_id = b.user_id WHERE a.purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
		// if(isset($list) && !empty($list)){
		// 	foreach ($list as $key => $value) {
		// 		$arr[] = $value;
		// 	}
		// 	echo json_encode($arr);
		// }else{
		// 	return false;
		// }

		$list = $this->mdl_common->allSelects('SELECT a.subtotal, b.user_name From product_purchase_info as a RIGHT JOIN user_master as b on a.user_id = b.user_id WHERE a.purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			$list2 = $this->mdl_common->allSelects('SELECT a.subtotal, b.user_name From product_purchase_info as a RIGHT JOIN reseller_store as b on a.user_id = b.user_id WHERE a.purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list2) && !empty($list2)){
				foreach ($list2 as $key2 => $value2) {
					$arr[] = $value2;
				}
			}
			echo json_encode($arr);
		}else{
			$list3 = $this->mdl_common->allSelects('SELECT a.subtotal, b.user_name From product_purchase_info as a RIGHT JOIN reseller_store as b on a.user_id = b.user_id WHERE a.purchase_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list3) && !empty($list3)){
				foreach ($list3 as $key3 => $value3) {
					$arr[] = $value3;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
		
	}

	function getUpgradeAmount($date){
		$from = date($date);
		$from = date('Y-m-d H:i:s', strtotime($date . ' +2 hours'));
		$to = date('Y-m-d H:i:s', strtotime($from . ' +1 day'));
		$list = $this->mdl_common->allSelects('SELECT  a.amount, b.user_name From upgrade_user_details as a RIGHT JOIN user_master as b on a.user_id = b.user_id WHERE a.upgrade_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}
	function getRegistrationAmount($date){
		$from = date($date);
		$from = date('Y-m-d H:i:s', strtotime($date . ' +2 hours'));
		$to = date('Y-m-d H:i:s', strtotime($from . ' +1 day'));
		$list = $this->mdl_common->allSelects('SELECT shipping_package_id, user_name from shipping_management_table  where type = "Registration" AND created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
						$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
						$packageAmmount = $this->mdl_common->planPrice($value['shipping_package_id'],$country);		
				$arr[] = array('user_name'=>$value['user_name'],'entry_ammout'=>$packageAmmount);
			}
			echo json_encode($arr);
		}else{
			return false;
		}


		// $list = $this->mdl_common->allSelects('SELECT b.entry_ammout, a.user_name from shipping_management_table as a LEFT JOIN  package_info as b on a.shipping_package_id = b.package_id where a.type = "Registration" AND a.created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		// if(isset($list) && !empty($list)){
		// 	foreach ($list as $key => $value) {
		// 		$arr[] = $value;
		// 	}
		// 	echo json_encode($arr);
		// }else{
		// 	return false;
		// }
		
	}


	function getFastStartAmount($date){
		$from = date($date);
		$from = date('Y-m-d H:i:s', strtotime($date . ' +2 hours'));
		$to = date('Y-m-d H:i:s', strtotime($from . ' +1 day'));
		$list = $this->mdl_common->allSelects('SELECT   a.referral_bonus, b.user_name From referral_bonus as a RIGHT JOIN user_master as b on a.parent_id = b.user_id WHERE a.created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
				if($country=='MEX'){
					$value['referral_bonus'] = 	round($this->mdl_common->getUSAmountFromMex($value['referral_bonus']), 2);		
				}
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}

	function getBinaryAmount($date){
		$from = date($date);
		$from = date('Y-m-d H:i:s', strtotime($date . ' +4 hours'));
		$to = date('Y-m-d H:i:s', strtotime($from . ' +1 day'));
		$list = $this->mdl_common->allSelects('SELECT  DISTINCT a.ammount, b.user_name From binary_deduction as a RIGHT JOIN user_master as b on a.parent_id = b.user_id WHERE a.deducted_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
				if($country=='MEX'){
					$value['ammount'] = 	round($this->mdl_common->getUSAmountFromMex($value['ammount']), 2);		
				}
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}

	function getEntrepreneurialAmount($date){
		$from = date($date);

		$exitvar = date('d', strtotime($from ));
		if($exitvar !=10){
			return;
		}

		$from = date('Y-m-d H:i:s', strtotime($date . ' +2 hours'));
		$from = date('Y-m-d H:i:s', strtotime($from . ' -15 day'));
		$to = date('Y-m-d H:i:s', strtotime($from . ' +10 day'));
		$list = $this->mdl_common->allSelects('SELECT   a.module_bonus, b.user_name From interpreneurial_bonus_module as a RIGHT JOIN user_master as b on a.user_id = b.user_id WHERE  a.molude_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
				if($country=='MEX'){
					$value['module_bonus'] = 	round($this->mdl_common->getUSAmountFromMex($value['module_bonus']), 2);		
				}
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
		
	}


	function getInsertDailyReport(){
		//$Date = date('Y-m-d');
		
		$Date = date('Y-m-d H:i:s', mktime(date("02"), date("00"), date("00"), date("m"), date("d") - 1, date("Y")));
		// $to = date('Y-m-d H:i:s', strtotime($Date . ' +1 day'));
		// echo $Date.'<br><br>'.$to;
		// return;
		//$Date = date('2015-10-9');
		$totalU = $this->mdl_common->allSelects('SELECT SUM(amount) as total from upgrade_user_details where upgrade_at >="'.$Date.'"');
		if(isset($totalU) && !empty($totalU) && $totalU != null){
			foreach ($totalU as $value) {
				if(!empty($value['total'])){
					$totalUpgrade = $value['total'];
				}else{
					$totalUpgrade = 0;
				}
			}		
		}else{
			$totalUpgrade = 0;
		}

		$totalP = $this->mdl_common->allSelects('SELECT SUM(subtotal) as total from product_purchase_info where purchase_at >="'.$Date.'"');
		if(isset($totalP) && !empty($totalP) && $totalP != null){
			foreach ($totalP as $value) {
				//$totalProduct = $value['total'];
				if(!empty($value['total'])){
					$totalProduct = $value['total'];
				}else{
					$totalProduct = 0;
				}
			}		
		}else{
			$totalProduct = 0;
		}


		$totalRegistration = 0;
		$totalR = $this->mdl_common->allSelects('SELECT shipping_package_id, user_name from shipping_management_table  where type = "Registration" AND created_at >="'.$Date.'"');
		if(isset($totalR) && !empty($totalR)){
			foreach ($totalR as $key => $value) {
						$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
						$totalRegistration += 	$this->mdl_common->planPrice($value['shipping_package_id'],$country);		
			}
		}


		// $totalR = $this->mdl_common->allSelects('SELECT SUM(entry_ammout) as total from shipping_management_table as a LEFT JOIN  package_info as b on a.shipping_package_id = b.package_id where a.type = "Registration" AND a.created_at >="'.$Date.'"');


		// //$totalR = $this->mdl_common->allSelects('SELECT SUM(total_amount) as total from earning_info where eaning_created >="'.$Date.'"');
		// if(isset($totalR) && !empty($totalR) && $totalR != null){
		// 	foreach ($totalR as $value) {
		// 		//$totalRegistration = $value['total'];
		// 		if(!empty($value['total'])){
		// 			$totalRegistration = $value['total'];
		// 		}else{
		// 			$totalRegistration = 0;
		// 		}
		// 	}		
		// }else{
		// 	$totalRegistration = 0;
		// }


		$totalIncome = $totalUpgrade + $totalProduct + $totalRegistration;

		$totalFastStart = 0;
		$totalF = $this->mdl_common->allSelects('SELECT   a.referral_bonus, b.user_name From referral_bonus as a RIGHT JOIN user_master as b on a.parent_id = b.user_id WHERE a.created_at >="'.$Date.'"');
		if(isset($totalF) && !empty($totalF)){
			foreach ($totalF as $key => $value) {
				$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
				if($country=='MEX'){
					$value['referral_bonus'] = 	round($this->mdl_common->getUSAmountFromMex($value['referral_bonus']), 2);		
				}
				$totalFastStart += $value['referral_bonus'];
			}
			
		}


		// $totalF = $this->mdl_common->allSelects('SELECT SUM(referral_bonus) as total from referral_bonus where  created_at >="'.$Date.'"');
		// if(isset($totalF) && !empty($totalF) && $totalF != null){
		// 	foreach ($totalF as $value) {
		// 		//$totalFastStart = $value['total'];
		// 		if(!empty($value['total'])){
		// 			$totalFastStart = $value['total'];
		// 		}else{
		// 			$totalFastStart = 0;
		// 		}
		// 	}		
		// }else{
		// 	$totalFastStart = 0;
		// }

	

		$totalCoded = 0;

		$totalBinary = 0;

		$BinaryDate = date('Y-m-d H:i:s', strtotime($Date . ' +2 hours'));

		$totalB = $this->mdl_common->allSelects('SELECT  DISTINCT a.ammount, b.user_name From binary_deduction as a RIGHT JOIN user_master as b on a.parent_id = b.user_id WHERE a.deducted_at >="'.$BinaryDate.'"');
		if(isset($totalB) && !empty($totalB)){
			foreach ($totalB as $key => $value) {
				$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
				if($country=='MEX'){
					$value['ammount'] = 	round($this->mdl_common->getUSAmountFromMex($value['ammount']), 2);		
				}
				$totalBinary += $value['ammount'];
			}
		}

		// $totalB = $this->mdl_common->allSelects('SELECT SUM(ammount) as total from binary_deduction where  	deducted_at >="'.$Date.'"');
		// if(isset($totalB) && !empty($totalB) && $totalB != null){
		// 	foreach ($totalB as $value) {
		// 		//$totalBinary = $value['total']/2;
		// 		if(!empty($value['total'])){
		// 			$totalBinary = $value['total']/2;
		// 		}else{
		// 			$totalBinary = 0;
		// 		}
		// 	}		
		// }else{
		// 	$totalBinary = 0;
		// }
		$totalEntrepreneurial = 0;
		$from = date($Date);

		$exitvar = date('d', strtotime($from ));
		if($exitvar ==10){
			
			$from = date('Y-m-d H:i:s', strtotime($Date . ' -15 day'));
			$to = date('Y-m-d H:i:s', strtotime($from . ' +10 day'));

			
			$totalE = $this->mdl_common->allSelects('SELECT   a.module_bonus, b.user_name From interpreneurial_bonus_module as a RIGHT JOIN user_master as b on a.user_id = b.user_id WHERE  a.molude_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($totalE) && !empty($totalE)){
				foreach ($totalE as $key => $value) {
					$country = $this->mdl_common->getCountryByUserNameInUserMaster($value['user_name']);
					if($country=='MEX'){
						$value['module_bonus'] = 	round($this->mdl_common->getUSAmountFromMex($value['module_bonus']), 2);		
					}
					$totalEntrepreneurial += $value['module_bonus'];
				}
			}
		}


		// $totalE = $this->mdl_common->allSelects('SELECT SUM(module_bonus) as total from interpreneurial_bonus_module where  	molude_created_at BETWEEN "'.$from.'" AND "'.$to.'"');
		// if(isset($totalE) && !empty($totalE) && $totalE != null){
		// 	foreach ($totalE as $value) {
		// 		//$totalEntrepreneurial = $value['total'];
		// 		if(!empty($value['total'])){
		// 			$totalEntrepreneurial = $value['total'];
		// 		}else{
		// 			$totalEntrepreneurial = 0;
		// 		}
		// 	}		
		// }else{
		// 	$totalEntrepreneurial = 0;
		// }

		$totalMatching = 0;


		$totalPaid = $totalFastStart + $totalCoded + $totalBinary  + $totalEntrepreneurial + $totalMatching;

		$totalProfit = $totalIncome - $totalPaid;



		$insertArr = array(
				'total_income'=>$totalIncome,
				'fast_start'=>$totalFastStart,
				'bv'=>$totalBinary,
				'coded'=>$totalCoded,
				'entrepreneurial'=>$totalEntrepreneurial,
				'matching'=>$totalMatching,
				'total_paid'=>$totalPaid,
				'total_profit'=>$totalProfit,
				'date'=>$Date,
			);
		
		$this->db->insert('daily_report_for_admin', $insertArr);
				  
	


		
	}


	function getDailyReportList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT * From daily_report_for_admin WHERE created_at BETWEEN "'.$from.'" AND "'.$to.'" ORDER BY daily_report_id DESC');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT * From daily_report_for_admin ORDER BY daily_report_id DESC');
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



	
	


}