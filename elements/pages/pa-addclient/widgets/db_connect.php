<?php
/**
 * A class file to connect to database
 */
class DB_CONNECT {
/**
 * Function to connect with database
 */
function connect() {
    // import database connection variables
    require_once __DIR__ . '/db_config.php';

    // Connecting to mysql database
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die(mysqli_error());
    //$con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

    // Selecting database
    //


    /*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($con->connect_error) {
    die('Connect Error (' . $con->connect_errno . ') '
            . $mysqli->connect_error);
}

/*
 * Use this instead of $connect_error if you need to ensure
 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
 */
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

    // returing connection cursor
    return $con;
    $con->close();

}
}

?>
