<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Survey API</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
       <!-- <script src="<?php echo base_url()?>application/modules/anketa/JS/functions.js" type="text/javascript"></script> -->


        <style>
            label, input { display:inline-block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 550px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
             div#users-contain { width: 350px; margin: 20px 0; }
             div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
             div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    
    
<?php

//if ($this->router->fetch_class() != 'anketa' && $this->router->fetch_class() != ('api')) {

    $is_login = $this->user->logged_in;
    
 
    

    /*
    if($is_login){
                $username  = $this->user->username;
                $user_id = $this->id = $this->session->userdata('id');  // application/libraries/User.php 143 linija

            // echo json_encode($is_login);
        }
     * 

     */
    
/*
 if (empty($this->input->server('PHP_AUTH_USER'))) {
       header('HTTP/1.0 401 Unauthorized');
       header('HTTP/1.1 401 Unauthorized');
       //header('WWW-Authenticate: Basic realm="My Realm"');

       echo '<p style=color:red;><b>You must login to use this service </b></p>'; // Ako klikne na  cancel
       die();
       }

       $username = $this->input->server('PHP_AUTH_USER');
       $password  = $this->input->server('PHP_AUTH_PW');

*/


if ($this->router->fetch_class() == 'news') {

    if ($survey_id) {

        $zbir = '';

        foreach ($query as $row) {

            echo "<span style='display:none;' class='total_answers'>  " . $row->ponudjeni_odgovori . " " . " - Total answers = " . $row->total . "</span><br>";
            $zbir += $row->total;
        }

        "Total votes   : " . $zbir . " ";

        ?>
        <p class='total'> </p>


         <!-- Login popup -->

         <div id="login-form" class="login" style="display:none;"  title="Login Form" >
             <p >All form fields are required.</p>

             <form id="login_forma" action='#' method="POST">   

          <fieldset>
              <div id="reg_form"  style="display:block;" >
            <label for="name">Username</label>
            <input type="text" name="username" id="name" value="" class="text ui-widget-content ui-corner-all">
<!--            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">-->
            <label for="password">Password</label>
            <input type="password" name="password" id="pass_popup" value="" class="text ui-widget-content ui-corner-all"><br>
           <!-- <input type="submit" name="submit_login" class="submit_login" id="submit_login" value="Login" style="margin: 95px 0 0 25px!important; position: absolute"> -->

            <p>If you don't have accout, please register <a id="reg-tab" href="#tab">here </a></p>
              </div>


            <div id="tab" style="display:none">
                  <label for="name">Username</label>
                 <input type="text" name="username" id="name" value="" class="text ui-widget-content ui-corner-all">

                   <label for="password">Password</label>
                  <input type="password" name="password" id="pass" value="" class="text ui-widget-content ui-corner-all"><br>

                    <label for="email">Email</label>
                  <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all">
                    <p>Have accout? Please login <a id="log-tab" href="#reg_form">here </a></p>

            </div>


            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <!-- <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"> -->
          </fieldset>
        </form>
      </div>

 
 
        <div id="users-contain" class="ui-widget" style=" display: none;" >
          <h1>Existing Users:</h1>
          <table id="users" class="ui-widget ui-widget-content">
            <thead>
              <tr class="ui-widget-header ">
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>John Doe</td>
                <td>john.doe@example.com</td>
                <td>johndoe1</td>
              </tr>
            </tbody>
          </table>

        <button id="create-user">Create new user</button>
        </div>


  <!--  Kraj Login popup -->

        <p style="border: 2px solid #6699cc; display: none;  padding: 5px; color:red;font-weight: bold  " class='error'>
            <img style="width:20px; height: 20px;"  src="<?php echo base_url(); ?>media/images/error.jpg " />  </p>


        <p style="border: 2px solid #6699cc; display: none;  padding: 5px; color:green;font-weight: bold  " class='success'>
            <img style="width:20px; height: 20px;"  src="<?php echo base_url(); ?>media/images/ok.jpg " />

        </p>
        <p style="font-weight: bold" class='time' id="time"></p>

        <?php if (isset($notice) || $notice = $this->session->flashdata('notification')): ?>
            <p class="notice"><?php echo $notice; ?></p>
        <?php endif; ?>

        <form id="forma" method="post" action="#">

              <div style="display:none;" id="dialog-form" title="Survey Comments">
            <p class="validateTips">Please write your comment bellow &nbsp;</p>
                    <textarea name="kom"  id="textarea" rows="10" cols="30" ></textarea>
        </div>
            <input type="hidden" name="komentar" id="kom" value="">   <!--  -->

            <div id="loading-image" style="display:none; margin: 30px 0 0 90px;" >
                <img style="width:60px; height: 60px;"  src="<?php echo base_url(); ?>media/images/ajax-loader.gif " />
                <p>Loading Survey...</p>
            </div>

            <div class='menubox widget' id="widget" style="display:none; background: #cccccc none; border: 1px solid #6699cc;" >

                <table id="table">
                    <tbody>
                    </tbody>

                </table>
                <input style="margin: 25px 0 0 25px!important;" type="submit" name="submit" value="submit" class="submit">
            </div>
            <div id="infomsg" style="display: none; color:green;"><b>Survey Result :</b>

                <title>Survey Results</title>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
                <script type="text/javascript">
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart()
                    {
                        var data = google.visualization.arrayToDataTable([
                            ['Answers', 'Number'],
        <?php
        foreach ($query as $row) {

            echo "[' " . $row->ponudjeni_odgovori . " ', " . $row->total . " ],";
        }
        ?>
                        ]);
                        var options = {
                            title: 'Percentage of our survey by users answers',
                            width: 350,
                            height: 350,
                            is3D: true,
                            pieHole: 0.4,
                            pieSliceTextStyle: {
                                color: 'black'
                            },
                            chartArea: {left: 20, top: 0, width: '100%', height: '75%'}
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                        chart.draw(data, options);

                    }

                </script>
                <br />
            </div>

        </form>

        <div id="piechart" style="width: 100%; height: 350px; display: none; background-color: #eee"></div> 

        <?php
    } else {

        echo '<p style="color:red"><b>No survey activated!</b></p>';
    }
    ?>

    <script>
        var is_user_login =<?php echo json_encode($is_login); ?>;

         $(document).ready(function () {

            $.ajax({
                method: "GET",
                url: '<?php echo site_url('anketa/anketa/widget'); ?>',
                dataType: 'json',
                beforeSend: function () {
                    setTimeout('document.getElementById("loading-image").style.display="none"', 2000);
                    $("#loading-image").show();
                },
                success: function (json) {
                    //console.log(json)
                    setTimeout('document.getElementById("widget").style.display="block"', 2000);
                    var tr;
                    var pitanje_id;
                    for (var i = 0; i < json.length; i++) {
                        tr = $('<tr>');
                        tr.append("<tr><td><h2>" + json[i].pitanje + "</h2></tr>") + "<br>";

                        for (var j = 0; j < json[i].odgovori.length; j++) {
                            pitanje_id = json[i].pitanje_id;
                            tr.append("<tr><td><input type='radio' class='coments' required name='odgovor_id' value=' " + json[i].odgovori[j].odgovor_id + " '>   " + json[i].odgovori[j].ponudjeni_odgovori + "</td></tr>") + "<br>";
                            $('table').append(tr);
                        }
                        tr.append("<tr><td><input type='hidden' ='' name='pitanje_id' value=' " + pitanje_id + " '></td></tr>");
                    }

                },
                error: function () {
                    $('.error').text('An error occurred');
                }
            });  //ajax request   

            $('form#forma').on("click", '.submit', function (e) {
                e.preventDefault();

                // pretvaramo u json_encode da dobijemo TRUE ili FALSE

            if(!is_user_login ) {

                       $( ".submit" ).button().on( "click", function() {
                          if(!is_user_login){
                            // js/function.js
                       dialog1.dialog( "open" );
                       $('.login').css("display", "block");
                   }
                     });
                     return false;

            }else{

                  //var username = $("#name").val();;
                  //var password = $("#pass").val();

                var datastring = $("#forma").serialize();
                odgovor_id = ($("input:radio:checked").val());
                komentar = $("#kom").val();

                if (!odgovor_id ||  komentar === '' ) {

                    $('.error').append('Please fill all fields ').css("display", "block");
                    $('.error').fadeIn().delay(2000).fadeOut();

                    return false;

                }else{

                    $.ajax({
                        url: '<?php echo site_url('anketa/anketa/insert_user_answers'); ?>',
                        method: "POST",
                        data: datastring,
                        dataType: "json",
                        success: function (data) {

                            if (data.status == 1) {

                                var total = 0;
                                for (var i = 0, r = data.count.length; i < r; i++) {
                                    total += parseInt(data.count[i].total);
                                }

                                $("#widget").fadeOut('slow', function () {
                                    $("#piechart").fadeIn('slow');
                                    $(".total_answers").fadeIn('slow');
                                    $('.success').append(data.message).css("display", "block");
                                    $('.total').append('Total Votes:' + total);
                                });
                            }

                        },
                        error: function (XHR, textStatus, errorThrown) {
                            $('.time').text('');
                            var err = JSON.parse(XHR.responseText);
                            $('.error').append(err.message).css("display", "block");
                          }
                    });  //ajax request   

                    }//else
                }
            });

            /*Pop-up komentar*/

                dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 350,
                width: 300,
                modal: true,
                     buttons: {
            "OK": function() {
                  var komentar = $("#textarea").val();
                   $("#kom").val(komentar);
                   $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
                $('#textarea').val('');
           }
      },

        close: function () {
            //form[ 1 ].reset();
            //  $('#textarea').val('');
        }

            });

            form = dialog.find("form").on("submit", function (event) {
                event.preventDefault();
            });

                 $("#widget").on("click", '.coments',  function () {
                 $("#dialog-form").dialog("open");
                 odgovor_id = ($("input:radio:checked").val());
                 $("#kom_id").val(odgovor_id);
            }); 


               $("#reg-tab").on("click", function () {
                           document.getElementById("reg_form").style.display="none";
                           document.getElementById("tab").style.display="block";
                });

                $("#log_tab").on("click", function () {
                           document.getElementById("tab").style.display="none";
                           document.getElementById("reg_form").style.display="block";

                });

      dialog1 = $( "#login-form" ).dialog({
      autoOpen: false,
      height: 400,
      width: 350,
      modal: true,
      buttons: {
         "Login": function() {

             var username = $("#name").val();
             var password = $("#pass_popup").val();

                /*Ajax header */

            $.ajax({
                        url: '<?php echo base_url()?>anketa/BACKEND_Controller/checkUserLogin',
                          method: "POST",
                          dataType: "json",
                       /*    headers: {
                             'PHP_AUTH_USER': username,
                             'PHP_AUTH_PW':   password

                        },*/

                        success: function (result) {

                        if (result.logged_in == true ) {

                                  is_user_login = true;
                                  $('.success').append(result.message).css("display", "block");
                                  $('.success').delay(2000).fadeOut(); 
 

                  }

               },

                        error: function (XHR, textStatus, errorThrown) {
                            var err = JSON.parse(XHR.responseText);
                            $('.error').append(err.message).css("display", "block");
                          },

                        beforeSend: function(xhr) { 
                             // console.log(password);
                            // console.log(username);
                        xhr.setRequestHeader('Authorization', 'Basic ' + window.btoa(unescape(encodeURIComponent(username + ':' + password))));
                    }


                    });   // ajax 

          $( this ).dialog( "close" );
        },

        Cancel: function() {
          dialog1.dialog( "close" );
        }
     }
    /*
      close: function() {
       form[ 0 ].reset();
       allFields.removeClass( "ui-state-error" );
      }
      */
    });


      });       //ready function 


    </script>

<?php 


    } 



