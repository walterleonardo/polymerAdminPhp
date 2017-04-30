<?php

    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

    $result = mysqli_query($con, "SELECT * FROM reservations where now() >= startdate AND now() <= enddate") or die(mysqli_error($con));

    while($row=mysqli_fetch_assoc($result))
    $output[]=$row;
    print_r($output[0]);
    print(json_encode($output[0],JSON_FORCE_OBJECT));
    echo json_encode(["res" => "success"]);
    mysqli_close($con);

?>
