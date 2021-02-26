<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This class is for running cron job from cli
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 16, 2014
 */
class Attendance extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
		$this->load->filter('attendancefilter', 'attf');
		$this->init_grid();		
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Student Attendance List');
		$this->grid_board->set_filter($this->attf);
        $this->grid_board->add_link('Insert Student Attendance', site_url('attendance/create'), array('class' => 'add', 'id' => 'new_absent'));
        $grid_columns = array('id' => array('visible' => false), 'full_name' => 'Student Name','mobile'=>'Mobile','student_number' => 'Student Number', 'class' => 'Class', 'section' => 'Form', 'class_roll' => 'Class Roll',
             'date' => 'Date','attendance_status'=>'Status','created_at' => 'Create Date');
        $this->grid_board->set_column($grid_columns);
          $actions = array(            
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete absent record'),
        );
        $this->grid_board->set_action($actions);
        $params = array('count_method' => 'attendance_count', 'model' => 'attendancemodel', 'method' => 'info_query');
        $this->grid_board->render($params);
    }
	
	function filter() {
        $this->load->filter('attendancefilter', 'attf');
        $this->attf->execute();
        redirect('attendance/index');
    }
	
    function create() {
        $this->load->form('attendanceform');
    }

    function edit($id = '') {
        if (empty($id))
            redirect('attendance');
        $this->load->model('attendancemodel');
        $info = $this->attendancemodel->find($id);
        $this->load->form('attendanceform', null, $info);
        $this->process_form($this->attendanceform);
    }

    function view($id) {
        $this->load->model('attendancemodel');
        $info = $this->attendancemodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $labels = array('student_name' => 'Student Name','absent_date' => 'Absent Date', 'class' => 'Class', 'section' => 'Form',
              'class_roll' => 'Class Roll','remarks' => 'Remarks','created_by' => 'Created By', 'created_at' => 'Created at');
      
        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view', true);
    }

    public function save() {
        $this->load->model('attendancemodel');
        $this->load->model('sentmessagemodel');
		$class_id = $this->input->post('attendance_class_id');
		$section_id = $this->input->post('attendance_section_id');
                $student_id = $this->input->post('attendance_student_id'); 
                
                if(!empty($student_id['0'])){
                    $attendance_date = $this->input->post('attendance_adatepicker');
                    $check_attn = $this->attendancemodel->check_attendance($student_id['0'], $class_id, $section_id, $attendance_date);
                }
                if(isset($check_attn) && $check_attn > 0){
                    $this->session->set_flashdata('error', "The Record Already Exist.");
                    redirect('attendance/index');
                }else{
		$student_info = $this->attendancemodel->get_student_list($class_id,$section_id);         // get full message
		$data = array();
		$info =array();
		$i=0;
		foreach($student_info as $val){
			$data[$i]['student_id']= $val['student_id'];
			$data[$i]['date'] = $this->input->post('attendance_adatepicker');
			if(in_array($val['student_id'],$this->input->post('attendance_student_id')))
			{
				$data[$i]['attendance_status'] = 'Present';			
			}else{	
				$data[$i]['attendance_status'] = 'Absent';
				$info['student_id']= $val['student_id'];
				$info['created_at'] = date('Y-m-d h:i:s');
					
//				send sms
				$row = $this->sentmessagemodel->get_student_info($val['student_id']);
				$absentsms = $this->send_absent_sms($row);
				$info['status'] = $absentsms;
				$this->attendancemodel->abcent_info($info);
			}
			$data[$i]['created_at'] = date('Y-m-d h:i:s');
			$data[$i]['created_by'] = $this->session->userdata('user_id');
			$i++;
		}
            $this->attendancemodel->save_attendance($data);

            $this->session->set_flashdata('success', "Student attendance has been added successfully.");
            redirect('attendance/index');
        }
    }

    

    public function del($id) {
        $this->load->model('attendancemodel');
        $this->attendancemodel->delete($id);
        $this->session->set_flashdata('success', "Attendance record has been deleted successfully");
        redirect('attendance');
    }
	
	
	function get_student_list() {
        $this->load->model('attendancemodel');
        $class_id = $_POST['class_id'];
		$section_id = $_POST['section_id'];

        if ($class_id != '' AND $section_id !='') {
            $student_list = $this->attendancemodel->get_student_list($class_id,$section_id);         // get full message

            if (!empty($student_list)) {
                $this->html = '';
                $this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
						<table width="50%">
							<thead>
							<tr>
								<th><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
								<th style="width:300px !important;text-align:center !important;">Student Name</th>
								<th style="text-align:center !important;">Class Roll</th>
								<th>Student Number</th>
							</tr>	
							<thead>';
                foreach ($student_list as $val) {

                    $this->html .='<tr>
								<td align="center"><input type="checkbox" name="attendance_student_id[]" id="attendance_student_id" value="' . $val['student_id'] . '" required/></td>
								<td>' . $val['student_name'] . '</td>
								<td style="text-align:center !important;">' . $val['class_roll'] . '</td>
								<td align="center">' . $val['student_number'] . '</td>
							</tr>';
                }
                $this->html .='</table>
					</div>';
            } else {
                $this->html = 'Student not found.';
            }
        }

        $html = $this->html;
        return $this->output->set_output($html);
    }
    function send_absent_sms($row)
    {
        $gsm='880'.substr($row['mobile'],-10);
        $message='Dear guardian, your child '.$row['student_name'].' is absent today in the school.'.' Class:'.$row['class'].', Form:'.$row['section'].', Roll:'.$row['class_roll'].'. Headmaster, IMSN';
        $result = $this->send_sms($gsm,$message);
        if($result==1)
        {
                return 1;
        }else{
                return 0;
        }
    }
    public function find_attendance() {
        $this->load->form('student_attendanceform');
    }
    public function attendance_info(){
        $this->load->form('student_attendanceform');
        $this->tpl->set_view('find_attendance');
        $this->attendance_range($this->student_attendanceform);
    }
    public function attendance_range($form){
        if($form->validate()){
            $this->load->model('attendancemodel');
            $this->load->model('publish_resultmodel');

            $name = $this->input->post('stdattendance_full_name');
            $number = $this->input->post('stdattendance_student_number');
            $class_id = $this->input->post('stdattendance_class_id');
            $section_id = $this->input->post('stdattendance_section_id');
            $date_from = $this->input->post('stdattendance_date_from');
            $date_to = $this->input->post('stdattendance_date_to');
            $students = $this->attendancemodel->get_student_ids($class_id, $section_id, $name, $number);
            $info = array();        
            if(!empty($students)){
                foreach ($students as $student){
                    $present = $this->attendancemodel->range_present($student['id'], $date_from, $date_to);
//                    $absent = $this->attendancemodel->range_absent($student['id'], $date_from, $date_to);
                    $working_days = $this->attendancemodel->total_working_days($date_from, $date_to);

                    $data['student_name'] = $student['full_name'];
                    $data['section_title'] = $student['section'];                
                    $data['class_roll'] = $student['class_roll'];     
                    $data['class_name'] = $student['class'];    
                    $data['number'] = $student['student_number'];    
                    $data['present'] = $present;
                    $data['absent'] = $working_days - $present;
                    $data['working_days'] = $working_days;
                    $data['date_from'] = $date_from;
                    $data['date_to'] = $date_to;

                    $info[] = $data;
                }
            }
            $this->tpl->assign('stdinfo', $info);        
            $this->tpl->set_view('range_attendance');
            
        }
    }

}