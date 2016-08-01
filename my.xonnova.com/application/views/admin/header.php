<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Xonnova</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Xonnova ">
	<meta name="author" content="Xonnova ">

	<link rel="icon" type="image/png" href="<?php echo base_url();?>/assets/images/isologo.png">

	<!-- prochtml:remove:dist -->
	<link href="<?php echo base_url();?>assets/less/styles.less" rel="stylesheet/less" media="all"> 
	<!-- /prochtml -->
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'> 
	<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>     

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ie8.css">
	  <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
	  <script type="text/javascript" src="<?php echo base_url();?>/bower_components/flot/excanvas.min.js"></script>
	  <script type='text/javascript' src='<?php echo base_url();?>/assets/plugins/misc/placeholdr.js'></script>
	  <script type="text/javascript" src="<?php echo base_url();?>/assets/plugins/misc/media.match.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->

	<!-- build:css assets/css/vendor.css -->
	<!-- bower:css -->
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-ui-tree/dist/angular-ui-tree.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/ng-grid/ng-grid.css" />
	<!--<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-xeditable/dist/css/xeditable.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap-datepaginator/dist/bootstrap-datepaginator.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/fullcalendar/fullcalendar.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-meditor/dist/meditor.min.css" />
	
	-->
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/iCheck/skins/all.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/pnotify/pnotify.core.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/pnotify/pnotify.buttons.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/pnotify/pnotify.history.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/nanoscroller/bin/css/nanoscroller.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/textAngular/src/textAngular.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-ui-grid/ui-grid.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/switchery/dist/switchery.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/ng-sortable/dist/ng-sortable.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-ui-select/dist/select.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/animate.css/animate.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/nvd3/src/nv.d3.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/skylo/vendor/styles/skylo.css" />
	<!-- endbower -->
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/fonts/glyphicons/css/glyphicons.min.css' /> 
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/plugins/form-fseditor/fseditor.css' /> 
	<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/plugins/jcrop/css/jquery.Jcrop.min.css' /> 
	<!-- endbuild -->
	

	<!-- build:css({.tmp,app}) assets/css/main.css -->
	  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/styles.css">
	  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/angular-pickadate.css">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.date.css"/>
	<!-- endbuild -->
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-custom-width.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-default.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-plain.css"/>

	<!-- prochtml:remove:dist -->
	<script type="text/javascript">less = { env: 'production'};</script>
	<script type="text/javascript" src="<?php echo base_url();?>/assets/plugins/misc/less.js"></script>
	<!-- /prochtml -->
	<script>
		var BASE_URL = "<?php echo base_url(); ?>";
		console.log(BASE_URL);
		var LOGIN_TYPE = "<?php echo $this->session->userdata('user_type'); ?>";
		
		var CUR_USER = "<?php echo $current_user = $this->session->userdata('user_email'); ?>";
		var UNILEVEL_USER = "<?php echo $unilevel = $this->session->userdata('uninlevel_user');?>";

		<?php 
		 $this->mdl_common->empMenu($this->session->userdata('user_id'));
		?>


		<?php
			$sb_id = $this->session->userdata('sb_id');
			$sb_name = $this->session->userdata('sb_name');
			if(isset($sb_id) && !empty($sb_id) && isset($sb_name) && !empty($sb_name)){
				$this->mdl_common->SBdownLineChildUser($this->session->userdata('sb_id'),$this->session->userdata("sb_name"));
			}else{
				$this->mdl_common->SBdownLineChildUser($this->session->userdata('user_id'),$this->session->userdata("user_name"));	
			}
  			
		?>
		

		<?php 
		 		$cur_user_id = $this->session->userdata('user_id');
		 		$board_view_user = $this->session->userdata('boardlevel_user');
		 		if(isset($board_view_user) && !empty($board_view_user)){
					$query = "SELECT * FROM user_master  WHERE user_email = '".$board_view_user."'";
					$tree = $this->mdl_common->allSelects($query);
					if(isset($tree) && !empty($tree)){
						foreach ($tree as $key => $value) {			
								echo 'var treeData = {"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
								"children":[';
								$left = $this->mdl_common->leftChild($value['user_id']);
								$right = $this->mdl_common->rightChild($value['user_id']);
								$Ltree1 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left."'");
								$Rtree1 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right."'");
								if(!empty($Ltree1) && !empty($left)){
									foreach ($Ltree1 as $key => $value1) {
										echo '{
											"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
												$left1 = $this->mdl_common->leftChild($value1['user_id']);
												$right1 = $this->mdl_common->rightChild($value1['user_id']);
												$Ltree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left1."'");
												$Rtree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right1."'");
												if(!empty($Ltree2) && !empty($left1)){
													foreach ($Ltree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo ']},';
													}
												}else{
													echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
												}
												if(!empty($Rtree2) && !empty($right1)){
													foreach ($Rtree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo']},';
													}
												}else{
													echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
												}
										echo ']},';							
									}								
								}else{
									echo '{"id":"L'.$cur_user_id.'","name":"Add New User","parent_id":'.$cur_user_id.',"level":0,"position_tree":"L","image":"0"},';
								}

								if(!empty($Rtree1) && !empty($right)){
									foreach ($Rtree1 as $key => $value1) {
										echo '{
											"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
												$left1 = $this->mdl_common->leftChild($value1['user_id']);
												$right1 = $this->mdl_common->rightChild($value1['user_id']);
												$Ltree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left1."'");
												$Rtree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right1."'");
												if(!empty($Ltree2) && !empty($left1)){
													foreach ($Ltree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo ']},';
													}
												}else{
													echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
												}
												if(!empty($Rtree2) && !empty($right1)){
													foreach ($Rtree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo']},';
													}
												}else{
													echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
												}
										echo ']},';
										
									}								
								}else{
									echo '{"id":"R'.$cur_user_id.'","name":"Add User","parent_id":'.$cur_user_id.',"level":0,"position_tree":"R","image":"0"},';
								}	
								echo ']';
							echo '};';
						}
					}
				}else{
					$query = "SELECT * FROM user_master  WHERE user_id = '".$cur_user_id."'";
					$tree = $this->mdl_common->allSelects($query);
					if(isset($tree) && !empty($tree)){
						foreach ($tree as $key => $value) {			
								echo 'var treeData = {"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
								"children":[';
								$left = $this->mdl_common->leftChild($value['user_id']);
								$right = $this->mdl_common->rightChild($value['user_id']);
								$Ltree1 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left."'");
								$Rtree1 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right."'");
								if(!empty($Ltree1) && !empty($left)){
									foreach ($Ltree1 as $key => $value1) {
										echo '{
											"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
												$left1 = $this->mdl_common->leftChild($value1['user_id']);
												$right1 = $this->mdl_common->rightChild($value1['user_id']);
												$Ltree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left1."'");
												$Rtree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right1."'");
												if(!empty($Ltree2) && !empty($left1)){
													foreach ($Ltree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo ']},';
													}
												}else{
													echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
												}
												if(!empty($Rtree2) && !empty($right1)){
													foreach ($Rtree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo']},';
													}
												}else{
													echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
												}
										echo ']},';							
									}								
								}else{
									echo '{"id":"L'.$cur_user_id.'","name":"Add New User","parent_id":'.$cur_user_id.',"level":0,"position_tree":"L","image":"0"},';
								}

								if(!empty($Rtree1) && !empty($right)){
									foreach ($Rtree1 as $key => $value1) {
										echo '{
											"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
												$left1 = $this->mdl_common->leftChild($value1['user_id']);
												$right1 = $this->mdl_common->rightChild($value1['user_id']);
												$Ltree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left1."'");
												$Rtree2 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right1."'");
												if(!empty($Ltree2) && !empty($left1)){
													foreach ($Ltree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo ']},';
													}
												}else{
													echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
												}
												if(!empty($Rtree2) && !empty($right1)){
													foreach ($Rtree2 as $key => $value2) {
														echo '{
															"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
															$left2 = $this->mdl_common->leftChild($value2['user_id']);
															$right2 = $this->mdl_common->rightChild($value2['user_id']);
															$Ltree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left2."'");
															$Rtree3 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right2."'");
															if(!empty($Ltree3) && !empty($left2)){
																foreach ($Ltree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"L'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"L","image":"0"},';
															}
															if(!empty($Rtree3) && !empty($right2)){
																foreach ($Rtree3 as $key => $value3) {
																	echo '{
																		"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																		$left3 = $this->mdl_common->leftChild($value3['user_id']);
																		$right3 = $this->mdl_common->rightChild($value3['user_id']);
																		$Ltree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left3."'");
																		$Rtree4 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right3."'");
																		if(!empty($Ltree4) && !empty($left3)){
																			foreach ($Ltree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"L'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																		}
																		if(!empty($Rtree4) && !empty($right3)){
																			foreach ($Rtree4 as $key => $value4) {
																				echo '{
																					"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																					$left4 = $this->mdl_common->leftChild($value4['user_id']);
																					$right4 = $this->mdl_common->rightChild($value4['user_id']);
																					$Ltree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$left4."'");
																					$Rtree5 = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$right4."'");
																					if(!empty($Ltree5) && !empty($left4)){
																						foreach ($Ltree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"L'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"L","image":"0"},';
																					}
																					if(!empty($Rtree5) && !empty($right4)){
																						foreach ($Rtree5 as $key => $value5) {
																							echo '{
																								"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																								
																							echo']},';
																						}
																					}else{
																						echo '{"id":"R'.$value4["user_id"].'","name":"Add User","parent_id":'.$value4["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																					}
																				echo']},';
																			}
																		}else{
																			echo '{"id":"R'.$value3["user_id"].'","name":"Add User","parent_id":'.$value3["user_id"].',"level":0,"position_tree":"R","image":"0"},';
																		}
																	echo']},';
																}
															}else{
																echo '{"id":"R'.$value2["user_id"].'","name":"Add User","parent_id":'.$value2["user_id"].',"level":0,"position_tree":"R","image":"0"},';
															}
														echo']},';
													}
												}else{
													echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
												}
										echo ']},';
										
									}								
								}else{
									echo '{"id":"R'.$cur_user_id.'","name":"Add User","parent_id":'.$cur_user_id.',"level":0,"position_tree":"R","image":"0"},';
								}	
								echo ']';
							echo '};';
						}
					}
				}
				$unilevel = $this->session->userdata('uninlevel_user');
				$current_user = $this->session->userdata('user_email');
				if($unilevel == $current_user){
					$unileveluser = $this->session->userdata('user_email');
					$data = "";
			 		$query = "SELECT * FROM user_master  WHERE user_email = '".$unileveluser."'";
					$tree = $this->mdl_common->allSelects($query);
					if(isset($tree) && !empty($tree)){
						foreach ($tree as $key => $value) {			
								$data .= 'var UnileveltreeData = {"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
								"children":[';
								$query1 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value["user_id"]."'";
								$tree1 = $this->mdl_common->allSelects($query1);
								foreach ($tree1 as $key => $value1) {
									$data .= '{
										"id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
											$query2 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value1["user_id"]."'";
											$tree2 = $this->mdl_common->allSelects($query2);
											if(isset($tree2) && !empty($tree2)){
												foreach ($tree2 as $key => $value2) {
													$data .= '{
														"id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value2["user_id"].',"level":0,"image":"avatar_default.png","children":[';
														$query3 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value2["user_id"]."'";
														$tree3 = $this->mdl_common->allSelects($query3);
														if(isset($tree3) && !empty($tree3)){
															foreach ($tree3 as $key => $value3) {
																$data .= '{
																	"id":'.$value3["user_id"].',"name":"'.$value3["user_name"].'","parent_id":'.$value3["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																	$query4 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value3["user_id"]."'";
																	$tree4 = $this->mdl_common->allSelects($query4);
																	if(isset($tree4) && !empty($tree4)){
																		foreach ($tree4 as $key => $value4) {
																			$data .= '{
																				"id":'.$value4["user_id"].',"name":"'.$value4["user_name"].'","parent_id":'.$value4["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																				$query5 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value4["user_id"]."'";
																				$tree5 = $this->mdl_common->allSelects($query5);
																				if(isset($tree5) && !empty($tree5)){
																					foreach ($tree5 as $key => $value5) {
																						$data .= '{
																							"id":'.$value5["user_id"].',"name":"'.$value5["user_name"].'","parent_id":'.$value5["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																							$query6 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value5["user_id"]."'";
																							$tree6 = $this->mdl_common->allSelects($query6);
																							if(isset($tree6) && !empty($tree6)){
																								foreach ($tree6 as $key => $value6) {
																									$data .= '{
																										"id":'.$value6["user_id"].',"name":"'.$value6["user_name"].'","parent_id":'.$value6["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																										$query7 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value6["user_id"]."'";
																										$tree7 = $this->mdl_common->allSelects($query7);
																										if(isset($tree7) && !empty($tree7)){
																											foreach ($tree7 as $key => $value7) {
																												$data .= '{
																													"id":'.$value7["user_id"].',"name":"'.$value7["user_name"].'","parent_id":'.$value7["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																													$query8 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value7["user_id"]."'";
																													$tree8 = $this->mdl_common->allSelects($query8);
																													if(isset($tree8) && !empty($tree8)){
																														foreach ($tree8 as $key => $value8) {
																															$data .= '{
																																"id":'.$value8["user_id"].',"name":"'.$value8["user_name"].'","parent_id":'.$value8["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																																$query9 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value8["user_id"]."'";
																																$tree9 = $this->mdl_common->allSelects($query9);
																																if(isset($tree9) && !empty($tree9)){
																																	foreach ($tree9 as $key => $value9) {
																																		$data .= '{
																																			"id":'.$value9["user_id"].',"name":"'.$value9["user_name"].'","parent_id":'.$value9["user_id"].',"level":0,"image":"avatar_default.png","children":[';
																																			
																																		$data .=']},';
																																	}
																																}		
																															$data .=']},';
																														}
																													}								
																												$data .=']},';
																											}
																										}
																									$data .=']},';
																								}
																							}
																						$data .=']},';
																					}
																				}
																			$data .=']},';
																		}
																	}
																$data .=']},';
															}
														}
													$data .=']},';
												}
											}
									$data .= ']},';						
								}
								$data .= ']';
							$data .= '};';
						}
						echo $data;
					}
				}else{
					$unileveluser = $this->session->userdata('uninlevel_user');
			 		//$cur_user_id = $this->session->userdata('user_id');
			 		$query = "SELECT * FROM user_master  WHERE user_email = '".$unileveluser."'";
					$tree = $this->mdl_common->allSelects($query);
					if(isset($tree) && !empty($tree)){
						foreach ($tree as $key => $value) {			
								echo 'var UnileveltreeDatasearch = {"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
								"children":[';
								$query22 = "SELECT   * FROM user_master  WHERE sponsor_id = '".$value["user_id"]."'";
								$tree22 = $this->mdl_common->allSelects($query22);
								if(isset($tree22) && !empty($tree22)){
									foreach ($tree22 as $key => $value22) {
										echo  '{
											"id":'.$value22["user_id"].',"name":"'.$value22["user_name"].'","parent_id":'.$value22["user_id"].',"level":0,"image":"avatar_default.png","children":[';
											
										echo ']},';
									}
								}
								echo ']';
							echo '};';
						}
					}
				}
		 	?>
    </script>
</head>

<body
  ng-app="themesApp"
  ng-controller="MainController"
  class="{{getLayoutOption('sidebarThemeClass')}} {{getLayoutOption('topNavThemeClass')}}"
  ng-class="{
			  'static-header': !getLayoutOption('fixedHeader'),
			  'focusedform': getLayoutOption('fullscreen'),
			  'layout-horizontal': getLayoutOption('layoutHorizontal'),
			  'fixed-layout': getLayoutOption('layoutBoxed'),
			  'sidebar-collapsed': getLayoutOption('leftbarCollapsed') && !getLayoutOption('leftbarShown'),
			  'show-infobar': getLayoutOption('rightbarCollapsed'),
			  'show-sidebar': getLayoutOption('leftbarShown')
			}"
  ng-click="hideHeaderBar();hideChatBox()"
  to-top-on-load
>

<!-- <div ng-include="'application/views/admin/views/templates/custom-styles.html'"></div>

<ng-include src="'application/views/admin/views/layout/header.html'"></ng-include> -->