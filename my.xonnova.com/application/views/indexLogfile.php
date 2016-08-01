<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>MLM Network Login</title>
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <link href="<?php echo base_url(); ?>/assets/favicon.png" type="image/png" rel="icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">

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
  </head>
  <body class="login">
    <div class="form-signin">
      <div class="text-center">
        <img class="img-square" src="<?php echo base_url(); ?>/assets/images/logo.png" alt="Olegacy Logo">
      </div>
      <hr>
      <div class="tab-content">
        <div id="login" class="tab-pane <?php if(isset($lacitve) && !empty($lacitve)){ echo $lacitve;}?>">
          <form method="post" action="<?php '#';//echo base_url('signing/login');?>">
            <!-- <p class="text-muted text-center">
              Enter your username and password
            </p> -->
            <div class="form-group">
                <input type="text" name="user_email" placeholder="Username" class="form-control top" value="<?php echo set_value('user_email');?>">
                <span class="error"><?php echo form_error('user_email'); ?></span>
            </div>
            <div class="form-group">
                <input type="password" name="user_password" placeholder="Password" class="form-control bottom" value="<?php echo set_value('user_password');?>">
                <span class="error"><?php echo form_error('user_password'); ?></span>
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
        <!--<div id="forgot" class="tab-pane">
          <form action="<?php echo base_url('signing/forgotpassword');?>">
            <p class="text-muted text-center">Enter your valid e-mail</p>
            <input type="email" placeholder="mail@domain.com" class="form-control">
            <br>
            <button class="btn btn-lg btn-primary btn-main btn-block" type="submit">Recover Password</button>
          </form>
        </div>-->
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
        <!-- <div id="signup" class="tab-pane">
          <form action="index.html">
            <input type="text" placeholder="username" class="form-control top">
            <input type="email" placeholder="mail@domain.com" class="form-control middle">
            <input type="password" placeholder="password" class="form-control middle">
            <input type="password" placeholder="re-password" class="form-control bottom">
            <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
          </form>
        </div> -->
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
          <!-- <li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a>  </li> -->
        </ul>
      </div>
    </div>
	
	<div class="modal fade" id="myModal" data-backdrop="static">
		<div class="modal-dialog">
		  <div class="modal-content" style="box-shadow: none; background-color: transparent; border: medium none;">
			<div class="modal-header" style="border-bottom: medium none;">
			  <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
			  <h4 class="modal-title"></h4>
			</div>
			<div class="modal-body" align="center">
				<!--<img src="<?php echo base_url();?>assets/img/loader.gif" alt=""/>-->
			</div>
			<div class="modal-footer" style="border-top: medium none;">
			  <div class="col-sm-12" align="center" >
				<!-- <button type="button" class="btn btn-default" id="reload-current-page" data-dismiss="modal">Close</button>        -->
			  </div>
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  
    <!--jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!--Bootstrap -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
            $("#reload").click(function() {
                $("#captcha_img").attr("src", "<?php echo base_url();?>/assets/captcha.php");
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
	 <script>
    (function() {
            $('#login').ajaxForm({
                success: function(responseText) {
                   $('#myModal').modal();  
                      //$('#thankyou-message').html(data);
                  },
                error: function () {
                      alert('Error....');
                  }
            });
      
       
        })();
       
    </script>
  </body>
</html>