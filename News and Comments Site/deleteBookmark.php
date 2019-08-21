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

// get story id
if (isset($_POST['story_id'])) {

    $story_id = $_POST['story_id'];

    //Try to delete the specific bookmark
    $stmt = $mysqli->prepare("delete from bookmarks where story_id = ? and user_id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ii', $story_id, $user_id);
    if (!$stmt->execute()) {
        echo $mysqli->error;
        echo "Failed to delete the bookmark";
    } else {
        header("Location: bookmarks.php");
    }
    $stmt->close();

}
?>