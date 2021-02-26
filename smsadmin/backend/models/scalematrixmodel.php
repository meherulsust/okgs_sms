<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 19, 2012
 */
 class Scalematrixmodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'scale_matrix';
    }	
   public function get_columns()
   {
   	  return array('id','result_scale_id','min_range','weight','grade_title','created_at','max_range','title','created_by');
   }   
 }

?>