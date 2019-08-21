<!DOCTYPE html>
<html lang="en" xml:lang="en">
	<head>
		<title>The Answer </title>
	</head>
	<body>
		<?php
			$first = (float)$_GET["first"];
			$second = (float)$_GET["second"];
			$oper = $_GET["oper"];
			
			echo "The answer is  ";
			
			if($first=="" || $second=="") {
				echo htmlentities("unvalid.  Both numbers need to be typed in.");
				exit();
			} 
			
			switch($oper){
				case "add":
					echo $first + $second;
					break;
				case "subtract":
					echo $first - $second;
					break;
				case "multiply":
					echo $first * $second;
					break;
				case "divide":
					if ($second == 0){
        				echo htmlentities("unvalid.  Cannot be divided by zero.");
        				exit();
    				} else {
        				echo $first / $second;
   				 	}
			}
		?>
	</body>
</html>
	
	