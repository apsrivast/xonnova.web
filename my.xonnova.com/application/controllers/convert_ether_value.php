<?php
/**
* 
*/
class Convert_ether_value extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}

	function getTotalWalletBalance() {
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$userId.' AND wallet_type="1"');
		//$deduct = $this->getTotalDeductWalletBalance($userId);
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$data = $value['total'];
				echo json_encode($data);
			}
		}else{
			echo json_encode (0);
		}
	}

	function getTotalDeductWalletBalance() {
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total FROM ether_wallet WHERE user_id='.$userId.' AND wallet_type="2"');
		if(!empty($contentData)){
			foreach ($contentData as $value) {
				$data = $value['total'];
				echo json_encode($data);
			}
		}else{
			echo json_encode(0);
		}
	}

	function getEtherConversionRateAddedByAdmin() {
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM ether_conversionrate');
		if(!empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr = array(
					'ether_rate' => $value['ether_rate'],
					'conversion_charge' => $value['conversion_charge']
				);

				echo json_encode ($arr); 
			}
		}
		else {
			echo json_encode (0);
		}
	}

	function convertEtherAmount() {
		$_POST = json_decode(file_get_contents("php://input"),true);
		$userId = $this->session->userdata('user_id');
		$creditTotal = $this->mdl_common->getTotalEtherWalletBalance($userId);
		$deductTotal = $this->mdl_common->getTotalDeductById($userId);
		$contentData = $creditTotal - $deductTotal; 
		if(!empty($_POST['amount_to_convert']))
		{
			if($_POST['amount_to_convert'] > 0)
			{
				if($creditTotal != 0)
				{
					if($contentData >= $_POST['amount_to_convert'])
					{
						$rates = $this->mdl_common->getEtherConversionRates();
						$earningTotal = $this->mdl_common->getEarningTotalBalance($userId);

						$conversion = ($_POST['amount_to_convert'] * $rates['ether_rate'] - $rates['conversion_charge']);
						$conversionTotal = $conversion + $earningTotal ;
						$updattotalarr = array(
										'total_balance' => $conversionTotal,
						);
						if($this->db->update('earning_info',$updattotalarr,array('user_id'=>$userId)))
						{
							$insertEtherDeduction =array(
									'credit'=>$_POST['amount_to_convert'],
									'user_id' => $userId,
									'wallet_type'=>'2',
									'message' => 'Ether Deduct'
								);
							$this->db->insert('ether_wallet',$insertEtherDeduction,array('user_id'=>$userId) );
							$curBalance = $this->mdl_common->getCurrentBalanceFromEarningById($userId);
							$total = $curBalance + $conversion ;
							$insertToEarning = array(
									'user_id' => $userId,
									'amount' => $conversion,
									'current_balance' => $total,
									'description' => 'Ether Conversion Amount by User',
								);
							$this->db->insert('earning_details_by_user',$insertToEarning, array('user_id'=>$userId) );
						}
						$data = array('message'=>'Value converted successfully.');
						echo json_encode($data);
						return;
					}
					else 
					{
						$data = array('message'=>'Amount should be lesser than wallet balance.');
						echo json_encode($data);
					}
				}
				else
				{
					$data = array('message'=>'Sorry Your Wallet Balance is 0.');
						echo json_encode($data);
				}
			}
			else 
			{
				$data = array('message'=>'Amount should be positive.');
					echo json_encode($data);
			}
		}
		else
		{
			$data = array('message'=>'Please enter the amount to convert.');
					echo json_encode($data);
		}
	}
}
