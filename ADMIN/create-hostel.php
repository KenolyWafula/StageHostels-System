<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
date_default_timezone_set('Africa/Nairobi');
$creationTime= date('Y-m-d H:i:s',time() );
if(isset($_POST['submit'])){
  $hostel_name=$_POST['hostelname'];
  $hostel_location=$_POST['hostellocation'];
  $room_description=$_POST['roomdescription'];
  $caretaker_name=$_POST['caretakername'];
  $caretaker_contact=$_POST['caretakercontact'];
  $creationTime = date('Y-m-d H:i:s',time() );
  $hostStatus=1;
  $dir="images/hostels/$hostel_name";
  if(!is_dir($dir)){
    mkdir($dir);
    $create_new_hostel= "INSERT INTO `hostel` (hostelName,hostelLocation,roomdescription,hostelCaretaker,careTakerContact,creationDate,hostelStatus)VALUES(?,?,?,?,?,?,?)";
    $stmt = $con->prepare($create_new_hostel);
    $create=$stmt->bind_param('ssssisi',$hostel_name,$hostel_location,$room_description,$caretaker_name,$caretaker_contact,$creationTime,$hostStatus);
    $new_hostel_created=$stmt->execute();
    if($new_hostel_created){
      $_SESSION["success"]="Hostel Created";
      Redirect_to("create-rooms.php");
    }else{ 
      $_SESSION["error"]="Hostel Not Created";
      Redirect_to("create-hostel.php");
    }
  }
}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/DATATABLES/datatables.css" rel="stylesheet"> 
    <link rel="shortcut icon" href="images/stagehostelicon.ico">   
    <title>ADMIN | CREATE | HOSTELS</title>
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
              <h3><b>CREATE HOSTEL</b></h3>
            </div>
            <?php echo message();?>
            <?php echo success();?>
            <div class="stage-body">
              <form method="POST" >
                <div class="form-group">
                  <label  class="labelinfo" for="hostelname">HOSTEL NAME:</label>
                  <input  class="form-control" type="text" name="hostelname" placeholder="Enter Hostel Name" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="hostellocation">HOSTEL LOCATION:</label>
                  <input class="form-control" type="text" name="hostellocation" placeholder="Enter Location" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="roomdescription">ROOM DESCRIPTION:</label>
                  <input class="form-control" type="text" name="roomdescription" placeholder="Enter Room Description" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="caretakername">CARETAKER NAME:</label>
                  <input class="form-control" type="text" name="caretakername" placeholder="Enter Caretaker's Name" required>
                </div>
                <div class="form-group">
                  <label  class="labelinfo" for="caretakercontact">CARETAKER CONTACT:</label>
                  <input class="form-control" type="tel" name="caretakercontact" placeholder="Enter Caretaker's Contact" required>
                </div>
                <div class="form-group">
                  <button class="btn submit-button btn-info" type="submit" name="submit">Create Hostel</button>
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