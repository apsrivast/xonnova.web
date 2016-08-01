<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Onlegacy_mdl extends CI_Model {
	function __construct(){
        parent::__construct();
    }

    function getUserHaveAccount($where){
		$query = "SELECT user_id FROM telekloud_master WHERE user_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			return true;		
		}else{
			return false;
		}
	}

    function getReccuringAmount($where){
		$query = "SELECT vprice FROM telekloud_plan_info WHERE varProID = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['vprice'];
			}			
		}else{
			return 30;
		}
	}

    function getActivationAmount($where){
		$query = "SELECT varSetupPrice FROM telekloud_plan_info WHERE varProID = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['varSetupPrice'];
			}			
		}else{
			return 2;
		}
	}

    function searchQueueOrderId($id){
		$request = "<TELEKLOUD>
	    <auth>
	    	<VARID>2777866318</VARID>
			<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
			<USER>info@onlegacynetwork.com</USER>
			<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
	    </auth>
	    <service>SEARCH_QUEUE</service>
	    <TRANSACTION_NUMBER>".$id."</TRANSACTION_NUMBER>
	    <CUSTOMER_ACCOUNT_NUMBER></CUSTOMER_ACCOUNT_NUMBER>
	    <ORDER_NUMBER></ORDER_NUMBER>
	    </TELEKLOUD>";

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
	    $response = curl_exec($curl);
	    curl_close ($curl);
	 
	    $xml = simplexml_load_string($response);
	 //    if( $xml->SEARCH_QUEUE->TRANSACTION->STATUS == 'FAILED')
		// 	return $xml->SEARCH_QUEUE->TRANSACTION->ERROR;
		// else
			return $xml->SEARCH_QUEUE->TRANSACTION->RETURNED_ID;
	}

    function getGroupId($where){
		$query = "SELECT g_id FROM onlegacy_mobile_plan_info WHERE var_pro_id = ".$where;
		$result = $this->db->query($query);
		$data = $result->result_array();
		if(isset($data) && !empty($data)){
			foreach ($data as $key => $value) {
				return $value['g_id'];
			}			
		}else{
			return 0;
		}
	}

    function searchQueue($id){
    	sleep(30);
		$request = "<TELEKLOUD>
	    <auth>
	    	<VARID>2777866318</VARID>
			<APIKEY>pq6U25qc6Z5kR6lfaUmWhnpjXdTqnml</APIKEY>
			<USER>info@onlegacynetwork.com</USER>
			<ACCOUNT_TYPE>VAR</ACCOUNT_TYPE>
	    </auth>
	    <service>SEARCH_QUEUE</service>
	    <TRANSACTION_NUMBER>".$id."</TRANSACTION_NUMBER>
	    <CUSTOMER_ACCOUNT_NUMBER></CUSTOMER_ACCOUNT_NUMBER>
	    <ORDER_NUMBER></ORDER_NUMBER>
	    </TELEKLOUD>";

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, 'https://secureaccesspoint.com/API/');
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);;
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_MAXREDIRS, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
	    $response = curl_exec($curl);
	    curl_close ($curl);
	 
	    $xml = simplexml_load_string($response);
	    if( $xml->SEARCH_QUEUE->TRANSACTION->STATUS == 'FAILED')
			return $xml->SEARCH_QUEUE->TRANSACTION->ERROR;
		else
			return '0';
	}	

    function packageBinaryPoint($id,$currency = null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency == "MEX"){
				return $value['mx_bv_point'];				
			}else{
				return $value['Binary_point'];				
			}
		}
	}

    function packageQVPoint($id,$currency = null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency =="MEX"){
				return $value['mx_qv_point'];					
			}else{
				return $value['qv_point'];
			}
		}
	}


    function packageReferralAmount($id=null,$currency=null,$userCurrency=null){
		$this->db->where(array('package_id'=>$id));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				if(!empty($currency) && $currency == "MEX" && !empty($userCurrency) && $userCurrency == "MEX"){
					return $value['mex_referral_amount'];					
				}elseif(!empty($currency) && $currency != "MEX" && !empty($userCurrency) && $userCurrency !="MEX"){
					return $value['referrals_amount'];
				}elseif(!empty($currency) && $currency != "MEX" && !empty($userCurrency) && $userCurrency =="MEX"){
					$rate = $this->packageConversionRate(1,$currency);
					$price =   $value['mex_referral_amount'] * $rate;
					return $price;
				}elseif(!empty($currency) && $currency == "MEX" && !empty($userCurrency) && $userCurrency !="MEX"){
					$rate = $this->packageConversionRate(1,$currency);
					$price =  $value['referrals_amount'] * $rate;
					return $price;
				}else{
					return $value['referrals_amount'];
				}
			}			
		}else{
			return 0;
		}
	}

	function packageConversionRate($id=null,$currency=null){
		$this->db->where(array('id'=>$id));
		$result = $this->db->get('conversion_rate');
		$data =$result->result_array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				if(!empty($currency) && $currency == "MEX"){
					return $value['us_rate'];
				}else{
					return $value['mx_rate'];					
				}
			}			
		}else{
			return 0;
		}
	}




	
	function getMEXPackageBinaryPoint($packageID){
		$this->db->where(array('package_id'=>$packageID,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				return $value['mx_bv_point'];
			}			
		}else{
			return 0;
		}
	}
	
	function getUSPackageBinaryPoint($packageID){
		$this->db->where(array('package_id'=>$packageID,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				return $value['Binary_point'];
			}			
		}else{
			return 0;
		}
	}
	
	function getMEXPackageQvPoint($packageID){
		$this->db->where(array('package_id'=>$packageID,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				return $value['mx_qv_point'];
			}			
		}else{
			return 0;
		}
	}
	
	function getUSPackageQvPoint($packageID){
		$this->db->where(array('package_id'=>$packageID,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		if(!empty($planPrice)){
			foreach ($planPrice as $key => $value) {
				return $value['qv_point'];
			}			
		}else{
			return 0;
		}
	}
	
	#====================================================================================================
	#Des : for store package amount from package table
 	#====================================================================================================
 	function packageStoreCredit($id,$currency = null){
		$this->db->where(array('package_id'=>$id,'package_status'=>'active'));
		$result = $this->db->get('package_info');
		$planPrice =$result->result_array();
		foreach ($planPrice as $key => $value) {
			if(!empty($currency) && $currency == "MEX"){
				return $value['mex_st_package_amount'];
			}else{
				return $value['st_package_amount'];				
			}
		}
	}
	
}
?>