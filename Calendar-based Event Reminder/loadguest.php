<?php
require 'database.php';
  session_start();
  $username="guest";
  if ($_SESSION['username']!= null){
    //$stmt = $mysqli->prepare("SELECT title, eventdetail, start, end from  event  where username = ?");// values (?, ?, ?, ?, ?)");/possible error


//$stmt = $mysqli->prepare("select title, eventdetail, start, end  from event  where username = ?");

//("select  calendarid ,calendarname from calendar where username = ?")
 //echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));


//$stmt->bind_param('s', $username);
	//$stmt->execute();
	//$stmt->bind_result( $title, $eventdetail, $start, $end);
      // $result = $stmt->store_result();
       // $request = "select title, eventdetail, start, end  from event  where username = $username";
        
              $request = "SELECT eventid, title, eventdetail, start, end FROM event WHERE username='" . $username . "' ORDER BY eventid";
      $bdd = new PDO('mysql:host=localhost;dbname=calendar2', 'root', 'bonzo5597');
      
        $resultat = $bdd->query($request) or die(print_r($bdd->errorInfo()));
        
           echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));
 
//       $result = mysql_query("select title, eventdetail, start, end  from event  where username = $username");
//          while( $row = mysql_fetch_assoc( $result)){
//    $new_array[] = $row; // Inside while loop
//}
//
// echo json_encode($result);


    
 
  // stmt->fetchAll();
   
 //while($stmt ->fetch()){
 //   
 //   	echo "<h4>".($calendarid." &nbsp;corresponds to the name of :&nbsp;".$calendarname)."</h4>";
 //   
 // 
 //   echo '<br>';
 //}
  }
?>