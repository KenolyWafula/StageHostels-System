<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT | ROOM DETAILS</title>
    <link type="text/css" href="../STYLES/css/students-style.css" rel="stylesheet">      
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet"> 
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	  <link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
    <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body class="managements">
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
                            <h3><b>BOOKED ROOMS</b></h3>
                        </div>                        <?php echo message();?>
                            <?php echo success();?>
                        <div class="stage-body">
                        <table class="kenolykovitable dataTable table table-striped                 table-hover">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Hostel</th>
                              <th>Room Name</th>
                              <th>Payment Status</th>
                              <th>Price</th>
                              <th>Move Status</th>
                              <th>Booking Date</th> 
                              <th>CareTaker Name </th>
                              <th>CareTaker Contact </th>                                                   
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $payment='paid';
                          $is_room_expr=1;
                          $is_completion=1;
                          $rumoccupy='occupied';
                          $i_own=1;
                          $query="SELECT hostel.hostelName,hostel.hostelCaretaker,hostel.careTakerContact,room.roomname,room.roomImage1,studentroombook.bookingDate,studentroombook.moveStatus,studentroombook.roomownership,studentroombook.registrationNo, studentroombook.bookedroomid,studentroombook.payment,studentroombook.amount from studentroombook join room on studentroombook.bookedroomid=room.id join hostel on hostel.id=room.hostelid WHERE
                          studentroombook.registrationNo=? ";
                          $booking_to_select=$con->prepare($query);
                          $booking_to_select->bind_param('s',$studentid);
                          $booking_to_select->execute();
                          $bookings=$booking_to_select->get_result();
                          $count=$bookings->num_rows;
                          $cnt=1;
                          while($row=$bookings->fetch_assoc())
                          {  
                          $room_named=$row['roomname'];
                          $room_image=$row['roomImage1'];
                          $host_name=$row["hostelName"];
                          $date=$row["bookingDate"];
                          $current_room_owned=$row["moveStatus"];
                          $room_price=$row["amount"];
                          $rum_payment=$row["payment"];
                          $caretaker=$row['hostelCaretaker'];
                          $caretakerNo=$row['careTakerContact'];
                            ?>
                          
                           <tr>
                           <td><?php echo htmlentities($cnt);?></td>
                           <td><?php echo htmlentities($host_name);?></td>
                           <td><?php echo htmlentities($room_named);?></td>
                           <td><?php echo htmlentities($rum_payment);?></td>
                           <td> SH.<?php echo htmlentities($room_price);?></td>
                           <td><?php echo htmlentities($current_room_owned);?></td>
                           <td><?php echo htmlentities($date);?></td>
                           <td><?php echo htmlentities($caretaker);?></td>
                           <td><?php echo htmlentities($caretakerNo);?></td>
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