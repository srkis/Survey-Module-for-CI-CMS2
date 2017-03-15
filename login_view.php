<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

      <head>  
           <title>CI CMS2</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
           <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />  

      </head>  
      <body>  

    <div class="text-center">
    <h2>Welcome to the CI CMS Survey</h2>
    <h3>Please login or register to your account!</h3>
    <?php  echo validation_errors(); ?>


      <?php 
      
     // $is_login = $this->user->logged_in;

      ?>

    </div><br><br>
                <div class="col-md-6 ">
                    <div class="panel panel-login" style="width: 400px;">
                <div class="panel-heading">
                        <div class="row">
                <div class="col-xs-6">
                        <a href="#" class="active" id="login-form-link">Login</a>
                </div>
                <div class="col-xs-6">
                        <a href="#" id="register-form-link">Register</a>
                </div>
                </div>
                <hr>
                </div>
    <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
        <form id="login-form" action="<?php echo base_url();?>anketa/Login_Controller/checklogin" method="POST" role="form" style="display: block;">  <!-- <?php echo base_url();?>anketa/login -->

                <div class="form-group">    
                    <input type="text" name="username" id="username" tabindex="1" class="form-control"  placeholder="Username" value='<?php echo set_value('username'); ?>'>
                </div>
                <div class="form-group">
                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value='<?php echo set_value('password'); ?>'>
                </div>
                <div class="form-group text-center">
                        <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                        <label for="remember"> Remember Me</label>
                </div>
                <div class="form-group">
                        <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <input type="submit" name="login_submit" id="login-submit" tabindex="4" class="form-control btn btn-info" value="Log In">
                                </div>
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                                <div class="col-lg-12">
                                        <div class="text-center">
                                                <a href="" tabindex="5" class="forgot-password">Forgot Password?</a>
                                        </div>
                                </div>
                        </div>
                </div>
        </form>

            <form id="register-form" action="<?php echo site_url();?>anketa/register_new_user/" method="post" role="form" style="display: none;">

            <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value='<?php echo set_value('username'); ?>'>
                </div>
                <div class="form-group">
                        <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php  echo set_value('email');?>">
                </div>
                <div class="form-group">
                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                        <input type="password" name="passconf" id="passconf" tabindex="2" class="form-control" placeholder="Password Again">
                </div>
                <div class="form-group">
                        <div class="row">
                                <div class="col-sm-6 col-sm-offset-3">
                <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-success" value="Register Now">
                    </div>
            </div>
    </div>
    </form>
</div>
</div>
</div>
</div>
</div>


<script>

   $(document).ready(function(){
       
       $(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
        
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});


});


</script>


