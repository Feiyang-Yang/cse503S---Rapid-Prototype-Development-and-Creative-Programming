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
$title = "";
$content = "";
$link = "";
$id = "";

?>
 <!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title> Share Your Story </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>


<?php

$displayAll = "";

//get story id
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $displayAll = $_POST['displayAll'];
    //look for the specific story
    $stmt = $mysqli->prepare("select user_id, title, content from stories where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($story_user_id, $title, $content);
    $stmt->fetch();
    $stmt->close();
}

//generate and pre-populate the form
echo "
    <form action='editStory.php' method='POST'>
    <input type='hidden' name='id' value = '" . $id . "'/>" .
    "<p> Title:</p>
    <input type='text' name='title' required placeholder = 'title' value = '" . $title .
    "'/><br>
    <input type='hidden' name='displayAll' value='" . $displayAll . "' />
    <p> Content:</p>
    <textarea rows='7' cols='50' name='content' required>" . $content .
    "</textarea><br><br>
    <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
    <input type='submit' value='Submit'>
    </form>
    <a href='stories.php?displayAll=". $displayAll ."'>Back</a>";

// if user submits the form and this is a call back page
if (isset($_POST['title'])) {

    $id = $_POST['id'];
    //get title and content inputed by user
    $title = $_POST['title'];
    $content = $_POST['content'];
    $displayAll = $_POST['displayAll'];

    if (strlen($title) == 0) {
        echo "Please enter the title";
    } else if (strlen($content) == 0) {
        echo "Please enter the content";
    } else {
        //Try to update the title and content
        $stmt = $mysqli->prepare("update stories set title = ?, content = ? where id = ?");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ssi', $title, $content, $id);
        if (!$stmt->execute()) {
            echo $mysqli->error;
            echo "Failed to update story";
            $stmt->close();
        } else if (strcmp($displayAll, "1") != 0) {
            header("Location: stories.php");
        } else {
            header("Location: stories.php?displayAll=1");
        }
    }

}
?>
</body></html>
