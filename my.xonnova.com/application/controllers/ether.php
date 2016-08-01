<?php 
/**
* 
*/
class Ether extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
		header('Content-Type: application/json');
	}

	function getEtherWallet(){
		$temp = $this->mdl_common->allSelects('SELECT sum(credit) as total from ether_wallet WHERE wallet_type="1"');
		if(isset($temp) && !empty($temp)){
			foreach ($temp as $total) {	
				$total = $total['total'] ;
			}
		}else{
			$total = 0;
		}
		echo json_encode($total);
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

	function getEtherWalletReport1(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.*, b.user_name as user_name FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id');
		$arr = null;
		if(!empty($contentData)){
			$arr .= '[';
			$i = 1;
			foreach ($contentData as $key=>$value) {	
				$arr .= '{"credit_v_id":"'.$i.'","user_id":"'.$value['user_id'].'","credit":"'.$this->getEtherWalletTotalByUser($value['user_id']).'","message":"'.$value['message'].'","wallet_type":"'.$value['wallet_type'].'","wallet_credited_at":"'.$value['wallet_credited_at'].'","user_name":"'.$value['user_name'].'"}';
				
				if($i < count($contentData)){
					$arr .= ",";
				}
				$i++;
			}
			$arr .= ']';
			echo $arr;
		}
	}

	function getEtherWalletReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT a.*, b.user_name as user_name FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$arr[] = $value;
			}
			echo json_encode($arr);
		}
	}

	public function export() {
		$this->load->library('excel');

		$titles = array(
			'ID', 'To User', 'Credit Balance', 'Description', 'Date'
		);
		$array = array();
		$contentData = $this->mdl_common->allSelects('SELECT a.credit_v_id, b.user_name as user_name, a.credit, a.message, a.wallet_credited_at  FROM ether_wallet as a LEFT JOIN user_master as b on b.user_id=a.user_id ORDER BY a.user_id ASC');
		if(!empty($contentData)){
			foreach ($contentData as $key=>$value) {	
				$array[] = $value;
			}
		}
		$this->excel->make_from_array($titles, $array);
	}
}