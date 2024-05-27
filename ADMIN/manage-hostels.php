<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();

if(isset($_GET['del'])){
  $hostid=$_GET['id'];
  $status=0;
  $deleted="UPDATE hostel SET hostelStatus=? WHERE id=?";
  $delete=$con->prepare($deleted);
  $delete->bind_param('ii',$status,$hostid);
  $delete->execute();  

  $room_to_delete="UPDATE room SET roomstatus=? WHERE hostelid=?";
  $roomdelete=$con->prepare($room_to_delete);
  $roomdelete->bind_param('ii',$status,$hostid);
  $roomdelete->execute();  

  if($delete && $roomdelete){
    $_SESSION["success"]="Hostel And Corresponding Rooms Deleted";
  }else{ 
    $_SESSION["error"]="Hostel Not Deleted Something Went Wrong";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ADMIN | MANAGE HOSTELS</title>
  <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/DATATABLES/datatables.css" rel="stylesheet"> 
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
              <h3><b>MANAGE HOSTELS</b></h3>
            </div>
            <?php echo message();?>
            <?php echo success();?>
            <div class="stage-body">
              <table class="kenolykovitable dataTable table table-striped table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Hostel Name</th>
                    <th>Location</th>
                    <th>Caretaker</th>
                    <th>careTaker Number</th>
                    <th>Creation date</th>
                    <th>Updated On</th>
                    <th>Edit </th>
                    <th>Delete </th>
                    <th>Rooms</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $hosts_status=1;
                  $query="SELECT * from hostel WHERE hostelStatus=?";
                  $cnt=1;
                  $hostel_to_select=$con->prepare($query);
                  $hostel_to_select->bind_param('i',$hosts_status);
                  $hostel_to_select->execute();
                  $hostels=$hostel_to_select->get_result();
                  while($row=$hostels->fetch_assoc()){
                    $id=$row['id'];
                    $hostelname=$row['hostelName'];
                    $hostellocation=$row['hostelLocation'];
                    $hostelCaretaker=$row['hostelCaretaker'];
                    $careTakerContact=$row['careTakerContact'];
                    $creationDate=$row['creationDate'];
                    $updationDate=$row['updationDate'];
                    
                    
                    ?>									
                    <tr>
                      <td><?php echo htmlentities($cnt);?></td>
                      <td><?php echo htmlentities($hostelname);?></td>
                      <td><?php echo htmlentities($hostellocation);?></td>
                      <td><?php echo htmlentities($hostelCaretaker);?></td>
                      <td><?php echo htmlentities($careTakerContact);?></td>
                      <td> <?php echo htmlentities($creationDate);?></td>
                      <td><?php echo htmlentities($updationDate);?></td>
                      <td><a href="edit-hostels.php?id=<?php echo $id?>" ><i class=" fa fa-edit"></i></a></td>
                      <td><a href="manage-hostels.php?id=<?php echo $id?>&del=delete"  onClick="return confirm('Are you sure you want to delete <?php echo htmlentities($row['hostelName']);?> And Its Rooms?')"><i class="fa fa-trash"></i></a></td>
                      <td><a href="manage-rooms.php?myhostid=<?php echo $id?>"><i class="fa fa-bed"></i></a>
                    </tr>
                    <?php $cnt=$cnt+1; 
                  }?>
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
  <script src="../STYLES/DATATABLES/datatables.js" type="text/javascript"></script>
  <?php include('includes/admin-notification-container.php')?>
</body>
</html>