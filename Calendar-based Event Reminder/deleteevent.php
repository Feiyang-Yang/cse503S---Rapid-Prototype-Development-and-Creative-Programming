<?php
 require 'database.php';
header("Content-Type: application/json");


session_start();

$username=$_SESSION['username'];
 $id = $_POST['id'];
         $stmt1 = $mysqli->prepare("delete from event where eventid=?");
         
         
         	if(!$stmt1) {
				echo "error in preparing delete comment";
			}

			$stmt1->bind_param('i',$id);
			$stmt1->execute();
            $stmt1->close();
            
       
    echo json_encode(array(
		"success" => true
	));
	exit;
        ?>
        