<?php

include("../db/config.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
?>


<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
</head>
<body>
<div class="container">
    <br />

    <h3 align="center">Chat Jobint</h3><br />
    <br />
    <div class="row">
        <div class="col-md-8 col-sm-6">
            <h4>Online User</h4>
        </div>
        <div class="col-md-2 col-sm-3">
            <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
        </div>
    </div>
    <div class="table-responsive">

        <div id="user_details"></div>
        <div id="user_model_details"></div>
    </div>
    <br />
    <br />

</div>

</body>
</html>

<style>

    .chat_message_area
    {
        position: relative;
        width: 100%;
        height: auto;
        background-color: #FFF;
        border: 1px solid #CCC;
        border-radius: 3px;
    }


    .image_upload > form > input
    {
        display: none;
    }


</style>

<script>
    $(document).ready(function()
    {
        fetch_user();




    setInterval(function(){
       update_last_activity();
        fetch_user();
        //update_chat_history_data();
        //fetch_group_chat_history();
    }, 5000);

    function fetch_user()
    {
        $.ajax({
            url:"fetch_user.php",
            method:"POST",
            success:function(data){
                $('#user_details').html(data);
            }
        })
    }


        function update_last_activity()
        {
            $.ajax({
                url:"update_last_activity.php",
                success:function()
                {

                }
            })
        }



    }
    )

</script>