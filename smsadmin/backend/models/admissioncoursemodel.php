<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     December 04, 2012
 * 
 * model class for admission course
 */
class Admissioncoursemodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'admission_course';
    }

    public function grid_query($params) {
        $query = $this->get_info_query();
        $query->where('student_id', $params['student_id']);
        return $query;
    }

    public function save($data) {
        $num = 0;
        foreach ($data['adcrs'] as $rows) {
            foreach ($rows as $row) {
                if ($row['id'] && !isset($row['course_id'])) {
                    $this->delete($row['id']);
                } elseif (isset($row['course_id']) && !$row['id']) {
                    $rs[$num]['course_id'] = $row['course_id'];
                    $rs[$num]['admission_id'] = $data['admission_id'];
                    $rs[$num]['created_at'] = $this->now();
                    $rs[$num]['created_by'] = 1;
                    $num++;
                }
            }
        }
        if ($num > 0)
            $this->db->insert_batch($this->get_table_name(), $rs);
    }

    protected function get_active_sylabus($class_id, $section_id) {

        $sql = $this->db->select('id')
                ->from('sylabus s')
                ->where("(class_id = '$class_id' AND status = 'ACTIVE')  AND ( section_id = '0' or section_id = '$section_id' ) ");

        return $this->get_one();
    }

    public function get_info($id) {
        $query = $this->get_info_query();
        $query->where('a.id', $id);
        $rs = $query->get();
        return $rs->row_array();
    }

    public function get_columns() {
        return array('id', 'admission_id', 'course_id', 'created_at', 'created_by');
    }

    public function get_by_course($course_id) {
        $sql = $this->db->select('cset.id,sylabus_evaluation_type_id,value,et.title,eval_type')
                ->from($this->get_table_name() . ' cset')
                ->join('sylabus_evaluation_type st', 'st.id = cset.sylabus_evaluation_type_id', 'left')
                ->join('evaluation_type et', 'et.id = st.evaluation_type_id', 'left')
                ->where('course_id', $course_id);
        $query = $sql->get();
        return $query->result_array();
    }

    protected function get_info_query() {
        $query = $this->db->select('a.id,c.title class, sylabus_id, student_id,section_id, s.title section,s.class_id,session,a.status,class_roll,fee,a.created_at')
                ->from('admission a')
                ->join('class c', 'a.class_id = c.id', 'left')
                ->join('section s', 'a.section_id = s.id', 'left');
        return $query;
    }

    public function get_course($admission_id) {
        $sql = $this->db->select('ac.id, course_type_id, admission_id,course_id')
                ->from('admission_course ac')
                ->join('course c', 'ac.course_id = c.id', 'left')
                ->join('sylabus_course_type sct', 'c.sylabus_course_type_id = sct.id', 'left')
                ->where("ac.admission_id = '$admission_id'");
        $query = $sql->get();
        return $query->result_array();
    }

    public function get_course_type($admission_id) {
        $sql = $this->db->select('course_type_id id, ct.title ')
                ->from('sylabus_course_type sct')
                ->join('course_type ct', 'course_type_id = ct.id', 'left')
                ->join('admission a', 'a.sylabus_id = sct.sylabus_id', 'left')
                ->where("a.id = '$admission_id'")
                ->order_by('title asc');
        $rs = $this->get_list();
        return $rs;
    }

    public function is_roll_exist($student_id, $roll_no, $session, $class_id, $section_id) {
        $query = $this->db->select('student_id')
                ->from('admission')
                ->where("class_roll = '$roll_no' AND session='$session' AND class_id ='$class_id' AND ( section_id = '0' or section_id = '$section_id' ) ")
                ->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            // check for edit
            if ($row['student_id'] == $student_id)
                return false;
            else
                return true;
        }
        else
            return false;
    }

}

?>