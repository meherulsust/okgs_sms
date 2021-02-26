<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     January 08, 2012
 */
 class Classtuitionfeetrailmodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'class_tuition_fee_trail';
    }
   public function get_columns()
   {
   	  return array('id','class_tuition_fee_id','ammount','created_at','created_by','updated_at','updated_by');
   }
   
  
   
 }

?>