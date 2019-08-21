<?php
session_start();

//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if(!isset($_POST['token'])){
    die("You cannot directly view this page");
}

//check CSRF token
if (!hash_equals($_SESSION['token'], $_POST['token'])) {
    die("Request forgery detected");
}

//     Connect to Database
require 'newMySQLConnection.php';

//get user id from session
$user_id = $_SESSION['id'];
$content = "";

// if user submits the form and this is a call back page
if (isset($_POST['content'])) {

    //get content inputed by user
    $content = $_POST['content'];

    //Try to insert the new content inputed by user into database
    $stmt = $mysqli->prepare("insert into comments (story_id, user_id, content) values (?, ?, ?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('iis', $_POST['story_id'], $user_id, $content);
    if (!$stmt->execute()) {
        echo $mysqli->error;
        echo "Failed to add comment";
    } else {
        header("Location: " . $_POST['link']);
    }

    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Register</title>
    	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
    	<form action="addComment.php" method="POST">
        <input type='hidden' name='story_id' value='<?php echo $_POST['story_id'] ?>' />
        <input type='hidden' name='link' value='<?php echo $_POST['link'] ?>' />
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
    	<h1> Content:</h1>
        <textarea rows="4" cols="50" name="content" required></textarea><br><br>
    	<input type="submit" value="Submit">
    	</form>
        <br>
    	<a href="<?php echo $_POST['link'] ?>">Back</a>
    </body>
</html>
