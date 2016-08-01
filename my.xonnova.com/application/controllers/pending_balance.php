<?php
/**
* 
*/
class Pending_balance extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	////cron job dalily 00:00:01
	function cronjob_fast_sales_bonus(){
		$totalU = $this->mdl_common->allSelects('SELECT user_id, created_at from user_master ');
		if(isset($totalU) ){
			foreach ($totalU as $key => $value) {
				$val = (new DateTime())->diff(new DateTime($value['created_at']))->format("%a");
				if( $val % 30 == 0){
					$payid = ($val / 30 == 1) ? 1 : 2 ;
					$valout = date('Y-m-d', strtotime(date('Y-m-d') . ' -30 day'));
					$totalCP = $this->mdl_common->allSelects('SELECT SUM(cp) as total from csv_fast_sales_bonus where user_id = '.$value['user_id'].' and at >  "'.$valout.'"');
					if(isset($totalCP)){
						foreach ($totalCP as $valueCP) {
							if(isset($valueCP['total'])){
								if($valueCP['total'] >= 10){
									($payid == 1) ? $this->insert_fast_sales($value['user_id'], 1000) : $this->insert_fast_sales($value['user_id'], 500);
								}elseif ($valueCP['total'] >= 5) {
									($payid == 1) ? $this->insert_fast_sales($value['user_id'], 400) : $this->insert_fast_sales($value['user_id'], 200);
								}
							}
						}		
					}
				}
			}		
		}
	}

	function insert_fast_sales($userId, $amount){
		$inserBonus = array(
			'user_id'=>$userId,
			'amount'=> $amount,
		);
		$this->db->insert('csv_fast_sales_bonus_pending',$inserBonus);
	}	
	/////cronjob on 10 th 00:00:01
	function cronjob_fast_sales(){
		$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . 'last month'));
    	$contentData = $this->mdl_common->allSelects('SELECT * from csv_fast_sales_bonus_pending where  m_b_time >= "'.$date.'"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr2 = array(
						'user_id'=>$value['user_id'],
						'description'=>'Fast Sales Bonus',
						'amount'=>$value['amount'],
					);
				$this->db->insert('earning_details_by_user_pending',$arr2);
			}
		}
	}



	function admingetPendingBalance(){
		$contentData = $this->mdl_common->allSelects('SELECT user_id, user_name FROM user_master ORDER BY user_id ASC');
		foreach ($contentData as $value) {
			$value['pending_balance'] = $this->mdl_common->pendingBalance($value['user_id']);
			if(isset($value['pending_balance']) && !empty($value['pending_balance'])){
				$arr[]=$value;
			}
		}
		echo json_encode($arr);
	}




	function admingetPendingBalance2222(){
		$contentData = $this->mdl_common->allSelects('SELECT user_id, user_name FROM user_master ORDER BY user_id ASC');
		foreach ($contentData as $value) {
			$value['pending_balance'] = $this->mdl_common->pendingBalance($value['user_id']);
			$arr[]=$value;
		}
		echo json_encode($arr);
	}



	function admingetEarningReportByUserApproved($id){
		$contentData = $this->mdl_common->allSelects('SELECT * from earning_details_by_user_pending where user_id = '.$id.'  ORDER BY e_d_b_u_date DESC');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[]=$value;
				}
			echo json_encode($arr);
		}else{

		}
	}
	

	function getPendingBalance(){
		// $contentData = $this->mdl_common->allSelects('SELECT a.*, b.* FROM user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id where a.user_id='.$this->session->userdata('user_id'));
		// foreach ($contentData as $value) {
		// 	$value['approved_balance'] = $this->mdl_common->approvedBalance($this->session->userdata('user_id'));
		// 	$arr[]=$value;
		// }
		// echo json_encode($arr);


		header('Content-Type: application/json');
		$total = $this->mdl_common->pendingBalance($this->session->userdata('user_id'));
		echo json_encode($total);
	}



	function getEarningReportByUserApproved(){
		$id = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT * from earning_details_by_user_pending where user_id = '.$id.'  ORDER BY e_d_b_u_date DESC');
		if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$arr[]=$value;
				}
			echo json_encode($arr);
		}else{

		}
	}

	////////////corn job daily 00:01
	function PendingBalance(){
		$date = date('Y-m-d');
    	$date = date('Y-m-d', strtotime($date . ' -17 day'));
		$contentData = $this->mdl_common->allSelects('SELECT * from earning_details_by_user_pending where  e_d_b_u_date < "'.$date.'"');
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$TotalBalance =  $this->mdl_common->getTotalBalance($value['user_id']);	
				$arr = array(
					'total_balance'=>$TotalBalance + $value['amount'],
				);
				$this->db->update('earning_info',$arr,array('user_id'=>$value['user_id']));
				$arr2 = array(
						'user_id'=>$value['user_id'],
						'ref_id'=>$value['ref_id'],
						'type_id'=>$value['type_id'],
						'description'=>$value['description'],
						'amount'=>$value['amount'],
						'current_balance'=>$this->mdl_common->getTotalBalance($value['user_id']),
					);
				$this->db->insert('earning_details_by_user',$arr2);

				$this->db->delete('earning_details_by_user_pending',array('e_d_b_u_id'=>$value['e_d_b_u_id']));
			}
		}
	}


	function releasePendingBalanceByUser($userId=null){
		$date = date('Y-m-d H:i:s');
    	//$date = date('Y-m-d', strtotime($date . ' -17 day'));
		$contentData = $this->mdl_common->allSelects('SELECT * from earning_details_by_user_pending where  e_d_b_u_date <= "'.$date.'" AND user_id='.$userId);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$TotalBalance =  $this->mdl_common->getTotalBalance($value['user_id']);	
				$arr = array(
					'total_balance'=>$TotalBalance + $value['amount'],
				);
				$this->db->update('earning_info',$arr,array('user_id'=>$value['user_id']));
				$arr2 = array(
						'user_id'=>$value['user_id'],
						'ref_id'=>$value['ref_id'],
						'type_id'=>$value['type_id'],
						'description'=>$value['description'],
						'amount'=>$value['amount'],
						'current_balance'=>$this->mdl_common->getTotalBalance($value['user_id']),
					);
				$this->db->insert('earning_details_by_user',$arr2);

				$this->db->delete('earning_details_by_user_pending',array('e_d_b_u_id'=>$value['e_d_b_u_id']));
				
				//print_r($arr2);
                                echo json_encode("True");
			}
		}
	}

	
}