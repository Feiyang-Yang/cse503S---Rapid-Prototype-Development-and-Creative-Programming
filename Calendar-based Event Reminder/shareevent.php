

<?php
require 'database.php';
header("Content-Type: application/json");

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
	if($stmt->num_rows ==0) {
	echo json_encode(array(
		"success" => false,
		"message" => "username not existed in the database "
	));

	exit;
     
	}
	
}

session_start();
$shareuser = $_POST['shareuser'];
	checkexisting($shareuser);
        

    
$username=$_SESSION['username'];

$title = $_POST['title'];
$eventdetail= $_POST['detail'];
$mergedate = $_POST['mergedate'];

$mergeenddate = $_POST['mergeenddate'];






$stmt = $mysqli->prepare("insert into event ( title, eventdetail, username, start, end) values (?, ?, ?, ?, ?)");


   //$result->close();

if(!$stmt){
echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
	}



  $stmt->bind_param('sssss', $title,$eventdetail, $shareuser, $mergedate , $mergeenddate);
 
 
    $stmt->execute();
  
  
    $stmt->close();


echo json_encode(array(
		"success" => true
	));
	exit;






?>