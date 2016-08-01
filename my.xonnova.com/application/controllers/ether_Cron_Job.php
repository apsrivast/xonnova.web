<?php
/**
* 
*/
class Ether_Cron_Job extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		
	}

	function getEtherValueAddedByAdmin(){		
		$ethervalue = $this->mdl_common->allSelects('SELECT * FROM ether_value');
		if(!empty($ethervalue)){
			foreach ($ethervalue as $key => $value) {
				return $value['e_value'];
			}
		}else{
			return 0;
		}
		
	}

	function etherCron(){
		$Data = $this->mdl_common->allSelects('SELECT * FROM user_master WHERE package="4" AND subscription_status="active" AND user_type="user"');
		$ethervalue = $this->getEtherValueAddedByAdmin();
		//echo $ethervalue;
		//print_r($Data);
		if(!empty($Data)){
			foreach ($Data as $key => $value) {
				 $insertEtherBonus = array('user_id' => $value['user_id'],
									 		'admin_id' => '1',
									 		'credit' => $ethervalue,
									 		'message' => 'Ether Credit',
									 		'wallet_type' => '1',
									 		'store_type' => '0',
									 		'wallet_status' => '1'
									 	);
				 $this->db->insert('ether_wallet',$insertEtherBonus);
			}
		}		
	}
}