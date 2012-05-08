<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once(APPPATH.'libraries/excel_reader2.php');

class ExcelReader extend Spreadsheet_Excel_Reader{
    /*
	* constructor
	*
	*/
	function ExcelReader(){
		$this->CI=& get_instance();
	}
	
	function readExcelFile($file,$type = null){
		$data = new Spreadsheet_Excel_Reader($file);
	    return $data;
	}
	 
}
?>