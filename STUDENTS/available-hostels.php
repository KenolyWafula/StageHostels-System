<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT | HOME PAGE</title>
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
                        <div class="student-body">
                            <?php
                            $status=1;
                            $avail='available';
                            $query="SELECT * FROM hostel WHERE hostelStatus=? ORDER BY hostelName DESC";
                            $hostel_to_select=$con->prepare($query);
                            $hostel_to_select->bind_param('i',$status);
                            $hostel_to_select->execute();
                            $hostels=$hostel_to_select->get_result();
                            $cnt=1;
                            while($row=$hostels->fetch_assoc()){
                                $hostid=$row['id'];
                                $gothostel=$row['hostelName'];
                                $hostel_location=$row['hostelLocation'];
                                $room_description=$row['roomdescription'];
                                $caretaker=$row['hostelCaretaker'];
                                $caretaker_contact=$row['careTakerContact'];
                                
                                ?>
                                <div class="room-container">
                                    <a href="rooms-available.php?hostelid=<?php echo $row['id']?>">
                                        <div class="room-title"><u><?php echo htmlentities($gothostel);?></u></div>
                                        <div class="description"><?php echo htmlentities($room_description);?></div>
                                        <div class="description"><?php echo htmlentities($hostel_location);?> </div>
                                        <div class="description"><b>Caretaker Name: </b><?php echo htmlentities($caretaker);?> </div>
                                        <div class="description"><b>Caretaker Contact: </b><?php echo htmlentities($caretaker_contact);?> </div>
                                        
                                        <?php
                                        $query2="SELECT * FROM room WHERE hostelid=? AND roomavailability=? AND  roomstatus=?";
                                        $rooms_for_hostel=$con->prepare($query2);
                                        $rooms_for_hostel->bind_param('isi',$hostid,$avail,$status);
                                        $rooms_for_hostel->execute();
                                        $rooms=$rooms_for_hostel->get_result();
							            $total_rooms= $rooms->num_rows;{ ?>
                                            
                                        <div class="description">Hurry <b><u style="color:red"><?php echo htmlentities($total_rooms);?></u></b> Room(s) remaining </div>
                                        <?php
                                        }
                                         ?>                                
                            
                                    </a>
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
  	<?php if(isset($_SESSION['mystudentid'])){	
  	  include('includes/student-notification-container.php');
  	}
  	?>   
</body>
</html>