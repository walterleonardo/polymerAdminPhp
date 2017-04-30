<?php
//PHP PAGE EXAMPLE

include "connect-db.php";

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
$output = '';

if(isset($_POST['startdate']) || isset($_POST['enddate'])) {

	if(isset($_POST['range']) && $_POST['range'] == "true")
	{
		if(!isset($_POST['startdate']))
		{
			$startdateGet = '1900-01-01';

		}
		else
		{
			$startdateGet = convertDate($_POST['startdate']);
		}


		if(!isset($_POST['enddate']))
		{
			$enddateGet = '2100-01-01';
		}
		else
		{
			$enddateGet = convertDate($_POST['enddate']);
		}

		$query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE startdate >= CAST('$startdateGet' AS DATE) AND enddate <= CAST('$enddateGet' AS DATE)") or die ("Could not search");
	}
	else
	{
		if(isset($_POST['startdate']) && isset($_POST['enddate']))
		{
			$startdateGet = convertDate($_POST['startdate']);
			$enddateGet = convertDate($_POST['enddate']);
			$query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE startdate=CAST('$startdateGet' AS DATE) AND enddate=CAST('$enddateGet' AS DATE)") or die ("Could not search");
		}
		else if(!isset($_POST['startdate']))
			{
				$enddateGet = convertDate($_POST['enddate']);
				$query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE enddate=CAST('$enddateGet' AS DATE)") or die ("Could not search");
			}
		else
		{
			$startdateGet = convertDate($_POST['startdate']);
			$query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE startdate=CAST('$startdateGet' AS DATE)") or die ("Could not search");
		}
	}



	//$search = preg_replace("#[^0-9a-z]i#","", $search);

	//$query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE startdate >= '$startdateGet' AND enddate <= '$enddateGet'") or die ("Could not search");
	$count = mysqli_num_rows($query);

	if($count == 0){
		$output = '<tr><th>There was no search results!</th></tr>';

	}else{

		$output .='<tr><th>ID</th><th>FIRST NAME</th><th>LAST NAME</th><th>START DATE</th><th>END DATE</th><th>CONTENT</th></tr>';

		while ($row = mysqli_fetch_array($query)) {

			$id = $row ['id'];
			$firstname = $row ['firstname'];
			$lastname = $row ['lastname'];
			$content = $row ['content'];
			$startdate = convertDate($row ['startdate']);
			$enddate = convertDate($row ['enddate']);

			$output .='<tr><th><a href="show.php?id=' . $row['id'] . '" role="button" class="btn btn-default">' . $row['id'] . '</a></th><th>'.$firstname.'</th><th>'.$lastname.'</th><th>'.$startdate.'</th><th>'.$enddate.'</th><th>'.$content.'</th></tr>';



		}

	}
}
include_once("top.php");
?>

<style type="text/css">
#eventForm .dateContainer .form-control-feedback {
    top: 0;
    right: -15px;
}
</style>
<div class="container">
<div class="jumbotron">
<h1>Search reservation data</h1>
<form action ="searchbydates.php" method = "post">
	<div class="input-group">
			<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">Dates</span>
				<div id="event_period">
					<input name="startdate" type="text" class="actual_range form-control" placeholder="from date">
					<input name="enddate" type="text" class="actual_range form-control" placeholder="to date" >
				</div>
						<span class="input-group-btn">
		<button class="btn btn-lg btn-primary" type="submit" value="Search">Go!</button>
		</span>
			</div>
			
			<br>
			<div class="input-group">
				 <label for="exampleSelect1">Search by</label>
                <select class="form-control" id="range" name="range" data-style="btn-primary">
      <option value=true selected>Range</option>
      <option value=false >Point to Point</option>
       </select>
			</div>
	
	</div>

</form>
<br>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Results</div>

  <!-- Table -->
  <table class="table">
    <?php print ("$output");?>
  </table>
</div>


</div>
<?php
include_once("footer.php");
?>
<script>
$(document).ready(function() {
$('#event_period').datepicker({
    inputs: $('.actual_range'),
    format: "dd-mm-yyyy",
    minDate:new Date(),
                todayBtn: "linked",
                    maxViewMode: 3,
                        language: "es",
    autoclose: true,
        multidate: false,
      todayHighlight: true

});

});
</script>
</div>
</body>
</html>