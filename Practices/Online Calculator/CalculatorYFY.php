<!DOCTYPE html>
<html lang="en" xml:lang="en">
	<head>
		<title> Simple Calculator </title>
	</head>
	
	<body>
		<form action="CalculationYFY.php" method="GET">
			<p>
				<label for="firstNum">Enter First Number:</label>
				<input type="text" name="first" id="firstNum" />
			</p>
			<p>
				<label>Choose Operator:</label>
				<label for="addNum">Add</label> 
				<input type="radio" name="oper" id="addNum" value="add" checked="checked" />  &#9;
				<label for="subNum">Subtract</label>
				<input type="radio" name="oper" id="subNum" value="subtract"/>  &#9;
				<label for="mulNum">Multiply</label>
				<input type="radio" name="oper" id="mulNum" value="multiply"/>  &#9;
				<label for="divNum">Divide</label> 
				<input type="radio" name="oper" id="divNum" value="divide"/> 
			</p>
			<p>
				<label for="secondNum">Enter Second Number:</label>
				<input type="text" name="second" id="secondNum" />
			</p>
			<p>
				<input type="submit" value="Submit" />  &#9;
				<input type="reset" />
			</p>
		</form>
	</body>
</html>
