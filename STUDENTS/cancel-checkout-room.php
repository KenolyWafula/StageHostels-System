<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];
date_default_timezone_set('AFRICA/NAIROBI');
$deadl_id=$_GET['id'];
$has_expired=1;
$removeowner=0;
$room_made_available='available';
$deadline_query="UPDATE studentroombook SET roomownership=?,isExpired=?, CompletionStatus=? WHERE id=? AND registrationNo=?  ";
$deadline_failed=$con->prepare($deadline_query);
$deadline_failed->bind_param('iiiis',$removeowner,$has_expired,$has_completed,$deadl_id,$studentid);
$stud_remove=$deadline_failed->execute();
   
$room_ownership_revoke="SELECT studentroombook.bookedroomid,room.roomavailability,studentroombook.roomownership FROM `studentroombook` join room on room.id=studentroombook.bookedroomid WHERE studentroombook.id=? AND studentroombook.isExpired=? AND studentroombook.CompletionStatus=? AND room.roomavailability!=? AND studentroombook.roomownership=? AND studentroombook.registrationNo=?";
$revoking = $con->prepare($room_ownership_revoke);
$revoking ->bind_param('iiisis',$deadl_id,$has_expired,$removeowner,$room_made_available,$removeowner,$studentid);
$revoking ->execute();
$revoked_room=$revoking->get_result();
while($sroomrevok=$revoked_room->fetch_assoc()){
  $theroom=$sroomrevok['bookedroomid'];
  $status=$sroomrevok['roomavailability'];
  $revokedownership=$sroomrevok['roomownership'];
  if($status!== $room_made_available AND $revokedownership==$removeowner){
    $revoke_no="UPDATE room SET roomavailability=? WHERE id=? ";
    $revoke_success=$con->prepare($revoke_no);
    $revoke_success->bind_param('si',$room_made_available,$theroom);
    $romm_remove=$revoke_success->execute();
  }
  if($stud_remove AND $romm_remove){
    $readstatus=0;   
    $currenttime= date('Y-m-d H:i:s',time() );
    $dissapoint="You have successfully cancelled your booking";

    $notify_cancel="INSERT INTO studentnotifications(studregNo,sentmessage,readstatus,notificationDate,studentoverview )VALUES(?,?,?,?,?)";
    $cancelled = $con->prepare($notify_cancel);
    $cancelled->bind_param('ssisi',$studentid,$dissapoint,$readstatus,$currenttime,$readstatus);
    $don3=$cancelled->execute();
    $_SESSION["error"]="Your Booking Has Been Cancelled";
    Redirect_to("booked-room-details.php");
  }else{ 
    $_SESSION["error"]="Cancelled Something Went Wrong";
  }

}

?>