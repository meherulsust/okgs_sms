<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 23, 2012
 */
 class Coursetypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'course_type';
    }	
   public function get_columns()
   {
   	  return array('id','title','created_at','description','status');
   }   
 }

?>