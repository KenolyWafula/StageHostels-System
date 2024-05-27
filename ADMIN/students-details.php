
<?php
session_start();
require_once('../DbConnection/dbconnection.php');
require_once("includes/session.php");
require_once("includes/function.php");
admincheck_login();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | STUDENT DETAILS</title>
    <link type="text/css" href="../STYLES/css/admin-style.css" rel="stylesheet">
    <link type="text/css"href="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/FONTAWESOME/fontawesome-free-5.15.2-web/css/all.css" rel="stylesheet">
    <link type="text/css" href="../STYLES/css/general-elements.css" rel="stylesheet">	
	<link type="text/css" href="../STYLES/DATATABLES\datatables.css"   rel="stylesheet">
    <link rel="shortcut icon" href="IMAGES/stagehostelicon.ico">
</head>
</head>
<body class="managements">
    <header>
        <?php include('includes/header.php')?>
    </header>
    <div class="adminbody">
        <div class="container-fluid">
            <div class="row">
                <div class="thesidemenu">
                    <?php include("includes/admin-menubar.php") ?>
                </div>
                <div class="col-md-8">
                    <div class="stage">
                        <div class="stage-head">
                            <h3><b>SIGNED UP STUDENTS</b></h3> 
                        </div>
                        <div class="stage-body">
                            <table class="kenolykovitable dataTable table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Reg NO</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Registration Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $student_details="SELECT students.fullname,students.regNo, students.contactno,students.email,students.registrationDate from students ORDER BY regNo";
                                    $serial=0;
                                    $student_to_select=$con->prepare($student_details);
                                    $student_to_select->execute();
                                    $students=$student_to_select->get_result();
                                    while($Rows=$students->fetch_assoc()){
                                        $Name=$Rows['fullname'];
                                        $reg_number=$Rows['regNo'];
                                        $phone_number=$Rows['contactno'];
                                        $email=$Rows['email'];
                                        $RegDate=$Rows['registrationDate'];
                                        $identity=$Rows['regNo'];
                                        $serial++;?>
                                        <tr>
                                            <td><?php echo htmlentities($serial);?></td>
                                            <td><?php echo htmlentities($Name);?></td>
                                            <td><?php echo htmlentities($reg_number);?></td>
                                            <td><?php echo htmlentities($phone_number);?></td>
                                            <td><?php echo htmlentities($email);?></td>
                                            <td><?php echo htmlentities($RegDate);?></td>
                                            <td><a href="download-details.php?studentid=<?php echo htmlentities($identity);?>" title="Download Details" target="_blank"><i class=" fa fa-download"></i></a></td>
                                        </tr>
                                        <?php } ?>  
                                </tbody>
                            </table>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php")?>
    <script src="../STYLES/JQUERY/jquery-3.5.1.js"type="text/javascript"></script>
    <script src="../STYLES/BOOTSTRAP/bootstrap-4.6.0-dist/js/bootstrap.js" type="text/javascript"></script>
    <script src="../STYLES/js/sidebar.js"type="text/javascript"></script>
    <script src="../STYLES\DATATABLES\datatables.js" type="text/javascript"></script>
    <?php include('includes/admin-notification-container.php')?>
</body>
</html>