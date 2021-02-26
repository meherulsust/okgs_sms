<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 30, 2013
 * 
 * model class for course Sylabus exam type course evaluation
 */
 class Sylabusexamcourseevalmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus_exam_type_course_evaluation';
   }
   public function get_columns()
   {
   	  return array('id','sylabus_exam_type_course_id','sylabus_evaluation_type_id','value','created_at','created_by');
   } 
   
   public function get_by_exam_type_course($course_id)
   {
   	 $sql = $this->db->select('cset.id,sylabus_evaluation_type_id,value,et.title,eval_type')
   	 		  ->from($this->get_table_name().' cset')
   	 		  ->join('sylabus_evaluation_type st','st.id = cset.sylabus_evaluation_type_id','left')
   	 		  ->join('evaluation_type et','et.id = st.evaluation_type_id','left')
   	 		  ->where('sylabus_exam_type_course_id',$course_id);
   	$query = $sql->get(); 
   	return $query->result_array();
   }
   
     public function get_course_evals($sylabus_id,$exam_type_id){
       $sql = $this->db->select('setc.id,sylabus_evaluation_type_id,value,et.title,eval_type')
                        ->from($this->get_table_name().' setce')
                        ->join('sylabus_evaluation_type set','set.id = setce.sylabus_evaluation_type_id','left')
   	 		->join('evaluation_type et','et.id = set.evaluation_type_id','left')
                        ->join('sylabus_exam_type_course setc','setc.id = setcv.sylabus_exam_type_course_id','left')
                        ->join('sylabus_exam_type set','set.id = setcv.sylabus_exam_type_id','left')
                        ->where('set.sylabus_id',$sylabus_id)
                        ->where('set.exam_type_lookup_id',$exam_type_id);
        $query = $sql->get();
        if($query->num_rows()>0)
            return $query->result_array();
        else
            return false;
    }
  
 }

?>