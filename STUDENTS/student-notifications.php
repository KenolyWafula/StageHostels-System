<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];
date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENTS | NOTIFICATIONS</title>
    <link type="text/css" href="../STYLES/css/students-style.css" rel="stylesheet">       
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet"> 
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
    <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body class="notifications-body">
    <div class="container-fluid">
        <div class="row">
            <div class="thesidemenu">
                <?php include("includes/student-menu-bar.php") ?>
            </div>
            <div class="col-md-8">
                <div class="stage">
                    <div class="stage-head">
                        <h3><b>NOTIFICATIONS</b></h3>
                    </div>
                    <div class="notification-display">
                        <?php include('student-todays-notification.php')?>
                        <?php include('student-yesterdays-notification.php')?>
                        <?php include('student-previous-notifications.php')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php include("includes/footer.php")?>
     <script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
     <script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
     <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
     <?php include('includes/student-notification-container.php')?>  
     
    <script>
        if($.trim($("#today_notif").html())==""){
           $("#today_notif").remove();
       }
       if($.trim($("#yesterday_notif").html())==""){
           $("#yesterday_notif").remove();
       }
       if($.trim($("#previous_notif").html())==""){
           $("#previous_notif").remove();
       }

       if($.trim($(".notification-display").html())==""){
           $(".notification-display").append('<div class="notification-content"> No Notifications ');
           $(".notification-content").append(' <div class="notification-Text notification_read"> You have no notifications</div>');

       }
    </script>
</body>
</html>
 
