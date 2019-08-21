<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

echo generateHeader();

echo "<p>Are you sure you want to cancel your account?</p>";
echo "<a href = 'cancel.php'>Yes</a><br>";
echo "<a href = 'userMain.php'>No</a>";

echo generateFooter();

?>
