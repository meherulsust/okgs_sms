<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Excel
{
    function __construct()
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).'/phpoffice/excel');
        
    }
    
    public function get_array($inputFileName){
        $data = array();
        if($inputFileName){
            require_once 'PHPExcel/IOFactory.php';
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            //echo $sheetCount = $objPHPExcel->getSheetCount();
            $loadedSheetNames = $objPHPExcel->getSheetNames();
            foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                	$objPHPExcel->setActiveSheetIndexByName($loadedSheetName);
                        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                        $data[$loadedSheetName] = $sheetData;
            }
            
            return $data;
        }
    }
    
}

?>
