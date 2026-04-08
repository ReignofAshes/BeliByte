<?php

	//unset($_SESSION['belibyte_userid']); //use to force log out for troubleshooting

	include("classes to connect to db/isba2402_masterClassList.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['belibyte_userid']);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>BeliByte | Timeline</title>
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

			<!-- friends area-->
				<div style="min-height: 400px; flex: 1;">

					<div id="friends_bar">
						
						<img id="profile_pic" src="IMG_5765 (touched) - Square.png"><br>

						<a href="isba2402_profile.php" style="text-decoration: none;">
						<?php echo $user_data['first_name'] . "<br> " . $user_data['last_name'] ?>
						</a>

					</div>

				</div>


			<!-- posts area-->
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">

					<div style="border: solid thin #aaa; padding: 10px; background-color: white;">

						<textarea placeholder="What's on your mind?"></textarea>
						<input id="post_button" type="submit" value="Post">
						<br><br>
					</div>

			<!-- posts-->
			<div id="post_bar">

			<!-- post 1-->
				<div id="post">
					<div>
						<img src="graduation cap icon.png" style="width: 75px; margin-right: 4px;">
					</div>
					<div>
						<div style="font-weight: bold; color: #405d9b;">Education</div>
						Santa Clara University, MBA (Marketing and Data Analytics) <br>
						California State University, East Bay, Paralegal Certification <br>
						University of California, Berkeley, BFA
						<br>
						<a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999">2013-2025</span>

					</div>
				</div>


			<!-- post 2-->
				<div id="post">
					<div>
						<img src="resume-icon-png.png" style="width: 75px; margin-right: 4px;">
					</div>
					<div>
						<div style="font-weight: bold; color: #405d9b;">Work Experience</div>
						Snorkel AI, Data Annotator | Oct. 2024-Present<br>
						E&Y, Extern | 2024<br>
						Law Offices of Hannah Taylor | 2023-2024<br>
						Accenture, Intern | Summer 2023
						<br>
						<a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999">February 1, 2025</span>

					</div>
				</div>


			<!-- post 3-->
				<div id="post">
					<div>
						<img src="lightbulb-png.png" style="width: 75px; margin-right: 4px;">
					</div>
					<div>
						<div style="font-weight: bold; color: #405d9b;">Hobbies and Interests</div>
						Tennis<br>
						Coding (SQL and Python)<br>
						Animals<br>
						Piano/Classical Music<br>
						Calisthenics<br>
						<br>
						<a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999">February 1, 2025</span>

					</div>
				</div>




				</div>

			</div>

		</div>

	</body>
</html>