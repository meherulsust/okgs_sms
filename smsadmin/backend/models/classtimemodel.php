<?php

class Classtimemodel extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'class_time';
    }

    public function get_columns() {
        return array('id','class_id','title','serial','status');
    }	
    
    public function grid_query() {
        $this->db->select('ct.id,ct.title,ct.serial,ct.status,c.title class')
                ->from('class_time ct')
				->join('class c','c.id = ct.class_id','left')
				->order_by('ct.class_id','ASC');
    }  
}

?>