<?php 
/**
* 
*/
class Levelup extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function upLevel(){
		$this->is_levelTeamLead();
		$this->is_levelDirector();
		$this->is_levelRegional();
		$this->is_levelNational();
		$this->is_levelInternational();
		$this->is_levelVP();
		$this->is_levelP();
		$this->is_levelCrownAmbassador();
	}

	function is_levelTeamLead(){
		$allData = $this->mdl_common->allSelects('SELECT DISTINCT a.sponsor_id FROM user_master as a RIGHT JOIN user_master as b on b.sponsor_id=a.sponsor_id where a.sponsor_id > 0 ');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allData as $value){
			$user = explode(',',$this->mdl_common->getSponsorUser($value['sponsor_id']));
			$level = $this->mdl_common->countUserLevel('earning_info',$value['sponsor_id']);
			$package = $this->mdl_common->getPackageById($value['sponsor_id']);
			$levelExitPrice = $this->mdl_common->getLevelExitQv($level);
			$discountPercentOfPackage = $this->mdl_common->getDiscountPercentOfLevel($level);
			$currentUserTotalBinaryPercent = $levelExitPrice*$discountPercentOfPackage/100;
			$x = $discountPercentOfPackage/2;
			$restBV = $levelExitPrice*$x/100;
		 	if(!empty($user)){
				 $Qv = '';
				 $Qv1 = 0;
				 $Qv2 = 0;
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV > $currentUserTotalBinaryPercent){
							$Qv .= $totalQV.',';
							$Qv1 += $currentUserTotalBinaryPercent;
						}
					}
				}
				for($i=0; $i<count($user); $i++){
					if(!empty($user[$i]) && $user[$i] > 0){
						$totalQV1 = $this->mdl_common->totalQVBinary('SELECT SUM(qv_point) as qv_point FROM unilevel_binary_info where sponsor_id='.$value['sponsor_id'].' and user_id='.$user[$i]);
						if($totalQV1 < $currentUserTotalBinaryPercent){
							$Qv2 += $totalQV1;
						}
					}
				}
				
				if(!empty($Qv1)){
					$total2 = $Qv2 + $Qv1 ;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						return $this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}else{
					$total2 = $Qv2;
					if($total2 > $levelExitPrice && $level < 6){
						$updArr = array('level'=>6, 'level_updated_at'=>$dateTime);
						return $this->db->update('earning_info',$updArr,array('user_id'=>$value['sponsor_id']));
					}
				}
			}
		}
	}
	
	function countUserRank($startId=null,$level=null){	
		$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
	    $row = $directDescendents->result_array($directDescendents);
	    $i = null;
	    foreach ($row as $key => $value) {
	    	$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
	    	if(!empty($value['user_id']) && !empty($countLegSponsor)){
				$coutnLevel = $this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND direct_sponsor='.$value['user_id'].' AND member_rank >='.$level.' AND unilevel_rant_created >='.date('Y-m-d'));	
	    		if(!empty($coutnLevel)){
	    			$x = count($coutnLevel);	   
	    			if(!empty($x) && $x >= 1){
	    				$i++;
	    			} 			
	    		}
	    	}
	    }
	    return $i;
	}
	
	function is_levelDirector(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],6);

			if($unilevelUserRank >= 2 && $level == 6){
				$updArr = array('level'=>7, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelRegional(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],7);

			if($unilevelUserRank >= 4 && $level == 7){
				$updArr = array('level'=>8, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}
		}
	}

	function is_levelNational(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$countchildren = $this->mdl_common->countChildren('user_master',$value['user_id']);
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],8);

			if($unilevelUserRank >= 5 && $level == 8){
				$updArr = array('level'=>9, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelInternational(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],9);

			if($unilevelUserRank >= 5 && $level == 9){
				$updArr = array('level'=>10, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelVP(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],10);

			if($unilevelUserRank >= 5 && $level == 10){
				$updArr = array('level'=>11, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}

	function is_levelP(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],11);

			if($unilevelUserRank >= 5 && $level == 11){
				$updArr = array('level'=>12, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}
	
	function is_levelCrownAmbassador(){
		$allSelects = $this->mdl_common->allSelects('SELECT * FROM user_master');
		$dateTime = date('Y-m-d H:i:s');
		foreach($allSelects as $value){
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			
			$level = $this->mdl_common->countUserLevel('earning_info',$value['user_id']);
			$unilevelUserRank = $this->countUserRank($value['user_id'],11);

			if($unilevelUserRank >= 5 && $level == 12){
				$updArr = array('level'=>13, 'level_updated_at'=>$dateTime);
				return $this->db->update('earning_info',$updArr,array('user_id'=>$value['user_id']));
			}

		}
	}
	
	function processUserLevel(){
		//$startId = $this->session->userdata('user_id');
		$contentData = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE level >=6');
		if(!empty($contentData)){
			foreach ($contentData as $key => $rankUser) {
				$startId = $rankUser['user_id'];
				$directDescendents = $this->db->query("SELECT user_id, level, sponser_id  FROM earning_info WHERE sponser_id =".$startId);
			    $row = $directDescendents->result_array($directDescendents);
				if(!empty($row)){
					$checkUserExitIncountTable = count($this->mdl_common->allSelects('SELECT * FROM count_unilevel_leg_rank WHERE user_id='.$startId.' AND unilevel_rant_created >="'.date('Y-m-d').'"'));	
					foreach ($row as $key => $value) {
						$countLegSponsor = $this->mdl_common->allSelects('SELECT * FROM earning_info WHERE sponser_id='.$value['user_id']);
						if(!empty($value['user_id']) && !empty($countLegSponsor)){
								$this->mdl_common->getSponsorToBottom($value['user_id'],$startId,$value['user_id']);	
								$insertArr = array(
										'user_id'=>$startId,
										'direct_sponsor'=>$value['user_id'],
										'unilevel_member'=>$value['user_id'],
										'unilevel_member_sponsor'=>$value['sponser_id'],
										'member_rank'=>$value['level'],
										'count_member_status'=>'1',
										'unilevel_rant_created'=>date('Y-m-d H:i:s'),
									);
							if(empty($checkUserExitIncountTable)){	
								$this->db->insert('count_unilevel_leg_rank',$insertArr);
							}	    		
						}
					}					
				}
			}			
		}
	}
}