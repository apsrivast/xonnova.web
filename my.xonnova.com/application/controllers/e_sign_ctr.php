<?php
/**
* 
*/
class E_sign_ctr extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){



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
		}else{
			$data = array('err'=>'Sorry, Agreement not generated please try again !');
		}
		echo json_encode($data);
 	}


	function submitEsign(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		if(isset($_POST['first_name']) && !empty($_POST['first_name'])){

			/* $contentData = $this->mdl_common->allSelects('SELECT first_name FROM  user_master where user_id = '.$this->session->userdata('user_id'));
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					// $arr[] = $value;

					if($_POST['first_name'] == $value['first_name']){
					}else{

						$data = array("mess"=>"First Name Not Correct");
						echo json_encode($data);
						return  ;

					}		

				}
				
			}else{

				$data = array("mess"=>"First Name Not in Database   !");
				echo json_encode($data);
				return  ;

			}		 */

		}else{
			$data = array("mess"=>"First Name field is required !");
			echo json_encode($data);
			return  ;
		}
		
		if(isset($_POST['last_name']) && !empty($_POST['last_name'])){

			/* $contentData = $this->mdl_common->allSelects('SELECT last_name FROM  user_master where user_id = '.$this->session->userdata('user_id'));
			if(isset($contentData) && !empty($contentData)){
				foreach ($contentData as $value) {
					// $arr[] = $value;

					if($_POST['last_name'] == $value['last_name']){
					}else{

						$data = array("mess"=>"Last Name Not Correct");
						echo json_encode($data);
						return  ;

					}		

				}
				
			}else{

				$data = array("mess"=>"Last Name Not in Database   !");
				echo json_encode($data);
				return  ;

			}		 */
		}else{
			$data = array("mess"=>"Last Name field is required !");
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
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'], 	
			'esign_image'=>$_POST['esign'],
			'sign_ip'=>$this->input->ip_address(),

		);
			

		if(!$this->db->insert('e_sign',$insertArr)){
		    $data = array('mess' => $this->db->_error_message());
			echo json_encode($data );
		}else{
           	$data = array('message' => 'Agreement Updated Successfully ! ');
			echo json_encode($data );
		}
	}

	
	


}