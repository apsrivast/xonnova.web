<?php
/**
* 
*/
class PendingEarningReport extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getPendingBalanceReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.*, b.user_name as user_name, c.user_name as reference_name FROM earning_details_by_user_pending as a LEFT JOIN user_master as b on b.user_id=a.user_id LEFT JOIN user_master as c on c.user_id=a.ref_id');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$arr[] = $value;
			}
			echo json_encode($arr);
		}
	}

	function getPendingBalance(){
		header('Content-Type: application/json');
		$total = $this->pendingBalance();
		echo json_encode($total);
	}

	function pendingBalance(){
		$temp = $this->mdl_common->allSelects('SELECT sum(amount) as amount from earning_details_by_user_pending');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	
				return $total['amount'] ;
			}
		}else{
			return 0;
		}
	}

	public function export() {
		$this->load->library('excel');

		$titles = array(
			'ID', 'To User', 'From User', 'Pending Balance', 'Description', 'Date'
		);
		$array = array();
		$contentData = $this->mdl_common->allSelects('SELECT a.e_d_b_u_id, b.user_name as user_name, c.user_name as reference_name, a.amount, a.description, a.e_d_b_u_date  FROM earning_details_by_user_pending as a LEFT JOIN user_master as b on b.user_id=a.user_id LEFT JOIN user_master as c on c.user_id=a.ref_id ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$array[] = $value;
			}
		}
		$this->excel->make_from_array($titles, $array);
	}
}