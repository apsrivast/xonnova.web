<?php 
/**
* 
*/
class EtherReport extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getEtherWalletTotalByUser($id){
		$temp = $this->mdl_common->allSelects('SELECT sum(credit) as total from ether_wallet WHERE wallet_type="1" AND user_id='.$id);
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	
				$total = $total['total'] ;
			}
		}else{
			$total = 0;
		}
		return $total;
	}
	function getEtherWalletReportByID(){
		header('Content-Type: application/json');
		$id = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id, b.user_name, b.user_email FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE a.user_id='.$id.' ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$totalether = $this->getEtherWalletTotalByUser($value['user_id']);
				if(!empty($totalether)){
					$value['totalEther'] = $totalether;
					$arr[] = $value;					
				}
			}
			echo json_encode($arr);
		}
	}

	public function exportByID() {
		$this->load->library('excel');
		$id = $this->session->userdata('user_id');
		$titles = array(
			'User ID', 'User Name', 'Email-ID', 'Total'
		);
		$array = array();
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id, b.user_name, b.user_email FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE a.user_id='.$id.' ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$totalether = $this->getEtherWalletTotalByUser($value['user_id']);
				if(!empty($totalether)){
					$value['totalEther'] = $totalether;
					$array[] = $value;					
				}
			}
		}
		$this->excel->make_from_array($titles, $array);
	}
	
	function getEtherWalletReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id, b.user_name, b.user_email FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$totalether = $this->getEtherWalletTotalByUser($value['user_id']);
				if(!empty($totalether)){
					$value['totalEther'] = $totalether;
					$arr[] = $value;					
				}
			}
			echo json_encode($arr);
		}
	}

	public function export() {
		$this->load->library('excel');

		$titles = array(
			'User ID', 'User Name', 'Email-ID', 'Total'
		);
		$array = array();
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id, b.user_name, b.user_email FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$totalether = $this->getEtherWalletTotalByUser($value['user_id']);
				if(!empty($totalether)){
					$value['totalEther'] = $totalether;
					$array[] = $value;					
				}
			}
		}
		$this->excel->make_from_array($titles, $array);
	}

	function getEtherWalletReportByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name as user_name FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE a.user_id='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$arr[] = $value;
			}
			echo json_encode($arr);
		}
	}


	public function exportByUser($id) {
		$this->load->library('excel');

		$titles = array(
			'ID', 'User Name', 'Credit Balance', 'Description', 'Date'
		);
		$array = array();
		$contentData = $this->mdl_common->allSelects('SELECT a.credit_v_id, b.user_name as user_name, a.credit, a.message, a.wallet_credited_at  FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id WHERE a.user_id='.$id.' ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$array[] = $value;
			}
		}
		$this->excel->make_from_array($titles, $array);
	}
}