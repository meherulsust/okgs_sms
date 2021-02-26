<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class Student_house extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->load->filter('student_house_filter', 'shf');
        $this->init_student_grid();
    }

    protected function init_student_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Student list');
        $this->grid_board->set_filter($this->shf);
        $this->grid_board->add_link('Add New Student into House', site_url('student_house/create'), array('class' => 'add', 'id' => 'new_student'));
        $grid_columns = array('id' => array('visible' => false), 'full_name' => 'Student', 'student_number' => 'Student Number', 'class' => 'Class', 'section' => 'Form', 'class_roll' => 'Class Roll','house_name' => 'House',
            'create_date' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete student'),
        );
        $this->grid_board->set_action($actions);
        //$this->grid_board->render('studenthousemodel');
		$params = array('count_method' => 'student_count', 'model' => 'studenthousemodel', 'method' => 'student_list');
        $this->grid_board->render($params);
    }

    function filter() {
        $this->load->filter('student_house_filter', 'shf');
        $this->shf->execute();
        redirect('student_house/index');
    }

	
    function create() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'student_house_form'));
        $this->load->form('studenthouseform');
    }

    public function save() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'student_house_form'));
        $this->load->form('studenthouseform');
        $this->tpl->set_view('send_sms');
        $error=0;
		foreach ($this->input->post('student_id') as $lm => $val) {
			$student_number = $val;
			$count=$this->studenthousemodel->count_student($val); 
			if($count >0){
				$error=1;
				break;	
			}
		}
        
		if($error>0)
		{
			$this->load->model('studentmodel');
			$info=$this->studentmodel->find($student_number); 
			$this->session->set_flashdata('error', "Student number ".$info['student_number']." is already exits.");
			redirect('student_house/create');
		}else{
			foreach ($this->input->post('student_id') as $lm => $val) {
				$data['house_id'] = $this->input->post('student_house_house_id');
				$data['student_id'] = $val;
				//$data['create_date'] = date('Y-m-d h:i:s');
				$this->studenthousemodel->add_student($data);         // add student
			}
			$this->session->set_flashdata('success', "Student has been added successfully.");
			redirect('student_house/index');			
		}
    }

    
    public function del($id) {
        if (empty($id))
            redirect('student_house/index');

        $this->load->model('studenthousemodel');
        $this->studenthousemodel->delete($id);
        $this->session->set_flashdata('success', "Student has been deleted successfully.");
        redirect('student_house/index');
    }

    function get_student_list() {
        $this->load->model('studenthousemodel');
        $house_id = $_POST['house_id'];
		$class_id = $_POST['class_id'];
		$section_id = $_POST['section_id'];

        if ($class_id != '' AND $section_id !='') {
            $student_list = $this->studenthousemodel->get_student_list($house_id,$class_id,$section_id);         // get full message

            if (!empty($student_list)) {
                $this->html = '';
                $this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
						<table width="50%">
							<thead>
							<tr>
								<th style="width:20px !important;"><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
								<th style="width:300px !important;text-align:center !important;">Student Name</th>
								<th style="text-align:center !important;">Class Roll</th>
								<th>Student Number</th>
							</tr>	
							<thead>';
                foreach ($student_list as $val) {

                    $this->html .='<tr>
								<td align="center"><input type="checkbox" name="student_id[]" id="student_id" value="' . $val['student_id'] . '"/></td>
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
	
	
	function student_house_transfer()
	{
        $this->tpl->set_js(array('select-chain','jquery.validate', 'house_transfer_form'));
        $this->load->form('housetransferform');
    }
	
	function update_student_house()
	{
		$this->load->model('studenthousemodel');
		foreach ($this->input->post('student_id') as $lm => $val) {
			$data['house_id'] = $this->input->post('house_transfer_transfer_house_id');
			$data['update_date'] = date('Y-m-d h:i:s');
			$this->studenthousemodel->update_student_house($val,$data);         // add student
		}
		$this->session->set_flashdata('success', "Student has been transferred successfully.");
		redirect('student_house/index');
	}
	

}