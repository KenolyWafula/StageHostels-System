<div class="notification-content" id="previous_notif"> 
  <?php
  $nowdate=new DateTime();
  $todayDate=$nowdate->format('Y-m-d');
  $querydate1=$nowdate->format('Y-m-d 00:00:00');
  $yesterday=new DateTime();

  $onedayperiod=new DateInterval('P1D');
  $yesterday->sub($onedayperiod);
  $date_yesterday=$yesterday->format('Y-m-d');
  $querydate3=$yesterday->format('Y-m-d 00:00:00');
  $todayDate=$nowdate->format('Y-m-d');

  $adminid=$_SESSION['adminlogin'];
  $select_notifications="SELECT * FROM AdminNotifications where adminid=? AND adminnotificationDate<? ORDER BY adminnotificationDate DESC  ";
  $admin_previous_notify=$con->prepare($select_notifications);
  $admin_previous_notify->bind_param('is',$adminid,$querydate3);
  $admin_previous_notify->execute();
    
  $previous_notifications=$admin_previous_notify->get_result();
  $count= $previous_notifications->num_rows;
  if($count>0){ ?>
    <div class="dateTitle"> Previously </div>

    <?php
    while($myrow=$previous_notifications->fetch_assoc()){
      $notifDate=new DateTime($myrow['adminnotificationDate']);
      $did=$myrow['adminreadstatus'];
      $reading=1;
      $dt=$notifDate->format('Y-m-d');
      $mytime=$notifDate->format('M d ').'at'." ".$notifDate->format('h:i A ');
      if($date_yesterday!==$dt AND $todayDate!==$dt ){
        if($reading!==$did){ ?>
          <a class="notification-Text notification_unread" href="read-notification.php?mynotification=<?php echo $myrow['id']?>">
            <div class="notif">
              <?php  echo htmlentities($myrow['adminmessage']);?> <br>
              <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>
              <i class="fa fa-arrow-right place-right arrow"></i>
            </div>
          </a> 
        <?php }
        else{ ?>
          <a class="notification-Text notification_read" href="read-notification.php?mynotification=<?php echo $myrow['id']?>">
            <div class="notif"> <?php  echo htmlentities($myrow['adminmessage']);?><br>
              <i class="fa fa-arrow-right place-right arrow"></i>
              <span class=notificationTime>  <?php  echo htmlentities($mytime);?></span>        
            </div>
          </a> 
        <?php
        }
      }
    } 
  }
  ?>   
</div> 