<?php
// array for JSON response
$response = array();
header('Content-type: application/json');
// include db connect class
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();
// check for post data
if (isset($_GET["UserID"])) {
$UserID = $_GET['UserID'];

// get a product from products table
$result = mysql_query("SELECT * FROM getdata WHERE firstname = $UserID") or die(mysql_error());

if (!empty($result)) {
    // check for empty result
    if (mysql_num_rows($result) > 0) {

        // user node
        $response["Users"] = array();

        While ($row = mysql_fetch_array($result)){

            $user[] = array();
            $user["firstname"] = $row["firstname"];
            $user["lastname"] = $row["lastname"];
            $user["code"] = $row["code"];


            array_push($response["Users"], $user);
        }



        // success
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No User found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // no product found
    $response["success"] = 0;
    $response["message"] = "No User found";

    // echo no users JSON
    echo json_encode($response);
}
} else {
// required field is missing
$response["success"] = 0;
$response["message"] = "Required field(s) is missing";

// echoing JSON response
echo json_encode($response);
}
?>