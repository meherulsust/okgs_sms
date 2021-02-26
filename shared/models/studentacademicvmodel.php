<?php

class Studentacademicvmodel extends BACKEND_Model {
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'student_academic_v';
    }

    public function get_columns() {
        return array('id', 'student_number','class','section','class_id','section_id');
    }
   

}

?>