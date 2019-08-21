<?php
session_start();
include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

$dir = dirPath(); //get directory path

//get file name passed from form
if(isset($_GET['file'])){
    $filename = $_GET['file'];
}else{
    header("Location: userMain.php"); //redirect to main page if user directly views this page
}

//make full path for the file location
$full_path = sprintf("%s/%s/%s", $dir, $username, $filename);

//delete this file
unlink($full_path);

//redirect to main page
header("Location: userMain.php");

?>