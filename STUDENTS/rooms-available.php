<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
$hostelid=intval($_GET['hostelid']);
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
                            $room_status=1;
                            $avail='available';
                            $query="SELECT room.id,hostel.hostelName,room.roomname,room.roomprice,room.roomImage1 from room join hostel on hostel.id=room.hostelid  WHERE room.roomStatus=? AND room.roomavailability=? AND hostel.id=? ORDER BY room.roomname ASC ";
                            $room_to_select=$con->prepare($query);
                            $room_to_select->bind_param('isi',$room_status,$avail,$hostelid);
                            $room_to_select->execute();
                            $rooms=$room_to_select->get_result();
                            $count= $rooms->num_rows;
                            if($count>0){
                            while($row=$rooms->fetch_assoc()){
                                $gothostel=$row['hostelName'];
                                $room_name=$row['roomname'];
                                $room_image=$row['roomImage1'];
                                ?>
                                <div class="room-container">
                                    <a href="room-details.php?roomid=<?php echo $row['id']?>">
                                        
                                        <img  class="room-image" src="<?php echo "../ADMIN/images/hostels/$gothostel/$room_name/$room_image"  ?>" onerror="this.src='../ADMIN/images/images/noimageavailable.png'">
                                        <div class="room-title"><?php echo htmlentities($row['hostelName']);?></div>
                                        <div class="room-title"><?php echo htmlentities($row['roomname']);?> </div>
                                        <div class="room-price">
                                            <b>SH.<?php echo htmlentities($row['roomprice']);?></b>                                    
                                        </div>
                                    </a>
                                </div>
                            <?php }
                            }
                            else{ ?>
                            <div class="room-title"> No rooms available</div>
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