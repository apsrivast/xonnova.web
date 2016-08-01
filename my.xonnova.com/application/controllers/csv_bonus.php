<?php
 
class Csv_bonus extends CI_Controller {
 
    function __construct() {
        parent::__construct();        
    }

    function importcsv(){
        if(!empty($_FILES)) { 
            $date = date("YmdHis");
           
            $file = 'csv_bonus_'.$date.$_FILES[ 'file' ][ 'name' ];

            $configVideo = array(
                    'upload_path' => './assets/csv/',
                    'max_size' => '8000240',
                    'allowed_types' => 'text/plain|text|csv',
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
                        foreach ($csv_array as $row) {
                            if(isset($row['user_name']) && isset($row['kw']) && isset($row['p_kw'])){

                                $insert_data = array(
                                    'user_name'=>$row['user_name'],
                                    'kw'=>$row['kw'],
                                    'p_kw'=>$row['p_kw'],
                                );
                              
                                if(!$this->db->insert('csv_solar_bonus',$insert_data)){
                                    $data = array("err"=>$this->db->_error_message());
                                    echo json_encode($data);
                                    return;
                                }
                                $userID = $this->mdl_common->getUserId($row['user_name']);
                                if(!empty($userID)){
                                    $this->db->update('csv_solar_bonus',array('user_id'=>$userID),array('user_name'=>$row['user_name']));
                                }
                            }else{
                                $data = array('err'=> 'Sorry... Csv Data Not Imported, Or Please See note to create csv');
                                 echo json_encode($data);
                                    return;
                            }
                        }
                        $data = array('sucess'=> 'Csv Data Imported Succesfully');                        
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

    function importcsvSales(){
        if(!empty($_FILES)) { 
            $date = date("YmdHis");
           
            $file = 'csv_fast_sales_bonus_'.$date.$_FILES[ 'file' ][ 'name' ];

            $configVideo = array(
                    'upload_path' => './assets/csv/',
                    'max_size' => '8000240',
                    'allowed_types' => 'text/plain|text|csv',
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
                        foreach ($csv_array as $row) {
                            if(isset($row['user_name']) && isset($row['cp']) && isset($row['at'])){
                                $at = $this->changeDateFormat($row['at']);
                                $insert_data = array(
                                    'user_name'=>$row['user_name'],
                                    'cp'=>$row['cp'],
                                    'at'=>$at,
                                );
                              
                                if(!$this->db->insert('csv_fast_sales_bonus',$insert_data)){
                                    $data = array("err"=>$this->db->_error_message());
                                    echo json_encode($data);
                                    return;
                                }
                                $userID = $this->mdl_common->getUserId($row['user_name']);
                                if(!empty($userID)){
                                    $this->db->update('csv_fast_sales_bonus',array('user_id'=>$userID),array('user_name'=>$row['user_name']));
                                }
                            }else{
                                $data = array('err'=> 'Sorry... Csv Data Not Imported, Or Please See note to create csv');
                                 echo json_encode($data);
                                    return;
                            }
                        }
                        $data = array('sucess'=> 'Csv Data Imported Succesfully');                        
                }else{ 
                   $data = array('err'=>'Error occured : Please See note to create csv');
                }
            }
        }else{
            $data = array('err'=>'Please Select CSV File only!');
        }
        echo json_encode($data);
    }
}