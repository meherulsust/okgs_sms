<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 11, 2012
 * Model section model class.
 */
class Sectionmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
     
   public function get_table_name()
   {
   	  return 'section';
   }
   public function get_columns()
   {
   	  return array('id','description','version_id','class_id','status','room_number','title','created_at','created_by');
   }
   
  

 } 
?>
