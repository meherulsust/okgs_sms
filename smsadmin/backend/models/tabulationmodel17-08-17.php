<?php

/* 
 * Created on 19-06-2016
 * Developed by: Arena Development Team
 * 
 */
class Tabulationmodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    function get_result($student_id, $class_id, $section_id, $exam_id){
        $this->db->select('rs.*');
        $this->db->from('result_sheet rs');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        if(isset($section_id) && $section_id > 0){
            $this->db->where('section_id', $section_id);
        }
        $this->db->where('exam_id', $exam_id);
        $this->db->order_by('subject_id', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    function get_subjects($class_id) {
        $this->db->select('ct.id, ct.title subject');
        $this->db->from('course_title ct');
        $this->db->join('assigned_courses ac', 'ac.course_title_id = ct.id', 'left');
        $this->db->where('class_id', $class_id);
//        $this->db->order_by('id', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    function get_exam_title($exam_id) {
        $this->db->select('title');
        $this->db->from('exam');
        $this->db->where('id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_total_exam_marks($class_id, $exam_id, $student_id){
        $this->db->select('SUM(res.half_yearly_grand_total) total_mks_half_yearly, '
                . 'SUM(yearly_grand_total) total_mks_yearly');
        $this->db->from('result_sheet res');
        $this->db->where('res.class_id', $class_id);
        $this->db->where('res.exam_id', $exam_id);
        $this->db->where('res.student_id', $student_id);
        $this->db->where('res.subject_id !=', '62');
        $rs = $this->db->get();       
        return $rs->row_array();
    }
    public function get_position($student_id) {
        $this->db->select('position');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get('result_sheet');
        return $rs->row_array();
    }
    public function get_section($section_id) {
        $this->db->select('title section');
        $this->db->where('id', $section_id);
        $rs = $this->db->get('section');
        return $rs->row_array();
    }
    public function get_roll($student_id) {
        $this->db->select('class_roll');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get('admission'); //       echo $this->db->last_query(); exit;
        return $rs->row_array();
    }
    function fetch_stduents_withoutsecs() {
        $this->db->select('student_id');
        $this->db->from('result_sheet rs');
        $this->db->where('section_id', '0');
        $this->db->where('class_id', '9');
        $rs = $this->db->get();        
        return $rs->result_array();
    }
    function getstudent_sections($student_id) {
        $this->db->select('section_id');
        $this->db->from('admission');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get();        
        return $rs->row_array();
    }
    function update_studentwithout_sec($student_id, $section_id) {
        $this->db->set('section_id', $section_id);
        $this->db->where('student_id', $student_id);
        $this->db->update('result_sheet');
        return TRUE;
    }
    public function get_tabulation_ids($class_id, $exam_id, $section_id) {
        $this->db->select('st.student_id,stv.father_name,mother_name');
        $this->db->from('result_sheet st');
        $this->db->join('student_v stv', 'stv.id = st.student_id', 'left');
        $this->db->where('st.class_id', $class_id);
        $this->db->where('st.exam_id', $exam_id);
        if(isset($section_id) && $section_id > 0){
            $this->db->where('st.section_id', $section_id);
        }
        $this->db->group_by('st.student_id');
        $this->db->order_by('st.position', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
}