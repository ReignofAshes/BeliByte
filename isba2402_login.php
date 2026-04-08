<?php //make sure to add php tags to connect your html links to the db and php

//session_start();
include("classes to connect to db/isba2402_masterClassList.php");
// include("classes to connect to db/isba2402_loginClass.php");

	//practice hashing user db info \ NOTE ONLY REFRESH ONCE

		// ini_set("display_errors",1);
		// $DB = new Database();
		// $sql = "select * from users ";
		// $result = $DB->read($sql);

		// foreach ($result as $row) {
		// 	$id = $row['id'];
		// 	$password = hash("sha1", $row['password']); //make sure your passwords have enough space to accommodate the hashing
		// 	$sql = "update users set password = '$password' where id='$id' limit 1"; //SHOULD ONLY BE DONE ONCE or it'll rehash
		// 	$DB->save($sql);
		// }

		// die;

//placeholders that start empty until values are each input/incase "sign up" is clicked prematurely
	$email = "";
	$password = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST') //check to make sure ppl fill out the sign up forms correctly after clicking the button "signup" or "login"
	//_ creates a global variable

	{

		$login = new Login();
		$result = $login->evaluate($_POST); //$_POST stores the information to interact with the other classes

		if($result != "") 
		{

			echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";			

		}else
		{
			//Redirects to the log in page if no errors - this must happen before official html starts

			header("Location: isba2402_profile.php");
			die;

		}

		$email = $_POST['email'];
		$password = $_POST['password'];
	}


?>

<html>
	
	<head>
		<title>BeliByte | Log In</title>
	</head>

	<style>
		#bar {
			height:100px; 
			background-color:rgb(59, 89, 152); 
			color:#d9dfeb; 
			padding: 4px;

		}

		#signup_button {
			text-decoration: none;
			background-color: #42b72a;
			width: 70px;
			text-align: center;
			padding: 4px;
			border-radius: 4px;
			float: right;


		}

		#bar2 {
			 background-color: white; 
			 width: 800px; 
			 margin: auto; 
			 margin-top: 50px;
			 padding:10px;
			 padding-top:80px;
			 text-align: center;
			 font-weight: bold;

		}

		#text {
			height: 30px;
			width: 300px;
			border-radius: 4px;
			border: solid 1px #ccc;
			padding: 4px;
			font-size: 14px;

		}

		#button {

			width: 300px;
			height: 40px;
			border-radius: 4px;
			border: none;
			background-color:rgb(59, 89, 152); 
			color: white;
			font-weight: bold;
		}

	</style>

	<body style="font-family: tahoma; background-color: #e9efee;">

		<div id="bar">

			<div style="font-size: 40px;"> BeliByte </div><br>
			Welcome to the Belindaverse! 
			<div id="signup_button"> 
				<a href="isba2402_signup.php">Signup</a>
			</div>

		</div>

		<div id="bar2">
			
			<form method="post">

				Log in to BeliByte<br><br>

				<input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email"><br><br>
				<input name="password" value="<?php echo $password ?>"type="password" id="text" placeholder="Password"><br><br>

				<input type="submit" id="button" value="Log In"><br><br>
				<div style="font-size:12px;"><a href="isba2402_whoopspage.php">Forgot Password?</a></div>

				<br><br><br>
			</form>
		</div>

	</body>

</html>
