<?php
/* declaramos los detalles de mysql*/
$username = "polymer";
$password = "polymer";
$dbname = "polymer";
$hostname = "127.0.0.1";


/* generamos la llamada */

$mysqli = new mysqli($hostname, $username,$password,$dbname);




// Connect to Database
/*

$connection = mysql_connect($hostname, $username, $password)

or die ("Could not connect to server ... \n" . mysql_error ());

mysql_select_db($$dbname)

or die ("Could not connect to database ... \n" . mysql_error ());
*/


?>