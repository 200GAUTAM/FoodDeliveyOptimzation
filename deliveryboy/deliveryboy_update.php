
<a href="">Status Update</a>  | <a href="deliveryboy_index.php">Getting Late</a></br></br></br>
<?php
  
	require_once ('../db_connect.php');
	$id="abhi";
	$query="select * from orders where delivery_boy_id='".$id."'";
	$result = mysql_query($query);
	
	
?>  
	<table style="width:100%">
	  <tr>
		<td>Order Id</td>
		<td>Customer Details</td>		
		<td>Meal Id</td>
		<!--<td>Status</td>-->
		<td>Change Status</td>
	  </tr>
<?php
	
	while ($result_array=mysql_fetch_array($result)){
     $temp=$result_array[1].",".$result_array[2];
	 echo "<tr>
		<td>". $result_array[0]."</td>
		
		<td>". $temp."</td>";
		$query="select name from meal where id=".$result_array[3];
		$result2=mysql_query($query);
		$result3=mysql_fetch_assoc($result2);
		echo "<td>".$result3['name']."</td>";
	//	echo "<td>". $result_array[4]."</td>";
		 
		?>
		<td><select  name="users" onchange="updateStatus(this.value)">
		  <option value="p">Pending</option>
		  <option value="d">Delivered</option>
		  <option value="c">Cancelled</option>
		  <option value="g">Getting Late</option>
		  <input type="hidden" name="hidden" id="hidden" value="<?php echo $result_array[0]; ?>">
		</select>
		</td>

		<div id="txtHint"></div>
		<?php
	 echo "</tr>";
	
	
}
	print_r($result_array);	
   
?>
</table>
<script>
function updateStatus(str) {
         var id=document.getElementById("hidden").value;
		 
        //var id="<?php echo $result_array[0]; ?>";
		
		var send=id+"."+str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
				alert(xmlhttp.responseText);
            }
        }
		
        xmlhttp.open("GET","update_ajax.php?a="+send,true);
        xmlhttp.send();
    
}
</script>
