<?php
session_start();

//some fixed expression cite from courseWiki PHP and MySQL
//Connect to Database
require 'newMySQLConnection.php';

$user_id = "";
//if user logs in, get user id
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
}

//if user wants to display all the stories
$displayAll = "";
if (isset($_GET['displayAll'])) {
    $displayAll = $_GET['displayAll'];
}else if (isset($_POST['displayAll'])) {
    $displayAll = $_POST['displayAll'];
}

$username = "";
$password = "";
$title = "";
$dateBefore = "";
$dateAfter = "";
$first_name = "";
$content = "";
$sqlStatement = "select img_url, stories.id, likes, posted_time, first_name, stories.id, user_id, content, link, title
from stories join users on stories.user_id = users.id";

//get user input and pre-populate the form
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    if (isset($_POST['first_name'])) {
        $first_name = $_POST['first_name'];
    }
    $content = $_POST['content'];
    $dateBefore = $_POST['dateBefore'];
    $dateAfter = $_POST['dateAfter'];
}
?>
 <!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title> Share Your Story </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>
        <form action="stories.php" method="POST">
        <?php
//if it is not in a specific user stories page, then show the input text field for name search criteria
if ($displayAll == 1) {
    echo '<label>First Name: <input type="text" name="first_name" placeholder = "First Name"/><br></label>';
}
?>
    		 <label>Title: <input type="text" name="title" placeholder = "Title" value = '<?php echo $title ?>'/><br></label>
    		 <label>Content: <input type="text" name="content" placeholder = "Content" value = '<?php echo $content ?>'/><br></label>
             Date between: <input type="date" name="dateBefore" value = '<?php echo $dateBefore ?>' />
             <input type="date" name="dateAfter" value = '<?php echo $dateAfter ?>'/><br>
             <input type='hidden' name='displayAll' value=' <?php echo $displayAll ?>' />
    		 <input type="submit" value="Search"><br><br>
    	</form>
        

<?php

if(strlen($user_id) != 0){
    echo "
    <form action='newStory.php' method='POST'>
    <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
    <input type='hidden' name='displayAll' value='" . $displayAll . "' />
    <input type='submit' value='Make a New Story'>
    </form><br>";
}

//call back page from seach button clicked
if (isset($_POST['title'])) {
    //make sql statement for search
    $sqlStatement = $sqlStatement . " where ";
    if (strlen($title) != 0 || strlen($first_name) != 0 || strlen($content) != 0
        || strlen($dateBefore) != 0 || (strlen($dateAfter) != 0)) {
        if (strlen($title) != 0) {
            $sqlStatement = $sqlStatement . " title like '%" . $title . "%' and ";
        }
        if (strlen($first_name) != 0) {
            $sqlStatement = $sqlStatement . " first_name like '%" . $first_name . "%' and ";
        }
        if (strlen($content) != 0) {
            $sqlStatement = $sqlStatement . " content like '%" . $content . "%' and ";
        }
        if (strlen($dateBefore) != 0) {
            $sqlStatement = $sqlStatement . " posted_time >= '" . $dateBefore . "' and ";
        }
        if (strlen($dateAfter) != 0) {
            $sqlStatement = $sqlStatement . " posted_time <= '" . $dateAfter . " 23:59:59' and ";
        }
    }
    if (strlen($user_id) != 0 && $displayAll != 1) {
        $sqlStatement = $sqlStatement . " user_id = ? and ";
    }
    $sqlStatement = $sqlStatement . " 1=1 order by posted_time";

} else {
    //if this is not a call back page
    if (strlen($user_id) != 0 && $displayAll != 1) {
        $sqlStatement = "select img_url, stories.id, likes, posted_time, first_name, stories.id, user_id, content, link, title
    from stories join users on stories.user_id = users.id where user_id = ? order by posted_time";
    } else {
        $sqlStatement = "select img_url, stories.id, likes, posted_time, first_name, stories.id, user_id, content, link, title
    from stories join users on stories.user_id = users.id order by posted_time";
    }
}

//find and display the corresponding results
$stmt = $mysqli->prepare($sqlStatement);
if (strlen($user_id) != 0 && $displayAll != 1) {
    $stmt->bind_param('i', $user_id);
}
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->execute();
$stmt->bind_result($img_url, $story_id, $likes, $posted_time, $first_name, $id, $story_user_id, $content, $link, $title);

while ($stmt->fetch()) {
    //display all the story information saved in database
    echo "  <a style='font-size:24px'  href='" . $link . "'>" . htmlentities($title) . "</a>  &nbsp;&nbsp;";
    if (strlen($user_id) == 0 || $displayAll == 1) {
        echo "<a>posted by " . htmlentities($first_name) . "</a> &nbsp;&nbsp;";
    }
    echo " <a>" . $posted_time . "</a>  &nbsp;&nbsp;";
    echo "likes: " . $likes;

    if(strlen($content) < 30){
        echo "<p>" . htmlentities($content) . "</p> ";
    }else{
        echo "<p>" . htmlentities($content) . substr(0, 30) . "...</p> ";
    }
    if(strlen($img_url) > 0){
        echo '<p><img src="' . $img_url .'" alt = "" height="100" width="100"></p>';
    }

    //if logged in user and the user id of the story matches the current user, then add link for edit and delete
    //or if user is admin
    if ((strlen($user_id) != 0 && $user_id == $story_user_id) || isset($_SESSION['admin'])) {
        echo "
            <form action='editStory.php' method='POST' >
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='hidden' name='id' value='" . $id . "' />
            <input type='hidden' name='displayAll' value='" . $displayAll . "' />
            <input type='submit' value='Edit' >
            </form>
            <form action='deleteStory.php' method='POST' >
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='hidden' name='id' value='" . $id . "' />
            <input type='hidden' name='displayAll' value='" . $displayAll . "' />
            <input type='submit' value='Delete'>
            </form><br/>";
    }
}
$stmt->close();

if (strlen($user_id) != 0) {
    echo "<br><br><a href='main.php'>Back </a><br>";
    echo "<a href='logout.php'>Log out</a><br>";
} else {
    echo "<a href='login.php'>Back </a><br>";
}

?>
</body></html>
