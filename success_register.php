<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

      <head>  
           <title>CI CMS Survay</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
           <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />  
          
      </head>  
      <body>  

            <div class="text-center">
            <h2>CI CMS Survey</h2>
            <h3>Created by Srdjan.S</h3>
            </div><br><br>
        <div class="col-md-12">
         <?php  
             $module = $this->session->flashdata('notification');
           
             ?>
	   <p class="notice"><?php  echo $module;?></p>
            <div class="alert alert-success">
        <strong>Success!</strong> Thank you for registering on Srki's CI CMS Survey.</div>
           <p>Please login to your account! <a href="<?php echo base_url();?>anketa/">HERE!</a></p>
	
           
        </div>

