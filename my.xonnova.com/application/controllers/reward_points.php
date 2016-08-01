<?php
/**
* 
*/
class Reward_points extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function creditwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->mdl_common->getUserId($_POST['user_name']);

		if(!empty($id) && !empty($_POST['credit'])){
			$existUser = count($this->mdl_common->allSelects('SELECT * FROM reward_points_report_info WHERE user_id='.$id));
			$Arr = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['credit'],
					'wallet_type'=>'1',
					'message'=>$_POST['message'],
				);
			$this->db->insert('reward_points_report_info',$Arr);

			if(empty($existUser) && $existUser == 0){
				$insertwallete = array(
					'user_id'=>$id,
					'admin_id'=>$this->session->userdata('user_id'),
				);
				$this->db->insert('reward_points_report_user_map_info',$insertwallete);
			}

			$data = array('message'=>'Wallet Amount Credited To '.$_POST['user_name'].' Account!');
			echo json_encode($data);
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not Credited To '.$_POST['user_name'].' valette');
			echo json_encode($data);
		}
	}

	public function deductwallet() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->mdl_common->getUserId($_POST['user_name']);
		if(!empty($id) && !empty($_POST['credit'])){
			$Arr = array(
				'user_id'=>$id,
				'admin_id'=>$this->session->userdata('user_id'),
				'credit'=>$_POST['credit'],
				'wallet_type'=>'2',
				'message'=>$_POST['message'],
			);
			$this->db->insert('reward_points_report_info',$Arr);
			$data = array('message'=>'Wallet Amount Deducted from '.$_POST['user_name'].' Account!');
			echo json_encode($data);
		}else{
			$data = array('error'=>'Sorry Wallet Amount Not deduct from valette');
			echo json_encode($data);
		}
	}

	function getCreditwallet(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name, d.* From reward_points_report_info as d LEFT JOIN  user_master as a on d.user_id= a.user_id LEFT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level WHERE d.wallet_type="1"');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{

		}
	}

	function getDeletewallet(){
		header('Content-Type: application/json');
		$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name, d.* From reward_points_report_info as d LEFT JOIN  user_master as a on d.user_id= a.user_id LEFT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level WHERE d.wallet_type="2"');
		if(isset($getData) && !empty($getData)){
		foreach ($getData as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
		}else{

		}
	}

	function walletReport(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT DISTINCT  a.*, b.* FROM user_master as a RIGHT JOIN reward_points_report_user_map_info as b on b.user_id=a.user_id');
		if(!empty($contentData)){
			$data = '[';
			$i = 0;
			foreach ($contentData as $key => $value) {
				$count = count($contentData);
				//$arr[]=$value;
				$data .='{"user_id":"'.$value['user_id'].'","user_name":"'.$value['user_name'].'","user_email":"'.$value['user_email'].'","image":"'.$value['image'].'","wallet_r_id":"'.$value['wallet_r_id'].'","admin_id":"'.$value['admin_id'].'","wallet_report_created_at":"'.$value['wallet_report_created_at'].'","total_wallet":"'.$this->getTotalWallet($value['user_id']).'","total_deduct":"'.$this->getTotalDeductWallet($value['user_id']).'"}';
				$i++;
				if($i != $count){
					$data .=',';
				}
			}
			$data .= ']';
			echo $data;
		}else{

		}
	}

	function walletReportByUser($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master as a RIGHT JOIN reward_points_report_info as b on b.user_id=a.user_id  where a.user_id='.$id);
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
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM reward_points_report_info WHERE user_id='.$id.' AND wallet_type="1"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}

	function getTotalDeductWallet($id){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM reward_points_report_info WHERE user_id='.$id.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				//$arr[]=$value;
				return $value['total'];
			}
		}else{
			return 0;
		}
	}
	
	function walletReportByUser2(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM user_master as a RIGHT JOIN reward_points_report_info as b on b.user_id=a.user_id  where a.user_id='.$this->session->userdata('user_id'));
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr[]=$value;
			}
			echo json_encode($arr);
		}else{

		}
	}
}