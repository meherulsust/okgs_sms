<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 06, 2012
 */
class Exam extends BACKEND_Controller {

    function __construct() {
        $this->set_ignore_auth('exam'); 
		parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Exam list');
        $this->grid_board->add_link('Create New Exam', site_url('exam/create'), array('class' => 'add', 'id' => 'new_exam'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Exam Name', 'fee' => 'Exam Fee','exam_session'=>'Exam Session',
            'start_date' => array('title' => 'Start Date', 'date' => true),
            'end_date' => array('title' => 'End Date', 'date' => true),
            'status' => array('title' => 'Status', 'status' => 'status'),
            'created_at' => array('title' => 'Create Date', 'datetime' => true));
         $actions = array(
            'view' => array('title' => 'View', 'action' => 'view', 'controller' => '', 'tips' => 'View details of this exam'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit this exam'),
           // 'clstest' => array('title' => 'Create Class Test', 'action' => 'index', 'controller' => 'classtest', 'tips' => 'Create class test for this exam'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete this exam'),
        );
        $this->grid_board->set_action($actions);
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('exammodel');
    }

    function create() {
        $this->load->form('examform');
    }

    function save() {
        $this->load->form('examform');
        $this->process_form($this->examform);
        $this->create();
        $this->tpl->set_view('create');
    }

    function edit($id = '') {
        $this->load->model('exammodel');
        $info = $this->exammodel->find($id);
        $this->load->model('examsylabusmodel', 'esm');
        if (empty($info)) {
            show_404();
        }
        $temp_date = DateTime::createFromFormat('Y-m-d', $info['start_date']);
        $info['sdatepicker'] = $temp_date->format('d F, Y');
        $temp_date = DateTime::createFromFormat('Y-m-d', $info['end_date']);
        $info['edatepicker'] = $temp_date->format('d F, Y');
        unset($temp_date);
        $info['sylabus_id[]'] = $this->esm->get_field('sylabus_id', array('exam_id' => $id));
        $this->load->form('examform', null, $info);
        $this->process_form($this->examform);
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Exam has been created successfully");
            else
                $this->session->set_flashdata('success', "Exam has been updated successfully");
            redirect('exam/index');
        }
    }

    public function del($id) {
        $this->load->model('exammodel');
        $info = $this->exammodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->exammodel->delete($id);
        $this->session->set_flashdata('success', "Exam has been deleted successfully");
        redirect('exam/index');
    }

    public function view($id = '') {
        $this->load->model('exammodel');
        $info = $this->exammodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->tpl->set_jquery_ui(array('dialog', 'position'));
        $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate', 'exam_registration'));
        $this->load->helper('date');
        $this->tpl->assign($info);
        $this->init_registration_grid($id);
    }

    function status($id,$stat) {
        $this->load->model('exammodel');
        $row = $this->exammodel->find($id);
        if (empty($row)) {
            show_404();
        }
        $this->exammodel->update_status($stat,$id);
        $this->session->set_flashdata('success', "Exam status has been changed successfully.");
        redirect('exam/index');
    }

    protected function init_registration_grid($eid) {
        $this->load->library('grid_board');
        $this->grid_board->set_param('exam_id', $eid);
        $this->grid_board->add_link('Register New Student', site_url('exam/newregi/' . $eid), array('class' => 'add', 'id' => 'new_regi'));
        $this->grid_board->set_title('Registered student list');
		$grid_all_actions = $this->config->item('grid_all_actions');
        $grid_all_actions['view_details'] = array();
        $this->config->set_item('grid_all_actions', $grid_all_actions);
        $actions = array(
           //'view_details' => array('title' => 'Download', 'action' => 'downlaod_transcript', 'controller' => '', 'tips' => 'Download Transcript'),
			'view' => array('title' => 'View', 'action' => 'regiview', 'controller' => '', 'tips' => 'View details of this scale'),
            'edit' => array('title' => 'Edit', 'action' => 'regiedit', 'controller' => '', 'tips' => 'Edit this scale'),
            'marks' => array('title' => 'Assign Marks', 'action' => 'marks', 'controller' => '', 'tips' => 'Assign exam marks'),
            'result' => array('title' => 'Show result', 'action' => 'result', 'controller' => '', 'tips' => 'Show result'),
            'transcript' => array('title' => 'Transcript', 'action' => 'transcript', 'controller' => '', 'tips' => 'Show transcript'),
            'del' => array('title' => 'Delete', 'action' => 'regidel', 'controller' => '', 'tips' => 'Delete this record'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'student' => 'Student', 'fee_received' => 'Fee Received', 'status' => array('title' => 'Status', 'status' => 'exam/registat'), 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('examregistrationmodel');
    }

    function register($id) {
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->model('examregistrationmodel', 'ermodel');
        $reg_num = $this->ermodel->count(array('exam_id' => $id));
        if ($reg_num > 0) {
            $response['message'] = "Students have already been registered for this exam.";
            $response['success'] = 0;
        } else {
            $this->ermodel->register_student($id);
            $this->session->set_flashdata('success', "All students has been successfuly registered for this exam.");
            $response['redirect'] = site_url('exam/view/' . $id);
        }
        $this->output->set_output(json_encode($response));
    }

    public function newregi($exam_id) {
        $this->load->model('exammodel');
        $exam_fee = $this->exammodel->find_one_by_pk('fee', $exam_id);
        $info = array('exam_id' => $exam_id, 'fee_received' => $exam_fee);
        $this->tpl->assign('exam_id', $exam_id);
        $this->load->form('registrationform', 'regiform', $info);
    }

    function regiedit($id) {
        $this->load->model('examregistrationmodel', 'ermodel');
        $info = $this->ermodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $edit_info['id'] = $info['id'];
        $edit_info['description'] = $info['description'];
        $edit_info['status'] = $info['status'];
        $edit_info['fee_received'] = $info['fee_received'];
        $edit_info['exam_id'] = $info['exam_id'];
        $this->tpl->assign('exam_id', $info['exam_id']);
        $this->load->form('registrationform', 'regiform', $edit_info);
        $this->tpl->set_view('newregi');
    }

    public function saveregi($exam_id) {
        $this->load->form('registrationform', 'regiform', array('exam_id' => $exam_id));
        if ($this->regiform->validate()) {
            $this->regiform->save();
            if ($this->regiform->is_new()) {
                $this->session->set_flashdata('success', "Selected student has been registered successfully.");
            } else {
                $this->session->set_flashdata('success', "Registration has been updated successfully.");
            }
        } else {
            $this->session->set_flashdata('error', "One or more required field is missing.");
        }
        redirect('exam/view/' . $exam_id);
    }

    public function regidel($id) {
        $this->load->model('examregistrationmodel', 'ermodel');
        $info = $this->ermodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->ermodel->delete($id);
        $this->session->set_flashdata('success', "Registration has been deleted sucessfully.");
        redirect('exam/view/' . $info['exam_id']);
    }

    public function registat($id, $stat) {
        $this->load->model('examregistrationmodel', 'ermodel');
        $info = $this->ermodel->find($id);
        if (empty($info) || empty($stat)) {
            show_404();
        }
        $this->ermodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Registration status been changed sucessfully.");
        redirect('exam/view/' . $info['exam_id']);
    }

    public function regiview($id) {
        $this->load->model('examregistrationmodel', 'ermodel');
        $info = $this->ermodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper(array('date'));
        $labels = array('student' => 'Student Name', 'sylabus' => 'Exam Sylabus', 'fee_received' => 'Exam Fee', 'description' => 'Description', 'status' => 'status', 'created_at' => 'Created At', 'updated_at' => 'Updated At'
            , 'created_by' => 'Created By');
        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view.php', true);
    }

    public function marks($reg_id) {
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $marks = $this->erdmodel->find_by('exam_registration_id', $reg_id);
        //in case of edit
        if ($marks) {
            $marks = array_assoc_by_key($marks, 'course_sylabus_evaluation_type_id');
        }
        $this->tpl->assign('marks_saved', $marks);
        $this->load->model('examregistrationmodel', 'ermodel');
        $rs = $this->ermodel->get_course_details($reg_id);
        $rs = array_group_by_key($rs, 'course_id');
        $this->tpl->assign('reg_id', $reg_id);
        $this->tpl->assign('course_details', $rs);
    }

    public function savemarks() {
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $this->erdmodel->save($_POST);
        $this->session->set_flashdata('success', "Exam marks have been saved sucessfully.");
        $this->load->model('examregistrationmodel', 'ermodel');
        $exam_id = $this->ermodel->find_one_by_pk('exam_id', $this->input->post('reg_id'));
        redirect('exam/view/' . $exam_id);
    }

    public function result($reg_id) {
        $this->load->model('examresultdetailsmodel', 'erdmodel');
		$this->load->model('examregistrationmodel','erm');  
        $num = $this->erdmodel->count(array('exam_registration_id' => $reg_id));
        $this->load->model('examresultmodel', 'ermodel');
        $exam_result_num = $this->ermodel->count(array('exam_registration_id' => $reg_id));
		$this->tpl->assign('exam_result_num', $exam_result_num);
        $this->tpl->assign('result_exists', true);
        $this->tpl->assign('reg_id', $reg_id);
        if ($num == 0) {
            $this->tpl->assign('result_exists', false);
        } else {
			$regi_info = $this->erm->get_registration_info($reg_id);
            $results = $this->erdmodel->get_result($reg_id);
            $final_result = $this->erdmodel->get_final_result();
            $this->tpl->assign('results', $results);
            $this->tpl->assign('regi_info', $regi_info);
            $this->tpl->assign('final_result', $final_result);
            switch ($final_result['scale_code']) {
                case 'DIVISION':
                    $this->tpl->set_view('division_result');
                    break;
            }
        }
    }

    public function promote($reg_id) {
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->model('examregistrationmodel', 'ermodel');
        $reg_num = $this->ermodel->count(array('exam_id' => $id));
        if ($reg_num > 0) {
            $response['message'] = "Students have already been registered for this exam.";
            $response['success'] = 0;
        } else {
            $this->ermodel->register_student($id);
            $this->session->set_flashdata('success', "All students has been successfuly registered for this exam.");
            $response['redirect'] = site_url('exam/view/' . $id);
        }
        $this->output->set_output(json_encode($response));
    }
	
    public function transcript($reg_id) {
        $this->load->helper('date');
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $num = $this->erdmodel->count(array('exam_registration_id' => $reg_id));
        if($num>1){
            $this->load->model('resultscalemodel','rsm');
            $this->load->model('examregistrationmodel','erm');
            $regi_info = $this->erm->get_registration_info($reg_id);
			$regi_info['htmark'] = $this->erm->get_exam_height_marks($regi_info['exam_id']);
            $this->load->model('schoolmodel');
            $school_info = $this->schoolmodel->find(1); 
            $this->tpl->assign('school_info',$school_info);
            $this->tpl->assign('regi_info',$regi_info);
            $results = $this->erdmodel->get_result($reg_id); 
            $final_result = $this->erdmodel->get_final_result();
            $this->tpl->assign('results', $results);
            $this->tpl->assign('final_result', $final_result);
            $rm = $this->rsm->get_matrix_by_scale($final_result['result_scale_id']);
            $this->tpl->assign('result_matrix',$rm);
        }else{
            die('No marks is found. Please insert marks frist');
        }
        $this->tpl->set_layout(false);
       
    }
	
	/* for downlaoding  progress report looping */
	
	function genarate_progress_report(){
		$this->tpl->set_jquery_ui();
        $this->tpl->set_js('select-chain');
		$this->load->form('genarate_progress_report_form','gprf');
		if($this->gprf->validate())
		{
			$data['class_id']= $this->input->post('progress_report_class_id');
			$data['exam_id'] = $this->input->post('progress_report_exam_id');
			$this->load->model('examresultdetailsmodel', 'erdmodel');
			$std_info = $this->erdmodel->all_students_result_info($data['exam_id']);
			$html ='';
			$i=1;
			if($std_info){
				foreach($std_info as $val){
					echo $html .= $this->downlaod_transcript($val->id);
					echo"<div style='page-break-after:always'>";
				}
				exit();
				/* $aa = $html;
				
				$pdfFilePath = "Transcript" . '_' . rand(100, 999) . '_' . date('Y-m-d') . '.pdf';
				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$pdf->WriteHTML($aa);
				$pdf->Output($pdfFilePath, "D"); */
				
			}
			else{
					$this->session->set_flashdata('error',"No Progress Report Found!.");
					redirect('exam/genarate_progress_report');	
				}
		}
	}
	
	public function downlaod_transcript($reg_id) {
		$this->load->helper('date');
        $this->load->model('examresultdetailsmodel', 'erdmodel');
        $num = $this->erdmodel->count(array('exam_registration_id' => $reg_id));
        if($num>1){
            $this->load->model('resultscalemodel','rsm');
            $this->load->model('examregistrationmodel','erm');
            $regi_info = $this->erm->get_registration_info($reg_id);
			$regi_info['htmark'] = $this->erm->get_exam_height_marks($regi_info['exam_id']);
            $this->load->model('schoolmodel');
            $school_info = $this->schoolmodel->find(1); 
            $this->tpl->assign('school_info',$school_info);
            $this->tpl->assign('regi_info',$regi_info);
            $results = $this->erdmodel->get_result($reg_id);
            $final_result = $this->erdmodel->get_final_result();
            $this->tpl->assign('results', $results);
            $this->tpl->assign('final_result', $final_result);
            $rm = $this->rsm->get_matrix_by_scale($final_result['result_scale_id']);
            $this->tpl->assign('result_matrix',$rm);
			$this->tpl->set_layout(false);	
			$html=$this->load->view('exam/transcript_loop_tpl.php',$this->tpl->_template_var,true);//making view for pdf
			return $html;
        }else{
            echo 'No marks is found. Please insert marks frist';
        }
        
        /* $pdfFilePath = "Transcript" . '_' . rand(100, 999) . '_' . date('Y-m-d') . '.pdf';
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "D"); */
	}
	
	/* end for downlaoding  progress report looping */
	
	//showing  result inito student panel
	function progress_report_by_student_id($exam_id=null,$student_id=null)
	{
		$this->load->model('examresultdetailsmodel', 'erdmodel');
		$std = $this->erdmodel->student_result_info($student_id,$exam_id);
		@$reg_id = $std[0]['id'];
		if($reg_id){
			echo $this->downlaod_transcript($reg_id);exit();
		}else
		{
			echo"<h2 style='color:red; text-align:center;'>No Result Found!</h2>";exit();
		}	
	}
	
	function genarate_progress_report_tp($exam_id=null){
			$html ='';
			$this->load->model('examresultdetailsmodel', 'erdmodel');
			@$std_info = $this->erdmodel->all_students_result_info($exam_id);
			if($std_info){
				foreach($std_info as $val){
					echo $html .= $this->downlaod_transcript($val->id);
					echo"<div style='page-break-after:always'>";
				}exit();
				
			}else{
				 echo"<h2 style='color:red; text-align:center;'>No Result Found!</h2>";exit();	
				}
		}
	
	
	
}