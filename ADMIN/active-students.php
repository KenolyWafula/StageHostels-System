<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | ACTIVE STUDENTS</title>
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
    <link rel="shortcut icon" href="IMAGES/stagehostelicon.ico">
</head>
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
                            <h3><b>STUDENTS BOOKED</b></h3>
                        </div>
                        <?php echo message();?>
                        <?php echo success();?>
                        <div class="stage-body">
                            <table class="kenolykovitable dataTable table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>  #</th>
                                        <th> Name</th>
                                        <th>Reg NO</th>
                                        <th>Contact</th>
                                        <th>Hostel</th>
                                        <th>Room Name</th>
                                        <th>Booking Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $payment_status='paid';
                                    $Status='occupied';
                                    $room_mine=1;
                                    $paid_students="SELECT students.fullname,students.regNo, students.contactno,hostel.hostelName,room.roomname,studentroombook.bookingDate,studentroombook.id,studentroombook.moveStatus from studentroombook join students on  studentroombook.registrationNo=students.regNo join room on room.id=studentroombook.bookedroomid join hostel on room.hostelid=hostel.id WHERE studentroombook.payment=? AND studentroombook.moveStatus=? AND studentroombook.roomownership=?";
                                    $serial=0;
                                    $student_in_session=$con->prepare($paid_students);
                                    $student_in_session->bind_param('ssi',$payment_status,$Status,$room_mine);
                                    $student_in_session->execute();
                                    $students=$student_in_session->get_result();
                                    while($Rows=$students->fetch_assoc()){
                                        $Name=$Rows['fullname'];
                                        $reg_number=$Rows['regNo'];
                                        $phone_number=$Rows['contactno'];
                                        $host_name=$Rows['hostelName'];
                                        $nameof_room=$Rows['roomname'];
                                        $book_date=$Rows['bookingDate'];
                                        $booking_statusid=$Rows['id'];
                                        $serial++;
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($serial);?></td>
                                            <td><?php echo htmlentities($Name);?></td>
                                            <td><?php echo htmlentities($reg_number);?></td>
                                            <td><?php echo htmlentities($phone_number);?></td>
                                            <td><?php echo htmlentities($host_name);?></td>
                                            <td><?php echo htmlentities($nameof_room);?></td>
                                            <td><?php echo htmlentities($book_date);?></td>
                                            <td><a href="student-update-room-booking.php?bkid=<?php echo htmlentities($booking_statusid);?>" title="Update Move Status" target="_blank"><i class=" fa fa-user-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?> 
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
    <script src="../STYLES/DATATABLES/datatables.js" type="text/javascript"></script>
    <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
    <?php include('includes/admin-notification-container.php')?>  
</body>
</html>