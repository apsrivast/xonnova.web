<?php
/**
* 
*/
class Entrepreneurial extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}

	function getAllUsers(){
		header('Content-Type: application/json');
		//SELECT a.*,b.*,c.* FROM `user_master` as a LEFT Join interpreneurial_bonus_module as b on b.user_id=a.user_id  LEFT JOIN entrepreneurial_info as c on c.e_id=b.module_id
		//$getData = $this->mdl_common->allSelects('SELECT a.user_id, a.user_name, b.level, c.level_name From user_master as a RIGHT JOIN earning_info as b on b.user_id=a.user_id LEFT JOIN level_configuration as c on c.l_conf_id=b.level where a.parent_id !="0"');
		$getData = $this->mdl_common->allSelects('SELECT DISTINCT a.user_id as moduleuserid,a.user_name as username,a.user_status as userstatus,b.*,c.*,d.* FROM `user_master` as a Right Join earning_info as d on d.user_id=a.user_id LEFT Join interpreneurial_bonus_module as b on b.user_id=d.module  LEFT JOIN entrepreneurial_info as c on c.e_id=b.module_id');
		if(isset($getData) && !empty($getData)){
			foreach ($getData as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);			
		}else{
			
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