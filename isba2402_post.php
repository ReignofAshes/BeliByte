
	<div id="post">
		<div>

			<?php

			//generic images for personal vs business profile type
				$image = "isba2402 placeholder images/personal logo.jpg";
				if($ROW_USER['account_type'] == "Business")
				{
					$image = "isba2402 placeholder images/business logo.jpg";
				}

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

			<br/><br/>
			

			<?php

				$likes = "";

				$likes = ($ROW['likes'] > 0) ? "(" .$ROW['likes']. ")" : ""; //if statement in one line

			?>
				<a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>">Like(s) <?php echo $likes ?></a> . <a href="">Comment</a> . <span style="color: #999"></span>

				<span style = "color: #999;">

					<?php echo htmlspecialchars($ROW['date']) // forces posts to be normal text and no code or special characters?> 
					
				</span>

				<span style = "color: #999; float: right;">

					<?php

						$post = new Post();

						//if you own the post or not -> if not hide the delete and edit button 
						if($post->i_own_post($ROW['postid'], $_SESSION['belibyte_userid'])){

							echo 
							"<a href='isba2402_edit.php?id=$ROW[postid]'>
							Edit
							</a> .

							<a href='isba2402_delete.php?id=$ROW[postid]'>
							Delete
							</a>";

						}
					?>
				
				</span>

				<?php

					$i_liked = false;

					if(isset($_SESSION['belibyte_userid'])){
					
						$DB = new Database();


						$sql = "select likes from likes where type = 'post' and contentid = '$ROW[postid]' LIMIT 1";
				        $result = $DB->read($sql);

					        if (is_array($result)) {
					           
					            $likes = json_decode($result[0]['likes'], true);
					            
					            // Check if the user has already liked the post
					            $user_ids = array_column($likes, "userid");

					            if (in_array($_SESSION['belibyte_userid'], $user_ids)) {
					            	$i_liked = true;

					            }
				           	}
						}

					if($ROW['likes'] > 0){

						echo "<br/>";
						echo "<a href='isba2402_likes.php?type=post&id=$ROW[postid]'>";

						if($ROW['likes'] == 1){

							if($i_liked){
								echo "<div style= 'text-align: left;'> You liked this post. </div>";
							}else{
								echo "<div style= 'text-align: left;'> 1 person liked this post. </div>";
							}
							

						}else{
							if($i_liked){

								$text = "others";
								if($ROW['likes'] - 1 == 1){
									$text = "other";
								}
								echo "<div style= 'text-align: left;'> You and " . ($ROW['likes'] - 1) . " $text liked this post. </div>";
							}else{
								echo "<div style= 'text-align: left;'>" . $ROW['likes'] . " people liked this post. </div>";
							}
		
						}
						
						echo "</a>";
					}

				?>
		</div>
	</div>