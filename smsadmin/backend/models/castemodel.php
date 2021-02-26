<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2012
 * Model class for caste.
 */
class Castemodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'religion_caste';
   }
    
   public function get_caste_by_religion($religion_id)
   {
   	  $this->db->from($this->get_table_name())
   	        ->select('id,title')
   	        ->where('religion_id',$religion_id)
   	        ->order_by('title asc');
   	   return $this->db->get();     
   }
   public function caste_list_by_religion($religion_id)
   {
   	  $query = $this->get_caste_by_religion($religion_id);
   	  return $query->result_array();
   }
   public function get_columns()
   {
   	  return array('id','religion_id','title');
   }
   

 } 
?>