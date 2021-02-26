<?php

class Student_list_model extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'student_v';
    }

    public function get_columns() {
        return array('id', 'username');
		
    }
	
	public function get_all_students($data='')
	{
		$this->db->select('s.id,s.extra_facility_id,student_number,p.first_name,last_name,gender,mobile,c.title class,sec.title section,a.class_roll,sp.file_name photo');
        $this->db->from('student s');
        $this->db->join('personal_details p', 'p.id = s.personal_details_id', 'left');
		$this->db->join('student_photo sp', 'sp.id = s.photo_id', 'left');
		$this->db->join('admission a', 'a.student_id = s.id', 'left');                
        $this->db->join('class c', 'c.id = a.class_id', 'left');
		$this->db->join('section sec', 'sec.id = a.section_id', 'left');
		$this->db->where('a.class_id',$data['class_id']);
		if($data['section_id']>0){
		$this->db->where('a.section_id',$data['section_id']);   
		}		
		$this->db->order_by('a.class_roll','ASC');
		$query = $this->db->get();
		$rs = $query->result();
		return $rs;
	}

	
        
	public function get_class_title($class_id)
	{
		$this->db->select('title');
		$this->db->from('class');
		$this->db->where('id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
        

	
	public function get_class()
	{
		$this->db->select('id,title');
 		$this->db->from('class');
 		$this->db->where('status','ACTIVE');
		$this->db->order_by('title','asc');
 			$rs=$this->db->get(); 	    
		return $rs->result_array();  
	}
	public function get_section($class_id)
	{
		$this->db->select('id,title');
 		$this->db->from('section');
 		$this->db->where('class_id',$class_id);
 		$this->db->where('status','ACTIVE');
		$this->db->order_by('title','asc');
 			$rs=$this->db->get(); 	    
		return $rs->result_array();  
	}
	
	/*for attendence */
	
	public function working_days(){
			  $this->db->select('DISTINCT(date)');
			  $this->db->from('student_attendance');
			  $this->db->where('YEAR(date)',date('Y'));
			  $rs=$this->db->get(); 	    
		return $rs->num_rows();		
	}
	public function total_attendance($student_id){
		$query = $this->db->select('student_id,date')
				->from('student_attendance')
				->where('student_id',$student_id)
				->where('attendance_status','Present')
				->where('YEAR(date)',date('Y'));	
				 $rs=$this->db->get(); 	    
		return $rs->num_rows();
	}	
	
	/*end*/
}

?>