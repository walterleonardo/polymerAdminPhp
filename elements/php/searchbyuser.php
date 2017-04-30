<?php
//PHP PAGE EXAMPLE

  include "db_connect.php";
      $db = new DB_CONNECT();
    $con = $db->connect();
    
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

$querySentence = "select * from getdata where firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR id LIKE '%$search%' ORDER BY firstname ASC";
//"SELECT * FROM polymer WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR id LIKE '%$search%' ORDER BY firstname DESC"

    $query = mysqli_query($con, $querySentence) or die ("Could not search");
    $count = mysqli_num_rows($query);
    
       while($row=mysqli_fetch_assoc($query))
    $output1[]=$row;
    print(json_encode($output1));
    
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


        $output .='<tr><th><a href="show.php?id=' . $row['id'] . '" role="button" class="btn btn-default">' . $row['id'] . '</a></th><th>'.$firstname.'</th><th>'.$lastname.'</th><th>'.$startdate.'</th><th>'.$enddate.'</th><th>'.$content.'</th>
        <th><div class="btn-group" role="group" aria-label="..."><a href="edit.php?id=' . $row['id'] . '" role="button" class="btn btn-default">Edit</a><a data-href="delete.php?id=' . $row['id'] . '" data-toggle="modal" data-target="#confirm-delete" role="button" class="btn btn-danger"><span class="fa fa-times"></span>Delete</a></td></div></th></tr>';
        
        

      }

    }
  }
  print ("$output");


?>