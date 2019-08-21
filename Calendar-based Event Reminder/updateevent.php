 <?php
 
 require 'database.php';
header("Content-Type: application/json");


session_start();

$username=$_SESSION['username'];
 
 

    $title = $_POST['title'];
    $detail = $_POST['detail'];
    
    $start = $_POST['start'];    $end = $_POST['end'];
 $id = $_POST['id'];
    
    //echo ($start.$end .$id.$detail.$title);

	
$stmt = $mysqli->prepare("UPDATE event SET title=?, eventdetail=?, start=?, end=? WHERE eventid=?");
if(!$stmt){
     printf("update story  prep failed： %s\n", $mysqli->error);
   exit;
}
$stmt->bind_param('ssssi', $title, $detail, $start, $end, $id);
     

$stmt->execute();
$stmt->close();
 echo json_encode(array(
		"success" => true
	));
	exit;
	
?>