<?php

class Notebookmodel extends BACKEND_Model {
    
	public function __construct() {
        parent::__construct();
    }
		
	public function get_table_name() {
        return 'note_book';
    }

    public function get_columns() {
        return array('id','title','description','subject_id','class_id','section_id','file_name','status','created_at','created_by');
    }
	
    public function grid_query() {
        $this->db->select('nb.id,nb.title as note_title,nb.description,nb.status,cl.title class,sec.title section,cs.title subject')
                ->from('note_book nb')
				->join('class cl', 'cl.id = nb.class_id', 'left')
				->join('section sec', 'sec.id = nb.section_id', 'left')
				->join('course_title cs', 'cs.id = nb.subject_id', 'left');
    }
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('note_book');
        return $query->count_all_results();
    }
	
    public function get_details_info($id) {
        $this->db->select('nb.id,nb.title as note_title,nb.description,nb.status,cl.title class,sec.title section,cs.title subject')
                ->from('note_book nb')
				->join('class cl', 'cl.id = nb.class_id', 'left')
				->join('section sec', 'sec.id = nb.section_id', 'left')
				->join('course_title cs', 'cs.id = nb.subject_id', 'left')                
                ->where('nb.id', $id);
        $query = $this->db->get();
        return $query->row_array();
        
    }

	
      
}

?>