<?php
session_start();

//if user does not log in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (!isset($_POST['token'])) {
    die("You cannot directly view this page");
}

//check CSRF token
if (!hash_equals($_SESSION['token'], $_POST['token'])) {
    die("Request forgery detected");
}

//     Connect to Database
require 'newMySQLConnection.php';

//get user id from session
$user_id = $_SESSION['id'];
$displayAll = $_POST['displayAll'];
$title = "";
$content = "";
$link = "";
$full_path = "";

//try to upload image
if (isset($_POST['upload'])) {

    $path = "images"; //make directory path

    $content = $_POST['content'];
    $title = $_POST['title'];

    if (isset($_POST["MAX_FILE_SIZE"])) {
        $max_file_size = $_POST["MAX_FILE_SIZE"];
    }

    // Get the filename and make sure it is valid
    $filename = basename($_FILES['uploadedfile']['name']);
    if (strlen($filename) == 0) {
        echo "No image selected";
    } else if (!preg_match('/^[\w_\.\-]+$/', $filename)) {
        echo "Image name invalid";
    } else if (filesize($_FILES['uploadedfile']['tmp_name']) > $max_file_size) {
        echo "File too large!";
    } else {

        //make full path for the file location
        $full_path = sprintf("%s/%s", $path, $filename);

        //try to upload image
        if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path)) {
            
        } else {
            echo "Failed to upload image";
            $full_path = "";
        }
    }
}

// if user submits the form and this is a call back page
if (isset($_POST['submit'])) {

    //get title and content inputed by user
    $title = $_POST['title'];
    $content = $_POST['content'];
    $full_path = $_POST['full_path'];

    if (strlen($title) == 0) {
        echo "Please enter title";
    } else if (strlen($content) == 0) {
        echo "Please enter content";
    } else {

        //Try to insert the new things inputed by user into database
        //make this random validate field to look back for id
        $validate = bin2hex(openssl_random_pseudo_bytes(32));
        $stmt = $mysqli->prepare("insert into stories (user_id, title, content, link, img_url, validate) values (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('isssss', $user_id, $title, $content, $link, $full_path, $validate);
        if (!$stmt->execute()) {
            echo $mysqli->error;
            echo "Failed to create the new story";
            $stmt->close();
        } else {
            $stmt->close();
            //if successfully insert the new story, then get story id and generate a link for it
            //look for story id after inserting one result
            $stmt = $mysqli->prepare("select id from stories where title = ? and validate = ?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('ss', $title, $validate);
            $stmt->execute();
            $stmt->bind_result($id);

            //create the link for the story
            if ($stmt->fetch()) {
                $link = "http://ec2-54-157-25-173.compute-1.amazonaws.com/~Joey/module3/story.php?id=" . $id;
                echo $link;
            }
            $stmt->close();
            //Try to update the link
            $stmt = $mysqli->prepare("update stories set link = ? where id = ?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('ss', $link, $id);
            $stmt->execute();
            echo $mysqli->error;
            $stmt->close();
            if (strcmp($displayAll, "1") != 0) {
                header("Location: stories.php");
            } else {
                header("Location: stories.php?displayAll=1");
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
    	<title>New Story</title>
    	<link rel="stylesheet" type="text/css" href="StyleSheet.css">
    </head>

    <body>
    	<form enctype="multipart/form-data" action="newStory.php" method="POST">
        <h3> Title:</h3>
    	<input type="text" name="title"  placeholder = "title" value = "<?php echo $title; ?>"/><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
        <input type='hidden' name='displayAll' value='<?php echo $displayAll ?>' />
        <input type='hidden' name='full_path' value='<?php echo $full_path ?>' />
    	<h3> Content:</h3>
        <textarea rows="7" cols="50" name="content" ><?php echo $content; ?></textarea><br><br>
        <?php
if (strlen($full_path) != 0) {
    echo '<img src="' . $full_path . '" alt = "" height="100" width="100">';
}
?>
        <p>
		        <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		        <label for="uploadfile_input">Choose an image to upload:</label>
                <input name="uploadedfile" type="file" id="uploadfile_input" />
	    </p>
        <label >Note: the image won't work if it is not supported</label><br>
    	<input type="submit" name = "upload" value="Upload File" /><br>
        <input type="submit" name = "submit" value="Submit Form"><br>
        </form>

    	<a href="stories.php?displayAll=<?php echo $displayAll ?>">Back</a>
    </body>
</html>
