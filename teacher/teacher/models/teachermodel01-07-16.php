<?php

class Teachermodel extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'teacher';
    }

    public function get_columns() {
        return array('id', 'username');
    }
	
	
/* 	public function get_general_notice($data)
	{
		$class_id=$data['class_id'];
		$section_id=$data['section_id'];
		$house_id=$data['house_id'];
		$facility_id=$data['facility_id'];
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('student_number <',0);
		$this->db->where('status','ACTIVE');
		$this->db->where('version_id',$data['version_id']);
		$this->db->or_where("(house_id ='$house_id' AND house_id >'0')");
		$this->db->or_where("(facility_id ='$facility_id' AND facility_id >'0')");
		$this->db->or_where("(class_id ='$class_id' AND section_id ='')");
		$this->db->or_where("(class_id ='$class_id' AND section_id ='$section_id')");
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	} */	
	
	public function get_general_notice($designation_id)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('status','ACTIVE');
		$this->db->where('designation_id',$designation_id);
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_personal_notice($student_number)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('student_number',$student_number);
		$this->db->where('status','ACTIVE');
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_all_notice($class_id)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		if($class_id){
		$this->db->where('class_id',$class_id);
		}else{
		$this->db->where('class_id',0);
		}
		$this->db->where('status','ACTIVE');
		$this->db->order_by('created_at','desc');
		$this->db->limit(20);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	
	public function get_book_list($class_id)
	{
		$this->db->select('*');
		$this->db->from('book');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
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
        
	function get_photo($user_id){
		$this->db->select('photo')
				->from('teacher')
				->where('teacher.id',$user_id);
		return $this->get_one();
	}
	
	
	public function get_class_routine($class_id,$section_id)
	{
		$this->db->select('cr.id,class_day_id,class_time_id,cst.title subject,teacher.name teacher_name');
		$this->db->from('class_routine cr');
		$this->db->join('course_title cst','cst.id=cr.subject_id','left');
		$this->db->join('teacher','teacher.id=cr.teacher_id','left');
		$this->db->where('cr.class_id',$class_id);
		$this->db->where('cr.section_id',$section_id);
		$this->db->where('cr.status','ACTIVE');
		$this->db->order_by('cr.class_day_id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array();
	}
	
	public function get_class_day()
	{
		$this->db->select('*');
		$this->db->from('class_day');
		$this->db->order_by('id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_class_time($class_id)
	{
		$this->db->select('*');
		$this->db->from('class_time');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$this->db->order_by('serial','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	
	function update_password($st_id,$passwd)
	{
		$data['passwd'] = $passwd;
		$this->db->update('student',$data,array('id'=>$st_id));
	}
	
	public function edit_teacher($id,$data)
	{
		$this->db->update('teacher',$data,array('id'=>$id));
		return 1;
	}
	
	public function get_notebook($data)
	{
		$class_id=$data['class_id']; 
		$section_id=$data['section_id'];
		$this->db->select('nb.id,nb.title,description,file_name,ct.title subject');
		$this->db->from('note_book nb');
		$this->db->join('course_title ct','ct.id=nb.subject_id');		
		$this->db->where('nb.status','ACTIVE');
		$this->db->where("(nb.class_id ='$class_id' AND nb.section_id ='')");
		$this->db->or_where("(nb.class_id ='$class_id' AND nb.section_id ='$section_id')");
		$this->db->order_by('nb.created_at','desc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function teacher_details($id)
 	{
		$this->db->select('t.name teacher_name,photo,dob,gender,address,designation_id,mobile_no,email,d.title as designation,b.title as blood_group,ct.title as subject, r.title as religion');		
 	 	$this->db->from('teacher t');
 	 	$this->db->join('designation d', 'd.id = t.designation_id', 'left');	
		$this->db->join('blood_group b','b.id = t.blood_group_id','left');
		$this->db->join('course_title ct','ct.id = t.relevant_subject_id','left');
		$this->db->join('religion r','r.id = t.religion_id','left');
		$this->db->where('t.id',$id);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
 	}
	
	public function get_record($id)
 	{
		$this->db->select('t.*,t.name as teacher_name');		
		//$this->db->select('t.name,dob,gender,address,mobile_no,email,d.title as designation,b.title as blood_group,s.title as subject, r.title as religion');		
 	 	$this->db->from('teacher t');
 	 	$this->db->join('designation d', 'd.id = t.designation_id', 'left');	
		$this->db->join('blood_group b','b.id = t.blood_group_id','left');
		$this->db->join('subject s','s.id = t.relevant_subject_id','left');
		$this->db->join('religion r','r.id = t.religion_id','left');
		$this->db->where('t.id',$id);
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
	public function get_designation()
	{	
		$this->db->select('id,title');
        $this->db->from('designation');
        $this->db->where('type','Admin');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	
	public function get_blood_group()
	{	
		$this->db->select('id,title');
        $this->db->from('blood_group');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	
	public function get_religion()
	{	
		$this->db->select('id,title');
        $this->db->from('religion');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	
	public function get_subject()
	{	
		$this->db->select('id,title');
        $this->db->from('subject');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	public function get_exam_list($class_id)
	{
		$this->db->select('id,title');
		$this->db->from('exam');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
}

?>