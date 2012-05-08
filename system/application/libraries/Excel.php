<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Excel  
    {
        public $workbook;
        
        function __construct()
        {
            // PHPExcel libraries have to be in your include path !
            require_once(APPPATH.'libraries/PHPExcel.php');
            require_once(APPPATH.'libraries/PHPExcel/IOFactory.php');
            //require_once('PHPExcel.php');
            //require_once('PHPExcel/IOFactory.php');
        }
        
        public function load($filename){
            $objReader = new PHPExcel_Reader_Excel5();
            //$objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($filename);

            $xls_array = array();
            $cell_array = array();

            $numrows = 0;
            $numcols = 0;

            $last_col = '';
            $last_row = '';


            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                //echo '- ' . $worksheet->getTitle() . "\r\n";

                if(preg_match('/Template/', $worksheet->getTitle()) OR preg_match('/Data/', $worksheet->getTitle())){

                    foreach ($worksheet->getRowIterator() as $row) {
                        //echo '    - Row number: ' . $row->getRowIndex() . "\r\n";

                        $last_row = $row->getRowIndex();


                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                        $numcols = 0;
                        foreach ($cellIterator as $cell) {
                            $cell_array[$numrows][$numcols] = $cell->getCalculatedValue() ;
                            $numcols++;
                            $last_col = $cell->getCoordinate();
                        }

                        $numrows++;
                    }

                }

            }

            $xls_array['numRows'] = $numrows - 1;
            $xls_array['numCols'] = $numcols - 1;

            $xls_array['lastRow'] = $last_row;
            $xls_array['lastCol'] = $last_col;


            $xls_array['cells'] = $cell_array;

            return $xls_array;
        }

        public function _load($filename){
            $objPHPExcel = PHPExcel_IOFactory::load($filename);

            return $objPHPExcel;
        }

        function __load()
        {
            // Path to the template file
            $template_location = 'resources/template.xls';
        
            $xls_reader = PHPExcel_IOFactory::createReader('Excel5');
            $this->workbook = $xls_reader->load($template_location);
            
            var_dump($this->workbook); // Yea, successfully load the data
        }


    }
?>