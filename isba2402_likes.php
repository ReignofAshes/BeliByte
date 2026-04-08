<?php

	//unset($_SESSION['belibyte_userid']); //use to force log out for troubleshooting

	include("classes to connect to db/isba2402_masterClassList.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['belibyte_userid']);

	$Post = new Post();

	$likes = false; //start the likes report empty first;

 	$ERROR = "";
 	if(isset($_GET['id']) && isset($_GET['type'])){
 		
 		$likes = $Post->get_likes($_GET['id'], $_GET['type']);

 	}else{
		$ERROR = "No information was found.";
 	}
 		
?>

<!DOCTYPE html>
<html>
	<head>
		<title>BeliByte | People Who Liked</title>
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

					<?php

							$User = new User();
							$image_class = new Image();

							if(is_array($likes)){

								//cycle through each user that may have liked the post
								foreach ($likes as $row) {

									$FRIEND_ROW = $User->get_user($row['userid']);
									include("isba2402_user.php");

							}
						}

					?>

						<br style= "clear: both;">
					
					</div>
				</div>

			</div>

	</body>
</html>