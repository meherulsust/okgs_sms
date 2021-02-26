<?php

/* 
 * Created on 19-04-2016
 * Developed by: Arena Development Team
 * 
 */
class Tabulation extends BACKEND_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('tabulationmodel');
        $this->load->model('publish_resultmodel');
    }
    function index() {
    }
    function make_tabulation() {
        $this->tpl->set_view('make_tabulation');
        $this->load->form('tabulationform');
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->tabulation_sheet($this->tabulationform);
        }
    }
    function tabulation_sheet($form){
        if($form->validate()){         
            $class_id = $this->input->post('tabulation_class_id');
            $section_id = $this->input->post('tabulation_section_id');
            $exam_id = $this->input->post('tabulation_exam_id');
            $all_subjects = $this->tabulationmodel->get_subjects($class_id);
//            Setting Subjects
            foreach ($all_subjects as $sub){
                $configures = $this->publish_resultmodel->tabulation_view_exam_subjects($class_id, $exam_id, $sub['id']);

                $aa = str_replace(' ','', $configures['exam_type']);
                $ex_final = substr($aa, 0, -3);
                $exam_type = array_unique(explode(',', $aa));
                
//                echo '<pre>';
//                print_r($exam_type);
//                exit;
                
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

                $subject_data['subject'] = $sub['subject'];
                $subject_data['subject_id'] = $sub['id'];
                
                if(!empty($configures)){
                    $subjects = $exam_title;
                    $subjects = array_combine($fields, $fields);
//                    $subjects = $fields;
                    $exam_types = explode(',', $configures['exam_type']);
                    $this->tpl->assign('subjects', $subjects);
                    $this->tpl->assign('exam_types', $exam_type);       
                }
                $subject_data['exam_types'] = $subjects;
                $subject_info[] = $subject_data;
            }
            
            $this->tpl->assign('subjects', $subject_info);
            $this->tpl->assign('class_id', $class_id);
            
            //school and exam
            $this->load->model('schoolmodel');
            $school_info = $this->schoolmodel->find(1);	  // get school info
            $this->tpl->assign('school_info',$school_info);
            $exam = $this->tabulationmodel->get_exam_title($exam_id);
            $this->tpl->assign('exam', $exam['title']);
            
            $students_details = $this->tabulationmodel->get_tabulation_ids($class_id, $exam_id, $section_id);
            
            $info = array();
            foreach ($students_details as $students_detail){ 
                $student_name = $this->publish_resultmodel->get_student_name($students_detail['student_id']);
                $roll = $this->tabulationmodel->get_roll($students_detail['student_id']);
                $class_title = $this->publish_resultmodel->get_class_title($class_id);
                $total_mks = $this->tabulationmodel->get_total_exam_marks($class_id, $exam_id, $students_detail['student_id']);
                $position = $this->tabulationmodel->get_position($students_detail['student_id']);
                
                if(isset($section_id) && $section_id > 0){
                $section = $this->tabulationmodel->get_section($section_id);
                $data['section_title'] = $section['section'];                
                }
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['class_roll'] = $roll['class_roll'];                
                $data['class_name'] = $class_title['title'];
                $data['total_mks_half_yearly'] = $total_mks['total_mks_half_yearly'];
                $data['position'] = $position['position'];
                
                $data['results'] = $this->tabulationmodel->get_result($students_detail['student_id'], $class_id, $section_id, $exam_id);
                
                $result_scale = $this->publish_resultmodel->get_result_scale($class_id);
                $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
                $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $rs['point']);
                $info[] = $data;
            }
            $class_details = array('class_id' => $class_id, 'section_id' => $section_id, 'exam_id' => $exam_id);
            $this->tpl->assign('class_details', $class_details);
            
            $this->tpl->set_view('tabulation_sheet');
            $this->tpl->assign('results', $info);            
        }
    }
    private function _get_scale_matrix($result_scale_id, $point){
            //Find total Marks and grades
            $total_scale_matrix = $this->publish_resultmodel->get_scale_matrices($result_scale_id,$point);

            $data['weight'] = $point;
            $data['title'] = $total_scale_matrix;
            return $data;
    }
    function updatesections() {
        $student_without_sections = $this->tabulationmodel->fetch_stduents_withoutsecs();
        foreach ($student_without_sections as $val){
            $section = $this->tabulationmodel->getstudent_sections($val['student_id']);

            $update = $this->tabulationmodel->update_studentwithout_sec($val['student_id'], $section['section_id']);
        }
        echo 'update done';
    }
    public function download_tabulationsheet() {
        $this->tpl->set_layout('ajax_layout');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $exam_id = $this->input->post('exam_id');
        $all_subjects = $this->tabulationmodel->get_subjects($class_id);
//            Setting Subjects
        foreach ($all_subjects as $sub){
            $configures = $this->publish_resultmodel->tabulation_view_exam_subjects($class_id, $exam_id, $sub['id']);

            $aa = str_replace(' ','', $configures['exam_type']);
            $ex_final = substr($aa, 0, -3);
            $exam_type = array_unique(explode(',', $aa));

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

            $subject_data['subject'] = $sub['subject'];
            $subject_data['subject_id'] = $sub['id'];

            if(!empty($configures)){
                $subjects = $exam_title;
                $subjects = array_combine($fields, $fields);
//                    $subjects = $fields;
                $exam_types = explode(',', $configures['exam_type']);
                $this->tpl->assign('subjects', $subjects);
                $this->tpl->assign('exam_types', $exam_type);       
            }
            $subject_data['exam_types'] = $subjects;
            $subject_info[] = $subject_data;
        }

        $this->tpl->assign('subjects', $subject_info);
        $this->tpl->assign('class_id', $class_id);

        //school and exam
        $this->load->model('schoolmodel');
        $school_info = $this->schoolmodel->find(1);	  // get school info
        $this->tpl->assign('school_info',$school_info);
        $exam = $this->tabulationmodel->get_exam_title($exam_id);
        $this->tpl->assign('exam', $exam['title']);

        $students_details = $this->tabulationmodel->get_tabulation_ids($class_id, $exam_id, $section_id);

        $info = array();
        foreach ($students_details as $students_detail){ 
            $student_name = $this->publish_resultmodel->get_student_name($students_detail['student_id']);
            $roll = $this->tabulationmodel->get_roll($students_detail['student_id']);
            $class_title = $this->publish_resultmodel->get_class_title($class_id);
            $total_mks = $this->tabulationmodel->get_total_exam_marks($class_id, $exam_id, $students_detail['student_id']);
            $position = $this->tabulationmodel->get_position($students_detail['student_id']);

            if(isset($section_id) && $section_id > 0){
            $section = $this->tabulationmodel->get_section($section_id);
            $data['section_title'] = $section['section'];                
            }
            $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
            $data['class_roll'] = $roll['class_roll'];                
            $data['class_name'] = $class_title['title'];
            $data['total_mks_half_yearly'] = $total_mks['total_mks_half_yearly'];
            $data['position'] = $position['position'];

            $data['results'] = $this->tabulationmodel->get_result($students_detail['student_id'], $class_id, $section_id, $exam_id);

            $result_scale = $this->publish_resultmodel->get_result_scale($class_id);
            $rs = $this->publish_resultmodel->get_entire_class_result($class_id, $exam_id, $students_detail['student_id'], $result_scale['result_scale_id']);
            $data['scale_matrix'] = $this->_get_scale_matrix($result_scale['result_scale_id'], $rs['point']);
            $info[] = $data;
        }
        $tabulation_file_name = 'tabulation_sheet' . date('Y-m-d') . '.xls';
        $this->tpl->assign('tabulationsheet_filename', $tabulation_file_name);
        $this->tpl->assign('results', $info);   
    }
}