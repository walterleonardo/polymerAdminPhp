<?php

    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

if(isset($_POST['search']) || isset($_GET['search'])) {
  echo "entramos al post";
      echo "\n\r";

    $search1 = $_GET['search'];
    echo "valor del get";
    echo $search1;
    echo "\n\r";
    $search = $_POST['search'];



    echo "valor del post";
    echo $search;
        echo "\n\r";


    $search1 = preg_replace("#[^0-9a-z]i#","", $search1);



    $result = mysqli_query($con, "SELECT * FROM getdata WHERE firstname LIKE '%$$search1%'") or die(mysqli_error($con));

    while($row=mysqli_fetch_assoc($result))
    $output[]=$row;
    print(json_encode($output));
    mysqli_close($con);

} else {
  echo "No entramos al post";
}
?>
