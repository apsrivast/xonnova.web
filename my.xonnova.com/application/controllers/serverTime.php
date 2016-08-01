<?php

class ServerTime extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		echo 'ServerTime : '.date('Y-m-d H:i:s').'<br>';
		
		$currentDate = date('Y-m-d');
		$date = new DateTime($currentDate, new DateTimeZone('Pacific/Nauru'));
		//$date->setTimezone(new DateTimeZone("PST"));
		$date->setTimezone(new DateTimeZone("UTC"));
		echo $date->format('Y-m-d H:i:s');
	}
}