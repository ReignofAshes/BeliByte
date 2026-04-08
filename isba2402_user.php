
<div id="friends" style= "display: inline-block;">
	<?php

		$image = "isba2402 placeholder images/personal logo.jpg";
		if($FRIEND_ROW['account_type'] == "Business")
		{
			$image = "isba2402 placeholder images/business logo.jpg";
		}

		if(file_exists($FRIEND_ROW['profile_image'])) //switch to show friend's page
		{
			$image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
		}

	?> 

	<a href="isba2402_profile.php?id=<?php echo $FRIEND_ROW['userid']; ?>"> <!-- MUST have "echo" to report the unique userid -->
		<img id="friends_img" src="<?php echo $image ?>">
		<br>
		
		<?php echo $FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name'] ?>
	</a>

</div>	