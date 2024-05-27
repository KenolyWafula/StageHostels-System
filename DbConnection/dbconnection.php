<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
define('DB_NAME', 'stagehostel'); //Database name

// Establish database connection.
try
{
$con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

?>