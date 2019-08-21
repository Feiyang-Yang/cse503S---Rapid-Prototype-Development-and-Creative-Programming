    <?php
     $username = $_POST['username'];
     
     require 'database.php';
     $stmt = $mysqli->prepare("select  calendarid ,calendarname from calendar where username = ?");


 $stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result( $calendarid, $calendarname);
 while($stmt ->fetch()){
    
    	echo "<h4>".($calendarid." &nbsp;corresponds to the name of :&nbsp;".$calendarname)."</h4>";
    
  
    echo '<br>';
 }
 //echo' <input type="text" name="calendarname" id="calendarname"/>';
  //echo'  <input type="hidden" id="loadcalendarusername" value="'.$username.'"/>';
  //   echo'      <button onclick="loadCal()">loadyourCalendar</button>';
       ?>