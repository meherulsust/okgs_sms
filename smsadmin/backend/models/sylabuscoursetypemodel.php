<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 02, 2012
 * 
 * model clas for sylabus course type
 */
 class Sylabuscoursetypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus_course_type';
   }
   public function get_columns()
   {
   	  return array('id','sylabus_id','course_type_id','created_at','created_by','status');
   } 
   public function grid_query($params)
   {
   	        $query = $this->get_info_query();
    		$query->where('sc.sylabus_id',$params['sylabus_id']);
   }
   
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('sc.id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }

   protected function get_info_query()
   {
   		$query = $this->db->select('sc.id,sylabus_id,s.title sylabus,sc.status,c.title course_type, sc.created_at')
   	 			->from('sylabus_course_type sc')
   	 			->join('course_type c','c.id=sc.course_type_id','left')
   	 			->join('sylabus s','s.id=sc.sylabus_id','left');
   	 	return $query;		
   }
   
  public function get_course_type_list($params)
   {
   	  $query = $this->db->select('sct.id id, ct.title')
   	  		 ->from('sylabus_course_type sct')
   	  		 ->join('course_type ct','sct.course_type_id=ct.id','left')
   	  		 ->where('sylabus_id',$params['sylabus_id'])
   	  		 ->order_by('title asc');
   	  return $query->get();		 
   }
   
  public function get_sylabus_course_type_attribute($sylabus_id){
       $query = $this->db->select('sct.id sylabus_course_type_id,params,course_attribute_id, eval_type,eval_func')
               ->from('sylabus_course_type sct')
               ->join('course_type_course_attribute ctca','ctca.course_type_id = sct.course_type_id','left')
               ->join('course_attribute ca','ctca.course_attribute_id = ca.id','left')
               ->where('sct.sylabus_id',$sylabus_id)
               ->get();
       return $query->result_array();       
   }
 }

?>