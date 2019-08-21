<?php
session_start();

//some fixed expression cite from courseWiki PHP and MySQL
//Connect to Database
require 'newMySQLConnection.php';

?>
 <!DOCTYPE html>
 		<html lang="en">
			<head>
     			<title> Share Your Story </title>
    			<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    		</head>
        <body>


<?php

$id = "";

//get story id and user id from url
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    //look for the specific story and display it
    $stmt = $mysqli->prepare("select link, content, title, img_url from stories where id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($link, $content, $title, $img_url);

    //if find one result
    if ($stmt->fetch()) {
        //display the title and content
        echo " <h1>" . htmlentities($title) . "</h1>";
        echo "<p>" . htmlentities($content);
        echo "</p>";

        if(strlen($img_url) > 0){
            echo '<p><img src="' . $img_url .'" alt = "" height="100" width="100"></p>';
        }

        if (isset($_SESSION['id'])) {
            //if logged in user, add link for adding comment, bookmarking and like
            echo "
            <div class='edit-delete'> 
            <form action='addComment.php' method='POST' >
            <input type='hidden' name='story_id' value='" . $id . "' />
            <input type='hidden' name='link' value='" . $link . "' />
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='submit' value='Add Comment'>
            </form>";
            $stmt->close();

            echo "
            <form action='addBookmark.php' method='POST' >
            <input type='hidden' name='story_id' value='" . $id . "' />
            <input type='hidden' name='link' value='" . $link . "' />
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='submit' value='Bookmark this story'>
            </form> </div>";

            //count and display likes for the story
            $stmt = $mysqli->prepare("select count(*) from likes where story_id = ?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($count);
            if ($stmt->fetch()) {
                echo "likes: " . $count . "<br>";
            }
            echo "
            <form action='addLike.php' method='POST'>
            <input type='hidden' name='story_id' value='" . $id . "' />
            <input type='hidden' name='link' value='" . $link . "' />
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='submit' value='Like'>
            </form>";
        }

        $stmt->close();

        //update likes field in story table
        $stmt = $mysqli->prepare("update stories set likes = ? where id = ? ");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('ii', $count, $id);
        $stmt->execute();
        if ($stmt->fetch()) {
            echo "likes: " . $count . "<br>";
        }

    }
    $stmt->close();

    //look for comments
    $stmt = $mysqli->prepare("select posted_time, comments.id, user_id, content, first_name from comments
    join users on comments.user_id = users.id
    where story_id = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($posted_time, $comment_id, $user_id, $content, $first_name);
    //display all the comments if found
    echo "<h2>Comments:</h2>";
    while ($stmt->fetch()) {
        echo " <b style='font-size:20px'>" . htmlentities($first_name) . "</b> &nbsp;&nbsp;";
        echo "<a>" . $posted_time . "</a>&nbsp;&nbsp;";
        echo "<p style='font-size:20px'>" . htmlentities($content) . "</p>";
        if ((isset($_SESSION['id']) && $_SESSION['id'] == $user_id) || isset($_SESSION['admin'])) {
            //if logged in user and the user_id mathes the comment's one, add link for edit and delete
            //or if user is admin
            echo " <div class='edit-delete'>
            <form action='editComment.php' method='POST'>
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='hidden' name='comment_id' value='" . $comment_id . "' />
            <input type='hidden' name='link' value='" . $link . "' />
            <input type='submit' value='Edit'>
            </form>";
            echo "
            <form action='deleteComment.php' method='POST'>
            <input type='hidden' name='token' value='" . $_SESSION['token'] . "' />
            <input type='hidden' name='comment_id' value='" . $comment_id . "' />
            <input type='hidden' name='link' value='" . $link . "' />
            <input type='submit' value='Delete'>
            </form>  </div> ";
        }
    }
    $stmt->close();
    if (isset($_SESSION['id'])){
        echo "<br><a href='stories.php?displayAll=1'>Back to all stories</a><br>";
        echo "<br><a href='stories.php'>Back to your stories</a><br>";
        echo "<br><a href='main.php'>Back to main page</a><br>";
        echo "<br><a href='logout.php'>Log out</a><br>";
    } else {
        echo "<a href='stories.php?displayAll=1'>Back </a><br>";
    }
}

?>
</body></html>