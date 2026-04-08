<?php
//unset($_SESSION['belibyte_userid']); //use to force log out for troubleshooting

include("classes to connect to db/isba2402_masterClassList.php");

	$login = new Login();
	$user_data = $login->check_login($_SESSION['belibyte_userid']);

	$change = isset($_POST['change']) ? $_POST['change'] : "profile";
	//posting and files check
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
		{

			if($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png")
			{

			$allowed_size = (1024 * 1024) * 15; //should give us 15mb
			if($_FILES['file']['size'] < $allowed_size)
			{
				//everything is fine
				$folder = "uploads/" . $user_data['userid'] . "/"; //match a created folder to each user when they upload a photo

				//create the folder
				if(!file_exists($folder))
				{
					mkdir($folder, 0777, true); //remember to give file permissions
				}

				$image = new Image();

				$filename = $folder . $image->generate_filename(15) . ".jpg";
				move_uploaded_file($_FILES['file']['tmp_name'], $filename);

				$change = "profile";
					//check for mode
					if(isset($_GET['change']))
					{
						$change = $_GET['change'];
					}


				if($change == "cover")
				{
					if(file_exists($user_data['cover_image']))
					{
						unlink($user_data['cover_image']);
					}
					$image->resize_image($filename, $filename, 1500, 1500); //original image, new cropped image, width, height	

				}else
				{
					if(file_exists($user_data['profile_image']))
					{
						unlink($user_data['profile_image']);
					}
					$image->resize_image($filename, $filename, 1500, 1500); 					
				}

				if (file_exists($filename))
				{
					//saving the data to folder
					$userid = $user_data['userid'];

					if($change == "cover")
					{
						$query = "update users set cover_image = '$filename' where userid = '$userid' limit 1"; //update the users table to change the profile picture
						$_POST['is_cover_image'] = 1; 			

					}else

					{
					//protects and defaults again to profile if attempted manipulation
						$query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
						$_POST['is_profile_image'] = 1;	

					}

					$DB = new Database();
					$DB->save($query);

					//create a post 	
					$post = new Post();

					$post->create_post($userid, $_POST, $filename);


					header("Location: isba2402_profile.php");
					die;

				}	

			}else
			{
				echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo "Only images of size 15mb or lower are allowed.";
				echo "</div>";					
			}

		}else
		{
			echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo "Only jpeg and png types are allowed.";
			echo "</div>";	
		}
	}
	}else
	    if (isset($_FILES['file']) && $_FILES['file']['error'] != 0) 
		{
			echo "<div style = 'text-align: center; font-size: 12px; color: white; background-color: grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo "Please attach a valid image.";
			echo "</div>";				
		}
	

?>

<!DOCTYPE html>
<html>
	<head>
		<title>BeliByte | Change Profile Picture</title>
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

		#post_button {

			float: right;
			background-color: #405d9b;
			border: none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 80px;
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

					<form method="post" enctype="multipart/form-data"> 
					<div style="border: solid thin #aaa; padding: 10px; background-color: white;">

						<input type="file" name="file">
						<input type="hidden" name="change" value="<?php echo isset($_GET['change']) ? $_GET['change'] : 'profile'; ?>">
						<input id="post_button" type="submit" value="Confirm">
						<br><br> 

					<div style="text-align: center;">
						<br><br>
						<?php
							// show user the previous photo before changing
							//check for mode
							if(isset($_GET['change']) && $_GET['change'] == "cover")
							{

							$change = "cover";							
								echo "<img src='$user_data[cover_image]' style = 'width: 100%;' >";

							}else
							{
								echo "<img src='$user_data[profile_image]' style = 'max-width: 500px;' >";
							}


						?>
					</div>
						</div>
					</form>
				
				</div>

			</div>

		</div>

	</body>
</html>