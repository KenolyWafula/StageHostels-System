<div class="notification-content" id="yesterday_notif">
  <?php
  $yesterday=new DateTime();
  $onedayperiod=new DateInterval('P1D');
  $yesterday->sub($onedayperiod);
  $date_yesterday=$yesterday->format('Y-m-d');
  $yestdate1=$yesterday->format('Y-m-d 00:00:00');
  $yestdate2=$yesterday->format('Y-m-d 23:59:59');
  $adminid=$_SESSION['adminlogin'];
  $select_notifications="SELECT * FROM AdminNotifications where adminid=? AND adminnotificationDate BETWEEN ? AND ? ORDER BY adminnotificationDate DESC  ";
  $admin_yest_notify=$con->prepare($select_notifications);
  $admin_yest_notify->bind_param('iss',$adminid,$yestdate1,$yestdate2);
  $admin_yest_notify->execute();
  $yesterday_notifications=$admin_yest_notify->get_result();
  $yest_totnotif= $yesterday_notifications->num_rows;
  if($yest_totnotif>0){ ?>
    <div class="dateTitle"> Yesterday </div>
    <?php   
    while($myrow=$yesterday_notifications->fetch_assoc()){
      $notifDate=new DateTime($myrow['adminnotificationDate']);
      $did=$myrow['adminreadstatus'];
      $reading=1;
      $dt=$notifDate->format('Y-m-d');
      $mytime='Yesterday'." ".$notifDate->format('M d ').'at'." ".$notifDate->format('h:i A ');
      if($date_yesterday==$dt){
        if($reading!==$did){ ?>
          <a class="notification-Text notification_unread" href="read-notification.php?mynotification=<?php echo $myrow['id']?>">
            <div class="notif">
              <?php  echo htmlentities($myrow['adminmessage']);?> <br>
              <i class="fa fa-arrow-right place-right arrow"></i>
              <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>
            </div>
          </a> 
        <?php } 
        else{ ?>
          <a class="notification-Text notification_read" href="read-notification.php?mynotification=<?php echo $myrow['id']?>">
            <div class="notif">
              <?php  echo htmlentities($myrow['adminmessage']);?> <br>
              <i class="fa fa-arrow-right place-right arrow"></i>
              <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>
            </div>
          </a> 
        <?php
        }
      }
    }
  }?>
</div>