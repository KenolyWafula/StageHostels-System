<?php
session_start();
$_SESSION['mystudentid']=="";
session_unset();
$_SESSION['error']="You have successfully logout";
?>
<script language="javascript">
document.location="index.php";
</script>
