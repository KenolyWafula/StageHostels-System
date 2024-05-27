<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
$rumid=$_GET['id'];
date_default_timezone_set('Africa/Nairobi');
$current_time= date('Y-m-d H:i:s A', time());
if(isset($_POST["submit"])){
	$hostel_id=$_POST["hostel-id"];
	$room_name=$_POST["room-name"];
	$room_rent=$_POST["room-price"];
  $room_status=$_POST["room-status"];
  $room_image=$_FILES["roomimage"]["name"];

	
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
  move_uploaded_file($_FILES["roomimage"]["tmp_name"],"images/hostels/$gothostel/$room_name/".$room_image);
  $edit_room="UPDATE room SET hostelid=?,roomname=?,roomprice=?,roomImage1=?,updationDate=?,roomavailability=? WHERE id=?";
  $edit=$con->prepare($edit_room);
  $edit->bind_param('isisssi',$hostel_id,$room_name,$room_rent, $room_image,$current_time,$room_status,$rumid);
  $edit->execute();  
  if($edit){
    $_SESSION["success"]="Room Updated";      
  }else{ 
    $_SESSION["error"]="Room Not Updated!!Something Went Wrong!!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN | UPDATE | ROOMS</title>
  <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet"> 
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
          <?php include("includes/admin-menubar.php");?>
        </div>
        <div class="col-md-8">
          <?php	
          $ret="select * from room where id=?";
	        $stmt= $con->prepare($ret) ;
	        $stmt->bind_param('i',$rumid);
	        $stmt->execute() ;
	        $res=$stmt->get_result();
	        while($row=$res->fetch_object()){ ?>
            <div class="stage">
              <div class="stage-head">
                <h3><b>Edit <?php echo $row->roomname?></b></h3>
              </div>
              <?php echo message();?>
              <?php echo success();?>
              <div class="stage-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label   class="labelinfo" for="hostel-name">HOSTEL NAME:</label>
                    <select name="hostel-id" class="form-control"  readonly>
                      <?php
                      $myhostelid=$row->hostelid;
                      $select_your_hostel="SELECT id,hostelName FROM hostel WHERE id=? ";
                      $hostel_to_select=$con->prepare($select_your_hostel);
                      $hostel_to_select->bind_param('i',$myhostelid);
                      $hostel_to_select->execute();
                      $hostel_choice=$hostel_to_select->get_result();    
                      while($Rows=$hostel_choice->fetch_assoc()){
                        $host_id=$Rows["id"];
                        $host_name=$Rows["hostelName"];
                        ?>
                        <option  value="<?php echo $host_id?>"><?php echo $host_name?> </option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group" enctype="multipart/form-data">
                    <label  class="labelinfo" for="room-name">ROOM NAME:</label>
                    <input type="text" class="form-control" name="room-name" value="<?php echo $row->roomname?>" placeholder="Enter Room Name" required>
                  </div>
                  <div class="form-group">
                    <label  class="labelinfo" for="room-price">ROOM RENT:</label>
                    <input type="number" class="form-control" name="room-price" value="<?php echo $row->roomprice?>"placeholder="Enter Room Rent" required>
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
                    <input type="file" class="form-control" name="roomimage" >
                  </div>
                  <div class="form-group">
                    <button class="btn submit-button btn-info" type="submit" name="submit">Edit Room</button>
                  </div>
                </form>
              </div>
            </div>
            <?php } ?>
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