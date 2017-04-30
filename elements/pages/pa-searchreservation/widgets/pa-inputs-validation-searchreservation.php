<?php
    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

//comprobamos que sea una petición ajax
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    if(array_key_exists_r('username',filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING)))
    {
        if(isset($_POST['username']))
        {
        $username = $_POST['username'];
        $date = date("Y-m-d", strtotime($_POST['date']));

        } else {
        $username = "pepe";
        }
        $username = preg_replace("#[^0-9a-z]i#","", $username);


        if ($result = mysqli_query($con, "SELECT * FROM admin WHERE (firstname LIKE '%$username%' OR lastname LIKE '%$username%' OR mail LIKE '%$username%') AND startdate >= '$date'")) {

            while($row=mysqli_fetch_assoc($result))
            $output[]=$row;

            //determinar el número de filas del resultado
            $row_cnt = mysqli_num_rows($result);

            mysqli_free_result($result);

            if($row_cnt >= 1)
            {
              print(json_encode($output,JSON_FORCE_OBJECT));
            } else {
              $error = "error";
              $error = array(
                          array("res" => "$error"),
                          array("res" => "$error")
                          );

              echo json_encode([$error]);
            }
            mysqli_close($con);
        } else {
          echo json_encode(["res" => "mysqlError"]);
        }

    }
    else
    {
        echo json_encode(["res" => "Please complete required fields..."]);
    }



}

function array_key_exists_r($keys, $search_r)
{
    $keys_r = explode('|',$keys);
    foreach($keys_r as $key)
    if(!array_key_exists($key,$search_r))
    return false;
    return true;
}
