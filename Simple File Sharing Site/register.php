<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user already logged in, redirect to main page
if (isset($_SESSION['user']) && strlen($_SESSION['user']) != 0) {
    header("Location: userMain.php");
}

$username = "";

$dir = dirPath(); //get directory path

$flag = 0;

if (isset($_GET["username"])) { //if user clicks register button
    $username = $_GET["username"]; //get username inputed by user
}

//check if user enters invalid username
if (strlen($username) != 0) {
    if (!preg_match('/^[\w_\-]+$/', $username)) {
        echo "Invalid username";
        $flag = 1;
    }

    //open users.txt file to find all the usernames and check if the username already exists
    $h = fopen(usersCredentialFilePath(), "r");
    while (!feof($h)) { //read file line by line
        $inputUsername = substr(fgets($h), 0, -1); //omit last character
        if (strcmp($username, $inputUsername) == 0) { //if username exists, redirect user to failure page
            echo "Username exists";
            $flag = 1;
        }
    }

    //if inputed username is valid, append it to the file and redirect user to main page
    if ($flag == 0) {
        $h = fopen(usersCredentialFilePath(), "a");
        fwrite($h, $username . "\n");
        $userdir = $dir . '/' . $username;
        mkdir($userdir); //make new directory for the new user

        //change permission for the new directory
        chown($userdir, "apache"); 
        chmod($userdir, 0755);
        
        $_SESSION['user'] = $username;
        header("Location: userMain.php");
    }

    fclose($h);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"><title> Registor </title>
	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
</head>
<body>
<div class = "container">
    <form  action = "register.php" method = "get">
        <input type = "text"
            name = "username" placeholder = "username" required>
        <button type = "submit" name = "register">Register</button>
    </form>
</div>

</body>
</html>
