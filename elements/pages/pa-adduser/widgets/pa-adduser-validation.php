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
    if(array_key_exists_r('username|password2',filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING)))
    {
        $username = (isset($_POST['username'])) ? $_POST['username'] : "none";
        $password = (isset($_POST['password2'])) ? $_POST['password2'] : "none";
        $firstname = (isset($_POST['firstname'])) ? $_POST['firstname'] : "none";
        $lastname = (isset($_POST['lastname'])) ? $_POST['lastname'] : "none";
        $phone = (isset($_POST['phone'])) ? $_POST['phone'] : "none";
        $mail = (isset($_POST['mail'])) ? $_POST['mail'] : "none";
        $address = (isset($_POST['address'])) ? $_POST['address'] : "none";



        $username = preg_replace("#[^0-9a-z]i#","", $username);



            if ($result = mysqli_query($con, "SELECT * FROM admin WHERE username='$username'")) {
    
                //determinar el número de filas del resultado
                $row_cnt = mysqli_num_rows($result);;
    
                mysqli_free_result($result);
    
                if($row_cnt >= 1)
                {
                  echo json_encode(["res" => "user"]);
                } else {
    
                  
                  $sql = "INSERT INTO admin (username, password, firstname, lastname, phone, mail, address) VALUES ('$username','$password','$firstname', '$lastname', '$phone', '$mail', '$address')";
                  
                  if (mysqli_query($con, $sql)) {
                      echo json_encode(["res" => "success"]);
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                   echo json_encode(["res" => "no created"]);
                  }     
                  mysqli_close($con);
    
                }
            } else {
              echo json_encode(["res" => "mysqlError"]);
            }

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

