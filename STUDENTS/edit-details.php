<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("../ADMIN/includes/session.php");
require_once("../ADMIN/includes/function.php");
studentcheck_login();
$studentid=$_SESSION['mystudentid'];
date_default_timezone_set('Africa/Nairobi');
$editTime= date('Y-m-d H:i:s',time() );
if(isset($_POST['submit'])){
	$regno=$_POST['regno'];
	$name=$_POST['fullname'];
	$yearofstudy=$_POST['yearofstudy'];
	$semesterofstudy=$_POST['semesterofstudy'];
	$email=$_POST['email'];
	$phonenumber=$_POST['phonenumber'];
	$password=$_POST['password'];
	$confirmpass=$_POST['confirmpass'];	
	$student_image=$_FILES["student-photo"]["name"];
	$dir="../ADMIN/images/studentImages/$email";
	if(!is_dir($dir)){
		mkdir($dir);
	}
	if($password!=$confirmpass){
		$_SESSION["error"]="Password | Confirm Password Do Not Match";
	}else{
		$image_created=move_uploaded_file($_FILES["student-photo"]["tmp_name"],"../ADMIN/images/studentImages/$email/".$student_image);
		$signup="UPDATE `students` SET yearofstudy=?,semester=?,email=?,contactno=?,password=?,photo=?,updationDate=? WHERE regNo=?";
		$student_signup= $con->prepare($signup);
		$student_signup->bind_param('iissssss',$yearofstudy,$semesterofstudy,$email,$phonenumber,$password,$student_image,$editTime,$studentid);
		$signed_up=$student_signup->execute();
		if($signed_up ){
			$_SESSION["success"]="Successfully Updated your details";
			}else{
				$_SESSION["error"]="Something Went Wrong";
			}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIGN UP</title>
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
							<h3><b>EDIT DETAILS</b></h3>
						</div>
					<?php echo message();?>
					<?php echo success();?>
					<div class="stage-body">
                    <?php
                        $studentdetails="SELECT * FROM students WHERE regNo=?";
                        $student_to_book=$con->prepare($studentdetails);
                        $student_to_book->bind_param('s',$studentid);
                        $student_to_book->execute();
                        $studentdet=$student_to_book->get_result();
                        while($query=$studentdet->fetch_assoc()){
                            ?>
						<form  method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label class="labelinfo">NAME:</label>
								<input class="form-control" type="text" id="name" name="fullname" value="<?php echo  htmlentities($query['fullname']);?>" readonly>
							</div>
							<div class="form-group">
								<label class="labelinfo">REGISTRATION NUMBER:</label>
								<input class="form-control" type="text" id="regnumber" name="regno" value="<?php echo  htmlentities($query['regNo']);?>" readonly>	
							</div>
                          	<div class="form-group">
								<label for="photo">UPLOAD YOUR PHOTO</label>
								<input type="file" class="form-control" name="student-photo" id="photo" required>
							</div>
							<div class="form-group">
								<label class="labelinfo">YEAR OF STUDY:</label>
								<select class="form-control" name="yearofstudy" id="yearstudying" required>
									<option value="">Select Year of Study:</option>
									<option value="1">Year 1</option>
									<option value="2">Year 2</option>
									<option value="3">Year 3</option>
									<option value="4">Year 4</option>
									<option value="5">Year 5</option>
								</select>	
							</div>
						    <div class="form-group">
								<label class="labelinfo">SEMESTER:</label>
								<select class="form-control" name="semesterofstudy" id="sem" required>
									<option value="">Select Semester</option>
									<option value="1">Sem 1</option>
									<option value="1">Sem 2</option>
								</select>	
							</div>
							<div class="form-group">
								<label class="labelinfo">EMAIL:</label>
								<input class="form-control" type="email" name="email" id="studemail" onBlur="checkEmailAvailability()" placeholder="Enter Your Email" required value="<?php echo  htmlentities($query['email']);?>"
								pattern="[a-z0-9._+-%]+?=@gmail.com" title="Email Must Be In the format example@gmail.com">	
								<span id="studemail-existence-status" style="font-size:12px;"></span>
							</div>
						
							<div class="form-group">
								<label class="labelinfo">PHONE NUMBER:</label>
								<input class="form-control" type="tel" name="phonenumber" id="studphonenumber" onBlur="checkPhoneNoAvailability()" value='+254' placeholder="Enter Your Phone Number" title="Mpesa Registered Number Only format)07..." required
								
								>	
								<span id="phonenumber-existence-status" class="status" style="font-size:12px;"></span>
							</div>
							<div class="form-group mypass" >
								<label class="labelinfo">PASSWORD:</label>
								<input class="form-control" id="mypassword" type="password" name="password" id="pass" placeholder="Enter Your Password" required>	
								<i toggle="#mypassword" class="fa fa-eye show-password" ></i> 

							</div>
							<div class="form-group mypass" >
								<label class="labelinfo">CONFIRM PASSWORD:</label>
								<input class="form-control" id="confirmpassword" type="password" name="confirmpass" id="confirmyourpass" placeholder="Re-type password" required>	
								<i toggle="#confirmpassword" class="fa fa-eye show-password" ></i> 
							</div>
							<div class="form-group">
								<button class="btn submit-button btn-info" type="submit" id="submit" name="submit">Edit Details</button>
							</div>
						</form>
                        <?php } ?>
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
	<script>

		function checkEmailAvailability() {
			jQuery.ajax({
				url: "form-validation.php",
				data:'email='+$("#studemail").val(),
				type: "POST",
				success:function(data){
					$("#studemail-existence-status").html(data);
				},
				error:function ()
				{
					event.preventDefault();
					alert('error');
				}
			});
		}
		function checkPhoneNoAvailability() {
			jQuery.ajax({
				url: "form-validation.php",
				data:'phonenumber='+$("#studphonenumber").val(),
				type: "POST",
				success:function(data){
					$("#phonenumber-existence-status").html(data);
				},
				error:function ()
				{
					event.preventDefault();
					alert('error');
				}
			});
		}
	</script>
</body>
</html>