<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
$adminid=$_SESSION['adminlogin'];
$notificationid=intval($_GET['mynotification']);
$readstat=0;
$mymessage_read=1;
$update_notoficationstatus="UPDATE AdminNotifications SET adminreadstatus=?,admnoverview=? WHERE adminid=? AND adminreadstatus=? AND id=? ";
$notification_updated=$con->prepare($update_notoficationstatus);
$notification_updated->bind_param('iiiii',$mymessage_read, $mymessage_read,$adminid,$readstat,$notificationid);
$notification_updated->execute(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | READ | NOTIFICATION</title>
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css" rel="stylesheet">
    <link rel="shortcut icon" href="IMAGES/stagehostelicon.ico">

</head>
<body class="notifications-body">
    <header>
        <?php include('includes/header.php')?>
    </header>
    <div class="adminbody">
        <div class="container-fluid">
            <div class="row">
                <div class="thesidemenu">
                    <?php include("includes/admin-menubar.php");?>
                </div>
                <div class="col-md-8">
                    <div class=stage>
                        <div class="stage-head">
                            <h3><b>READ NOTIFICATION</b></h3>
                        </div>
                        <div class="notification-display" >
                            <?php
                            $status_query = "SELECT * FROM AdminNotifications where adminid=? AND id=? ";
                            $admin_notify=$con->prepare($status_query);
                            $admin_notify->bind_param('ii',$adminid,$notificationid);
                            $admin_notify->execute();
                            $yesterday_notifications=$admin_notify->get_result();   
                            while($row=$yesterday_notifications->fetch_assoc()){
                                $notifDate=new DateTime($row['adminnotificationDate']);
                                $dt=$notifDate->format('dS M Y m:s A');?>
                                <div class="notification-content"style="line-height:60px;word-wrap:wrap; background-color:#eee;">
                                    <div class="dateTitle"> <?php  echo htmlentities($dt);?></div>
                                    <div class="notification_read"style="line-height:60px;word-wrap:break-word;"> 
                                        <?php  echo htmlentities($row['adminmessage']);?>
                                    </div>
                                </div>
                            <?php } ?>
                                
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php")?>
    <script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
    <script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
    <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
    <?php include('includes/admin-notification-container.php')?> 
</html>