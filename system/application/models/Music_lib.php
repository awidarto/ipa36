<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('getid3/getid3/getid3.php');

class Music_lib {
	
	function Music_lib(){

		$this->getID3 = new getID3;
		$this->getID3->option_md5_data        = true;
		$this->getID3->option_md5_data_source = true;
		$this->getID3->encoding               = 'UTF-8';		
	}
	
    function getID3tag($filename)
    {
/*		if($fileinfo = $this->getID3->analyze($filename)){
			getid3_lib::CopyTagsToComments($fileinfo);
			return $fileinfo;
		}else{
			return FALSE;
		}
*/		
		$this->info = $this->getID3->analyze($filename);

		// Exit here on error
		if (isset($this->info['error'])) {
		    return FALSE;
		}else{
		    getid3_lib::CopyTagsToComments($this->info);
		    return $this->info;
		}
/*
		// Post getID3() data handling based on file format
		$method = @$this->info['fileformat'].'Info';
		if (@$this->info['fileformat'] && method_exists($this, $method)) {
			$this->$method();
		}

		return $this->result;
*/

    }
    

	/**
	* post-getID3() data handling for AAC files.
	*
	* @access   private
	*/

	function aacInfo() {
		$this->result['format_name']     = 'AAC';
	}




	/**
	* post-getID3() data handling for Wave files.
	*
	* @access   private
	*/

	function riffInfo() {
		if ($this->info['audio']['dataformat'] == 'wav') {

			$this->result['format_name'] = 'Wave';

		} else if (ereg('^mp[1-3]$', $this->info['audio']['dataformat'])) {

			$this->result['format_name'] = strtoupper($this->info['audio']['dataformat']);

		} else {

			$this->result['format_name'] = 'riff/'.$this->info['audio']['dataformat'];

		}
	}




	/**
	* * post-getID3() data handling for FLAC files.
	*
	* @access   private
	*/

	function flacInfo() {
		$this->result['format_name']     = 'FLAC';
	}





	/**
	* post-getID3() data handling for Monkey's Audio files.
	*
	* @access   private
	*/

	function macInfo() {
		$this->result['format_name']     = 'Monkey\'s Audio';
	}





	/**
	* post-getID3() data handling for Lossless Audio files.
	*
	* @access   private
	*/

	function laInfo() {
		$this->result['format_name']     = 'La';
	}





	/**
	* post-getID3() data handling for Ogg Vorbis files.
	*
	* @access   private
	*/

	function oggInfo() {
		if ($this->info['audio']['dataformat'] == 'vorbis') {

			$this->result['format_name']     = 'Ogg Vorbis';

		} else if ($this->info['audio']['dataformat'] == 'flac') {

			$this->result['format_name'] = 'Ogg FLAC';

		} else if ($this->info['audio']['dataformat'] == 'speex') {

			$this->result['format_name'] = 'Ogg Speex';

		} else {

			$this->result['format_name'] = 'Ogg '.$this->info['audio']['dataformat'];

		}
	}




	/**
	* post-getID3() data handling for Musepack files.
	*
	* @access   private
	*/

	function mpcInfo() {
		$this->result['format_name']     = 'Musepack';
	}




	/**
	* post-getID3() data handling for MPEG files.
	*
	* @access   private
	*/

	function mp3Info() {
		$this->result['format_name']     = 'MP3';
	}




	/**
	* post-getID3() data handling for MPEG files.
	*
	* @access   private
	*/

	function mp2Info() {
		$this->result['format_name']     = 'MP2';
	}





	/**
	* post-getID3() data handling for MPEG files.
	*
	* @access   private
	*/

	function mp1Info() {
		$this->result['format_name']     = 'MP1';
	}




	/**
	* post-getID3() data handling for WMA files.
	*
	* @access   private
	*/

	function asfInfo() {
		$this->result['format_name']     = strtoupper($this->info['audio']['dataformat']);
	}



	/**
	* post-getID3() data handling for Real files.
	*
	* @access   private
	*/

	function realInfo() {
		$this->result['format_name']     = 'Real';
	}





	/**
	* post-getID3() data handling for VQF files.
	*
	* @access   private
	*/

	function vqfInfo() {
		$this->result['format_name']     = 'VQF';
	}
    
    
    
}

?>