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
		
		$array = array(
				'success' => true,
				'msg' => 'buy phone credit success, id user: ' . $this->session->userdata('user_id'),
				'data' => $_POST,
				'extra' => get_include_path()
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
		// Verificar crédito
		$has_credit = true;
		if($has_credit)
		{
			$m_RESPUESTA = array();
			if($e_OPERADOR == 'TELCEL')
			{
				//Libreria para el manejo de Pyxter
				require_once('pyxter_telcel.php');
				try
				{
					//$e_COMPANIA, $e_TELEFONO, $e_MONTO)
					$m_RESPUESTA = pyxter_venta_telcel($e_OPERADOR, $e_TELEFONO, $e_MONTO);
				}
				catch(Exception $o_EXCEPTION)
				{
					$m_RESPUESTA = $o_EXCEPTION->getMessage();
					$array['success'] = false;
					$array['msg'] = 'ERROR: ' . $m_RESPUESTA;
					$array['data'] = $_POST;
					echo json_encode($array);
					die();
				}
				echo($m_RESPUESTA['FOLIO_OPERADOR']);
			}
			else
			{
				require_once('pyxter.php');
				try
				{
					//$e_COMPANIA, $e_TELEFONO, $e_MONTO)
					$m_RESPUESTA = pyxter_venta($e_OPERADOR, $e_TELEFONO, $e_MONTO);
				}
				catch(Exception $o_EXCEPTION)
				{
					$m_RESPUESTA = $o_EXCEPTION->getMessage();
					$array['success'] = false;
					$array['msg'] = 'ERROR: ' . $m_RESPUESTA;
					$array['data'] = $_POST;
					echo json_encode($array);
					die();
				}
					
				//echo($m_RESPUESTA['FOLIO_OPERADOR']);
			}
		}
		$array['msg'] = $m_RESPUESTA;
		echo json_encode($array);
		die();
		
		$getData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id as moduleuserid,a.user_name as username,
				a.user_status as userstatus,b.*,c.* 
				FROM `user_master` as a 
				LEFT Join interpreneurial_bonus_module as b on b.user_id=a.user_id  
				LEFT JOIN entrepreneurial_info as c on c.e_id=b.module_id');
		if(isset($getData) && !empty($getData))
		{
			foreach ($getData as $key => $value) 
			{
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}
		else
		{
			
		}
	}

	function getUserModuleMemberDetails(){
		header('Content-Type: application/json');
		$id = $this->session->userdata('user_id');
		if(isset($id) && !empty($id)){			
	   		$totalSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id ='.$id));
	   		$totalMember = $this->mdl_common->countTotalChildren($id);
	   		$rulePercent = $this->mdl_common->getDiscountPercentOfPackage($id);
	   		$curentModule = $this->mdl_common->getCurrentModule($id);
   			if($curentModule == 0){
				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=1');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);					
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 1){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=2');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);					
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 2){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=3');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);							
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 3){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=4');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);								
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 4){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=5');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);								
						echo json_encode($data);
					}
				}else{
					
				}
   			}	
   			//echo "OK";			
		}
	}

	function getModuleMemberDetails($id){
		header('Content-Type: application/json');
		if(isset($id) && !empty($id)){			
	   		$totalSponsored = count($this->mdl_common->allSelects('SELECT * FROM user_master WHERE sponsor_id ='.$id));
	   		$totalMember = $this->mdl_common->countTotalChildren($id);
	   		$rulePercent = $this->mdl_common->getDiscountPercentOfPackage($id);
	   		$curentModule = $this->mdl_common->getCurrentModule($id);
   			if($curentModule == 0){
				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=1');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);					
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 1){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=2');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);					
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 2){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=3');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);							
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 3){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=4');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);								
						echo json_encode($data);
					}
				}else{
					
				}
   			}elseif($curentModule == 4){
   				$moduleInfo = $this->mdl_common->allSelects('SELECT * FROM entrepreneurial_info WHERE status="active" AND e_id=5');
				if(isset($moduleInfo) && !empty($moduleInfo)){
					foreach ($moduleInfo as $value) {
						if($value['p_sponsor_user'] < $totalSponsored){
							$sponsorDif = 0;
						}else{
							$sponsorDif = $value['p_sponsor_user'] - $totalSponsored;
							//$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						if($value['total_member_in_team'] < $totalMember){
							$memberDif = 0;
						}else{
							$memberDif = $value['total_member_in_team'] - $totalMember;							
						}
						$data = array(
							'moduleLevel'=>'Module',
							'module'=>$value['module_name'],
							'totalSponsorLevel'=>'Personal Sponsor Member',
							'totalSponsor'=>$totalSponsored,
							'totalSponsorDifLevel'=>'Required Personal Sponsor Member to compleate Module',
							'totalSponsorDif'=>$sponsorDif,
							'sponsorRequiredLevel'=>'Total Personal Sponsor Member ',
							'sponsorRequired'=>$value['p_sponsor_user'],
							'totalTeamMemberLevel'=>'Team Member',
							'totalTeamMemberDifLevel'=>'Require Member in Team  to compleate Module',
							'totalTeamMemberDif'=>$memberDif,
							'totalTeamMember'=>$totalMember,
							'teamMemberRequiredLevel'=>'Total Team Member',
							'teamMemberRequired'=>$value['total_member_in_team'],
						);								
						echo json_encode($data);
					}
				}else{
					
				}
   			}	
   			//echo "OK";			
		}
	}
}