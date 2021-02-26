<?php

class Comment_model extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'student_comment';
    }

    public function get_columns() {
        return array('id','comment','comment_date');
    }
	
	public function post_comment($data){
		$this->db->insert('student_comment',$data);
	}
	
	public function get_comment($student_id){
		$this->db->select('*');
		$this->db->from('student_comment');
		$this->db->where('student_id',$student_id);
			$rs=$this->db->get(); 	    
		return $rs->result_array();
	}
	

}

?>