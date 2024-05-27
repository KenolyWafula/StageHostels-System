<?php
require('dbconnection.php');
date_default_timezone_set('Africa/Nairobi');
//retrieve students who have not paid
$payment_status='paid';
$room_own=1;
$room_revoked=1;
$has_completed=0;
$sql="SELECT * FROM studentroombook WHERE payment!=? AND roomownership=? AND isExpired=? AND CompletionStatus=? ";
$student_notpaid=$con->prepare( $sql);
$student_notpaid->bind_param('siii',$payment_status,$room_own,$has_completed,$has_completed);
$student_notpaid->execute();
$students=$student_notpaid->get_result();
while($Rows=$students->fetch_assoc())
{

  $regist_No=$Rows['registrationNo'];
  $deadl_id=$Rows['id'];
  $expiry=new DateTime($Rows['ExpiryTime']);
  $started=new DateTime($Rows['StartingTime']);
  $myexpirydt=$expiry->format('Y-m-d H:i:s');
  $mystartingdt=$started->format('Y-m-d H:i:s');
  $today=new DateTime();
  $nowtime=$today->format('Y-m-d H:i:s');
  $is_started_sec=strtotime($mystartingdt);
  $is_ended=strtotime($myexpirydt);
  $today_sec=strtotime($nowtime);
  $deadline_valid=$is_ended-$today_sec;
  $rem_mins=floor($deadline_valid/(60));
  
  
  if(($rem_mins>=59)AND ($rem_mins<=60)){
    $readstatus=0;
    $admoverview=0;
 
    $currenttime= date('Y-m-d H:i:s',time() );
    $reg_number=$Rows['registrationNo'];
    $mymessage="You are reminded that you have less than<b> 1 hour</b> remaining to pay for your room";
//Insert a notification into the students platform
$student_notification="INSERT INTO `studentnotifications` (studregNo,sentmessage,readstatus,notificationDate,studentoverview)
   VALUES(?,?,?,?,?)";
   $stmt = $con->prepare($student_notification);
   $create=$stmt->bind_param('ssisi',$reg_number,$mymessage,$readstatus,$currenttime,$readstatus);
   $message_sent_to_student=$stmt->execute();

   
//select Admins that are available
$myadmin="SELECT id FROM admin ";
$admins=$con->prepare( $myadmin);
$admins->execute();
$alladmins=$admins->get_result();
while($systadmin=$alladmins->fetch_assoc())
{
    date_default_timezone_set('Africa/Nairobi');
    $admintime= date('Y-m-d H:i:s',time() );
    $adminidentity=$systadmin['id'];
    $read=0;
    $admoverview=0;
  if($message_sent_to_student){
 //To Notify Admin That Message Was Sent To Student
 $adminmsg="Payment Notification Sent To $reg_number On $currenttime";
 $admin_notification="INSERT INTO `AdminNotifications` (adminid,receiverstudregNo,adminmessage,adminreadstatus,adminnotificationDate,admnoverview)
   VALUES(?,?,?,?,?,?)";
   $admin_notify = $con->prepare($admin_notification);
   $admin_notify->bind_param('issisi',$adminidentity,$reg_number,$adminmsg,$read,$admintime,$read);
   $admin_notify->execute();
  }
   else{
    $adminmsgfail="Something Wrong With The Systems Regular Notifications";
    $failedadmin_notification="INSERT INTO `AdminNotifications` (adminid,receiverstudregNo,adminmessage,adminreadstatus,adminnotificationDate,admnoverview)
    VALUES(?,?,?,?,?,?)";
    $admin_failnotify = $con->prepare( $failedadmin_notification);
    $admin_failnotify->bind_param('issisi',$adminidentity,$my_studreg_number,$adminmsgfail,$read,$admintime,$read);
    $admin_failnotify->execute();
   }
}

}

   if($deadline_valid<=0){
      $readstatus=0;   
      $currenttime= date('Y-m-d H:i:s',time() );
      $dissapoint="Please note that you have failed to complete the payment deadline as required. <br>Your room was revoked.";   
      $deadline_failed="INSERT INTO `studentnotifications` (studregNo,sentmessage,readstatus,notificationDate,studentoverview)VALUES(?,?,?,?,?)";
      $failed = $con->prepare( $deadline_failed);
      $failed->bind_param('ssisi',$regist_No,$dissapoint,$readstatus,$currenttime,$readstatus);
      $failed->execute();
      $has_expired=1;
      $removeowner=0;
      $room_made_available='available';
      $deadline_query="UPDATE studentroombook SET roomownership=?,isExpired=?,CompletionStatus=? WHERE id=? ";
      $deadline_failed=$con->prepare($deadline_query);
      $deadline_failed->bind_param('iiii',$removeowner,$has_expired,$has_completed,$deadl_id);
      $deadline_failed->execute();   
      $room_ownership_revoke="SELECT studentroombook.bookedroomid,room.roomavailability,studentroombook.roomownership FROM `studentroombook` join room on room.id=studentroombook.bookedroomid WHERE studentroombook.isExpired=? AND studentroombook.CompletionStatus=? AND room.roomavailability!=? AND studentroombook.roomownership=? ";
      $revoking = $con->prepare($room_ownership_revoke);
      $revoking ->bind_param('iisi',$has_expired,$removeowner,$room_made_available,$removeowner);
      $revoking ->execute();
      $revoked_room=$revoking->get_result();
      while($sroomrevok=$revoked_room->fetch_assoc())
       {
          $theroom=$sroomrevok['bookedroomid'];
          $status=$sroomrevok['roomavailability'];
          $revokedownership=$sroomrevok['roomownership'];     
          if($status!== $room_made_available AND $revokedownership==$removeowner){
             $revoke_no="UPDATE room SET roomavailability=? WHERE id=? ";
             $revoke_success=$con->prepare($revoke_no);
             $revoke_success->bind_param('si',$room_made_available,$theroom);
             $revoke_success->execute();
         } 
      }
 
  }
}
?>