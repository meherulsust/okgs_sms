<?php

class Classroutinemodel extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'class_routine';
    }

    public function get_columns() {
        return array('id','class_id','section_id','subject_id','teacher_id','class_day_id','class_time_id','status');
    }
	
    public function grid_query() {
        $this->db->select('cr.id,cr.status,c.title class,sec.title section,sub.title subject,t.name AS teacher_name,cd.title class_day,ct.title class_time',False)
                ->from('class_routine cr')
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
	
    public function get_details_info($id) {
        $this->db->select('t.id,CONCAT(t.first_name," ",t.last_name) as full_name,gender,mobile_no,email,address,dob,t.status,sub.title relevant_subject,blg.title blood_group,r.title religion',False)
                ->from('teacher t')
				->join('blood_group blg', 'blg.id = t.blood_group_id', 'left')
				->join('religion r', 'r.id = t.religion_id', 'left')
				->join('course_title sub', 'sub.id = t.relevant_subject_id', 'left')                
                ->where('t.id', $id);
        $query = $this->db->get();
        return $query->row_array();
        
    }

      
}

?>