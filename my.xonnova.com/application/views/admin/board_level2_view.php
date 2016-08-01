	<style type="text/css">
		#testform { 
		    border-radius: 10px;
		    border: 3px solid #ccc;
		    box-shadow: 0px 2px 5px 0px #444;
		    background: #fff;
		    position: relative;
		    padding: 10px;
		    overflow: hidden;
		} 

		.simple-form-button {
			-moz-border-bottom-colors: none;
		    -moz-border-image: none;
		    -moz-border-left-colors: none;
		    -moz-border-right-colors: none;
		    -moz-border-top-colors: none;
		    background: -moz-linear-gradient(center top , #FFFFFF, #ff6702 ) repeat scroll 0 0 transparent;
		    background: -webkit-linear-gradient(center top , #FFFFFF, #ff6702 ) repeat scroll 0 0 transparent;
		    border-color: #E2E2E2 #DDDDDD #CCCCCC;
		    border-left: 1px solid #DDDDDD;
		    border-radius: 5px 5px 5px 5px;
		    border-right: 1px solid #DDDDDD;
		    border-style: solid;
		    border-width: 1px 1px 2px;
		    color: #000000;
		    cursor: pointer;
		    font-size: 9pt;
		    margin: 0;
		    padding: 8px 18px;
		    width: auto;
		    height: auto;
		}

		.submit-button {
			background: -moz-linear-gradient(center top , #FFFFFF, #2a8db4) repeat scroll 0 0 transparent;
		    float: right;
		    display: none;
		}

		.form-controls {
		    clear: both;
		}

		.previous-fieldset {
			display: none;
			float: left;
		}
		.next-fieldset {
			float: right;
		},
		a.next-fieldset,
		a.previous-fieldset {
			color: #ccc;
		}

		.clear {
			clear: both;
		}
		.progress {
			border-bottom: 1px solid #EEECE9;
		    border-top: 1px solid #FFFFFF;
		    height: 20px;
		}

		.progress-bar {
	        height: 22px;
	        position: relative;
	        /*background: #e2e2e2;*/
	        -moz-border-radius: 25px;
	        -webkit-border-radius: 25px;
	        border-radius: 25px;
	        padding: 3px;
	        -webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
	        -moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
	        box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);
	        margin: 10px 0;
	        overflow: hidden;
	        float: none;
	        width: 100%;
		}

		.progress-bar .progress-bg{
	        display: block;
	        height: 100%;
	        -webkit-border-top-right-radius:    20px;
	        -webkit-border-bottom-right-radius: 20px;
	        -moz-border-radius-topright:        20px;
	        -moz-border-radius-bottomright:     20px;
	        border-top-right-radius:            20px;
	        border-bottom-right-radius:         20px;
	        -webkit-border-top-left-radius:     20px;
	        -webkit-border-bottom-left-radius:  20px;
	        -moz-border-radius-topleft:         20px;
	        -moz-border-radius-bottomleft:      20px;
	        border-top-left-radius:             20px;
	        border-bottom-left-radius:          20px;
	        background-color: rgb(255, 103, 2);
	        background-image: -webkit-gradient(
				linear,
				left bottom,
				left top,
				color-stop(0, rgb(255, 103, 2)),
				color-stop(1, rgb(255, 103, 2))
	        );
	        background-image: -webkit-linear-gradient(
				center bottom,
				rgb(255, 103, 2) 37%,
				rgb(255, 103, 2) 69%
			);
	        background-image: -moz-linear-gradient(
				center bottom,
				rgb(255, 103, 2) 37%,
				rgb(255, 103, 2) 69%
			);
	        background-image: -ms-linear-gradient(
				center bottom,
				rgb(255, 103, 2) 37%,
				rgb(255, 103, 2) 69%
	        );
	        background-image: -o-linear-gradient(
				center bottom,
				rgb(255, 103, 2) 37%,
				rgb(255, 103, 2) 69%
	        );
	        -webkit-box-shadow:
				inset 0 2px 9px  rgba(255,255,255,0.3),
				inset 0 -2px 6px rgba(0,0,0,0.4);
	        -moz-box-shadow:
				inset 0 2px 9px  rgba(255,255,255,0.3),
				inset 0 -2px 6px rgba(0,0,0,0.4);
	        overflow: hidden;
	        width: 0%;
		}

		.progress-bar .progress-text {
		    position: absolute;
		    left: 50%;
		    top: 2px;
		    z-index: 10;
		}

		.panel.with-nav-tabs .panel-heading{
		    padding: 5px 5px 0 5px;
		}
		.panel.with-nav-tabs .nav-tabs{
		    border-bottom: none;
		}
		.panel.with-nav-tabs .nav-justified{
		    margin-bottom: -1px;
		}
		/********************************************************************/
		/*** PANEL DEFAULT ***/
		.with-nav-tabs.panel-default .nav-tabs > li > a,
		.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
		    color: #777;
		}
		.with-nav-tabs.panel-default .nav-tabs > .open > a,
		.with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
		.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
		    color: #777;
		    background-color: #ddd;
		    border-color: transparent;
		}
		.with-nav-tabs.panel-default .nav-tabs > li.active > a,
		.with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
		    color: #555;
		    background-color: #fff;
		    border-color: #ddd;
		    border-bottom-color: transparent;
		}
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
		    background-color: #f5f5f5;
		    border-color: #ddd;
		}
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
		    color: #777;   
		}
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
		    background-color: #ddd;
		}
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
		.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
		    color: #fff;
		    background-color: #555;
		}
	</style>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<style type="text/css">
	    .error{color: red;}
	</style>
	<style type="text/css">
	    .error{color: red;}
	</style>
	<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>

	<script type="text/javascript">
	    $(document).ready(function () {
	        var date = new Date();
	        date.setDate(date.getDate() - 1);

	        $( "#datepicker" ).datepicker({
	            dateFormat: 'yy-mm-dd',
	            changeMonth: true,
	            changeYear: true,
	            yearRange: "1900:2050",
	        });

	        $( "#datepicker1" ).datepicker({
	            dateFormat: 'yy-mm-dd',
	            changeMonth: true,
	            changeYear: true,
	            yearRange: "1900:2050",
	        });

	        $( "#datepicker2" ).datepicker({
	            dateFormat: 'yy-mm-dd',
	            changeMonth: true,
	            changeYear: true,
	            yearRange: "1900:2050",
	        });

	        $( "#sponsorchange" ).change(function(){
	            $.ajax({
	                 type: "post",
	                 url: "<?php echo base_url(); ?>"+"newMemberRegistration/check_sponsorfor_form/"+ $(this).val(),
	                 success: function(data){
	                    if (data =='Invalid Sponsor' ) {
	                       var message = '<div class="alert alert-danger fade in"><button  data-dismiss="alert" class="close" type="button">×</button><strong>'+data+'</strong></div>';
	                            $('#error-message').html(message);
	                             $('#error-message').attr('style','display:block');
	                    }else{
	                        $('#error-message').attr('style','display:none');
	                        return true;
	                    }
	                   
	                 }
	            });
	        });
	    });
	</script>
	<div id="page-wrapper">	
		<div class="page-header">
		    <ul class="breadcrumb">
		        <li><a href="#">Team</a></li>
		        <li class="active">Position</li>
		    </ul>
		</div>
		<div class="row">
	        <div class="col-lg-3 col-md-6">
	            <div class="panel panel-red">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-group fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?php if(isset($member)) echo $member; else echo '0'; ?></div>
	                            <div>Members in my network</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                        <span class="pull-left"><a href="<?php echo base_url('userTeam');?>">View Details</a></span>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-6">
	            <div class="panel panel-red">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-group fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge"><?php echo $children; ?></div>
	                            <div><?php echo $current_level; ?><br/></div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                        <span class="pull-left"><a href="<?php echo base_url('userTeam/addNewMember');?>">Add New Members</a></span>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
	        <div class="col-lg-3 col-md-6">
	            <div class="panel panel-red">
	                <div class="panel-heading">
	                    <div class="row">
	                        <div class="col-xs-3">
	                            <i class="fa fa-group fa-5x"></i>
	                        </div>
	                        <div class="col-xs-9 text-right">
	                            <div class="huge">
	                                <?php 
	                                    if(isset($lifetotal) && !empty($lifetotal)){ echo '$'. $lifetotal;}else{ echo '$'. 0; }
	                                ?>
	                            </div>
	                            <div>Your Total Earning !</div>
	                        </div>
	                    </div>
	                </div>
	                <a href="#">
	                    <div class="panel-footer">
	                        <span class="pull-left"><a href="<?php echo base_url('userTeam/addNewMember');?>">Add New Members</a></span>
	                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                        <div class="clearfix"></div>
	                    </div>
	                </a>
	            </div>
	        </div>
	    </div>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
			        <div class="panel-heading">
						<i class="fa fa-th-large"></i>&nbsp;Binary Tree
					</div>
					<div class="panel-body">
						<div class="col-sm-12">
							<div class="col-sm-6 pull-right">
								<form method="post" action="<?php echo base_url('adminTeam/boardLevel'); ?>" id="level-form-select">
									<div class="input-group pull-right">
										<input type="text" name="user_name" placeholder="Enter User Name...." class="select-form-control" id="search_user">
				                        <select name="level" class="select-form-control" id="select-level">
				                       		<option value="none" selected="selected">Default</option>
				                       		<option value="1">First Level Board</option>
				                       		<option value="2">Second Level Board</option>
				                       		<option value="3">Third Level Board</option>
				                       		<option value="4">Fourth Level Board</option>
				                       		<option value="5">Fifth Level Board</option>
				                       		<option value="6">Sixth Level Board</option>
				                       		<option value="7">Seventh Level Board</option>
				                       		<option value="8">Eighth Level Board</option>
				                       		<option value="9">Ninth Level Board</option>
				                       		<option value="10">Tenth Level Board</option>
				                        </select>
				                       <!-- <span id="search_user_icon" style="background-color: green; color: white" class="input-group-addon btn">
				                           <button type="submit" name="submit" class="fa fa-search"></button> 
				                       </span> -->
				                   </div>
								</form>
							</div>
						</div>
						<div class="col-sm-12">
	                       	<div class="content">
								<div id="chart"></div>
							</div>		
						</div>			
					</div>
			    </div>
			</div>
		</div>	

		<script type="text/javascript">
		  	$(document).ready(function(){
		  		$('#select-level').change(function() {
				    $('#level-form-select').submit();
				});
		  	});
		</script>
		<?php //if(isset($table) && !empty($table) && $tablecount > 0){ ?>
			<script src="<?php echo base_url(); ?>/assets/trjs/d3.js"></script>       
			<style>
				.circle { cursor: pointer;		}
				text {	font-size: 13px; stroke-width: 1px;	}

				path.link {	fill: none;	stroke: #ccc;	stroke-width: 1.5px;}
			</style>
			<script type="text/javascript">
			 	<?php 
			 		if(!empty($table)){
				 		$query = "SELECT * FROM ".$table."  WHERE user_id = '".$id."'";
						$tree = $this->mdl_common->allSelects($query);
						if(isset($tree) && !empty($tree)){
							foreach ($tree as $key => $value) {         
						        echo 'var treeData = {"id":'.$value["user_id"].',"name":"'.$value["user_name"].'","image":"avatar_default.png","level":0,
						        "children":[';
						        $left = $this->mdl_common->boardLevelLeftChild($table,$value['user_id']);
						        $right = $this->mdl_common->boardLevelRightChild($table,$value['user_id']);
						        $Ltree1 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$left."'");
						        $Rtree1 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$right."'");
						        if(!empty($Ltree1) && !empty($left)){
						            foreach ($Ltree1 as $key => $value1) {
						                echo '{
						                    "id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                        $left1 = $this->mdl_common->boardLevelLeftChild($table,$value1['user_id']);
						                        $right1 = $this->mdl_common->boardLevelRightChild($table,$value1['user_id']);
						                        $Ltree2 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$left1."'");
						                        $Rtree2 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$right1."'");
						                        if(!empty($Ltree2) && !empty($left1)){
						                            foreach ($Ltree2 as $key => $value2) {
						                                echo '{
						                                    "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                                    
						                                echo ']},';
						                            }
						                        }else{
						                            echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
						                        }
						                        if(!empty($Rtree2) && !empty($right1)){
						                            foreach ($Rtree2 as $key => $value2) {
						                                echo '{
						                                    "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                                    
						                                echo']},';
						                            }
						                        }else{
						                            echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
						                        }
						                echo ']},';                         
						            }                               
						        }else{
						            echo '{"id":"L'.$id.'","name":"Add New User","parent_id":'.$id.',"level":0,"position_tree":"L","image":"0"},';
						        }

						        if(!empty($Rtree1) && !empty($right)){
						            foreach ($Rtree1 as $key => $value1) {
						                echo '{
						                    "id":'.$value1["user_id"].',"name":"'.$value1["user_name"].'","parent_id":'.$value["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                        $left1 = $this->mdl_common->boardLevelLeftChild($table,$value1['user_id']);
						                        $right1 = $this->mdl_common->boardLevelRightChild($table,$value1['user_id']);
						                        $Ltree2 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$left1."'");
						                        $Rtree2 = $this->mdl_common->allSelects("SELECT * FROM ".$table."  WHERE user_id = '".$right1."'");
						                        if(!empty($Ltree2) && !empty($left1)){
						                            foreach ($Ltree2 as $key => $value2) {
						                                echo '{
						                                    "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                                    
						                                echo ']},';
						                            }
						                        }else{
						                            echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
						                        }
						                        if(!empty($Rtree2) && !empty($right1)){
						                            foreach ($Rtree2 as $key => $value2) {
						                                echo '{
						                                    "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
						                                    
						                                echo']},';
						                            }
						                        }else{
						                            echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
						                        }
						                echo ']},';
						                
						            }                               
						        }else{
						            echo '{"id":"R'.$id.'","name":"Add User","parent_id":'.$id.',"level":0,"position_tree":"R","image":"0"},';
						        }   
						        echo ']};';
						    }
						} 			
			 		}else{
			 			$tree = $this->mdl_common->allSelects("SELECT * FROM user_master  WHERE user_id = '".$id."'");
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
			                                                
			                                            echo ']},';
			                                        }
			                                    }else{
			                                        echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
			                                    }
			                                    if(!empty($Rtree2) && !empty($right1)){
			                                        foreach ($Rtree2 as $key => $value2) {
			                                            echo '{
			                                                "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
			                                                
			                                            echo']},';
			                                        }
			                                    }else{
			                                        echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
			                                    }
			                            echo ']},';                         
			                        }                               
			                    }else{
			                        echo '{"id":"L'.$id.'","name":"Add New User","parent_id":'.$id.',"level":0,"position_tree":"L","image":"0"},';
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
			                                                
			                                            echo ']},';
			                                        }
			                                    }else{
			                                        echo '{"id":"L'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"L","image":"0"},';
			                                    }
			                                    if(!empty($Rtree2) && !empty($right1)){
			                                        foreach ($Rtree2 as $key => $value2) {
			                                            echo '{
			                                                "id":'.$value2["user_id"].',"name":"'.$value2["user_name"].'","parent_id":'.$value1["user_id"].',"level":0,"image":"avatar_default.png","children":[';
			                                                
			                                            echo']},';
			                                        }
			                                    }else{
			                                        echo '{"id":"R'.$value1["user_id"].'","name":"Add User","parent_id":'.$value1["user_id"].',"level":0,"position_tree":"R","image":"0"},';
			                                    }
			                            echo ']},';
			                            
			                        }                               
			                    }else{
			                        echo '{"id":"R'.$id.'","name":"Add User","parent_id":'.$id.',"level":0,"position_tree":"R","image":"0"},';
			                    }   
			                    echo ']};';
			                }
			            }
			 		}
			 	?>
			 	$(document).ready(function (){
					var max = 30, min = 10, dec = 5;

					var w = $(window).width()*0.7,
						h = $(window).height()*0.9,
						i = 0,
						duration = 600,
						roo;

					var tree = d3.layout.tree()
							.size([w, h]);

					var diagonal = d3.svg.diagonal()
							.projection(function(d) { return [d.x, d.y]; });

					var vis = d3.select("#chart").append("svg:svg")
							.attr("height", $(window).height())
							.attr("width", w)
							.append("svg:g")
							.attr("transform", "translate(0,40)");


					root = treeData;

					update(root);

					$(window).resize(function(){
						$("#chart").html("");
						//.size([ $(window).width()*0.7*0.9 , $(window).height()*0.7/2 - 160 ]);
						tree = d3.layout.tree()
							.size([$(window).width()*0.7*0.9, $(window).height()*0.7]);
						vis = d3.select("#chart").append("svg:svg")
							.attr("height",  $(window).height())
							.attr("width", "100%")
							.append("svg:g")
							.attr("transform", "translate(0,40)");
						update(root);
					});

					function update(source) {

						// Compute the new tree layout.
						var nodes = tree.nodes(root).reverse();
						//console.log(nodes)
						// Update the nodes…
						var node = vis.selectAll("g.node")
								.data(nodes, function(d) { return d.id || (d.id = ++i); });

						var nodeEnter = node.enter().append("svg:g")
								.attr("class", "node")
								.on("mouseover", function(d) {
									var g = d3.select(this); // The node
									// The class is used to remove the additional text later
									var info = g.append('text')

										.attr('stroke','black')

										.classed('info', true)
										.attr('x', 15)
										.attr('y', function(d){
											return  ( ( max - ( d.level * dec)) > min ) ? ( max - ( d.level * dec))/2 + 10 + "px" : "-5px";
										})
										.text(function(d) {
											return d.name;
										});
								})
								.on("mouseout", function() {
									// Remove the info text on mouse out.
									d3.select(this).select('text.info').remove();
								})
								.attr("transform", function(d) { return "translate(" + source.x0 + "," + source.y0 + ")"; })
							.style("opacity", 0);

						// Enter any new nodes at the parent's previous position.
						node.append("svg:image")
								.attr("class", "circle")
								.attr("xlink:href", function(d){
									if(d.image == 0){
										//return "/images/users/avatars/circle_avatar_default.png"
										return "../assets/images/UserAdd.png"
									}else{
										return "../assets/images/users/avatars/circle_"+ d.image
									}
								})
								.attr("preserveAspectRatio","xMidYMid slice")
								.attr("x", function(d){
									return  ( ( max - ( d.level * dec)) > min ) ?  "-" + ( max - ( d.level * dec))/2 + "px" : "-5px";
								})
								.attr("y", function(d){
									return  ( ( max - ( d.level * dec)) > min ) ?  "-" + ( max - ( d.level * dec))/2 + "px" : "-5px";
								})
								.attr("width", function(d){
									return  ( ( max - ( d.level * dec)) > min ) ? max - ( d.level * dec) + "px" : "10px";
								})
								.attr("height", function(d){
									return  ( ( max - ( d.level * dec)) > min ) ? max - ( d.level * dec) + "px" : "10px";
								})
								.on("click", click);

						/*nodeEnter.append("svg:text")
								.attr("x", function(d) { return d._children ? -15 : -15; })
								.attr("y", 20)
								.text(function(d) { return d.name; });*/

						// Transition nodes to their new position.
						nodeEnter.transition()
								.duration(duration)
								.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
								.style("opacity", 1)
								.select("circle")
								.style("fill", "lightsteelblue");

						node.transition()
								.duration(duration)
								.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
								.style("opacity", 1);


						node.exit().transition()
								.duration(duration)
								.attr("transform", function(d) { return "translate(" + source.x + "," + source.y + ")"; })
								.style("opacity", 0)
								.remove();

						// Update the links…
						var link = vis.selectAll("path.link")
								.data(tree.links(nodes), function(d) { return d.target.id; });

						// Enter any new links at the parent's previous position.
						link.enter().insert("svg:path", "g")
								.attr("class", "link")
								.attr("d", function(d) {
									var o = {x: source.x0, y: source.y0};
									return diagonal({source: o, target: o});
								})
								.transition()
								.duration(duration)
								.attr("d", diagonal);

						// Transition links to their new position.
						link.transition()
								.duration(duration)
								.attr("d", diagonal);

						// Transition exiting nodes to the parent's new position.
						link.exit().transition()
								.duration(duration)
								.attr("d", function(d) {
									var o = {x: source.x, y: source.y};
									return diagonal({source: o, target: o});
								})
								.remove();

						var maxLevel = 0;
						// Stash the old positions for transition.
						nodes.forEach(function(d) {
							d.x0 = d.x;
							d.y0 = d.y;
							maxLevel++;
						});
						//alert(maxLevel);
					}

					// Toggle children on click.
					function click(d) {

						// Contrae
						if (d.children) {
							d._children = d.children;
							d.children = null;
							// n.parent(d);
						} //Expande
						else {
							    //d.children = d._children;
								//d._children = null;
							if(d.image == 0){
				              	$('#userTreeForm .parent-id').val(d.parent_id);
				              	$('#userTreeForm .user-name').val(d.parent.name);
				              	$('#userTreeForm .user-child').val(d.position_tree);
				              	$('#userTreeForm').modal();      
				            }else{
				              	$.ajax({
					                'async': false,
					                'global': false,
					                'url': BASE_URL + "level/myLevel/" + d.id,
					                'dataType': "json",
					                'success': function (data) {
					                  	for (var i in data) {
					                    	data[i].level = d.level + 1;
					                  	}
					                  	d._children = data;
					                  	d.children = d._children;
					                  	d._children = null;
					                }
				              	});
				            }
						}
						update(d);
						/*$("svg").find("image").attr("width",  max - maxLevel*dec);
						$("svg").find("image").attr("height", max - maxLevel*dec);*/
					}

					d3.select(self.frameElement).style("height", "200px");

					//Collapse All nodes
					function toggleAll(d) {
						if (d.children) {
							d.children.forEach(toggleAll);
							toggle(d);
						}
					}

				});
			</script>
		<?php //}else{ ?>
				<script type="text/javascript">
					/*$(document).ready(function(){
						$('#chart').html('This Board is Empty...');
					});*/
				</script>
		<?php //} ?>
	</div>

	<div class="modal" id="userTreeForm">
	    <div class="modal-dialog modal-lg">
	      	<div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>         
		        </div>
		        <div class="modal-body row">
                    <div class="col-md-12">
                        <div class="panel with-nav-tabs panel-default">
                            <div class="panel-heading">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab1default" data-toggle="tab">Holding Tank</a></li>
                                        <!-- <li><a href="#tab2default" data-toggle="tab">Register New Member</a></li> -->
                                    </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1default">
                                        <form name="addHoldingForm" id="add-holding-form" method="post" action="<?php echo base_url('adminTeam/addHolding'); ?>" style="width:60%; float:none; margin:auto;">
                                            <fieldset>
                                                <legend>Add New User to  Board</legend>
                                                <input type="hidden" name="parent_id" class="parent-id">
                                                <input type="hidden" name="child_position" class="user-child">
                                                <div class="form-group">
                                                    <label></label>
                                                    <input type="text" name="user_name" class="form-control user-name" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Child User<span class="error">*</span></label>
                                                    <select name="child_id" id="child_id" class="form-control">
                                                        <option value="" selected="selected">Select User</option>
                                                        <?php if(isset($childUserDetails) && !empty($childUserDetails)){ ?>
                                                            <?php foreach ($childUserDetails as $key => $value) {
                                                                echo '<option value="'.$value['user_id'].'">'.$value['user_name'].'</option>';
                                                            } ?>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="error"><?php echo form_error('child_id');?></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab2default" style="display:none;">
                                        <form name="checkout" id="testform" method="post" enctype="multipart/form-data" class="checkout testform woocommerce-checkout" action="<?php echo base_url('register/newMemberRegistration_view_By_Tree');?>">
                                            <input type="hidden" value="" id="user-name" class="form-control user-name" name="user_name" required="true"/>
                                            <input type="hidden" name="child_position" class="user-child">
                                            <input type="hidden" value="" id="user-child" class="form-control user-child" name="user_child" required="true"/>
                                            <fieldset title="Step 1">           
                                                <legend>Personal Information</legend>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <div class="selectpicker-wrapper">
                                                            <select name="country" class="form-control">
                                                                <option value="" selected="selected">Select Country</option>
                                                                <option value="Afganistan">Afghanistan</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                                <option value="Andorra">Andorra</option>
                                                                <option value="Angola">Angola</option>
                                                                <option value="Anguilla">Anguilla</option>
                                                                <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                                                <option value="Argentina">Argentina</option>
                                                                <option value="Armenia">Armenia</option>
                                                                <option value="Aruba">Aruba</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Austria">Austria</option>
                                                                <option value="Azerbaijan">Azerbaijan</option>
                                                                <option value="Bahamas">Bahamas</option>
                                                                <option value="Bahrain">Bahrain</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Barbados">Barbados</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Belgium">Belgium</option>
                                                                <option value="Belize">Belize</option>
                                                                <option value="Benin">Benin</option>
                                                                <option value="Bermuda">Bermuda</option>
                                                                <option value="Bhutan">Bhutan</option>
                                                                <option value="Bolivia">Bolivia</option>
                                                                <option value="Bonaire">Bonaire</option>
                                                                <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                                                <option value="Botswana">Botswana</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                                <option value="Brunei">Brunei</option>
                                                                <option value="Bulgaria">Bulgaria</option>
                                                                <option value="Burkina Faso">Burkina Faso</option>
                                                                <option value="Burundi">Burundi</option>
                                                                <option value="Cambodia">Cambodia</option>
                                                                <option value="Cameroon">Cameroon</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="Canary Islands">Canary Islands</option>
                                                                <option value="Cape Verde">Cape Verde</option>
                                                                <option value="Cayman Islands">Cayman Islands</option>
                                                                <option value="Central African Republic">Central African Republic</option>
                                                                <option value="Chad">Chad</option>
                                                                <option value="Channel Islands">Channel Islands</option>
                                                                <option value="Chile">Chile</option>
                                                                <option value="China">China</option>
                                                                <option value="Christmas Island">Christmas Island</option>
                                                                <option value="Cocos Island">Cocos Island</option>
                                                                <option value="Colombia">Colombia</option>
                                                                <option value="Comoros">Comoros</option>
                                                                <option value="Congo">Congo</option>
                                                                <option value="Cook Islands">Cook Islands</option>
                                                                <option value="Costa Rica">Costa Rica</option>
                                                                <option value="Cote DIvoire">Cote D'Ivoire</option>
                                                                <option value="Croatia">Croatia</option>
                                                                <option value="Cuba">Cuba</option>
                                                                <option value="Curaco">Curacao</option>
                                                                <option value="Cyprus">Cyprus</option>
                                                                <option value="Czech Republic">Czech Republic</option>
                                                                <option value="Denmark">Denmark</option>
                                                                <option value="Djibouti">Djibouti</option>
                                                                <option value="Dominica">Dominica</option>
                                                                <option value="Dominican Republic">Dominican Republic</option>
                                                                <option value="East Timor">East Timor</option>
                                                                <option value="Ecuador">Ecuador</option>
                                                                <option value="Egypt">Egypt</option>
                                                                <option value="El Salvador">El Salvador</option>
                                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                                <option value="Eritrea">Eritrea</option>
                                                                <option value="Estonia">Estonia</option>
                                                                <option value="Ethiopia">Ethiopia</option>
                                                                <option value="Falkland Islands">Falkland Islands</option>
                                                                <option value="Faroe Islands">Faroe Islands</option>
                                                                <option value="Fiji">Fiji</option>
                                                                <option value="Finland">Finland</option>
                                                                <option value="France">France</option>
                                                                <option value="French Guiana">French Guiana</option>
                                                                <option value="French Polynesia">French Polynesia</option>
                                                                <option value="French Southern Ter">French Southern Ter</option>
                                                                <option value="Gabon">Gabon</option>
                                                                <option value="Gambia">Gambia</option>
                                                                <option value="Georgia">Georgia</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="Ghana">Ghana</option>
                                                                <option value="Gibraltar">Gibraltar</option>
                                                                <option value="Great Britain">Great Britain</option>
                                                                <option value="Greece">Greece</option>
                                                                <option value="Greenland">Greenland</option>
                                                                <option value="Grenada">Grenada</option>
                                                                <option value="Guadeloupe">Guadeloupe</option>
                                                                <option value="Guam">Guam</option>
                                                                <option value="Guatemala">Guatemala</option>
                                                                <option value="Guinea">Guinea</option>
                                                                <option value="Guyana">Guyana</option>
                                                                <option value="Haiti">Haiti</option>
                                                                <option value="Hawaii">Hawaii</option>
                                                                <option value="Honduras">Honduras</option>
                                                                <option value="Hong Kong">Hong Kong</option>
                                                                <option value="Hungary">Hungary</option>
                                                                <option value="Iceland">Iceland</option>
                                                                <option value="India">India</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Iran">Iran</option>
                                                                <option value="Iraq">Iraq</option>
                                                                <option value="Ireland">Ireland</option>
                                                                <option value="Isle of Man">Isle of Man</option>
                                                                <option value="Israel">Israel</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Jamaica">Jamaica</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Jordan">Jordan</option>
                                                                <option value="Kazakhstan">Kazakhstan</option>
                                                                <option value="Kenya">Kenya</option>
                                                                <option value="Kiribati">Kiribati</option>
                                                                <option value="Korea North">Korea North</option>
                                                                <option value="Korea Sout">Korea South</option>
                                                                <option value="Kuwait">Kuwait</option>
                                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                <option value="Laos">Laos</option>
                                                                <option value="Latvia">Latvia</option>
                                                                <option value="Lebanon">Lebanon</option>
                                                                <option value="Lesotho">Lesotho</option>
                                                                <option value="Liberia">Liberia</option>
                                                                <option value="Libya">Libya</option>
                                                                <option value="Liechtenstein">Liechtenstein</option>
                                                                <option value="Lithuania">Lithuania</option>
                                                                <option value="Luxembourg">Luxembourg</option>
                                                                <option value="Macau">Macau</option>
                                                                <option value="Macedonia">Macedonia</option>
                                                                <option value="Madagascar">Madagascar</option>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="Malawi">Malawi</option>
                                                                <option value="Maldives">Maldives</option>
                                                                <option value="Mali">Mali</option>
                                                                <option value="Malta">Malta</option>
                                                                <option value="Marshall Islands">Marshall Islands</option>
                                                                <option value="Martinique">Martinique</option>
                                                                <option value="Mauritania">Mauritania</option>
                                                                <option value="Mauritius">Mauritius</option>
                                                                <option value="Mayotte">Mayotte</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Midway Islands">Midway Islands</option>
                                                                <option value="Moldova">Moldova</option>
                                                                <option value="Monaco">Monaco</option>
                                                                <option value="Mongolia">Mongolia</option>
                                                                <option value="Montserrat">Montserrat</option>
                                                                <option value="Morocco">Morocco</option>
                                                                <option value="Mozambique">Mozambique</option>
                                                                <option value="Myanmar">Myanmar</option>
                                                                <option value="Nambia">Nambia</option>
                                                                <option value="Nauru">Nauru</option>
                                                                <option value="Nepal">Nepal</option>
                                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                                <option value="Nevis">Nevis</option>
                                                                <option value="New Caledonia">New Caledonia</option>
                                                                <option value="New Zealand">New Zealand</option>
                                                                <option value="Nicaragua">Nicaragua</option>
                                                                <option value="Niger">Niger</option>
                                                                <option value="Nigeria">Nigeria</option>
                                                                <option value="Niue">Niue</option>
                                                                <option value="Norfolk Island">Norfolk Island</option>
                                                                <option value="Norway">Norway</option>
                                                                <option value="Oman">Oman</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="Palau Island">Palau Island</option>
                                                                <option value="Palestine">Palestine</option>
                                                                <option value="Panama">Panama</option>
                                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                                <option value="Paraguay">Paraguay</option>
                                                                <option value="Peru">Peru</option>
                                                                <option value="Phillipines">Philippines</option>
                                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                                <option value="Poland">Poland</option>
                                                                <option value="Portugal">Portugal</option>
                                                                <option value="Puerto Rico">Puerto Rico</option>
                                                                <option value="Qatar">Qatar</option>
                                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                                <option value="Reunion">Reunion</option>
                                                                <option value="Romania">Romania</option>
                                                                <option value="Russia">Russia</option>
                                                                <option value="Rwanda">Rwanda</option>
                                                                <option value="St Barthelemy">St Barthelemy</option>
                                                                <option value="St Eustatius">St Eustatius</option>
                                                                <option value="St Helena">St Helena</option>
                                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                                <option value="St Lucia">St Lucia</option>
                                                                <option value="St Maarten">St Maarten</option>
                                                                <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                                                <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                                                <option value="Saipan">Saipan</option>
                                                                <option value="Samoa">Samoa</option>
                                                                <option value="Samoa American">Samoa American</option>
                                                                <option value="San Marino">San Marino</option>
                                                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                <option value="Senegal">Senegal</option>
                                                                <option value="Serbia">Serbia</option>
                                                                <option value="Seychelles">Seychelles</option>
                                                                <option value="Sierra Leone">Sierra Leone</option>
                                                                <option value="Singapore">Singapore</option>
                                                                <option value="Slovakia">Slovakia</option>
                                                                <option value="Slovenia">Slovenia</option>
                                                                <option value="Solomon Islands">Solomon Islands</option>
                                                                <option value="Somalia">Somalia</option>
                                                                <option value="South Africa">South Africa</option>
                                                                <option value="Spain">Spain</option>
                                                                <option value="Sri Lanka">Sri Lanka</option>
                                                                <option value="Sudan">Sudan</option>
                                                                <option value="Suriname">Suriname</option>
                                                                <option value="Swaziland">Swaziland</option>
                                                                <option value="Sweden">Sweden</option>
                                                                <option value="Switzerland">Switzerland</option>
                                                                <option value="Syria">Syria</option>
                                                                <option value="Tahiti">Tahiti</option>
                                                                <option value="Taiwan">Taiwan</option>
                                                                <option value="Tajikistan">Tajikistan</option>
                                                                <option value="Tanzania">Tanzania</option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Togo">Togo</option>
                                                                <option value="Tokelau">Tokelau</option>
                                                                <option value="Tonga">Tonga</option>
                                                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                                <option value="Tunisia">Tunisia</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="Turkmenistan">Turkmenistan</option>
                                                                <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                                                <option value="Tuvalu">Tuvalu</option>
                                                                <option value="Uganda">Uganda</option>
                                                                <option value="Ukraine">Ukraine</option>
                                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States of America">United States of America</option>
                                                                <option value="Uraguay">Uruguay</option>
                                                                <option value="Uzbekistan">Uzbekistan</option>
                                                                <option value="Vanuatu">Vanuatu</option>
                                                                <option value="Vatican City State">Vatican City State</option>
                                                                <option value="Venezuela">Venezuela</option>
                                                                <option value="Vietnam">Vietnam</option>
                                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                                <option value="Wake Island">Wake Island</option>
                                                                <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                                                <option value="Yemen">Yemen</option>
                                                                <option value="Zaire">Zaire</option>
                                                                <option value="Zambia">Zambia</option>
                                                                <option value="Zimbabwe">Zimbabwe</option>
                                                            </select>
                                                            <span class="error pull-right"><?php echo form_error('country'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="first_name">First Name</label>
                                                        <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo set_value('first_name');?>">
                                                        <span class="error pull-right"><?php echo form_error('first_name'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="middle_name">Middle Name</label>
                                                        <input type="text" name="middle_name" class="form-control" id="middle_name" value="<?php echo set_value('middle_name');?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="last_name">Last Name</label>
                                                        <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo set_value('last_name');?>">
                                                        <span class="error pull-right"><?php echo form_error('last_name'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="user_email">Email</label>
                                                        <input type="email" name="user_email" class="form-control" id="user_email" value="<?php echo set_value('user_email');?>">
                                                        <span class="error pull-right"><?php echo form_error('user_email'); ?></span>
                                                    </div>
                                                </div>   
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="user-dob">Birth Date</label>
                                                        <input type="text" name="dob" class="form-control" id="datepicker" value="<?php echo set_value('dob');?>">
                                                        <span class="error pull-right"><?php echo form_error('user_email'); ?></span>
                                                    </div>
                                                </div>                            
                                            </fieldset>  
                                            <fieldset title="Step 2">
                                                <legend>Choose User Name</legend>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="sponser">Sponsor</label>
                                                        <select name="sponser" id="sponser" class="form-control">
                                                            <?php 
                                                                $query = "SELECT * FROM user_master";
                                                                $result = $this->db->query($query);
                                                                $sponserList = $result->result_array();
                                                                foreach ($sponserList as $key => $value) {
                                                                    echo "<option value='".$value['user_name']."' ".set_select('user_name', $value['user_name']).">".$value['user_name']."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                        <span class="error pull-right"><?php echo form_error('sponser'); ?></span>
                                                        <div id="error-message" ></div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="parent_id" class="form-control parent-id" id="parent-id" value="" readonly/>
                                                        <span class="error pull-right"><?php echo form_error('parent'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="user_name">User Name</label>
                                                        <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo set_value('user_name');?>">
                                                        <span class="error pull-right"><?php echo form_error('user_name'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="user_password">Password</label>
                                                        <input type="password" name="user_password" class="form-control" id="user_password" value="<?php echo set_value('user_password');?>">
                                                        <span class="error pull-right"><?php echo form_error('user_password'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="cpassword">Confirm  Password</label>
                                                        <input type="password" name="cpassword" class="form-control" id="cpassword" value="<?php echo set_value('cpassword');?>">
                                                        <span class="error pull-right"><?php echo form_error('cpassword'); ?></span>
                                                    </div>
                                                </div>
                                            </fieldset>  
                                            <fieldset title="Step 3">
                                                <legend>Contact Information</legend>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="address1">Address</label>
                                                        <input type="text" name="address1" class="form-control" id="address1" value="<?php echo set_value('address1');?>">
                                                        <br/><input type="text" name="address2" class="form-control" id="address2" value="<?php echo set_value('address1');?>">
                                                        <span class="error pull-right"><?php echo form_error('address1'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="contact_no">Contact No.</label>
                                                        <input type="text" name="contact_no" class="form-control" id="contact_no" value="<?php echo set_value('contact_no');?>">
                                                        <span class="error pull-right"><?php echo form_error('contact_no'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="city">City</label>
                                                        <input type="text" name="city" class="form-control" id="city" value="<?php echo set_value('city');?>">
                                                        <span class="error pull-right"><?php echo form_error('city'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="state">State</label>
                                                        <input type="text" name="state" class="form-control" id="state" value="<?php echo set_value('state');?>">
                                                        <span class="error pull-right"><?php echo form_error('state'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="zip">Zip</label>
                                                        <input type="zip" name="zip" class="form-control" id="zip" value="<?php echo set_value('zip');?>">
                                                        <span class="error pull-right"><?php echo form_error('zip'); ?></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset title="Step 3">
                                                <legend>Payment Information</legend>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="package">Select Package</label>
                                                        <select name="package" class="form-control">
                                                            <?php 
                                                                $query = "SELECT * FROM package_info";
                                                                $result = $this->db->query($query);
                                                                $package = $result->result_array();
                                                                foreach ($package as $key => $value) {
                                                                    echo "<option value='".$value['package_id']."' ".set_select('package_id', $value['package_id']).">".$value['package_name']."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                        <!-- <input type="text" name="package" class="form-control" id="package" value="<?php echo set_value('package');?>"> -->
                                                        <span class="error pull-right"><?php echo form_error('package'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Select Voucher</label>
                                                        <input type="text" name="voucher_code" class="form-control" value="<?php echo set_value('voucher_code'); ?>" id="voucher-code" />
                                                        <span class="error"><?php echo form_error('voucher_code'); ?></span>
                                                    </div>
                                                </div>

                                               <!--  <div id="card-information">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Name on card<span class="error">*</span></label>
                                                            <input type="text" class="form-control" name="name_on_card" value="<?php echo set_value('name_on_card');?>"/>
                                                            <span class="error"><?php echo form_error('name_on_card');?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Card No<span class="error">*</span></label>
                                                            <input type="text" class="form-control" name="card_no" value="<?php echo set_value('card_no');?>"/>
                                                            <span class="error"><?php echo form_error('card_no');?></span>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="col-md-12">
                                                    <p class="form-row form-row form-row-first address-field validate-required validate-state" id="billing_state_field">
                                                        <label for="expiry_month" class="">Month<abbr class="required" title="required">*</abbr></label>
                                                        <select name="expiry_month" id="expiry_month">
                                                               <?php
                                                                    for($i=1;$i<=12;$i++){
                                                                        $expiry_month = date('m');
                                                                        $selected   =   '';
                                                                        if($expiry_month == $i)
                                                                            $selected   =   'selected="selected"';
                                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                    }
                                                                ?>
                                                              </select>
                                                        </select>
                                                    </p>
                                                    <p class="form-row form-row form-row-first address-field validate-required validate-state" id="billing_state_field">
                                                        <label for="expiry_year" class="">Year<abbr class="required" title="required">*</abbr></label>
                                                        <select name="expiry_year" id="expiry_year">
                                                            <?php
                                                                    $cur_year   =   date('Y');
                                                                    $end_year   =   date('Y')+50;
                                                                    $expiry_year = date('Y');
                                                                    for($i=$cur_year;$i<=$end_year;$i++){
                                                                        $selected   =   '';
                                                                        if($expiry_year == $i)
                                                                            $selected   =   'selected="selected"';
                                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                    }
                                                                ?>
                                                        </select>
                                                    </p>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row col-sm-12">
                                                                <label style="float:left;">Expiry Date<span class="error">*</span></label>
                                                            </div>
                                                            <div class="row col-sm-12">
                                                             <select name="expiry_month" id="expiry_month" class="select-form-control">
                                                                <?php
                                                                    for($i=1;$i<=12;$i++){
                                                                        $selected   =   '';
                                                                        if($expiry_month == $i)
                                                                            $selected   =   'selected="selected"';
                                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                    }
                                                                ?>
                                                              </select>
                                                              &nbsp;&nbsp;
                                                              <select name="expiry_year" id="expiry_year" class="select-form-control">
                                                                <?php
                                                                    $cur_year   =   date('Y');
                                                                    $end_year   =   date('Y')+50;
                                                                    for($i=$cur_year;$i<=$end_year;$i++){
                                                                        $selected   =   '';
                                                                        if($expiry_year == $i)
                                                                            $selected   =   'selected="selected"';
                                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                    }
                                                                ?>
                                                              </select>   
                                                            </div>        
                                                            <span class="error"><?php echo form_error('expiry_year');?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>CVV No<span class="error">*</span></label>
                                                            <input type="text" class="form-control" name="cvv_no" value="<?php echo set_value('cvv_no');?>"/>
                                                            <span class="error"><?php echo form_error('cvv_no');?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Billing Zip<span class="error">*</span></label>
                                                            <input type="text" class="form-control" name="billing_zip" value="<?php echo set_value('billing_zip');?>"/>
                                                            <span class="error"><?php echo form_error('billing_zip');?></span>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </fieldset>  
                                            <div class="clear"></div>
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
		        </div>
		        <div class="modal-footer">         
		        </div>
	      	</div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script type="text/javascript" src="<?php echo base_url();?>assets/wizard/simpleform.min.js"></script>
	<script type="text/javascript">
        $( document ).ready( function () {

            $("#add-holding-form").ajaxForm(function(msg) {
                if(msg.succes != null){
                    location.reload();
                }else{
                    //alert(msg.err);                    
                }
            });
            $( "#add-holding-form" ).validate( {
                rules: {
                    child_id: {
                        required: true
                    },                   
                },
            } );
        } );
    </script>
	<script type="text/javascript">

		$(".testform").simpleform({
			speed : 500,
			transition : 'fade',
			//validate: false,
			progressBar : true,
			showProgressText : true,
			validate: true
		});

		function validateForm(formID, Obj){

			switch(formID){
				case 'testform' :
					Obj.validate({
						rules: {
							country: {
								required: true
							},
							first_name: {
								required: true
							},
							last_name: {
								required: true
							},
							dob: {
								required: true
							},
							user_email: {
								required: true,
								remote: {
                                    url: '<?php echo base_url();?>'+"register/checkEmailExists",
                                    type: "post",
                                    data: {
                                      user_email: function() {
                                        return $("#user_email").val();
                                      }
                                    }
                                },
                                email: true
							},
							sponsor: {
								required: true,
								remote: {
                                    url: '<?php echo base_url();?>'+"register/checkSponsorExists",
                                    type: "post",
                                    data: {
                                      sponsor: function() {
                                        return $( "#sponsor" ).val();
                                      }
                                    }
                                }
							},
							user_name: {
								minlength: 3, 
                                required: true,
                                remote: {
                                    url: '<?php echo base_url();?>'+"register/checkUserExists",
                                    type: "post",
                                    data: {
                                      user_name: function() {
                                        return $( "#user_name" ).val();
                                      }
                                    }
                                }
							},
							user_password: {
								minlength: 2, 
								required: true
							},
							cpassword: {
								minlength: 2, 
								required: true,
								equalTo: "#user_password"
							},
							contact_no: {
								required: true
							},
							address1: {
								required: true
							},
							city: {
								required: true
							},
							state: {
								required: true
							},
							zip: {
								required: true
							},
							voucher_code: {
							required: true,
							remote: {
                                     url: '<?php echo base_url();?>'+"register/checkVoucherExists",
                                     type: "post",
                                     data: {
                                       voucher_code: function() {
                                         return $( "#voucher-code" ).val();
                                       }
                                     }
                                 }
							},

							/*name_on_card: {
								required: true
							},
							card_no: {
								required: true
							},
							expiry_month: {
								required: true
							},
							expiry_year: {
								required: true
							},
							cvv_no: {
								required: true
							},
							billing_zip: {
								required: true
							}*/
						},
						messages: {
							country: "Please select Country",
							first_name: "This field is required",
							last_name: "This field is required",
							user_email: {
								required: "Please enter an email address",
								email: "Not a valid email address",
								remote: "This Email allready exits!"
							},
							sponsor: {
							 	required: "Please enter your sponsor",
							 	remote: "This is an invalid sponsor!"
							},
							user_name: {
							 	required: "Please enter your user name",
							 	remote: "This User allready exits!"
							},
							cpassword:{
								equalTo: "Password does not match!"
							},
							voucher_code: {
								remote: "Your Voucher code is invalid!"
							}
						}

					});
				return Obj.valid();
				break;
			}
		}
	</script>