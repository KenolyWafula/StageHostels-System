<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();

date_default_timezone_set('Africa/Nairobi');
$currentTime = date( 'd-m-Y h:i:s A', time () );

if(isset($_POST['submit'])){
    $oldpassword=$_POST['oldpassword'];
    $New=$_POST['newpassword'];
    $confirmpass=$_POST['confirmpassword'];
    $adminid=$_SESSION['adminlogin'];

    $sql="SELECT password,id FROM  admin where password=? AND id=?";
    $stmt=$con->prepare( $sql);
    $stmt->bind_param('si',$oldpassword,$adminid);
    $stmt->execute();
    $stmt->store_result();
    $adminoldpass=$stmt->fetch();
    $row_cnt=$stmt->num_rows;
	if($row_cnt>0){
        if($New!=$confirmpass){
            $_SESSION["error"]="New Password | Confirm New Password Do Not Match";
            Redirect_to("changepass.php");
        }
        else{
            $update="UPDATE admin set password=?, updationDate=? where id=?";
            $updatepass=$con->prepare( $update);
            $updatepass->bind_param('ssi',$New,$currentTime,$adminid);
            $updatepass->execute();
            if($updatepass){
                $_SESSION["success"]="Password Changed Succesfully";
                Redirect_to("student-todays-bookings.php");
            }else{ 
                $_SESSION["error"]="Password Not Changed.Something Went Wrong!!";
                Redirect_to("changepass.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | CHANGE PASSWORD</title>
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">    
    <link rel="shortcut icon" href="images/stagehostelicon.ico">
</head>
<body>
    <header>
        <?php include('includes/header.php')?>
    </header>
    <div class="adminbody">
        <div class="container-fluid">
            <div class="row">
                <div class="thesidemenu">
                    <?php include("includes/admin-menubar.php")?>
                </div>
                <div class="col-md-8">
                    <div class="stage">
                        <div class="stage-head">
                            <h3><b>CHANGE PASSWORD</b></h3>
                        </div>
                        <?php echo message();?>
                        <?php echo success();?>
                        <div class="stage-body">
                            <form method="POST" name="changepassword">
                                <div class="form-group mypass">
                                    <label class="labelinfo" for="oldpass">OLD PASSWORD</label>
                                    <input  class="form-control" id="mypassword" type="password" name="oldpassword" placeholder="Enter Old Password" required>
                                     <i toggle="#mypassword" class="fa fa-eye show-password" ></i> 
                                </div>
                                <div class="form-group mypass">
                                    <label class="labelinfo" for="newpass">NEW PASSWORD</label>
                                    <input class="form-control" id="mynewpassword" type="password" name="newpassword" placeholder="Enter New Password" required
    
                                    >
                                    <i toggle="#mynewpassword" class="fa fa-eye show-password" ></i> 
                                </div>
                                <div class="form-group mypass">
                                    <label class="labelinfo" for="confirmpass">CONFIRM NEW PASSWORD</label>
                                    <input  class="form-control" id="confirmpassword" type="password" name="confirmpassword" placeholder="Re-type password" required>
                                    <i toggle="#confirmpassword" class="fa fa-eye show-password" ></i> 
                                </div>
                                <div class="form-group">
                                    <button class="btn submit-button btn-info" type="submit" name="submit">Change Password</button>
                                </div>  
                            </form>
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
    <?php include('includes/admin-notification-container.php')?> 
</body>
</html>
