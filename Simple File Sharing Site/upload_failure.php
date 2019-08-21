<?php

session_start();
//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

?>

<!DOCTYPE html>
<html lang="en">
<head> 
	<meta charset="UTF-8"><title> UploadFailure </title>
	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
</head>
<body>
<p class = fail>Failed to upload file</p>
<a href = "userMain.php" tite = "Logout">Back</a>
</body>
</html>
