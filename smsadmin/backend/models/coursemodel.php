<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 09, 2012
 * 
 * model class for course
 */
class Coursemodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'course';
    }

    public function get_columns() {
        return array('id', 'sylabus_id', 'course_title_id', 'total_marks', 'sylabus_course_type_id','serial', 'created_at', 'status', 'code', 'created_by');
    }

    public function grid_query($params) {
        $query = $this->get_info_query();
        $query->where('c.sylabus_id', $params['sylabus_id']);
    }

    public function get_info($id) {
        $query = $this->get_info_query();
        $query->where('c.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    protected function get_info_query() {
        $query = $this->db->select('c.id,c.sylabus_id,ct.title course_type,serial,crst.title course_title,c.status,s.title sylabus,c.total_marks, c.created_at')
                ->from('course c')
                ->join('course_title crst', 'crst.id= c.course_title_id', 'left')
                ->join('sylabus s', 's.id=c.sylabus_id', 'left')
                ->join('sylabus_course_type sct', 'sylabus_course_type_id = sct.id', 'left')
                ->join('course_type ct', 'course_type_id = ct.id', 'left')
                ->order_by('c.serial asc');
        return $query;
    }

    public function save(array $data) {
        $this->db->trans_start();
        if ($data['id']) {
            $course_id = $this->update($data);
        } else {
            $course_id = $this->insert($data);
        }
        if (array_key_exists('evaluation', $data)) {
            $evaluations = $data['evaluation'];
            $eval_data = array();
            $this->load->model('Coursesylabusevaltypemodel', 'csetmodel');
            foreach ($evaluations as $type_id => $eval) {
                if ($eval['value']) {
                    $eval_data['course_id'] = $course_id;
                    $eval_data['sylabus_evaluation_type_id'] = $type_id;
                    $eval_data['created_at'] = $this->now();
                    $eval_data['value'] = $eval['value'];
                    $eval_data['id'] = $eval['id'];
                    if ($eval['id']) {
                        $this->csetmodel->update($eval_data);
                    } else {
                        $this->csetmodel->insert($eval_data);
                    }
                } elseif ($eval['id']) {
                    $this->csetmodel->delete($eval['id']);
                }
            }
        }
        if (array_key_exists('attributes', $data)) {
            $attributes = $data['attributes'];
            $attr_data = array();
            $this->load->model('Coursecourseattrmodel', 'ccamodel');
            foreach ($attributes as $attr_id => $attr) {
                $attr_data['course_id'] = $course_id;
                $attr_data['course_attribute_id'] = $attr_id;
                $attr_data['created_at'] = $this->now();
                $attr_data['value'] = $attr['value'];
                $attr_data['id'] = $attr['id'];
                if ($attr['value']) {
                    if ($attr['id']) {
                        $this->ccamodel->update($attr_data);
                    } else {
                        $this->ccamodel->insert($attr_data);
                    }
                } elseif ($attr['id']) {
                    $this->ccamodel->delete($attr['id']);
                }
            }
        }
        if ($data['books']) {
            $this->load->model('coursebookmodel');
            $data['course_id'] = $course_id;
            $this->coursebookmodel->save($data);
        }
        $this->db->trans_complete();
        return $course_id;
    }

    public function del_course($id) {
        $this->db->trans_start();
        $this->delete($id);
        $this->load->model('Coursesylabusevaltypemodel', 'csetmodel');
        $this->csetmodel->delete_where(array('course_id' => $id));
        $this->load->model('Coursecourseattrmodel', 'ccamodel');
        $this->ccamodel->delete_where(array('course_id' => $id));
        $this->load->model('coursebookmodel');
        $this->coursebookmodel->delete_where(array('course_id' => $id));
        $this->db->trans_complete();
        return true;
    }
    
    public function get_course_by_sylabus($sylabus_id){
         $query = $this->db->select('ct.title course_title,c.id course_id, total_marks')
   	       ->from('course c')
               ->join('course_title ct','ct.id=c.course_title_id','left')
               ->where('sylabus_id',$sylabus_id)
               ->where('c.status','ACTIVE')
               ->order_by('c.serial asc')
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
    }
    
     public function get_course_id($sylabus_id,$type_id){
         $query = $this->db->select('c.id course_id')
   	       ->from('course c')
               ->join('sylabus_course_type sct','sct.id = c.sylabus_course_type_id','left')
               ->join('scourse_type ct','ct.id = sct.course_type_id','left')
               ->where('c.sylabus_id',$sylabus_id)
               ->where('ct.id',$type_id)
               ->where('c.status','ACTIVE')
               ->order_by('c.serial asc')
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
    }

}

?>