<?php
/**
* 
*/
class Ether_Wallet extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function getEtherWalletForUser(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM  ether_wallet   where user_id='.$this->session->userdata('user_id'));
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	

	function walletReportByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master as a RIGHT JOIN store_credit_report_info as b on b.user_id=a.user_id  where b.user_id='.$id);
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

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
}