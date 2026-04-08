<?php

	//unset($_SESSION['belibyte_userid']); //use to force log out for troubleshooting

	include("classes to connect to db/isba2402_masterClassList.php");

// <?php

	$login = new Login();
	$user_data = $login->check_login($_SESSION['belibyte_userid']);
	$Post = new POST();

 	$ERROR = "";
 	if(isset($_GET['id'])){
 		
 		$ROW = $Post->get_one_post($_GET['id']);

 		if(!$ROW){
			
			$ERROR = "No such post was found.";

 		}else{

 			if($ROW['userid'] != $_SESSION['belibyte_userid']){

 				$ERROR = "Access denied. You can't delete this post.";
 			}
 		}

 	}else{
		$ERROR = "No such post was found.";
 	}
 		
 	//if something was posted
 	if($_SERVER['REQUEST_METHOD'] == "POST"){

 		$Post->delete_post($_POST['postid']);
 		header("Location: isba2402_profile.php");
 		die;
 	}

	// if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	//     die("<p style='color: red;'>ERROR: Invalid or missing post ID.</p>");
	// }

	// $post_id = intval($_GET['id']);


 	// //check if a post id is provided
 	// if(!isset($_GET['id']) || empty($_GET['id'])){
 	// 	die("<p style='color: red;'>ERROR: No post ID provided in the URL.</p>");
 	// }

 	// $post_id = $_GET['id'];
 	// echo "DEBUG: Full URL: " . htmlspecialchars($_SERVER['REQUEST_URI']) . "<br>";
 	// echo "DEBUG: Post ID received from URL: " . $_GET['id'] . "<br>";

 	// //retrieve post data
 	// $Post = new Post();
 	// $ROW = $Post->get_one_post($post_id);

 	// //if post not found
 	// if (!$ROW) {
 	// 	// die("<p style='color: red;'>ERROR: No post found in the database for ID: " . $post_id . "</p>");
 	// 	die("
 	// 		<p style='color: red;'>ERROR: No such post was found.
	// 	    <a href='isba2402_profile.php'>
	// 	        <button style='background-color: #405d9b; border: none; color: white; padding: 10px; font-size: 14px; border-radius: 5px; cursor: pointer;'>
	// 	            Back to Profile
	// 	        </button>
	// 	    </a>
 	// 		");
 	// }

 	// //restrict access to non-owners of a post
	//  if (intval($ROW['userid']) !== intval($_SESSION['belibyte_userid'])) {
	//     die("
	//         <p style='color: red;'>ERROR: Access denied. You do not have permission to delete this post.</p>
	//         <a href='isba2402_profile.php'>
	//             <button style='background-color: #405d9b; border: none; color: white; padding: 10px; font-size: 14px; border-radius: 5px; cursor: pointer;'>
	//                 Back to Profile
	//             </button>
	//         </a>
	//     ");
	// }

 	// // **Handle Delete Request**
	// if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//     $DB = new Database();
	    
	//     // Delete post from database
	//     $query = "DELETE FROM posts WHERE postid = $post_id = ? LIMIT 1";
	//     $DB->save($query, [$post_id]);

	//     // If there's an image, delete it from the server
	//     if (!empty($ROW['image']) && file_exists($ROW['image'])) {
	//         unlink($ROW['image']);
	//     }

	//     // Redirect back to profile or posts page
	//     header("Location: isba2402_profile.php");
	//     die();
	// }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>BeliByte | Delete</title>
	</head>

	<style type="text/css">
		
		#blue_bar {

			height: 50px;
			background-color: #405d9b;
			color: #d9dfeb;

		}

		#search_box {

			width: 400px;
			height: 20px;
			border-radius:4px;
			border: none;
			padding: 4px;
			font-size: 14px;
			backgroung-image: url(search.png);
			background-repeat: no-repeat;
			background-position: right;

		}

		#profile_pic {

			width: 150px;
			border-radius: 50%;
			border:solid 2px white;

		}

		#menu_buttons {

			width: 100px;
			display: inline-block;
			margin: 2px;

		}

		#friends_img {

			width: 75px;
			float: left;
			margin: 8px;

		}

		#friends_bar {

			min-height: 400px;
			margin-top: 20px;
			color: #405d9b;
			padding: 8px;
			text-align: center;
			font-size: 20px;

		}

		#friends {

			clear: both;
			font-size: 12px;
			font-weight: bold;
			color: #405d9b;
		}

		textarea{

			width: 100%;
			border: none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;
		}

		#post_button {

			float: right;
			background-color: #405d9b;
			border: none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px;
		}


		#post_bar {

			margin-top: 20px;
			background-color: white;
			padding: 10px;

		}

		#post{

			padding:4px;
			font-size: 13px;
			display: flex;
			margin-bottom: 10px;
		}

	</style>

	<body style="font-family: tahoma; background-color: #d0d8e4;">

		<!-- top bar -->
		<?php include("isba2402_header.php"); ?>

		<!-- cover area-->
		<div style="width: 800px; margin: auto; min-height: 400px;">

			<!-- below cover area-->
			<div style="display: flex;">

			<!-- posts area-->
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">

					<div style="border: solid thin #aaa; padding: 10px; background-color: white;">

						<form method="post">

								<?php 
	
									if($ERROR != ""){

										echo $ERROR;
									}else{

										echo "Are you sure you want to delete this post?<br><br>";

										$user = new User();
										$ROW_USER = $user->get_user($ROW['userid']);

										include("isba2402_post_delete.php");

										echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
										echo "<div style='display: flex; gap: 10px; justify-content: flex-end;'>";
										echo "<input id='post_button' type='submit' value='Delete'>";
									}
								?>

										<a href="isba2402_profile.php" id="post_button" style="display: inline-block; text-decoration: none; background-color: #405d9b; color: white; padding: 5px; text-align: center;">
										    Cancel
										</a>
								</div>

						</form>
					
					</div>
				</div>

			</div>

	</body>
</html>