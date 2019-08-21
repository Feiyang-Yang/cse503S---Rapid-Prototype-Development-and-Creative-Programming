<?php
session_start();

//if user does not log in, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

$username = $_SESSION['user'];//get username from session

include 'function.php'; //include the file which contains all the functions

echo generateHeader();

$dir = dirPath(); //get directory path

//find user directory
$dir = $dir . '/' . $username . "/*";

//list all files in his directory
$files = glob($dir);
foreach ($files as $file) {
    $filename = substr($file, strlen(dirPath()) + strlen($username) + 2); //omit file path to only show file name
    echo $filename;
    echo '
    <a href="./userViewFile.php?file=' . $filename . '">View</a>
    <a href="./delete.php?file=' . $filename . '">Delete</a>
    <a href="./share.php?file=' . $filename . '">Share</a><br>';
}

?>

<!--cited from course PHP wiki "Uploading a File"-->
<form enctype="multipart/form-data" action="upload.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form>
<a href = "update.php">Change Username</a>
<a href = "logout.php">Log out</a>
<a href = "cancelConfirm.php">Cancel Account</a>
</body>
</html>
