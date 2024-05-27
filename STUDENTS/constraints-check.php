<?php

$studentid=$_SESSION['mystudentid'];
$roomowning=1;
$student_already_booked="SELECT registrationNo,roomownership FROM studentroombook WHERE registrationNo=? AND roomownership=?";
$student_has_booked_a_room=$con->prepare($student_already_booked);
$student_has_booked_a_room->bind_param('si',$studentid,$roomowning);
$student_has_booked_a_room->execute();
$mystud= $student_has_booked_a_room->fetch();
if($mystud){
 header('location:booked-room-details.php');
}
?>