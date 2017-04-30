<?php

//db data 
$host = 'localhost';
$dbuser = 'polymer ';
$dbpass = 'polymer';
$dbname = 'polymer';

$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

if (!$conn)
{
    echo "Error: Unable to connect " . PHP_EOL;
    echo "Debugging Error: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}
else
{
    echo "Hurray" . PHP_EOL;
}

$sql = "SELECT name FROM getData";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    echo "Query executed rows--> : " . $result->num_rows . " rows. " . PHP_EOL;
    $rows = array();

    while ($r = mysqli_fetch_assoc($result))
    {
        $rows[] = $r;
    }
}

?>