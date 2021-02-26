<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 03, 2012
 * Model class for Photo.
 */
class Photomodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function save($values)
   {
 	  $photo_id = parent::save($values);
 	  return $photo_id;
   }
   public function get_student_photo($std_id)
   {
   	   $query = $this->db->select('id,file_name,student_id,date_format(created_at,"%D %b,%Y") create_date,
   	   			date_format(updated_at,"%D %b,%Y") update_date',false)
   	   			->from($this->get_table_name())
   	  		    ->where('student_id',$std_id)->order_by('id asc')
   	  		    ->get();
   	   return $query->result_array();		    	
   }
   public function get_table_name()
   {
   	  return 'student_photo';
   }
   public function get_columns()
   {
   	  return array('id','student_id','file_name','image_size','image_type','created_at','created_by','updated_by');
   }
    

 } 
?>
