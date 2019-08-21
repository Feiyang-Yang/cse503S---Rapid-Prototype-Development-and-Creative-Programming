<?php
session_start();

include 'function.php'; //include the file which contains all the functions

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$dir = dirPath(); //get directory path

$username = $_SESSION['user'];//get username from session
$filename = $_GET["file"];
$selectedUser = "";
if (isset($_GET["selectedUser"])) { //if user clicks submit button
    $selectedUser = $_GET["selectedUser"];
    if(copy($dir . '/' . $username. '/' . $filename, $dir . '/' . $selectedUser. '/'  . $filename)){//copy file to the selected user directory
        echo "File successfully shared to " . $selectedUser .".";
    }else{
        echo "Failed to share file to " . $selectedUser .".";
    }
}

$username = $_SESSION['user']; //get username from session

echo generateHeader();

echo "<h1>Note: you will overwrite the file if it has the same name!<h1/>";

$dir = dirPath(); //get directory path

echo "<form action='share.php'>
<input type='hidden' name = 'file' value='".$filename."' />
<select name = 'selectedUser'>";   //start to generate drop down list

//open users.txt file to find all the usernames and generate all the values for the drop down list
$h = fopen(usersCredentialFilePath(), "r");

while (!feof($h)) { //read file line by line
    $inputUsername = substr(fgets($h), 0, -1); //omit last character
    if( !preg_match('/^[\w_\.\-]+$/', $inputUsername) || strcmp($username, $inputUsername) == 0){
        continue;
    }
    echo "<option value='" . $inputUsername . "'>" . $inputUsername . "</option>";
}

echo "</select><input type='submit'></form><a href = 'userMain.php' tite = 'Logout'>Back</a>";
fclose($h);
generateFooter()

?>