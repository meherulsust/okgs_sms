<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     November 12, 2012
 *  
 *  class for course type course attribute
 */
 class Coursetypecourseattributemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
    public function grid_query($params)
    {
    	$query = $this->get_info_query();
    	$query->where('ctca.course_type_id',$params['course_type_id']);		
    	
    }
    
    public function get_table_name()
    {
   	   return 'course_type_course_attribute';
    }
    
    public function get_info($id)
    {
    	$query = $this->get_info_query();
    	$query->where('ctca.id',$id);
    	$query = $this->db->get();
   	  	return $query->row_array();		
    }
    protected function get_info_query()
    {
    	$query = $this->db->select('ctca.id,ct.title course_type,params,execution_order,ca.title attribute,ctca.created_at, ctca.created_by,ctca.status')
    			->from($this->get_table_name().' ctca')
    			->join('course_type ct','ctca.course_type_id = ct.id','left')
    			->join('course_attribute ca','ctca.course_attribute_id = ca.id','left');
    	return $query;
    }
   public function get_columns()
   {
   	  return array('id','course_type_id','course_attribute_id','params','execution_order','status','created_at','created_by');
   }   
 }

?>