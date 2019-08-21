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
$comment_id = "";
$link = $_POST['link'];

?>

<!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title>editComment </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>

<?php

//get comment id
if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];

    //look for the specific story
    $stmt = $mysqli->prepare("select user_id, content from comments where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);
    $stmt->execute();
    $stmt->bind_result($comment_user_id, $content);
    $stmt->fetch();
    $stmt->close();
}

//generate and pre-populate the form
echo "
    <form action='editComment.php' method='POST'>
    <input type='hidden' name='comment_id' value = '" . $comment_id . "'/>
    <p> Content:</p>
    <textarea rows='4' cols='50' name='content' required>" . $content .
    "</textarea><br><br>
    <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
    <input type='hidden' name='link' value='" . $link . "' />
    <input type='submit' value='Submit'>
    </form>
    <br><a href='" . $_POST['link'] . "'>Back</a>";

// if user submits the form and this is a call back page
if (isset($_POST['content'])) {

    //get content inputed by user
    $content = $_POST['content'];

    $comment_id = $_POST['comment_id'];

    //Try to update the new content inputed by user into database
    $stmt = $mysqli->prepare("update comments set content = ? where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $content, $comment_id);
    if (!$stmt->execute()) {
        echo $mysqli->error;
        echo "Failed to update comment";
    } else {
        header("Location: " . $_POST['link']);
    }

    $stmt->close();
    generateFooter();

}
?>
</body></html>