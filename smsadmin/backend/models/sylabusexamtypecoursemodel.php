<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 30, 2013
 * 
 * model class for course
 */
class Sylabusexamtypecoursemodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'sylabus_exam_type_course';
    }

    public function get_columns() {
        return array('id', 'sylabus_exam_type_id', 'course_id', 'total_marks','created_at', 'status', 'created_by');
    }
    
    public function save($data){
        $rs_course = array();
        $rs_eval =  array();
        $rs_eval_update =  array();
        $dels = array();
        $num=0;
        $i=0;
        foreach($data['eval'] as $course_id => $course){
            $flag = true;
            $rs_course['sylabus_exam_type_id'] = $data['sylabus_exam_type_id'];
            $rs_course['course_id'] = $course_id;
            $rs_course['id'] = $course['id'];
            $rs_course['status'] = 'ACTIVE';
            $rs_course['total_marks'] = $course['total_marks'];
            if ($course['id']) {
               $this->update($rs_course);
             } else {
               $course['id'] = $this->insert($rs_course);
             }
             foreach($course['type'] as $eval){
                 //in case of save
                 if(empty($eval['id'])){
                    if($eval['value']){
                        $rs_eval[$num]['sylabus_exam_type_course_id'] = $course['id'];
                        $rs_eval[$num]['sylabus_evaluation_type_id'] = $eval['eval_id'];
                        $rs_eval[$num]['created_at'] = $this->now();
                        $rs_eval[$num]['created_by'] = $this->get_created_by();
                        $rs_eval[$num]['value'] = $eval['value'];
                        $rs_eval[$num++]['id'] = $eval['id'];
                        $flag = false;
                    }
                 }else{
                     //incase of delete empty 
                     if(empty($eval['value'])){
                         $dels[$course['id']][] = $eval['id'];
                         continue;
                     }
                     //incase of update
                     $rs_eval_update[$i]['value'] = $eval['value'];
                     $rs_eval_update[$i++]['id'] = $eval['id'];
                     $flag = false;
                 }
                  
                
             }
             // course id is not using
             if($flag)
             $this->delete($course['id']);
        }
        $this->load->model('sylabusexamcourseevalmodel','secemodel');
        if($rs_eval){
            $this->secemodel->insert_batch($rs_eval);
        }

        if($rs_eval_update){
             $this->secemodel->update_batch($rs_eval_update);
        }
        if($dels){
            foreach($dels as $course_id => $eids){
                $this->secemodel->delete_where_in($eids);
            }
        }
        
    }
}

?>