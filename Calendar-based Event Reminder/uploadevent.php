<?php
require 'database.php';
header("Content-Type: application/json");


session_start();

$username=$_SESSION['username'];
$title = $_POST['title'];
$eventdetail= $_POST['detail'];
$mergedate = $_POST['mergedate'];
$mergeenddate = $_POST['mergeenddate'];
//$date = $_POST['start'];
//$time = $_POST['end'];
//
//$enddate = $_POST['enddate'];
//$endtime = $_POST['endtime'];

$stmt = $mysqli->prepare("insert into event ( title, eventdetail, username, start, end) values (?, ?, ?, ?, ?)");


   //$result->close();

if(!$stmt){
echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
	}



  $stmt->bind_param('sssss', $title,$eventdetail, $username, $mergedate , $mergeenddate);
 
 
    $stmt->execute();
  
  
    $stmt->close();


echo json_encode(array(
		"success" => true
	));
	exit;






?>