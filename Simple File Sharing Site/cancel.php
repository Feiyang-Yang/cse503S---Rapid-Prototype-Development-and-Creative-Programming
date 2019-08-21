<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

//delete username in users.txt
$file = usersCredentialFilePath();
file_put_contents($file,str_replace($username."\n",'',file_get_contents($file)));

//remove user files and directory
$userDir = dirPath()."/".$username;
array_map('unlink', glob("$userDir/*.*"));
rmdir($userDir);

session_destroy();
header("Location: login.php");

?>