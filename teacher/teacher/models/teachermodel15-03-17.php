<?php

class Teachermodel extends Frontend_Model {
    public function __construct() {
        parent::__construct();
    }
    
	public function get_table_name() {
        return 'teacher';
    }

    public function get_columns() {
        return array('id', 'username');
    }
	
	
/* 	public function get_general_notice($data)
	{
		$class_id=$data['class_id'];
		$section_id=$data['section_id'];
		$house_id=$data['house_id'];
		$facility_id=$data['facility_id'];
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('student_number <',0);
		$this->db->where('status','ACTIVE');
		$this->db->where('version_id',$data['version_id']);
		$this->db->or_where("(house_id ='$house_id' AND house_id >'0')");
		$this->db->or_where("(facility_id ='$facility_id' AND facility_id >'0')");
		$this->db->or_where("(class_id ='$class_id' AND section_id ='')");
		$this->db->or_where("(class_id ='$class_id' AND section_id ='$section_id')");
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	} */	
	
	public function get_general_notice($designation_id)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('status','ACTIVE');
		$this->db->where('designation_id',$designation_id);
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_personal_notice($student_number)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		$this->db->where('student_number',$student_number);
		$this->db->where('status','ACTIVE');
		$this->db->order_by('created_at','desc');
		$this->db->limit(10);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_all_notice($class_id)
	{
		$this->db->select('*');
		$this->db->from('notice_board');
		if($class_id){
		$this->db->where('class_id',$class_id);
		}else{
		$this->db->where('class_id',0);
		}
		$this->db->where('status','ACTIVE');
		$this->db->order_by('created_at','desc');
		$this->db->limit(20);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	
	public function get_book_list($class_id)
	{
		$this->db->select('*');
		$this->db->from('book');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
        
	public function get_class_title($class_id)
	{
		$this->db->select('title');
		$this->db->from('class');
		$this->db->where('id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
        
	function get_photo($user_id){
		$this->db->select('photo')
				->from('teacher')
				->where('teacher.id',$user_id);
		return $this->get_one();
	}
	
	
	/* public function get_class_routine($class_id,$section_id)
	{
		$this->db->select('cr.id,class_day_id,class_time_id,cst.title subject,teacher.name teacher_name');
		$this->db->from('class_routine cr');
		$this->db->join('course_title cst','cst.id=cr.subject_id','left');
		$this->db->join('teacher','teacher.id=cr.teacher_id','left');
		$this->db->where('cr.class_id',$class_id);
		$this->db->where('cr.section_id',$section_id);
		$this->db->where('cr.status','ACTIVE');
		$this->db->order_by('cr.class_day_id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array();
	} */
	
	public function get_class_routine($teacher_id)
	{
		$this->db->select('cr.id,class_day_id,class_time_id,cst.title subject,teacher.name teacher_name,ct.title as time,c.title as class, s.title as section');
		$this->db->from('class_routine cr');
		$this->db->join('course_title cst','cst.id=cr.subject_id','left');
		$this->db->join('teacher','teacher.id=cr.teacher_id','left');
		$this->db->join('class_time ct','ct.id=cr.class_time_id','left');
		$this->db->join('class c','c.id=cr.class_id','left');
		$this->db->join('section s','s.id=cr.section_id','left');
		$this->db->where('cr.teacher_id',$teacher_id);
		$this->db->where('cr.status','ACTIVE');
		$this->db->order_by('cr.class_day_id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array();
	}
	
	public function get_class_day()
	{
		$this->db->select('*');
		$this->db->from('class_day');
		$this->db->order_by('id','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function get_class_time($class_id)
	{
		$this->db->select('*');
		$this->db->from('class_time');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$this->db->order_by('serial','asc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	
	function update_password($st_id,$passwd)
	{
		$data['passwd'] = $passwd;
		$this->db->update('student',$data,array('id'=>$st_id));
	}
	
	public function edit_teacher($id,$data)
	{
		$this->db->update('teacher',$data,array('id'=>$id));
		return 1;
	}
	
	public function get_notebook($data)
	{
		$class_id=$data['class_id']; 
		$section_id=$data['section_id'];
		$this->db->select('nb.id,nb.title,description,file_name,ct.title subject');
		$this->db->from('note_book nb');
		$this->db->join('course_title ct','ct.id=nb.subject_id');		
		$this->db->where('nb.status','ACTIVE');
		$this->db->where("(nb.class_id ='$class_id' AND nb.section_id ='')");
		$this->db->or_where("(nb.class_id ='$class_id' AND nb.section_id ='$section_id')");
		$this->db->order_by('nb.created_at','desc');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
	
	public function teacher_details($id)
 	{
		$this->db->select('t.name teacher_name,photo,dob,gender,address,designation_id,mobile_no,email,d.title as designation,b.title as blood_group,ct.title as subject, r.title as religion');		
 	 	$this->db->from('teacher t');
 	 	$this->db->join('designation d', 'd.id = t.designation_id', 'left');	
		$this->db->join('blood_group b','b.id = t.blood_group_id','left');
		$this->db->join('course_title ct','ct.id = t.relevant_subject_id','left');
		$this->db->join('religion r','r.id = t.religion_id','left');
		$this->db->where('t.id',$id);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
 	}
	
	public function get_record($id)
 	{
		$this->db->select('t.*,t.name as teacher_name');		
		//$this->db->select('t.name,dob,gender,address,mobile_no,email,d.title as designation,b.title as blood_group,s.title as subject, r.title as religion');		
 	 	$this->db->from('teacher t');
 	 	$this->db->join('designation d', 'd.id = t.designation_id', 'left');	
		$this->db->join('blood_group b','b.id = t.blood_group_id','left');
		$this->db->join('subject s','s.id = t.relevant_subject_id','left');
		$this->db->join('religion r','r.id = t.religion_id','left');
		$this->db->where('t.id',$id);
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
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
	public function get_section($class_id)
	{
		$this->db->select('id,title');
 		$this->db->from('section');
 		$this->db->where('class_id',$class_id);
 		$this->db->where('status','ACTIVE');
		$this->db->order_by('title','asc');
 			$rs=$this->db->get(); 	    
		return $rs->result_array();  
	}
	public function get_designation()
	{	
		$this->db->select('id,title');
        $this->db->from('designation');
        $this->db->where('type','Admin');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	
	public function get_blood_group()
	{	
		$this->db->select('id,title');
        $this->db->from('blood_group');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	
	public function get_religion()
	{	
		$this->db->select('id,title');
        $this->db->from('religion');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	public function get_subject()
	{	
		$this->db->select('id,title');
        $this->db->from('subject');
        $this->db->order_by('title', 'asc');
        return $this->get_assoc();

	}
	public function get_exam_list($class_id)
	{
		$this->db->select('id,title');
		$this->db->from('exam');
		$this->db->where('class_id',$class_id);
		$this->db->where('status','ACTIVE');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 
	}
        public function get_exams(){
            $this->db->select('id,title');
            $this->db->from('exam');
            $this->db->where('status','ACTIVE');
            $this->db->order_by('title','asc');
            $rs=$this->db->get(); 	    
            return $rs->result_array();  
	}
//    function get_height_total($class_id,$exam_id)
//    {
//        $this->db->select('SUM(half_yearly_grand_total) as max_total');
//        $this->db->from('result_sheet');
//        $this->db->where('class_id', $class_id);
//        $this->db->where('exam_id', $exam_id);
//        $this->db->group_by('student_id');
//        $this->db->order_by('max_total','DESC');
//        $rs = $this->db->get();
//        return $rs->row_array();
//    }
    public function get_test_subjects($class_id, $exam_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id, cl.title class_title, ex.title exam_title, sb.title subject_title, '
                . 'GROUP_CONCAT(et.title  ORDER BY et.id) exam_title, '
                . 'GROUP_CONCAT(et.test_type   ORDER BY et.id) exam_type, '
                . 'GROUP_CONCAT(et.field_name  ORDER BY et.id) field_name');
        $this->db->from('config_exam_class_ct ce');
        $this->db->join('class cl', 'cl.id = ce.class_id', 'left');
        $this->db->join('subject sb', 'sb.id = ce.subject_id', 'left');
        $this->db->join('exam ex', 'ex.id = ce.exam_id', 'left');
        $this->db->join('exam_type et', 'FIND_IN_SET(et.id, ce.marks_id) > 0', 'inner');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->group_by('ce.id');
        $this->db->order_by('cl.title', 'asc');        
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_half_yearly_results($exam_id, $class_id){
        $this->db->select('half_yearly_grand_total mid_term');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $rs = $this->db->get('result_sheet');
        return $rs->result_array();
    }
    public function get_result_scale($class_id){
        $this->db->select('result_scale_id');
        $this->db->from('class');
        $this->db->where('id', $class_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_student_id($class_id, $exam_id, $student_id) {
        $this->db->select('student_id');
        $this->db->from('result_sheet');
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('student_id', $student_id);
        $this->db->group_by('student_id');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_student_name($student_id) {
        $this->db->select('first_name, last_name');
        $this->db->where('student_id', $student_id);
        $rs = $this->db->get('personal_details');
        return $rs->row_array();
    }
    public function get_student_section($student_id) {
        $this->db->select('sc.title section, ad.class_roll');
        $this->db->from('admission ad');
        $this->db->join('section sc', 'sc.id = ad.section_id', 'left');
        $this->db->where('ad.student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_student_class_title($class_id){
        $this->db->select('title');
        $this->db->where('id', $class_id);
        $rs = $this->db->get('class');
        return $rs->row_array();
    }
    public function get_house($student_id) {
        $this->db->select('h.title');
        $this->db->from('student_house sh');        
        $this->db->join('house h', 'h.id = sh.house_id', 'left');
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_student_number($student_id){
        $this->db->select('student_number');
        $this->db->where('id', $student_id);
        $rs = $this->db->get('student');
        return $rs->row_array();
    }
    function get_scale_matrix_list($result_scale_id)
    {
        $this->db->select('max_range,min_range,title,weight');
        $this->db->from('scale_matrix');
        $this->db->where('result_scale_id',$result_scale_id);
        $this->db->order_by('weight','desc');
        $rs = $this->db->get();
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
        $rs = $this->db->get();        
        $aa = $rs->result_array();        
        $result = array();
        $half_yearly_gp = 0;
        $annual_gp_total = 0;
        $i = 0;
        $child = 0;
        $ab =0;
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
            $data['full_mark'] = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
            $data['hmark'] = $this->get_class_highest($class_id,$exam_id,$val['subject_id']);

            //Annual examination calculations
            if($exam_id == 3){
                $half_yearly = $this->get_half_yearly_results(2, $class_id, $student_id, $val['subject_id']);
                $cal_avg = number_format(($half_yearly['mid_term'] + $val['yearly_grand_total'])/2, 2, '.', '');
                $total_test_pass_marks = $this->get_exam_full_marks($class_id,$exam_id,$val['subject_id']);
                $scale_cal_avg = ($cal_avg/$total_test_pass_marks)*100;
                $scale_matrix = $this->get_scale_matrix($result_scale_id, $scale_cal_avg);
                $data['half_yearly_mks'] = $half_yearly['mid_term'];
                $data['final_avg_mks'] = $cal_avg;
                
                $half_yearly_class_highest = $this->get_class_highest($class_id, 2, $val['subject_id']);
//                echo '<pre>';
//                print_r($data['hmark']);
//                exit;
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
                //calculating optional subject grade points for Annual Exam
                $yearly_optional_gp_revised = 0;
                if($aa[0]['subject_group_id'] > 0){
                    $subject_group = $this->get_subject_group($val['subject_group_id']);
                    if($subject_group['optional_sub_id'] == $val['subject_id'] ){
                        $subject_optional = 1;                    
                        if($data['annual_gp'] > 2){
                            $yearly_optional_gp_revised = $data['annual_gp'] - 2;
                        }else{
                            $yearly_optional_gp_revised = 0;
                        }
                    }else{}
                }else{}
            
                if($val['is_parent'] <= 0){
                    if($yearly_optional_gp_revised > 0){
                        $annual_gp_total += $yearly_optional_gp_revised;                
                    }else{
                        $annual_gp_total += $data['annual_gp'];
                    }
                }
            }
            
            //calculating optional subject grade points for Half yearly exam
            $half_yearly_optional_gp_revised = 0;
            if($aa[0]['subject_group_id'] > 0){
                $subject_group = $this->get_subject_group($val['subject_group_id']);
                if($subject_group['optional_sub_id'] == $val['subject_id'] ){
                    $subject_optional = 1;                    
                    if($val['half_yearly_gp'] > 2){
                        $half_yearly_optional_gp_revised = $val['half_yearly_gp'] - 2;
                    }else{
                        $half_yearly_optional_gp_revised = 0;
                    }
                }else{}
            }else{}
            
            if($val['is_parent'] <= 0){
                $half_yearly_gp1 = $data['half_yearly_gp'];
            
                if($half_yearly_optional_gp_revised > 0){
                    $half_yearly_gp = $half_yearly_gp + $half_yearly_optional_gp_revised;                
                }else{ 
                    $half_yearly_gp = $half_yearly_gp + $half_yearly_gp1;                
                }
            }
            $result[] = $data;
            if($half_yearly_gp1 <=0.00 ){
                $i++;
            }   
        }
        
        if($i > 0){
            $data1['point'] = '0';
        }else{
            if(isset($subject_optional) && $subject_optional == 1){    
            $data1['point'] = $half_yearly_gp/(count($aa) - 3); 
            }else if($child > 0){
                $data1['point'] = $half_yearly_gp/(count($aa) - $child);
            }else{
                $data1['point'] = $half_yearly_gp/count($aa);
            }
        }
        //Annual Examination Total GP count
        if($exam_id == 3){
            if(isset($subject_optional) && $subject_optional == 1){
                $data1['annual_gp_point'] = $annual_gp_total / (count($aa) - 3);                
            }elseif($child > 0){
                $data1['annual_gp_point'] = $annual_gp_total / (count($aa) - $child);
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
    public function get_view_exam_subjects($class_id, $exam_id){
        $this->db->_protect_identifiers=false; 
        $this->db->select('ce.id,GROUP_CONCAT(ce.marks_id SEPARATOR ",") exam_type');
        $this->db->from('config_exam_class_ct ce');
        $this->db->where('ce.class_id', $class_id);
        $this->db->where('ce.exam_id', $exam_id);
        $this->db->group_by('ce.class_id');
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
    public function get_total_exam_marks($class_id, $exam_id, $student_id){
        $this->db->select('SUM(res.half_yearly_grand_total) total_mks_half_yearly, '
                . 'SUM(yearly_grand_total) total_mks_yearly');
        $this->db->from('result_sheet res');
        $this->db->where('res.class_id', $class_id);
        $this->db->where('res.exam_id', $exam_id);
        $this->db->where('res.student_id', $student_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function get_scale_matrices($result_scale_id,$point){
        $this->db->select('title, weight');
        $this->db->from('scale_matrix');
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
    function get_scale_matrix($result_scale_id,$total){
        $this->db->select('title,weight');
        $this->db->from('scale_matrix');
        $this->db->where('result_scale_id',$result_scale_id);
        $this->db->where('max_range >', $total);
        $this->db->where('min_range <=', $total);
        $rs = $this->db->get();
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
        $this->db->order_by('ad.class_roll', 'asc');
        $rs = $this->db->get();
        return $rs->result_array();
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
    function get_child_mark($class_id,$exam_id,$subject_id,$student_id){
        $this->db->select('*');
        $this->db->from('result_sheet');
        $this->db->where('student_id', $student_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('subject_id',$subject_id);
        $rs = $this->db->get();
        return $rs->row_array();
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
    public function get_sections($class_id) {
        $this->db->select('id, title');
        $this->db->from('section');
        $this->db->where('class_id', $class_id);
        $rs = $this->db->get();
        return $rs->result_array();
    }
    public function current_exam($exam_id) {
        $this->db->select('title');
        $this->db->from('exam');
        $this->db->where('id', $exam_id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function check_publish($class_id, $exam_id) {
        $this->db->select('is_result_publish');
        $this->db->from('class');
        $this->db->where('id', $class_id);
        $this->db->where('is_result_publish', '1');
        $cl = $this->db->get();
        $class_publish = $cl->num_rows();
        
        $this->db->select('is_result_publish');
        $this->db->from('exam');
        $this->db->where('id', $exam_id);
        $this->db->where('is_result_publish', '1');
        $cl = $this->db->get();
        $exam_publish = $cl->num_rows();
        if($class_publish > 0 && $exam_publish >0){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
}

?>