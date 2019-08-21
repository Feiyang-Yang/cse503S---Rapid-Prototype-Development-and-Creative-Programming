<?php
session_start();
include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];

$dir = dirPath();

//get file name passed from form
$filename = $_GET['file'];

//cited from course PHP wiki "Sending a File to the Browser"

$full_path = sprintf("%s/%s/%s", $dir, $username, $filename);

// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);

// Finally, set the Content-Type header to the MIME type of the file, and display the file.
header("Content-Type: ".$mime);
readfile($full_path);
?>