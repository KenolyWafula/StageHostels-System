<div class="notification-content" id="today_notif">
  <?php
  $nowdate=new DateTime();
  $todayDate=$nowdate->format('Y-m-d');
  $querydate1=$nowdate->format('Y-m-d 00:00:00');
  $querydate2=$nowdate->format('Y-m-d 23:59:59');
  $studentid=$_SESSION['mystudentid'];
    $select_notifications="SELECT * FROM studentnotifications where studregNo=? AND notificationDate BETWEEN ? AND ?  ORDER BY notificationDate DESC  ";
    $student_notify=$con->prepare($select_notifications);
    $student_notify->bind_param('sss',$studentid,$querydate1,$querydate2);
    $student_notify->execute();
    $notifications=$student_notify->get_result();
    $total_notifications= $notifications->num_rows;
    if($total_notifications>0){
      ?><div class="dateTitle"> Today </div>
      <?php 
      while($row=$notifications->fetch_assoc()){
        $notifDate=new DateTime($row['notificationDate']);
        $did=$row['readstatus'];
        $reading=1;
        $dt=$notifDate->format('Y-m-d');
        if($todayDate===$dt){
          $mytime=  'Today'." ". 'at'." ".$notifDate->format('h:i A ');
          if($reading!==$did){ ?>
            <a class="notification-Text notification_unread" href="read-notification.php?mynotification=<?php echo $row['id']?>">
              <div>
                <?php  echo htmlentities($row['sentmessage']);?> <br>
                <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>
                <i class="fa fa-arrow-right place-right arrow"></i>
              </div>
            </a> 
          <?php } 
          else{ ?>
            <a class="notification-Text notification_read" href="read-notification.php?mynotification=<?php echo $row['id']?>">
              <div class=notif>  <?php  echo htmlentities($row['sentmessage']);?> <br>
                <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>
                <i class="fa fa-arrow-right place-right arrow"></i>
              </div>
            </a> 
          <?php }
        }
      }
    }?>
</div>
