<?php

/*

NEW.PHP

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($first, $last, $error)

{

include_once("top.php");
?>

<div class="container">
<div class="jumbotron">
<h1>Add new Car</h1>
<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Matricula</span>
<input class="form-control" placeholder="Matricula *" type="text" name="matricula" value="<?php echo $first; ?>" aria-describedby="basic-addon1"/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Marca		</span>
<input class="form-control" placeholder="Marca *" type="text" name="marca" value="<?php echo $last; ?>" /><br/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Modelo	</span>
<input class="form-control" placeholder="Modelo *" type="text" name="modelo" value="<?php echo $first; ?>" aria-describedby="basic-addon1"/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Año		</span>
<input class="form-control" placeholder="Año *" type="text" name="anio" value="<?php echo $last; ?>" /><br/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Km		</span>
<input class="form-control" placeholder="Km *" type="text" name="km" value="<?php echo $first; ?>" aria-describedby="basic-addon1"/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">ITV		</span>
<input class="form-control" placeholder="ITV *" type="text" name="itv" value="<?php echo $last; ?>" /><br/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">AUTOMATICO</span>
<input class="form-control" placeholder="AUTO *" type="text" name="automatico" value="<?php echo $first; ?>" aria-describedby="basic-addon1"/>
</div>
<div class="input-group">
<span class="input-group-addon" id="basic-addon1">Detalles	</span>
<input class="form-control" placeholder="Detalles *" type="text" name="detalles" value="<?php echo $last; ?>" /><br/>
</div>

<p>* required</p>

<input class="btn btn-default" type="submit" name="submit" value="Submit">

</form>
</div>
<?php
          include_once("footer.php");
?>
</div>
</body>

</html>

<?php

}









// connect to the database

include('connect-db.php');



// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

// get form data, making sure it is valid

$firstname = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['firstname']));

$lastname = mysqli_real_escape_string($mysqli,htmlspecialchars($_POST['lastname']));



// check to make sure both fields are entered

if ($firstname == '' || $lastname == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($firstname, $lastname, $error);

}

else

{

// save the data to the database

mysqli_query($mysqli, "INSERT polymer SET firstname='$firstname', lastname='$lastname'")

or die(mysqli_error($mysqli));



// once saved, redirect back to the view page

header("Location: view.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','');

}

?>