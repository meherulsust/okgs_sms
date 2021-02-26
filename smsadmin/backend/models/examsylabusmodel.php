<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 07, 2012
 * Model class for exam sylabus.
 */
class Examsylabusmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'exam_sylabus';
   }
  public function get_columns()
   {
   	  return array('id','exam_id','sylabus_exam_type_id','created_at','created_by');
   }
   

 } 
?>