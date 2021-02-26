<?php

class Studentvmodel extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'student_v';
    }

    public function get_columns() {
        return array('id', 'student_number');
    }
	
	
	public function get_general_notice($data)
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
		$this->db->or_where("(class_id ='' AND section_id =''AND designation_id ='0')");
		$this->db->or_where("(class_id ='$class_id' AND section_id ='$section_id')");
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
        
	function get_photo($std_number){
		$this->db->select('file_name')
				->from('student s')
				->join('student_photo sp', 'photo_id = sp.id', 'left')
				->where('s.student_number',$std_number);
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
	
	public function get_syllabus($data)
	{
		$class_id=$data['class_id'];
		$this->db->select('*');
		$this->db->from('upload_syllabus us');	
		$this->db->where('us.status','ACTIVE');
		$this->db->where("(us.class ='$class_id')");
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_exam_list($data)
	{
		$this->db->select('id,title');
		$this->db->from('exam');
		$this->db->where('class_id',$data['class_id']);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
        
    public function get_exams(){
            $this->db->select('id,title');
            $this->db->from('exam');
            $this->db->where('status','ACTIVE');
            $this->db->order_by('title','asc');
            $rs=$this->db->get(); 	    
            return $rs->result_array();  
    }

    
    public function students_by_section($class_id, $section_id) {
        $this->db->select('pd.first_name, pd.last_name, pd.student_id, '
                . 'ad.class_roll, ad.section_id, ad.class_id, st.student_number');
        $this->db->from('personal_details pd');
        $this->db->join('admission ad', 'ad.student_id = pd.student_id', 'left');
        $this->db->join('student st', 'st.id = pd.student_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        if($section_id > 0){
            $this->db->where('ad.section_id', $section_id);
        }
        $this->db->order_by('ad.class_roll', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_exam_full_marks($class_id, $exam_id, $subject_id){        
        $this->db->select('total_marks');
        $this->db->from('config_exam_class_ct');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $rs= $this->db->get();        
        $data = $rs->row_array();
        if(!empty($data)){
            return $data['total_marks'];
        }else{
            return '0';
        }        
    }
    function get_child_mark($class_id,$exam_id,$subject_id,$student_id){
        $this->db->select('*');
        $this->db->from('result_sheet');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id',$subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_class_highest($class_id, $exam_id, $subject_id){
        $this->db->select('max(half_yearly_grand_total) half_yearly_class_highest,'
                . ' max(yearly_grand_total) yearly_class_highest');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_sections($class_id) {
        $this->db->select('id, title');
        $this->db->from('section');
        $this->db->where('class_id', $class_id);
        $rs = $this->db->get();
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
    public function current_exam($exam_id) {
        $this->db->select('title');
        $this->db->from('exam');
        $this->db->where('id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    function check_class_publish($class_id) {
        $this->db->select('id');
        $this->db->from('class');
        $this->db->where('id', $class_id);
        $this->db->where('is_result_publish', '1');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    function check_exam_publish($exam_id){
        $this->db->select('id');
        $this->db->from('exam');
        $this->db->where('id', $exam_id);
        $this->db->where('is_result_publish', '1');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    
    
}

?>