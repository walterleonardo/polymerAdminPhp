<?php

/*
CREATE TABLE `admin` (
  `res` varchar(255) CHARACTER SET latin1 DEFAULT 'success',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `lastname` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `username` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `mail` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `address` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `running` tinyint(1) DEFAULT '0',
  `gps` tinyint(1) DEFAULT '0',
  `babyseat` tinyint(1) DEFAULT '0',
  `gasfull` tinyint(1) DEFAULT '0',
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `autoID` varchar(255) CHARACTER SET latin1 DEFAULT 'IB0000',
  `info` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
*/

    require_once 'db_connect.php';

    $db = new DB_CONNECT();
    $con = $db->connect();

//comprobamos que sea una petición ajax
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    if(array_key_exists_r('username|password|terms',filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING)))
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



        if ($result = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' AND password='$password'")) {

            //determinar el número de filas del resultado
            $row_cnt = mysqli_num_rows($result);;

            mysqli_free_result($result);

            if($row_cnt >= 1)
            {
              echo json_encode(["res" => "success"]);
            } else {
              $error = "error";
              echo json_encode(["res" => "$error"]);
            }
        } else {
          echo json_encode(["res" => "mysqlError"]);
        }

    }
    else
    {
        echo json_encode(["res" => "errorTotal"]);
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
