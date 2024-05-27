<?php

require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");

if(!empty($_POST["email"])) {
	$youremail= $_POST["email"];
	if (filter_var($youremail, FILTER_VALIDATE_EMAIL)===false) {

		echo "<span style='color:red'>You did not enter a valid email.</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
        
	}
	else {
		$check_email ="SELECT email FROM students WHERE email=?";
		$email_exists=$con->prepare($check_email);
		$email_exists->bind_param('s',$youremail);
		$email_exists->execute();
        $email_exists->store_result();
		$existing= $email_exists->num_rows;
if($existing>0)
{
echo "<span style='color:red'> Email already exist.</span>";
echo "<script>$('#submit').prop('disabled',true);</script>";
}
else{
	echo "<span style='color:green'> Email available for registration.</span>";
    echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}

if(!empty($_POST['regno'])) {
    $your_regno=$_POST['regno'];
    $check_regNo ="SELECT regNo FROM students WHERE regNo=?";
    $regNo_exists =$con->prepare($check_regNo);
    $regNo_exists->bind_param('s',$your_regno);
    $regNo_exists->execute();
    $regNo_exists->store_result();
    $regNo_existing= $regNo_exists->num_rows;
if($regNo_existing>0)
{
echo "<span style='color:red'> Registration Number already exists. You can login here <a href='login.php'>LOGIN</a></span>";
echo "<script>$('#submit').prop('disabled',true);</script>";
}
else{
echo "<span style='color:green'> Registration Number available for registration.</span>";
echo "<script>$('#submit').prop('disabled',false);</script>";
}
}


if(!empty($_POST['phonenumber'])) {
    $your_phonenumber=$_POST['phonenumber'];
    $check_phonenumber ="SELECT contactno FROM students WHERE contactno=?";
    $phonenumber_exists =$con->prepare($check_phonenumber);
    $phonenumber_exists->bind_param('i',$your_phonenumber);
    $phonenumber_exists->execute();
    $phonenumber_exists->store_result();
    $phonenumber_existing= $phonenumber_exists->num_rows;
if($phonenumber_existing>0)
{
echo "<span style='color:red'> Phone Number already exist.</span>";
echo "<script>$('#submit').prop('disabled',true);</script>";

}
else {
    $nums=mb_strlen((string) $your_phonenumber);
    if (is_numeric($your_phonenumber) && $your_phonenumber>= 0 && $nums>=10 && $nums<=13) {
        echo "<span style='color:green'>Phone Number allowed. Remember that only Mpesa Registered Safaricom Numbers Can Be used</span>";
        echo "<script>$('#submit').prop('disabled',false);</script>";  
    
    }else{
    echo "<span class='trisl' style='color:red'> Provide a valid phone Number.</span>";
    echo "<script>$('#submit').prop('disabled',true);</script>";
    }
}

}