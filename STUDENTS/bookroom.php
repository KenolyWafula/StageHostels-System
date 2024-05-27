<?php

session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];

include('constraints-check.php');

date_default_timezone_set('Africa/Nairobi'); 
$rumid=intval($_GET['bookingrumid']);

if(isset($_POST['submit'])){
	$regno=$_POST['regno'];
	$name=$_POST['fullname'];
	$Room=$_POST['bookedroom'];
	$Amount=$_POST['amount'];
	$payment="unpaid";
  $availability='notavailable';
  $todaysdate=new DateTime();
	$currenttime=$todaysdate->format('Y-m-d H:i:s');
	$moveStatus="notoccupied";
	$student_own_room=1;

  $is_deadline_expired=0;
  $is_deadline_completed=0;
  $now=new DateTime();
  $twodayperiod=new DateInterval('P2D');//to get the time after 2days i.e 48hrs
  // "2 Days From Now";
  $now->add($twodayperiod);
  $twodaysdeadline=$now->format('Y-m-d H:i:s');
  $dayend_notify=$now->format('D,dS M h:i A ');

  $book__room="INSERT INTO studentroombook(registrationNo,bookedroomid,bookingDate, payment ,moveStatus,amount,roomownership,isExpired,StartingTime,ExpiryTime,CompletionStatus) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
  $my_booked_room = $con->prepare($book__room);
  $my_booked_room->bind_param('sisssiiissi',$regno,$Room,$currenttime,$payment,$moveStatus,$Amount,$student_own_room,$is_deadline_expired,$currenttime,$twodaysdeadline,$is_deadline_completed);
  $room_booked=$my_booked_room->execute();
	
  #declare the room unavailable for further booking
  $roomunavilable="UPDATE room SET roomavailability=? WHERE id=?";
  $booked =$con->prepare($roomunavilable);
  $booked->bind_param('si',$availability,$Room);
  $done=$booked->execute();  

  if($room_booked AND $done){
    $_SESSION["success"]="Room Booked Succesfully";
    $readstatus=0;   
    $currenttime= date('Y-m-d H:i:s',time() );
    $success_book="You have succesfully Booked Your Room You must pay for your Room before $dayend_notify ";

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
    
     //To Notify Admin That New stiudent booked a room
     $adminmsg="$studentid Booked a room On $currenttime";
     $admin_notification="INSERT INTO `AdminNotifications` (adminid,receiverstudregNo,adminmessage,adminreadstatus,adminnotificationDate,admnoverview)
       VALUES(?,?,?,?,?,?)";
       $admin_notify = $con->prepare($admin_notification);
       $admin_notify->bind_param('issisi',$adminidentity,$studentid,$adminmsg,$read,$admintime,$read);
       $admin_notify->execute();
      }
      Redirect_to("my-room-details.php");
    }else{
      $_SESSION["error"]="Something Went Wrong";
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
              <h3><b>BOOK ROOM</b></h3>
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
                    <label class="labelinfo">NAME:</label>
                    <input class="form-control" type="text" name="fullname"value="<?php echo  htmlentities($query['fullname']);?>" readonly>	
                  </div>
                  <div class="form-group">
                    <label class="labelinfo">REGISTRATION NUMBER:</label>
                    <input class="form-control" type="text" name="regno" value="<?php echo  htmlentities($query['regNo']);?>" readonly>	
                  </div>
                  <?php
                  $selected_room="SELECT room.id as myrumid,room.roomImage1,room.roomprice,hostel.id as hostelid, hostel.hostelName,room.roomname from room join hostel on hostel.id=room.hostelid  WHERE room.id=?";
                  $room_selected=$con->prepare($selected_room);
                  $room_selected->bind_param('i',$rumid);
                  $room_selected->execute();
                  $rooms=$room_selected->get_result();
                  while($row=$rooms->fetch_assoc()){
                    $hostel_belonged=$row['hostelName'];
                    $room_named=$row['roomname'];
                    $room_image=$row['roomImage1'];
                    $room_id=$row['myrumid'];
                    $hostel_id=$row["hostelid"];
                    $host_name=$row["hostelName"];
                    $room_price=$row["roomprice"];
                    ?>
                    <div class="form-group">
                      <label class="labelinfo"> HOSTEL:</label>
                      <select class="form-control" name="bookedhostel" readonly>
                        <option value="<?php echo $hostel_id?>"><?php echo $host_name?></option>
                      </select>	
                    </div>
                    <div class="form-group">
                      <label class="labelinfo">ROOM:</label>
                      <select class="form-control" name="bookedroom" id=#therooms readonly>
                        <option value="<?php echo $room_id ?>"><?php echo $room_named?></option> 
                      </select>
                    </div>
                    <div class="form-group">
                      <label class="labelinfo">AMOUNT:</label>
                      <input class="form-control" type="number"  id=fpm name="amount" value="<?php echo $room_price?>"" readonly>
                    </div>
                    <div class="form-group">
                      <button class="btn submit-button btn-info" type="submit" name="submit">Book Room</button>
                    </div>
                  <?php } ?>
                </form>
                
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
  <?php include('includes/student-notification-container.php')?> 
</body>
</html>

