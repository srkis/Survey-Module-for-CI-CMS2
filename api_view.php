

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Survey API</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- <link rel="stylesheet" href="/resources/demos/style.css">-->


        <style>
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 550px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body>


        <!-- Licence popup -->

        <div id="licence-form" class="licence" style="display:none;"  title="User Licence" >
            <p >Your licence key:</p>
            <p class="licence-key" style="color:red;" ><b></b></p>

            <form id="licence_forma" action='#' method="POST">   
                <fieldset>

                    <label for="name">Enter your Licence.: </label>
                    <input type="text" name="licence" id="licence_id" value="" class="text ui-widget-content ui-corner-all">

                </fieldset>
            </form>
            <p style="border: 2px solid #6699cc; display: none; width: 60%;  padding: 5px; color:red;font-weight:bold; margin-left:50px;" class='error-login'></p>
        </div>


        <div style="display:none;" id="dialog-form" title="Survey API details">

            <p style="border: 2px solid #6699cc; display: none;  padding: 5px; color:green;font-weight: bold  " class='success'>
                <img style="width:20px; height: 20px;"  src="<?php echo base_url(); ?>media/images/ok.jpg " />

            <p class="validateTips">Please choose Format &nbsp;
                <select id="format_select">
                    <option value="html" selected>HTML</option>
                    <option value="json">JSON</option>
                    <option value="xml">XML</option>
                </select>
            </p>
            <form>
                <fieldset>
                    <label for="url">API URL:</label>

                    <span><?php echo site_url("anketa/server/") ?></span> <br>
                    <p>Your licence key:

                    <p id="licence-key" style="color:red;" ><b></b></p>
                    <!-- <input type="text" name="url" id="url" value="" class="text ui-widget-content ui-corner-all">-->
                    <p class="validateTips"> Code Preview:</p>

                 <p class="validateTips"><span><?php echo site_url("anketa/api/getAPI/") ?></span><span id="format"></span></p><br>

                    <textarea id="textarea" rows="15" cols="70" readonly></textarea>
                </fieldset>
            </form>
        </div>


        <div id="users-contain" class="ui-widget">
            <h1>Existing Surveys:</h1>

            <p style="border: 2px solid #6699cc; display: none; width: 70%;  padding: 5px; color:red;font-weight: bold  " class='error'>
                <img style="width:20px; height: 20px;"  src="<?php echo base_url(); ?>media/images/error.jpg " />  </p>

            <table id="table" class="ui-widget ui-widget-content">
                <thead>
                    <tr class="ui-widget-header ">
                        <th>Question</th>
                        <th>Description</th>
                        <th>GET URL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anketa as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->pitanje ?></td>
                            <td><?php echo $row->description ?></td>
                            <td><button class="get_url" value="<?php echo $row->pitanje_id ?>">GET URL</button> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
        <?php ?>

    </body>
</html>


<script>

   var api_key = 'd41d8cd98f00b204e9800998ecf8427e';
    var pitanje_id = '';
    var licence = ''

    $(function () {

        $(".get_url").button().on("click", function () {
            pitanje_id = ($(this).val());

            $.ajax({
                method: "GET",
                url: '<?php echo site_url('anketa/api/getLicence'); ?>' + '/' + pitanje_id,
                dataType: 'json',
                success: function (data) {

                        licence = data.licence;


                    $("#licence-key").text(licence);

                },
                error: function (XHR, textStatus, errorThrown) {
                    $('.error').text('');
                    var err = JSON.parse(XHR.responseText);
                    $('.error').append(err.message).css("display", "block");
                },
            });
            dialog.dialog("open");

        });

        function getData(pitanje_id, format) {

            $.ajax({
                method: "GET",
                url: '<?php echo site_url('anketa/api/getApi'); ?>' + '/' + pitanje_id + '/' + format,
                dataType: 'text',
                success: function (data) {

                    $("#textarea").text(data);

                },
                error: function (XHR, textStatus, errorThrown) {
                    $('.error').text('');
                    var err = JSON.parse(XHR.responseText);
                    $('.error').append(err.message).css("display", "block");
                },
                beforeSend: function (xhr) {
                    //console.log(password);
                    xhr.setRequestHeader('Authorization', 'Basic ' + window.btoa(unescape(encodeURIComponent(api_key + ':' + pitanje_id))));
                }

            });

        }


        $("#format_select").change(function () {
            var format = ($(this).val());

            $("#format").html('/' + pitanje_id + '/' + format);
            getData(pitanje_id, format);
        });

        //var pitanje_id = 0;
        var dialog, form, pitanje_id, format
        dialog = $("#dialog-form").dialog({
            autoOpen: false,
            height: 450,
            width: 550,
            modal: true,
            buttons: {
                //  "GET URL": addUser,
                Cancel: function () {
                    dialog.dialog("close");
                }
            },
            close: function () {
                form[ 0 ].reset();
                $('#textarea').text('');
                //  allFields.removeClass( "ui-state-error" );
            },
            open: function () {
                if (pitanje_id)
                    getData(pitanje_id, $("#format_select option:selected").val())
            }
        });

        form = dialog.find("form").on("submit", function (event) {
            event.preventDefault();

        });



        function checkLicence() {

            /*Slanje licence za autorizaciju preko header-a  */
            $.ajax({
                method: "GET",
                url: '<?php echo site_url('anketa/server'); ?>',
                dataType: 'json',
                success: function (data) {

                    if (data.status != 1) {
                        $(this).dialog("close");

                    }
                    dialog.dialog("open");


                },
                error: function (XHR, textStatus, errorThrown) {
                    $('.error').text('');
                    var err = JSON.parse(XHR.responseText);
                    $('.error').append(err.message).css("display", "block");
                },
                beforeSend: function (xhr) {
                    //console.log(password);
                    xhr.setRequestHeader('Authorization', 'Basic ' + window.btoa(unescape(encodeURIComponent(licence + ':' + pitanje_id))));
                }

            });

        }

        // Promena formata

    });


</script>
