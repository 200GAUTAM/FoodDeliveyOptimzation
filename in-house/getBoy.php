<?php
 require_once ('../db_connect.php');
 date_default_timezone_set('Asia/Calcutta');
 $id=$_GET['id'];
 $add=$_GET['add']; 
 
 $stm="select l_r from cluster where name='".$add."'";
 $query=mysql_query($stm)or die(mysql_error()); 
 $res=mysql_fetch_assoc($query);

 $query2="update orders set nav='".$res['l_r']."' where id=".$id;
 $exec2=mysql_query($query2) or die(mysql_error());

 
 $query3="select boys from cluster where l_r='".$res['l_r']."'";
 $exec3=mysql_query($query3) or die(mysql_error());
 $counter=1;
 while($row3=mysql_fetch_row($exec3)){
  if($row3[0]!=" " || $row3[0]!=null){
   $stm4="select id from delivery_boy where name='".$row3[0]."'";
   $query4=mysql_query($stm4)or die(mysql_error()); 
   $res4=mysql_fetch_assoc($query4);
  $m=mysql_query("update orders set delivery_boy_id='".$row3[0] ."' where id=".$id)or die("parmidner");
   
    
   
   }
   
   

 }
 
  
 ?>
