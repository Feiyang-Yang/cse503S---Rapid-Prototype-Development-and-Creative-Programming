<?php
    require 'database.php';
	ini_set("session.cookie_httponly", 1);
		session_start();
		$_SESSION['username'] = "guest";
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
 
$username = $_POST['username'];
$password = $_POST['password'];
 
// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)
  $stmt = $mysqli->prepare("select  username, hashpass from user where username = ?");
      $stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result( $username, $realpassword);
	$stmt->fetch();

if( crypt($password,$realpassword)==$realpassword ){
//	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
      // $("p2").show();
	echo json_encode(array(
		"success" => true,
	"username" =>	$username
	)
	//	$username;			 
					 );
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password",
		"username" =>"guest"
	));
	exit;
}
?>
    
    
    
    
    