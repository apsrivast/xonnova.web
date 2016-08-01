<?php
/**
* 
*/
class PhoneCredit extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}

	function index() {}
	
	function buyPhoneCredit()
	{
		header('Content-Type: application/json');
		$_POST = json_decode(file_get_contents("php://input"), true);
		
		$e_TELEFONO = $_POST['number'];
		$e_OPERADOR = $_POST['operator'];
		$e_MONTO = $_POST['tobuy'];
		
		$folio_operador = null;
		$estado_operacion = null;
		
		$array = array(
				'success' => false,
				'msg' => 'ERROR',
				'data' => $_POST
		);
		
		$error = false;
		$cur_user_id = $this->session->userdata('user_id');
		
		if(!is_numeric($cur_user_id))
		{
			$array['success'] = true;
			$array['msg'] = 'No existe user';
			$array['data'] = $_POST;
			echo json_encode($array);
			die();
		}
		
		$m_RESPUESTA = null;
		// Verificar crédito
		$has_credit = false;
		$total_credito = $this->getTotalCredit($cur_user_id);
		
		if($e_MONTO > $total_credito)
		{
			$array['success'] = false;
			$array['msg'] = 'ERROR xonnova - crédito insuficiente';
			$array['data'] = null;
			$log = array(
					'user' => $cur_user_id,
					'phonetransaction' => null,
					'phonetransactionstatus' => 'ERROR',
					'phoneamount' => $e_MONTO,
					'phonemessage' => 'DENTRO DE xonnova: ' . $array['msg'],
					'phonenumber' => $e_TELEFONO,
					'phonecompany' => $e_OPERADOR
			);
			$this->mdl_common->AddRecord('phone_credit_log',$log);
			
			echo json_encode($array);
			die();
		}
		else
			$has_credit = true;
		
		if($has_credit)
		{
			if($e_OPERADOR == 'TELCEL')
			{
				//Libreria para el manejo de Pyxter
				require_once('pyxter_telcel.php');
				try
				{
					//$e_COMPANIA, $e_TELEFONO, $e_MONTO)
					$m_RESPUESTA = pyxter_venta_telcel($e_OPERADOR, $e_TELEFONO, $e_MONTO);
					if(is_array($m_RESPUESTA) && isset($m_RESPUESTA['ESTADO']))
					{
						if($m_RESPUESTA['ESTADO'] == 'VIGENTE')
						{
							$folio_operador = $m_RESPUESTA['FOLIO_OPERADOR'];
							$estado_operacion = 'VIGENTE';
							$array['success'] = true;
							$array['msg'] = 'Success! operation id: ' . $folio_operador;
							$array['data'] = $m_RESPUESTA;
							// Insert deduct
							$Arr = array(
									'user_id'=>$cur_user_id,
									'admin_id'=>$cur_user_id,
									'credit'=>$e_MONTO,
									'wallet_type'=>'2',
									'message'=> 'Compra de tiempo aire al número ' . $e_TELEFONO . ' por un monto de ' . $e_MONTO . '(' . $array['msg'] . ')'
							);
							$this->mdl_common->AddRecord('mxtopup_report_info',$Arr);
						}
						else
						{
							$array['success'] = false;
							$array['msg'] = 'ERROR: ' . $m_RESPUESTA['MOTIVO'];
							$array['data'] = $m_RESPUESTA;
						}
						
						$log = array(
							'user' => $cur_user_id,
							'phonetransaction' => isset($m_RESPUESTA['idtransaction']) ? $m_RESPUESTA['idtransaction'] : null,	
							'phonetransactionstatus' => isset($m_RESPUESTA['ESTADO']) ? $m_RESPUESTA['ESTADO'] : '-',
							'phoneamount' => $e_MONTO,
							'phonemessage' => isset($m_RESPUESTA['MOTIVO']) ? $m_RESPUESTA['MOTIVO'] : '-',
							'phonenumber' => $e_TELEFONO,
							'phonecompany' => $e_OPERADOR
						);
						$this->mdl_common->AddRecord('phone_credit_log',$log);
					}
				}
				catch(Exception $o_EXCEPTION)
				{
					$m_RESPUESTA = $o_EXCEPTION->getMessage();
					$array['success'] = false;
					$array['msg'] = 'ERROR: ' . $m_RESPUESTA;
					$array['data'] = $_POST;
					
					$log = array(
							'user' => $cur_user_id,
							'phonetransaction' => null,
							'phonetransactionstatus' => 'ERROR',
							'phoneamount' => $e_MONTO,
							'phonemessage' => $m_RESPUESTA,
							'phonenumber' => $e_TELEFONO,
							'phonecompany' => $e_OPERADOR
					);
					$this->mdl_common->AddRecord('phone_credit_log',$log);
					
					echo json_encode($array);
					die();
				}
			}
			else
			{
				require_once('pyxter.php');
				try
				{
					//$e_COMPANIA, $e_TELEFONO, $e_MONTO)
					$m_RESPUESTA = pyxter_venta($e_OPERADOR, $e_TELEFONO, $e_MONTO);
					if(is_array($m_RESPUESTA) && isset($m_RESPUESTA['ESTADO']))
					{
						if($m_RESPUESTA['ESTADO'] == 'VIGENTE')
						{
							$folio_operador = $m_RESPUESTA['FOLIO_OPERADOR'];
							$estado_operacion = 'VIGENTE';
							$array['success'] = true;
							$array['msg'] = 'Success! operation id: ' . $folio_operador;
							$array['data'] = $m_RESPUESTA;
							
							// Insert deduct
							$Arr = array(
									'user_id'=>$cur_user_id,
									'admin_id'=>$cur_user_id,
									'credit'=>$e_MONTO,
									'wallet_type'=>'2',
									'message'=> 'Compra de tiempo aire al número ' . $e_TELEFONO . ' por un monto de ' . $e_MONTO . '(' . $array['msg'] . ')'
							);
							$this->mdl_common->AddRecord('mxtopup_report_info',$Arr);
						}
						else
						{
							$array['success'] = false;
							$array['msg'] = 'ERROR: ' . $m_RESPUESTA['MOTIVO'];
							$array['data'] = $m_RESPUESTA;
						}
						
						$log = array(
								'user' => $cur_user_id,
								'phonetransaction' => null,
								'phonetransactionstatus' => 'ERROR',
								'phoneamount' => $e_MONTO,
								'phonemessage' => $m_RESPUESTA,
								'phonenumber' => $e_TELEFONO,
								'phonecompany' => $e_OPERADOR
						);
						$this->mdl_common->AddRecord('phone_credit_log',$log);
					}
				}
				catch(Exception $o_EXCEPTION)
				{
					$m_RESPUESTA = $o_EXCEPTION->getMessage();
					$array['success'] = false;
					$array['msg'] = 'ERROR: ' . $m_RESPUESTA;
					$array['data'] = $_POST;
					
					$log = array(
							'user' => $cur_user_id,
							'phonetransaction' => null,
							'phonetransactionstatus' => 'ERROR',
							'phoneamount' => $e_MONTO,
							'phonemessage' => $m_RESPUESTA,
							'phonenumber' => $e_TELEFONO,
							'phonecompany' => $e_OPERADOR
					);
					$this->mdl_common->AddRecord('phone_credit_log',$log);
					
					
					echo json_encode($array);
					die();
				}
			}
		}
		
		
		echo json_encode($array);
		//die();
	}
	
	// Save log phone credit log
	function addPhoneLog($array=array())
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