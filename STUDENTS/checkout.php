<?php
session_start();

require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];
date_default_timezone_set('AFRICA/NAIROBI');
$has_expired=1;
$removeowner=0;
$room_made_available='available';
$room_ownership_revoke="SELECT studentroombook.id,studentroombook.bookedroomid,room.roomavailability,studentroombook.roomownership FROM `studentroombook` join room on room.id=studentroombook.bookedroomid WHERE studentroombook.registrationNo=? AND studentroombook.roomownership=?";
$revoking = $con->prepare($room_ownership_revoke);
$revoking ->bind_param('si',$studentid,$has_expired);
$revoking ->execute();
$revoked_room=$revoking->get_result();
$count=$revoked_room->num_rows;
if($count>0){
while($sroomrevok=$revoked_room->fetch_assoc()){
  $theroom=$sroomrevok['bookedroomid'];
  $status=$sroomrevok['roomavailability'];
  $revokedownership=$sroomrevok['roomownership'];
  $deadl_id=$sroomrevok['id'];
  
  $revoke_no="UPDATE room SET roomavailability=? WHERE id=? ";
  $revoke_success=$con->prepare($revoke_no);
  $revoke_success->bind_param('si',$room_made_available,$theroom);
  $romm_remove=$revoke_success->execute();
  
  $deadline_query="UPDATE studentroombook SET roomownership=? WHERE id=? AND registrationNo=?  ";
  $deadline_failed=$con->prepare($deadline_query);
  $deadline_failed->bind_param('iis',$removeowner,$deadl_id,$studentid);
  $stud_remove=$deadline_failed->execute();

  if($stud_remove AND $romm_remove){
    $readstatus=0;   
    $currenttime= date('Y-m-d H:i:s',time() );
    $dissapoint="You have successfully Checked Out Of Your Room";

    $notify_cancel="INSERT INTO studentnotifications(studregNo,sentmessage,readstatus,notificationDate,studentoverview )VALUES(?,?,?,?,?)";
    $cancelled = $con->prepare($notify_cancel);
    $cancelled->bind_param('ssisi',$studentid,$dissapoint,$readstatus,$currenttime,$readstatus);
    $don3=$cancelled->execute();            
    $_SESSION["error"]="You Have Succesfully Checked Out Of Your Room";
    Redirect_to("booked-room-details.php");
  }else{ 
    $_SESSION["error"]="Not Succesful Something Went Wrong";
  }

}
}else{
  header('location:booked-room-details.php');
}

?>