<?Php
session_start();
include('../DbConnection/dbconnection.php');
require('../STYLES/FPDF/fpdf.php');
$me=$_GET['studentid'];

date_default_timezone_set('Africa/Nairobi');
$currenttime=date('M, dS Y h:i A', time());
function setup_page($pdf, &$margin_left, &$margin_top,
 &$height, &$width) {
 $pdf->AddPage();
 $pdf->SetX(-1);
 $width = $pdf->GetX() + 1;
 $pdf->SetY(-1);
 $height = $pdf->GetY() + 1;
 $pdf->SetFillColor(220);
 $pdf->Rect(0, 0, $width, $height, 'F');
 $inset = 18;
 $pdf->SetLineWidth(6);
 $pdf->SetDrawColor(190);
 $pdf->SetFillColor(238, 226, 226);
 $pdf->Rect($inset, $inset, $width - 2 * $inset,
 $height - 2 * $inset, 'DF');
 
 $margin_left = $inset + 20;
 $margin_top = $inset + 20;
 $pdf->SetFillColor(3, 3, 59);
 $pdf->Image('images/logo.jpg', $margin_left, $margin_top,40,40);
 $x = $margin_left + 50;
 $pdf->SetFont('Courier', 'B', 16);
 $pdf->SetTextColor(0,128,128);
 $pdf->Text($x, $margin_top + 20,
 'STAGE HOSTEL SYSTEM');
 $pdf->SetFont('Helvetica', 'I', 9);
 $pdf->SetTextColor(3, 3, 59);
 $pdf->Text($x, $margin_top + 32,
 'By Kenoly Wafula and  Peter Kovi');

 $pdf->SetLineWidth(1);
 $pdf->Line($margin_left, $margin_top + 45,
 $width - $margin_left, $margin_top + 45);
 $pdf->SetFont('Times', '', 10);
 $pdf->SetTextColor(0);
}
$pdf = new FPDF('P', 'pt', array(5 * 72, 6 * 72));
$sql="SELECT * FROM students WHERE regNo=?";
$student_to_download=$con->prepare($sql);
$student_to_download->bind_param('s',$me);
$student_to_download->execute();
$students_download=$student_to_download->get_result();
while($row=$students_download->fetch_assoc())
{
  $my_email=$row['email'];
  $my_image=$row['photo'];
  $imgPath ="images/studentImages/$my_email/$my_image";
  setup_page($pdf, $margin_left, $margin_top, $height, $width);
  $pdf->Text($margin_left, $margin_top + 60,
  "Details of {$row['fullname']} ");
  $pdf->Image($imgPath,$margin_left, $margin_top+70,150,150);
  $pdf->Text($margin_left, $margin_top + 235,
  "REGISTRATION NUMBER: {$row['regNo']}");
  $pdf->Text($margin_left, $margin_top + 255,
  "NAME: {$row['fullname']}");
  $pdf->Text($margin_left, $margin_top + 275,
  "EMAIL: {$row['email']}");
  $pdf->Text($margin_left, $margin_top + 295,
  "CONTACTS: 0{$row['contactno']}");
  $pdf->Text($margin_left, $margin_top + 315,
  "REG DATE: {$row['registrationDate']}");
  $pdf->Text($margin_left, $margin_top + 335,
  "UPDATION DATE: {$row['updationDate']}"); 

  $pdf->SetFont('Helvetica', 'U', 8);
  $pdf->SetTextColor(0,128,128);
  $pdf->Text($margin_left+50, $margin_top + 365,

  "Downloaded on: {$currenttime}");
}
$pdf->Output(); 
 ?>