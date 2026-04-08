<?php
//go into xampp > php and remove the ;extension=gd in php.ini if Fatal error: Uncaught Error: 

class Image
{

	public function generate_filename($length) //gives a file name the length of whatever you want in $length
	{
		
		$array = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		$text = "";

		for($x = 0; $x < $length; $x++)
		{

			$random = rand(0, 61);
			$text .= $array[$random];
		}

		return $text;
	}

    public function crop_image($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if (!file_exists($original_file_name)) {
            return false; // File does not exist
        }

        // Get image type (jpg or png)
        $image_info = getimagesize($original_file_name);
        $mime = $image_info['mime'];

        // Load image based on type
        if ($mime == "image/jpeg") {
            $original_image = imagecreatefromjpeg($original_file_name);
        } elseif ($mime == "image/png") {
            $original_image = imagecreatefrompng($original_file_name);
        } else {
            return false; // Unsupported file type
        }

        $original_width = imagesx($original_image);
        $original_height = imagesy($original_image);

        // Resize the image while keeping aspect ratio
        if ($original_height > $original_width) {
            $ratio = $max_width / $original_width;
            $new_width = $max_width;
            $new_height = $original_height * $ratio;

        } else {
            $ratio = $max_height / $original_height;
            $new_height = $max_height;
            $new_width = $original_width * $ratio;
        }

        // Create a new blank image with the correct size

        //adjust incase max width and height are different after calculation (for cover photo)
        if($max_width != $max_height)
        {

        	if ($max_height > $max_width)
        	{
        		if($max_height > $new_height)
        		{
        			$adjustment = ($max_height / $new_height);
        		}else
        		{
        			$adjustment = ($new_height / $max_height);        			
        		}

        		$new_width = $new_width * $adjustment;
        		$new_height = $new_height * $adjustment;
        	}else
        	{
        		if($max_width > $new_width)
        		{
        			$adjustment = ($max_width / $new_width);
        		}else
        		{
        			$adjustment = ($new_width / $max_width);        			
        		}

        		$new_width = $new_width * $adjustment;
        		$new_height = $new_height * $adjustment;
        	}
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

        // Free memory
        imagedestroy($original_image);  

        if($max_width != $max_height)
        {
	        if($max_width > $max_height)
	        {
	        	$diff = ($new_height - $max_height);
	        	if($diff < 0)
	        	{
	        		$diff = $diff * -1;	        		
	        	}

	        	$y = round($diff / 2);
	        	$x = 0;
	        }else
	        {
	        	$diff = ($new_width - $max_height);
	        	if($diff < 0)
	        	{
	        		$diff = $diff * -1;	        		
	        	}	        	
	        	$x = round($diff / 2);
	        	$y = 0;
	        }
        }else
        {
	        if($new_height > $new_width)
	        {
	        	$diff = ($new_height - $new_width);
	        	$y = round($diff / 2);
	        	$x = 0;
	        }else
	        {
	        	$diff = ($new_width - $new_height);
	        	$x = round($diff / 2);
	        	$y = 0;
	        }
	    }

        $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
        imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
        imagedestroy($new_image);


        // Save image in the correct format
        if ($mime == "image/jpeg") {
            imagejpeg($new_cropped_image, $cropped_file_name, 90);
        } elseif ($mime == "image/png") {
            imagepng($new_cropped_image, $cropped_file_name, 9);
        }

        imagedestroy($new_cropped_image);

        return true;

    } 

    //resize the image
	public function resize_image($original_file_name, $resized_file_name, $max_width, $max_height)
		{
		    if (!file_exists($original_file_name)) {
		        return false; // File does not exist
		    }

		    // Get image type (jpg or png)
		    $image_info = getimagesize($original_file_name);
		    $mime = $image_info['mime'];

		    // Load image based on type
		    if ($mime == "image/jpeg") {
		        $original_image = imagecreatefromjpeg($original_file_name);
		    } elseif ($mime == "image/png") {
		        $original_image = imagecreatefrompng($original_file_name);
		    } else {
		        return false; // Unsupported file type
		    }

		    $original_width = imagesx($original_image);
		    $original_height = imagesy($original_image);

		    // Resize the image while keeping aspect ratio
		    if ($original_height > $original_width) {
		        $ratio = $max_width / $original_width;
		        $new_width = $max_width;
		        $new_height = $original_height * $ratio;
		    } else {
		        $ratio = $max_height / $original_height;
		        $new_height = $max_height;
		        $new_width = $original_width * $ratio;
		    }

	        if($max_width != $max_height)
	        {

	        	if ($max_height > $max_width)
	        	{
	        		if($max_height > $new_height)
	        		{
	        			$adjustment = ($max_height / $new_height);
	        		}else
	        		{
	        			$adjustment = ($new_height / $max_height);        			
	        		}

	        		$new_width = $new_width * $adjustment;
	        		$new_height = $new_height * $adjustment;
	        	}else
	        	{
	        		if($max_width > $new_width)
	        		{
	        			$adjustment = ($max_width / $new_width);
	        		}else
	        		{
	        			$adjustment = ($new_width / $max_width);        			
	        		}

	        		$new_width = $new_width * $adjustment;
	        		$new_height = $new_height * $adjustment;
	        	}
	        }

		    // Create a new blank image with the correct size
		    $new_image = imagecreatetruecolor($new_width, $new_height);
		    imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

		    imagedestroy($original_image);

		    // Save image in the correct format
		    if ($mime == "image/jpeg") {
		        imagejpeg($new_image, $resized_file_name, 90);
		    } elseif ($mime == "image/png") {
		        imagepng($new_image, $resized_file_name, 9);
		    }

		    imagedestroy($new_image);

		    return true;
		}

	//create thumbnail for cover image
	public function get_thumb_cover($filename)		
	{

		$thumbmail = $filename . "_cover_thumb.jpg";

		if(file_exists($thumbmail))
			{
				return $thumbmail;
			}

		$this->crop_image($filename, $thumbmail, 1366, 488);

		if(file_exists($thumbmail))
		{
			return $thumbmail;

		}else
		{
			return $filename;
		}
	}

	//create thumbnail for profile image
		public function get_thumb_profile($filename)		
		{

			$thumbmail = $filename . "_profile_thumb.jpg";

			if(file_exists($thumbmail))
				{
					return $thumbmail;
				}

			$this->crop_image($filename, $thumbmail, 600, 600);

			if(file_exists($thumbmail))
			{
				return $thumbmail;

			}else
			{
				return $filename;
			}
		}

		//create thumbnail for post image
		public function get_thumb_post($filename)		
		{

			$thumbmail = $filename . "_post_thumb.jpg";

			if(file_exists($thumbmail))
				{
					return $thumbmail;
				}

			$this->crop_image($filename, $thumbmail, 600, 600);

			if(file_exists($thumbmail))
			{
				return $thumbmail;

			}else
			{
				return $filename;
			}
		}

}		

