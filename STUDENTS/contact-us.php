<?php

session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];

date_default_timezone_set('Africa/Nairobi'); 

if(isset($_POST['submit'])){
	$regno=$_POST['regno'];
	$question=$_POST['message'];
    $readstatus=0;   
    $currenttime= date('Y-m-d H:i:s',time() );
    $message=ucwords("FROM $studentid :"). $question;
    $success_book=" Thanks for contacting us. We will reply to you as soon as possible";
    $booking_done="INSERT INTO `studentnotifications` (studregNo,sentmessage,readstatus,notificationDate,studentoverview) VALUES(?,?,?,?,?)";
    $book = $con->prepare($booking_done);
    $book->bind_param('ssisi',$studentid, $success_book,$readstatus,$currenttime,$readstatus);
    $book->execute();

    //select Admins that are available
    $myadmin="SELECT id FROM admin ";
    $admins=$con->prepare( $myadmin);
    $admins->execute();
    $alladmins=$admins->get_result();
    while($systadmin=$alladmins->fetch_assoc())
    {
        date_default_timezone_set('Africa/Nairobi');
        $admintime= date('Y-m-d H:i:s',time() );
        $adminidentity=$systadmin['id'];
        $read=0;
        $admoverview=0;
    
     //To Notify Admin Tof the message
     $adminmsg="$studentid Booked a room On $currenttime";
     $admin_notification="INSERT INTO `AdminNotifications` (adminid,receiverstudregNo,adminmessage,adminreadstatus,adminnotificationDate,admnoverview)
    VALUES(?,?,?,?,?,?)";
    $admin_notify = $con->prepare($admin_notification);
    $admin_notify->bind_param('issisi',$adminidentity,$regno,$message,$read,$admintime,$read);
    $admin_notify->execute();
      }
    if( $admin_notify){
        $_SESSION["success"]="Message sent succesfull. Wait for a response";
    }
    
        else{
          $_SESSION["error"]="Message not sent Something Went Wrong";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STUDENTS | BOOK ROOM</title>
  <link type="text/css" href="../STYLES/css/students-style.css" rel="stylesheet">      
  <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet"> 
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
  <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body>
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
              <h3><b>CONTACT US</b></h3>
            </div>
            <?php echo message();?>
            <?php echo success();?>
            <div class="stage-body">
              <?php
              $studentdetails="SELECT * FROM students WHERE regNo=?";
              $student_to_book=$con->prepare($studentdetails);
              $student_to_book->bind_param('s',$studentid);
              $student_to_book->execute();
              $studentdet=$student_to_book->get_result();
              while($query=$studentdet->fetch_assoc()){
                ?>
                <form  method="POST">
                  <div class="form-group">
                    <label class="labelinfo">REGISTRATION NUMBER:</label>
                    <input class="form-control" type="text" name="regno" value="<?php echo  htmlentities($query['regNo']);?>" readonly>	
                  </div>
              
                    <div class="form-group">
                      <label class="labelinfo">MESSAGE:</label>
                      <textarea cols="30" rows="10" class="form-control" name="message" required placeholder="Enter your message">
                       </textarea>
                    </div>
                    <div class="form-group">
                      <button class="btn submit-button btn-info" type="submit" name="submit">SEND MESSAGE</button>
                    </div>
                  <?php } ?>
                </form>
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
  <?php include('includes/student-notification-container.php')?> 
</body>
</html>

