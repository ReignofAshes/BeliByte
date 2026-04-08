<?php

class Post
{
	private $error = "";

	public function create_post($userid, $data, $files)
	{

		//creating post and postid
		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image']))
		{
			$myimage = "";
			$has_image = 0;
			$is_cover_image = 0;
			$is_profile_image = 0;

			if(isset($data['is_profile_image']) || isset($data['is_cover_image']))
			{

			    $myimage = $files;
			    $has_image = 1;

				if(isset($data['is_cover_image']))
				{
					$is_cover_image = 1;
				}
				
				if(isset($data['is_profile_image']))
				{
					$is_profile_image = 1;
				}
				
			}else
			{
				if(!empty($files['file']['name']))
				{
					//create folder (taken from change_prof_image)
					$folder = "uploads/" . $userid . "/"; //match a created folder to each user when they upload a photo

						//create the folder
						if(!file_exists($folder))
						{
							mkdir($folder, 0777, true); //remember to give file permissions
							file_put_contents($folder . "index.php", ""); //automatically put an empty .php file in each folder for security
						}

						$image_class = new Image();

						$myimage = $folder . $image_class->generate_filename(15) . ".jpg";
						move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

						$image_class->resize_image($myimage, $myimage, 1500, 1500);

					$has_image = 1;				
				}

			}

			//making a post when profile pic is updated

			$post = "";
			if(isset($data['post'])) {

				$post = addslashes($data['post']);				
			}

			$postid = $this->create_postid();

			$query = "insert into posts (userid, postid, post, image, has_image, is_profile_image, is_cover_image) values ('$userid', '$postid', '$post', '$myimage', '$has_image', '$is_profile_image', '$is_cover_image')"; //insert into [table] values (variables) check db

			$DB = new Database();
			$DB->save($query);

		}else
		{
			$this->error .= "Please type something or upload media  to post.<br>";
		}
		
		return $this->error;
	}	


	public function edit_post($data, $files)
	{

		//creating post and postid
		if(!empty($data['post']) || !empty($files['file']['name']))
		{
			$myimage = "";
			$has_image = 0;

				if(!empty($files['file']['name']))
				{
					$folder = "uploads/" . $userid . "/"; //match a created folder to each user when they upload a photo

						//create the folder
						if(!file_exists($folder))
						{
							mkdir($folder, 0777, true); //remember to give file permissions
							file_put_contents($folder . "index.php", ""); //automatically put an empty .php file in each folder for security
						}

						$image_class = new Image();

						$myimage = $folder . $image_class->generate_filename(15) . ".jpg";
						move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

						$image_class->resize_image($myimage, $myimage, 1500, 1500);

					$has_image = 1;				
				}

			$post = "";
			if(isset($data['post'])) {

				$post = addslashes($data['post']);				
			}

			$postid = addslashes($data['postid']);

			if($has_image){
				$query = "update posts set post = '$post', image = '$myimage' where postid = '$postid' limit 1";
			}else{
				$query = "update posts set post = '$post' where postid = '$postid' limit 1";
			}

			$DB = new Database();
			$DB->save($query);

		}else
		{
			$this->error .= "Please type something or upload media  to post.<br>";
		}
		
		return $this->error;
	}


	public function get_posts($id)
	{
		$query = "select * from posts where userid = '$id' order by id desc limit 10"; //get the 10 most recent posts based on id

		$DB = new Database();
		$result = $DB->read($query); //remember to change save to read for get function

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}

	}

	public function get_one_post($postid)
	{
		if(!is_numeric($postid)){ //safeguards against malicious attack
			return false;
		}

		$query = "select * from posts where postid = '$postid' limit 1"; 
		
		$DB = new Database();
		$result = $DB->read($query); 

		if($result){

			return $result[0]; //need to bypass array 0 that sets automatically

		}else{

			return false;
		}

	}


	public function delete_post($postid)
	{

		if(!is_numeric($postid)){
			return false;
		}

		$query = "delete from posts where postid = '$postid' limit 1";

		$DB = new Database();
		$DB->save($query);

	}

	public function i_own_post($postid, $belibyte_userid)
	{
		if(!is_numeric($postid)){
			return false;
		}

		$query = "select * from posts where postid = '$postid' limit 1"; 

		$DB = new Database();
		$result = $DB->read($query); 

		if(is_array($result)){

			if($result[0]['userid'] == $belibyte_userid){ //array 0 is your id
				return true;
			}
		}

		return false;

	}			

	public function get_likes($id, $type){
		$DB = new Database();
		$type = addslashes($type);

		if(is_numeric($id)){

			//get like details
			$sql = "select likes from likes where type = '$type' && contentid = '$id' LIMIT 1";
			$result = $DB->read($sql);

			if(is_array($result)){

				$likes = json_decode($result[0]['likes'], true); 
				return $likes;

			}
		}

		return false;
	}	


	public function follow_user($id, $type, $belibyte_userid) {
	  
	    	$DB = new Database();

			//save following details
			$sql = "select following from likes where type = '$type' && contentid = '$id' LIMIT 1";
			$result = $DB->read($sql);

			if(is_array($result)){

				$likes = json_decode($result[0]['likes'], true); //to array; need "true" or it wont turn into an array

				$user_ids = array_column($likes, "userid");

				if(!in_array($belibyte_userid, $user_ids)){ //check if you already liked

					$arr["userid"] = $belibyte_userid;
					$arr["date"] = date("Y-m-d H:i:s");

					$likes[] = $arr;

					$likes_string = json_encode($likes); //to string
			    	$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' LIMIT 1";
					$DB->save($sql);	

					//increment the right table
			    	$sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' LIMIT 1";
					$DB->save($sql);

				}else{

					//removing your like
					$key = array_search($belibyte_userid, $user_ids);
					unset($likes[$key]); //can also be set to NULL instead

					$likes_string = json_encode($likes); 
			    	$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' LIMIT 1";
					$DB->save($sql);

					//decrease the posts table
			    	$sql = "update {$type}s set likes = likes - 1 where {$type}id = '$id' LIMIT 1";
					$DB->save($sql);
				}
				
			}else{
				$arr["userid"] = $belibyte_userid;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				$likes = json_encode($arr2);
		    	$sql = "insert into likes (type, contentid, likes) values ('$type', '$belibyte_userid', '$following')";
				$DB->save($sql);	

				//increment the right table
		    	$sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' LIMIT 1";
				$DB->save($sql);			
			}
	    
	}

	public function like_post($id, $type, $belibyte_userid){

		// if($type == "post"){
			$DB = new Database();

			//save likes details
			$sql = "select likes from likes where type = '$type' && contentid = '$id' limit 1";
			$result = $DB->read($sql);

			if(is_array($result) &&!empty($result[0]['likes'])){

				$likes = json_decode($result[0]['likes'], true);


				$user_ids = array_column($likes, "userid");

				if(!in_array($belibyte_userid, $user_ids)){

					$arr["userid"] = $belibyte_userid;
					$arr["date"] = date("Y-m-d H:i:s");

					$likes[] = $arr;

					$likes_string = json_encode($likes);
					$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' limit 1";
					$DB->save($sql);

					//increment the posts table
					$sql = "update {$type}s set likes = likes - 1 where {$type}id = $id' limit 1";
					$DB->save($sql);

				}else{
					//removing your like
					$key = array_search($belibyte_userid, $user_ids);
					unset($likes[$key]); //can also be set to NULL instead

					$likes_string = json_encode($likes); 
			    	$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' LIMIT 1";
					$DB->save($sql);

					//increment the right table
			    	$sql = "update {$type}s set likes = likes - 1 where {$type}id = '$id' LIMIT 1";
					$DB->save($sql);
				}

			}else{

				$arr["userid"] = $belibyte_userid;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				$likes = json_encode($arr);
				$sql = "insert into likes (type, contentid, likes) values ('$type', '$id', '$likes')";
				$DB->save($sql);

			}

		// }	
	}


	private function create_postid()
	{

		$length = rand(4, 19); #length of the user id random from 4 to 19 digits
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			
			$new_rand = rand(0, 9);

			$number = $number . $new_rand;
		}
		return $number; //return the generated ID into the db

	}

}
