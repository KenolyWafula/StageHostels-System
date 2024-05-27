<div class="notification-content" id="today_notif">
  <?php
  $nowdate=new DateTime();
  $todayDate=$nowdate->format('Y-m-d');
  $querydate1=$nowdate->format('Y-m-d 00:00:00');
  $querydate2=$nowdate->format('Y-m-d 23:59:59');
  $adminid=$_SESSION['adminlogin'];

  $select_notifications="SELECT * FROM AdminNotifications where adminid=? AND adminnotificationDate BETWEEN ? AND ? ORDER BY adminnotificationDate DESC  ";
  $admin_notify=$con->prepare($select_notifications);
  $admin_notify->bind_param('iss',$adminid,$querydate1,$querydate2);
  $admin_notify->execute();
  $notifications=$admin_notify->get_result();    
  $total_notifications= $notifications->num_rows;
  if($total_notifications>0){
    ?><div class="dateTitle"> Today </div>
    <?php
    while($row=$notifications->fetch_assoc()){
      $notifDate=new DateTime($row['adminnotificationDate']);
      $did=$row['adminreadstatus'];
      $reading=1;
      $dt=$notifDate->format('Y-m-d');
      if($todayDate===$dt){
        $mytime=  'Today'." ". 'at'." ".$notifDate->format('h:i A ');
        if($reading!==$did){ ?>
          <a class="notification-Text notification_unread" href="read-notification.php?mynotification=<?php echo $row['id']?>">
            <div> 
              <?php  echo htmlentities($row['adminmessage']);?> <br>
              <i class="fa fa-arrow-right place-right arrow"></i>
              <span class="notificationTime">  <?php  echo htmlentities($mytime);?></span>
            </div>
          </a> 
          <?php
        } 
          else{ ?>
            <a class="notification-Text notification_read" href="read-notification.php?mynotification=<?php echo $row['id']?>">
              <div class="notif">  <?php  echo htmlentities($row['adminmessage']);?> <br>
                <i class="fa fa-arrow-right place-right arrow"></i>
                <span class="notificationTime">  <?php  echo htmlentities($mytime);?></span>   
              </div>
            </a> 
          <?php
          }
      }
    }
  }?>

</div>
