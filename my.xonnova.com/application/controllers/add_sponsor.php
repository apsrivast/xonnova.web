<?php
/**
* 
*/
class Add_sponsor extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	
	function getUserForSponsor(){
	$list = $this->mdl_common->allSelects('SELECT user_id, user_name From user_master  WHERE sponsor_id = 0 and user_type = "user"');
		if(isset($list) && !empty($list)){
			foreach ($list as $key => $value) {
				$arr[] = $value;
			}
			echo json_encode($arr);
		}else{
			return false;
		}
	}

	function updateSponsor(){
		$_POST = json_decode(file_get_contents("php://input"),true);
							

		if(isset($_POST) && !empty($_POST)){
			$last_id = $_POST['user_id'];
			$sponser = $this->mdl_common->sponserID($_POST['sponsor']);
			
			$packageId = $this->mdl_common->getPackageById($last_id);
			$referralAmount = $this->mdl_common->packageReferralAmount($packageId);
			
			$Arr = array(
					'sponsor_id'=>$sponser,
				);
			$this->db->update('user_master',$Arr,array('user_id'=>$last_id));

			$ArrEarning = array(
					'sponser_id'=>$sponser,
				);
			$this->db->update('earning_info',$ArrEarning,array('user_id'=>$last_id));

				
			
			$selectearningtotal = $this->mdl_common->allSelects('SELECT total_balance from earning_info where user_id = '.$sponser);
					
			if(isset($selectearningtotal) && !empty($selectearningtotal)){
				foreach ($selectearningtotal as $total) {						
					$totalreferralAmount= $total['total_balance'] + $referralAmount;
					$updattotalarr = array(
						'total_balance'=>$totalreferralAmount,
					);
					$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
				}
			}else{
				$totalreferralAmount = $referralAmount;
				$updattotalarr = array(
					'total_balance'=>$totalreferralAmount,
				);
				$this->db->update('earning_info',$updattotalarr,array('user_id'=>$sponser));
			}
			
			$inserBonus = array(
					'parent_id'=>$sponser,
					'user_id'=>$last_id,
					'referral_bonus'=>$referralAmount
				);
			$this->db->insert('referral_bonus',$inserBonus);
			
			//Earning Details in one table	
			$toUserName = $this->mdl_common->getUserNameById($last_id);
			$earning_details_by_user = array(
					'user_id'=>$sponser,
					'ref_id'=>$last_id,
					'type_id'=>'1',
					'description'=>'Referral amount from '.$toUserName,
					'amount'=>$referralAmount,
					//'message'=>"",
					//'e_d_b_u_date'=>$value['created_at'],
				);
			$this->db->insert('earning_details_by_user',$earning_details_by_user);
			

			$data = array('message'=>'Successfully Updated.');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Sorry! NOT Updated.');
			echo json_encode($data);
		}
	}

	

	
}