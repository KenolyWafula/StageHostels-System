<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
$myhostel=$_GET['myhostid'];

$rumstat=0;
if(isset($_GET['del'])){
  $myroom=$_GET['rumid'];
  $roomdelete="UPDATE room  SET roomStatus=? WHERE id=?";
  $delete=$con->prepare($roomdelete);
  $delete->bind_param('ii',$rumstat,$myroom);
  $delete->execute(); 
  if($delete){
    $_SESSION["error"]="Room Deleted Succcesfully";
  }else{ 
    $_SESSION["error"]="Room Not Deleted Something Went Wrong";
    Redirect_to("manage-rooms.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN | MANAGE ROOMS</title>
  <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
  <link rel="shortcut icon" href="IMAGES/stagehostelicon.ico">
</head>
<body class="managements">
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
              <h3><b>MANAGE ROOMS</b></h3>
            </div>
            <?php echo message();?>
            <?php echo success();?>
            <div class="stage-body">
              <table class="kenolykovitable dataTable table table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Hostel name </th>
                    <th>Room Name</th>
                    <th>Creation Date</th>
                    <th>Last Updated</th>
                    <th>Edit Room</th>
                    <th>Delete Room</th>
							    </tr>
                </thead>
                <tbody>
                  <?php
                  $room_status=1;
                  $query="SELECT room.id,hostel.hostelName,room.roomname,room.creationDate,room.updationDate from room join hostel on hostel.id=room.hostelid  WHERE room.hostelid=? AND room.roomStatus=? ORDER BY roomname ASC";                  $room_to_select=$con->prepare($query);
                  $room_to_select->bind_param('ii',$myhostel,$room_status);
                  $room_to_select->execute();
                  $rooms=$room_to_select->get_result();
                  $cnt=1;
                 

                  while($row=$rooms->fetch_assoc()){ 
                    $hostelName=$row['hostelName'];
                    $roomname=$row['roomname'];
                    $creationDate=$row['creationDate'];
                    $updationDate=$row['updationDate'];

                    ?>									
                    <tr>
                      <td><?php echo htmlentities($cnt);?></td>
                      <td><?php echo htmlentities($hostelName);?></td>
                      <td><?php echo htmlentities($roomname);?></td>
                      <td> <?php echo htmlentities($creationDate);?></td>
                      <td><?php echo htmlentities($updationDate);?></td>
                      <td><a href="edit-rooms.php?id=<?php echo $row['id']?>" ><i class=" fa fa-edit"></i></a></td>
                      <td><a href="manage-rooms.php?myhostid=<?php echo $myhostel?>&& rumid=<?php echo $row['id']?> &del=delete" onClick="return confirm('Are you sure you want to delete <?php echo htmlentities($row['roomname']);?>?')"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php $cnt=$cnt+1; 
                  } ?> 
                </tbody>
              </table>
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
  <script src="../STYLES\DATATABLES\datatables.js" type="text/javascript"></script>
  <?php include('includes/admin-notification-container.php')?>
</body>
</html>