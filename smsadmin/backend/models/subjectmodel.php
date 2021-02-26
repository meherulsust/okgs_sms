<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */
class Subjectmodel extends BACKEND_Model
 {
	public function __construct()
	{
		parent::__construct();
	}
  	
	public function get_table_name()
	{
		return 'subject';
	}
    
	public function get_columns()
	{
   	  return array('id','title','status');
	}

 } 
?>
