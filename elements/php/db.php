<?php

    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

    $result = mysqli_query($con, "SELECT * FROM getdata") or die(mysqli_error($con));

    while($row=mysqli_fetch_assoc($result))
    $output[]=$row;
    print(json_encode($output));
    mysqli_close($con);

?>