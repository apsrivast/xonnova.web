<?php

/**
* 
*/
class Bonus_six_cron_job extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	////////////cronjob on 25th
	function ResidualMatrixBonus(){
		/*$contentData = $this->mdl_common->allSelects('SELECT user_id FROM user_master ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$subscription_status = $this->mdl_common->get_subscription_status($value['user_id']);
				if($subscription_status){
					$this->callResidualMatrixBonus( 0, $value['user_id']);
				}
			}
		}*/
	}

	function callResidualMatrixBonus( $count, $userid){
		if($count < 30){
			$sponserId = $this->mdl_common->getAllParent($userid);
			$count++;
			if($sponserId > 1){
				$subscription_status = $this->mdl_common->get_subscription_status($sponserId);
				if($subscription_status){
					$this->insertResidualMatrixBonusAmount($sponserId);
				}
				$this->callResidualMatrixBonus( $count, $sponserId);
			}
		}
	}


	function insertResidualMatrixBonusAmount($userId){
			$inserBonus = array(
				'user_id'=>$userId,
				'amount'=> 0.25,
			);
			$this->db->insert('residual_matrix_bonus',$inserBonus);
	}	




	////////////cronjob on 27th
	function MatchingBonus(){
		$contentData = $this->mdl_common->allSelects('SELECT user_id FROM user_master ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$subscription_status = $this->mdl_common->get_subscription_status($value['user_id']);
				if($subscription_status){
					$this->callMatchingBonus( $value['user_id']);
				}
			}
		}
	}

	function callMatchingBonus($userid){
		$sponserId = $this->mdl_common->getAllParent($userid);
		if($sponserId > 1){
			$subscription_status = $this->mdl_common->get_subscription_status($sponserId);
			if($subscription_status){
				$amount = $this->mdl_common->get_first_matching_amount($userid);
				$secondAmount = $this->mdl_common->get_second_matching_amount($userid);
				$this->insertMatchingBonusAmount($sponserId, $amount);
			}
			$this->callSecondMatchingBonus( 0, $sponserId, $secondAmount);
		}
	}

	function callSecondMatchingBonus($count, $userid, $secondAmount){
		if($count < 3){
			$sponserId = $this->mdl_common->getAllParent($userid);
			$count++;
			if($sponserId > 1){
				$subscription_status = $this->mdl_common->get_subscription_status($sponserId);
				if($subscription_status){
					$this->insertMatchingBonusAmount($sponserId, $secondAmount);
				}
				$this->callSecondMatchingBonus($count, $sponserId, $secondAmount);
			}
		}
	}



	function insertMatchingBonusAmount($userId, $amount){
		if($amount > 0){
			$inserBonus = array(
				'user_id'=>$userId,
				'amount'=> $amount,
			);
			$this->db->insert('matching_bonus',$inserBonus);
		}
	}	




	////////////cronjob on 1st
	function paidMatchingBonus(){
		$contentData = $this->mdl_common->allSelects('SELECT user_id FROM user_master ');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$subscription_status = $this->mdl_common->get_subscription_status($value['user_id']);
				if($subscription_status){
					$ResidualAmount = $this->mdl_common->get_residual_amount($value['user_id']);
					$MatchingAmount = $this->mdl_common->get_matching_amount($value['user_id']);
					//$this->insertBonusAmount( $value['user_id'], $ResidualAmount,  'Residual Matrix Bonus');
					$this->insertBonusAmount( $value['user_id'], $MatchingAmount,  'Matching Bonus');
				}
			}
		}
	}


	function insertBonusAmount2($sId, $amount, $mesg){
		$sAmount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sId);
		if(isset($sAmount) && !empty($sAmount)){
			foreach ($sAmount as $total) {						
				$arr = array(
					'total_balance'=>$total['total_balance'] + $amount,
				);
				$this->db->update('earning_info',$arr,array('user_id'=>$sId));
				$arr2 = array(
						'user_id'=>$sId,
						//'ref_id'=>$userId,
						//'type_id'=>'1',
						'description'=>$mesg,
						'amount'=>$amount,
					);
				$this->db->insert('earning_details_by_user',$arr2);
			}
		}
	}	



	function insertBonusAmount($sId, $amount, $mesg){
		// $sAmount = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sId);
		// if(isset($sAmount) && !empty($sAmount)){
		// 	foreach ($sAmount as $total) {						
		// 		$arr = array(
		// 			'total_balance'=>$total['total_balance'] + $amount,
		// 		);
		// 		$this->db->update('earning_info',$arr,array('user_id'=>$sId));
				$arr2 = array(
						'user_id'=>$sId,
						//'ref_id'=>$userId,
						//'type_id'=>'1',
						'description'=>$mesg,
						'amount'=>$amount,
					);
				$this->db->insert('earning_details_by_user_pending',$arr2);
		// 	}
		// }
	}	




	function testCronJob(){
				$arr2 = array(
						'user_id'=>1,
						
					);
				$this->db->insert('old_deposit_info',$arr2);
	}	








	
	
	
	
}