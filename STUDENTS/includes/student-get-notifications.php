<?php
session_start();
include('../../DbConnection/dbconnection.php');
$readstat=0;
$studentid=$_SESSION['mystudentid'];
if(isset($_POST['view'])){
   if($_POST["view"] != '')
   
   {
      $mymessage_overview=1;
      $update_notoficationstatus="UPDATE studentnotifications SET studentoverview=? WHERE studregNo=? AND readstatus=? AND studentoverview=? ";
      $notification_updated=$con->prepare($update_notoficationstatus);
      $notification_updated->bind_param('iiii',$mymessage_overview,$studentid,$readstat,$readstat);
      $notification_updated->execute(); 
   }

$status_query = "SELECT * FROM studentnotifications where studregNo=? and readstatus=? AND studentoverview=?";
$student__notify=$con->prepare($status_query);
$student__notify->bind_param('sii',$studentid,$readstat,$readstat);
$student__notify->execute();
$student__notify->store_result();
$total_notifications= $student__notify->num_rows;
$data = array(
   'unseen_notification' => $total_notifications,
);
echo json_encode($data);
}
?>