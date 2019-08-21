<?php
session_start();
	session_destroy();
//	header("Location: calendar.php");
    session_start();
    $_SESSION['username'] = "guest";
    echo json_encode(array(
		"success" => true,
        "username" =>"guest"
        
	));
	exit;
	
?>
