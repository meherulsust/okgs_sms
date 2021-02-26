<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 17, 2012
 * 
 * model class for course sylabus evaluation type
 */
 class Coursesylabusevaltypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'course_sylabus_evaluation_type';
   }
   public function get_columns()
   {
   	  return array('id','course_id','sylabus_evaluation_type_id','value','created_at','created_by');
   } 
   
   public function get_by_course($course_id)
   {
   	 $sql = $this->db->select('cset.id,sylabus_evaluation_type_id,value,et.title,eval_type')
   	 		  ->from($this->get_table_name().' cset')
   	 		  ->join('sylabus_evaluation_type st','st.id = cset.sylabus_evaluation_type_id','left')
   	 		  ->join('evaluation_type et','et.id = st.evaluation_type_id','left')
   	 		  ->where('course_id',$course_id);
   	$query = $sql->get(); 
   	return $query->result_array();
   }
  
 }

?>