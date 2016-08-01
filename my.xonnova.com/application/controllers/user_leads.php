<?php
/**
* 
*/
class User_leads extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

	}


	function userPackage(){
		header('Content-Type: application/json');
		$packageId = $this->mdl_common->getPackageById($this->session->userdata('user_id'));
		$contentData = $this->mdl_common->allSelects('SELECT package_name FROM package_info where package_id = '.$packageId);
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$data = $value['package_name'];
			}
		}else{
			$data = 'Not Found';
		}
		echo json_encode($data);
	}


	function userName(){
		header('Content-Type: application/json');
		$contentData = $this->mdl_common->allSelects('SELECT user_name  FROM user_master where user_id='.$this->session->userdata('user_id'));
		if(isset($contentData) && !empty($contentData)){
			foreach ($contentData as $key => $value) {
				$arr = $value['user_name'];
				echo json_encode($arr);
			}

		}	
	}


	function uploadQuestionnaireProof(){
		header('Content-Type: application/json');
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $imageFiles = $_FILES[ 'file' ][ 'name' ];
			//$image = 'cashout'.$date.'.png';
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_leads'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_leads'.$date.'.png';
			}
			
	      	$configVideo = array(
	            	'upload_path' => './assets/cashout/',
		            'max_size' => '800024000',
		            'allowed_types' => 'png|gif|jpg|jpeg|pdf',
		            'overwrite'=> FALSE,
		            'remove_spaces' => TRUE,
		            'file_name'=> $image
	        );

	        $this->load->library('upload', $configVideo);
	        $this->upload->initialize($configVideo);
	        if (!$this->upload->do_upload('file')) {
	            $data = array('massage'=>'error Not upload');
					echo json_encode($data);
	        } else {
	        		$data = array('file_name'=>$image);
					echo json_encode($data);
	        }	 
	    }else{ $data = array('massage'=>'error');
					echo json_encode($data);
		}       
	}

	function leads(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['industry']) && !empty($_POST['industry'])){
		}else{
			$data = array("error"=>"Industry field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['other_industry']) && !empty($_POST['other_industry'])){
		}else{
			$_POST['other_industry'] = '';
		}
		if(isset($_POST['business_name']) && !empty($_POST['business_name'])){
		}else{
			$data = array("error"=>"Business Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['owner_name']) && !empty($_POST['owner_name'])){
		}else{
			$data = array("error"=>"Owner Name field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['type_business']) && !empty($_POST['type_business'])){
		}else{
			$data = array("error"=>"Type of Business field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['business_email']) && !empty($_POST['business_email'])){
		}else{
			$_POST['business_email'] = '';
			// $data = array("error"=>"Email field is required !");
			// echo json_encode($data);
			// return  ;
		}
		
		if(isset($_POST['contect_no']) && !empty($_POST['contect_no'])){
		}else{
			$data = array("error"=>"Phone number field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['day']) && !empty($_POST['day'])){
		}else{
			$data = array("error"=>"Day field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['time']) && !empty($_POST['time'])){
		}else{
			$data = array("error"=>"Hour field is required !");
			echo json_encode($data);
			return  ;
		}
		

		if(isset($_POST['time_m']) && !empty($_POST['time_m'])){
		}else{
			$data = array("error"=>"Minute field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['zone']) && !empty($_POST['zone'])){
		}else{
			$data = array("error"=>"Time Zone field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['equipment']) && !empty($_POST['equipment'])){
		}else{
			$_POST['equipment'] = '';
		}
		if(isset($_POST['type_location']) && !empty($_POST['type_location'])){
		}else{
			$_POST['type_location'] = '';
		}
		if(isset($_POST['location']) && !empty($_POST['location'])){
		}else{
			$data = array("error"=>"Location field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['type_lead']) && !empty($_POST['type_lead'])){
		}else{
			$data = array("error"=>"Type of lead field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['get_prospect']) && !empty($_POST['get_prospect'])){
		}else{
			$data = array("error"=>"How did you get this prospect? field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['comments']) && !empty($_POST['comments'])){
		}else{
			$data = array("error"=>"Comments field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['user_questionnaire']) && !empty($_POST['user_questionnaire'])){
		}else{
			$_POST['user_questionnaire'] = 'NO_IMAGE';
		}

		if(isset($_POST['user_language']) && !empty($_POST['user_language'])){
		}else{
			$data = array("error"=>"Preferred Language field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['q_agent']) && !empty($_POST['q_agent'])){
		}else{
			//$_POST['q_agent'] = '';
			$data = array("error"=>"REFERRING AGENT field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_date']) && !empty($_POST['q_date'])){
		}else{
			//$_POST['q_date'] = '';
			$data = array("error"=>"INITIAL CONTACT DATE field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_avg_electricity']) && !empty($_POST['q_avg_electricity'])){
		}else{
			//$_POST['q_avg_electricity'] = '';
			$data = array("error"=>"Average Electricity Bill field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_late_payments_long']) && !empty($_POST['q_late_payments_long'])){
		}else{
			$_POST['q_late_payments_long'] = '';
		}

		if(isset($_POST['q_name']) && !empty($_POST['q_name'])){
		}else{
			//$_POST['q_name'] = '';
			$data = array("error"=>"Name field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_home_phone']) && !empty($_POST['q_home_phone'])){
		}else{
			//$_POST['q_home_phone'] = '';
			$data = array("error"=>"Home Phone # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_cell']) && !empty($_POST['q_cell'])){
		}else{
			//$_POST['q_cell'] = '';
			$data = array("error"=>"Cell # field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_address']) && !empty($_POST['q_address'])){
		}else{
			//$_POST['q_address'] = '';
			$data = array("error"=>"Address field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_city']) && !empty($_POST['q_city'])){
		}else{
			//$_POST['q_city'] = '';
			$data = array("error"=>"City field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_state']) && !empty($_POST['q_state'])){
		}else{
			//$_POST['q_state'] = '';
			$data = array("error"=>"State field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['q_zip']) && !empty($_POST['q_zip'])){
		}else{
			//$_POST['q_zip'] = '';
			$data = array("error"=>"Zip field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['q_electricity_bill']) && !empty($_POST['q_electricity_bill'])){
		}else{
			//$_POST['q_zip'] = '';
			$data = array("error"=>"Electricity Bill File is required !");
			echo json_encode($data);
			return  ;
		}



		
			
			$insertArr = array(
				'user_id'=> $this->session->userdata('user_id'),
				'industry'=>$_POST['industry'],
				'other_industry'=>$_POST['other_industry'],
				'business_name'=>$_POST['business_name'],
				'owner_name'=>$_POST['owner_name'],
				'type_business'=>$_POST['type_business'],
				'business_email'=>$_POST['business_email'],
				'contect_no'=>$_POST['contect_no'],
				'day'=>$_POST['day'],
				'time'=>$_POST['time'],
				'time_m'=>$_POST['time_m'],
				'zone'=>$_POST['zone'],
				'equipment'=>$_POST['equipment'],
				'type_location'=>$_POST['type_location'],
				'location'=>$_POST['location'],
				'type_lead'=>$_POST['type_lead'],
				'get_prospect'=>$_POST['get_prospect'],
				'comments'=>$_POST['comments'],
				'user_questionnaire'=>$_POST['user_questionnaire'],
				'user_language'=>$_POST['user_language'],

				'questionnaireans'=>$_POST['questionnaireans'],
				'q_agent'=>$_POST['q_agent'],
				'q_date'=>$_POST['q_date'],
				'q_home'=>$_POST['q_home'],
				'q_electricity'=>$_POST['q_electricity'],
				'q_avg_electricity'=>$_POST['q_avg_electricity'],

				'q_mortgage'=>$_POST['q_mortgage'],
				'q_mortgage_resolved'=>$_POST['q_mortgage_resolved'],
				'q_bankruptcy'=>$_POST['q_bankruptcy'],
				'q_bankruptcy_resolved'=>$_POST['q_bankruptcy_resolved'],
				'q_late_payments'=>$_POST['q_late_payments'],

				'q_late_payments_long'=>$_POST['q_late_payments_long'],
				'q_late_payments_upto'=>$_POST['q_late_payments_upto'],
				'q_property_taxes'=>$_POST['q_property_taxes'],
				'q_property_taxes_fallen'=>$_POST['q_property_taxes_fallen'],
				'q_property_taxes_mortgage'=>$_POST['q_property_taxes_mortgage'],

				'q_credit'=>$_POST['q_credit'],
				'q_roof'=>$_POST['q_roof'],
				'q_name'=>$_POST['q_name'],
				'q_home_phone'=>$_POST['q_home_phone'],


				'q_cell'=>$_POST['q_cell'],
				'q_address'=>$_POST['q_address'],
				'q_city'=>$_POST['q_city'],
				'q_state'=>$_POST['q_state'],
				'q_zip'=>$_POST['q_zip'],
				
				'q_electricity_bill'=>$_POST['q_electricity_bill'],	
				
			);
			

		if(!$this->db->insert('new_leads',$insertArr)){
		    $data = array('error' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('mess' => 'Lead uploaded successfully ! ');
			echo json_encode($data );
		}
	}

	
	


}