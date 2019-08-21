<?php
  require 'database.php';
header("Content-Type: application/json");

$username = $_POST['username'];

$calendarname = $_POST['calendarname'];

$stmt = $mysqli->prepare("insert into calendar (calendarname, username) values (?, ?)");

//if(!$stmt){
//	"success" => false,
//		"message" => "error preparing stmt"
//	}
//else{
     $stmt->bind_param('ss', $calendarname, $username);
 
 
    $stmt->execute();
  
  
    $stmt->close();

echo json_encode(array(
		"success" => true
	));
	exit;
    
    
//}



?>