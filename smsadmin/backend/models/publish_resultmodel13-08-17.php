<?php

/* 
 * Created on 19-04-2016
 * Developed by: Arena Development Team
 * 
 */
class Publish_resultmodel extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    public function get_table_name() {
//        return '';
    }
    public function add($data){
        $this->db->insert('config_exam_class_ct', $data);
        return $this->db->insert_id();
    }
    function edit($id, $data){
        return $this->db->update('config_exam_class_ct', $data, array('id' => $id));
    }
    function get_exam_types(){
        $this->db->select('id, title, field_name');
        $this->db->from('exam_type');
        $this->db->order_by('id');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    function check_config_duplicate($class_id, $subject_id, $exam_id){
        $this->db->select('id');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $rs = $this->db->get('config_exam_class_ct');
        return $rs->row_array();
    }    
    function get_test_types($class_id, $exam_id, $subject_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id, cl.title class_title, ex.title exam_title, sb.title subject_title, '
                . 'GROUP_CONCAT(et.title  ORDER BY et.id) exam_title, '
                . 'GROUP_CONCAT(et.field_name  ORDER BY et.id) field_name');
        $this->db->from('config_exam_class_ct ce');
        $this->db->join('class cl', 'cl.id = ce.class_id', 'left');
        $this->db->join('subject sb', 'sb.id = ce.subject_id', 'left');
        $this->db->join('exam ex', 'ex.id = ce.exam_id', 'left');
        $this->db->join('exam_type et', 'FIND_IN_SET(et.id, ce.marks_id) > 0', 'left');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.subject_id', $subject_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->group_by('ce.id');
        $this->db->order_by('cl.title', 'asc');        
        $rs = $this->db->get();
        return $rs->row_array();
    }
    
    function get_formula($class_id, $subject_id){
        $this->db->select('formula');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get('formula');
        return $rs->row_array();
    }
    public function generate_result($data){
        $this->db->insert('result_sheet', $data);
        return $this->db->insert_id();
    }
    public function add_result($data){
        $this->db->insert('result_sheet', $data);
        return $this->db->insert_id();
    }
    public function edit_result_sheet($result_sheet_id, $data){
        return $this->db->update('result_sheet', $data, array('id' => $result_sheet_id));
    }
    public function get_result_scale($class_id){
        $this->db->select('result_scale_id');
        $this->db->from('class');
        $this->db->where('id', $class_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_scale_matrices($result_scale_id,$point){
        $this->db->select('title, weight');
        $this->db->from('scale_matrix');
        $this->db->where('result_scale_id',$result_scale_id);
        $this->db->order_by('weight','desc');
        $rs = $this->db->get();
        $aa = $rs->result_array();
        foreach($aa as $val)
        {
            $title = $val['title'];
            if($val['weight']<=$point){
                break;
            }
        }
        return $title;
    }
    public function get_classes(){
        $this->db->select('id, title');
        $this->db->from('class');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_exams(){
        $this->db->select('id, title');
        $this->db->where('status', 'ACTIVE');
        $rs = $this->db->get('exam');
        return $rs->result_array();
    }

    public function get_entire_class_result($class_id, $exam_id, $student_id,$result_scale_id){
        $this->db->select('rs.*, cl.title class_name, ct.title subject_name,ct.child_id, ct.is_parent,'
                . 'pd.first_name, pd.last_name, pd.subject_group_id, ad.class_roll, sec.title section_title,'
                . '');
        $this->db->from('result_sheet rs');
        $this->db->join('class cl', 'cl.id = rs.class_id', 'left');
//      $this->db->join('subject sb', 'sb.id = rs.subject_id', 'left');
        $this->db->join('course_title ct', 'ct.id = rs.subject_id', 'left');
        $this->db->join('personal_details pd', 'pd.student_id = rs.student_id', 'left');
        $this->db->join('admission ad', 'ad.student_id = rs.student_id', 'left');
        $this->db->join('section sec', 'sec.id = ad.section_id', 'left');
        $this->db->where('rs.class_id', $class_id);
        $this->db->where('rs.exam_id', $exam_id);
        $this->db->where('rs.student_id', $student_id);        
        $this->db->order_by('ct.order', 'asc');
//      $this->db->group_by('rs.subject_id');
        $rs = $this->db->get();        
        $aa = $rs->result_array();        
        $result = array();
        $half_yearly_gp = 0;
        $annual_gp_total = 0;
        $subject_optional = 0;
        $i = 0;
        $child = 0;
        $ab =0;
        $remove_drawing = 0;
        if($rs->num_rows() > 0) {
        foreach($aa as $val){
            $data['ct1'] = $val['ct1'];
            $data['ct2'] = $val['ct2'];
            $data['ct3'] = $val['ct3'];
            $data['ct4'] = $val['ct4'];
            $data['ct5'] = $val['ct5'];
            $data['ct6'] = $val['ct6'];
            $data['ct7'] = $val['ct7'];
            $data['ct8'] = $val['ct8'];
            $data['ct9'] = $val['ct9'];
            $data['ct10'] = $val['ct10'];
            $data['creative'] = $val['creative'];
            $data['mcq'] = $val['mcq'];
            $data['practical'] = $val['practical'];
            $data['others'] = $val['others'];
            $data['descriptive1'] = $val['descriptive1'];
            $data['descriptive2'] = $val['descriptive2'];
            $data['descriptive3'] = $val['descriptive3'];
            $data['half_yearly_total'] = $val['half_yearly_total'];
            $data['yearly_total'] = $val['yearly_total'];
            $data['half_yearly_grand_total'] = $val['half_yearly_grand_total'];
            $data['yearly_grand_total'] = $val['yearly_grand_total'];
            if($val['child_id']>0){
                $child_mark = $this->get_child_mark($class_id,$exam_id,$val['child_id'],$val['student_id']);
                $combine_total = $child_mark['half_yearly_grand_total'] + $val['half_yearly_grand_total'];

                $total_marks_main_subject = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
                $total_marks_child_subject = $this->get_exam_full_marks($class_id,$exam_id,$child_mark['subject_id']);

                $final_marks = ($combine_total/($total_marks_main_subject+$total_marks_child_subject))*100;

                $scale_matrix = $this->get_scale_matrix($result_scale_id,$final_marks);

                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
                $ab = $scale_matrix['weight'];
                $child++;                
            }else{
                $data['half_yearly_gp'] = $val['half_yearly_gp'];
                $data['half_yearly_lg'] = $val['half_yearly_lg'];
                $ab = $val['half_yearly_gp'];
            }
            
            $data['child_id'] = $val['child_id'];
            $data['is_parent'] = $val['is_parent'];
            $data['yearly_gp'] = $val['yearly_gp'];
            $data['yearly_lg'] = $val['yearly_lg'];
            $data['final_gp'] = $val['final_gp'];
            $data['final_lg'] = $val['final_lg'];
            $data['position'] = $val['position'];
            $data['subject_name'] = $val['subject_name'];
            $data['subject_id'] = $val['subject_id'];
            $data['full_mark'] = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
            $data['hmark'] = $this->get_class_highest($class_id,$exam_id,$val['subject_id']);

            //Annual examination calculations
            if($exam_id == 3){
                $half_yearly = $this->get_half_yearly_results(2, $class_id, $student_id, $val['subject_id']);
                $cal_avg = ($half_yearly['mid_term'] + $val['yearly_grand_total'])/2;
                $total_test_pass_marks = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
                $scale_cal_avg = ($cal_avg/$total_test_pass_marks)*100;
                $scale_matrix = $this->get_scale_matrix($result_scale_id, $scale_cal_avg);
                $data['half_yearly_mks'] = $half_yearly['mid_term'];
                $data['final_avg_mks'] = $cal_avg;
                
                $half_yearly_class_highest = $this->get_class_highest($class_id, 2, $val['subject_id']);
                $data['annual_class_highest_avg'] = ($half_yearly_class_highest['half_yearly_class_highest'] + $data['hmark']['yearly_class_highest'])/2;
                $half_yearly_gp1 = $val['yearly_gp'];
                
                if($val['child_id'] > 0){
                    $annual_child_mark = $this->get_child_mark($class_id, $exam_id, $val['child_id'], $val['student_id']);
                    $half_yearly_child_mark = $this->get_child_mark($class_id, 2, $val['child_id'], $val['student_id']);
                    $cal_avg_child_mark = ($half_yearly_child_mark['half_yearly_grand_total'] + $annual_child_mark['yearly_grand_total'])/2;
                    $total_avg_child_parent = $cal_avg + $cal_avg_child_mark;
                    
                    $total_annual_marks = ($total_avg_child_parent/($total_marks_main_subject+$total_marks_child_subject))*100;
                    $total_annual_scale_matrix = $this->get_scale_matrix($result_scale_id,$total_annual_marks);
                    $data['annual_gp'] = $total_annual_scale_matrix['weight'];
                    $data['annual_lg'] = $total_annual_scale_matrix['title'];
                    
                }else{
                    $data['annual_gp'] = $scale_matrix['weight'];
                    $data['annual_lg'] = $scale_matrix['title'];
                }
                if($val['is_parent'] <= 0){
                    $annual_gp_total += $data['annual_gp'];
                }
            }
            
            //calculating optional subject grade points
            $half_yearly_optional_gp_revised = '';
            $remove_optional_grade = 0;
            if($aa[0]['subject_group_id'] > 0){
                $subject_group = $this->get_subject_group($val['subject_group_id']);
                if($subject_group['optional_sub_id'] == $val['subject_id'] ){
                    $subject_optional = 1;
                    $data['full_mark_optional'] = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
                    if($val['half_yearly_gp'] > 2){
                        $half_yearly_optional_gp_revised = $val['half_yearly_gp'] - 2;
                    }else{
                        $remove_optional_grade = 1;
                    }
                }else{}
            }else{}
            
            if($val['is_parent'] <= 0){
                $half_yearly_gp1 = $data['half_yearly_gp'];
            
                if(!empty($half_yearly_optional_gp_revised)){
                    $half_yearly_gp = $half_yearly_gp + $half_yearly_optional_gp_revised;                
                }else{
                    if($remove_optional_grade != 1){
                        if($val['subject_id'] != '62'){
                            $half_yearly_gp = $half_yearly_gp + $half_yearly_gp1;
                        }
                    }
                }
            }
            
            $result[] = $data;
            if($half_yearly_gp1 <=0.00 && $subject_optional == 0){
                if($val['subject_id'] != '62'){
                    $i++;
                }
            }   
            if($val['subject_id'] == '62'){$remove_drawing = 1;}
        }

        if($i > 0){  
            $data1['point'] = '0';
        }else{
            if(isset($subject_optional) && $subject_optional == 1){
            $data1['point'] = $half_yearly_gp/(count($aa) - 3);
            }else if($child > 0){
                $data1['point'] = $half_yearly_gp/(count($aa) - $child);
            }else{ 
                $data1['point'] = $half_yearly_gp/(count($aa) - $remove_drawing);
            }
        }
        //Annual Examination Total GP count
        if($exam_id == 3){
            if($child > 0){
                $data1['annual_gp_point'] = $annual_gp_total / (count($aa) - $child);
            }elseif(isset($subject_optional) && $subject_optional == 1){
                $data1['annual_gp_point'] = $annual_gp_total / (count($aa) - 3);
            }else{
                $data1['annual_gp_point'] = $annual_gp_total / count($aa);
            }
        }
        
        $data1['result'] = $result;        
        return $data1;
        } else {
            return false;
        }
    }
	
	
    function get_height_total($class_id,$exam_id)
    {
        $this->db->select('SUM(half_yearly_grand_total) as max_total');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id !=', '62');
        $this->db->group_by('student_id');
        $this->db->order_by('max_total','DESC');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    function get_highest_yearly_total($class_id, $exam_id){
        $this->db->select('SUM(yearly_grand_total) as max_total');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->group_by('student_id');
        $this->db->order_by('max_total','DESC');
        $rs = $this->db->get();
        return $rs->row_array();
    }
	
    function get_child_mark($class_id,$exam_id,$subject_id,$student_id)
    {
        $this->db->select('*');
        $this->db->from('result_sheet');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
	
    public function get_total_exam_marks($class_id, $exam_id, $student_id){
        $this->db->select('SUM(res.half_yearly_grand_total) total_mks_half_yearly, '
                . 'SUM(yearly_grand_total) total_mks_yearly');
        $this->db->from('result_sheet res');
        $this->db->where('res.class_id', $class_id);
        $this->db->where('res.exam_id', $exam_id);
        $this->db->where('res.student_id', $student_id);
        $this->db->where('res.subject_id !=', '62');
        $rs = $this->db->get();
        return $rs->row_array();
    }

    public function get_student_info($class_id, $exam_id){
        $this->db->select('rs.student_id, pd.first_name, pd.last_name, cl.title class_name,'
                . ' ad.class_roll, sec.title section_title, st.student_number,h.title house');
        $this->db->from('result_sheet rs');
        $this->db->join('admission ad', 'ad.student_id = rs.student_id', 'left');
        $this->db->join('personal_details pd', 'pd.student_id = rs.student_id', 'left');
        $this->db->join('student_house sh', 'sh.student_id = rs.student_id', 'left');
        $this->db->join('house h', 'h.id = sh.house_id', 'left');
        $this->db->join('section sec', 'sec.id = ad.section_id', 'left');
        $this->db->join('class cl', 'cl.id = rs.class_id', 'left');
        $this->db->join('student st', 'st.id = rs.student_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        $this->db->where('rs.exam_id', $exam_id);
        $this->db->group_by('pd.first_name');
        $this->db->order_by('ad.class_roll', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_student_ids($class_id, $exam_id, $section_id) {
        if(isset($section_id) && $section_id > 0){
            $query = $this->db->query("SELECT student_id FROM (sms_result_sheet) WHERE `class_id` = '".$class_id."' AND `exam_id` = '".$exam_id."' AND `section_id` = '".$section_id."' GROUP BY student_id ORDER BY position = 0, position");
        }else{
            $query = $this->db->query("SELECT student_id FROM (sms_result_sheet) WHERE `class_id` = '".$class_id."' AND `exam_id` = '".$exam_id."' GROUP BY student_id ORDER BY position = 0, position");
        }
        return $query->result_array();        
    }
    public function get_student_name($student_id) {
        $this->db->select('first_name, last_name');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get('personal_details');
        return $rs->row_array();
    }
    public function get_section($student_id) {
        $this->db->select('sc.title section, ad.class_roll');
        $this->db->from('admission ad');
        $this->db->join('section sc', 'sc.id = ad.section_id', 'left');
        $this->db->where('ad.student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_class_title($class_id){
        $this->db->select('title');
        $this->db->where('id', $class_id);
        $rs = $this->db->get('class');
        return $rs->row_array();
    }
    public function get_house($student_id) {
        $this->db->select('h.title');
        $this->db->from('student_house sh');        
        $this->db->join('house h', 'h.id = sh.house_id', 'left');
        $this->db->where('sh.student_id', $student_id);
        $rs = $this->db->get(); 
        return $rs->row_array();
    }
    public function get_student_number($student_id){
        $this->db->select('student_number');
        $this->db->where('id', $student_id);
        $rs = $this->db->get('student');
        return $rs->row_array();
    }
    public function get_cadidate_ids($class_id, $exam_id, $section_id) {
        $this->db->select('student_id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        if(isset($section_id) && $section_id > 0){
            $this->db->where('section_id', $section_id);
        }
        $this->db->group_by('student_id');
        $this->db->order_by('student_id', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_half_yearly_results($exam_id, $class_id, $student_id, $subject_id){
        $this->db->select('half_yearly_grand_total mid_term');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('student_id', $student_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get('result_sheet');
        return $rs->row_array();
    }
    public function get_test_subjects($class_id, $exam_id, $subject_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id, cl.title class_title, ex.title exam_title, '
                . 'ct.title subject_title, ct.is_optional, '
                . 'GROUP_CONCAT(et.title  ORDER BY et.id) exam_title, '
                . 'GROUP_CONCAT(et.test_type   ORDER BY et.id) exam_type, '
                . 'GROUP_CONCAT(et.field_name  ORDER BY et.id) field_name');
        $this->db->from('config_exam_class_ct ce');
        $this->db->join('class cl', 'cl.id = ce.class_id', 'left');
        $this->db->join('course_title ct', 'ct.id = ce.subject_id', 'left');
        $this->db->join('exam ex', 'ex.id = ce.exam_id', 'left');
        $this->db->join('exam_type et', 'FIND_IN_SET(et.id, ce.marks_id) > 0', 'left');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->where('ce.subject_id', $subject_id);
        $this->db->group_by('ce.id');
        $this->db->order_by('cl.title', 'asc');        
        $rs = $this->db->get();        
        return $rs->row_array();
    }
    public function get_view_exam_subjects($class_id, $exam_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id,GROUP_CONCAT(ce.marks_id SEPARATOR ",") exam_type');
        $this->db->from('config_exam_class_ct ce');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->group_by('ce.class_id');
//        $this->db->order_by('cl.title', 'asc');        
//        $this->db->order_by('LENGTH(ce.marks_id)', 'desc');        
        $rs = $this->db->get();  
        return $rs->row_array();
    }
    
    public function get_all_students($class_id){
        $this->db->select('pd.first_name, pd.student_id');
        $this->db->from('personal_details pd');
        $this->db->join('admission ad', 'ad.student_id = pd.student_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        $this->db->order_by('pd.student_id', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    
    public function get_all_subjects(){
        $this->db->select('id');
        $this->db->order_by('id', 'asc');
        $rs = $this->db->get('subject');
        return $rs->result_array();
    }
    public function get_class_highest($class_id, $exam_id, $subject_id){
        $this->db->select('max(half_yearly_grand_total) half_yearly_class_highest,'
                . ' max(yearly_grand_total) yearly_class_highest');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_exam_full_marks($class_id, $exam_id, $subject_id){        
        $this->db->select('total_marks');
        $this->db->from('config_exam_class_ct');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $rs= $this->db->get();        
        $data = $rs->row_array();
        if(!empty($data)){
            return $data['total_marks'];
        }else{
            return '0';
        }        
    }
	
    function get_scale_matrix($result_scale_id,$total)
    {
        $this->db->select('title,weight');
        $this->db->from('scale_matrix');
        $this->db->where('result_scale_id',$result_scale_id);
        $this->db->where('max_range >', $total);
        $this->db->where('min_range <=', $total);
        $rs = $this->db->get();
        return $rs->row_array();
    }
	
	function get_scale_matrix_list($result_scale_id)
	{
		$this->db->select('max_range,min_range,title,weight,grade_title');
		$this->db->from('scale_matrix');
		$this->db->where('result_scale_id',$result_scale_id);
		$this->db->order_by('weight','desc');
		$rs = $this->db->get();
		return $rs->result_array();
	}
	
    public function get_result_info($student_id, $exam_id, $subject_id){
        $this->db->select('*');
        $this->db->from('result_sheet');
        $this->db->where('student_id', $student_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id', $subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
	
    function edit_result($student_id, $class_id, $subject_id, $exam_id, $data){
        return $this->db->update('result_sheet', $data, 
		array(
			'student_id' => $student_id,
			'class_id' => $class_id,
			'subject_id' => $subject_id,
			'exam_id' => $exam_id,
		));
    }
	
    public function get_gp_lg($result_scale_id, $grand_total){
        $this->db->select('title, weight');
        $this->db->from('scale_matrix');
        $this->db->where('result_scale_id', $result_scale_id);
        $this->db->where('max_range >=', $grand_total);
		$this->db->where('min_range <=', $grand_total);
        $this->db->order_by('weight','desc');
        $rs = $this->db->get();
        $result = $rs->row_array();
        if(!empty($result)){
            return $result;
        }else{
            return array('title'=>'F', 'weight' => '0.00');
        }
    }
    public function check_duplicacy($class_id, $subject_id, $exam_id, $student_id){
        $this->db->select('id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function check_valid_exam($class_id, $subject_id, $exam_id, $section_id){
        $this->db->select('id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('section_id', $section_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }	
    public function get_students_by_form($class_id, $section_id){
        $this->db->select('pd.first_name, pd.last_name, pd.student_id, '
                . 'ad.class_roll, pd.subject_group_id, pd.student_group_id');
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
    public function get_form_students($class_id, $section_id, $exam_id, $subject_id) {
        $this->db->select('rs.student_id, pd.first_name, pd.last_name, ad.class_roll, '
                . 'pd.subject_group_id, pd.student_group_id');
        $this->db->from('result_sheet rs');
        $this->db->join('personal_details pd', 'pd.student_id = rs.student_id', 'left');
        $this->db->join('admission ad', 'ad.student_id = rs.student_id', 'left');
        $this->db->where('rs.class_id', $class_id);
        $this->db->where('rs.exam_id', $exam_id);
        $this->db->where('rs.subject_id', $subject_id);        
        if($section_id > 0){
            $this->db->where('rs.section_id', $section_id);
        }
        $this->db->order_by('ad.class_roll', 'asc');
        $rs = $this->db->get();       
        return $rs->result_array();
    }
    public function get_all_results() {
        $this->db->select('rs.*, pd.first_name, pd.last_name');
        $this->db->from('result_sheet rs');
        $this->db->join('personal_details pd', 'pd.student_id = rs.student_id', 'left');
        $this->db->group_by('student_id');
        $rs = $this->db->get();
        return $rs->result_array();
    }
	
    public function get_form_elements($class_id, $subject_id){
//        $this->db->select();
    }
	
    public function get_class_result($class_id, $subject_id, $exam_id, $section_id){
        $this->db->select('rs.*');
        $this->db->from('result_sheet rs');
        $this->db->join('admission ad', 'ad.student_id = rs.student_id');
        $this->db->join('section sc', 'sc.id = ad.section_id');
        $this->db->where('sc.id', $section_id);
        $this->db->where('rs.class_id', $class_id);
        $this->db->where('rs.subject_id', $subject_id);
        $this->db->where('rs.exam_id', $exam_id);
        $this->db->order_by('rs.student_id', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
    }
	
    public function get_result($class_id, $subject_id, $exam_id, $student_id)
	{
        $this->db->select('rs.*');
        $this->db->from('result_sheet rs');
        $this->db->where('rs.student_id', $student_id);
        $this->db->where('rs.class_id', $class_id);
        $this->db->where('rs.subject_id', $subject_id);
        $this->db->where('rs.exam_id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
	
    public function get_result_entry_details($class_id, $section_id, $subject_id) {
        $this->db->select('title');
        $this->db->where('id', $class_id);
        $cl = $this->db->get('class');
        $class = $cl->row_array();
        if($section_id > 0){
            $this->db->select('title');
            $this->db->where('id', $section_id);
            $se = $this->db->get('section');
            $section = $se->row_array();
        }
        $this->db->select('title');
        $this->db->where('id', $subject_id);
        $sb = $this->db->get('course_title');
        $subject = $sb->row_array();
        if($section_id > 0){
            return $entry_details = array('class_title' => $class['title'], 'section_title' => $section['title'], 'subject_title' => $subject['title']);
        }else{
            return $entry_details = array('class_title' => $class['title'], 'section_title' => '', 'subject_title' => $subject['title']);
        }
    }
	
    public function get_assigned_couses($class_id) 
	{
        $this->db->select('ct.id, ct.title');
        $this->db->from('assigned_courses ac');
        $this->db->join('course_title ct', 'ct.id = ac.course_title_id', 'left');
        $this->db->where('ac.class_id', $class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_student_no($class_id) {
        $this->db->select('count(id) total_Students');
        $this->db->from('student_v');
        $this->db->where('class_id', $class_id);
        $this->db->where('status', 'Active');        
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_working_days($class_id, $start_date, $end_date) {
        $this->db->select('DISTINCT(sa.date)');
        $this->db->from('student_attendance sa');
        $this->db->join('admission ad', 'ad.student_id = sa.student_id', 'left');
        $this->db->where('ad.class_id', $class_id);
        $this->db->where('sa.date >=', $start_date);
        $this->db->where('sa.date <=', $end_date);        
        $this->db->group_by('sa.date');
        $rs = $this->db->get();
        return count($rs->result_array());
    }
    public function get_total_present($student_id, $start_date, $end_date) {
        $this->db->select('count(DISTINCT(date)) total_presence');
        $this->db->from('student_attendance');
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('student_id', $student_id);
        $this->db->where('attendance_status', 'Present');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function set_publish_class($class_id, $exam_id) {
        $this->db->set('is_result_publish', '1');
        $this->db->where('id', $class_id);
        $this->db->update('class');
        
        $this->db->set('is_result_publish', '1');
        $this->db->where('id', $exam_id);
        $this->db->update('exam');
        return TRUE;
    }
    public function get_result_classes() {
        $this->db->select('*');
        $this->db->from('class');
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function get_subject_group($group_id) {
        $this->db->select('id, compulsory_sub_id, optional_sub_id');
        $this->db->from('subject_grouping');
        $this->db->where('id', $group_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_valid_exam($class_id, $section_id, $exam_id, $subject_id) {
        $this->db->select('rs.id');
        $this->db->from('result_sheet rs');
        $this->db->join('admission ad', 'ad.class_id = rs.class_id', 'left');
        $this->db->where('ad.section_id', $section_id);
        $this->db->where('rs.class_id', $class_id);
        $this->db->where('rs.subject_id', $subject_id);
        $this->db->where('rs.exam_id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function check_result($class_id, $exam_id) {
        $this->db->select('id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $rs = $this->db->get(); 
        return $rs->row_array();
    }
    
    function get_exam_type_details($id)
    {
        $this->db->select('*');
        $this->db->from('exam_type');
        $this->db->where('id', $id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    function create_position($position, $student_id_update) {
         $this->db->set('position', $position);
         $this->db->where('student_id', $student_id_update);
         $this->db->update('result_sheet');
    }
    function get_range($class_id) {
        $this->db->select('start_date, end_date');
        $this->db->where('id', $class_id);
        $rs = $this->db->get('class');
        return $rs->row_array();
    }
    public function get_student_pen_pic($student_id, $exam_id) {
        $this->db->select('sp.pen_picture_temaplte_id, sp.discipline, sp.cleanliness, sp.co_curricular_activities');
        $this->db->from('student_pen_picture_details sp');
        $this->db->where('sp.student_id', $student_id);
        $this->db->where('sp.exam_id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
	public function tabulation_view_exam_subjects($class_id, $exam_id, $subject_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id,GROUP_CONCAT(ce.marks_id SEPARATOR ",") exam_type');
        $this->db->from('config_exam_class_ct ce');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->where('ce.subject_id', $subject_id);
        $this->db->group_by('ce.class_id');
        $rs = $this->db->get();  
        return $rs->row_array();
    }
    public function get_exam_name($exam_id){
        $this->db->select('title');
        $this->db->where('id', $exam_id);
        $rs = $this->db->get('exam');
        return $rs->row_array();
    }
    public function get_optional_subject($student_id) {
        $this->db->select('sg.optional_sub_id');
        $this->db->from('personal_details pd');
        $this->db->join('subject_grouping sg', 'sg.id = pd.subject_group_id', 'left');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_student_per_section($class_id, $section_id) {
        $this->db->select('st.id');
        $this->db->from('student st');
        $this->db->join('admission ad', 'ad.student_id = st.id', 'left');
        $this->db->where('ad.class_id', $class_id);
        $this->db->where('ad.section_id', $section_id);
        $rs = $this->db->get();
        return $rs->num_rows();
    }
    public function get_top_student($class_id, $exam_id, $section_id){
        $this->db->select('SUM(half_yearly_grand_total) as half_yearly');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id !=', '62');
        $this->db->where('position', '1');
        $r = $this->db->get(); 
        return $r->row_array();
    }
}
