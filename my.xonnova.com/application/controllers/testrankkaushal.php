<?php

/**
* 
*/
class Testrankkaushal extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function getRankUser(){

	}
	
	function countUserRank($startId=null,$level=null){	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
	    $i = null;
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
				$coutnLevel = $this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND direct_sponsor='.$value['user_id'].' AND member_rank >='.$level.' AND unilevel_rant_created >='.date('Y-m-d'));	
	    		if(!empty($coutnLevel)){
	    			$x = count($coutnLevel);	   
	    			if(!empty($x) && $x >= 1){
	    				$i++;
	    			} 			
	    		}
	    	}
	    }
	    return $i;
	}
	
	function getUserRank(){
		$userId = $this->session->userdata('user_id');
		$package = $this->mdl_common->getUserPackageById($userId);

		$level = $this->mdl_common->countUserLevel('earning_info',$userId);
		if(!empty($package) && $package >=6){
			$package = $level;
		}else{
			$package = $package;
		}
		$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
		$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
		$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;

		$lftChild = $this->mdl_common->leftChild($userId);
		$rghtChild = $this->mdl_common->rightChild($userId);

		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary;

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary;
		
		/*if($leftUserTotal > $currentUserTotalBinaryPercent && $rightUserTotal > $currentUserTotalBinaryPercent){
			$leftUserTotal = $currentUserTotalBinaryPercent;
			$rightUserTotal =$currentUserTotalBinaryPercent;

		}*/
		$level1 = $level;
		if($level1 == 1){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 2){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 3){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 4){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV', 'requiredDiff'=>'Required QV to compleate level ','labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 5){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV', 'requiredDiff'=>'Required QV to compleate level ','labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 6){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>2,'total'=>$total,'labelText'=>'Total Team Lead Member', 'requiredDiff'=>'Required Team Lead  Member to compleate level', 'labelTextRequired'=>'Total Team Lead Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 7){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Director Member', 'requiredDiff'=>'Required Director  Member to compleate level',  'labelTextRequired'=>'Total Director  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 8){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Regional Member', 'requiredDiff'=>'Required Regional  Member to compleate level',  'labelTextRequired'=>'Total Regional  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 9){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total National Member', 'requiredDiff'=>'Required International Member Member to compleate level', 'labelTextRequired'=>'Total National  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 10){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total International Member', 'requiredDiff'=>'Required International  Member to compleate level',  'labelTextRequired'=>'Total International  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 11){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total VP Member',  'requiredDiff'=>'Required President Member to compleate level', 'labelTextRequired'=>'Total President Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 12){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total P Member', 'requiredDiff'=>'Required Ambasdor Member to compleate level',  'labelTextRequired'=>'Required Ambasdor Member to compleate level');

			echo json_encode($data);
		}

		
	}
	
	function totalQV($where){
		$allData = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id ='.$where);
		//$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 WHERE a.user_id ='.$where);
		$dateTime = date('Y-m-d H:i:s');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			if(!empty($package) && $package >=6){
				$package = $level;
			}else{
				$package = $package;
			}
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

	function getAllUserRank($id){
		$userId = $id;
		$package = $this->mdl_common->getUserPackageById($userId);

		$level = $this->mdl_common->countUserLevel('earning_info',$userId);
		$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
		$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
		$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;

		$lftChild = $this->mdl_common->leftChild($userId);
		$rghtChild = $this->mdl_common->rightChild($userId);

		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary;

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary;
		
		/*if($leftUserTotal > $currentUserTotalBinaryPercent && $rightUserTotal > $currentUserTotalBinaryPercent){
			$leftUserTotal = $currentUserTotalBinaryPercent;
			$rightUserTotal =$currentUserTotalBinaryPercent;

		}*/
		$level1 = $level;
		if($level1 == 1){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 2){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 3){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV','requiredDiff'=>'Required QV to compleate level ', 'labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 4){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV', 'requiredDiff'=>'Required QV to compleate level ','labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 5){
			//$total = $rightUserTotal + $leftUserTotal;
			$total = $this->totalQV($userId);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total QV', 'requiredDiff'=>'Required QV to compleate level ','labelTextRequired'=>'Total QV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 6){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>2,'total'=>$total,'labelText'=>'Total Team Lead Member', 'requiredDiff'=>'Required Team Lead  Member to compleate level', 'labelTextRequired'=>'Total Team Lead Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 7){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Director Member', 'requiredDiff'=>'Required Director  Member to compleate level',  'labelTextRequired'=>'Total Director  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 8){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Regional Member', 'requiredDiff'=>'Required Regional  Member to compleate level',  'labelTextRequired'=>'Total Regional  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 9){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total National Member', 'requiredDiff'=>'Required International Member Member to compleate level', 'labelTextRequired'=>'Total National  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 10){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total International Member', 'requiredDiff'=>'Required International  Member to compleate level',  'labelTextRequired'=>'Total International  Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 11){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total VP Member',  'requiredDiff'=>'Required President Member to compleate level', 'labelTextRequired'=>'Total President Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 12){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total P Member', 'requiredDiff'=>'Required Ambasdor Member to compleate level',  'labelTextRequired'=>'Required Ambasdor Member to compleate level');

			echo json_encode($data);
		}		
	}
	
	function getUserRank1(){
		$userId = $this->session->userdata('user_id');
		$package = $this->mdl_common->getUserPackageById($userId);

		$level = $this->mdl_common->countUserLevel('earning_info',$userId);
		$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
		$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
		$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;

		$lftChild = $this->mdl_common->leftChild($userId);
		$rghtChild = $this->mdl_common->rightChild($userId);

		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary;

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary;
		
		/*if($leftUserTotal > $currentUserTotalBinaryPercent && $rightUserTotal > $currentUserTotalBinaryPercent){
			$leftUserTotal = $currentUserTotalBinaryPercent;
			$rightUserTotal =$currentUserTotalBinaryPercent;

		}*/
		$level1 = $level;
		if($level1 == 1){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 2){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 3){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 4){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 5){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 6){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>2,'total'=>$total,'labelText'=>'Total Team Lead Member', 'labelTextRequired'=>'Required Team Lead Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 7){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Director Member', 'labelTextRequired'=>'Required Director Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 8){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Regional Member', 'labelTextRequired'=>'Required Regional Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 9){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total National Member', 'labelTextRequired'=>'Required National Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 10){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total International Member', 'labelTextRequired'=>'Required International Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 11){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total VP Member', 'labelTextRequired'=>'Required VP Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 12){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total P Member', 'labelTextRequired'=>'Required P Member Member to compleate level');

			echo json_encode($data);
		}

		
	}
	
	function getAllUserRank1($id){
		$userId = $id;
		$package = $this->mdl_common->getUserPackageById($userId);

		$level = $this->mdl_common->countUserLevel('earning_info',$userId);
		$levelExitPrice = $this->mdl_common->getLevelExitPrice($package);
		$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfPackage($package);
		$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;

		$lftChild = $this->mdl_common->leftChild($userId);
		$rghtChild = $this->mdl_common->rightChild($userId);

		$totalLeftDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$lftChild);
		$leftUserTotal = $leftUserTotalSaleBinary + $leftUserTotalReferralBinary;

		$totalRightDeductBinary = $this->mdl_common->totalRightBinaryDeduction('SELECT SUM(binary_point) as binary_point FROM binary_deduction where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalSaleBinary = $this->mdl_common->totalSaleBinary('SELECT SUM(sale_binary_point) as sale_binary_point FROM product_sale_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotalReferralBinary = $this->mdl_common->totalReferralBinary('SELECT SUM(referral_binary) as referral_binary FROM referrals_binary where parent_id='.$userId.' and user_id='.$rghtChild);
		$rightUserTotal = $rightUserTotalSaleBinary + $rightUserTotalReferralBinary;
		
		/*if($leftUserTotal > $currentUserTotalBinaryPercent && $rightUserTotal > $currentUserTotalBinaryPercent){
			$leftUserTotal = $currentUserTotalBinaryPercent;
			$rightUserTotal =$currentUserTotalBinaryPercent;

		}*/
		$level1 = $level;
		if($level1 == 1){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 2){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 3){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 4){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 5){
			$total = $rightUserTotal + $leftUserTotal;
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>$levelExitPrice,'total'=>$total,'labelText'=>'Total BV', 'labelTextRequired'=>'Required BV to compleate level ');

			echo json_encode($data);
		}elseif($level1 == 6){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>2,'total'=>$total,'labelText'=>'Total Team Lead Member', 'labelTextRequired'=>'Required Team Lead Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 7){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Director Member', 'labelTextRequired'=>'Required Director Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 8){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total Regional Member', 'labelTextRequired'=>'Required Regional Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 9){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total National Member', 'labelTextRequired'=>'Required National Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 10){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total International Member', 'labelTextRequired'=>'Required International Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 11){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total VP Member', 'labelTextRequired'=>'Required VP Member Member to compleate level');

			echo json_encode($data);
		}elseif($level1 == 12){
			$total = $this->countUserRank($userId, $level);
			$currentRank = $this->mdl_common->getCurrentRankById($level);
			$data = array('level'=>$level,'currentRank'=>$currentRank,'required'=>5,'total'=>$total,'labelText'=>'Total P Member', 'labelTextRequired'=>'Required P Member Member to compleate level');

			echo json_encode($data);
		}

		
	}


}