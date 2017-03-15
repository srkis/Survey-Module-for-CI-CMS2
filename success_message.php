
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Survey Results</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  


      </head>  
      <body>  
          
          <style>
              .all{
                  width:500px;
                  height:400px;
                  position:relative;
                  margin:20px;
              }

              .content{
                  margin-bottom: 100px;
              }

              .hor{
                  width: 1px;
                  height: 100%;
                  position:absolute;
                  left: 50px;
                  top:0px;
                  background-color: #CCC;
              }

              .ver{
                  height: 1px;
                  width: 100%;
                  position: absolute;
                  bottom: 20px;
                  left: 0px;
                  background-color: #CCC;
              }

               .chart{
                  height: 30px;
                  width: 100%;
                  bottom: 20px;
                  margin-left: 60px;

                  background-color: green;
                  text-align: center;
                  color:#000;

              }

              .answers ul li{
                  list-style: none;
                  margin-left:15px;
              }

          </style>

          <div class="content"><h2 style="text-align:center;"><?php echo "Results from survey "?></h2></div>
          <div class="row">

       <div class="col-md-4">
        <?php

      
                    foreach ($query  as $row){

                    echo  "Answer : " . $row->ponudjeni_odgovori . " ". " - Total answers = ". $row->total ."<br>";

        } 
              ?>

      </div>

          <div class="col-md-8">

       <?php

               $zbir = '';
                foreach ($query as $pitanje_id){
                $zbir =  $zbir + $pitanje_id->total;

         }
           "ukupno " . $zbir  .  "<br>";
                ?>

               <div class="hor"></div>

              <div class="ver"> </div>
<?php
         $div = 200;
        foreach ($query as $pitanje_id){

               "question_id = " . $pitanje_id->survey_odgovor_id . " ". " total = ". $pitanje_id->total ."<br>";
                $total = ($pitanje_id->total / $zbir) * 100 ."%";
                $all = ($div /100 ) * $total;
                ?>
            <div></div><br><br><br>
                <?php

                if($all < '50'){
                    $color = "background-color: red; ";

                }elseif($all > '50' && $all < '80' ){ 
                    $color = " background-color: yellow; ";

                }elseif($all > '80' ){
                    $color = " background-color: green; "; 

        }else{
            $color = " background-color: orange; ";

        }

        ?>
            <div class="chart" style="width:<?php echo $all ?>% ; <?php echo $color ?>;">
              <?php echo "<b>". round($total) ."%" ."</b>";

              ?>

            </div><br><br>

        <?php }  ?>

          </div>


      </div>
      </body>
 </html>

 