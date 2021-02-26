<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 10, 2012
 * Model class for School class.
 */
class Extrafacilitymodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   } 
   
   public function get_table_name()
   {
   	  return 'student_extra_facility_list';
   }
   public function get_columns()
   {
   	  return array('id','title','created_at');
   }
    
	public function get_extra_facility_list()
	{
		$query = $this->db->select('*')
   	   			->from('student_extra_facility_list')
   	  		    ->get();
		return $query->result_array();		
	}

 } 
?>
