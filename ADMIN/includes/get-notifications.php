<?php
session_start();
include('../../DbConnection/dbconnection.php');
$readstat=0;
$adminid=$_SESSION['adminlogin'];



if(isset($_POST['view'])){

  
   
   if($_POST["view"] != '')
   
   {
      $mymessage_overview=1;
      $update_notoficationstatus="UPDATE AdminNotifications SET admnoverview=? WHERE adminid=? AND adminreadstatus=? AND admnoverview=? ";
      $notification_updated=$con->prepare($update_notoficationstatus);
      $notification_updated->bind_param('iiii',$mymessage_overview,$adminid,$readstat,$readstat);
      $notification_updated->execute(); 
   }


$status_query = "SELECT * FROM AdminNotifications where adminid=? AND adminreadstatus=? AND admnoverview=? ";

$admin_notify=$con->prepare($status_query);
$admin_notify->bind_param('iii',$adminid,$readstat,$readstat);
$admin_notify->execute();
$admin_notify->store_result();
$total_notifications= $admin_notify->num_rows;


$data = array(
   'unseen_notification' => $total_notifications,
);

echo json_encode($data);

}

?>