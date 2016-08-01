<?php
/**
* 
*/
class Redeem_coupons extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}

	function index(){
	}



	function getCouponsList(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		$from = $_POST['from_date'];
		$to = $_POST['to_date'];
		if(isset($from) && !empty($from) && isset($to) && !empty($to)){
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From coupon_info as a LEFT JOIN user_master as b on b.user_id=a.user_id  WHERE  a.coupon_updated_at BETWEEN "'.$from.'" AND "'.$to.'"');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}else{
			
			$list = $this->mdl_common->allSelects('SELECT a.*, b.user_name From coupon_info as a LEFT JOIN user_master as b on b.user_id=a.user_id');
			if(isset($list) && !empty($list)){
				foreach ($list as $key => $value) {
					$arr[] = $value;
				}
				echo json_encode($arr);
			}else{
				return false;
			}
		}
	}

	function checkCouponCode(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST) && !empty($_POST)){
			$list = $this->mdl_common->allSelects('SELECT * From coupon_info  WHERE coupon_status = "active" AND coupon_code = "'.$_POST['coupon_code'].'"');
			if(isset($list) && !empty($list)){
				foreach ($list  as $value) {
					$arr[]=$value;
				}
				echo json_encode($arr);
			}else{
				$data[] = array('reward_points'=>'Sorry! Coupon Code is Invalid');
				echo json_encode($data);
			}
		}else{
			$data[] = array('reward_points'=>'Sorry! Coupon Code is Required');
			echo json_encode($data);
		}
	}



	function getRewardPoint(){
		$_POST = json_decode(file_get_contents("php://input"),true);
		if(isset($_POST['coupon_id']) && !empty($_POST['coupon_id'])){
			$Date = date('Y-m-d H:i:s');
			$updateArr = array(
				'coupon_status'=>'inactive',
				'coupon_updated_at'=>$Date,
				'user_id'=>$this->session->userdata('user_id'),
			);
			if($this->db->update('coupon_info',$updateArr, array('coupon_id'=>$_POST['coupon_id']))){
				$Arr = array(
					'user_id'=>$this->session->userdata('user_id'),
					'credit'=>$_POST['reward_points'],
					'wallet_type'=>'1',
					'message'=>'BY Coupon Code '.$_POST['coupon_code'],
				);
				$this->db->insert('reward_points_report_info',$Arr);
				$existUser = count($this->mdl_common->allSelects('SELECT * FROM reward_points_report_user_map_info WHERE user_id='.$this->session->userdata('user_id')));
				if(empty($existUser) && $existUser == 0){
					$insertwallete = array(
						'user_id'=>$this->session->userdata('user_id'),
					);
					$this->db->insert('reward_points_report_user_map_info',$insertwallete);
				}
				$data = array('message'=>'Reward Point Added');
				echo json_encode($data);
			}else{
				$data = array('message'=>'Sorry! Coupon Code is Invalid');
				echo json_encode($data);
			}
		}else{
			$data = array('message'=>'Sorry! Coupon Code is Invalid');
			echo json_encode($data);
		}
	}

	
	


}