<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user already logged in, redirect to main page
if (isset($_SESSION['user']) && strlen($_SESSION['user']) != 0) {
    header("Location: userMain.php");
}

$username = "";

if (isset($_GET["username"])) { //if user clicks login button
    $username = $_GET["username"]; //get username inputed by user
}

//check if user enters invalid username
if (strlen($username) != 0) {
    if (!preg_match('/^[\w_\-]+$/', $username)) {
        echo "Invalid username";
    } else {
        //open users.txt file to find all the usernames and check if the inputed username matched any of these
        $h = fopen(usersCredentialFilePath(), "r");
        $linenum = 1;
        while (!feof($h)) { //read file line by line
            $linenum++;
            $inputUsername = substr(fgets($h), 0, -1); //omit last character
            if (strcmp($username, $inputUsername) == 0) { //if username matches, redirect user to his file sharing site
                $_SESSION['user'] = $username;
                header("Location: userMain.php");
            }
        }
        fclose($h);

        //if username not founded
        echo "Incorrect username";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head> <meta charset="UTF-8"><title> Login </title>
<link rel="stylesheet" type="text/css" href="StyleSheet.css">
</head>

<body>
<div class = "container">

    <form action = "login.php" method = "get">
        <input type = "text"
            name = "username" placeholder = "username" required>
        <button type = "submit" name = "login">Login</button>
    </form>
</div>

   <a href = "register.php" >Register</a>
</body>
</html>
