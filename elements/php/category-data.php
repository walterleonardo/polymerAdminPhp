<?php

    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $db->connect();

    $result = mysql_query("SELECT * FROM getData") or die(mysql_error());

    while($row=mysql_fetch_assoc($result))
    $output[]=$row;
    print(json_encode($output));
    mysql_close();

?>