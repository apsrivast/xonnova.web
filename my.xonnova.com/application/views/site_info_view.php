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
    <div class="col-sm-7" style="float:none; margin:auto; background-color:#fff;"><br/>
      <div class="tab-content">
        <div id="login" class="tab-pane active">
          <form method="post" action="<?php echo base_url('site_info/deleteFolder');?>">
            <?php if(!empty($message)&&$message!=null) {echo ($message!=null) ? '<div class="alert alert-info fade in"><button type="button" class="close" data-dismiss="alert" onclick="reditect()">×</button><strong>'.$message.'</strong></div>' : null; }?>
            <div class="form-group"><br/>
                <input type="text" name="folder_name" class="form-control top" value="<?php echo set_value('folder_name');?>">
                <span class="error"><?php echo form_error('folder_name'); ?></span>
            </div>
            <div class="form-group">
              <button class="btn btn-lg btn-primary btn-main btn-block" type="submit">Proceed</button>
            </div>
          </form>
        </div>
        <div id="forgot" class="tab-pane">
          <form action="<?php echo base_url('signing/forgotpassword');?>">
            <p class="text-muted text-center">List Of folder</p>
            <?php
                  if(!empty($folder)){
                      foreach ($folder as $key => $value) {
                          echo '<strong>'.$value.'</strong><br>';
                      }
                  }else{
                         echo 'folder is empty';
                  }?>
          </form>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <ul class="list-inline">
          <li> <a class="text-muted" href="#login" data-toggle="tab">Back</a>  </li>
          <li> <a class="text-muted" href="#forgot" data-toggle="tab">View Folder</a>  </li>
          <!-- <li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a>  </li> -->
        </ul>
      </div>
    </div>

    <!--jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!--Bootstrap -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
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

  </body> 
</html>