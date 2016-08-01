<?php
/**
* 
*/
class Mxtopup_bonus extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$id = $this->session->userdata('user_id');
		$total = $this->getTotalWallet($id) - $this->getTotalDeductWallet($id) ;
		echo json_encode($total);
	}

	function getConversionRateData(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM mxtopup_rate LIMIT 0 , 1');
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
		$updateArr = array(
				'telcel'=>$_POST['telcel'],
				'movistar'=>$_POST['movistar'],
				'iusacell'=>$_POST['iusacell'],
				'unefon'=>$_POST['unefon'],
				'nextel'=>$_POST['nextel'],
				'virgin'=>$_POST['virgin'],
				'cierto'=>$_POST['cierto'],
				'maztiempo'=>$_POST['maztiempo'],
				'tuenti'=>$_POST['tuenti'],
			);
		if(!$this->db->update('mxtopup_rate',$updateArr,array('id'=>$_POST['id']))){
			$data = array('message'=>'Error... MxTopUp Rate Setting Not Updated!');
		}else{
			$data = array('message'=>'MxTopUp Rate Setting Updated sucessfully!');				
		}
		echo json_encode($data);
	}

	function creditwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
	
		$id = $this->mdl_common->resellerID($_POST['user_name']);
		if($id == 111000){
			$data = array('error'=>'User Not exist');
			echo json_encode($data);	
			return;
		}

		if(!empty($id) && !empty($_POST['credit'])){
			
			$Arr = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['credit'],
					'wallet_type'=>'1',
					'message'=>$_POST['message'],
				);
			$this->db->insert('mxtopup_bonus_info',$Arr);

			$existUser = count($this->mdl_common->allSelects('SELECT * FROM mxtopup_bonus_user_map_info WHERE user_id='.$id));
			if(empty($existUser) && $existUser == 0){
				$insertwallete = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
				);
				$this->db->insert('mxtopup_bonus_user_map_info',$insertwallete);
			}

			$data = array('message'=>'Wallet Amount Credited To '.$_POST['user_name'].' Account!');
			echo json_encode($data);
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not Credited To '.$_POST['user_name'].' valette');
			echo json_encode($data);
		}
	}

	function deductwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
	
		$id = $this->mdl_common->resellerID($_POST['user_name']);
		if($id == 111000){
			$data = array('error'=>'User Not exist');
			echo json_encode($data);	
			return;
		}
		if(!empty($id) && !empty($_POST['credit'])){
			$Arr = array(
				'user_id'=>$id,
				'admin_id'=>$this->session->userdata('user_id'),
				'credit'=>$_POST['credit'],
				'wallet_type'=>'2',
				'message'=>$_POST['message'],
			);
			$this->db->insert('mxtopup_bonus_info',$Arr);

			$existUser = count($this->mdl_common->allSelects('SELECT * FROM mxtopup_bonus_user_map_info WHERE user_id='.$id));
			if(empty($existUser) && $existUser == 0){
				$insertwallete = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
				);
				$this->db->insert('mxtopup_bonus_user_map_info',$insertwallete);
			}


			$data = array('message'=>'Wallet Amount Deducted from '.$_POST['user_name'].' Account!');
			echo json_encode($data);
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not deduct from valette');
			echo json_encode($data);
		}
	}



	function walletReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name From mxtopup_bonus_user_map_info as d LEFT JOIN  reseller_store as a on d.user_id= a.user_id ');
		
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$value['total'] = $this->getTotalWallet($value['user_id']) - $this->getTotalDeductWallet($value['user_id']) ;
				$arr[] = $value;
			}
			echo json_encode($arr);
		}
		
	}
	function walletReportByUser2(){
		$this->walletReportByUser($this->session->userdata('user_id'));
	}

	function walletReportByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM  mxtopup_bonus_info   where user_id='.$id);
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
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM mxtopup_bonus_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductWallet($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM mxtopup_bonus_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}
	
	// function walletReportByUser2(){
	// 	header('Content-Type: application/json');
	// 	$contentData = $this->mdl_common->allSelects('SELECT * FROM  mxtopup_bonus_info   where user_id='.$this->session->userdata('user_id'));
	// 	if(!empty($contentData)){
	// 		foreach ($contentData as $key => $value) {
	// 			$arr[]=$value;
	// 		}
	// 		echo json_encode($arr);
	// 	}else{

	// 	}
	// }

	// function getCreditwallet(){
	// 	header('Content-Type: application/json');
	// 	$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, d.* From mxtopup_bonus_info as d LEFT JOIN  reseller_store as a on d.user_id= a.user_id  WHERE d.wallet_type="1"');
	// 	if(isset($getData) && !empty($getData)){
	// 	foreach ($getData as $key => $value) {
	// 		$arr[] = $value;
	// 	}
	// 	echo json_encode($arr);
	// 	}else{

	// 	}
	// }

	// function getDeletewallet(){
	// 	header('Content-Type: application/json');
	// 	$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, d.* From mxtopup_bonus_info as d LEFT JOIN  reseller_store as a on d.user_id= a.user_id  WHERE d.wallet_type="2"');
	// 	if(isset($getData) && !empty($getData)){
	// 	foreach ($getData as $key => $value) {
	// 		$arr[] = $value;
	// 	}
	// 	echo json_encode($arr);
	// 	}else{

	// 	}
	// }
}