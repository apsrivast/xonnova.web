<?php 
/**
* 
*/
class ExchangeStoreCredit extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){

	}

	function getTotalMexStoreCreditById(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM mxtopup_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}

	function getTotalDeductMexStoreCreditById(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM mxtopup_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}

	function transferMexToUsStoreCredit(){
		$_POST = json_decode(file_get_contents("php://input"),true);		
		$userId = 	$this->session->userdata('user_id');
		$fromUserCurrency = $this->mdl_common->sponsorCountry($userId);
		$userStoreCredit = $this->getTotalStoreCredit($userId,'mxtopup_report_info') - $this->getTotalDeductStoreCredit($userId,'mxtopup_report_info');
		$currencyConversionRate = $this->mdl_common->packageConversionRate(1,'US');
		$transferAmount = $_POST['credit'] * $currencyConversionRate ;					

		if($_POST['credit'] <= $userStoreCredit){
			$UserName = $this->mdl_common->getUserNameById($userId);
			$Arr = array(
					'user_id'=>$userId,
					'admin_id'=>1,
					'credit'=>$_POST['credit'],
					'wallet_type'=>'2',
					'store_type'=> '2',
					'message'=>$UserName." transfer MEX Credit To US wallet",
				);
			if(!$this->db->insert('mxtopup_report_info',$Arr)){
				$data = array('err'=>'Sory.. Database Error'.$this->db->_error_message());
				echo json_encode($data);
			}else{
				$Arr = array(
						'user_id'=>$userId,
						'admin_id'=>1,
						'credit'=>$transferAmount,
						'wallet_type'=>'1',
						'store_type'=> '2',
						'message'=>$UserName." transfer MEX Credit To US wallet",
					);
				$this->db->insert('store_credit_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM mxtopup_report_user_map_info WHERE user_id='.$userId));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$userId,
						'admin_id'=>1,
					);
					$this->db->insert('mxtopup_report_user_map_info',$insertwallete);
				}
				$data = array('message'=>'Thank you! Store Credits have been successfully transferred.');
				echo json_encode($data);				
			}
		}else{
			$data = array('err'=>'We are sorry! You have insufficient credits to transfer.');
			echo json_encode($data);
		}	
	}

	function getTransferStoreCreditList(){
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT a.*,b.* FROM user_master as a RIGHT JOIN mxtopup_report_info as b on b.user_id=a.user_id WHERE b.store_type="2" AND b.wallet_type="2" AND b.user_id='.$userId.' ORDER BY wallet_credited_at DESC');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}

	function getTotalUsStoreCredit(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}

	function getTotalDeductUsStoreCredit(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM store_credit_report_info WHERE user_id='.$this->session->userdata('user_id').' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				//$arr=$value['total'];
				$arr['total'] = $value['total'];
				echo json_encode ($arr);
			}
		}else{
			echo json_encode (0);
		}
	}
	function getTotalStoreCredit($id, $table=null){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM '.$table.' WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductStoreCredit($id, $table=null){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM '.$table.' WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function transferUsToMexStoreCredit(){
		$_POST = json_decode(file_get_contents("php://input"),true);		
		$userId = 	$this->session->userdata('user_id');
		$fromUserCurrency = $this->mdl_common->sponsorCountry($userId);
		$userStoreCredit = $this->getTotalStoreCredit($userId,'store_credit_report_info') - $this->getTotalDeductStoreCredit($userId,'store_credit_report_info');
		$currencyConversionRate = $this->mdl_common->packageConversionRate(1,'MEX');
		$transferAmount = $_POST['credit'] * $currencyConversionRate ;					

		if($_POST['credit'] <= $userStoreCredit){
			$UserName = $this->mdl_common->getUserNameById($userId);
			$Arr = array(
					'user_id'=>$userId,
					'admin_id'=>1,
					'credit'=>$_POST['credit'],
					'wallet_type'=>'2',
					'store_type'=> '2',
					'message'=>$UserName." transfer MEX Credit To US wallet",
				);
			if(!$this->db->insert('store_credit_report_info',$Arr)){
				$data = array('err'=>'Sory.. Database Error'.$this->db->_error_message());
				echo json_encode($data);
			}else{
				$Arr = array(
						'user_id'=>$userId,
						'admin_id'=>1,
						'credit'=>$transferAmount,
						'wallet_type'=>'1',
						//'store_type'=> '2',
						'message'=>$UserName." transfer MEX Credit To US wallet",
					);
				$this->db->insert('mxtopup_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM store_credit_report_user_map_info WHERE user_id='.$userId));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$userId,
						'admin_id'=>1,
					);
					$this->db->insert('store_credit_report_user_map_info',$insertwallete);
				}
				$data = array('message'=>'Thank you! Store Credits have been successfully transferred.');
				echo json_encode($data);				
			}
		}else{
			$data = array('err'=>'We are sorry! You have insufficient credits to transfer.');
			echo json_encode($data);
		}	
	}
}