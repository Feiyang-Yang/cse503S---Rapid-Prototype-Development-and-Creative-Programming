<?php
session_start();

//if user already logged in, redirect to main page
if (isset($_SESSION['id'])) {
    header("Location: main.php");
}

//     Connect to Database
require 'newMySQLConnection.php';

$usernameEntered = "";
$passwordEntered = "";
$first_name = "";
$last_name = "";
// if user submits the form and this is a call back page
if (isset($_POST['username'])) {
    $usernameEntered = $_POST['username'];
    $passwordEntered = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    //some fixed expression cite from courseWiki PHP and MySQL
    //check if user already exists
    $stmt = $mysqli->prepare("select username from users where username = ?");

    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('s', $usernameEntered);
    $stmt->execute();
    $stmt->bind_result($usernameReturned);
    //if gets one result, then it means username exists
    if ($stmt->fetch()) {
        echo "Username already exists!";
        $stmt->close();
    } else {
        //// 1.hash the passwords
        //filter input from user
		if (!preg_match('/^[\w_\-]+$/', $usernameEntered) || !preg_match('/^[\w_\-]+$/', $passwordEntered)
		||!preg_match('/^[\w_\-]+$/', $first_name) || !preg_match('/^[\w_\-]+$/', $last_name)) {
            echo "Invalid input";
        } else {
            $password_hashed = password_hash($passwordEntered, PASSWORD_DEFAULT);
            //Insert the new username and password into database
            $stmt = $mysqli->prepare("insert into users (username, password, first_name, last_name)
		values (?, ?, ?, ?)");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            //// 2.store the passwords hashed into database
            $stmt->bind_param('ssss', $usernameEntered, $password_hashed, $first_name, $last_name);
            $stmt->execute();
            $stmt->close();
            //look for user id after inserting one result
            $stmt = $mysqli->prepare("select id from users where username = ?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('s', $usernameEntered);
            $stmt->execute();
            $stmt->bind_result($id);
            //if finds one result
            if ($stmt->fetch()) {
                //set session id
				$_SESSION['id'] = $id;
				$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
				$stmt->close();
				header("Location:main.php");
            }else{
				echo "Sorry, something went wrong";
			}
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>Register</title>
    	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
    	<p> Please set your user name and password</p><br><br>
    	<form action="register.php" method="POST">
    	<label>User Name: </label>
    	<input type="text" name="username" placeholder = "username" required/><br>
    	<label>Password: </label>
    	<input type="password" name="password" placeholder = "password" required/><br>
		<label>First Name: </label>
		<input type="text" name="first_name" placeholder = "First Name" required/><br>
		<label>Last Name: </label>
		<input type="text" name="last_name" placeholder = "Last Name" required/><br>
    	<input type="submit" value="Register">
    	</form>

    	<a href="login.php">Log in</a>
    </body>
</html>
