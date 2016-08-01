<?php

class InsertUser extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
		$user = json_decode(file_get_contents("php://input"),true);
		//$column_names = array('first_name', 'middle_name', 'last_name', 'user_name', 'user_email','user_password','dob','address1','address2','city','state','zip','country','sponsor_id','package');
		$insertArr = array(
				'first_name'=>$user['first_name'],
				'middle_name'=>$user['middle_name'],
				'last_name'=>$user['last_name'],
				'user_name'=>$user['user_name'],
				'user_email'=>$user['user_email'],
				'user_password'=>$user['user_password'],
				'dob'=>$user['dob'],
				'address1'=>$user['address1'],
				'address2'=>$user['address2'],
				'city'=>$user['city'],
				'state'=>$user['state'],
				'zip'=>$user['zip'],
				'country'=>$user['country'],
				'sponsor_id'=>$user['sponsor_id']
			);
		$this->db->insert('user_master',$insertArr);
	}

	function getUser(){

	}

	function insertUser(){
		$user = json_decode(file_get_contents("php://input"),true);
		//$column_names = array('first_name', 'middle_name', 'last_name', 'user_name', 'user_email','user_password','dob','address1','address2','city','state','zip','country','sponsor_id','package');
		$insertArr = array(
				'first_name'=>$user['first_name'],
				'middle_name'=>$user['middle_name'],
				'last_name'=>$user['last_name'],
				'user_name'=>$user['user_name'],
				'user_email'=>$user['user_email'],
				'user_password'=>$user['user_password'],
				'dob'=>$user['dob'],
				'address1'=>$user['address1'],
				'address2'=>$user['address2'],
				'city'=>$user['city'],
				'state'=>$user['state'],
				'zip'=>$user['zip'],
				'country'=>$user['country'],
				'sponsor_id'=>$user['sponsor_id']
			);
		$this->db->insert('user_master',$insertArr);
		
	}

	function updateUser(){

	}

	function deleteUser(){

	}
}