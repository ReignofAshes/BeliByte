<!-- top bar -->
<?php

// // Check if the user is logged in
	if (isset($_SESSION['belibyte_userid'])) {
	    $login = new Login();
	    $USER = $login->check_login($_SESSION['belibyte_userid']);
	} else {
	    $USER = null;
	}

	$corner_image = "isba2402 placeholder images/personal logo.jpg";
	
	if (isset($USER['profile_image']) && !empty($USER['profile_image']) && file_exists($USER['profile_image'])) {
	    $image_class = new Image(); // Redundant, but ensures other pages activate this
	    $corner_image = $image_class->get_thumb_profile($USER['profile_image']);
	} else {
	    if ($USER['account_type'] == "business") {
	        $corner_image = "isba2402 placeholder images/business logo.jpg";
	    }
	}
	
?>

<div id="blue_bar">
	<div style="width: 800px; margin: auto; font-size: 30px;">

	<a href="isba2402_index.php" style="color: white; text-decoration: none;"> BeliByte</a> 

	&nbsp &nbsp <input type="text" name id="search_box" placeholder="Search for what you like">

	<a href="isba2402_profile.php">
	<img src="<?php echo $corner_image ?>" style="width: 50px; height: 50px; object-fit: cover; float: right;">
	</a>

	<a href="isba2402_logout.php">
	<span style="font-size: 11px; float: right; margin: 10px; color: white;">Logout</span>
	</a>

	</div>
</div>	