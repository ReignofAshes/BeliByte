
	<div id="post">
		<div>

			<?php

			//generic images for personal vs business profile type
				$image = "isba2402 placeholder images/personal logo.jpg";
				if($ROW_USER['account_type'] == "Business")
				{
					$image = "isba2402 placeholder images/business logo.jpg";
				}

				$image_class = new Image(); //remember to instantiate your Classes if possible
				if(file_exists($ROW_USER['profile_image'])) //match the users profile picture to their profile post pics
				{

					$image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
				}


			?>

			<img src="<?php echo $image ?>" style="width: 75px; margin-right: 4px; border-radius: 50%;">

		</div>


		<div style="width: 100%;">
			<div style="font-weight: bold; color: #405d9b; width: 100%;">
				<?php 

					echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name']; 

					if($ROW['is_profile_image'])
					{

					$pronoun = "their";
						// if($ROW_USER['gender'] == "Female") //only if gender settings instead of business/personal account
						// {
						// 	$pronoun = "her"
						// }

						if($ROW_USER['account_type'] == "Personal") 
							{
							$pronoun = "their";
							}

							echo "<span style='font-weight: normal; color: #aaa'> updated $pronoun profile picture.</span>";	

					}

					if($ROW['is_cover_image'])
					{

					$pronoun = "their";
						// if($ROW_USER['gender'] == "Female") //only if gender settings instead of business/personal account
						// {
						// 	$pronoun = "her"
						// }

						if($ROW_USER['account_type'] == "Personal") 
							{
							$pronoun = "their";
							}

							echo "<span style='font-weight: normal; color: #aaa'> updated $pronoun cover image.</span>";	
					}

				?>

			</div>

			<?php echo $ROW['post'] ?> 

			<br><br>

			<?php 
				
				if(file_exists($ROW['image']))
				{
				    $post_image = $image_class->get_thumb_post($ROW['image']);
				    echo "<img src = '$post_image' style='max-width: 40%; height: auto; border-radius: 8px;' />";
				}
				
			?> 

		</div>
	</div>