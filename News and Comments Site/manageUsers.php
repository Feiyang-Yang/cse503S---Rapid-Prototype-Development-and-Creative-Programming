<?php
session_start();
?>

 <!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title> ManageUsers </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>

<?php
//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (!isset($_SESSION['admin'])) {
    die("You cannot directly view this page");
}

//     Connect to Database
require 'newMySQLConnection.php';

//get user id from session
$user_id = $_SESSION['id'];
$content = "";

//Try to display all the users except admin users
$stmt = $mysqli->prepare("select id, username, first_name, last_name from users where role_id = 0");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->execute();
$stmt->bind_result($id, $username, $first_name, $last_name);

//display all the users and the edit and delete link
while ($stmt->fetch()) {
    echo "<div class='edit-delete'> username: " . $username . " first name: " . $first_name;
    echo " <br/>
    <form action='editUser.php' method='POST' >
    <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
    <input type='hidden' name='id' value='" . $id . "' />
    <input type='hidden' name='user' value='" . $username . "' />
    <input type='hidden' name='first_name' value='" . $first_name . "' />
    <input type='hidden' name='last_name' value='" . $last_name . "' />
    <input type='submit' value='Edit' >
    </form>
    <form action='deleteUser.php' method='POST' >
    <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
    <input type='hidden' name='id' value='" . $id . "' />
    <input type='submit' value='Delete'>
    </form>  </div>";
}
$stmt->close();

//back to previous story page
echo "<br><a href='main.php'>Back</a><br>";
?>
</body></html>
