<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'stagehostel'); //Database name

// Establish database connection.
try
{
$con= new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

?>