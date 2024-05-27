  <?php
function message(){
	if(isset($_SESSION["error"])){
		$output='
		<div class="alert btn-danger" Title="Click To Dismiss">
		<button  type="button" class="close" data-dismiss="alert">×</button>
	   '.($_SESSION["error"]).'
		</div>
		';
		$_SESSION["error"]=null;
		return $output;
	}
}
function success(){
	if(isset($_SESSION["success"])){
		$output='
		<div class="alert btn-success" Title="Click To Dismiss">
		<button  type="button" class="close" data-dismiss="alert">×</button>
		'.($_SESSION["success"]).'
		</div>
		';
		$_SESSION["success"]=null;
		return $output;
	}
}
/*check whether a student has logged in or not*/
function studentcheck_login()
{
if(strlen($_SESSION['mystudentid'])==0)
	{	
		header('location:login.php');
	}
}
?>