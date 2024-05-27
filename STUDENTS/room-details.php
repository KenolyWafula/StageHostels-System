<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
$rumid=intval($_GET['roomid']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROOM | DETAILS</title>
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
                            <h3><b>ROOM DETAILS</b></h3>
                        </div>
                        <div class="stage-body">
                        <div class=image-description-holder>
                            <?php
                            $selected_room="SELECT room.id,room.roomImage1,room.roomprice,hostel.roomdescription,hostel.hostelLocation,hostel.hostelCaretaker,hostel.careTakerContact,hostel.hostelName,room.roomname from room join hostel on hostel.id=room.hostelid  WHERE room.id=?";
                            $room_selected=$con->prepare($selected_room);
                            $room_selected->bind_param('i',$rumid);
                            $room_selected->execute();
                            $rooms=$room_selected->get_result();
                            while($row=$rooms->fetch_assoc()){
                                $hostel_belonged=$row['hostelName'];
                                $room_named=$row['roomname'];
                                $room_image=$row['roomImage1'];
                                $room_price=$row['roomprice'];
                                $rumdescription=$row['roomdescription'];
                                $location=$row['hostelLocation'];
                                $caretaker=$row['hostelCaretaker'];
                                $caretakerNo=$row['careTakerContact'];
                               
                                $room_id=$row['id'];
                                 ?>
                                 <div class="room-images">							
                                     <img  class="room-images" src="<?php echo "../ADMIN/images/hostels/$hostel_belonged/$room_named/$room_image"  ?>" onerror="this.src='../ADMIN/images/images/noimageavailable.png'"width=300 height=300>
                                </div>  
                                <div class="description-container">
                                <div class="room-title"><u> <?php echo $hostel_belonged?></u></div>
                                
                                <div class="room"><?php echo htmlentities($room_named);?></div>
                                    <div class="price"><u>PRICE: SH <?php echo $room_price?> </u></div>
                                    <h4><u> Room Description</u></h4>
                                    <ul>
                                   <li><p> <?php echo htmlentities($rumdescription) ?></p></li>
                                   <li><p>Location:<i><?php echo htmlentities($location) ?></i></p></li>
                                  <li> <p>CareTaker: <i><?php echo htmlentities($caretaker) ?></i></p></li>
                                <li><p>CareTaker Number:<i><?php echo htmlentities($caretakerNo) ?></i></p></li>
                                </ul>
                                    <a class="cancelpaybtn" href="bookroom.php?bookingrumid=<?php echo htmlentities($room_id) ?>">
                                        <button class="btn submit-button btn-info"  id="paybtn">BOOK ROOM</button>
                                    </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                
<script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
<script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
<script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
<?php

if(isset($_SESSION['mystudentid']))
{	
include('includes/student-notification-container.php');
}?> 

 
</body>
</html>