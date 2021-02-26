<?php

/* 
 * Created on 19-04-2016
 * Developed by: Arena Development Team
 * 
 */
class Config_exam_class_ctmodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'config_exam_class_ct';
    }
    public function get_columns() {
        return array('id', 'class_id', 'subject_id', 'exam_id', 'marks_id');
    }
    public function grid_query($params){        
        $this->info_query();
    }
    protected function info_query(){        
        $query =  $this->db->_protect_identifiers=false; 
                $this->db->select('ce.id, cl.title class_title, ex.title examination, ct.title subject_title, '
                . 'GROUP_CONCAT(et.title  ORDER BY et.id) exam_title')
               ->from('config_exam_class_ct ce')
               ->join('class cl', 'cl.id = ce.class_id', 'left')
               ->join('exam ex', 'ex.id = ce.exam_id', 'left')
               ->join('course_title ct', 'ct.id = ce.subject_id', 'left')
               ->join('exam_type et', 'FIND_IN_SET(et.id, ce.marks_id) > 0', 'left')
               ->group_by('ce.id')        
               ->order_by('cl.title', 'asc');
       
       return $query;
    }
    public function get_info($id){
        $q = $this->info_query();
        $q->where('ce.id', $id);
        $query = $q->get();
        return $query->result_array();
    }
    
    public function get_config($id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id, cl.title class_title, ex.title exam_title, ct.title subject_title, '
                . 'GROUP_CONCAT(et.title  ORDER BY et.id) exam_title');
        $this->db->from('config_exam_class_ct ce');
        $this->db->join('class cl', 'cl.id = ce.class_id', 'left');
        $this->db->join('course_title ct', 'ct.id = ce.subject_id', 'left');
        $this->db->join('exam ex', 'ex.id = ce.exam_id', 'left');
        $this->db->join('exam_type et', 'FIND_IN_SET(et.id, ce.marks_id) > 0', 'inner');
        $this->db->where('ce.id', $id);
        $this->db->group_by('ce.id');
        $this->db->order_by('cl.title', 'asc');        
        $rs = $this->db->get();
        return $rs->result_array();
    }
    
    public function delete($id){
        $this->db->delete('config_exam_class_ct', array('id' => $id));
    }
}
 