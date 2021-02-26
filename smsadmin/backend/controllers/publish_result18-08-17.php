<?php

/* 
 * Created on 18-04-2016
 * Developed by: Arena Development Team
 * 
 */

class Publish_result extends BACKEND_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('publish_resultmodel');
        $this->load->model('config_exam_class_ctmodel');
    }
    function index(){
        $this->init_grid();
    }
    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Configuation List');
        $grid_columns = array('class_title' => 'Class Name', 'subject_title' => 'Subject', 'examination' => 'Examination', 'exam_title' => 'Exam Types');
        $this->grid_board->set_column($grid_columns);
        $as = $this->grid_board->render('config_exam_class_ctmodel');
    }
            
    function create(){
        $this->load->form('config_exam_classform');
        $form_checkboxes = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('form_checkboxes', $form_checkboxes);
    }
    function save(){
        $this->load->form('config_exam_classform');
        $this->tpl->set_view('create');
        $form_checkboxes = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('form_checkboxes', $form_checkboxes);
        $this->process_form($this->config_exam_classform);
    }
    protected function process_form($form){
        if($form->validate()){
            $data['class_id'] = $this->input->post('config_exam_class_class_id');
            $data['exam_id'] = $this->input->post('config_exam_class_exam_id');
            $data['subject_id'] = $this->input->post('config_exam_class_subject_id');
            $data['total_marks'] = $this->input->post('config_exam_class_total_marks');
//            $data['pass_marks'] = $this->input->post('config_exam_class_pass_marks');
            $exam_types = $this->input->post('exam_type');
            if(!empty($exam_types)){
                $data['marks_id'] = implode(',', $exam_types);
            }
            $duplicate = $this->publish_resultmodel->check_config_duplicate($data['class_id'], $data['subject_id'], $data['exam_id']);
            if(empty($duplicate)){
                $config_exam_id = $this->publish_resultmodel->add($data);
                $this->session->set_flashdata('success', 'The Settings saved successfully');
                redirect('publish_result');
            }else{
                $this->session->set_flashdata('error', 'The Settings you are trying to create is already exist!');
//                redirect('publish_result/create');
                redirect(base_url().'index.php/publish_result/create?class='.$data['class_id'].'&exam='.$data['exam_id'].'&subject='.$data['subject_id'].'&total_marks='.$data['total_marks']);
            }
        }
    }
    
    function edit($id = ''){
        if(empty($id))
            redirect ('publish_result');
        $info = $this->config_exam_class_ctmodel->find($id);
        $this->load->form('config_exam_classform', NULL, $info);
        $this->tpl->assign('config_data', $info);
        $form_checkboxes = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('form_checkboxes', $form_checkboxes);
//        $this->edit_data($this->config_exam_classform);
    }
    function update(){
        $this->load->form('config_exam_classform');
        $this->tpl->set_view('create');
        $form_checkboxes = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('form_checkboxes', $form_checkboxes);
        $this->edit_data($this->config_exam_classform);
    }
    function edit_data($form){
        $config_id = $this->input->post('config_id');
         if($form->validate()){
            $data['class_id'] = $this->input->post('config_exam_class_class_id');
            $data['exam_id'] = $this->input->post('config_exam_class_exam_id');
            $data['subject_id'] = $this->input->post('config_exam_class_subject_id');
            $data['total_marks'] = $this->input->post('config_exam_class_total_marks');
//            $data['pass_marks'] = $this->input->post('config_exam_class_pass_marks');
            
            $exam_types = $this->input->post('exam_type');
            $data['marks_id'] = implode(',', $exam_types);
            $edit_config_exam = $this->publish_resultmodel->edit($config_id, $data);
            if($edit_config_exam){
                $this->session->set_flashdata('success',"The Settings has been updated successfully");
                redirect('publish_result');
            }
        }else{
            $info = $this->config_exam_class_ctmodel->find($config_id);
            $this->tpl->assign('config_data', $info);
        }
    }    
    function view($id){
        $info = $this->config_exam_class_ctmodel->get_config($id);
        if(empty($info)){
            show_404();
        }
        $this->tpl->assign($info[0]);
    }    
    function del($id){
        $this->config_exam_class_ctmodel->delete($id);
        $this->session->set_flashdata('success', 'The Configuration has been deleted Successfully');
        redirect('publish_result');
    }
    
    function test_entry(){
        $this->load->form('test_entry_form');
        $this->load->model('studentmodel');
        $class_id = $this->input->get('class');
        $exam_id = $this->input->get('exam');
        $subject_id = $this->input->get('subject');        
        if(!empty($class_id)){
            $students = $this->publish_resultmodel->get_all_students($class_id);
            $this->tpl->assign('students', $students);
        }
        $exam_types = $this->publish_resultmodel->get_test_types($class_id, $exam_id, $subject_id);
        if(!empty($exam_types)){
            $exam_titles = explode(',', $exam_types['exam_title']);
            $field_names = explode(',', $exam_types['field_name']);
            $form_fields = array_combine($field_names, $exam_titles);        
            $this->tpl->assign('form_fields', $form_fields);
        }
    }
    function create_result(){
        $data['class_id'] = $this->input->post('test_entry_form_class_id');
        $data['subject_id'] = $this->input->post('test_entry_form_subject_id');
        $data['exam_id'] = $this->input->post('test_entry_form_exam_id');
        $data['student_id'] = $this->input->post('student_id');
        $data['ct1'] =  $this->input->post('ct1');
        $data['ct2'] =  $this->input->post('ct2');
        $data['ct3'] =  $this->input->post('ct3');
        $data['ct4'] =  $this->input->post('ct4');
        $data['ct5'] =  $this->input->post('ct5');
        $data['ct6'] =  $this->input->post('ct6');
        $data['ct7'] =  $this->input->post('ct7');
        $data['ct8'] =  $this->input->post('ct8');
        $data['ct9'] =  $this->input->post('ct9');
        $data['ct10'] =  $this->input->post('ct10');
        $data['creative'] = $this->input->post('creative');
        $data['mcq'] = $this->input->post('mcq');
        $data['practical'] = $this->input->post('practical');
        $data['others'] =  $this->input->post('others');
        $data['descriptive1'] =  $this->input->post('descriptive1');
        $data['descriptive2'] =  $this->input->post('descriptive2');
        $data['descriptive3'] =  $this->input->post('descriptive3');
//        print_r($this->input->post()); exit();
        
        if($data['class_id'] != '' || $data['subject_id'] != '' || $data['exam_id'] != '' || $data['student_id'] != '---Select Student---'){
            $formula_hard = $this->publish_resultmodel->get_formula($data['class_id'], $data['subject_id']);
            $equation = $this->evalmath($formula_hard['formula']);

            $ct1 = $data['ct1']; 
            $ct2 = $data['ct2'];
            $ct3 = $data['ct3'];
            $ct4 = $data['ct4'];
            $ct5 = $data['ct5'];
            $ct6 = $data['ct6'];
            $ct7 = $data['ct7'];
            $ct8 = $data['ct8'];
            $ct9 = $data['ct9'];
            $ct10 = $data['ct10'];
            $creative = $data['creative'];
            $mcq = $data['mcq'];
            $practical = $data['practical'];
            $others = $data['others'];
            $descriptive1 = $data['descriptive1'];
            $descriptive2 = $data['descriptive2'];
            $descriptive3 = $data['descriptive3'];

            $data['half_yearly_total'] = $creative + $mcq + $practical + $others + $descriptive1 + $descriptive2 + $descriptive3;

            if($equation != ''){
                $grand_total = @eval("return " . $equation . ";" );
            }
    //        $examination = $this->publish_resultmodel->get_exam_name($data['exam_id']);
            $result_scale = $this->publish_resultmodel->get_result_scale($data['class_id']);       
            $total_exam_marks = $this->publish_resultmodel->get_exam_full_marks($data['class_id'], $data['exam_id'], $data['subject_id']);

            $scale_grand_total = ($grand_total/$total_exam_marks)*100;

            $scale_matrix = $this->publish_resultmodel->get_gp_lg($result_scale['result_scale_id'], $scale_grand_total);

            if($data['exam_id'] == '2'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            if($data['exam_id'] == '3'){
                $data['yearly_grand_total'] = $grand_total;
                $data['yearly_gp'] = $scale_matrix['weight'];
                $data['yearly_lg'] = $scale_matrix['title'];
            }
            $duplicate = $this->publish_resultmodel->check_duplicacy($data['class_id'], $data['subject_id'], $data['exam_id'], $data['student_id']);
            if(empty($duplicate)){
                $result_sheet_id = $this->publish_resultmodel->generate_result($data);
                $this->session->set_flashdata('success', 'The Result Sheet Generated successfully');
                redirect('publish_result/test_entry');   
            }
        }else {
            $this->session->set_flashdata('error', 'Error! Please fill up all the required fields.');
            
//            redirect("publish_result/test_entry");
            redirect(base_url().'index.php/publish_result/test_entry?class='.$data['class_id'].'&exam='.$data['exam_id'].'&subject='.$data['subject_id']);
        }
    }
    function evalmath($equation){
        $equation = preg_replace("/[^a-z0-9+\-.*\/()%]/","",$equation);
        $equation = preg_replace("/([a-z])+/i", "\$$0", $equation); 
        $equation = preg_replace("/([+-])([0-9]{1})(%)/","*(1\$1.0\$2)",$equation);
        $equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation);
        $equation = preg_replace("/([0-9]{1})(%)/",".0\$1",$equation);
        $equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation);	        
        return $equation;                
    }    
	
    function make_result() {
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);
    }
	
    function show_results(){
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);	  // get school info
        $this->tpl->assign('school_info',$school_info);
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);      

        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $exam_id = $this->input->get('exam_id');
        
        $exam_name = $this->publish_resultmodel->get_exam_name($exam_id);
        $this->tpl->assign('exam_name', $exam_name['title']);

        $max_total = $this->publish_resultmodel->get_height_total($class_id, $exam_id);
        $this->tpl->assign('max_total', $max_total['max_total']);

        $configures = $this->publish_resultmodel->get_view_exam_subjects($class_id, $exam_id);
        $aa = str_replace(' ','', $configures['exam_type']);
        $ex_final = substr($aa, 0, -3);
        $exam_type = array_unique(explode(',', $ex_final));
        $subjective = 0;
        $ct = 0;
        foreach($exam_type as $key=>$val)
        {
            $row = $this->publish_resultmodel->get_exam_type_details($val);
            $exam_title[] = $row['title'];
            $fields[] = $row['field_name'];
            if($val>10)
            {
            $subjective++;
            }else if($val>0 AND $val<11){
                $ct++;
            }
        }
        $this->tpl->assign('subjective', $subjective);       
        $this->tpl->assign('ct', $ct);
        
        if(!empty($configures)){
            $subjects = $exam_title;
            $subjects = array_combine($fields, $fields);
            $exam_types = explode(',', $configures['exam_type']);
            $this->tpl->assign('subjects', $subjects);
            $this->tpl->assign('exam_types', $exam_type);                   
        }

//        $total_student_no = $this->publish_resultmodel->get_student_no($class_id);
        $total_student_no = $this->publish_resultmodel->get_student_per_section($class_id, $section_id);
        $this->tpl->assign('total_students', $total_student_no);
        
        $topper = $this->publish_resultmodel->get_top_student($class_id, $exam_id, $section_id);
        $top_score = $topper['half_yearly'];
        $this->tpl->assign('topper_score', $top_score);
        
        if(!empty($class_id)){
            $result_scale = $this->publish_resultmodel->get_result_scale($class_id);            
            $students_details = $this->publish_resultmodel->get_student_ids($class_id, $exam_id, $section_id);
            
            $scale_matrix_list = $this->publish_resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
            $this->tpl->assign('scale_matrix_list', $scale_matrix_list);
            
            //Calculating total working days
            $range = $this->publish_resultmodel->get_range($class_id);
            if(!empty($range)){
                $working_days = $this->publish_resultmodel->get_working_days($class_id, $range['start_date'], $range['end_date']);
                $this->tpl->assign('working_days', $working_days);
            }
			
            $asd = array();
            foreach ($students_details as $students_detail){
                $student_name = $this->publish_resultmodel->get_student_name($students_detail['student_id']);
                $section = $this->publish_resultmodel->get_section($students_detail['student_id']);
                $class_title = $this->publish_resultmodel->get_class_title($class_id);
                $student_house = $this->publish_resultmodel->get_house($students_detail['student_id']);
                $student_number = $this->publish_resultmodel->get_student_number($students_detail['student_id']);
                
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['section_title'] = $section['section'];                
                $data['class_roll'] = $section['class_roll'];                
                $data['student_id'] = $students_detail['student_id'];
                $data['class_name'] = $class_title['title'];                
                if(!empty($student_house)){
                $data['house'] = $student_house['title'];
                }
                $data['class_id'] = $class_id;
                $data['exam_id'] = $exam_id;
                $data['student_number'] = $student_number['student_number'];
                
                $data['activities'] = $this->publish_resultmodel->get_student_pen_pic($students_detail['student_id'], $exam_id);
                if(!empty($range)){
                $presents = $this->publish_resultmodel->get_total_present($students_detail['student_id'], $range['start_date'], $range['end_date']);
                $data['total_presence'] = $presents['total_presence'];
                }
                
                $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
                
                $optional_subject = $this->publish_resultmodel->get_optional_subject($students_detail['student_id']);
                if(!empty($optional_subject)){
                    $data['optional_sub_id'] = $optional_subject['optional_sub_id'];
                }
                
                $compusory_subjects = array();
                $optional_subjects = array();
                foreach ($rs['result'] as $mark){
                    if(!empty($data['optional_sub_id']) && $mark['subject_id'] == $data['optional_sub_id']){
                    $optional_subjects[] = $mark;
                    }else{
                        $compusory_subjects[] = $mark;
                    }
                }
                $combined_array = array_merge($compusory_subjects, $optional_subjects);
                
                $data['results'] = $combined_array;
                
//                $data['results'] = $rs['result'];
                $data['point'] = $rs['point'];
                $data['total_mks'] = $this->publish_resultmodel->get_total_exam_marks($class_id, $exam_id, $data['student_id']);
                $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
                $asd[] = $data;
            }
            
            $this->tpl->assign('results', $asd);
            $this->tpl->assign('student_details', $students_details);
        }
    }
    function show_2017_results(){
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);	  // get school info
        $this->tpl->assign('school_info',$school_info);
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);      

        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $exam_id = $this->input->get('exam_id');
        
        $exam_name = $this->publish_resultmodel->get_exam_name($exam_id);
        $this->tpl->assign('exam_name', $exam_name['title']);

        $max_total = $this->publish_resultmodel->get_height_total($class_id, $exam_id);
        $this->tpl->assign('max_total', $max_total['max_total']);

        $configures = $this->publish_resultmodel->get_view_exam_subjects($class_id, $exam_id);
        $aa = str_replace(' ','', $configures['exam_type']);
        $ex_final = substr($aa, 0, -3);
        $exam_type = array_unique(explode(',', $ex_final));
        $subjective = 0;
        $ct = 0;
        foreach($exam_type as $key=>$val)
        {
            $row = $this->publish_resultmodel->get_exam_type_details($val);
            $exam_title[] = $row['title'];
            $fields[] = $row['field_name'];
            if($val>10)
            {
            $subjective++;
            }else if($val>0 AND $val<11){
                $ct++;
            }
        }
        $this->tpl->assign('subjective', $subjective);       
        $this->tpl->assign('ct', $ct);
        
        if(!empty($configures)){
            $subjects = $exam_title;
            $subjects = array_combine($fields, $fields);
            $exam_types = explode(',', $configures['exam_type']);
            $this->tpl->assign('subjects', $subjects);
            $this->tpl->assign('exam_types', $exam_type);                   
        }

        $total_student_no = $this->publish_resultmodel->get_student_per_section($class_id, $section_id);
        $this->tpl->assign('total_students', $total_student_no);
        
        $topper = $this->publish_resultmodel->get_top_student($class_id, $exam_id, $section_id);
        $top_score = $topper['half_yearly'];
        $this->tpl->assign('topper_score', $top_score);
        
        if(!empty($class_id)){
            $result_scale = $this->publish_resultmodel->get_result_scale($class_id);            
            $students_details = $this->publish_resultmodel->get_student_ids($class_id, $exam_id, $section_id);
            
            $scale_matrix_list = $this->publish_resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
            $this->tpl->assign('scale_matrix_list', $scale_matrix_list);
            
            //Calculating total working days
            $range = $this->publish_resultmodel->get_range($class_id);
            if(!empty($range)){
                $working_days = $this->publish_resultmodel->get_working_days($class_id, $range['start_date'], $range['end_date']);
                $this->tpl->assign('working_days', $working_days);
            }
			
            $asd = array();
            foreach ($students_details as $students_detail){
                $student_name = $this->publish_resultmodel->get_student_name($students_detail['student_id']);
                $section = $this->publish_resultmodel->get_section($students_detail['student_id']);
                $class_title = $this->publish_resultmodel->get_class_title($class_id);
                $student_house = $this->publish_resultmodel->get_house($students_detail['student_id']);
                $student_number = $this->publish_resultmodel->get_student_number($students_detail['student_id']);
                
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['section_title'] = $section['section'];                
                $data['class_roll'] = $section['class_roll'];                
                $data['student_id'] = $students_detail['student_id'];
                $data['class_name'] = $class_title['title'];                
                if(!empty($student_house)){
                $data['house'] = $student_house['title'];
                }
                $data['class_id'] = $class_id;
                $data['exam_id'] = $exam_id;
                $data['student_number'] = $student_number['student_number'];
                
                $data['activities'] = $this->publish_resultmodel->get_student_pen_pic($students_detail['student_id'], $exam_id);
                if(!empty($range)){
                $presents = $this->publish_resultmodel->get_total_present($students_detail['student_id'], $range['start_date'], $range['end_date']);
                $data['total_presence'] = $presents['total_presence'];
                }
                
                $rs = $this->publish_resultmodel->get_entire_class_2017_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
                
                $optional_subject = $this->publish_resultmodel->get_optional_subject($students_detail['student_id']);
                if(!empty($optional_subject)){
                    $data['optional_sub_id'] = $optional_subject['optional_sub_id'];
                }
                
                $compusory_subjects = array();
                $optional_subjects = array();
                foreach ($rs['result'] as $mark){
                    if(!empty($data['optional_sub_id']) && $mark['subject_id'] == $data['optional_sub_id']){
                    $optional_subjects[] = $mark;
                    }else{
                        $compusory_subjects[] = $mark;
                    }
                }
                $combined_array = array_merge($compusory_subjects, $optional_subjects);
                
                $data['results'] = $combined_array;
                
//                $data['results'] = $rs['result'];
                $data['point'] = $rs['point'];
                $data['total_mks'] = $this->publish_resultmodel->get_total_exam_marks($class_id, $exam_id, $data['student_id']);
                $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
                $asd[] = $data;
            }
            
            $this->tpl->assign('results', $asd);
            $this->tpl->assign('student_details', $students_details);
        }
    }
    function annual_exam() {
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);        
        $class_id = $this->input->get('class_id');
        $exam_id = $this->input->get('exam_id');
        
        $max_total = $this->publish_resultmodel->get_highest_yearly_total($class_id, $exam_id);
        $this->tpl->assign('max_total', $max_total['max_total']);
        $configures = $this->publish_resultmodel->get_view_exam_subjects($class_id, $exam_id);
        
        $aa = str_replace(' ','', $configures['exam_type']);
        $ex_final = substr($aa, 0, -3);
        $exam_type = array_unique(explode(',', $ex_final));
        $subjective = 0;
        $ct = 0;
        foreach($exam_type as $key=>$val)
        {
            $row = $this->publish_resultmodel->get_exam_type_details($val);
            $exam_title[] = $row['title'];
            $fields[] = $row['field_name'];
            if($val>10)
            {
                $subjective++;
            }else if($val>0 AND $val<11){
                $ct++;
            }
        }
	$this->tpl->assign('subjective', $subjective);       
        $this->tpl->assign('ct', $ct);
        
        if(!empty($configures)){
            $subjects = $exam_title;
            $subjects = array_combine($fields, $fields);
            $exam_types = explode(',', $configures['exam_type']);
            $this->tpl->assign('subjects', $subjects);
            $this->tpl->assign('exam_types', $exam_type);       
        }

        $total_student_no = $this->publish_resultmodel->get_student_no($class_id);
        $this->tpl->assign('total_students', $total_student_no['total_Students']);
        
        if(!empty($class_id)){
            $result_scale = $this->publish_resultmodel->get_result_scale($class_id);
            $students_details = $this->publish_resultmodel->get_student_info($class_id, $exam_id);
            $scale_matrix_list = $this->publish_resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
            $this->tpl->assign('scale_matrix_list', $scale_matrix_list);
            
            $working_days = $this->publish_resultmodel->get_working_days($students_details[0]['student_id']);
            
            $this->tpl->assign('working_days', $working_days);
            
            $asd = array();
            foreach ($students_details as $students_detail){ 
                $data['student_name'] = $students_detail['first_name'].' '. $students_detail['last_name'];
                $data['class_roll'] = $students_detail['class_roll'];
                $data['section_title'] = $students_detail['section_title'];
                $data['student_id'] = $students_detail['student_id'];
                $data['class_name'] = $students_detail['class_name'];
                $data['house'] = $students_detail['house'];
                $data['class_id'] = $class_id;
                $data['exam_id'] = $exam_id;
                $data['student_number'] = $students_detail['student_number'];
                
                $presents = $this->publish_resultmodel->get_total_present($students_detail['student_id']);
                $data['total_presence'] = $presents['total_presence'];
                
                $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
                $data['results'] = $rs['result'];
                $data['point'] = $rs['annual_gp_point'];
                $data['total_mks'] = $this->publish_resultmodel->get_total_exam_marks($class_id, $exam_id, $data['student_id']);
//                $set_marks = $this->publish_resultmodel->get_pass_marks($class_id, $exam_id);
                
                $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
                
                $asd[] = $data;
            }
            
            $this->tpl->assign('results', $asd);
            $this->tpl->assign('student_details', $students_details);
        }
    }
    
    function download_result_sheet()
	{ 
        $class_id = $this->input->get('class_id');
        $exam_id = $this->input->get('exam_id');
        
        $check_result = $this->publish_resultmodel->check_result($class_id, $exam_id);
        $year = $this->session->userdata('db_postfix'); 
        if($year == ''){
            $year = date('Y-m-d');
        }else{
            $year = $year;
        }
        if(!empty($check_result)){
            if($exam_id == '2' || $exam_id == '18' || $exam_id == '19' || $exam_id == '20' || $exam_id == '21'){ 
                switch ($year){
                    case 2016:
                    $this->show_results();
                    $html =$this->load->view('publish_result/show_results_tpl.php',$this->tpl->_template_var,true); //making view for pdf
                    break;
                    case 2017:
                        $this->show_2017_results();
                        $html = $this->load->view('publish_result/show_2017_results_tpl.php', $this->tpl->_template_var, true);
                        break;
                    default:
                        break;
                }
                
            }else{
                $this->annual_exam();
                $html =$this->load->view('publish_result/annual_exam_tpl.php',$this->tpl->_template_var,true);  //making view for pdf
            }
            $this->tpl->set_layout(false);
            
//            echo $html;
//            exit();
            $pdfFilePath = "Transcript" . '_' . rand(100, 999) . '_' . date('Y-m-d') . '.pdf';
            $this->load->library('pdf');
            $pdf = $this->pdf->load();

            $pdf->AddPage('L', // L - landscape, P - portrait
                '', '', '', '',
                0, // margin_left
                0, // margin right
                0, // margin top
                0, // margin bottom
                0, // margin header
                0); // margin footer
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'The result you are trying to publish does not exist !');
            redirect('publish_result/make_result');
        }
    }


    private function _get_scale_matrix($result_scale_id, $point){
		//Find total Marks and grades
		$total_scale_matrix = $this->publish_resultmodel->get_scale_matrices($result_scale_id,$point);
		
		$data['weight'] = $point;
		$data['title'] = $total_scale_matrix;
		return $data;
	}

    private function _get_class_highest($class_id, $exam_id){        
        $all_subjects = $this->publish_resultmodel->get_all_subjects();        
		if(!empty($all_subjects)){
			foreach ($all_subjects as $subject){
				$class_highest[] = $this->publish_resultmodel->get_class_highest($class_id, $exam_id, $subject['id']);
			}
		}
		return $class_highest;
    }
    
    function update_entry(){
        $this->load->form('update_entry_form');
        $student_id = $this->input->get('student_id');
        $class_id = $this->input->get('class');
        $exam_id = $this->input->get('exam');
        $subject_id = $this->input->get('subject');        
        if(!empty($class_id)){
            $students = $this->publish_resultmodel->get_all_students($class_id);
            $this->tpl->assign('students', $students);
        }
        $exam_types = $this->publish_resultmodel->get_test_types($class_id, $exam_id, $subject_id);
        if(!empty($exam_types)){
            $exam_titles = explode(',', $exam_types['exam_title']);
            $field_names = explode(',', $exam_types['field_name']);
            $form_fields = array_combine($field_names, $exam_titles);        
            $this->tpl->assign('form_fields', $form_fields);
        }
        if(!empty($student_id)){
            $marks = $this->publish_resultmodel->get_result_info($student_id, $exam_id, $subject_id);
            $this->load->form('update_entry_form', NULL, $marks);
            $this->tpl->assign('marks', $marks);
//            print_r($marks);
        }        
    }
    function amend_result() {
        $student_id = $this->input->post('student_id');
        $exam_id = $this->input->post('update_entry_form_exam_id');
        $subject_id = $this->input->post('update_entry_form_subject_id');
        $class_id = $this->input->post('update_entry_form_class_id');
            
            $data['student_id'] = $student_id;
            $data['class_id'] = $class_id;
            $data['subject_id'] = $subject_id;
            $data['exam_id'] = $exam_id;
            $data['ct1'] = $this->input->post('ct1');
            $data['ct2'] = $this->input->post('ct2');
            $data['ct3'] = $this->input->post('ct3');
            $data['ct4'] = $this->input->post('ct4');
            $data['ct5'] = $this->input->post('ct5');
            $data['ct6'] = $this->input->post('ct6');
            $data['ct7'] = $this->input->post('ct7');
            $data['ct8'] = $this->input->post('ct8');
            $data['ct9'] = $this->input->post('ct9');
            $data['ct10'] = $this->input->post('ct10');
            $data['creative'] = $this->input->post('creative');
            $data['mcq'] = $this->input->post('mcq');
            $data['practical'] = $this->input->post('practical');
            $data['others'] = $this->input->post('others');
            $data['descriptive1'] = $this->input->post('descriptive1');
            $data['descriptive2'] = $this->input->post('descriptive2');
            $data['descriptive3'] = $this->input->post('descriptive3');
            
            $formula_hard = $this->publish_resultmodel->get_formula($data['class_id'], $data['subject_id']);
            $equation = $this->evalmath($formula_hard['formula']);

            $ct1 = $data['ct1']; 
            $ct2 = $data['ct2'];
            $ct3 = $data['ct3'];
            $ct4 = $data['ct4'];
            $ct5 = $data['ct5'];
            $ct6 = $data['ct6'];
            $ct7 = $data['ct7'];
            $ct8 = $data['ct8'];
            $ct9 = $data['ct9'];
            $ct10 = $data['ct10'];
            $creative = $data['creative'];
            $mcq = $data['mcq'];
            $practical = $data['practical'];
            $others = $data['others'];
            $descriptive1 = $data['descriptive1'];
            $descriptive2 = $data['descriptive2'];
            $descriptive3 = $data['descriptive3'];
        
            $data['half_yearly_total'] = $creative + $mcq + $practical + $others + $descriptive1 + $descriptive2 + $descriptive3;
        
            if($equation != ''){
                $grand_total = @eval("return " . $equation . ";" );
            }        
//        $examination = $this->publish_resultmodel->get_exam_name($data['exam_id']);
        $result_scale = $this->publish_resultmodel->get_result_scale($data['class_id']);       
        $total_exam_marks = $this->publish_resultmodel->get_exam_full_marks($data['class_id'], $data['exam_id'], $data['subject_id']);

        $scale_grand_total = ($grand_total/$total_exam_marks)*100;
        $scale_matrix = $this->publish_resultmodel->get_gp_lg($result_scale['result_scale_id'], $scale_grand_total);

        if($data['exam_id'] == '2'){
            $data['half_yearly_grand_total'] = $grand_total;
            $data['half_yearly_gp'] = $scale_matrix['weight'];
            $data['half_yearly_lg'] = $scale_matrix['title'];
        }
        if($data['exam_id'] == '3'){
            $data['yearly_grand_total'] = $grand_total;
            $data['yearly_gp'] = $scale_matrix['weight'];
            $data['yearly_lg'] = $scale_matrix['title'];
        }
            
        $edit_result_sheet = $this->publish_resultmodel->edit_result($student_id, $class_id, $subject_id, $exam_id, $data);
            if($edit_result_sheet){
                $this->session->set_flashdata('success',"The Result Sheet has been updated successfully");
                redirect('publish_result/test_entry');
            }
    }
    function view_result() {
        $results = $this->publish_resultmodel->get_all_results();        
        foreach ($results as $result){
            $data['student_name'] = $result['first_name'] .' '.$result['last_name'];
            $data['total_mks'] = $this->publish_resultmodel->get_total_exam_marks($result['class_id'], $result['exam_id'], $result['student_id']);

            $result_scale = $this->publish_resultmodel->get_result_scale($result['class_id']);
            $rs = $this->publish_resultmodel->get_entire_class_result($result['class_id'], $result['exam_id'], $result['student_id'], $result_scale['result_scale_id']);
            
            $data['point'] = $rs['point'];
            $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
            $all_result[] = $data;            
        }
        $this->tpl->assign('results', $all_result);
//        echo '<pre>';
//        print_r($all_result);
//        $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
    }
    
//    protected function display_grid() {
//        $this->load->library('grid_board');
//        $this->grid_board->set_title('Result Sheet');
//        $grid_columns = array('student_name' => 'Student Name', 'halh_yearly_grand_total' => 'Half Yearly Marks', 'yearly_grand_total' => 'Yearly Marks');
//        $this->grid_board->set_column($grid_columns);
//        $this->grid_board->render('');
//    }
    function generate_grid_board() {
        $this->load->form('generate_grid_boardform');
        $this->tpl->set_view('generate_grid_board');
        $this->insert_grid_board($this->generate_grid_boardform);
    }
    function insert_grid_board($form) {
        if($form->validate()){
            $this->tpl->set_view('insert_grid_board');
            $class_id = $this->input->post('generate_grid_boardform_class_id');
            $section_id = $this->input->post('generate_grid_boardform_section_id');
            $subject_id = $this->input->post('generate_grid_boardform_subject_id');
            $exam_id = $this->input->post('generate_grid_boardform_exam_id');
            $exam_types = $this->publish_resultmodel->get_test_subjects($class_id, $exam_id, $subject_id);
            $formula_hard = $this->publish_resultmodel->get_formula($class_id, $subject_id);

            if(!empty($exam_types) && !empty($formula_hard)){    
                $exam_titles = explode(',', $exam_types['exam_title']);
                $field_names = explode(',', $exam_types['field_name']);
                $data['form_fields'] = array_combine($field_names, $exam_titles);
                
                $students = $this->publish_resultmodel->get_students_by_form($class_id, $section_id);
                
                $info = array();
                foreach ($students as $student){
                    if($exam_types['is_optional'] > 0){
                        $subject_group = $this->publish_resultmodel->get_subject_group($student['subject_group_id']);

                        if(!empty($subject_group)){                            
                            if($subject_group['compulsory_sub_id'] == $subject_id || $subject_group['optional_sub_id'] == $subject_id ){
                                $data['student_name'] = $student['first_name']. ' '.$student['last_name'];
                                $data['student_id'] = $student['student_id'];
                                $data['class_roll'] = $student['class_roll'];
                                $info[] = $data;
                            }
                        }
                    }else{
                        $data['student_name'] = $student['first_name']. ' '.$student['last_name'];
                        $data['student_id'] = $student['student_id'];
                        $data['class_roll'] = $student['class_roll'];
                        $info[] = $data;
                    }
                }

                $this->tpl->assign('form_elements', $info);
                $entry_details = $this->publish_resultmodel->get_result_entry_details($class_id, $section_id, $subject_id);
                $this->tpl->assign('entry_details', $entry_details);
                $class_info = array('class_id'=> $class_id, 'exam_id' => $exam_id, 'subject_id' => $subject_id, 'section_id' => $section_id);
                $this->tpl->assign('info', $class_info);
            }else{
                $no_record = 'No Record Found!';
                $this->tpl->assign('no_record', $no_record);
            }
        }
    }
    
    function insert_result(){
        $row_count = $this->input->post('row_count');
        $data['class_id'] = $this->input->post('class_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['exam_id'] = $this->input->post('exam_id');
        $data['section_id'] = $this->input->post('section_id');
        $check_valid_exam = $this->publish_resultmodel->check_valid_exam($data['class_id'], $data['subject_id'], $data['exam_id'], $data['section_id']);
        if(empty($check_valid_exam)){
        for($i=0;$i<$row_count;$i++){
            $data['ct1'] = $this->input->post('ct1'.$i);
            $data['ct2'] = $this->input->post('ct2'.$i);
            $data['ct3'] = $this->input->post('ct3'.$i);
            $data['ct4'] = $this->input->post('ct4'.$i);
            $data['ct5'] = $this->input->post('ct5'.$i);
            $data['ct6'] = $this->input->post('ct6'.$i);
            $data['ct7'] = $this->input->post('ct7'.$i);
            $data['ct8'] = $this->input->post('ct8'.$i);
            $data['ct9'] = $this->input->post('ct9'.$i);
            $data['ct10'] = $this->input->post('ct10'.$i);
            $data['creative'] = $this->input->post('creative'.$i);
            $data['mcq'] = $this->input->post('mcq'.$i);
            $data['practical'] = $this->input->post('practical'.$i);
            $data['others'] = $this->input->post('others'.$i);
            $data['descriptive1'] = $this->input->post('descriptive1'.$i);
            $data['descriptive2'] = $this->input->post('descriptive2'.$i);
            $data['descriptive3'] = $this->input->post('descriptive3'.$i);            
            $data['wt1'] = $this->input->post('wt1'.$i);            
            $data['wt2'] = $this->input->post('wt2'.$i);            
            $data['wt3'] = $this->input->post('wt3'.$i);            
            $data['wt4'] = $this->input->post('wt4'.$i);            
            $data['wt5'] = $this->input->post('wt5'.$i);            
            $data['wt6'] = $this->input->post('wt6'.$i);            
            $data['student_id'] = $this->input->post('student_id'.$i);
            
            $formula_hard = $this->publish_resultmodel->get_formula($data['class_id'], $data['subject_id']);
            $equation = $this->evalmath($formula_hard['formula']);
            
            $ct1 = $data['ct1']; 
            $ct2 = $data['ct2'];
            $ct3 = $data['ct3'];
            $ct4 = $data['ct4'];
            $ct5 = $data['ct5'];
            $ct6 = $data['ct6'];
            $ct7 = $data['ct7'];
            $ct8 = $data['ct8'];
            $ct9 = $data['ct9'];
            $ct10 = $data['ct10'];
            $creative = $data['creative'];
            $mcq = $data['mcq'];
            $practical = $data['practical'];
            $others = $data['others'];
            $descriptive1 = $data['descriptive1'];
            $descriptive2 = $data['descriptive2'];
            $descriptive3 = $data['descriptive3'];
            $wt1 = $data['wt1'];
            $wt2 = $data['wt2'];
            $wt3 = $data['wt3'];
            $wt4 = $data['wt4'];
            $wt5 = $data['wt5'];
            $wt6 = $data['wt6'];
            
            $data['half_yearly_total'] = $creative + $mcq + $practical + $others + $descriptive1 + $descriptive2 + $descriptive3;            

            if($equation != ''){
                $grand_total = @eval("return " . $equation . ";" );
            }
            $result_scale = $this->publish_resultmodel->get_result_scale($data['class_id']);       
            $total_exam_marks = $this->publish_resultmodel->get_exam_full_marks($data['class_id'], $data['exam_id'], $data['subject_id']);

            $scale_grand_total = ($grand_total/$total_exam_marks)*100;

            $scale_matrix = $this->publish_resultmodel->get_gp_lg($result_scale['result_scale_id'], $scale_grand_total);
            
            $check_passfail = $this->calculate_pass_fail($data['class_id'], $data['subject_id'], $creative, $mcq, $practical);
            if($check_passfail == 'fail'){
                $scale_matrix['weight'] = '0.00';
                $scale_matrix['title'] = '';
            }
            
            if($data['exam_id'] == '2'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            if($data['exam_id'] == '18'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            if($data['exam_id'] == '19'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            if($data['exam_id'] == '20'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            if($data['exam_id'] == '21'){
                $data['half_yearly_grand_total'] = $grand_total;
                $data['half_yearly_gp'] = $scale_matrix['weight'];
                $data['half_yearly_lg'] = $scale_matrix['title'];
            }
            
            $add_result_id = $this->publish_resultmodel->add_result($data);
            }
            $this->session->set_flashdata('success', 'The Result Sheet Generated successfully');
            redirect('publish_result/generate_grid_board');
        }else {
            $this->session->set_flashdata('error', 'The Result you are trying to create is already exist!');
            redirect('publish_result/generate_grid_board');
        }
    }
    
    function generate_edit_grid_board() {
        $this->load->form('generate_edit_grid_boardform');
        $this->tpl->set_view('generate_edit_grid_board');
        $this->edit_grid_board($this->generate_edit_grid_boardform);
    }
    function edit_grid_board($form) {
        if($form->validate()){
            $this->tpl->set_view('edit_grid_board');
            $class_id = $this->input->post('generate_edit_grid_boardform_class_id');
            $section_id = $this->input->post('generate_edit_grid_boardform_section_id');
            $subject_id = $this->input->post('generate_edit_grid_boardform_subject_id');
            $exam_id = $this->input->post('generate_edit_grid_boardform_exam_id');
            $exam_types = $this->publish_resultmodel->get_test_subjects($class_id, $exam_id, $subject_id);
            $formula_hard = $this->publish_resultmodel->get_formula($class_id, $subject_id);
            if(!empty($exam_types) && !empty($formula_hard)){
                $exam_titles = explode(',', $exam_types['exam_title']);
                $field_names = explode(',', $exam_types['field_name']);
                $form_fields = array_combine($field_names, $exam_titles);

//                $students = $this->publish_resultmodel->get_students_by_form($class_id, $section_id);
                $students = $this->publish_resultmodel->get_form_students($class_id, $section_id, $exam_id, $subject_id);

                $info = array();
                $data['form_fields'] = array();
                foreach ($students as $student) {
                    if ($exam_types['is_optional'] > 0) {
                        $subject_group = $this->publish_resultmodel->get_subject_group($student['subject_group_id']);
                        if (!empty($subject_group)) {
                            if($subject_group['compulsory_sub_id'] == $subject_id || $subject_group['optional_sub_id'] == $subject_id ){
                                $data['student_name'] = $student['first_name'] . ' ' . $student['last_name'];
                                $data['student_id'] = $student['student_id'];
                                $data['class_roll'] = $student['class_roll'];
                                $data['form_fields'] = $form_fields;
                                $results = $this->publish_resultmodel->get_result($class_id, $subject_id, $exam_id, $student['student_id']);

                                if (!empty($results)) {
                                    $data['result_sheet_id'] = $results['id'];
                                    $data['ct1'] = $results['ct1'];
                                    $data['ct2'] = $results['ct2'];
                                    $data['ct3'] = $results['ct3'];
                                    $data['ct4'] = $results['ct4'];
                                    $data['ct5'] = $results['ct5'];
                                    $data['ct6'] = $results['ct6'];
                                    $data['ct7'] = $results['ct7'];
                                    $data['ct8'] = $results['ct8'];
                                    $data['ct9'] = $results['ct9'];
                                    $data['ct10'] = $results['ct10'];
                                    $data['others'] = $results['others'];
                                    $data['creative'] = $results['creative'];
                                    $data['mcq'] = $results['mcq'];
                                    $data['practical'] = $results['practical'];
                                    $data['descriptive1'] = $results['descriptive1'];
                                    $data['descriptive2'] = $results['descriptive2'];
                                    $data['descriptive3'] = $results['descriptive3'];
                                    $data['wt1'] = $results['wt1'];
                                    $data['wt2'] = $results['wt2'];
                                    $data['wt3'] = $results['wt3'];
                                    $data['wt4'] = $results['wt4'];
                                    $data['wt5'] = $results['wt5'];
                                    $data['wt6'] = $results['wt6'];
                            }
                            $info[] = $data;
                            }
                        }
                    } else {
                        $data['student_name'] = $student['first_name'] . ' ' . $student['last_name'];
                        $data['student_id'] = $student['student_id'];
                        $data['class_roll'] = $student['class_roll'];
                        $data['form_fields'] = $form_fields;
                        $results = $this->publish_resultmodel->get_result($class_id, $subject_id, $exam_id, $student['student_id']);

                        if (!empty($results)) {
                            $data['result_sheet_id'] = $results['id'];
                            $data['ct1'] = $results['ct1'];
                            $data['ct2'] = $results['ct2'];
                            $data['ct3'] = $results['ct3'];
                            $data['ct4'] = $results['ct4'];
                            $data['ct5'] = $results['ct5'];
                            $data['ct6'] = $results['ct6'];
                            $data['ct7'] = $results['ct7'];
                            $data['ct8'] = $results['ct8'];
                            $data['ct9'] = $results['ct9'];
                            $data['ct10'] = $results['ct10'];
                            $data['others'] = $results['others'];
                            $data['creative'] = $results['creative'];
                            $data['mcq'] = $results['mcq'];
                            $data['practical'] = $results['practical'];
                            $data['descriptive1'] = $results['descriptive1'];
                            $data['descriptive2'] = $results['descriptive2'];
                            $data['descriptive3'] = $results['descriptive3'];
                            $data['wt1'] = $results['wt1'];
                            $data['wt2'] = $results['wt2'];
                            $data['wt3'] = $results['wt3'];
                            $data['wt4'] = $results['wt4'];
                            $data['wt5'] = $results['wt5'];
                            $data['wt6'] = $results['wt6'];
                        }
                        $info[] = $data;
                    }
                }
                $this->tpl->assign('form_elements', $info);
                $class_info = array('class_id'=> $class_id, 'exam_id' => $exam_id, 'subject_id' => $subject_id);
                $this->tpl->assign('info', $class_info);
                $entry_details = $this->publish_resultmodel->get_result_entry_details($class_id, $section_id, $subject_id);
                $this->tpl->assign('entry_details', $entry_details);
            }else{
                $no_record = 'No Record Found!';
                $this->tpl->assign('no_record', $no_record);
            }
        }
    }
    function update_result() {
        $row_count = $this->input->post('row_count');
        $data['class_id'] = $this->input->post('class_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['exam_id'] = $this->input->post('exam_id');
        if(!empty($row_count)){
        for($i=0;$i<$row_count;$i++){
            $result_sheet_id = $this->input->post('result_sheet_id'.$i);
            
            $data['ct1'] = $this->input->post('ct1'.$i);
            $data['ct2'] = $this->input->post('ct2'.$i);
            $data['ct3'] = $this->input->post('ct3'.$i);
            $data['ct4'] = $this->input->post('ct4'.$i);
            $data['ct5'] = $this->input->post('ct5'.$i);
            $data['ct6'] = $this->input->post('ct6'.$i);
            $data['ct7'] = $this->input->post('ct7'.$i);
            $data['ct8'] = $this->input->post('ct8'.$i);
            $data['ct9'] = $this->input->post('ct9'.$i);
            $data['ct10'] = $this->input->post('ct10'.$i);
            $data['creative'] = $this->input->post('creative'.$i);
            $data['mcq'] = $this->input->post('mcq'.$i);
            $data['practical'] = $this->input->post('practical'.$i);
            $data['others'] = $this->input->post('others'.$i);
            $data['descriptive1'] = $this->input->post('descriptive1'.$i);
            $data['descriptive2'] = $this->input->post('descriptive2'.$i);
            $data['descriptive3'] = $this->input->post('descriptive3'.$i); 
            $data['wt1'] = $this->input->post('wt1'.$i);            
            $data['wt2'] = $this->input->post('wt2'.$i);            
            $data['wt3'] = $this->input->post('wt3'.$i);            
            $data['wt4'] = $this->input->post('wt4'.$i);            
            $data['wt5'] = $this->input->post('wt5'.$i);            
            $data['wt6'] = $this->input->post('wt6'.$i);
            
            $data['student_id'] = $this->input->post('student_id'.$i);
            
            $formula_hard = $this->publish_resultmodel->get_formula($data['class_id'], $data['subject_id']);
            $equation = $this->evalmath($formula_hard['formula']);
            
            $ct1 = $data['ct1']; 
            $ct2 = $data['ct2'];
            $ct3 = $data['ct3'];
            $ct4 = $data['ct4'];
            $ct5 = $data['ct5'];
            $ct6 = $data['ct6'];
            $ct7 = $data['ct7'];
            $ct8 = $data['ct8'];
            $ct9 = $data['ct9'];
            $ct10 = $data['ct10'];
            $creative = $data['creative'];
            $mcq = $data['mcq'];
            $practical = $data['practical'];
            $others = $data['others'];
            $descriptive1 = $data['descriptive1'];
            $descriptive2 = $data['descriptive2'];
            $descriptive3 = $data['descriptive3'];
            $wt1 = $data['wt1'];
            $wt2 = $data['wt2'];
            $wt3 = $data['wt3'];
            $wt4 = $data['wt4'];
            $wt5 = $data['wt5'];
            $wt6 = $data['wt6'];
            
            $data['half_yearly_total'] = $creative + $mcq + $practical + $others + $descriptive1 + $descriptive2 + $descriptive3;            
            
            if($equation != ''){
                $grand_total = @eval("return " . $equation . ";" );
            }
            $result_scale = $this->publish_resultmodel->get_result_scale($data['class_id']);       
            $total_exam_marks = $this->publish_resultmodel->get_exam_full_marks($data['class_id'], $data['exam_id'], $data['subject_id']);

            $scale_grand_total = ($grand_total/$total_exam_marks)*100;

            $scale_matrix = $this->publish_resultmodel->get_gp_lg($result_scale['result_scale_id'], $scale_grand_total);
            
            $check_passfail = $this->calculate_pass_fail($data['class_id'], $data['subject_id'], $creative, $mcq, $practical);
                if($check_passfail == 'fail'){
                    $scale_matrix['weight'] = '0.00';
                    $scale_matrix['title'] = 'F';
                }
                if($data['exam_id'] == '2'){
                    $data['half_yearly_grand_total'] = $grand_total;
                    $data['half_yearly_gp'] = $scale_matrix['weight'];
                    $data['half_yearly_lg'] = $scale_matrix['title'];
                }
                if($data['exam_id'] == '18'){
                    $data['half_yearly_grand_total'] = $grand_total;
                    $data['half_yearly_gp'] = $scale_matrix['weight'];
                    $data['half_yearly_lg'] = $scale_matrix['title'];
                }
                if($data['exam_id'] == '19'){
                    $data['half_yearly_grand_total'] = $grand_total;
                    $data['half_yearly_gp'] = $scale_matrix['weight'];
                    $data['half_yearly_lg'] = $scale_matrix['title'];
                }
                if($data['exam_id'] == '20'){
                    $data['half_yearly_grand_total'] = $grand_total;
                    $data['half_yearly_gp'] = $scale_matrix['weight'];
                    $data['half_yearly_lg'] = $scale_matrix['title'];
                }
                if($data['exam_id'] == '21'){
                    $data['half_yearly_grand_total'] = $grand_total;
                    $data['half_yearly_gp'] = $scale_matrix['weight'];
                    $data['half_yearly_lg'] = $scale_matrix['title'];
                }
            
            $add_result_id = $this->publish_resultmodel->edit_result_sheet($result_sheet_id, $data);                
            }
            $this->session->set_flashdata('success', 'The Result Sheet Updated successfully');
            redirect('publish_result/generate_edit_grid_board');
        }
    }
    public function get_related_subjects() {
        $class_id = $this->input->post('class_id');
        $subjects = $this->publish_resultmodel->get_assigned_couses($class_id);
        echo json_encode($subjects);
    }
//    public function class_result_publish() {
//        $this->load->form('class_result_publishform');
//        $this->publish_class_wise($this->class_result_publishform);
//    }
//    public function publish_class_wise($form) {
//        if($form->validate()){
//            $class_id = $this->input->post('class_result_class_id');
//            $exam_id = $this->input->post('class_result_exam_id');
//            $publish = $this->publish_resultmodel->set_publish_class($class_id, $exam_id);
//            if($publish){
//                $this->session->set_flashdata('success', 'The Result Published successfully');
//                redirect('publish_result/result_class_publish_list');
//            }
//        }
//    }
//    public function result_class_publish_list() {
//        $classes = $this->publish_resultmodel->get_result_classes();
//        $exams = $this->publish_resultmodel->get_exams();
//        $this->tpl->assign('classes', $classes);
//    }
    function create_position_per_class() {
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);
    }    
    public function create_positions() {                
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $exam_id = $this->input->post('exam_id');
        
        $check_result = $this->publish_resultmodel->check_result($class_id, $exam_id);
        
        if(!empty($check_result)){
            $result_scale = $this->publish_resultmodel->get_result_scale($class_id);
//            $students_details = $this->publish_resultmodel->get_student_info($class_id, $exam_id);
            $students_details = $this->publish_resultmodel->get_cadidate_ids($class_id, $exam_id, $section_id);

            $asd = array();
            foreach ($students_details as $students_detail){                 
                $student_id = $students_detail['student_id'];
                $section = $this->publish_resultmodel->get_section($students_detail['student_id']);
                
                $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
                
                $point = $rs['point'];
                $total_mks = $this->publish_resultmodel->get_total_exam_marks($class_id, $exam_id, $student_id);
                
                $scale_matrix = $this->_get_scale_matrix($result_scale['result_scale_id'], $point);
                $data['scale_matrix'] = number_format($scale_matrix['weight'], 2, '.', '');
                $data['total_mks'] = $total_mks['total_mks_half_yearly'];
                $data['class_roll'] = $section['class_roll'];
                $data['student_id'] = $student_id;
                $asd[] = $data;
            }  
            
//            arsort($asd);
          $data = array();
            foreach($asd as $key=>$val)
            {    
                $data['scale_matrix'][$key] = $val['scale_matrix'];
                $data['total_mks'][$key] = $val['total_mks'];
                $data['class_roll'][$key] = $val['class_roll'];
                $data['student_id'][$key] = $val['student_id'];
            }
            
            // Sort the data with volume descending, edition ascending
            array_multisort($data['scale_matrix'], SORT_DESC, $data['total_mks'], SORT_DESC, $data['class_roll'], SORT_ASC, $asd);
            
            
            $i = 1;
            foreach ($asd as $position){
                $student_id_update = $position['student_id'];
                $this->publish_resultmodel->create_position($i, $student_id_update);
                $i++;
            }
            $this->session->set_flashdata('success', 'The Position Created successfully');
            redirect('publish_result/create_position_per_class');
        }else{
            $this->session->set_flashdata('error', 'No record found!');
            redirect('publish_result/create_position_per_class');
        }
    }
    function calculate_pass_fail($class, $subject, $creative = "", $mcq = "", $practical = "") {
        if ($class == '32' OR $class == '36' OR $class == '37') {
            $sub_70 = array(56, 57, 75, 59, 68);
            $sub_50 = array(64, 67);
            $sub_80 = array(65);
            $sub_25 = array(69);

            // for class six and seven

            if (in_array($subject, $sub_70)) {

                if (!empty($creative)) {
                    $rs = $creative < 23 ? "F" : "P";
                }
                if (!empty($mcq)) {
                    $rs1 = $mcq < 10 ? "F" : "P";
                }
                if (!empty($rs) AND ! empty($rs1)) {
                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
                } 
                elseif (!empty($rs)) {
                    $result = ($rs == "P") ? "pass" : "fail";
                }
                elseif (!empty($rs1)) {
                    $result = ($rs1 == "P") ? "pass" : "fail";
                }
                return $result;
            }
//            elseif (in_array($subject, $sub_50)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 17 ? "F" : "P";
//                }
//                if (!empty($rs)) {
//                    $result = ($rs == "P") ? "pass" : "fail";
//                }
//                return $result;
//            } elseif (in_array($subject, $sub_80)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 27 ? "F" : "P";
//                }
//                if (!empty($practical)) {
//                    $rs1 = $practical < 7 ? "F" : "P";
//                }
//                if (!empty($rs) AND ! empty($rs1)) {
//                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
//                } 
//				elseif (!empty($rs)) {
//                    $result = ($rs == "P") ? "pass" : "fail";
//                } 
//				elseif (!empty($rs1)) {
//                    $result = ($rs1 == "P") ? "pass" : "fail";
//                }
//                return $result;
//            } 
            elseif (in_array($subject, $sub_25)) {
                if (!empty($creative)) {
                    $rs = $creative < 8 ? "F" : "P";
                }
                if (!empty($mcq)) {
                    $rs1 = $mcq < 8 ? "F" : "P";
                }
                if (!empty($practical)) {
                    $rs2 = $practical < 8 ? "F" : "P";
                }
                if (!empty($rs) AND ! empty($rs1) AND ! empty($rs2)) {
                    $result = ($rs == "P" AND $rs1 == "P" AND $rs2 == "P") ? "pass" : "fail";
                }
                elseif (!empty($rs) AND ! empty($rs1)) {
                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
                }
                elseif (!empty($rs) AND ! empty($rs2)) {
                    $result = ($rs == "P" AND $rs2 == "P") ? "pass" : "fail";
                }
                return $result;
            } 
        }

        //end class six and seven
        // Start class eight
//        elseif ($class == '37') {
//            $sub_60 = array(63, 56, 57, 75, 59, 68);
//            $sub_50 = array(64, 67);
//            $sub_25 = array(69,70, 72);
//            $sub_30 = array(71);
//            $sub_100 = array(65);
//
//            if (in_array($subject, $sub_60)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 20 ? "F" : "P";
//                }
//                if (!empty($mcq)) {
//                    $rs1 = $mcq < 13 ? "F" : "P";
//                }
//                if (!empty($rs) AND ! empty($rs1)) {
//                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
//                } elseif (!empty($rs)) {
//                    $result = ($rs == "P") ? "pass" : "fail";
//                } elseif (!empty($rs1)) {
//                    $result = ($rs1 == "P") ? "pass" : "fail";
//                }
//                return $result;
//            } elseif (in_array($subject, $sub_50)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 17 ? "F" : "P";
//                }
//                if (!empty($rs)) {
//                    $result = ($rs == "P") ? "pass" : "fail";
//                }
//                return $result;
//            } 
//			elseif (in_array($subject, $sub_25)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 8 ? "F" : "P";
//                }
//                if (!empty($mcq)) {
//                    $rs1 = $mcq < 8 ? "F" : "P";
//                }
//                if (!empty($practical)) {
//                    $rs2 = $practical < 8 ? "F" : "P";
//                }
//                if (!empty($rs) AND ! empty($rs1) AND ! empty($rs2)) {
//                    $result = ($rs == "P" AND $rs1 == "P" AND $rs2 == "P") ? "pass" : "fail";
//                }
//				elseif (!empty($rs) AND ! empty($rs1)) {
//                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
//                }
//				elseif (!empty($rs) AND ! empty($rs2)) {
//                    $result = ($rs == "P" AND $rs2 == "P") ? "pass" : "fail";
//                }	
//                return $result;
//            } 
//			elseif (in_array($subject, $sub_30)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 10 ? "F" : "P";
//                }
//                if (!empty($mcq)) {
//                    $rs1 = $mcq < 7 ? "F" : "P";
//                }
//                if (!empty($rs) AND ! empty($rs1)) {
//                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
//                } 
//                return $result;
//            }  
//			
//			elseif (in_array($subject, $sub_100)) {
//                if (!empty($creative)) {
//                    $rs = $creative < 33 ? "F" : "P";
//                }
//                if (!empty($rs)) {
//                    $result = ($rs == "P") ? "pass" : "fail";
//                }
//                return $result;
//            }
//        }

        // end class eight.
		
        // class Nine and Ten. 
        elseif ($class == '39' OR $class == '41') {
            $sub_70 = array(56, 57, 59, 84, 86, 89, 96);
            $sub_25 = array(69);
            $sub_50 = array(93, 108, 109, 71, 102, 112);
            $sub_100 = array(65, 67);

            if (in_array($subject, $sub_70)) {
                if (!empty($creative)) {
                    $rs = $creative < 23 ? "F" : "P";
                }
                if (!empty($mcq)) {
                    $rs1 = $mcq < 10 ? "F" : "P";
                }
                if (!empty($rs) AND ! empty($rs1)) {
                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
                } 
                elseif (!empty($rs)) {
                    $result = ($rs == "P") ? "pass" : "fail";
                } 
		elseif (!empty($rs1)) {
                    $result = ($rs1 == "P") ? "pass" : "fail";
                }
                return $result;
            } 
            elseif (in_array($subject, $sub_50)) {
                if (!empty($creative)) {
                    $rs = $creative < 17 ? "F" : "P";
                }
                if (!empty($mcq)) {
                    $rs1 = $mcq < 8 ? "F" : "P";
                }
                if (!empty($practical)) {
                    $rs2 = $practical < 8 ? "F" : "P";
                }
                if (!empty($rs) AND ! empty($rs1) AND ! empty($rs2)) {
                    $result = ($rs == "P" AND $rs1 == "P" AND $rs2 == "P") ? "pass" : "fail";
                } 
		elseif (!empty($rs)) {
                    $result = ($rs == "P") ? "pass" : "fail";
                } 
		elseif (!empty($rs1)) {
                    $result = ($rs1 == "P") ? "pass" : "fail";
                } 
		elseif (!empty($rs2)) {
                    $result = ($rs2 == "P") ? "pass" : "fail";
                }
                return $result;
            }
            elseif (in_array($subject, $sub_25)) {
                if (!empty($creative)) {
                    $rs = $creative < 8 ? "F" : "P";
                }
                if (!empty($mcq)) {
                    $rs1 = $mcq < 8 ? "F" : "P";
                }
                if (!empty($practical)) {
                    $rs2 = $practical < 8 ? "F" : "P";
                } 
                if (!empty($rs) AND ! empty($rs1)) {
                    $result = ($rs == "P" AND $rs1 == "P") ? "pass" : "fail";
                }
                elseif (!empty($rs1) AND ! empty($rs2)) {
                    $result = ($rs1 == "P" AND $rs2 == "P") ? "pass" : "fail";
                }	
                else {
                    $result = "fail";
                }
                return $result;
            }
			
	elseif (in_array($subject, $sub_100)) {
            if (!empty($creative)) {
                $rs = $creative < 33 ? "F" : "P";
            }
            if (!empty($rs)) {
                $result = ($rs == "P") ? "pass" : "fail";
            }
            return $result;
        }
    }

        // end class nine
    }

}