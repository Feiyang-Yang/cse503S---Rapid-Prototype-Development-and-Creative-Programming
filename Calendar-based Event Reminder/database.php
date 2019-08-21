<?php
// Connect to database. 
$mysqli = new mysqli('localhost', 'root', 'bonzo5597', 'calendar2');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>