<?php //make sure to add php tags to connect your html links to the db and php

	include("classes to connect to db/isba2402_connect.php");
	include("classes to connect to db/isba2402_signupClass.php");

	//placeholders that start empty until values are each input/incase "sign up" is clicked prematurely
	$first_name = "";
	$last_name = "";
	$account_type = "";
	$email = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST') //check to make sure ppl fill out the sign up forms correctly
	{

		$signup = new Signup();
		$result = $signup->evaluate($_POST);

		if($result != "") 
		{

			echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
			echo "<br>The following error(s) occured:<br><br>";
			echo $result;
			echo "</div>";			

		}else
		{
			//Redirects to the log in page - this must happen before official html starts

			header("Location: isba2402_login.php");
			die;

		}

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$account_type = $_POST['account_type'];
		$email = $_POST['email'];
	}


?>

<html>
	
	<head>
		<title>BeliByte | Sign Up</title>
	</head>

	<style>
		#bar {
			height:100px; 
			background-color:rgb(59, 89, 152); 
			color:#d9dfeb; 
			padding: 4px;

		}

		#signup_button {
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

			<div style="font-size: 40px;"> BeliByte </div> 
			<div id="signup_button"> <a href="isba2402_login.php"> Log In </a></div>

		</div>

		<div id="bar2">
			
			Sign Up for BeliByte<br><br>

			<form method="post" action=""> 
			
				<input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First Name"><br><br>
				<input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last Name"><br><br>
				<input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Email"><br><br>

				<input name="password" type="password" id="text" placeholder="Password"><br><br>
				<input name="password2" type="password" id="text" placeholder="Retype Password"><br><br>

				<span style="font-weight: normal">Account Type:</span><br>
				<select id="text" name="account_type">

					<option><?php echo $account_type ?></option>	
					<option>Personal</option>	
					<option>Business</option>	

				</select><br><br>

				<input type="submit" id="button" value="Sign Up"><br><br>
				<br><br><br>

			</form>

		</div>

	</body>

</html>
