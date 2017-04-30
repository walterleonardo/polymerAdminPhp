<?php
$conn=mysql_connect("localhost","polymer","polymer");
mysql_select_db("polymer",$conn);


$query = "select id, name from getData";
$query_result = mysql_query($query);
$output = array();
$i=0;
while($row=mysql_fetch_array($query_result,MYSQL_ASSOC))
 {
 $output[$i]["id"]=$row["id"];
 $output[$i]["name"]=$row["name"];
 $i++;
 }

print json_encode($output);
?>