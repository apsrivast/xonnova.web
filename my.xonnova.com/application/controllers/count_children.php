<?php 
/**
* 
*/
class Count_children extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
	}
	/*function myLevel($a){
		//header('Content-Type: application/json');
		$query = "SELECT * FROM user_master  WHERE user_id = '".$a."'";
		$tree = $this->mdl_common->allSelects($query);
		$m = null;
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $key => $value4) {	
				
					$left4 = $this->mdl_common->leftChild($value4['user_id']);
					$right4 = $this->mdl_common->rightChild($value4['user_id']);
					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
					if(!empty($Ltree5) && !empty($left4)){
						foreach ($Ltree5 as $key => $value5) {
							$m ++;
						}
					}
					if(!empty($Rtree5) && !empty($right4)){
						foreach ($Rtree5 as $key => $value5) {
							$m ++;
						}
					}
				$m++;
			}
		}
		echo $m;
	}*/

	function getChartValue(){
		header('Content-Type: application/json');
		$userId = $this->session->userdata('user_id');
		$binaryValue = $this->totalBinaryTreeCount($userId);
		$successValue = $this->totalSuccessTreeCount($userId);
		$query = $this->mdl_common->allSelects("SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as d from user_master WHERE user_id=".$userId);
		foreach ($query as $key => $value) {
			$year = $value['d'];
		}
		$userRegDate = $year;
		//print_r($userRegDate);
		$curDate = date('Y-m-d');
		$data = array(
				array('y'=>$userRegDate, 'a'=>0, 'b'=>0),
				array('y'=>$curDate, 'a'=>$successValue, 'b'=>$binaryValue)
			);
		echo json_encode($data);
	}


	//Counting the total number of nodes in a binary tree
	function totalBinaryTreeCount($a){
		//header('Content-Type: application/json');
		$query = "SELECT * FROM user_master  WHERE user_id = '".$a."'";
		$tree = $this->mdl_common->allSelects($query);

		static $m=null;
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $value) {
				$arr = array(
					'user_id' => $value['user_id'],
					'created_at' => $value['created_at']
					);
			}
			$this->db->insert('user_binary_tree', $arr);
			foreach ($tree as $key => $value4) {	
					$left4 = $this->mdl_common->leftChild($value4['user_id']);
					$right4 = $this->mdl_common->rightChild($value4['user_id']);
					
					$Ltree5 = $this->mdl_common->allSelects("SELECT user_id, created_at FROM user_master  WHERE user_id = '".$left4."'");
					$Rtree5 = $this->mdl_common->allSelects("SELECT user_id, created_at FROM user_master  WHERE user_id = '".$right4."'");

					if(!empty($Ltree5) && !empty($left4)){
						foreach ($Ltree5 as $key => $value) {
							//$m++;
							//echo json_encode($Ltree5);
							$left1=$this->totalBinaryTreeCount($value['user_id']);				
						}
					}
					if(!empty($Rtree5) && !empty($right4)){
						foreach ($Rtree5 as $key => $value){
							//$m++;
							//echo json_encode($Rtree5);
							$right1=$this->totalBinaryTreeCount($value['user_id']);
						}
					}
					$m++;
			}
		}

		return $m;
	}
	//Returning the total count in a tree
	function getTotalBinaryTreeCount($id){
		$total = $this->totalBinaryTreeCount($id);
		return $total;
	}

	//Counting the total number of nodes in a success tree
	function totalSuccessTreeCount($id){
		$query = "SELECT * FROM user_master  WHERE user_id = '".$id."'";
		$tree = $this->mdl_common->allSelects($query);
		static $m=null;
		if(isset($tree) && !empty($tree)){
			foreach ($tree as $key => $value) {
				$top = $this->mdl_common->SBleftChild($value['user_id']);
				$mid = $this->mdl_common->SBmidChild($value['user_id']);
				$bottom = $this->mdl_common->SBrightChild($value['user_id']);
				$topTree = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$top."'");
				$midTree = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$mid."'");
				$bottomTree = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$bottom."'");
				if(!empty($topTree) && !empty($top)) {
						foreach ($topTree as $key => $value) {
							$topChild=$this->totalSuccessTreeCount($value['user_id']);				
						}
				}
				if(!empty($midTree) && !empty($mid)) {
						foreach ($midTree as $key => $value) {
							$midChild=$this->totalSuccessTreeCount($value['user_id']);				
						}
				}
				if(!empty($bottomTree) && !empty($bottom)) {
						foreach ($bottomTree as $key => $value) {
							$bottomChild=$this->totalSuccessTreeCount($value['user_id']);				
						}
				}
				$m++;
			}
		}
		return json_encode($m);
	}

	function getTotalSuccessTreeCount($id){
		$total = $this->totalSuccessTreeCount($id);
		return $total;
	}


	function countChildren($table,$id,$totalMember=null){		
		$query = "SELECT * FROM $table WHERE parent_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		$totalMember = count($child->result_array());
		foreach ($childresult as $key => $value) {
			if(!empty($value['lft_user'])){
				$children = $value['lft_user'];	
				if(!empty($children)){					
					echo $totalMember += $totalMember;
					$this->countChildren($table,$children,$totalMember);				
				}			
			}

			if(!empty($value['rght_user'])){
				$children = $value['rght_user'];				
				if(!empty($children)){
					echo $totalMember += $totalMember;
					$this->countChildren($table,$children,$totalMember);				
				}
			}
		}
		return $totalMember;

	}

	function countChildren1($id){	
	$membercount = 	$this->countChildren('user_master',$id);
		/*$query = "SELECT * FROM user_master WHERE parent_id = ".$id;
		$child = $this->db->query($query);
		$childresult =  $child->result_array();
		$membercount = count($childresult);
		$membercount1 = null;
		foreach ($childresult as $key => $value) {
			$childquery = "SELECT * from user_master WHERE parent_id = ".$value['user_id']." and created_at between 'created_at' and '2016-4-28'";
			$child1 = $this->db->query($childquery);
			$childresult1 = $child1->result_array();
			$membercount += count($childresult1);
		}*/
		echo json_encode($membercount);
	}
}