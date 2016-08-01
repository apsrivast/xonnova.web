<?php 

class Profile extends CI_Controller
{
	function __construct(){
		parent::__construct();
		
	}

	function index(){
		$cur_user_id = $this->session->userdata('user_id');

		$profile = $this->mdl_common->allSelects('Select * From user_master where user_id= '.$cur_user_id);
		foreach ($profile as $key => $value) {
			$arr[] = $value;
		}
		echo json_encode($arr);
	}



	public function isStorePassNotMatch() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		$pass = $this->mdl_common->storePassword($this->session->userdata('user_id'));
		
		if($pass != md5($value['password'])){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}

	public function storeUserChangePass() {
		$user = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'password'=>md5($user['user_password'])
			);
		$cur_user_id = $this->session->userdata('user_id');

		if(!$this->db->update('reseller_store',$updateArr, array('user_id'=>$cur_user_id))){
			$data = array('message'=>'Error Your Password Not updated sucessfully');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Your Password updated sucessfully');
			echo json_encode($data);
		}
		
	}

	

	function editUser(){
		$user = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'first_name'=>$user['first_name'],
				'middle_name'=>$user['middle_name'],
				'last_name'=>$user['last_name'],
				'dob'=>$user['dob'],
				'contact_no'=>$user['contact_no'],
				'phone_carrier'=>$user['phone_carrier'],
				'address1'=>$user['address1'],
				'address2'=>$user['address2'],
				'city'=>$user['city'],
				'state'=>$user['state'],
				'zip'=>$user['zip'],
				'country'=>$user['country']
			);
		$this->db->update('user_master',$updateArr, array('user_id'=>$user['user_id']));

		$contentData2 = $this->mdl_common->allSelects('SELECT a.*, b.* FROM product_purchase_info as a RIGHT JOIN user_purchase_info as b on b.order_id=a.purchase_id  WHERE a.user_id="'.$user['user_id'].'" AND a.purchase_user_id = 0 AND a.delivery_status != "Shipped"');
		if(isset($contentData2) && !empty($contentData2)){
			foreach ($contentData2 as $key2 => $value2) {
				$updateArr22 = array(
						'contact_no'=>$user['contact_no'],
						'address1'=>$user['address1'],
						'address2'=>$user['address2'],
						'city'=>$user['city'],
						'state'=>$user['state'],
						'zip'=>$user['zip'],
						'country'=>$user['country']
					);
				$this->db->update('user_purchase_info',$updateArr22, array('user_purchase_id'=>$value2['user_purchase_id']));
			}
		}

		
	}

	function upload(){
		if(!empty($_FILES)) {
	        $date = date("ymdHis");
			$imageFiles = $_FILES[ 'file' ][ 'name' ];
			$image = 'circle_'.$date.'.png';
	        //$image = 'circle_'.$date.$_FILES[ 'file' ][ 'name' ];
	
	        $configVideo = array(
	            	'upload_path' => './uploads/',
		            'max_size' => '8000240',
		            'allowed_types' => 'png|gif|jpg|jpeg',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            echo 'No files';
	        } else {
	            $videoDetails = $this->upload->data();
	            $insertarr = array(
	            	'image' => $image,
	            	);
	            $this->db->update('user_master',$insertarr,array('user_id' =>$this->session->userdata('user_id')));
	            	
            	$answer = array( 'answer' => 'File transfer completed' );
			    $json = json_encode( $answer );

			    echo $json;
	        }	        
	            $data['message'] = "Your image is uploaded sucessfully.";
		}
	}

	public function isPassNotMatch() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		$pass = $this->mdl_common->userPassword($this->session->userdata('user_id'));
		
		if($pass != md5($value['password'])){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}

	public function userChangePass() {
		$user = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'user_password'=>md5($user['user_password'])
			);
		$cur_user_id = $this->session->userdata('user_id');

		if(!$this->db->update('user_master',$updateArr, array('user_id'=>$cur_user_id))){
			$data = array('message'=>'Error Your Password Not updated sucessfully');
			echo json_encode($data);
		}else{
			$data = array('message'=>'Your Password updated sucessfully');
			echo json_encode($data);
		}
		
	}

	public function isUserExist() {
		$data = array('status' => true);
		$value  = json_decode(file_get_contents("php://input"),true);
		
		$this->db->where('user_name',$value['username']);
		$user = $this->db->get('user_master')->result_array();
		
		if(count($user) == 0){
			$data['status'] = false;
		}
		echo json_encode($data , JSON_FORCE_OBJECT);
	}
	
	public function managementChangePass() {
		$user = json_decode(file_get_contents("php://input"),true);
		$updateArr = array(
				'user_password'=>md5($user['user_password'])
			);
		if(!$this->db->update('user_master',$updateArr, array('user_name'=>$user['user_name']))){
			$data = array('message'=>' Error Password Not updated sucessfully for this user '.$user['user_name']);
			echo json_encode($data);
		}else{
			$data = array('message'=>$user['user_name'].' Password updated sucessfully');
			echo json_encode($data);
		}
	}
}
