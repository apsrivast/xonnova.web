<?php
/**
* 
*/
class UserCredit extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}

	function index() {}
	
	function transferUserCredit()
	{
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$target_user = addslashes(trim($_POST['userid']));
		$amount = $_POST['amount'];
		
		$error_amount = false;
		if(!is_numeric($amount))
			$error_amount = true;
		if($amount < 1)
			$error_amount = true;
		
		if($error_amount)	
		{
			$array['success'] = false;
			$array['msg'] = 'Credit to transfer must be greather than 0';
			$array['data'] = $_POST;
			echo json_encode($array);
			die();
		}
		
		$array = array(
				'success' => false,
				'msg' => 'ERROR',
				'data' => $_POST
		);
		
		$error = false;
		$cur_user_id = $this->session->userdata('user_id');
		
		if(!is_numeric($cur_user_id))
		{
			$array['success'] = false;
			$array['msg'] = 'No existe user';
			$array['data'] = $_POST;
			echo json_encode($array);
			die();
		}
		
		// Verificar que el user existe
		$target_id = $this->mdl_common->getUserId($target_user);
		if(!$target_id)
		{
			$array['success'] = false;
			$array['msg'] = 'Target user does not exists: ' . $target_user;
			$array['data'] = $_POST;
			echo json_encode($array);
			die();
		}
		
		// Verificar crédito
		$has_credit = false;
		$total_credito = $this->getTotalCredit($cur_user_id);
		
		if($amount > $total_credito)
		{
			$array['success'] = false;
			$array['msg'] = 'ERROR OL - crédito insuficiente';
			$array['data'] = null;
			echo json_encode($array);
			die();
		}
		else
			$has_credit = true;
		
		if($has_credit)
		{
			try
			{
				
				// Insert credit to target user
				$Arr_credit = array(
					'user_id' => $target_id,
					'admin_id' => $cur_user_id,
					'credit' => $amount,
					'wallet_type'=>'1',
					'message' => 'Credit transfer to this user',
				);
				$this->mdl_common->AddRecord('mxtopup_report_info',$Arr_credit);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM mxtopup_report_info WHERE user_id='.$target_id));
				if(empty($existUser) && $existUser == 0)
				{
					$insertwallete = array(
							'user_id'=>$target_id,
							'admin_id'=> $cur_user_id,
					);
					$this->mdl_common->AddRecord('mxtopup_report_user_map_info',$insertwallete);
				}
				
				// Insert deduct to user thats are doing transfer
				$Arr_deduct = array(
						'user_id'=>$cur_user_id,
						'admin_id'=>$cur_user_id,
						'credit'=>$amount,
						'wallet_type'=>'2',
						'message'=> 'Credit transfer from this user to another user'
				);
				$this->mdl_common->AddRecord('mxtopup_report_info',$Arr_deduct);
				
				$array['success'] = true;
				$array['msg'] = 'Success! credit has been transfered!';
				$array['data'] = null;
				echo json_encode($array);
				die();
			}
			catch(Exception $e)
			{
				$m_RESPUESTA = $o_EXCEPTION->getMessage();
				$array['success'] = false;
				$array['msg'] = 'ERROR: ' . $m_RESPUESTA;
				$array['data'] = null;
				
				echo json_encode($array);
				die();
			}
		}
		
		
	}
	
	// Save log phone credit log
	function addPhoneLog($array)
	{
		return $this->mdl_common->AddRecord('phone_credit_log', $array);
	}
	
	// total = credit - deduct
	function getTotalCredit($id_user)
	{
		$total = 0;
		
		$favor = $this->getCreditWallet($id_user);
		
		if($favor > 0)
		{
			$contra = $this->getDeductWallet($id_user);
			$total = $favor - $contra;
		}
			
		return $total;
	}
	
	// Get credit wallet
	function getCreditWallet($id_user)
	{
		$total = 0; 
		$getData = $this->mdl_common->allSelects('SELECT SUM(credit) as total
				FROM mxtopup_report_info WHERE user_id=' . $id_user . ' AND wallet_type="1"');
		
		if(isset($getData) && !empty($getData))
			$total = $getData[0]['total'];
		
		return $total;
	}
	
	// Get deduct wall
	function getDeductWallet($id_user)
	{
		$total = 0;
		$contentData = $this->mdl_common->allSelects('SELECT SUM(credit) as total
				FROM mxtopup_report_info WHERE user_id=' . $id_user . ' AND wallet_type="2"');
		
		if(isset($contentData) && !empty($contentData))
			$total = $contentData[0]['total'];
	
		return $total;
	}
}