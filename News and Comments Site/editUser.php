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

$usernameEntered = "";
$passwordEntered = "";
$first_name = "";
$last_name = "";
$id = "";
$user = "";

if (isset($_POST['user'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $id = $_POST['id'];
    $user = $_POST['user'];
}

// if user submits the form and this is a call back page
if (isset($_POST['username'])) {
    $usernameEntered = $_POST['username'];
    $passwordEntered = $_POST['password'];
    $id = $_POST['id'];
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
            || !preg_match('/^[\w_\-]+$/', $first_name) || !preg_match('/^[\w_\-]+$/', $last_name)) {
            echo "Invalid input";
        } else {
            $password_hashed = password_hash($passwordEntered, PASSWORD_DEFAULT);
            //Insert the new username and password into database
            $stmt = $mysqli->prepare("update users set username = ?, password = ?, first_name = ?,
            last_name = ? where id = ?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            //// 2.store the passwords hashed into database
            $stmt->bind_param('ssssi', $usernameEntered, $password_hashed, $first_name, $last_name, $id);
            if ($stmt->execute()) {
                header("Location: manageUsers.php");
            } else {
                echo "Failed to update user record!";
            }
            $stmt->close();
        }
    }
}
?>
<html lang="en">
	<head>
    	<title>Edit User</title>
    	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
    	<p> Try to update user record for username: <?php echo $user ?></p><br><br>
    	<form action="editUser.php" method="POST">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
    	<label>User Name: </label>
    	<input type="text" name="username" placeholder = "username" required value = '<?php echo $user ?>'/><br>
    	<label>Password: </label>
    	<input type="password" name="password" placeholder = "password" required/><br>
        <input type='hidden' name='id' value = '<?php echo $id ?>'/>
		<label>First Name: </label>
		<input type="text" name="first_name" placeholder = "First Name" required value = '<?php echo $first_name ?>'/><br>
		<label>Last Name: </label>
		<input type="text" name="last_name" placeholder = "Last Name" required value = '<?php echo $last_name ?>'/><br><br>
    	<input type="submit" value="Update">
    	</form>

    	<a href="manageUsers.php">Back</a>
    </body>
</html>
