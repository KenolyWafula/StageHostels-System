<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];
$payment='unpaid';

$is_room_expr=0;
$is_completion=0;
$i_own=1;
$query="SELECT hostel.hostelName, hostel.roomdescription,hostel.hostelLocation,hostel.hostelCaretaker,hostel.careTakerContact,room.roomname,room.roomImage1,studentroombook.bookedroomid as cancelroomid,studentroombook.isExpired,studentroombook.StartingTime,studentroombook.ExpiryTime,studentroombook.CompletionStatus,studentroombook.id as studentbkid,studentroombook.registrationNo, studentroombook.bookedroomid,studentroombook.payment,studentroombook.amount from studentroombook join room on studentroombook.bookedroomid=room.id join hostel on hostel.id=room.hostelid WHERE
studentroombook.registrationNo=? AND  studentroombook.payment=? AND  studentroombook.roomownership=? AND studentroombook.isExpired=? AND studentroombook.CompletionStatus=?";
$booking_to_select=$con->prepare($query);
$booking_to_select->bind_param('ssiii',$studentid,$payment,$i_own,$is_room_expr,$is_completion);
$booking_to_select->execute();
$bookings=$booking_to_select->get_result();
$count=$bookings->num_rows;
if($count>0){
while($row=$bookings->fetch_assoc())
{  
$mydeadline=$row['ExpiryTime'];
$startingtime=$row['StartingTime'];
$expiry=new DateTime($row['ExpiryTime']);
$started=new DateTime($row['StartingTime']);
$hostel_belonged=$row['hostelName'];
$hosteldescription=$row['roomdescription'];
$room_named=$row['roomname'];
$room_image=$row['roomImage1'];
$host_name=$row["hostelName"];
$room_price=$row["amount"];
$room_to_cancel=$row["cancelroomid"];
$location=$row['hostelLocation'];
$caretaker=$row['hostelCaretaker'];
$caretakerNo=$row['careTakerContact'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT | ROOM | PENDING PAYMENT</title>
    <link type="text/css" href="../STYLES/css/students-style.css" rel="stylesheet">       
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet"> 
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
    <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body class="desriptions_rooms">
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
                            <h3><b>BOOKED ROOM DETAILS</b></h3>
                        </div>
                        <?php echo message();?>
                            <?php echo success();?>
                        <div class="stage-body">
                        
                            <div class=image-description-holder>
                            
                            <?php 
                                $daystart=$started->format('D,dS M h:i A ');
                                $expired=$expiry->format('D,dS M h:i A ');
                                ?>
                                 <div class="room-images">
                                    <img widthe= 100 height=100 class="room-image" src="<?php echo "../ADMIN/images/hostels/$hostel_belonged/$room_named/$room_image"  ?>" onerror="this.src='../ADMIN/images/images/noimageavailable.png'">
                                </div>
                                <div class="description-container">                            
                                    <div class="room-title"><u> <?php echo $hostel_belonged?></u></div>
                                    <div class="room"><?php echo $room_named?></div>
                                    You Must Pay For Your Room Before <span class="date"><b><?php echo ("$expired" ) ?></b></span> 
                                    <div class="price"><u>PRICE: SH <?php echo $room_price?> </u></div>
                                    <h4><u> Room Description</u></h4>
                                    <ul>
                                   <li><p> <?php echo htmlentities($hosteldescription) ?></p></li>
                                
                                   <li><p>Location:<i><?php echo htmlentities($location) ?></i></p></li>
                                  <li> <p>CareTaker: <i><?php echo htmlentities($caretaker) ?></i></p></li>
                                <li><p>CareTaker Number:<i><?php echo htmlentities($caretakerNo) ?></i></p></li>
                                </ul>
                                    <a class="cancelpaybtn" href="#">
                                        <button Class="btn btn-info" id="paybtn">PAY NOW</button>
                                    </a>
                                    <a class="cancelpaybtn" href="cancel-checkout-room.php?id=<?php echo $row['studentbkid'];?>">
                                        <button Class="btn btn-danger" >CANCEL BOOKING </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
<script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
<script src="../STYLES/js/sidebar.js"type="text/javascript"></script>






<?php if(isset($_SESSION['mystudentid']))
	{	
	include('includes/student-notification-container.php');
    }
    ?> 
</body>
</html>
<?php 
}
}else{
    Redirect_to("booked-room-details.php");
}

?>

