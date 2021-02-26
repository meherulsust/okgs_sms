<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gamil.com>
 * @ Created    August 31, 2012
 */
class Noticeboard extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

        
	function index()
	{
		$this->tpl->set_js('select-chain');
		$this->init_grid();
	}
	
	protected function init_grid()
	{
		$this->load->library('grid_board');
		$this->grid_board->set_title('Notice list');
		$this->grid_board->add_link('New Notice', site_url('noticeboard/create'), array('class' => 'add'));
		$grid_columns = array('id'=>array('visible'=>false),'notice_title'=>'Notice Title','full_notice'=>'Full Notice','version'=>'Version','class_name'=>'Class','section'=>'Section','house'=>'House','facility'=>'Extra Facility','student_number'=>'Student',
	   					'designation'=>'Designation','created_at'=> array('title'=>'Create Date','datetime'=>true),'status' => array('title' => 'Status', 'status' => 'status'));
		$this->grid_board->set_column($grid_columns);
		$actions = array(
						'edit'=>array('title'=>'Edit','action'=>'edit_notice','controller'=>'','tips'=>'Edit this notice'),
  						'del'=>array('title'=>'Delete','action'=>'del_notice','controller'=>'','tips'=>'Delete this notice'),
  						);
		$this->grid_board->set_action($actions);
		$this->grid_board->render('noticeboardmodel');	
	}
	
	
	
	
	function create() {
		$this->tpl->set_js(array('select-chain','jquery.validate', 'noticeboard_form'));
        $this->load->form('noticeboardform');   
    
    }

	
	public function save_notice() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'noticeboard_form'));
        $this->load->form('noticeboardform');
        $this->tpl->set_view('create');
        $this->process_form($this->noticeboardform);
    }

    public function edit_notice($id) {
		$this->tpl->set_js(array('select-chain','jquery.validate', 'noticeboard_form'));
        $this->load->model('noticeboardmodel');
        $info = $this->noticeboardmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->form('noticeboardform', null, $info);
        $this->process_form($this->noticeboardform);
        $this->tpl->set_view('create');
    }
	
	
	public function del_notice($id)
	{
		if(empty($id))
		redirect('noticeboard');
		
		$this->load->model('noticeboardmodel');
		$this->noticeboardmodel->delete($id);
		$this->session->set_flashdata('success',"Notice has been deleted successfully");
		redirect('noticeboard/index');
		
	}
	
    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Notice has been created successfully");
            else
                $this->session->set_flashdata('success', "Notice has been updated successfully");
            redirect('noticeboard/index');
        }
    }

    function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('noticeboard/index');
        $this->load->model('noticeboardmodel');
        $this->noticeboardmodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Notice status has been changed successfully");
        redirect('noticeboard/index');
    }
	
	
	
}