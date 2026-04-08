<?php

class Signup
{

	private $error = ""; //will check if there are empty inputs 
	public function evaluate($data)
	{

		foreach ($data as $key => $value) 
		{	
			if(empty($value))
			{
				$this->error = $this->error . $key . " is empty.<br>"; //use $this-> on all error returns to access variables from inside
			}

			if($key == "email")
			{
				if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {

					$this->error = $this->error . "Please enter a valid email address.<br>"; 
				}

			}

			if($key == "first_name")
			{
    			if (!preg_match("/^[a-zA-Z-]+$/", $value)) {
       	 			$this->error .= "First name can only contain letters and hyphens.<br>";
				}

    			if (strstr($value, " ")) {
       	 			$this->error .= "First name cannot have spaces.<br>";
       	 		}
			}


			if($key == "last_name")
			{
    			if (!preg_match("/^[a-zA-Z-]+$/", $value)) {
       	 			$this->error .= "Last name can only contain letters and hyphens.<br>"; 
				}

				if (strstr($value, " ")) {
       	 			$this->error .= "Last name cannot have spaces.<br>";
       	 		}
       	 	}
       	 }


		if (!isset($data['password']) || empty($data['password'])) {
			   $this->error .= "Password is required.<br>";
		}

		if (!isset($data['password2']) || empty($data['password2'])) {
			    $this->error .= "Password confirmation is required.<br>";
		}

		if (isset($data['password']) && isset($data['password2'])) {
			if ($data['password'] !== $data['password2']) {
			    $this->error .= "Passwords must match.<br>";

			}
		}

		if($this->error == "")
		{

			//no error
			$this->create_user($data); //will move to the user creation function
		}
		else
		{
			return $this->error; //this will show the user if they miss an input
		}
	}
		

	public function create_user($data)
	{

		$first_name = addslashes(ucfirst($data['first_name']));		
		$last_name = addslashes(ucfirst($data['last_name']));
		$account_type = $data['account_type'];
		$email = addslashes($data['email']);
		$password = addslashes(($data['password']));

		//create urls and userids
		$url_address = strtolower($first_name) . "." . strtolower($last_name);
		$userid = $this->create_userid();

		$query = "insert into 
		users (userid, first_name, last_name, account_type, email, password, url_address) 
		values ('$userid', '$first_name', '$last_name', '$account_type', '$email', '$password', '$url_address')";

		//echo $query; //uncomment to check without adding to database

		$DB = new Database(); //comment out to check but not add to database yet
		$DB->save($query);

	}

	private function create_userid()
	{

		$length = rand(4, 19); #length of the user id random from 4 to 19 digits
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			
			$new_rand = rand(0, 9);

			$number = $number . $new_rand;
		}
		return $number; //return the generated ID into the db

	}

}