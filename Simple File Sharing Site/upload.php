<?php
//cited from course PHP wiki "Uploading a File"

include 'function.php'; //include the file which contains all the functions

session_start();

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

$dir = dirPath(); //get directory path

// Get the filename and make sure it is valid
$filename = basename($_FILES['uploadedfile']['name']);
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	header("Location: upload_failure.php");
	exit;
}
if(isset($_POST["MAX_FILE_SIZE"])){
	$max_file_size = $_POST["MAX_FILE_SIZE"];
}

if( filesize($_FILES['uploadedfile']['tmp_name']) > $max_file_size ){
	header("Location: upload_failure.php");
	exit;
}

//make full path for the file location
$full_path = sprintf("%s/%s/%s", $dir, $username, $filename);

//try to upload file
if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
    header("Location: upload_success.php");
	exit;
}else{
	header("Location: upload_failure.php");
	exit;
}

?>