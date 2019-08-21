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

// get comment id
if (isset($_POST['comment_id'])) {

    $comment_id = $_POST['comment_id'];

    //Try to delete the comment
    $stmt = $mysqli->prepare("delete from comments where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $comment_id);
    if (!$stmt->execute()) {
        echo $mysqli->error;
        echo "Failed to delete the comment";
    } else {
        header("Location: " . $_POST['link']);
    }
    $stmt->close();

}
?>