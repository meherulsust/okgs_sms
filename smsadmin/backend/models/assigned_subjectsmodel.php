<?php

/* 
 * Created on 11-05-2016
 * Developed by: Arena Development Team
 * 
 */
class Assigned_subjectsmodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'assigned_courses';
    }
    public function get_columns() {
        return array('id', 'class_id', 'course_title_id', 'status', 'created_at', 'created_by');
    }
    public function grid_query($params){        
        $this->info_query();
    }
    protected function info_query(){        
        $query =  $this->db->select('ac.id, cl.title class_title, ct.title course_title')
               ->from('assigned_courses ac')
               ->join('class cl', 'cl.id = ac.class_id', 'left')
               ->join('course_title ct', 'ct.id = ac.course_title_id', 'left')
               ->order_by('ac.class_id', 'asc');
       return $query;
    }
    public function get_info($id){
        $q = $this->info_query();
        $q->where('ac.id', $id);
        $query = $q->get();
        return $query->result_array();
    }
    public function edit($id, $data) {
        $this->db->update('assigned_courses', $data, array('id' => $id));
    }
    public function set_subject($data){
        $this->db->insert('assigned_courses', $data);
        return $this->db->insert_id();
    }
    public function delete($id){
        $this->db->delete('assigned_courses', array('id' => $id));
    }
    public function config_subject_duplicate($class_id, $course_id) {
        $this->db->select('id');
        $this->db->where('class_id', $class_id);
        $this->db->where('course_title_id', $course_id);
        $rs = $this->db->get('assigned_courses');
        return $rs->row_array();
    }
}