<?php 
$host="localhost";
$username="polymer"; 
$password="polymer"; 
$db_name="polymer";
$db_query="SELECT * FROM getdata"; 

$mysqli = new mysqli("$host", "$username", "$password", "$db_name");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$mysqli->real_query("$db_query");
$res = $mysqli->use_result();
$rows = array();
while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
}
print json_encode($rows);

?>   