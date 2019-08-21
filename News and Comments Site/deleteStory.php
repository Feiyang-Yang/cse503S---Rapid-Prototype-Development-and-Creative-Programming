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
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $displayAll = $_POST['displayAll'];

    //Try to delete the story
    $stmt = $mysqli->prepare("delete from stories where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        echo $mysqli->error;
        echo "Failed to delete the story";
    } else if (strcmp($displayAll, "1") != 0) {
        header("Location: stories.php");
    } else {
        header("Location: stories.php?displayAll=1");
    }
    $stmt->close();

}
?>