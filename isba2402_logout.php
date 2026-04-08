<?php

session_start();

if(isset($_SESSION['belibyte_userid']))
{

	$_SESSION['belibyte_userid'] = NULL; //redundant but useful to have for practice
	unset($_SESSION['belibyte_userid']);

}

header("Location: isba2402_login.php");
die;