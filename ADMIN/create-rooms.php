<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
date_default_timezone_set('Africa/Nairobi');
$current_time= date('Y-m-d H:i:s',time() );
if(isset($_POST["submit"])){
	$hostel_id=$_POST["hostel-name"];
	$room_name=$_POST["room-name"];
	$room_rent=$_POST["room-price"];
	$room_image=$_FILES["room-image"]["name"];
  $room_status=$_POST["room-status"];
  $roomstatus=1;
  $sql="SELECT id,hostelName,hostelStatus FROM hostel WHERE id=?";
  $stmt=$con->prepare( $sql);
  $stmt->bind_param('i',$hostel_id);
  $stmt->execute();
  $hostel_retrieved=$stmt->get_result();
  $thehost= $hostel_retrieved->fetch_assoc();
  $gothostel=$thehost['hostelName'];

	$dir="images/hostels/$gothostel/$room_name";
	if(!is_dir($dir)){
		mkdir($dir);
	}

  $image_created=move_uploaded_file($_FILES["room-image"]["tmp_name"],"images/hostels/$gothostel/$room_name/".$room_image);
  $create_room="INSERT INTO room(hostelid, roomname,roomprice,roomImage1,creationDate,roomavailability,roomstatus) VALUES(?,?,?,?,?,?,?)";
	$the_room_created=$con->prepare($create_room);
  $the_room_created->bind_param('isisssi',$hostel_id,$room_name,$room_rent,$room_image,$current_time,$room_status,$roomstatus);
  $new_room=$the_room_created->execute();

  if($new_room&& $image_created){
    $_SESSION["success"]="{$_POST["room-name"]} of $gothostel Created";
  }else{ 
      $_SESSION["error"]="Room Not Created Something Went Wrong";
      Redirect_to("create-rooms.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>ADMIN | CREATE ROOMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/DATATABLES/datatables.css" rel="stylesheet"> 
  <link rel="shortcut icon" href="images/stagehostelicon.ico"> 
</head>
<body>
  <header>
    <?php include('includes/header.php')?>
  </header>
  <div class="adminbody">
    <div class="container-fluid">
      <div class="row">
        <div class="thesidemenu">
          <?php include("includes/admin-menubar.php") ?>
        </div>
        <div class="col-md-8">
          <div class="stage">
            <div class="stage-head">
              <h3><b>CREATE ROOMS</b></h3>
            </div>
            <?php echo message();?>
            <?php echo success();?>
            <div class="stage-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label   class="labelinfo" for="hostel-name">HOSTEL NAME:</label>
                  <select class="form-control" name="hostel-name" required>
                    <option value="">SELECT HOSTEL:</option>
                    <?php
                    $stat=1;
                    $select_your_hostel="SELECT id,hostelName FROM hostel WHERE hostelStatus=? ORDER BY hostelName ASC";
                    $hostel_to_select=$con->prepare($select_your_hostel);
                    $hostel_to_select->bind_param('i', $stat);
                    $hostel_to_select->execute();
                    $hostel_choice=$hostel_to_select->get_result();
                    while($Rows=$hostel_choice->fetch_assoc()){
                      $host_id=$Rows["id"];
                      $host_name=$Rows["hostelName"];
                      ?>
                      <option value="<?php echo $host_id ?>"><?php echo $host_name?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="room-name">ROOM NAME:</label>
                  <input type="text" class="form-control" name="room-name" placeholder="Enter Room Name" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="room-price">ROOM RENT:</label>
                  <input type="number" class="form-control" name="room-price" placeholder="Enter Room Rent" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="room-price">Select Room Status:</label>
                  <select name="room-status" class="form-control"  title="Select whether room is available for booking or not">
                    <option value="">Select Room Status</option>
                    <option value="available"title="Room Available For Booking">Available</option>
                    <option value="notavailable" title="Room Not Available For Booking">Not Available</option>
                  </select>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="room-image">ROOM IMAGE:</label>
                  <input type="file" class="form-control" name="room-image" required>
                </div>
                <div class="form-group">
                  <button class="btn submit-button btn-info" type="submit" name="submit">Create Rooms</button>
                </div>
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
  <?php include('includes/admin-notification-container.php')?> 
</body>
</html>