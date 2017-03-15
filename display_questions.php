<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CI CMS Survey</title>
</head>
<body>
    <?php
        if (isset($notice) || $notice = $this->session->flashdata('notification')):?>
    <p class="notice"><?php  echo $notice;?></p>
    <?php  endif;?>

<div id="container">
	<h1>CI CMS Survey</h1>
        
        <?php
        
          if($anketa){
              
             

            ?>

        <form action="<?php echo base_url();?>anketa/insert_user_answers" method="POST">        
    
        <?php 

        foreach($anketa as $row) {   ?>

       <h3><?php echo $row->pitanje_id . ". " . $row->pitanje ?></h3>

    <?php
                if ( isset( $row ) && property_exists( $row, 'odgovori')) {
         foreach ($row->odgovori as $answer) {

          $odgovor =  (array)$answer;

    ?>

     <input type="radio" name="odgovor_id" value="<?php echo $odgovor['odgovor_id'] ?>" required ><?php echo $odgovor['ponudjeni_odgovori'] ?><br>
     
        <?php  } } }  ?>

        <br><br>
        <input type="hidden" name="pitanje_id" value="<?php echo $row->pitanje_id ?> ">
        <input type="submit" name="submit" value="Submit!">
 </form>
        <?php
            }else{

                echo( "<h2>Sorry no survey Activated.</h2>");
            }
        ?>

   </div>

   </body>
   </html>

