<?php

/**
 * @ Author     Avijit Chakravarty
 * @ Created    Jan 10, 2017
 */
class Extra_classmodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'extra_classes';
    }
    public function get_columns() {
        return array('id','class_id','section_id','subject_id','teacher_id','class_day_id','class_time_id','status', 'class_date');
    }
    public function grid_query() {
        $this->db->select('cr.id,cr.status,c.title class,sec.title section,sub.title subject,t.name AS teacher_name,cd.title class_day,ct.title class_time, cr.class_date',False)
                ->from('extra_classes cr')
                ->join('class c','c.id = cr.class_id','left')
                ->join('section sec','sec.id = cr.section_id','left')
                ->join('course_title sub', 'sub.id = cr.subject_id','left')
                ->join('teacher t','t.id = cr.teacher_id','left')
                ->join('class_day cd','cd.id = cr.class_day_id','left')
                ->join('class_time ct','ct.id = cr.class_time_id','left');
    }
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('class_routine cr');
        return $query->count_all_results();
    }
    public function delete_extra_class($id){
        $this->db->delete('extra_classes', array('id' => $id));
    }
    public function check_empty($teacher_id, $class_day_id, $class_time_text){
        $this->db->select('cr.id');
        $this->db->from('class_routine cr');
        $this->db->join('class_time ct', 'ct.id = cr.class_time_id', 'left');
        $this->db->where('cr.teacher_id', $teacher_id);
        $this->db->where('ct.title', $class_time_text);
        $this->db->where('cr.class_day_id', $class_day_id);
        $rs = $this->db->get();
        return $rs->num_rows();
    }
    public function check_empty_extra_class($teacher_id, $class_day_id, $class_time_text){
        $this->db->select('cr.id');
        $this->db->from('extra_classes cr');
        $this->db->join('class_time ct', 'ct.id = cr.class_time_id', 'left');
        $this->db->where('cr.teacher_id', $teacher_id);
        $this->db->where('ct.title', $class_time_text);
        $this->db->where('cr.class_day_id', $class_day_id);
        $rs = $this->db->get();
        return $rs->num_rows();
    }
    public function get_teacher_info($teacher_id){
        $this->db->select('name, mobile_no');
        $this->db->from('teacher');
        $this->db->where('id', $teacher_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
}
