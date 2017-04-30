<?php
include_once("top.php");
?>
<?php

/**
 * @param string $date (d.m.y, y-m-d, y/m/d)
 * @return string|bol
 */

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

?>
    
<div class="container">
<div class="jumbotron">
<h1>Search reservation data</h1>

<?php

/*

VIEW.PHP

Displays all data from 'players' table

*/



// connect to the database

include('connect-db.php');

$orderby = 'startdate';
$up = 'DESC';

if(isset($_POST['submit'])) {
    $orderby = $_POST['orderby'];
    $up = $_POST['updown'];
    }
// get results from database

$result = mysqli_query($mysqli, "SELECT * FROM polymer ORDER BY $orderby $up")

or die(mysqli_error($mysqli));

?>


<p><b>View All</b> | <a href='view-paginated.php?page=1'>View Paginated</a></p>

<div class="container">
<form   action="<?php echo $_SERVER['PHP_SELF']?>" method ="post">
    <div class='col-md-5'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker6'>
            <label for="exampleSelect1">Order by</label>
                <select class="form-control" id="orderby" name="orderby" data-style="btn-primary">
      <option value="firstname">First Name</option>
      <option value="lastname">Last Name</option>
      <option value="startdate" selected>Start Date</option>
      <option value="enddate">End Date</option>
      <option value="id">id</option>
    </select>

              
            </div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker7'>
            <label for="exampleSelect1">UP or DOWN</label>
                <select class="form-control" id="updown" name="updown" data-style="btn-primary">
      <option value="DESC" selected>DOWN</option>
      <option value="ASC">UP</option>
    </select>            </div>
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">DONE</button>
</form>
</div>
  <br>
    <br>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Panel heading</div>

  <!-- Table -->
  <table class="table">

<tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th>Start Date</th> <th>End Date</th><th>Actions</th></tr>

<?php


// loop through results of database query, displaying them in the table

while($row = mysqli_fetch_array( $result )) {



// echo out the contents of each row into a table

echo "<tr>";

echo '<td><a href="show.php?id=' . $row['id'] . '" role="button" class="btn btn-default">' . $row['id'] . '</a></td>';

echo '<td>' . $row['firstname'] . '</td>';

echo '<td>' . $row['lastname'] . '</td>';

echo '<td>' . convertDate($row['startdate']) . '</td>';

echo '<td>' . convertDate($row['enddate']) . '</td>';

echo '<td>';
echo '<div class="btn-group" role="group" aria-label="...">';
echo '<a href="edit.php?id=' . $row['id'] . '" role="button" class="btn btn-default">Edit</a>';

echo '<a data-href="delete.php?id=' . $row['id'] . '" data-toggle="modal" data-target="#confirm-delete" role="button" class="btn btn-danger"><span class="fa fa-times"></span>Delete</a>';
echo '</td>';

echo '</div>';
echo "</tr>";

}

?>
</table></div>

<!-- MENSAJE DE ALERTA-->
 <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete one line, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                   <!--  <p class="debug-url"></p> -->
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            
            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>

</body>

</html>