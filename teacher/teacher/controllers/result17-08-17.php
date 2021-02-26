<?php
/*
 * Created on Feb 17, 2016
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Result extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
		$this->tpl->set_js('select-chain');
		$this->load->model('teachermodel');
		$this->load->model('resultmodel');
    }

  	function index()
	{		
            $this->load->model('teachermodel');
            $get_class = $this->teachermodel->get_class();
            $this->tpl->assign('get_class',$get_class);
            $exams = $this->teachermodel->get_exams();
            $this->tpl->assign('exams',$exams);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $exam_id = $this->input->post('exam_id');
                $this->tpl->assign('exam_id', $exam_id);
                $this->tpl->assign('class_id', $class_id);
                $this->tpl->assign('section_id', $section_id);
                $check_publish = $this->teachermodel->check_publish($class_id, $exam_id);
                $sections = $this->teachermodel->get_sections($class_id);
                $this->tpl->assign('sections', $sections);
                if($check_publish == TRUE) {
                    $students = $this->teachermodel->students_by_section($class_id, $section_id);
                    $this->tpl->assign('students', $students);
                
                }else{
                    $no_result = 'Result not yet published!';
                    $this->tpl->assign('no_result', $no_result);
                }
            }
		
	} 

	public function exam_list() 
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teachermodel');
		$class_id = $this->input->post('class_id');	
		$rs=array(array('id'=>'','title'=>'Select Exam'));	
		$get_exam = array_merge($rs,$this->teachermodel->get_exam_list($class_id));
        $this->output->set_output(json_encode($get_exam)); 
    }
	
	function exam_result()
	{		
		$this->tpl->set_layout(false);
		$exam_id     = $this->input->post('exam_id');
		echo $url = file_get_contents("http://bv.rajcpsc.edu.bd/smsadmin/index.php/exam/genarate_progress_report_tp/$exam_id");exit();
	}  	
		
    public function popup_result($class_id, $student_id, $section_id, $exam_id) {
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);
        
        $max_total = $this->resultmodel->get_height_total($class_id, $exam_id, $section_id);
        $this->tpl->assign('max_total', $max_total['max_total']);
        $configures = $this->resultmodel->get_view_exam_subjects($class_id, $exam_id);
        
        $aa = str_replace(' ','', $configures['exam_type']);
        $ex_final = substr($aa, 0, -3);
        $exam_type = array_unique(explode(',', $ex_final));
        $subjective = 0;
        $ct = 0;
        foreach($exam_type as $key=>$val)
        {
            $row = $this->resultmodel->get_exam_type_details($val);
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

        $result_scale = $this->resultmodel->get_result_scale($class_id);
        $students_detail = $this->resultmodel->get_student_info($class_id, $exam_id, $student_id);
        $scale_matrix_list = $this->resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
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

        $rs = $this->resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
        $data['results'] = $rs['result'];
        $data['point'] = $rs['point'];
        $data['total_mks'] = $this->resultmodel->get_total_exam_marks($class_id, $exam_id, $data['student_id']);

        $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);

        $asd[] = $data;
        $this->tpl->assign('results', $asd);
        $current_exam = $this->resultmodel->current_exam($exam_id);
        $this->tpl->assign('current_exam', $current_exam['title']);
    }
    //Find total grades
    private function _get_scale_matrix($result_scale_id, $point){
        $total_scale_matrix = $this->resultmodel->get_scale_matrices($result_scale_id,$point);
        $data['weight'] = $point;
        $data['title'] = $total_scale_matrix;
        return $data;
    }
 }