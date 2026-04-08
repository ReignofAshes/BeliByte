<?php
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

	include("classes to connect to db/isba2402_masterClassList.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['belibyte_userid']);

	$USER = $user_data;

	if(isset($_GET['id']) && is_numeric($_GET['id'])){ //will make sure url is numeric for security

		$profile = new Profile();
		$profile_data = $profile->get_profile($_GET['id']);

		if(is_array($profile_data)){
			$user_data = $profile_data[0];
		}	

	}

	//posting starts here
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$post = new Post();
		$id = $_SESSION['belibyte_userid'];
		$result = $post->create_post($id, $_POST, $_FILES);

		if($result == "") //don't want posts to duplicate if page is refreshed
		{
			header("Location: isba2402_profile.php");
			die;
		}else
		{
			echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";	
		}

	}

	//collect posts 
	$post = new Post();
	$id = $user_data['userid'];
	$posts = $post->get_posts($id);

	//collect friends
	$user = new User();
	$friends = $user->get_friends($id);
	$image_class = new Image();

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>BeliByte | Profile</title>
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
			margin-top: -160px;
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

			background-color: white;
			min-height: 400px;
			margin-top: 20px;
			color: #aaa;
			padding: 8px;
/*			width: 250px;
			flex: 1;*/

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
			min-width: 50px;
			cursor: pointer;
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

		<br>
		<?php include("isba2402_header.php"); ?>


		<!-- cover area-->
		<div style="width: 800px; margin: auto; min-height: 400px;">

			<div style="background-color: white; text-align: center; color: #405d9b;">
				
					<?php

						$image = "isba2402 placeholder images/cover-placeholder.png";
						if(file_exists($user_data['cover_image']))
						{
							$image = $image_class->get_thumb_cover($user_data['cover_image']);
						}

					?>

				<img src="<?php echo $image ?>" style="width: 100%;">

				<span style = "font-size: 12px;">
					<?php

						$image = "isba2402 placeholder images/personal logo.jpg";
						if($user_data['account_type'] == "Business")
						{
							$image = "isba2402 placeholder images/business logo.jpg";

						}
						if(file_exists($user_data['profile_image']))
						{
							$image = $image_class->get_thumb_profile($user_data['profile_image']);
						}

					?>
					<img id="profile_pic" src="<?php echo $image ?>"><br/>

					<a style= "text-decoration: none; color: #f0f" href="isba2402_change_prof_image.php?change=profile">Change Profile Picture</a>
					| <a style= "text-decoration: none; color: #f0f" href="isba2402_change_prof_image.php?change=cover">Change Cover Photo</a>

				</span>

				<br>	
					<div style="font-size: 20px; margin: 2px;">
						<a href="isba2402_profile.php?id=<?php echo $user_data['userid']?>">
							<?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?><br> 
						</a>

						<?php
							$mylikes = "";
							if($user_data['likes'] > 0){

								$mylikes = "(" . $user_data['likes'] . " Followers)";
							}
						?>

						<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">
							<input id="post_button" type="button" value="Follow <?php echo $mylikes ?>" style="margin-right: 10px; background-color: $9b409a; width: auto;">
						</a> 

					</div>
				<br>

				<a href="isba2402_index.php"> <div id="menu_buttons">Timeline</div></a>
				<a href="isba2402_profile.php?section=about&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">About</div></a> 
				<a href="isba2402_profile.php?section=following&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Following</div></a> 
				<a href="isba2402_profile.php?section=followers&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Followers</div></a> 
				<a href="isba2402_profile.php?section=photos&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons">Photos</div></a>
				<a href="isba2402_profile.php?section=settings"><div id="menu_buttons">Settings</div></a>

			</div>

		<!-- below cover area-->

		<?php

			$section = "default";
			if(isset($_GET['section'])){

				$section = $_GET["section"];
			}

			if($section == "default"){
				include("isba2402_profile_content_default.php");

			}elseif($section == "followers"){
				include("isba2402_profile_content_followers.php");

			}elseif($section == "following"){
				include("isba2402_profile_content_following.php");

			}elseif($section == "photos"){
				include("isba2402_profile_content_photos.php");

			}

		?>

	</div><!-- Cover area div to close cover area properly -->
	</body>
</html>