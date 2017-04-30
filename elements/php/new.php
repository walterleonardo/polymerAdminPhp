<?php

/*

NEW.PHP

Allows user to create a new entry in the database

*/

// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

function convertDate($date) {
       // EN-Date to GE-Date
       if (strstr($date, "-") || strstr($date, "/"))   {
               $date = preg_split("/[\/]|[-]+/", $date);
               $date = $date[2]."-".$date[1]."-".$date[0];
               return $date;
       }
       // GE-Date to EN-Date
       else if (strstr($date, ".")) {
               $date = preg_split("[.]", $date);
               $date = $date[2]."-".$date[1]."-".$date[0];
               return $date;
       }
       return false;
}

// get form data, making sure it is valid

$firstname = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['firstname']));

$lastname = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['lastname']));

$Sdate = $_POST['startdate'];
$startdate = convertDate($Sdate);

$Tdate = $_POST['enddate'];

$enddate = convertDate($Tdate);

// check to make sure both fields are entered

if ($firstname == '' || $lastname == '' || $startdate == '' || $enddate == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($firstname, $lastname, $startdate, $enddate, $error);

}

else

{

// save the data to the database


mysqli_query($mysqli, "INSERT polymer SET firstname='$firstname', lastname='$lastname',startdate='$startdate', enddate='$enddate'")

or die(mysqli_error($mysqli));



// once saved, redirect back to the view page

//header("Location: view.php");

}

}

else

// if the form hasn't been submitted, display the form

{

}



/**
 * @param string $date (d.m.y, y-m-d, y/m/d)
 * @return string|bol
 */


?>