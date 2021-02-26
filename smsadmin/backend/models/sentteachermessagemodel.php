<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
 class Sentteachermessagemodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
  
    public function get_columns()
	{
		return array('id','teacher_id','message','status','created_at');
	}
  
   public function get_table_name()
   {
   	 return 'teacher_message_sent_list';
   }

   
    public function grid_query() {
        $query = $this->db->select('sm.id,sm.status,sm.teacher_id,sm.created_at,mn.title as message,t.name as teacher_name,t.mobile')
				->from('teacher_message_sent_list sm')			
				->join('message_notification mn','mn.id=sm.message_id','left')
				->join('teacher t','t.id=sm.teacher_id','left');
				
				}
   
 	public function message_list(){
		$query = $this->db->select('msl.id,msl.status,msl.created_at,mn.title message,t.name as teacher_name, t.mobile_no')
				->from('teacher_message_sent_list msl')		
				->join('message_notification mn','mn.id=msl.message_id','left')
				->join('teacher t','t.id=msl.teacher_id','left');
				//->join('student_v st','st.id=msl.student_id','left')
				//->join('student_house sth','sth.student_id=msl.student_id','left')				
				//->join('house','house.id=sth.house_id','left');             
		return $query;
	} 
   
	function message_count(){
		$query = $this->db->select('ms1.id')
				->from('teacher_message_sent_list msl');
       return $query->count_all_results();
	}
	
	
	function get_teacher_list($data)
	{
		$this->db->select('*');
		$this->db->from('teacher');
		$this->db->where('designation_id',$data['designation_id']);
		$this->db->order_by('id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}	
	
	function get_all_teacher_list()
	{
		$this->db->select('*');
		$this->db->from('teacher');
		$this->db->where('status','ACTIVE');
		$this->db->order_by('id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}	
	
	
	function get_teacher_mobile_no($teacher_id)
	{
		$this->db->select('teacher.mobile_no');
		$this->db->from('teacher');
		$this->db->where('id',$teacher_id);
		$rs=$this->db->get(); 	    
		return $rs->row_array(); 
	}
	
	
	function add_sent_teacher_message($data)
	{
		$this->db->insert('teacher_message_sent_list',$data);
		return $this->db->insert_id();
	}
        
       
      
	
 }

?>