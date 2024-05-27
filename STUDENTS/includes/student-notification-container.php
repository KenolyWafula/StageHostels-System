<a href="student-notifications.php" class="notification">
  <span class="notification-icon"><i class="fa fa-bell"></i></span>
  <span class="number"></span>             
</a>

<script>
  $(document).ready(function(){
    // updating the view with notifications using ajax
    function load_unseen_notification(view = ''){
      $.ajax({
        url:"includes/student-get-notifications.php",
        method:"POST",
        data:{view:view},
        dataType:"json",
        success:function(data)
        {
          if(data.unseen_notification > 0){
            $('.number').html(data.unseen_notification);
          }
        }
      });
    }
    load_unseen_notification();
    // load new notifications
    $(document).on('click', '.notification', function(){
      $('.number').html('');
      load_unseen_notification('yes');
      });
      setInterval(function(){
       load_unseen_notification();
      }, 3000);
  });

</script>