<?php
/**
* 
*/
class Ether_credit_store_for_user extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function creditToEtherwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		//$id = $this->mdl_common->getUserId($_POST['user_name']);
		if(isset($_POST['message']) && !empty($_POST['message'])){
		}
		else{
			$data = array("error"=>"message field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$this->db->where('user_name',$_POST['user_name']);
			$rs2	=	$this->db->get('user_master');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$id = $this->mdl_common->getUserId($_POST['user_name']);	
			}
			else{
				$data = array("error"=>"user not exist !");
				echo json_encode($data);
				return  ;		
			}
		}
		else{
			$data = array("error"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(!empty($id) && !empty($_POST['credit'])){
			
			$Arr = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['credit'],
					'wallet_type'=>'1',
					'message'=>$_POST['message'],
				);
			$this->db->insert('ether_wallet',$Arr);
			$data = array('message'=>'Ether Wallet Amount Credited To '.$_POST['user_name'].' Account!');
			echo json_encode($data);
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not Credited To '.$_POST['user_name'].'Account');
			echo json_encode($data);
		}
	}

	public function deductFromEtherwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		//$id = $this->mdl_common->getUserId($_POST['user_name']);
		if(isset($_POST['message']) && !empty($_POST['message'])){
		}else{
			$data = array("error"=>"message field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$this->db->where('user_name',$_POST['user_name']);
			$rs2	=	$this->db->get('user_master');
			$UserInfo2	=	$rs2->num_rows();	
			if($UserInfo2 > 0){
				$id = $this->mdl_common->getUserId($_POST['user_name']);	
			}else{
				$data = array("error"=>"user not exist !");
				echo json_encode($data);
				return  ;		
			}
		}
		else{
			$data = array("error"=>"User Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(!empty($id) && !empty($_POST['credit'])){
		
			$total = $this->getTotalWalletBalance($id) - $this->getTotalDeductWalletBalance($id);
			if($_POST['credit'] > $total || $_POST['credit'] < 0 ){
				$data = array('error'=>'Sorry... Wallet Total Amount is '.(double)$total);
				echo json_encode($data);
			}else{
				$Arr = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['credit'],
					'wallet_type'=>'2',
					'message'=>$_POST['message'],
				);
				$this->db->insert('ether_wallet',$Arr);
				$data = array('message'=>'Ether Wallet Amount Deducted from '.$_POST['user_name'].' Account!');
				echo json_encode($data);
			}
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not deduct from'.$_POST['user_name'].'Account');
			echo json_encode($data);
		}
	}

	function getTotalWalletBalance($id) {
		//$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$id.' AND wallet_type="1"');
		//$deduct = $this->getTotalDeductWalletBalance($userId);
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductWalletBalance($id) {
		//$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				return  $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getEtherCreditwallet(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT e.user_id, um.user_name, e.credit, e.message, e.wallet_credited_at FROM ether_wallet e , user_master um where e.user_id= um.user_id and e.wallet_type="1"');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{

		}
	}

	function getEtherDeductwallet(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT e.user_id, um.user_name, e.credit, e.message, e.wallet_credited_at FROM ether_wallet e , user_master um where e.user_id= um.user_id and e.wallet_type="2"');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{

		}
	}


}