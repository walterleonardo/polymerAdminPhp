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
        $password = $_POST['password'];


        } else {
        $username = "pepe";
        $password = "";
        }
        $username = preg_replace("#[^0-9a-z]i#","", $username);



        if ($result = mysqli_query($con, "SELECT * FROM login WHERE username='$username'")) {

            //determinar el número de filas del resultado
            $row_cnt = mysqli_num_rows($result);;

            mysqli_free_result($result);

            if($row_cnt >= 1)
            {
              echo json_encode(["res" => "success"]);
            } else {
              echo json_encode(["res" => "error"]);
            }
        }

    }
    else
    {
        echo json_encode(["res" => "error"]);
    }


}

function array_key_exists_r($keys, $search_r)
{
    $keys_r = split('\|',$keys);
    foreach($keys_r as $key)
    if(!array_key_exists($key,$search_r))
    return false;
    return true;
}
