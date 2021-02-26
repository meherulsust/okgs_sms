<?php

class Comment_model extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'comment';
    }

    public function get_columns() {
        return array('id','comment','comment_date');
    }
	
	public function post_comment($data){
		$this->db->insert('comment',$data);
	}
	
	public function get_comment($teacher_id){
		$this->db->select('*');
		$this->db->from('comment');
		$this->db->where('teacher_id',$teacher_id);
			$rs=$this->db->get(); 	    
		return $rs->result_array();
	}
	

}

?>