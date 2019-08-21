<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user']; //get username from session
$newusername = "";

$flag = 0;

if (isset($_GET["username"])) { //if user clicks update button
    $newusername = $_GET["username"]; //get username inputed by user

//check if user enters invalid username
    if (strlen($newusername) != 0) {
        if (!preg_match('/^[\w_\-]+$/', $newusername)) {
            echo "Invalid username";
            $flag = 1;
        } else {
            //open users.txt file to find all the usernames and check if the inputed username matched any of these
            $h = fopen(usersCredentialFilePath(), "r");
            while (!feof($h)) { //read file line by line
                $inputUsername = substr(fgets($h), 0, -1); //omit last character
                if (strcmp($newusername, $inputUsername) == 0) { //if username matches
                    echo "Username exists";
                    $flag = 1;
                }
            }
            fclose($h);
        }
    }

    if ($flag == 0) { //if username is valid
        //update username in users.txt
        $file = usersCredentialFilePath();
        file_put_contents($file, str_replace($username, $newusername, file_get_contents($file)));

        //copy current directory to new directory
        $userDir = dirPath() . "/";
        recurse_copy($userDir . $username, $userDir . $newusername);

        //remove old files and directory
        $userDir = dirPath() . "/" . $username;
        array_map('unlink', glob("$userDir/*.*"));
        rmdir($userDir);

        //change user session 
        $_SESSION['user'] = $newusername;

        echo "Successfully changed username";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> <meta charset="UTF-8"><title> Update </title>
<link rel="stylesheet" type="text/css" href="StyleSheet.css">
</head>

<body>
<div class = "container">

    <form  action = "update.php" method = "get">
        <input type = "text"
            name = "username" placeholder = "new username" required>
        <button type = "submit" name = "update">Update</button>
    </form>
   </div>

   <a href = "userMain.php" >Back</a>
</body>
</html>
