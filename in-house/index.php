
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
<script>
var source, destination;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
google.maps.event.addDomListener(window, 'load', function () {
    new google.maps.places.SearchBox(document.getElementById('txtSource'));
    new google.maps.places.SearchBox(document.getElementById('txtDestination'));
    directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
});
 
 function map(str,id){
   
    
    //*********DIRECTIONS AND ROUTE**********************//
    source = str;
    destination = "indra nagar,bangalore";
 
    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
 
    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
            var distance = response.rows[0].elements[0].distance.text;
            var duration = response.rows[0].elements[0].duration.text;
            var dvDistance = document.getElementById("dvDistance");
           dvDistance.innerHTML = "";
            dvDistance.innerHTML += "Distance: " + distance + "<br />";
            dvDistance.innerHTML += "Duration:" + duration;
			window.location = "setTime.php?id="+id+"&duration="+duration+"&distance="+distance;
            
			} else {
            alert("Unable to find the distance via road.");
        }
    });
}</script>
<script>
  function getBoy(add){
        
		var arr=add.split(".");
     window.location="getBoy.php?id="+arr[0]+"&add="+arr[1];
  
  }
</script>
<?php
  require_once ('db_connect.php');
 
  $query="select * from orders ";
  $result = mysql_query($query);
  $src="Indra Nagar";
  echo "<table style='width:100%'>
  <tr>
    <td>Order Id</td>
    <td>Customer Details</td> 
    <td>Meal Details</td> 
    <td>Delivery Boy</td>
    <td>Time required to deliver</td>
    <td>Disp time</td>
	<td>time to start with Chappti</td>
  </tr>";	
  while ($row=mysql_fetch_row($result))
    {
	   echo "<tr>
	     <td>".$row[0]."</td>
	     <td>".$row[1].",".$row[2]."</td>";
		 $query="select name from meal where id=".$row[3];
		 $result2=mysql_query($query);
		 $result3=mysql_fetch_assoc($result2);
		 echo "<td>".$result3['name']."</td>";
		 
		 if($row[4]){
		 echo "<td>".$row[4]."</td>";
		 }
		 else{
		 $string_send=$row[0].".".$row[2];
		   ?>
		<td><a href='#'  onClick="getBoy('<?php echo $string_send;?>');">Click Here</a></td>
		<?php  }
		 
		 if($row[5]!=0){
		   
		 echo "<td>".$row[6]."</td>";
		 }
		 else{
		   $str =$row[2];
		 ?>
		   <td><a href='#' id="dvDistance" onClick="map('<?php echo $str;?>','<?php echo $row[0];?>');">Click Here</a></td>
		 
		 <?php
		 }
		 if($row[6]!=0){
		    //print_r(str_split($row[6],"hour"));
			$arr = explode(' ', $row[6]);
			//echo $arr[0];
			$query="select order_time from orders where id=".$row[0];
			$results2=mysql_query($query);
			$result3=mysql_fetch_assoc($results2);
			$timeb=explode(':', $result3['order_time']);
			echo "<br>";
			//print_r($timeb);
			 if($timeb[1]+45 > 60){ 
				 $time=$timeb[0]*60+$timeb[1]+45;
				$timeb[0] = floor($time/60);
				$timeb[1] = $time % 60;		
			  }
			  else{ 
			    $timeb[1]+=45; 
			  }
			  if(($timeb[1])-($arr[0])>0){
			   
			     $timeb[1]=($timeb[1])-($arr[0]);
			  }
			 else{
			   $newdiff=($arr[0])-($timeb[1]); 
			   $times=($timeb[0]*60)-$newdiff;
			   $timeb[0] = floor($times/60);
				$timeb[1] = $times % 60;	
			   
			 }
			 $sending=$timeb[0].":".$timeb[1];
			 echo "<td>".$timeb[0].":".$timeb[1]."</td>";
			 mysql_query("update orders set dispTime='".$sending."' where id=".$row[0])or die(mysql_error());
			}
		 else{
		    echo "<td>First go for total time</td>";
		}
		if($timeb[0] >0 || $timeb[1]>1  ){
		      $chTime =($timeb[0]*60)+($timeb[1])-15;
			  $hourCh = floor($chTime/60);
			  $minCh= $chTime % 60;	
			  $ChPrint=$hourCh.":".$minCh;	
				echo "<td>".$ChPrint."</td>";
		}
		}
	     echo "</tr>";
       
    
 
	     echo"</table>";


?>
