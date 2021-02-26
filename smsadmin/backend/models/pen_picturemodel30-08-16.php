<?php

/* 
 * Created on 14-06-2016
 * Developed by: Arena Development Team
 * 
 */
class Pen_picturemodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function add_template($data){
        $this->db->insert('pen_picture_temaplte', $data);
        return $this->db->insert_id();
    }
    function check_template_duplicate($title){
        $this->db->select('id');
        $this->db->where('title', $title);
        $rs = $this->db->get('pen_picture_temaplte');
        return $rs->row_array();
    }
    
    public function get_table_name() {
        return 'pen_picture_temaplte';
    }
    public function get_columns() {
        return array('id', 'title', 'description');
    }
    public function grid_query($params){        
        $this->info_query();
    }
    protected function info_query(){
        $query = $this->db->select('*')
                 ->from('pen_picture_temaplte');
         return $query;
    }
    function update_template($id, $data){
        return $this->db->update('pen_picture_temaplte', $data, array('id' => $id));
    }
    function get_templates() {
        $this->db->select('id, title');
        $this->db->from('pen_picture_temaplte');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_result_entry_details($class_id, $section_id) {
        $this->db->select('title');
        $this->db->where('id', $class_id);
        $cl = $this->db->get('class');
        $class = $cl->row_array();
        if($section_id > 0){
            $this->db->select('title');
            $this->db->where('id', $section_id);
            $se = $this->db->get('section');
            $section = $se->row_array();
        }
        if($section_id > 0){
            return $entry_details = array('class_title' => $class['title'], 'section_title' => $section['title']);
        }else{
            return $entry_details = array('class_title' => $class['title'], 'section_title' => '');
        }
    }
    public function add_pen_pic_details($data){
        $this->db->insert('student_pen_picture_details', $data);
        return $this->db->insert_id();
    }
    public function get_stdent_templates($student_id) {
        $this->db->select('*');
        $this->db->from('student_pen_picture_details');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function edit_pen_pic_details($id, $data){
        return $this->db->update('student_pen_picture_details', $data, array('id' => $id));
    }
}
