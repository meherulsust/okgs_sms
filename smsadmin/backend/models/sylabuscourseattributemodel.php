<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     November 13, 2012
 *  
 * model class for sylabus course attribute
 */
 class Sylabuscourseattributemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
    public function grid_query($params)
    {
    	$query = $this->get_info_query();
    	$query->where('sca.sylabus_id',$params['sylabus_id']);		
    	
    }
    
    public function get_table_name()
    {
   	   return 'sylabus_course_attribute';
    }
    
    public function get_info($id)
    {
    	$query = $this->get_info_query();
    	$query->where('sca.id',$id);
    	$query = $this->db->get();
   	  	return $query->row_array();		
    }
    protected function get_info_query()
    {
    	$query = $this->db->select('sca.id,s.title sylabus, params, execution_order,ca.title attribute,sca.created_at, sca.created_by,sca.status')
    			->from($this->get_table_name().' sca')
    			->join('sylabus s','sca.sylabus_id = s.id','left')
    			->join('course_attribute ca','sca.course_attribute_id = ca.id','left');
    	return $query;
    }
   public function get_columns()
   {
   	  return array('id','sylabus_id','course_attribute_id','params','execution_order','status','created_at','created_by');
   } 
   
   public function get_sylabus_attribute($sylabus_id){
       $query = $this->db->select('params,course_attribute_id,eval_type,eval_func')
               ->from('sylabus_course_attribute sca')
               ->join('course_attribute ca','sca.course_attribute_id = ca.id','left')
               ->where('sylabus_id',$sylabus_id)
               ->get();
       return $query->result_array();       
   }
 }

?>