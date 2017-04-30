<?php

/*

EDIT.PHP

Allows user to edit specific entry in database

*/



// creates the edit record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($id, $firstname, $lastname, $startdate, $enddate, $error)

{

/**
 * @param string $date (d.m.y, y-m-d, y/m/d)
 * @return string|bol
 */

?>

<?php
include_once("top.php");
?>
<div class="container">
<div class="jumbotron">
<h1>Search reservation data</h1>
<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div class="alert alert-danger fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>'.$error.'</strong> ...
</div>';
}

?>



<form action="" method="post">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div>

<div class="input-group">
<span class="input-group-addon" id="basic-addon1">ID</span>
<input class="form-control" placeholder="FirstName *" type="text" name="id" value="<?php echo $id; ?>" aria-describedby="basic-addon1" disabled/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Name</span>
<input class="form-control" placeholder="FirstName *" type="text" name="firstname" value="<?php echo $firstname; ?>" aria-describedby="basic-addon1"/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">LastName</span>
<input class="form-control" placeholder="LastName *" type="text" name="lastname" value="<?php echo $lastname; ?>" /><br/>


</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Dates</span>
<div id="event_period">
    <input name="startdate" type="text" class="actual_range form-control" placeholder="from date" value="<?php echo $startdate; ?>">
    <input name="enddate" type="text" class="actual_range form-control" placeholder="to date" value="<?php echo $enddate; ?>">
</div>

</div>
<p>* Required</p>

<input class="btn btn-default" type="submit" name="submit" value="UPDATE">

</div>

</form>



</div>
<?php
          include_once("footer.php");
?>
</div>
<script>
$(document).ready(function() {
$('#event_period').datepicker({
    inputs: $('.actual_range'),
    format: "dd-mm-yyyy",
                todayBtn: "linked",
                    maxViewMode: 3,
                        language: "es",
    autoclose: true,
        multidate: false,
      todayHighlight: true

});

});
</script>
</body>

</html>

<?php

}







// connect to the database

include('connect-db.php');

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

// check if the form has been submitted. If it has, process the form and save it to the database

if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['id']))

{


// get form data, making sure it is valid

$id = $_POST['id'];

$firstname = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['firstname']));

$lastname = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['lastname']));

$startdate = convertDate($_POST['startdate']);

$enddate = convertDate($_POST['enddate']);



// check that firstname/lastname fields are both filled in

if ($firstname == '' || $lastname == '' || $startdate == '' || $enddate == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



//error, display form

renderForm($id, $firstname, $lastname, $startdate, $enddate, $error);

}

else

{

// save the data to the database

mysqli_query($mysqli, "UPDATE polymer SET firstname='$firstname', lastname='$lastname',startdate='$startdate', enddate='$enddate' WHERE id='$id'")

or die(mysql_error());



// once saved, redirect back to the view page

header("Location: view.php");

}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error! no data to edit.';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{



// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)

{

// query db

$id = $_GET['id'];

$result = mysqli_query($mysqli,"SELECT * FROM polymer WHERE id=$id")

or die(mysqli_error($mysqli));

$row = mysqli_fetch_array($result);



// check that the 'id' matches up with a row in the databse

if($row)

{



// get data from db

$firstname = $row['firstname'];

$lastname = $row['lastname'];

$startdate = convertDate($row['startdate']);

$enddate = convertDate($row['enddate']);


// show form

renderForm($id, $firstname, $lastname, $startdate, $enddate, '');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

header("Location: view.php");


}

}




?>