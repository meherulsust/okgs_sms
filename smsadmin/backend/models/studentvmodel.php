<?php

class Studentvmodel extends BACKEND_Model {
    protected $xls_fields = array();
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'student_v';
    }

    public function get_columns() {
        return array('id', 'student_number');
    }
	
	public function get_student_list(){
       $query = $this->db->select('st.*,h.title house')
               ->from('student_v st')
               ->where_not_in('st.status','tc')
               ->where('st.is_approve','Yes')
			   //->join('student s','s.id = st.id','left')
               ->join('student_house sth','sth.student_id = st.id','left')
			   ->join('house h','h.id = sth.house_id','left');             
       return $query;
   }
   
   public function count_student(){
       $query = $this->db->select('st.id')
			   ->from('student_v st')
               ->where_not_in('st.status','tc')
               ->where('st.is_approve','Yes')			   
			   //->join('student s','s.id = st.id','left')
               ->join('student_house sth','sth.student_id = st.id','left')
			   ->join('house h','h.id = sth.house_id','left'); 
       return $query->count_all_results();
   }
   
	public function get_student_approve_list(){
       $query = $this->db->select('st.*,h.title house')
               ->from('student_v st')
			   ->where('st.is_approve','No')
			   ->or_where('st.approve_date',date("Y-m-d")) 
               ->where_not_in('st.status','tc')
			   //->join('student s','s.id = st.id','left')
               ->join('student_house sth','sth.student_id = st.id','left')
			   ->join('house h','h.id = sth.house_id','left');             
       return $query;
   }
   
   public function count_approve_student(){
       $query = $this->db->select('st.id')
			   ->from('student_v st')
			   ->where('st.is_approve','No')
			   ->or_where('st.approve_date',date("Y-m-d"))
               ->where_not_in('st.status','tc')
			   //->join('student s','s.id = st.id','left')
               ->join('student_house sth','sth.student_id = st.id','left')
			   ->join('house h','h.id = sth.house_id','left'); 
       return $query->count_all_results();
   }
   
}

?>