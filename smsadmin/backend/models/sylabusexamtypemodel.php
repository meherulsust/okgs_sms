<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 29, 2013
 * 
 * model clas for sylabus evaluation type
 */
 class Sylabusexamtypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus_exam_type';
   }
   public function get_columns()
   {
   	  return array('id','sylabus_id','exam_type_lookup_id','final_percent','created_at','created_by','status');
   } 
   public function grid_query($params)
   {
                $query = $this->get_info_query();
    		$query->where('se.sylabus_id',$params['sylabus_id']);
   }
   
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('se.id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }

   protected function get_info_query()
   {
   		$query = $this->db->select('se.id,sylabus_id,s.title sylabus,se.status,l.title exam_type,final_percent,se.created_at, se.created_by')
   	 			->from('sylabus_exam_type se')
   	 			->join('lookup l','l.id=se.exam_type_lookup_id','left')
   	 			->join('sylabus s','s.id=se.sylabus_id','left');
   	 	return $query;		
   }
   
   public function get_exam_by_sylabus($sylabus_id)
   {
   		$query = $this->db->select('se.id sylabus_exam_type_id,s.title,l.title exam_type')
   	 			->from('sylabus_exam_type se')
   	 			->join('lookup l','l.id=se.exam_type_lookup_id','left')
   				->where('sylabus_id',$sylabus_id)
   				->where('se.status','ACTIVE')
   				->order_by('l.title asc')->get();
   		return $query->result_array();
   }
   
   public function get_sylabus_course($id){
       $query = $this->db->select('se.id,ct.title course,c.id course_id, total_marks')
   	       ->from('sylabus_exam_type se')
               ->join('course c','c.sylabus_id=se.sylabus_id','left')
               ->join('course_title ct','ct.id=c.course_title_id','left')
               ->where('se.id',$id)->where('c.status','ACTIVE')
               ->order_by('ct.title asc')
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
       
 }  
  public function get_course($id){
         $query = $this->db->select('id exam_course_id,course_id,total_marks')
               ->from('sylabus_exam_type_course')
               ->where('sylabus_exam_type_id',$id)
               ->where('status','ACTIVE')
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
    }
    
  public function get_course_eval($id){
      $query = $this->db->select('etce.id course_eval_id, course_id,total_marks,value, sylabus_evaluation_type_id eval_type_id')
               ->from('sylabus_exam_type_course etc')
               ->join('sylabus_exam_type_course_evaluation etce','etc.id = sylabus_exam_type_course_id','left') 
               ->where('sylabus_exam_type_id',$id)
               ->where('etc.status','ACTIVE')
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
  }
           
                
 }

?>
