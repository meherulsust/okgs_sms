<?php

class Classdaymodel extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'class_day';
    }

    public function get_columns() {
        return array('id','title','short_title');
    }	
    
      
}

?>