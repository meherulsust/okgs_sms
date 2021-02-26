<?php
/* 
 * Created on 20-04-2016
 * Developed by: Arena Development Team
 * 
 */
class Result_formula extends BACKEND_Controller{
    public $error = array();
    function __construct() {
        parent::__construct();
        $this->load->model('result_formulamodel');
        $this->load->model('publish_resultmodel');
    }
    function index(){
        $this->init_grid();
    }    
    protected function init_grid(){       
        $this->load->library('grid_board');
        $this->grid_board->set_title('Formula List');        
        $grid_columns = array('class_title' => 'class_name', 'subject_title' => 'Subject Name', 'examination' => 'Examination', 'formula' =>'Formula');
        
        $this->grid_board->set_column($grid_columns);        
        $this->grid_board->render('result_formulamodel');
    }
    function view($id){
        $info = $this->result_formulamodel->get_formulas($id);
        if(empty($info)){
            show_404();
        }
        $this->tpl->assign($info[0]);
    }
    function create_formula(){
        $this->load->form('create_formula_form');
        $this->tpl->set_js(array('jquery.validate','select-chain'));
        $class_tests = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('tests', $class_tests);
//        $classes = $this->result_formulamodel->get_classes();
//        $this->tpl->assign('classes', $classes);
//        $subjects = $this->result_formulamodel->get_subjects();
//        $this->tpl->assign('subjects', $subjects);
        
    }
    function save(){
        $this->load->form('create_formula_form');
        $this->tpl->set_view('create_formula');
        $this->process_form($this->create_formula_form);
    }
    protected function process_form($form){
        if($form->validate()){
            $data['class_id'] = $this->input->post('create_formula_class_id');
            $data['exam_id'] = $this->input->post('create_formula_exam_id');
            $data['subject_id'] = $this->input->post('create_formula_subject_id');
            $data['formula'] = $this->input->post('create_formula_hidden_formula');
            $data['formula_title'] = $this->input->post('create_formula_formula');
            $duplicate = $this->result_formulamodel->check_formula_duplicate($data['class_id'], $data['subject_id'], $data['exam_id']);
            if(empty($duplicate)){    
                $add_formula = $this->result_formulamodel->add($data);            
                $this->session->set_flashdata('success',"The Formula has been updated successfully");
                redirect('result_formula');
            }else{
                $this->session->set_flashdata('error',"The Formula you are trying to create is already exist!");
                //redirect('result_formula/create_formula');
                redirect(base_url().'index.php/result_formula/create_formula?class='.$data['class_id'].'&subject='.$data['subject_id']);
            }
        } else {
            $class_tests = $this->publish_resultmodel->get_exam_types();
            $this->tpl->assign('tests', $class_tests);
            $classes = $this->result_formulamodel->get_classes();
            $this->tpl->assign('classes', $classes);
            $subjects = $this->result_formulamodel->get_subjects();
            $this->tpl->assign('subjects', $subjects);
        }
    }
    function edit($id = ''){
        if(empty($id))
            redirect ('result_formula');
        $info = $this->result_formulamodel->find_formula($id);
        $this->load->form('create_formula_form', NULL, $info);
        $this->tpl->assign('formula_data', $info);
        $class_tests = $this->publish_resultmodel->get_exam_types();
        $this->tpl->assign('tests', $class_tests);
//        $this->edit_data($this->config_exam_classform);
    }    
    function update(){
        $this->load->form('create_formula_form');
        $this->tpl->set_view('create_formula');
        $this->edit_data($this->create_formula_form);
    }
    function edit_data($form){
        $formula_id = $this->input->post('create_formula_id');
        if($form->validate()){
            $data['class_id'] = $this->input->post('create_formula_class_id');
            $data['exam_id'] = $this->input->post('create_formula_exam_id');
            $data['subject_id'] = $this->input->post('create_formula_subject_id');
            $data['formula'] = $this->input->post('create_formula_hidden_formula');
            $data['formula_title'] = $this->input->post('create_formula_formula');
            
            $edit_formula = $this->result_formulamodel->edit($formula_id, $data);
            if($edit_formula){
                $this->session->set_flashdata('success',"The Settings has been updated successfully");
                redirect('result_formula');
            }
        }else{
            $info = $this->result_formulamodel->find($formula_id);
            $this->tpl->assign('formula_data', $info);
            $class_tests = $this->publish_resultmodel->get_exam_types();
            $this->tpl->assign('tests', $class_tests);
        }
    }
    function del($id){
        $this->result_formulamodel->delete($id);
        $this->session->set_flashdata('success', 'The Formula has been deleted Successfully');
        redirect('result_formula');
    }
    function parse_formula() {
        $formula = $this->result_formulamodel->find(7); 
        $without_chars = preg_replace('/[^A-Za-z0-9\-]/', '', $formula['formula']);
        $formula_array = str_split($without_chars);
        print_r($formula_array);
        $whatIWant = substr($formula['formula'], strpos($formula['formula'], "d") + 1);    
        
        preg_match_all('#^.*\bline (\d+).*$#m', $formula['formula'], $matches, PREG_SET_ORDER);
        foreach($matches as $msg) {
            echo "message: " . $msg[0] . "\n";
            echo "line: " . $msg[1] . "\n";
        }
    }
    
//    public function check_redundancy(){
//        $class_id = $this->input->post('class_id');
//        $subject_id = $this->input->post('subject_id');
//        $duplicate = $this->result_formulamodel->check_formula_duplicate($class_id, $subject_id);
//        if(!empty($duplicate)){
//            $data['data_found'] = 'The Formula you are trying to create is already exist!';
//        }
//        else{
//            $data['not_found'] = 'No record Found.';
//        }        
//        echo json_encode($data); 
//    }
    
    public function navigate_result() {
        $this->load->form('navigate_resultform');
        $this->view_student($this->navigate_resultform);
    }
    public function view_student($form) {
        if($form->validate()){
            $this->tpl->set_view('view_student');
            $this->load->model('publish_resultmodel');
            $class_id = $this->input->post('navigate_resultform_class_id');
            $section_id = $this->input->post('navigate_resultform_section_id');
            $exam_id = $this->input->post('navigate_resultform_exam_id');
            $this->tpl->assign('exam_id', $exam_id);

            $this->tpl->set_css(array('jquery.loadmask'));
            $this->tpl->set_jquery_ui(array('dialog', 'position'));
            $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate', 'exam_registration'));
            $students = $this->result_formulamodel->students_by_section($class_id, $section_id);
            $this->tpl->assign('students', $students);
        }
    }
    public function popup_result($class_id, $student_id, $section_id, $exam_id) { 
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        $classes = $this->publish_resultmodel->get_classes();
        $this->tpl->assign('classes', $classes);
        
        
        $exams = $this->publish_resultmodel->get_exams();
        $this->tpl->assign('exams', $exams);        
        
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

        $total_student_no = $this->publish_resultmodel->get_student_no($class_id);
        $this->tpl->assign('total_students', $total_student_no['total_Students']);
        
        $result_scale = $this->publish_resultmodel->get_result_scale($class_id);
        $students_detail = $this->result_formulamodel->get_student_info($class_id, $exam_id, $student_id);
        $scale_matrix_list = $this->publish_resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
        $this->tpl->assign('scale_matrix_list', $scale_matrix_list);

        $asd = array();
        $data['student_name'] = $students_detail['first_name'].' '. $students_detail['last_name'];
        $data['class_roll'] = $students_detail['class_roll'];
        $data['section_title'] = $students_detail['section_title'];
        $data['student_id'] = $students_detail['student_id'];
        $data['class_name'] = $students_detail['class_name'];
        $data['house'] = $students_detail['house'];
        $data['class_id'] = $class_id;
        $data['exam_id'] = $exam_id;
        $data['student_number'] = $students_detail['student_number'];

        $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);

        $data['results'] = $rs['result'];
        $data['point'] = $rs['point'];
        $data['total_mks'] = $this->publish_resultmodel->get_total_exam_marks($class_id, $exam_id, $data['student_id']);

        $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);

        $asd[] = $data;
        
        
        $this->tpl->assign('results', $asd);
//        $this->tpl->assign('student_details', $students_details);
    }
    //Find total grades
    private function _get_scale_matrix($result_scale_id, $point){        
        $total_scale_matrix = $this->publish_resultmodel->get_scale_matrices($result_scale_id,$point);

        $data['weight'] = $point;
        $data['title'] = $total_scale_matrix;
        return $data;
    }    
	public function student_list() {
        $this->load->form('generate_grid_boardform');
        $this->generate_list($this->generate_grid_boardform);
    }
    function generate_list($form) {
        if($form->validate()){
            $this->tpl->set_view('generate_list');
            $class_id = $this->input->post('generate_grid_boardform_class_id');
            $section_id = $this->input->post('generate_grid_boardform_section_id');
            $exam_id = $this->input->post('generate_grid_boardform_exam_id');
            $subject_id = $this->input->post('generate_grid_boardform_subject_id');
            

            $students = $this->result_formulamodel->get_students_list($class_id, $section_id, $exam_id, $subject_id);
            $std = array();
            foreach ($students as $student){ 
                $student_name = $this->publish_resultmodel->get_student_name($student['student_id']);
                $section = $this->publish_resultmodel->get_section($student['student_id']);
                $student_number = $this->publish_resultmodel->get_student_number($student['student_id']);
                
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['class_roll'] = $section['class_roll']; 
                $data['student_number'] = $student_number['student_number'];
                $data['student_id'] = $student['student_id'];
                $std[] = $data;
            }
            
            $this->tpl->assign('students', $std);
            $entry_details = $this->publish_resultmodel->get_result_entry_details($class_id, $section_id, $subject_id);
            $this->tpl->assign('entry_details', $entry_details);
            $this->tpl->assign('class_id', $class_id);
            $this->tpl->assign('exam_id', $exam_id);
            $this->tpl->assign('section_id', $section_id);
            $this->tpl->assign('subject_id', $subject_id);
        }
    }
    function remove_subject_entry($class_id, $student_id, $section_id, $exam_id, $subject_id){
        $remove_subject = $this->result_formulamodel->remove_subject_entry($class_id, $student_id, $section_id, $exam_id, $subject_id);
        $this->session->set_flashdata('success', 'The Subject has been deleted Successfully');
        redirect(base_url().'index.php/result_formula/show_subject_entry?class_id='.$class_id.'&section_id='.$section_id.'&exam_id='.$exam_id.'&subject_id='.$subject_id);  
    }
    
    function show_subject_entry() {
        $this->tpl->set_view('generate_list');
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        $exam_id = $this->input->get('exam_id');
        $subject_id = $this->input->get('subject_id');
        
        $students = $this->result_formulamodel->get_students_list($class_id, $section_id, $exam_id, $subject_id);
            $std = array();
            foreach ($students as $student){ 
                $student_name = $this->publish_resultmodel->get_student_name($student['student_id']);
                $section = $this->publish_resultmodel->get_section($student['student_id']);
                $student_number = $this->publish_resultmodel->get_student_number($student['student_id']);
                
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['class_roll'] = $section['class_roll']; 
                $data['student_number'] = $student_number['student_number'];
                $data['student_id'] = $student['student_id'];
                $std[] = $data;
            }
            
            $this->tpl->assign('students', $std);
            $entry_details = $this->publish_resultmodel->get_result_entry_details($class_id, $section_id, $subject_id);
            $this->tpl->assign('entry_details', $entry_details);
            $this->tpl->assign('class_id', $class_id);
            $this->tpl->assign('exam_id', $exam_id);
            $this->tpl->assign('section_id', $section_id);
            $this->tpl->assign('subject_id', $subject_id);
        
    }   
	
}
