<?php

class Syllabus_list_model extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'upload_syllabus';
    }

    public function get_columns() {
        return array('id', 'title');
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
	
	public function get_syllabus($class_id)
	{
		$this->db->select('*');
 		$this->db->from('upload_syllabus');
 		$this->db->where('status','ACTIVE');
		$this->db->where('class',$class_id);
			$rs=$this->db->get(); 	    
		return $rs->result_array();  
	}

}

?>