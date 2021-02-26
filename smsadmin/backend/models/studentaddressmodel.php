<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 11, 2012
 * Model class for studentguardian.
 */
class Studentaddressmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
   	
   public function get_table_name()
   {
   	  return 'student_address';
   }
   
   public function get_columns()
   {
   	  return array('id','student_id','address_id','address_type','created_at');
   }
    

 } 
?>
