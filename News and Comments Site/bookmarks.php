<?php
session_start();
?>

<!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title> Bookmarks </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>

<?php
//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

//     Connect to Database
require 'newMySQLConnection.php';

//get user id from session
$user_id = $_SESSION['id'];

//find and display all the saved bookmarks
$stmt = $mysqli->prepare("select bookmarks.story_id, title, link from stories join bookmarks on stories.id = bookmarks.story_id where bookmarks.user_id = ?");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('i', $user_id);
!$stmt->execute();
$stmt->bind_result($story_id, $title, $link);
while($stmt->fetch()){
        //display the story information saved in database
        echo " <div class='edit-delete'> <a style='font-size:24px', href='" . $link . "'>" . htmlentities($title) . "</a> &nbsp;&nbsp";
        echo " 
        <form action='deleteBookmark.php' method='POST' >
        <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
        <input type='hidden' name='story_id' value='" . $story_id . "' />
        <input type='submit' value='Delete'>
        </form>  </div>";
}

$stmt->close();

echo "<br><a href='main.php'>Back </a><br>";
?>
</body></html>