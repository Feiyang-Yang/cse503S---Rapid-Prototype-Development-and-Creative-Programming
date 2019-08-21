<?php
session_start();
//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Main Page</title>
    	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
		<a href="stories.php">View your stories</a><br>
		<a href="stories.php?displayAll=1">View all stories</a><br>
		<a href="bookmarks.php?">Bookmarks</a><br>
		<?php 
		//if admin user, add link to manage all users
		if(isset($_SESSION['admin'])){
			echo '<a href="manageUsers.php?">Manage Users</a><br>';
		}
		?>
		<a href="logout.php">Log out</a><br>
	 </body>
 </html>
