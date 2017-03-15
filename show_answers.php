 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Survey Results</title>  
        
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

      </head>  


<?php 
$survey_id = $this->uri->segment(4);
 
?>

<!-- [Content] start -->
<div class="content wide">

    <h1 id="page"><?php echo __("Survey Statistic", $module) ?></h1>

    <ul class="manage">
            <!--<li><a href="<?php // echo site_url('admin/anketa/show_user_answers') ?>"><?php //  echo __("View Answers", $module) ?></a></li> -->
        <li><a href="<?php echo site_url('admin/anketa/create') ?>"><?php echo __("Add a new survey", $module) ?></a></li>
         <li><a id='show_comments' href=""><?php echo __("Show Comments", $module) ?></a></li>
        <li><a href="<?php echo site_url('admin') ?>" class="last"><?php echo __("Cancel", $module) ?></a></li>
    </ul>

    <br class="clearfloat" />

    <hr />

    <div class="col-md-12">

        <h3 align="center">Here you can see survey result in percentage</h3>


        <?php
        $module = $this->session->flashdata('notification');
        ?>
        <p class="notice"><?php echo $module; ?></p>

        <?php

            $i = 0;
            $zbir = '';

        foreach ($data as $row) {


            echo "Answer : " . $row->ponudjeni_odgovori . " " . " - Total answers = " . $row->total . "<br>";
            $zbir += $row->total;
        }

        echo "Total votes   : " . $zbir;
        ?>

        <?php ?>
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
foreach ($data as $row) {

    echo "[' " . $row->ponudjeni_odgovori . " ', " . $row->total . "],";
}
?>

                ]);

                var options = {
                    title: 'Percentage of our survey by users answers',
                    is3D: true,
                    pieHole: 0.4
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }

        </script>

        <br /><br />
        <div style="width:900px;">

                     <table id="table">
                         <h1>Survey Comments</h1>
                    <tbody>
                    <th></th>

                    </tbody>

                </table>

            <br />
            <div id="piechart" style="width: 900px; height: 500px;"></div>  
        </div>

    </div>
</div>
</body>
</html>


      <script>

        $(document).ready(function () {

                $.ajax({
                        url: '<?php echo site_url('admin/anketa/show_user_Comments/'.$survey_id); ?>',
                        method: "GET",
                        dataType: "json",
                        success: function (json) {

                          var tr;
                          tr = $('<tr>');
 
                            $("tbody").append("<td style='width:62%;'><h3>Username</h3></td></th>") ;
                            $("tbody").append("<td><h3>Comments</h3></td></th>") ;
 
                        for (var i = 0; i <=10; i++) {
                            $("tbody  ").append("<tr><td>" + json[i].username + "</td> " + " <td>" + json[i].survey_comments + "</td> " + " <td>" + "</td></td></tr>");
                            $("tbody").append( tr);
                    }

                },
                        error: function (XHR, textStatus, errorThrown) {
                               $('.time').text('');
                               var err = JSON.parse(XHR.responseText);
                               $('.error').append(err.message).css("display", "block");
                        }
                    });  //ajax request   
        });


</script>
