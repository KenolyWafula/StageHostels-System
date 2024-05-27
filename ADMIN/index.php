<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
if(isset($_POST["submit"])){


    $username=$_POST['adminusername'];
    $password=$_POST['adminpass'];
    $sql="SELECT id, username, password FROM admin WHERE username=? AND password=?";
    $stmt=$con->prepare( $sql);
    $stmt->bind_param('ss',$username,$password);
    $stmt->execute();
    $stmt -> bind_result($id,$username,$password);
    $admin=$stmt->fetch();
    if($admin){
        $_SESSION["success"]="Login Succesfull";
        $_SESSION['adminlogin']=$id;
        Redirect_to("changepass.php");

    } else{
        $_SESSION["error"]="Check Your Details!!";
        Redirect_to("index.php");
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | LOGIN</title>
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/stagehostelicon.ico">   
</head>
<body class="loginpage">
<header>
<?php include('includes/header.php')?>
</header>
    <div class="adminbody">
        <div class="container-fluid">
            <img class="mylogo" src="images/stagehostelicon.ico" alt="Stage Hostel System" width="102" height="72">
            <div class="stage">
           
                <div class="stage-head">
                    <h3><b>LOG IN</b></h3>
                </div>
                <?php echo message();?>
                <?php echo success();?>
                <div class="stage-body">
                    <form method="POST" class="loginform">
                        <div class="form-group">
                            <label for="username" class="labelinfo">USERNAME</label>
                            <input class="form-control" type="text" name="adminusername" placeholder="Enter Your Username" required>
                        </div>
                        <div class="form-group mypass">
                            <label for="username" class="labelinfo">PASSWORD</label>
                            <input class="form-control" id="mypassword" type="password" name="adminpass" placeholder="Enter Your Password" required>
                            <i toggle="#mypassword" class="fa fa-eye show-password" ></i> 
                        </div>
                        <button class="btn submit-button btn-info" type="submit" name="submit">Login</button>
                    </form>
                </div>
            </div>          
        </div>        
    </div>
    <?php include("includes/footer.php")?>    
    <script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
    <script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
    <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
</body>
</html>