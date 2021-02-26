<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 3, 2011
 **/

class Teacher_routine_model extends BACKEND_Model {
    public function __construct() {
        parent::__construct();
    }
	public function get_class_routine($class_id,$teacher_id)
	{
		$this->db->select('cr.id,class_day_id,class_time_id,cst.title subject,teacher.name teacher_name,section.id,section.title section_title');
		$this->db->from('class_routine cr');
		$this->db->join('course_title cst','cst.id=cr.subject_id','left');
		$this->db->join('teacher','teacher.id=cr.teacher_id','left');
		$this->db->join('section','section.id=cr.section_id','left');
		$this->db->where('cr.class_id',$class_id);
		$this->db->where('cr.teacher_id',$teacher_id);
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
	public function get_class()
	{
		$this->db->select('id,title');
 		$this->db->from('class');
 		$this->db->where('status','ACTIVE');
		$this->db->order_by('title','asc');
 			$rs=$this->db->get(); 	    
		return $rs->result_array();  
	}
	public function get_teacher($class_id)
	{	
		$this->db->distinct();
		$this->db->select('cr.teacher_id id,t.name');
 		$this->db->from('class_routine cr');
 		$this->db->join('teacher t','t.id=cr.teacher_id','inner');
		$this->db->where('cr.class_id',$class_id);
 		$this->db->where('cr.status','ACTIVE');
		$this->db->group_by('teacher_id');
		$this->db->order_by('name','asc');
 			$rs=$this->db->get();		
		return $rs->result_array();  
	}
}

?>