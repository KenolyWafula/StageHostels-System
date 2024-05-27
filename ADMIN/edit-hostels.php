<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
$id=$_GET['id'];
date_default_timezone_set('Africa/Nairobi');
$currenttime=date('Y-m-d H:i:s A', time());
if(isset($_POST['submit'])){
  $hostid=$id;
  $hostel_name=$_POST['hostelname'];
  $hostel_location=$_POST['hostellocation'];
  $room_description=$_POST['roomdescription'];
  $caretaker_name=$_POST['caretakername'];
  $caretaker_contact=$_POST['caretakercontact'];
  $hostStatus=1;
  $dir="images/hostels/$hostel_name";
  if(!is_dir($dir)){
    mkdir($dir);
  }  
  $edit_hostel="UPDATE hostel SET hostelName=?,hostelLocation=?,roomdescription=?,hostelCaretaker=?,careTakerContact=?,updationDate=? WHERE id=?";
  $edit=$con->prepare($edit_hostel);
  $edit->bind_param('ssssisi',$hostel_name,$hostel_location,$room_description,$caretaker_name,$caretaker_contact,$currenttime,$hostid);
  $edit->execute();  
  if($edit){
    $_SESSION["success"]="Hostel Updated";  
  }else{ 
    $_SESSION["error"]="Hostel Not Updated";
  }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN | UPDATE | HOSTELS</title>
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
          <?php include("includes/admin-menubar.php") ?>
        </div>
        <div class="col-md-8">
          <?php	
          $ret="select * from hostel where id=?";
          $stmt= $con->prepare($ret) ;
	        $stmt->bind_param('i',$id);
	        $stmt->execute() ;
	        $res=$stmt->get_result();
	        while($row=$res->fetch_object()){
            ?>
            <div class="stage">
              <div class="stage-head">
                <h3><b>Edit <?php echo $row->hostelName;?> HOSTEL</b></h3>
              </div>
              <?php echo message();?>
              <?php echo success();?>
              <div class="stage-body">
                <form method="POST" >
                  <div class="form-group">
                    <label  class="labelinfo" for="hostelname">HOSTEL NAME:</label>
                    <input  class="form-control" type="text" name="hostelname" placeholder="Enter Hostel Name"  value="<?php echo $row->hostelName;?>" required>
                  </div>
                  <div class="form-group">
                    <label  class="labelinfo" for="hostellocation">HOSTEL LOCATION:</label>
                    <input class="form-control" type="text" name="hostellocation" placeholder="Enter Location" Value="<?php echo $row->hostelLocation;?>" required>
                  </div>
                  <div class="form-group">
                    <label  class="labelinfo" for="roomdescription">ROOM DESCRIPTION:</label>
                    <input class="form-control" type="text" name="roomdescription" placeholder="Enter Room Description" value="<?php echo $row->roomdescription;?>" required>
                  </div>
                  <div class="form-group">
                    <label  class="labelinfo" for="caretakername">CARETAKER NAME:</label>
                    <input class="form-control" type="text" name="caretakername" placeholder="Enter Caretaker's Name"  value="<?php echo $row->hostelCaretaker;?>"  required>
                  </div>
                  <div class="form-group">
                    <label  class="labelinfo" for="caretakercontact">CARETAKER CONTACT:</label>
                    <input class="form-control" type="tel" name="caretakercontact" placeholder="Enter Caretaker's Contact" value="<?php echo $row->careTakerContact;?>"  required>
                  </div>
                  <div class="form-group">
                    <button class="btn submit-button btn-info" type="submit" name="submit">Edit Hostels</button>
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

