<?php
/*
 * Created on Feb 16, 2016
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Result extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('resultmodel');
    }

  	function index()
	{	
            $this->load->model('studentvmodel');
            $student_number = $this->auth->get_user()->student_number;
            $row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
//            print_r($row);
            $this->tpl->assign($row);
            $data['class_id'] = $row['class_id'];
            $data['student_id'] = $row['id'];
            $data['section_id'] = $row['section_id'];
            $this->tpl->assign('info', $data);
            
            $exams = $this->studentvmodel->get_exams();
            $this->tpl->assign('exams',$exams);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                $exam_id = $this->input->post('exam_id');
                $this->tpl->assign('exam_id', $exam_id);
//                $check_publish = $this->studentvmodel->check_publish($class_id, $exam_id);
                $check_class_publish = $this->studentvmodel->check_class_publish($class_id);
                $check_exam_publish = $this->studentvmodel->check_exam_publish($exam_id);
                
                if(!empty($check_class_publish) && !empty($check_exam_publish)) { 
                    $this->tpl->set_view('popup_result');
                    $this->popup_result($class_id, $student_id, $section_id, $exam_id);
                }else{
                    $no_result = 'Result not yet published!';
                    $this->tpl->assign('no_result', $no_result);
                }
            }
	}
	function exam_result()
	{		
            $this->tpl->set_layout(false);
            $this->load->model('studentvmodel');
            $student_id = $this->auth->get_user()->id;
            $exam_id     = $this->input->post('exam_id');
            echo $url = file_get_contents("http://bv.rajcpsc.edu.bd/smsadmin/index.php/exam/progress_report_by_student_id/$exam_id/$student_id");exit();
	}
    public function popup_result($class_id, $student_id, $section_id, $exam_id) { 
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);	  // get school info
        $this->tpl->assign('school_info',$school_info);
        $classes = $this->studentvmodel->get_class();
        $this->tpl->assign('classes', $classes);
        $exams = $this->studentvmodel->get_exams();
        $this->tpl->assign('exams', $exams);
        
        $max_total = $this->resultmodel->get_height_total($class_id, $exam_id, $section_id);
        if(!empty($max_total)){
            $this->tpl->assign('max_total', $max_total['max_total']);
        }
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
//        $students_detail = $this->studentvmodel->get_student_id($class_id, $exam_id, $section_id);
        
        $scale_matrix_list = $this->resultmodel->get_scale_matrix_list($result_scale['result_scale_id']);
        $this->tpl->assign('scale_matrix_list', $scale_matrix_list);
        
        if(!empty($student_id)){
            $asd = array();
            $student_name = $this->resultmodel->get_student_name($student_id);
            $section = $this->resultmodel->get_section($student_id);
            $class_title = $this->resultmodel->get_class_title($class_id);
            $student_house = $this->resultmodel->get_house($student_id);
            $student_number = $this->resultmodel->get_student_number($student_id);

            $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
            $data['section_title'] = $section['section'];                
            $data['class_roll'] = $section['class_roll'];                
            $data['student_id'] = $student_id;
            $data['class_name'] = $class_title['title'];                
            if(!empty($student_house)){
                $data['house'] = $student_house['title'];
            }
            $data['class_id'] = $class_id;
            $data['exam_id'] = $exam_id;
            $data['student_number'] = $student_number['student_number'];
                        
            $rs = $this->resultmodel->get_entire_class_result($class_id, $exam_id, $student_id, $result_scale['result_scale_id']);
            
            $data['results'] = $rs['result'];
            $data['point'] = $rs['point'];
            $data['total_mks'] = $this->resultmodel->get_total_exam_marks($class_id, $exam_id, $student_id);

            $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $data['point']);
            $asd[] = $data;
            
            $current_exam = $this->resultmodel->current_exam($exam_id);
            $this->tpl->assign('current_exam', $current_exam['title']);
            if($rs != FALSE){
                $this->tpl->assign('results', $asd);
            }
        }
    }
    //Find total grades
    private function _get_scale_matrix($result_scale_id, $point){
        $total_scale_matrix = $this->resultmodel->get_scale_matrices($result_scale_id,$point);
        $data['weight'] = $point;
        $data['title'] = $total_scale_matrix;
        return $data;
    }
 }