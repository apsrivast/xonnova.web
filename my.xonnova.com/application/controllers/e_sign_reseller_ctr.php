<?php
/**
* 
*/
class E_sign_reseller_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){



	}

	

	function uploadagrement(){
		if(!empty($_FILES)) { 
			$date = date("ymdHis");
		    $image = 'product_'.$date.$_FILES[ 'file' ][ 'name' ];
		    if($_FILES[ 'file' ][ 'type' ] == 'application/pdf'){
				$image = $this->session->userdata('user_id').'_leads'.$date.'.pdf';
			}else{
				$image = $this->session->userdata('user_id').'_leads'.$date.'.png';
			}
		    $configVideo = array(
					'upload_path' => './assets/uploads/',
					'max_size' => '800024000',
					'allowed_types' => 'png|gif|jpg|jpeg|pdf',
					'overwrite'=> FALSE,
					'remove_spaces' => TRUE,
					'file_name'=> $image
			);

			$this->load->library('upload', $configVideo);
			$this->upload->initialize($configVideo);
			if (!$this->upload->do_upload('file')) {
				$data = array("mess"=>"No files");
    			echo json_encode($data);
				
			} else {


				$insertArr = array(
					'user_id'=>$this->session->userdata('user_id'),
					//'first_name'=>$_POST['first_name'],
					//'last_name'=>$_POST['last_name'], 	
					'esign_image'=>$image,
					'sign_ip'=>$this->input->ip_address(),

				);
					

				if(!$this->db->insert('e_sign_reseller',$insertArr)){
				    $data = array('mess' => $this->db->_error_message());
					echo json_encode($data );
				}else{
					$this->session->set_userdata('e_sign_status', 'yes');
		           	$data = array('message' => 'Agreement Updated Successfully ! ');
					echo json_encode($data );
				}
			}		            
		}
	}

	function submitEsignPdf(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		//header('Content-Type: application/json');
		
		if(isset($_POST['esign2']) && !empty($_POST['esign2'])){
		}else{
			$_POST['esign2']='';
		}
		if(isset($_POST['esign3']) && !empty($_POST['esign3'])){
		}else{
			$_POST['esign3']='';
		}
		if(isset($_POST['esign4']) && !empty($_POST['esign4'])){
		}else{
			$_POST['esign4']='';
		}
		
		
		$data = $_POST['esign2'];
		$data2 = $_POST['esign3'];
		$data3 = $_POST['esign4'];

		if(!empty($data) && !empty($data2) && !empty($data3)){


			$this->db->where('user_id',$this->session->userdata('user_id'));
			$rs2	=	$this->db->get('e_sign_pdf');
			$UserInfo2	=	$rs2->num_rows();
			if($UserInfo2 > 0){
				$data = array('sucess'=>'Agreement Updated Successfully !');	
			}else{
						
				$insertArr = array(		
					'user_id'=>$this->session->userdata('user_id'),
					'pdf'=>$data,
					'pdf2'=>$data2,
					'pdf3'=>$data3,
				);

				if(!$this->db->insert('e_sign_pdf',$insertArr)){
					$data = array('err'=>'Sorry, Agreement not generated please try again, '.$this->db->_error_message());
				}else{
					$this->session->set_userdata('e_sign_status', 'yes');
					$data = array('sucess'=>'Agreement Updated Successfully !');			
				} 			
			}

		}else{
			$data = array('err'=>'Sorry, Agreement not generated please try again !');
		}
		echo json_encode($data);
 	}


	function submitEsign(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['location_name']) && !empty($_POST['location_name'])){
		}else{
			$data = array("mess"=>"INSTALLER LOCATION NAME: field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['address']) && !empty($_POST['address'])){
		}else{
			$data = array("mess"=>"ADDRESS field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['city']) && !empty($_POST['city'])){
		}else{
			$data = array("mess"=>"CITY field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['state']) && !empty($_POST['state'])){
		}else{
			$data = array("mess"=>"STATE field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['zip']) && !empty($_POST['zip'])){
		}else{
			$data = array("mess"=>"ZIP CODE field is required !");
			echo json_encode($data);
			return  ;
		}


		if(isset($_POST['full_name']) && !empty($_POST['full_name'])){
		}else{
			$data = array("mess"=>"CONTACT NAME field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['business_phone']) && !empty($_POST['business_phone'])){
		}else{
			$data = array("mess"=>"BUSINESS PHONE: field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['cellular_phone']) && !empty($_POST['cellular_phone'])){
		}else{
			$data = array("mess"=>"CELLULAR PHONE: field is required !");
			echo json_encode($data);
			return  ;
		}

		if(isset($_POST['dealer_name']) && !empty($_POST['dealer_name'])){
		}else{
			$data = array("mess"=>"DEALER NAME field is required !");
			echo json_encode($data);
			return  ;
		}
		if(isset($_POST['email']) && !empty($_POST['email'])){
		}else{
			$data = array("mess"=>"Email field is required !");
			echo json_encode($data);
			return  ;
		}



		$xyz = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAxUlEQVR4nO3BMQEAAADCoPVPbQhfoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOA1v9QAATX68/0AAAAASUVORK5CYII=';
		if(isset($_POST['esign']) && !empty($_POST['esign']) && $_POST['esign'] != $xyz){
		}else{
			$data = array("mess"=>"Signture field is required !");
			echo json_encode($data);
			return  ;
		}

		
	
			$insertArr = array(
				'user_id'=>$this->session->userdata('user_id'),
				'location_name'=>$_POST['location_name'],
				'address'=>$_POST['address'], 	
				'city'=>$_POST['city'],
				'state'=>$_POST['state'], 	
				'zip'=>$_POST['zip'],
				'full_name'=>$_POST['full_name'], 	
				'business_phone'=>$_POST['business_phone'],
				'cellular_phone'=>$_POST['cellular_phone'], 	
				'dealer_name'=>$_POST['dealer_name'],
				'esign_image'=>$_POST['esign'],
				'email'=>$_POST['email'],
				'sign_ip'=>$this->input->ip_address(),

			);
				

			if(!$this->db->insert('e_sign_reseller',$insertArr)){
				$data = array('mess' => $this->db->_error_message());
				echo json_encode($data );
			}else{
				$this->session->set_userdata('e_sign_status', 'yes');
				$this->send_agreement_sign_mail($this->session->userdata('user_id'), $this->session->userdata('user_name'));
			    
	           	$data = array('message' => 'Agreement Updated Successfully ! ');
				echo json_encode($data );
			}
		
		
	}


	function send_agreement_sign_mail(  $userId=null,  $userName=null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		
        $this->email->initialize($config);

        $this->email->from('info@xonnova.com', 'xonnova Network');
        $this->email->to('gustavo@xonnova.com');
       //$this->email->to('test.experdel@gmail.com');

        $this->email->subject('New Store Agreement Signed');
     
        $mail_body	='<div>
        					<p>A new Store has signed their agreement. </p>
        					<p>USER ID -  '.$userId.', </p>
        					<p>USER NAME - '.$userName.'</p>
        			</div>';
        $this->email->message($mail_body);

        $this->email->send();
    }


	
	


}