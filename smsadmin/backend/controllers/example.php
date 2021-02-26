<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Example extends BACKEND_Controller {
  function __construct()
  {
  	parent::__construct();
  }
  
  function create()
  {
  	 	$this->load->form('guardianform','gform');
  	 	if($this->gform->validate())
  	 	{
  	 		$this->gform->save();
  	 		exit();
  	 	}
  	 	
						   	   
  }
  function personal()
  {
  	$this->load->form('personaldetailsform','piform');
  	if($this->piform->validate())
  	{
  		echo $this->piform->save();
  		
  	}
  	
  }
  
  function jvalid()
  {
  	$this->load->form('personaldetailsform','piform');	    
  	$this->tpl->set_js(array('jquery.validate'));
  }
  
  function excel(){
  $bulk_data_path = $this->config->item('upload_dir').'bulk_data'.DIRECTORY_SEPARATOR;
 $this->load->library('excel');
 require_once 'PHPExcel/IOFactory.php';
 $inputFileName = $bulk_data_path.'student list.xlsx';
 $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
 $objReader = PHPExcel_IOFactory::createReader($inputFileType);
 $objReader->setReadDataOnly(true);
 $objPHPExcel = $objReader->load($inputFileName);
 //echo $sheetCount = $objPHPExcel->getSheetCount();
 $sheetNames = $objPHPExcel->getSheetNames();
 echo "<pre>";
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
print_r($sheetData);
 $this->tpl->set_view(false);
  }
}