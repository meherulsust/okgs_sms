<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 16, 2012
 */
 class Sectiontuitionfeetrailmodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'section_tuition_fee_trail';
    }
   public function get_columns()
   {
   	  return array('id','section_tuition_fee_id','ammount','created_at','created_by','updated_at','updated_by');
   }
  
   
 }

?>