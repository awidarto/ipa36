<?php

require_once(APPPATH.'libraries/PHPExcel.php');
require_once(APPPATH.'libraries/PHPExcel/IOFactory.php');

class Excel extends PHPExcel {
    /*
	* constructor
	*
	*/
	function Excel(){
		$this->CI=& get_instance();
	}
	
	function readExcelFile($file,$type = null){
	    //$objReader = PHPExcel_IOFactory::createReader();
	    $objReader = new PHPExcel_Reader_Excel5();
        $objReader->setReadDataOnly(true);
        $objReader->setReadFilter( $this->readFirstRow() );
        $objPHPExcel = $objReader->load($file);
        //$objPHPExcel = PHPExcel_IOFactory::load($file);
        return $objPHPExcel;
	}
	
    function readFirstRow($column, $row, $worksheetName = '') {
		// Read title row and rows 20 - 30
		if ($row == 1 && ($col != '')) {
			return true;
		}
		return false;
	}    
}
?>