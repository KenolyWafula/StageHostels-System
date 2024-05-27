<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
if(isset($_SESSION['mystudentid'])){
    $studentid=$_SESSION['mystudentid'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT | ABOUT US</title>
    <link type="text/css" href="../STYLES/css/students-style.css" rel="stylesheet">    
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet"> 
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
    <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body class="rooms-display">
	<header>
        <?php include('includes/header.php')?>
    </header>
    <div class="adminbody">
        <div class="container-fluid">
            <div class="row">
                <div class="thesidemenu">
                    <?php include("includes/student-menu-bar.php") ?>
                </div>
                <div class="col-md-8">
                    <div class="stage">
                        <div class="stage-head">
                             <h3><b>ABOUT US</b></h3>
                        </div>                      
                        <div class="stage-body">
                            <h2><u> Stage Hostel System</u></h2>
                            <h4><u> Developed by </u></h4>
                            <ol>
                            <li><b>KENOLY WAFULA- 0795759682.</b></li>
                            <li><b>PETER KOVI-0745647006</b></li>
                            
                            </ol>
                            <h4><u> Our Motivation</u></h4>
                            <p>Moi University has a very accessible area of settlement. 
                            This is the case as it is near the university’s premises. There are places of settlement outside the school which are owned by private entrepreneurs that are rented by students and a few locals. Due to the continuing growth in population of the students in the university, a couple of factors emerge; both positive and negative.
                            </p>
                            <hr>
                            <h4><u> Reasons to use our system</u></h4>
                            <ul>
                            <li> Due to the increased number of students in the university, there is also a need for increased areas of settlement for the students.</li>
                            <li> university hostels can only accommodate just but a fraction of whole population</li>
                            <li>A large number of students are forced to look for private areas of residence. </li>
                            <li>Students are also forced to travel all the way from their homes around the country; and at times out of the country, early enough before the semester starts, in order to book and get a place in these private areas of residence</li>
                            <li>The areas of settlement are few bringing lots of monetary and time challenges.</li>
                            <li>It is convenient</li>
                            </ul>
                            <hr>
                           

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
  	<?php if(isset($_SESSION['mystudentid'])){	
  	  include('includes/student-notification-container.php');
  	}
  	?>   
</body>
</html>