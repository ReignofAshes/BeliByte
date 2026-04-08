<?php

class User
{

	public function get_data($id)
	{

		$query = "select * from users where userid = '$id' limit 1";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{

			return $result[0]; //want only the first row of results

		}else
		{
			return false;
		}

	}

	public function get_user($id)
	{

		$query = "select * from users where userid = '$id' limit 1";
		$DB = New Database();
		$result = $DB->read($query);


		if($result)
		{
			return $result[0];
		}else
		{
			return false;
		}
	}

	public function get_friends($id){

		$query = "select * from users where userid != '$id' "; //everyone who is not myself ($id)
		$DB = New Database();
		$result = $DB->read($query);


		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}

	public function get_following($id, $type){

			$DB = new Database();
			$type = addslashes($type);

			if(is_numeric($id)){

				//get following details
				$sql = "select following from likes where type = '$type' && contentid = '$id' LIMIT 1";
				$result = $DB->read($sql);

				if(is_array($result)){

					$following = json_decode($result[0]['following'], true); 
					return $following;

				}
			}

			return false;
		}	


	public function follow_user($id, $type, $belibyte_userid){
	  
	    	$DB = new Database();

			//save likes details
			$sql = "select following from likes where type = '$type' && contentid = '$$belibyte_userid' LIMIT 1";
			$result = $DB->read($sql);

			if(is_array($result)){

				$likes = json_decode($result[0]['following'], true); //to array; need "true" or it wont turn into an array

				$user_ids = array_column($likes, "userid");

				if(!in_array($belibyte_userid, $user_ids)){ //check if you already liked

					$arr["userid"] = $id;
					$arr["date"] = date("Y-m-d H:i:s");

					$likes[] = $arr;

					$likes_string = json_encode($likes); //to string
			    	$sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$belibyte_userid' LIMIT 1";
					$DB->save($sql);	

				}else{

					//removing your like
					$key = array_search($id, $user_ids);
					unset($likes[$key]); //can also be set to NULL instead

					$likes_string = json_encode($likes); 
			    	$sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$belibyte_userid' LIMIT 1";
					$DB->save($sql);

				}
				
			}else{
				$arr["userid"] = $id;
				$arr["date"] = date("Y-m-d H:i:s");

				$arr2[] = $arr;

				$following = json_encode($arr2);
		    	$sql = "insert into likes (type, contentid, following) values ('$type', '$belibyte_userid', '$following')";
				$DB->save($sql);	
	
			}
	    
		}
}