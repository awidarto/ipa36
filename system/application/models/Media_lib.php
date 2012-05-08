<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media_lib {

	/*
	* constructor
	*
	*/
	function Media_lib(){

		$this->CI=& get_instance();
		
	}
	
	
	/**
	 * Dynamically outputs an image
	 *
	 * @access	public
	 * @param	resource
	 * @return	void
	 */
    function displayImageFile($file, $width = 400 )
    {
		$swidth = $file->image_width;
		$sheight = $file->image_height;
		
		if($sheight == 0){
			$twidth = $width;
			$theight = $height;
		}else if($width <= $swidth){
			$twidth = $width;
			$theight = ($sheight / $swidth) * $width;
		}else{
			$twidth = $swidth;
			$theight = $sheight;
		}
		
		
		
		
		switch ($file->image_type)
		{
			case 'gif' 		:	$src = imagecreatefromgif($file->full_path);
				break;
			case 'jpeg'		:	$src = imagecreatefromjpeg($file->full_path);
				break;
			case 'png'		:	$src = imagecreatefrompng($file->full_path);
				break;
			default		:	print 'Unable to display the image';
				break;		
		}
		
		$template = imagecreatetruecolor($twidth, $theight);
		imagecopyresampled($template, $src, 0, 0, 0, 0, $twidth, $theight, $swidth, $sheight);
	
		header("Content-Disposition: filename={$file->file_name};");
		header("Content-Type: {$file->file_type}");
		header('Content-Transfer-Encoding: binary');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');

		switch ($file->image_type)
		{
			case 'gif' 		:	imagegif($template);
				break;
			case 'jpeg'		:	imagejpeg($template, '', 100);
				break;
			case 'png'		:	imagepng($template);
				break;
			default		:	echo 'Unable to display the image';
				break;		
		}
		imagedestroy($template);
    }
    
    	/**
    	 * Generate from audio, 3gp files ( for mobile ) and mp3 ( for web )
    	 *
    	 * @access	public
    	 * @param	resource
    	 * @return	void
    	 */
        function createAudioThumbnail($file, $thumbfilename = NULL, $width = 75 )
        {
    		$file = (is_array($file))?$this->_createFileObject($file):$file;

    		$thumbfilename = ($thumbfilename == NULL)?$file->raw_name:$thumbfilename;

    		set_time_limit (0);
        	
            if( preg_match("/mp3/",$file->file_name) || $file->file_type == 'audio/mpeg' || $file->file_type == 'audio/x-mpeg'){
    		    $converted['mp3_file'] = $file->file_name;
            }else{
            	$in = $file->full_path;
            	$out = $file->file_path.$file->raw_name.".mp3";
        		system(escapeshellcmd($this->CI->config->item('ffmpeg_location')." -y -i ".$in." -f mp3 -acodec mp3 -ac 2 -ab 64k -ar 22050 ".$out),$retval);
        		$converted['mp3_file'] = $file->raw_name.".mp3";
            }

        	/*create and hint 3gp*/
        	$in = $file->full_path;
        	$out = $file->file_path.$file->raw_name.".3gp";
            system(escapeshellcmd($this->CI->config->item('ffmpeg_location')." -y -i ".$in." -f 3gp -vn -ac 1 -ab 12.2k -ar 8000 -acodec ".$this->CI->config->item('ffmpeg_amr_codec')." ".$out),$retval);
//            system(escapeshellcmd('sudo /bin/chmod 777 '.$out));
//            $retval = shell_exec(escapeshellcmd("sudo /usr/local/bin/MP4Box -hint ".$out));
            $converted['3gp_file'] = $file->raw_name.".3gp";
                
            return $converted;

    	}
    

	/**
	 * Generate image thumbnail from video, also create 3gp files ( for mobile ) and flv ( for web )
	 *
	 * @access	public
	 * @param	resource
	 * @return	void
	 */
    function createVideoThumbnail($file, $thumbfilename = NULL, $width = 75 )
    {
		$file = (is_array($file))?$this->_createFileObject($file):$file;
		
		$thumbfilename = ($thumbfilename == NULL)?$file->raw_name:$thumbfilename;
		
		set_time_limit (0);
		
		
        $thumbfile = $thumbfilename.".jpg";
        $seek = $this->CI->config->item('ffmpeg_thumbnail_seek');
        $cmd = $this->CI->config->item('ffmpeg_location')." -y -i ".$file->full_path." -an -y -f mjpeg -ss ".$seek." -vframes 1 ".$file->file_path.$thumbfile;
    	system(escapeshellcmd($cmd),$retval);
		
		$converted['thumbnail'] = $this->createImageThumbnailFromFile($file->file_path.$thumbfile, NULL, $width = 75 );
		
		
		if($file->file_type == 'video/x-flv'){
		    $converted['flv_file'] = $file->file_name;
        }else{
        	$in = $file->full_path;
        	$out = $file->file_path.$file->raw_name.".flv";
    		system(escapeshellcmd($this->CI->config->item('ffmpeg_location')." -y -i ".$in." -f flv -acodec mp3 -ac 2 -ab 64k -ar 22050 -b 500 -r 15 -s 352x288 -sameq ".$out),$retval);
    		$converted['flv_file'] = $file->raw_name.".flv";
        }

    	/*create and hint 3gp*/
        if($file->file_type == 'video/3gpp'){
            $converted['3gp_file'] = $file->file_name;
            //system(escapeshellcmd('sudo /bin/chmod 777 '.$out));
    		//$retval = shell_exec(escapeshellcmd("sudo /usr/local/bin/MP4Box -hint ".$out));
        }else{
        	$in = $file->full_path;
        	$out = $file->file_path.$file->raw_name.".3gp";
//        	if($node->media_upload_file->filemime == 'video/mp4'){
//        		$retval = shell_exec(escapeshellcmd("sudo /usr/local/bin/MP4Box -3gp -hint ".$in." -out ".$out));
//        		system(escapeshellcmd('sudo /bin/chmod 777 '.$out));
//        	}else{
// this one specifics for server
//        		system(escapeshellcmd("/usr/local/bin/ffmpeg -y -i ".$in." -f 3gp -vcodec h263 -ac 1 -ab 12.2k -ar 8000 -s 352x288 -acodec libamr_nb ".$out),$retval);
        		system(escapeshellcmd($this->CI->config->item('ffmpeg_location')." -y -i ".$in." -f 3gp -vcodec h263 -ac 1 -ab 12.2k -ar 8000 -s 352x288 -acodec ".$this->CI->config->item('ffmpeg_amr_codec')." ".$out),$retval);
//                	system(escapeshellcmd('sudo /bin/chmod 777 '.$out));
//        		$retval = shell_exec(escapeshellcmd("sudo /usr/local/bin/MP4Box -hint ".$out));
//        	}
            $converted['3gp_file'] = $file->raw_name.".3gp";
        }
        return $converted;
		
	}




	/**
	 * Dynamically outputs an image
	 *
	 * @access	public
	 * @param	resource
	 * @return	void
	 */
    function createImageThumbnail($file, $thumbfilename = NULL, $width = 75 )
    {
		$file = (is_array($file))?$this->_createFileObject($file):$file;
		
		
		$swidth = $file->image_width;
		$sheight = $file->image_height;
		$thumbfilename = ($thumbfilename == NULL)?'th_'.$file->raw_name:$thumbfilename;		
		
		if($swidth <= $sheight){
    		$twidth = $width;
    		$theight = ($sheight / $swidth) * $width;
		}else{
    		$theight = $width;
    		$twidth = ( $swidth / $sheight) * $width;
		}
		
				
		switch ($file->image_type)
		{
			case 'gif' 		:	$src = imagecreatefromgif($file->full_path);
				break;
			case 'jpeg'		:	$src = imagecreatefromjpeg($file->full_path);
				break;
			case 'png'		:	$src = imagecreatefrompng($file->full_path);
				break;
			default		:	print 'Unable to display the image';
				break;		
		}
		
		$template = imagecreatetruecolor($twidth, $theight);
		imagecopyresampled($template, $src, 0, 0, 0, 0, $twidth, $theight, $swidth, $sheight);
		
		$thumbtemplate = imagecreatetruecolor($width, $width);
		imagecopyresampled($thumbtemplate, $template, 0, 0, 0, 0, $twidth, $theight, $twidth, $theight);		
		
		$filethumbfullpath = $file->file_path.$thumbfilename.$file->file_ext;
		
		switch ($file->image_type)
		{
			case 'gif' 		:	imagegif($thumbtemplate,$filethumbfullpath);
				break;
			case 'jpeg'		:	imagejpeg($thumbtemplate, $filethumbfullpath, 100);
				break;
			case 'png'		:	imagepng($thumbtemplate,$filethumbfullpath);
				break;
			default		:	echo 'Unable to display the image';
				break;		
		}
		
		imagedestroy($template);
		imagedestroy($thumbtemplate);
		
		return $thumbfilename.$file->file_ext;
		
    }


	/**
	 * Dynamically outputs an image
	 *
	 * @access	public
	 * @param	resource
	 * @return	void
	 */
    function createImageThumbnailFromFile($filename, $thumbfilename = NULL, $width = 75 )
    {
		
		$file = getimagesize($filename);
		
		$path_parts = pathinfo($filename);
		$file_path = $path_parts['dirname'].'/';
		$extension = '.'.$path_parts['extension'];
		$basename = trim(str_replace($extension,'',$path_parts['basename']));
		
		$swidth = $file[0];
		$sheight = $file[1];
		$thumbfilename = ($thumbfilename == NULL)?'th_'.$basename:$thumbfilename;
		
		if(preg_match("/jpeg/",$file['mime'])) $image_type = 'jpeg';
		if(preg_match("/gif/",$file['mime'])) $image_type = 'gif';
		if(preg_match("/png/",$file['mime'])) $image_type = 'png';			

		if($swidth <= $sheight){
    		$twidth = $width;
    		$theight = ($sheight / $swidth) * $width;
		}else{
    		$theight = $width;
    		$twidth = ( $swidth / $sheight) * $width;
		}
		
		
		switch ($image_type)
		{
			case 'gif' 		:	$src = imagecreatefromgif($filename);
				break;
			case 'jpeg'		:	$src = imagecreatefromjpeg($filename);
				break;
			case 'png'		:	$src = imagecreatefrompng($filename);
				break;
			default		:	print 'Unable to display the image';
				break;		
		}

		$template = imagecreatetruecolor($twidth, $theight);
		imagecopyresampled($template, $src, 0, 0, 0, 0, $twidth, $theight, $swidth, $sheight);

		$thumbtemplate = imagecreatetruecolor($width, $width);
		imagecopyresampled($thumbtemplate, $template, 0, 0, 0, 0, $twidth, $theight, $twidth, $theight);	

		$filethumbfullpath = $file_path.$thumbfilename.$extension;

		switch ($image_type)
		{
			case 'gif' 		:	imagegif($thumbtemplate,$filethumbfullpath);
				break;
			case 'jpeg'		:	imagejpeg($thumbtemplate, $filethumbfullpath, 100);
				break;
			case 'png'		:	imagepng($thumbtemplate,$filethumbfullpath);
				break;
			default		:	echo 'Unable to display the image';
				break;		
		}

		imagedestroy($template);
		imagedestroy($thumbtemplate);

		return $thumbfilename.$extension;

    }


	function _createFileObject($filedataarray){
		$file = new stdClass();
		foreach($filedataarray as $key => $val){
			$file->$key = $val;
		}
		return $file;
	}


}

?>