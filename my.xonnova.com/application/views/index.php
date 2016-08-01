<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Xonnova</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Xonnova">
	<meta name="author" content="Xonnova">
   <meta property="og:title"         content="Xonnova" />
    <meta property="og:description"   content="Xonnova" />
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/images/isologo.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
   <!--  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css"> -->
      <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/animate.css/animate.css" />


      





    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/login/main.css">
    <style type="text/css">
    .error{
      color: red;
    }
    .img-square{
      width: 100%;
      padding: 5px;
    }
    </style>

  <!-- User css -->
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'> 
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>     
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
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/nvd3/src/nv.d3.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/skylo/vendor/styles/skylo.css" />
  <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/fonts/glyphicons/css/glyphicons.min.css' /> 
  <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/plugins/form-fseditor/fseditor.css' /> 
  <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>/assets/plugins/jcrop/css/jquery.Jcrop.min.css' /> 
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/default.date.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/styles.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/angular-pickadate.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-custom-width.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-default.css"/>
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ngDialog-theme-plain.css"/>
  <script type="text/javascript" src="<?php echo base_url();?>/assets/plugins/misc/less.js"></script>
  <!-- User css -->


  </head>
  <body class="login">
    <div class="form-signin">
      <div class="text-center">
         <img class="img-square" src="<?php echo base_url(); ?>/assets/images/logo.png" alt="Logo" style="width: 65%;"> 
		<!-- <h1 style="  color: rgb(136, 136, 136);">Xonnova</h1> -->
      </div>
      <hr>
      <div class="tab-content">
        <div id="login" class="tab-pane <?php if(isset($lacitve) && !empty($lacitve)){ echo $lacitve;}?>">
          <form method="post" action="<?php echo base_url('signing/login');?>">
           
            <div class="form-group">
                <input type="text" name="user_name" placeholder="Username" class="form-control top" value="<?php echo set_value('user_name');?>">
                <span class="error"><?php echo form_error('user_name'); ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="user_password" placeholder="Password" class="form-control bottom" value="<?php echo set_value('user_password');?>">
                <span class="error"><?php echo form_error('user_password'); ?></span>
            </div>
			<div class="form-group">
                <select class="form-control bottom" name="language">
                    <option value="">Select Language</option>
                    <?php 
                      if(!empty($country)){
                        foreach ($country as $key => $value) {
                            echo '<option value="'.$value['language_code'].'"">'.$value['language_name'].'</option>';
                        }
                      }else{
                        echo '<option value="">Language Not Found</option>';
                      }
                    ?>
                </select>
                <!--<span class="error"><?php echo form_error('user_password'); ?></span>-->
            </div>
            <div class="form-group" align="center">
                <img id="captcha_img" src="<?php echo base_url();?>/assets/captcha.php" /><br/>
                <button type="button" id="reload" class="button-icon"><i class="glyphicon glyphicon-refresh"></i></button>
                <input class="form-control" id="captcha1" name="captcha" type="text">
                <span class="error pull-left"><?php echo form_error('captcha'); ?></span>
            </div><br/>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-primary btn-main btn-block" type="submit">Sign in</button>
            </div>
          </form>
        </div>
		    <div id="forgot" class="tab-pane <?php if(isset($factive) && !empty($factive)){ echo $factive;}?>">
           <?php if(!empty($message)&&$message!=null) {echo ($message!=null) ? '<div class="alert alert-info fade in"><button type="button" class="close" data-dismiss="alert" onclick="reditect()">×</button><strong>'.$message.'</strong></div>' : null; }?>
          <form method="post" action="<?php echo base_url('signing/forgetPassword');?>">
            <p class="text-muted text-center">Enter your valid e-mail</p>
            <div class="form-group">
              <input type="email" name="user_email1" placeholder="mail@domain.com" class="form-control">
              <span class="error"><?php echo form_error('user_email1'); ?></span>
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-primary btn-main btn-block" type="submit">Recover Password</button>
            </div>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
        </ul>
      </div>
    </div>

    <script src="<?php echo base_url();?>/bower_components/jquery/dist/jquery.js"></script>
    <script src="<?php echo base_url();?>/bower_components/angular/angular.js"></script>
    <script src="<?php echo base_url();?>/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script src="<?php echo base_url();?>/bower_components/angular-ui-grid/ui-grid.js"></script>

    <!--jQuery 
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->

    <!--Bootstrap 
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
     <script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
            $("#reload").click(function() {
                $("#captcha_img").attr("src", "<?php echo base_url();?>/assets/captcha.php?timestamp=" + new Date().getTime());
			      });

        });
    </script>
    <script type="text/javascript">
      (function($) {
        $(document).ready(function() {
          $('.list-inline li > a').click(function() {
            var activeForm = $(this).attr('href') + ' > form';
            //console.log(activeForm);
            $(activeForm).addClass('animated fadeIn');
            //set timer to 1 seconds, after that, unload the animate animation
            setTimeout(function() {
              $(activeForm).removeClass('animated fadeIn');
            }, 1000);
          });
        });

      })(jQuery);
    </script>
  </body>
</html>