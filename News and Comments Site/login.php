<?php
session_start();
//if user already logged in, redirect to main page
if (isset($_SESSION['id'])) {
    header("Location: main.php");
}

//some fixed expression cite from courseWiki PHP and MySQL
//Connect to Database
require 'newMySQLConnection.php';

$username = "";
$password = "";

//Performing queries that return data
// if user submits the form and this is a call back page
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //filter input from user
    if (!preg_match('/^[\w_\-]+$/', $username) || !preg_match('/^[\w_\-]+$/', $password)) {
        echo "Invalid input";
    } else {
        //// 1.try to get back hashed password
        $stmt = $mysqli->prepare("select count(*), id, password, role_id from users where username = ?");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $username);
        $stmt->execute();
        //// 2. get hashed password from SQL
        $stmt->bind_result($cnt, $id, $password_fromSQL, $role_id);
        //if finds one result
        //// 3. get the user input password
        $pwd_guess = $_POST['password'];
        if ($stmt->fetch()) {
            //// 4.Compare the submitted password to the actual password hash
            if ($cnt == 1 && password_verify($pwd_guess, $password_fromSQL)) {
                //set session id
                $_SESSION['id'] = $id;
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                if ($role_id == 1) {
                    $_SESSION['admin'] = 1;
                }
                header("Location: main.php");
            } else {
                echo "Password incorrect, please try again";
            }
        } else {
            echo "Username or password incorrect, please try again";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
    	<h2> Please log in for further actions</h2><br><br>
    	<form action="login.php" method="POST">
    		 <label>User Name: <input type="text" name="username" placeholder = "username"/><br></label>
    		 <label>Password: <input type="password" name="password" placeholder = "password"/><br></label>
    		 <input type="submit" value="log in"><br><br>
    	</form>
			<p>Do not have an account? </p>
			<a href = "stories.php">View stories</a>
		
    		<a href = "register.php"> Register</a>
    </body>
</html>
