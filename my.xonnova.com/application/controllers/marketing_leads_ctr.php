<?php

class Marketing_leads_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}


	function getMarketingLeads(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$id = $this->session->userdata('user_id');

		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$contentData = $this->mdl_common->allSelects('SELECT site_name FROM user_site  where user_id = '.$id);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$value['site_name'] = 'http://xonnova.com/Marketing/'.$value['site_name'].'/';
					$contentData2 = $this->mdl_common->allSelects('SELECT * FROM site_lead  where s_l_time BETWEEN "'.$from.'" AND "'.$to.'" AND site_name = "'.$value['site_name'].'" order by S_l_id DESC');
					if(isset($contentData2) && !empty($contentData2)){
						foreach ($contentData2 as $value2) {
							$arr[] = $value2;
						}
					}
				}
				if(isset($contentData2) && !empty($contentData2)){
					echo json_encode($arr);	
				}
			}else{
				return false;
			}
			
		}else{
			$contentData = $this->mdl_common->allSelects('SELECT site_name FROM user_site  where user_id = '.$id);
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					$value['site_name'] = 'http://xonnova.com/Marketing/'.$value['site_name'].'/';
					$contentData2 = $this->mdl_common->allSelects('SELECT * FROM site_lead  where site_name = "'.$value['site_name'].'" order by S_l_id DESC');
					if(isset($contentData2) && !empty($contentData2)){
						foreach ($contentData2 as $value2) {
							$arr[] = $value2;
						}
					}
				}
				if(isset($contentData2) && !empty($contentData2)){
					echo json_encode($arr);	
				}
			}else{
				return false;
			}
		}
	}
}