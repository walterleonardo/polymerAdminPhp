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

  if(isset($_POST['search'])) {
    $search = $_POST['search'];
    $search = preg_replace("#[^0-9a-z]i#","", $search);

    $query = mysqli_query($mysqli, "SELECT * FROM polymer WHERE firstname LIKE '%$search%' ORDER BY firstname DESC") or die ("Could not search");
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

        $output .='<tr><th>'.$id.'</th><th>'.$firstname.'</th><th>'.$lastname.'</th><th>'.$startdate.'</th><th>'.$enddate.'</th><th>'.$content.'</th></tr>';
        
        

      }

    }
  }
include_once("top.php");
?>
<div class="container">
<div class="jumbotron">
<h1>Search reservation data</h1>
 <form action ="search.php" method = "post">
   <div class="input-group">
          <input class="form-control" placeholder="Search for...FirstName" name="search" type="text" size="30"/>
		        <span class="input-group-btn">
        <button class="btn btn-default" type="submit" value="Search">Go!</button>
      </span>
         <!--  <input class="btn btn-lg btn-primary"  type="submit" value="Search"/> -->
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
</div>
</body>
</html>