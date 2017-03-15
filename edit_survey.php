      
  <head>  
           <title>Survey Results</title>  
            
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      
   <div class="leftmenu">

	<h1 id="pageinfo"><?php _e("Survey informations", $module) ?></h1>
	
	<ul id="tabs" class="quickmenu">
		<li><a href="#one"><?php echo __("Content", $module)?></a></li>
		<li><a href="#two"><?php echo __("Other fields", $module)?></a></li>
		<li><a href="#three"><?php echo __("Options", $module)?></a></li>
		<?php /*<li><a href="#four"><?php echo __("Group access", $module)?></a></li>*/ ?>
	</ul>
	<div class="quickend"></div>

</div>
<!-- [Left menu] end -->

<!-- [Content] start -->
<div class="content slim">
<!-- <form  method="post" style="margin-top: 20px;" class="edit" name="add_name" id="forma" action=<?php //site_url('admin/anketa/save/')?> >  -->

<?php $survey_id =  $this->uri->segment(4); ?>

<h1 id="edit"><?php echo  __("Edit Survey", $module)?></h1><br><br>
   <?php  echo validation_errors(); ?>

        <?php echo form_open("admin/anketa/save/",'id="forma", class="edit",name="add_name" '); ?> 

               <ul>
                    <li><input type="submit" name="submit" value="Save changes" class="input-submit" /></li>
                   <li><a href="<?php  echo site_url('admin/'.$module.'/delete_survey/'.$survey_id)?>" class="input-submit"><?php echo __("Delete survey", $module)?></a></li>
                   
               <!--    <li><a href="#" name="disable_survey" value="<?php  //echo  $survey_id; ?>" id="disable_survey"  class="input-submit disable_survey"><?php// echo __("Disable Survey", $module)?></a></li> -->
                   <li><a style="display: none;" href="#" name="activate" id="enable_survey" class="input-submit last activate_survey"><?php echo __("Activate Survey", $module)?></a></li>
                       
                   <li><a href="<?php echo site_url('admin/anketa')?>" class="input-submit last"><?php echo __("Cancel", $module)?></a></li>

	</ul>
	<br class="clearfloat" />

	<hr />

                    <?php if ($notice = $this->session->flashdata('notification')):?>
                    <p class="notice"><?php echo $notice;?></p>
                    <?php endif;?>

	<div id="one">
                <table id="answers">  
                 <br>  

                <?php
      
                foreach ($edit as $survey_data)  {
                ?>
                        <tr>
<!--                        <label for="naziv"><?php echo __("Survey Name:", $module)?></label>
	        <input type="text" name="naziv" value="<?php echo $survey_data->description ?>" id="naziv" class="input-text" /><br />-->
                        <input type="hidden" name="pitanje_id" value="<?php  echo $survey_data->pitanje_id; ?>">

                        <label for="pitanje"><?php echo __("Survey Question", $module)?>:</label>
                        <input type="text" name="pitanje" value="<?php echo  $survey_data->pitanje ?>" class="input-text" />&nbsp;<button type="button" name="add" class="btn_add" id="add" >+</button><br /><br>
                        <input type="hidden" name="status" value="<?php  echo $survey_data->status; ?>"/>

                        <?php } ?>
                        </tr>


                        <?php
                          foreach ($edit as $row)  {

                          foreach ($row->odgovori as $key){ 
                                   $key->odgovor_id;

                         ?>
                        
                    <tr>
                      <label for="answer"><?php echo __("Survey Answer", $module)?>:</label>
                     <td><input type="text" name="answer[<?php  echo $key->odgovor_id; ?>]" value="<?php  echo $key->ponudjeni_odgovori; ?>" id="answer"  class="input-text name_list" /></td>
                     <td><button type="button" name="button" value="<?php  echo $key->odgovor_id; ?>" class="btn_remove">X</button></td>
                      
                  </tr>
         <?php  }  }  ?>
                  
                </table>
               <br>
                <label for="check"><?php echo __("Survey is Activated", $module)?>:</label> <br>
                <?php if($row->status == 1){ ?>
                <input type="checkbox"  name="check" checked value="1" id="check"  /><br /><br />
            <?php  }else{ ?>
                       <label for="check"><?php echo __("Activate Survey", $module)?>:</label> <br>
                       <input type="checkbox" name="check" value="1" id="check" /><br /><br />
               <?php } ?>

                <label for="body"><?php echo __("Survey Description:", $module)?></label><br><br>
	<textarea name="body" class="input-textarea"><?php echo $survey_data->description ?></textarea>


        </div>
                    
    
<?php echo form_close(); ?>

 <script>  
 $(document).ready(function(){  

      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#answers').append('<tr id="row'+i+'"><td><input type="text" name="newanswer[]" value="" id="answer" class="input-text name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn_remove">X</button></td></tr>');  
      });  

     $('form#forma').on("click", '.btn_remove', function(){
         var id_pitanja = $(this).val();
          console.log($(this).val())
           $(this).closest('tr').fadeOut(function(){
             $(this).remove();
             
});

                $.ajax({  
                url:'http://mojhost/ci-cms2/admin/anketa/remove_input',  
                method:"POST",  
                data:{id_pitanja:id_pitanja}, 
                dataType:"text",
                success:function(data)  
                {
                       // alert(data);
                }
           });


     }); 


           // Disable survey  disableSurvey

          $('form#forma').on("click", '.disable_survey', function(){
         var survey_id = $(this).val();
          console.log($(this).val())

                $.ajax({  
                 url:'http://mojhost/ci-cms2/admin/anketa/disable_Survey',  
                method:"POST",  
                data:{survey_id:survey_id}, 
                dataType:"text",
                success:function(data) {
 
                    $("#alert_disable").show();
                    $("#disable_survey").fadeOut('slow');
                     $("#enable_survey").fadeIn('slow');
                        $("#alert_disable").fadeOut("slow");

                }

           });

     });


        //Activate Survey 

        $('form#forma').on("click", '.activate_survey', function(){
          var survey_id = $(this).val();
           console.log($(this).val())

                $.ajax({  
                 url:'http://mojhost/ci-cms2/admin/anketa/enable_Survey',  
                method:"POST",  
                data:{survey_id:survey_id}, 
                dataType:"text",
                success:function(data) {

                  $("#alert_enable").show();
                  $("#disable_survey").fadeIn('slow');
                  $("#alert_disable").fadeOut('slow');
                  $("#enable_survey").fadeOut('slow');
                  $("#alert_enable").fadeOut('slow');


                }

           });

     }); 





 });
 </script>


 <script>

   $(document).ready(function(){
     $("#tabs").tabs();
   });

 </script>	

</div>
<!-- [Content] end -->