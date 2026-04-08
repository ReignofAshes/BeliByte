<?php

class Database
{

	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $db = "belibyte_db";

	function connect()
	{

		$connection = mysqli_connect($this->host, $this->username, $this->password,$this->db); // check "AUTO_INCREMENT" for "id" to prevent Primary Key duplicate error
		return $connection; //return means exit the function

	}

	function read($query)
	{

		$conn = $this->connect();
		$result = mysqli_query($conn, $query); //this saves the actual data into the db 

		if(!$result)
		{
			return false;
		}
		else
		{
			$data = false;
			while($row = mysqli_fetch_assoc($result))
			{

				$data[] = $row; //makes an array for all the data

			}

			return $data;

		}

	}

	function save($query)
	{

		$conn = $this->connect();
		$result = mysqli_query($conn, $query); //this saves the actual data into the db 

		if(!$result)
		{
			return false;
		}
		else
		{
			return true;
		}

	}

}

