<?php
session_start();

//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (!isset($_POST['token'])) {
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

if (isset($_POST['story_id'])) {

    //get story_id 
    $story_id = $_POST['story_id'];

    //Try to add one record in likes table
    $stmt = $mysqli->prepare("insert into likes (story_id, user_id) values (?, ?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ii', $story_id, $user_id);
    $stmt->execute();

    //back to previous story page
    header("Location: " . $_POST['link']);

    $stmt->close();

}
?>