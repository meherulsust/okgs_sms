<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Imrul Hasan
 * @ Created     September 22, 2014
 */
class Class_routine extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->tpl->set_page_title('Class Routine');
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $grid_columns = array('id' => array('visible' => false), 'class' => 'Class', 'section' => 'Form', 'subject' => 'Subject','teacher_name' => 'Teacher','class_day' => 'Day','class_time' => 'Time',
            'status' => array('title' => 'Status', 'status' => 'status'));
        $this->grid_board->set_column($grid_columns);
		$actions = array(
						'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit'),
  						'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete'),
  						);
		$this->grid_board->set_action($actions);
        $this->grid_board->render('classroutinemodel');
    }

    function create() {
        $this->load->form('classroutineform', 'crform');
        $this->tpl->set_js(array('jquery.validate','select-chain'));
    }
	
	function save() {
        
		$this->load->form('classroutineform', 'crform');
        $this->tpl->set_js(array('jquery.validate','select-chain'));
        $this->process_form($this->crform);
        $this->tpl->set_view('create');
    }

    public function edit($id) {
        $this->tpl->set_js(array('jquery.validate','select-chain'));
		if (empty($id))
            redirect('class_routine');
        $this->load->model('classroutinemodel');
        $info = $this->classroutinemodel->find($id);
        $this->load->form('classroutineform', 'crform', $info);
    }

    protected function process_form($form) {
        if ($form->validate()) {            
			$id = $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Class routine has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Class routine has been edited successfully");
            }
            redirect('class_routine');
        }
    }
	
	function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('class_routine');
        $this->load->model('classroutinemodel');
        $this->classroutinemodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Class routine status has been changed successfully");
        redirect('class_routine');
    }
	
	
	public function del($id) {
        if (empty($id))
            redirect('class_routine');

        $this->load->model('classroutinemodel');
        $this->classroutinemodel->delete($id);
        $this->session->set_flashdata('success', "Class routine has been deleted successfully");
        redirect('class_routine');
    }
    
	/* function duplicate_class_routine_check($str,$param='')
	{
		$class_id = $this->crform->get_value('class_id');
		$section_id = $this->crform->get_value('section_id');
		$class_day_id = $this->crform->get_value('class_day_id');
				
		$query = $this->db->query("SELECT id FROM sms_class_routine where class_id='$class_id' AND section_id=$section_id AND class_day_id=$class_day_id AND class_time_id=$str AND class_time_id<>'$str'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_class_routine_check', "These setting already exists.");
		 	return false;
		}
		return true; 
	}	 */
	
	
	function class_time_list() {
        $this->init_class_time_grid();
    }

    protected function init_class_time_grid() {
        $this->load->library('grid_board');
		$this->grid_board->add_link('Add Class Time', site_url('class_routine/create_class_time'), array('class' => 'add'));
        $grid_columns = array('id' => array('visible' => false), 'class' => 'Class','title' => 'Class Time', 'serial' => 'Serial No.','status' => array('title' => 'Status', 'status' => 'class_time_status'));
        $this->grid_board->set_column($grid_columns);
		$actions = array(
						'edit'=>array('title'=>'Edit','action'=>'edit_class_time','controller'=>'','tips'=>'Edit'),
  						'del'=>array('title'=>'Delete','action'=>'del_time','controller'=>'','tips'=>'Delete'),
						);
		$this->grid_board->set_action($actions);
        $this->grid_board->render('classtimemodel');
    }

	
    function create_class_time() {
        $this->load->form('classtimeform', 'ctform');
        $this->tpl->set_js(array('jquery.validate'));
    }
	
	function save_class_time() {
        $this->load->form('classtimeform', 'ctform');
        $this->tpl->set_js(array('jquery.validate'));
        $this->process_form_class_time($this->ctform);
        $this->tpl->set_view('create_class_time');
    }

    public function edit_class_time($id) {
        $this->tpl->set_js(array('jquery.validate'));
		if (empty($id))
            redirect('class_routine');
        $this->load->model('classtimemodel');
        $info = $this->classtimemodel->find($id);
        $this->load->form('classtimeform', 'ctform', $info);
    }
	
	public function del_time($id) {
        if (empty($id))
            redirect('class_routine/class_time_list');

        $this->load->model('classtimemodel');
        $this->classtimemodel->delete($id);
        $this->session->set_flashdata('success', "Class Class Time has been deleted successfully");
		redirect('class_routine/class_time_list');
	}

    protected function process_form_class_time($form) {
        if ($form->validate()) {
            $id = $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Class time has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Class time has been edited successfully");
            }
            redirect('class_routine/class_time_list');
        }
    }
	function class_time_status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('class_routine/class_time_list');
        $this->load->model('classtimemodel');
        $this->classtimemodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Class time status has been changed successfully");
        redirect('class_routine/class_time_list');
    }
	
}

?>