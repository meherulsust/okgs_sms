<?php
/* 
 * Created on 21-04-2016
 * Developed by: Arena Development Team
 * 
 */

class Result_formulamodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
        return 'formula';
    }
    public function get_columns() {
        return array('id', 'formula', 'formula_title', 'class_id', 'subject_id', 'exam_id');
    }
    public function grid_query($params){        
        $this->info_query();
    }
    protected function info_query(){
        $query = $this->db->select('fr.id, fr.formula formula_actual, fr.formula_title formula, cl.title class_title, sb.title subject_title, ex.title examination')
                        ->from('formula fr')
                        ->join('class cl', 'cl.id = fr.class_id', 'left')
                        ->join('exam ex', 'ex.id = fr.exam_id', 'left')
                        ->join('course_title sb', 'sb.id = fr.subject_id', 'left')
                        ->order_by('fr.id');                
        return $query;
    }
    
    function get_formulas($id){
        $query = $this->db->select('fr.id, fr.formula formula_actual, fr.formula_title formula, cl.title class_title, ct.title subject_title, ex.title examination')
                        ->from('formula fr')
                        ->join('class cl', 'cl.id = fr.class_id', 'left')
                        ->join('exam ex', 'ex.id = fr.exam_id', 'left')
                        ->join('course_title ct', 'ct.id = fr.subject_id', 'left')
                        ->where('fr.id', $id)
                        ->order_by('fr.id');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    public function add($data){
        $this->db->insert('formula', $data);
        return $this->db->insert_id();
    }
    public function get_classes(){
        $this->db->select('id, title');
        $this->db->from('class');
        $this->db->order_by('id');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    
    public function get_subjects(){
        $this->db->select('id, title');
        $this->db->from('subject');
        $this->db->order_by('id');
        $rs = $this->db->get();
        return $rs->result_array();
    }    
    function edit($id, $data){
        return $this->db->update('formula', $data, array('id' => $id));
    }
    public function delete($id){
        $this->db->delete('formula', array('id' => $id));
    }
    public function find_formula($id){
        $this->db->select('id, formula hidden_formula, formula_title formula, class_id, subject_id, exam_id');
        $this->db->from('formula');
        $this->db->where('id', $id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function check_formula_duplicate($class_id, $subject_id, $exam_id) {
        $this->db->select('id');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $rs = $this->db->get('formula');
        return $rs->row_array();
    }
    public function students_by_section($class_id, $section_id) {
        $this->db->select('pd.first_name, pd.last_name, pd.student_id, '
                . 'ad.class_roll, ad.section_id, ad.class_id, st.student_number');
        $this->db->from('personal_details pd');
        $this->db->join('admission ad', 'ad.student_id = pd.student_id', 'left');
        $this->db->join('student st', 'st.id = pd.student_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        if($section_id > 0){
            $this->db->where('ad.section_id', $section_id);
        }
        $this->db->where('st.status_id', '1');
        $this->db->order_by('ad.class_roll', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_student_info($class_id, $exam_id, $student_id){
        $this->db->select('rs.student_id, rs.exam_id, rs.class_id, pd.first_name, pd.last_name, cl.title class_name,'
                . ' ad.class_roll, sec.title section_title, st.student_number, h.title house');
        $this->db->from('result_sheet rs');
        $this->db->join('admission ad', 'ad.student_id = rs.student_id', 'left');
        $this->db->join('personal_details pd', 'pd.student_id = rs.student_id', 'left');
        $this->db->join('section sec', 'sec.id = ad.section_id', 'left');
        $this->db->join('class cl', 'cl.id = rs.class_id', 'left');
        $this->db->join('student st', 'st.id = rs.student_id', 'left');
        $this->db->join('student_house sh', 'sh.student_id = rs.student_id', 'left');
        $this->db->join('house h', 'h.id = sh.house_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        $this->db->where('rs.exam_id', $exam_id);
        $this->db->where('rs.student_id', $student_id);
//        $this->db->group_by('pd.first_name');
//        $this->db->order_by('rs.student_id', 'asc');
        $rs = $this->db->get();
        return $rs->row_array();
    }
	public function get_students_list($class_id, $section_id, $exam_id, $subject_id) {
        $this->db->select('student_id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        if(isset($section_id) && $section_id > 0){
            $this->db->where('section_id', $section_id);
        }
        $rs = $this->db->get();  
        return $rs->result_array();
    }
    function remove_subject_entry($class_id, $student_id, $section_id, $exam_id, $subject_id){
        $this->db->where('class_id', $class_id);
        $this->db->where('student_id', $student_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->delete('result_sheet');
    }
}
