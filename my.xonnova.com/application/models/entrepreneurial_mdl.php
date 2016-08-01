<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Entrepreneurial_mdl extends CI_Model {
	function __construct(){
        parent::__construct();
    }	

    function getTotalMemberInTeam($startId) {
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE subscription_status = 'active' AND created_at <= '".$recurringStartDate."' AND sponsor_id = ?", array( $startId ));
	    $count = $directDescendents->num_rows($directDescendents);
	    $row = $directDescendents->result_array($directDescendents);
	    foreach ($row as $key => $value) {
	        $count += $this->getTotalMemberInTeam($value['user_id']);
	    }
	    return $count;
	}
	
	function getSponsorUser($startId){
		$recurringStartDate = date('Y-m-d', mktime(date("H"), date("i"), date("s"), date("m") - 1, date("d"), date("Y")));
	    $directDescendents = $this->db->query("SELECT user_id FROM user_master WHERE subscription_status = 'active' AND created_at <= '".$recurringStartDate."' AND sponsor_id =".$startId);
		$user = "";
	    $row = $directDescendents->result_array($directDescendents);
		if(!empty($row)){
			foreach ($row as $key => $value) {
				$user .= $value['user_id'].',';
			}
			return $user;			
		}else{
			return '';
		}
	}
	
	function getCurrentModule($where){
		$query = "SELECT * FROM earning_info WHERE user_id =".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				if(isset($value['module']) && !empty($value['module'])){
					return $value['module'];
				}else{
					return 0;
				}
			}			
		}
	}

	function getModuleID($where){
		$this->db->where('user_id',$where);
	  	$data = $this->db->get('earning_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				if($value['module']){
					return $value['module'];					
				}else{
					return 0;
				}
			}		
		}else{
			return 1;
		}
	}

	function getRulePercentOfModule($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['rule_percent'];
			}		
		}else{
			return '0';
		}
	}

	function getModuleName($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['module_name'];
			}		
		}else{
			return 'NA';
		}
	}

	function getRequiredTeamMember($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['total_member_in_team'];
			}		
		}else{
			return '0';
		}
	}

	function getrequiredMember($id){
		$x = $this->db->query("SELECT * FROM coded_level WHERE id =".$id);
		$row = $x->result_array($x);
		if(!empty($row)){
			foreach ($row as $key => $value) {
				return $value['member'];
			}
		}else{
			return 2;
		}
	}

	function getPresonalSponsorMember($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['p_sponsor_user'];
			}		
		}else{
			return '0';
		}
	}

	function getModuleAmount($where){
		$this->db->where('e_id',$where);
	  	$data = $this->db->get('entrepreneurial_info')->result_array();
	  	if(isset($data) && !empty($data)){
			foreach ($data as $key => $value){
				return $value['payment'];
			}		
		}else{
			return '0';
		}
	}

 }