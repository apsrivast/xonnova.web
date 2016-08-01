<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Onlegacy Network</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Onlegacy Network">
	<meta name="author" content="Onlegacy Network">

	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/favicon.png">

	<!-- prochtml:remove:dist -->
	<link href="<?php echo base_url();?>assets/less/styles.less" rel="stylesheet/less" media="all"> 
	<!-- /prochtml -->

	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>     

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
	<!-- bower:css 
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-xeditable/dist/css/xeditable.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/fullcalendar/fullcalendar.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap-datepaginator/dist/bootstrap-datepaginator.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-meditor/dist/meditor.min.css" />
	
	-->
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/font-awesome/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/seiyria-bootstrap-slider/dist/css/bootstrap-slider.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/angular-ui-tree/dist/angular-ui-tree.min.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>/bower_components/ng-grid/ng-grid.css" />
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
	
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.date.css"/>

	<!-- build:css({.tmp,app}) assets/css/main.css -->
	  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/styles.css"/>
	  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/angular-pickadate.css"/>
	<!-- endbuild -->
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-custom-width.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-default.css"/>
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-plain.css"/>

	<!-- prochtml:remove:dist -->
	<script type="text/javascript">less = { env: 'development'};</script>
	<script type="text/javascript" src="<?php echo base_url();?>/assets/plugins/misc/less.js"></script>
	<!-- /prochtml -->
	<script>
		var BASE_URL = "<?php echo base_url(); ?>";
		var login_STATUS = "<?php echo $this->session->userdata('login_status'); ?>";
		// console.log(BASE_URL+" "+CUR_USER_STATUS);
		var E_SIGN_STATUS = "<?php echo  $this->session->userdata('e_sign_status');?>";
		
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

<div ng-include="'application/views/admin/views/templates/custom-styles.html'"></div>

<ng-include src="'application/views/admin/views/layout/header.html'"></ng-include>