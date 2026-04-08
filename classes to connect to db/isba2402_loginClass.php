<?php
//session_start(); don't need it bc it's being called directly in isba2402_login.php
// require_once "classes to connect to db/isba2402_connect.php"; 

class Login
{
	// private $DB;

	private $error = ""; //this property will check if there are empty inputs 

	public function evaluate($data) //method that checks $data if its in our database
	{

		$email = addslashes($data['email']); //addslashes helps with security 
		$password = addslashes($data['password']);

		$query = "select * from users where email = '$email' limit 1 ";

		$DB = new Database(); //comment out to check but not add to database yet
		$result = $DB->read($query); //will read and return from the db class from "connect" to see if user already exists

		if ($result)
		{
			$row = $result[0];

			if ($password == $row['password'])
			{ 

				//create session data
				$_SESSION['belibyte_userid'] = $row['userid'];
				
			}else
			{
				$error .= "Incorrect email or password.<br>";
			}

		}else
		{

			return $error;
		}	

	}

	public function check_login($id) //checks the db to see if the user is logged in and not manipulating user ids
	{
		if(is_numeric($id)) //use is_numeric to protect against malicious attacks
		{

			$query = "select * from users where userid = '$id' limit 1"; //selecting all columns from table "users"

			$DB = new Database();
			$result = $DB->read($query);

			if($result)
			{

				$user_data = $result[0];
				return $user_data;

			}else
			{
				header("Location: isba2402_login.php");
				die;
			}

		}else
		{
			header("Location: isba2402_login.php");
			die;
		}

	}

}