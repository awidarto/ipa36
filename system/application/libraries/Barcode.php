<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/barcode/BCGFontFile.php');
require_once(APPPATH.'libraries/barcode/BCGColor.php');
require_once(APPPATH.'libraries/barcode/BCGDrawing.php');
require_once(APPPATH.'libraries/barcode/BCGcode128.barcode.php');

class Barcode {

	private $CI;				// CodeIgniter instance

	function __construct()
	{
		$this->CI = &get_instance();
		log_message('debug', 'PHPlot Class Initialized');
	}

	function generateBarcode($filename,$udata){
		$font = new BCGFontFile(APPPATH.'libraries/barcode/font/Arial.ttf', 18);
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);
		 
		// Barcode Part
		$code = new BCGcode128();
		$code->setScale(2);
		$code->setThickness(30);
		$code->setForegroundColor($color_black);
		$code->setBackgroundColor($color_white);
		//$code->setFont($font);
		$code->setStart(NULL);
		$code->setTilde(true);
		$code->parse($udata);

		 //print $this->CI->config->item('qrcode_save_path').$filename;
		// Drawing Part
		$drawing = new BCGDrawing('', $color_white);
		$drawing->setFilename($this->CI->config->item('qrcode_save_path').$filename);
		$drawing->setBarcode($code);
		$drawing->draw();

		//header('Content-Type: image/png');
		 
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

        return $filename;
	}

}

?>