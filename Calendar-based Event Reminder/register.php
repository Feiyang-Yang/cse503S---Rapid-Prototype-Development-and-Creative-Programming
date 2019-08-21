<?php
    require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 

function checkexisting ($username){
    require 'database.php';
	$stmt = $mysqli->prepare("select * from user where username=? ");
		if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
            	}
			$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0) {
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
     
	}
	
}






if(isset($_POST['username']) && isset($_POST['password'])){
	
	checkexisting($_POST['username']);
    
$username = $_POST['username'];
$password = $_POST['password'];







$passwordHash = crypt($password);


$stmt = $mysqli->prepare("insert into user (username, hashpass) values (?, ?)");




  if(!$stmt){
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
	}



  $stmt->bind_param('ss', $username, $passwordHash);
 
 
    $stmt->execute();
  
  
    $stmt->close();


echo json_encode(array(
		"success" => true
	));
	exit;
    
    
}
?>
    
    
    
    
    