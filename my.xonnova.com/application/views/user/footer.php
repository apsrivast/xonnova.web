<!--[if lt IE 9]>
	<script src="bower_components/es5-shim/es5-shim.js"></script>
	<script src="bower_components/json3/lib/json3.min.js"></script>
	<![endif]-->

	<script type='text/javascript' src='https://maps.google.com/maps/api/js?sensor=true'></script> 
	<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
	<!-- build:js userScripts/vendor.js -->
	<!-- bower:js -->
	<script src="<?php echo base_url();?>/bower_components/modernizr/modernizr.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery/dist/jquery.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.percentageloader-0.1.js"></script>
	<script src="<?php echo base_url();?>/bower_components/underscore/underscore.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular/angular.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-resource/angular-resource.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-cookies/angular-cookies.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-sanitize/angular-sanitize.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-route/angular-route.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-animate/angular-animate.js"></script>
	<script src="<?php echo base_url();?>/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>/bower_components/seiyria-bootstrap-slider/js/bootstrap-slider.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-bootstrap/ui-bootstrap-tpls.js"></script>
	<!--<script src="<?php echo base_url();?>/bower_components/angular-bootstrap/ui-bootstrap1-tpls.js"></script>-->
	<script src="<?php echo base_url();?>/bower_components/jquery.ui/ui/jquery.ui.core.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.ui/ui/jquery.ui.widget.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.ui/ui/jquery.ui.mouse.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.ui/ui/jquery.ui.draggable.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.ui/ui/jquery.ui.resizable.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.easing/js/jquery.easing.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flot/jquery.flot.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flot/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flot/jquery.flot.pie.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flot/jquery.flot.resize.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flot.tooltip/js/jquery.flot.tooltip.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-ui-tree/dist/angular-ui-tree.js"></script>
	<script src="<?php echo base_url();?>/bower_components/moment/moment.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jqvmap/jqvmap/jquery.vmap.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
	<script src="<?php echo base_url();?>/bower_components/ng-grid/build/ng-grid.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-xeditable/dist/js/xeditable.js"></script>
	<script src="<?php echo base_url();?>/bower_components/iCheck/icheck.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/google-code-prettify/src/prettify.js"></script>
	<script src="<?php echo base_url();?>/bower_components/bootbox.js/bootbox.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery-autosize/jquery.autosize.js"></script>
	<script src="<?php echo base_url();?>/bower_components/gmaps/gmaps.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.pulsate/jquery.pulsate.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.knob/js/jquery.knob.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.sparkline/index.js"></script>
	<script src="<?php echo base_url();?>/bower_components/flow.js/dist/flow.js"></script>
	<script src="<?php echo base_url();?>/bower_components/ng-flow/dist/ng-flow.js"></script>
	<script src="<?php echo base_url();?>/bower_components/enquire/dist/enquire.js"></script>
	<script src="<?php echo base_url();?>/bower_components/shufflejs/dist/jquery.shuffle.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.core.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.buttons.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.callbacks.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.confirm.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.desktop.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.history.js"></script>
	<script src="<?php echo base_url();?>/bower_components/pnotify/pnotify.nonblock.js"></script>
	<script src="<?php echo base_url();?>/bower_components/nanoscroller/bin/javascripts/jquery.nanoscroller.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-nanoscroller/scrollable.js"></script>
	<script src="<?php echo base_url();?>/bower_components/rangy/rangy-core.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/rangy/rangy-cssclassapplier.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/rangy/rangy-selectionsaverestore.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/rangy/rangy-serializer.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/textAngular/src/textAngular.js"></script>
	<script src="<?php echo base_url();?>/bower_components/textAngular/src/textAngular-sanitize.js"></script>
	<script src="<?php echo base_url();?>/bower_components/textAngular/src/textAngularSetup.js"></script>
	<script src="<?php echo base_url();?>/bower_components/rangy/rangy-selectionsaverestore.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-ui-grid/ui-grid.js"></script>
	<script src="<?php echo base_url();?>/bower_components/transitionize/dist/transitionize.js"></script>
	<script src="<?php echo base_url();?>/bower_components/fastclick/lib/fastclick.js"></script>
	<script src="<?php echo base_url();?>/bower_components/switchery/dist/switchery.js"></script>
	<script src="<?php echo base_url();?>/bower_components/ng-switchery/src/ng-switchery.js"></script>
	<script src="<?php echo base_url();?>/bower_components/ng-sortable/dist/ng-sortable.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-meditor/dist/meditor.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-ui-select/dist/select.js"></script>
	<script src="<?php echo base_url();?>/bower_components/skycons/skycons.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-skycons/angular-skycons.js"></script>
	<script src="<?php echo base_url();?>/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo base_url();?>/bower_components/d3/d3.js"></script>
	<script src="<?php echo base_url();?>/bower_components/nvd3/nv.d3.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angularjs-nvd3-directives/dist/angularjs-nvd3-directives.js"></script>
	<script src="<?php echo base_url();?>/bower_components/oclazyload/dist/ocLazyLoad.min.js"></script>
	<script src="<?php echo base_url();?>/bower_components/skylo/vendor/scripts/skylo.js"></script>
	<script src="<?php echo base_url();?>/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>/bower_components/jquery.easy-pie-chart/dist/angular.easypiechart.js"></script>
	<script src="<?php echo base_url();?>/bower_components/bootstrap-datepaginator/dist/bootstrap-datepaginator.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>/assets/js/angular-pickadate.min.js"></script>
	<script src="<?php echo base_url();?>bower_components/morrisChart/raphael-min.js"></script>
	<script src="<?php echo base_url();?>bower_components/morrisChart/morris.min.js"></script>
	<!-- endbower -->

	<script type='text/javascript' src='<?php echo base_url();?>/assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/plugins/form-fseditor/jquery.fseditor-min.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/plugins/form-jasnyupload/fileinput.min.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/plugins/flot/jquery.flot.spline.js'></script> 
	
	<!-- endbuild -->

	  <!-- build:js({.tmp,app}) userScripts/userScripts.js -->
	<script src="<?php echo base_url();?>/userScripts/core/controllers/mainController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/controllers/messagesController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/controllers/navigationController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/controllers/notificationsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/directives/directives.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/directives/form.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/directives/ui.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/modules/templateOverrides.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/modules/templates.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/modules/panels/ngDraggable.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/modules/panels/panels.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/modules/panels/directives.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/services/services.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/services/theme.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/theme.js"></script>
	<script src="<?php echo base_url();?>/userScripts/calendar/calendar.js"></script>
	<script src="<?php echo base_url();?>/userScripts/chart/canvas.js"></script>
	<script src="<?php echo base_url();?>/userScripts/chart/flot.js"></script>
	<script src="<?php echo base_url();?>/userScripts/chart/morris.js"></script>
	<script src="<?php echo base_url();?>/userScripts/chart/sparklines.js"></script>
	<script src="<?php echo base_url();?>/userScripts/gallery/gallery.js"></script>
	<script src="<?php echo base_url();?>/userScripts/map/googleMaps.js"></script>
	<script src="<?php echo base_url();?>/userScripts/map/vectorMaps.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/basicTables.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/boxedLayout.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/calendar.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/canvasCharts.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/nvd3Charts.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/chatBox.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/editableTable.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/flotCharts.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/form.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/angularFormValidationController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/datepickerDemoController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/dateRangePickerDemoController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/formComponentsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/imageCropController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/inlineEditableController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/form/controllers/timepickerDemoController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/referrals/referrals.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/custom/customApp.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/gallery.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/googleMaps.js"></script>
	<script src="<?php echo base_url();?>/scripts/demos/modules/custom/customDirective.js"></script>
	<script src="<?php echo base_url();?>/scripts/demos/modules/custom/customController.js"></script>
	<script src="<?php echo base_url();?>/scripts/demos/modules/custom/customUrlPath.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/horizontalLayout.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/mail/controllers/composeController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/mail/controllers/inboxController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/mail/mail.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/morrisCharts.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/sparklineCharts.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ngGrid.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/panels.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/registrationPage.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/signupPage.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/notFoundController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/errorPageController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/tasks.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/uiComponents.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/alertsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/carouselController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/modalsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/nestableController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/paginationsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/progressbarsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/ratingsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/slidersController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/tabsController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/ui-components/controllers/tilesController.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/vectorMaps.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/modules/dashboard.js"></script>
	<script src="<?php echo base_url();?>/userScripts/demos/demos.js"></script>
	<script src="<?php echo base_url();?>/userScripts/core/angular-file-upload.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>/scripts/core/ng-file-upload.min.js"></script>
	<script src="<?php echo base_url();?>/scripts/core/ng-file-upload-shim.min.js"></script>
	
	<script type='text/javascript' src='<?php echo base_url();?>/assets/css/picker.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/css/picker.date.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/css/legacy.js'></script> 
	<script type='text/javascript' src='<?php echo base_url();?>/assets/js/ngDialog.js'></script>
	<script src="https://www.youtube.com/iframe_api"></script>
	<script type='text/javascript' src='<?php echo base_url();?>/assets/js/angular-youtube-embed.js'></script> 
	<script src="https://cdn.rawgit.com/szimek/signature_pad/master/signature_pad.js"></script>
  	<script src="https://cdn.rawgit.com/ecentinela/ng-signature-pad/master/dist/ng-signature-pad.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/source/jquery.fancybox.js?v=2.1.5"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script src="<?php echo base_url();?>/userScripts/app.js"></script>
	<script src="<?php echo base_url();?>/js/customModule.js"></script>

	<div class="modal fade" id="chequeModel" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				  <h4 class="modal-title">Your Account is under temporary hold. Kindly contact info@xonnova.com to reactivate your account. <a href="<?php echo base_url('signing/logout');?>">Click here to Logout</a> </h4>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		if(CHEQUE_STATUS == 'yes'){
			$('#chequeModel').modal();
		}else{
		}
	</script>



	<!-- endbuild -->
	<div class="modal fade" id="subscriptionModel" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
				   
				</div>
				<div class="modal-body" ng-controller="activateUserSubscriptionCtr">
				  	<div class="row">
				  		<!-- <img src="assets/img/Update-Card.jpg" style="width:100%"> -->
				  	</div>
				  	<div class="row">
					  	<div class="col-sm-12"><br/>
							<form class="form-horizontal row-border" enctype="multipart/form-data" name="activateSubscriptionForm" ng-repeat="user in userDATA">
								<div class="form-group">
									<label for="fieldname" class="col-md-3 control-label">User Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="user_name" ng-model="user.user_name" ng-activeuser="user_master.user_name" placeholder="Enter User Name" readonly/>
										<div ng-show="activateSubscriptionForm.user_name.$touched">
											<span style="color:#B4270F" ng-show="activateSubscriptionForm.user_name.$error.activeuser">This user Subscription Already Active!</span>
										</div>
									</div>
								</div>                
								<div class="form-group">
									<label for="fieldpass" class="col-md-3 control-label">Name on Card</label>
									<div class="col-md-6"><input id="name-on-card" class="form-control"  type="text" ng-model="user.name_on_card" placeholder= "Enter name on card" required></div>
								</div>
								<div class="form-group">
									<label for="fieldpass" class="col-md-3 control-label">Card No.</label>
									<div class="col-md-6"><input id="card-no" class="form-control"  type="text" ng-model="user.card_no" ng-pattern="/[0-9]/" placeholder= "Enter card no." required></div>
								</div>
								<div class="form-group">
									<label for="fieldpass" class="col-md-3 control-label">Expiry Date</label>
									<div class="col-md-6">
										<select ng-model="user.expiry_month" style="padding: 5px; border-color:none;" required>
											<option value="">mm</option>
											<option value="01">01</option>
											<option value="02">02</option>
											<option value="03">03</option>
											<option value="04">04</option>
											<option value="05">05</option>
											<option value="06">06</option>
											<option value="07">07</option>
											<option value="08">08</option>
											<option value="09">09</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
										
										<select ng-model="user.expiry_year" style="padding: 5px; border-color:none;" required>
											<option value="">yyyy</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
											<option value="2025">2025</option>
											<option value="2026">2026</option>
											<option value="2027">2027</option>
											<option value="2028">2028</option>
											<option value="2029">2029</option>
											<option value="2030">2030</option>
											<option value="2031">2031</option>
											<option value="2032">2032</option>
											<option value="2033">2033</option>
											<option value="2034">2034</option>
											<option value="2035">2035</option>
											<option value="2036">2036</option>
											<option value="2037">2037</option>
											<option value="2038">2038</option>
											<option value="2039">2039</option>
											<option value="2040">2040</option>
											<option value="2041">2041</option>
											<option value="2042">2042</option>
											<option value="2043">2043</option>
											<option value="2044">2044</option>
											<option value="2045">2045</option>
											<option value="2046">2046</option>
											<option value="2047">2047</option>
											<option value="2048">2048</option>
											<option value="2049">2049</option>
											<option value="2050">2050</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="fieldpass" class="col-md-3 control-label">CVV No.</label>
									<div class="col-md-6"><input id="cvv-no" class="form-control"  type="text" ng-model="user.cvv_no" placeholder="Enter CVV No." ng-pattern="/[0-9]/" required></div>
								</div>
								<div class="form-group">
									<label for="fieldpass" class="col-md-3 control-label">Billing ZIP</label>
									<div class="col-md-6"><input id="billing_zip" class="form-control"  type="text"ng-model="user.billing_zip" placeholder= "Enter Billing ZIP Code" ng-pattern="/[0-9]/" minlength="2" required></div>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<div class="btn-toolbar" align="center">
												<a class="btn btn-primary" href="<?php echo base_url('signing/logout');?>">Click here to Logout</a>
												<button type="submit" class="btn-primary btn" ng-disabled=" activateSubscriptionForm.$invalid" ng-click="activateSubscription(user);">submit</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>			  		
				  	</div>	
				</div>
				<div class="modal-footer">
					<div class="col-sm-12" align="center">
					  <!-- <button type="button" class="btn btn-default" id="reload-current-page" data-dismiss="modal">Close</button>        -->
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script type="text/javascript">
		if(CUR_USER_STATUS == 'inactive'){
			$('#subscriptionModel').modal();
			//alert(CUR_USER_STATUS);
		}else{
			//$('#subscriptionModel').modal();
		}
	</script>
	
	
	

<div class="modal fade bs-example-modal-sm"  id="wsloader" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="margin-top:100px; background-color: unset;">
      <div class="modal-dialog modal-sm">
            <div class="modal-content" style="background-color: transparent; box-shadow: 0px 0px 0px 0px rgb(255, 255, 255); border: medium none; border-radius: 0px;" align="center">
                  <img src="assets/img/loader.gif" style="width:100px !important;"/>
            </div>
      </div>
</div>
			
</body>
</html>
