<?php

class Teachermodel extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'teacher';
    }

    public function get_columns() {
        return array('id','name','dob','username','passwd','designation_id','gender','blood_group_id','religion_id','address','mobile_no','email','t.status','photo','relevant_subject_id','created_at','updated_at','created_by','updated_by','order','edulabel');
    }
	
    public function grid_query() {
        $this->db->select('t.id,t.name as full_name,username,gender,mobile_no,email,address,dob,t.status,t.order,t.edulabel,sub.title relevant_subject,blg.title blood_group,r.title religion,dg.title as designation',False)
                ->from('teacher t')
				->join('blood_group blg', 'blg.id = t.blood_group_id', 'left')
				->join('religion r', 'r.id = t.religion_id', 'left')
				->join('course_title sub', 'sub.id = t.relevant_subject_id', 'left')
				->join('designation dg', 'dg.id = t.designation_id', 'left')
				->where_in('designation_id',array('2','3','14','17','18','51','52','53','54'))								
				->order_by('t.order','ASC');
    }
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('teacher t');
        return $query->count_all_results();
    }
	
    public function get_details_info($id) {
        $this->db->select('t.id,t.name as full_name,gender,mobile_no,email,photo,address,dob,t.status,t.order,t.edulabel,sub.title relevant_subject,blg.title blood_group,r.title religion',False)
                ->from('teacher t')
				->join('blood_group blg', 'blg.id = t.blood_group_id', 'left')
				->join('religion r', 'r.id = t.religion_id', 'left')
				->join('course_title sub', 'sub.id = t.relevant_subject_id', 'left')                
                ->where('t.id', $id);
        $query = $this->db->get();
        return $query->row_array();
        
    }
	
	public function check_duplicate_user($str,$param)
    {
		$this->db->select('id');	
		$this->db->from('teacher');	
		$this->db->where('username',$str);
		if($param)
		$this->db->where('username <>',$param);	
		$rs=$this->db->get();	    
		return $rs->num_rows();
    }
	
      
}

?>