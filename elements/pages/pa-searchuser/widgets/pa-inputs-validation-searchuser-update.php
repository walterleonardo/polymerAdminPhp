<?php
    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

//comprobamos que sea una petición ajax
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
//array_key_exists_r('id',filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING))
    if(array_key_exists_r('id|username',filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING)))
    {

        $id = (isset($_POST['id'])) ? $_POST['id'] : "none";
        $firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : "none";
        $lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : "none";
        $username = (isset($_POST['username'])) ? $_POST['username'] : "none";
        $mail = (isset($_POST['mail'])) ? $_POST['mail'] : "none";
        $address = (isset($_POST['address'])) ? $_POST['address'] : "none";
        $phone = (isset($_POST['phone'])) ? $_POST['phone'] : "none";
        $username = preg_replace("#[^0-9a-z]i#","", $username);

        $updateQuery = "UPDATE admin SET firstname='$firstname', lastname='$lastname', username='$username', mail='$mail', address='$address', phone='$phone' WHERE id='$id'";

        if ($result = mysqli_query($con, $updateQuery)) 
        {
         echo json_encode(["res" => "success"]);
        } else 
        {
          echo json_encode(["res" => "error"]);
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
