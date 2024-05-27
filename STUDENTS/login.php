<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
if(isset($_POST['submit'])){
  $regno=$_POST['regno'];
	$password=$_POST['password'];
  $stud_details="SELECT regNo,password FROM students WHERE regNo=? AND password=?";
  $stmt=$con->prepare($stud_details);
  $stmt->bind_param('ss',$regno,$password);
  $stmt->execute();
  $student=$stmt->fetch();
  
  if($student){
    $_SESSION['mystudentid']=$regno;
    $_SESSION["success"]=" Succesfully Logged In";
    Redirect_to('index.php');
  }else{
    $_SESSION["error"]="Check Your User Credential";
  }
}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STUDENT | LOG IN</title>
	<link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
  <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
  <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
  <link rel="shortcut icon" href="../ADMIN/images/stagehostelicon.ico">
</head>
<body>
  <header>
    <?php include('includes/header.php')?>
  </header>
  <div class="adminbody">
    <div class="container-fluid">
      <div class="row">
        <div class="thesidemenu">
        <?php include("includes/student-menu-bar.php") ?>
        </div>
        <div class="col-md-8">
          <div class="stage">
            <div class="stage-head">
              <h3><b>LOG IN</b></h3>
            </div>
            <?php echo message(); ?>
            <?php echo success();?>
            <div class="stage-body">
              <form method="POST">
                <div class="form-group">
                  <label class="labelinfo">REGISTRATION NUMBER:</label>
                  <input class="form-control" type="text" name="regno" placeholder="Enter Registration Number" required>	
                </div>
                <div class="form-group mypass" >
                  <label class="labelinfo">PASSWORD:</label>
                  <input class="form-control" id="mypassword" type="password" name="password" placeholder="Enter Your Password" required>	
                  <i toggle="#mypassword" class="fa fa-eye show-password" ></i> 
                </div>
                <div class="form-group">
                  <button class="btn submit-button btn-info" type="submit" name="submit">Log In</button>
                </div>
              </form>
              <p>New Student <a href="sign-up.php">Sign Up Here</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("includes/footer.php")?>
  <script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
  <script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
  <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
  <?php if(isset($_SESSION['mystudentid'])){	
    include('includes/student-notification-container.php');
  }
  ?>  
</body>
</html>