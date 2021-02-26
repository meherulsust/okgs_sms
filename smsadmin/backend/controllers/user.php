<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 31, 2012
 */
class User extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $grid_columns = array('id' => array('visible' => false), 'username' => 'User Name', 'full_name' => 'Full Name', 'mobile_no' => 'Mobile', 'email' => 'Email',
            'status' => array('title' => 'Status', 'status' => 'status'), 'created_at' => array('title' => 'Create Date', 'date' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('usermodel');
    }

    function create() {
        $this->load->form('userform');
        $this->tpl->set_jquery_ui();
    }

    public function save() {
        $this->load->form('userform');
        $this->tpl->set_view('create');
        $this->process_form($this->userform);
    }

    public function edit($id) {
        $this->load->model('usermodel');
        $info = $this->usermodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->form('userform', null, $info);
        $this->process_form($this->userform);
        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "User has been created successfully");
            else
                $this->session->set_flashdata('success', "User has been updated successfully");
            redirect('user/index');
        }
    }

    function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('user/index');
        $this->load->model('usermodel');
        $this->usermodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "User status has been changed successfully");
        redirect('user/index');
    }

    function view($id) {
       $this->load->helper('date');
       $columns = array('username' => 'Username', 'email' => 'Email', 'full_name' => 'Full Name', 'address' => 'Address','created_at'=>'Created At','created_by'=>'Created By');
       $info = $this->load->model('usermodel');
       $this->tpl->assign('view_title','User details');
       $this->tpl->assign('view_button',array('url'=>'user/create','alt'=>'Create user','title'=>'Create User'));
       $info = $this->usermodel->find($id);
       $this->tpl->assign('row',$info);
       $this->tpl->assign('labels',$columns);
       $this->tpl->set_view('elements/record_view',true);
    }
	
	public function del($id) {
        if (empty($id))
            redirect('user');

        $this->load->model('usermodel');
        $this->usermodel->delete($id);
        $this->session->set_flashdata('success', "User has been deleted successfully.");
        redirect('user');
    }
	
	/*
	// only for student number update
	public function update_student_user()
	{
		$this->load->model('usermodel');	
		$student_list = $this->usermodel->allstudentuser(); 		
		
		foreach($student_list as $val){
			
			$id = $val->id;
			$username = $val->username;
			$year = substr($username, 0, 4);
			$sid = str_replace($year,'',$username);				
			$data['username'] = 'BV'.$year.sprintf('%06d', $sid);
			$this->usermodel->update_student_user($id,$data);
		}
		echo 'Success';
		exit();
	}
	
	*/
	
}