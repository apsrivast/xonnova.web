<?php

/**
* 
*/
class CheckSubscriptionStatus extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		$loginname="3PeE482c2";
		$transactionkey="7S428TRF96ckPAgq";
		$host = "api.authorize.net";
		$path = "/xml/v1/request.api";

		//$this->load->library('Subscription_status');
		$this->load->library('Subscription_status');

		$subscriptionId = '25855259';


		echo "get subscription status <br>";

		//build xml to post
		$content =
		        "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
		        "<ARBGetSubscriptionStatusRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
		        "<merchantAuthentication>".
		        "<name>" . $loginname . "</name>".
		        "<transactionKey>" . $transactionkey . "</transactionKey>".
		        "</merchantAuthentication>" .
		        "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
		        "</ARBGetSubscriptionStatusRequest>";

		//send the xml via curl
		$response = $this->subscription_status->send_request_via_curl($host,$path,$content);
		//if curl is unavilable you can try using fsockopen
		/*
		$response = $this->subscription_status->send_request_via_fsockopen($host,$path,$content);
		*/


		//if the connection and send worked $response holds the return from Authorize.net
		if ($response){
			list ($resultCode, $code, $text, $subscriptionId) = $this->subscription_status->parse_return($response);

			
			echo " Response Code: $resultCode <br>";
			echo " Response Reason Code: $code<br>";
			echo " Response Text: $text<br>";
			echo " Subscription Id: $subscriptionId <br><br>";
			echo " Data has been written to data.log<br><br>";
			
			$fp = fopen('data.log', "a");
			fwrite($fp, "$subscriptionId\r\n");
			fwrite($fp, "$text\r\n");
			fclose($fp);
		}else{
			echo "Transaction Failed. <br>";
		}
	}
}