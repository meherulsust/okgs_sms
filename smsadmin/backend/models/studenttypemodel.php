<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 10, 2012
 * Model class for School class.
 */
class Studenttypemodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function get_table_name()
   {
   	  return 'student_type';
   }
   public function get_columns()
   {
   	  return array('id','title','status');
   }
    

 } 
?>
