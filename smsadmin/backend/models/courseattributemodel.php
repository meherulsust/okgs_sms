<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     October 13, 2012
 *  
 *  class for course attribute
 */
 class Courseattributemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'course_attribute';
    }

    public function get_course_attribute()
    {
    	$query = $this->db->select('id,title,eval_type')
    			->where('status','ACTIVE')
    			->where('attribute_for','COURSE');
    	$query = $query->get($this->get_table_name());
    	return $query->result_array();		
    }
   public function get_columns()
   {
   	  return array('id','eval_type','title','eval_func','attribute_for','description','status','description','created_at','created_by');
   }   
 }

?>