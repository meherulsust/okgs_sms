<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 17, 2012
 * 
 * model class for course course attribute
 */
 class Coursecourseattrmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'course_course_attribute';
   }
   public function get_columns()
   {
   	  return array('id','course_id','course_attribute_id','value','created_at','created_by');
   } 
   
   public function get_by_course($course_id)
   {
   	 $sql = $this->db->select('cca.id,value,course_attribute_id,title,eval_type')
   	 		  ->from($this->get_table_name().' cca')
   	 		  ->join('course_attribute ca','ca.id = cca.course_attribute_id','left')
   	 		  ->where('course_id',$course_id);
   	$query = $sql->get(); 
   	return $query->result_array();
   }
   
 }

?>