<?php
 
class Csv extends CI_Controller {
 
    function __construct() {
        parent::__construct();        
    }

    function importcsv(){
        if(!empty($_FILES)) { 
            $date = date("YmdHis");
           
            $file = 'csv_'.$date.$_FILES[ 'file' ][ 'name' ];

            $configVideo = array(
                    'upload_path' => './assets/csv/',
                    'max_size' => '8000240',
                    'allowed_types' => 'text/plain|text|csv|csv',
                    'overwrite'=> FALSE,
                    'remove_spaces' => TRUE,
                    'file_name'=> $file
            );

            $this->load->library('upload', $configVideo);
            $this->upload->initialize($configVideo);
            if (!$this->upload->do_upload('file')) {
                $data = array('err'=>'Error occured => '.$this->upload->display_errors());                
            }else{
                $file_data = $this->upload->data();
                $file_path =  './assets/csv/'.$file;
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    $i = null;
                    if(!empty($row['created_at']) && !empty($row['arb_id']) && !empty($row['status'])){
                        foreach ($csv_array as $row) {
                            $created_at = $this->changeDateFormat($row['created_at']);
                            $insert_data = array(
                                'arb_id'=>$row['arb_id'],
                                'status'=>$row['status'],
                                'created_at'=>$created_at,
                            );
                            $this->db->insert('active_subscription_info',$insert_data);
                            $userID = $this->mdl_common->getUserIdByArbId($row['arb_id']);
                            if(!empty($userID)){
                                $this->db->update('active_subscription_info',array('user_id'=>$userID),array('arb_id'=>$row['arb_id']));
                                $this->db->update('user_master',array('subscription_status'=>'inactive','user_status'=>'inactive'),array('user_id'=>$userID));
                            }
                           
                        }
                        $data = array('sucess'=> 'Csv Data Imported Succesfully');                        
                    }else{
                        $data = array('sucess'=> 'Sorry... Csv Data Not Imported, Or Please See note to create csv');
                    }
                }else{ 
                   $data = array('err'=>'Error occured : Please See note to create csv');
                }
            }
        }else{
            $data = array('err'=>'Please Select CSV File only!');
        }
        echo json_encode($data);
    }
    
    function changeDateFormat($originalDate=null){
        if(!empty($originalDate)){
            return date("Y-m-d H:i:s", strtotime($originalDate));
        }else{
           return date('Y-m-d H:i:s'); 
        }
    }
}