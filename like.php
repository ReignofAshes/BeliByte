<?php
include("classes to connect to db/isba2402_masterClassList.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['belibyte_userid']);

// $Post = new Post();
// $ERROR = "";

//redirect when clicking "like"
if(isset($_SERVER['HTTP_REFERER'])){
	$return_to = $_SERVER['HTTP_REFERER'];

}else{
	$return_to = "isba_2402_profile.php";		
}

	if(isset($_GET['type']) && isset($_GET['id'])){

		//safe measure
		if(is_numeric($_GET['id'])){

			//whitelist your types to be liked (array)
			$allowed[] = 'post';
			$allowed[] = 'user';
			$allowed[] = 'comment';

			if(in_array($_GET['type'], $allowed)){

				$post = new Post();
				$user_class = new User();
				$post->like_post($_GET['id'], $_GET['type'], $_SESSION['belibyte_userid']);	

				if($_GET['type'] == "user"){

					$user_class->follow_user($_GET['id'], $_GET['type'], $_SESSION['belibyte_userid']);	
				}
				
			}
		}	
	}
	
header("Location: " . $return_to);
die;