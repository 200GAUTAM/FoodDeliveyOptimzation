<?php
require_once ('../db_connect.php');
$id=$_GET['id'];
$time=$_GET['duration'];
$distance=$_GET['distance'];
$query="update orders set time = '".$time."',distance='".$distance."' where id = ".$id;
$result = mysql_query($query)or die(mysql_error());
 echo $result;
 ?>
