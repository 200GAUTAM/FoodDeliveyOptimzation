<?php
 require_once ('../db_connect.php');
 $send = $_REQUEST["a"];
 explode(".",$send);
 $query="update orders set status = '".$send[2]."' where id = ".$send[0];
 $result = mysql_query($query)or die(mysql_error());
 
 echo $result;
 
?>
