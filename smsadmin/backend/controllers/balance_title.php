<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Md.Meherul Islam
 * @ Created     18.10.2016
 */
class Balance_title extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }
	
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Balance title list');
		$this->grid_board->add_link('New Balance title', site_url('balance_title/create'), array('class' => 'add', 'id' => 'new_title'));
        $grid_columns = array('id' => array('visible' => false),
            'title'=>'Title','created_at'=>'Created at','status' => array('title' => 'Status', 'status' => 'status'));
        $this->grid_board->set_column($grid_columns);
		$actions = array(            
//            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete record'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit record'),
        );
        $this->grid_board->set_action($actions);
		
        $this->grid_board->render('balance_titlemodel');
    }
	
    function create() {
        $this->load->form('balance_titleform', 'btform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate'));
    }
	
	function save() {
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate'));
        $this->load->form('balance_titleform', 'btform');
        $this->process_form($this->btform);
        $this->tpl->set_view('create');
    }
	
    public function edit($id) {
        $this->load->model('balance_titlemodel');
        $info = $this->balance_titlemodel->find($id);
        if(empty($info)){
            show_404();
        }
		$this->load->form('balance_titleform', 'btform',$info);
		$this->process_form($this->btform);        
    }
	
	
   
    protected function process_form($form) {
        if ($form->validate()) {            
			$id = $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Balance title has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Balance title has been edited successfully");
            }
            redirect('balance_title');
        }
    }

   
    public function del($id) {
        $this->load->model('balance_titlemodel');        
		$this->balance_titlemodel->delete($id);
		$this->session->set_flashdata('success', "Balance title has been deleted successfully.");
		redirect('balance_title');       
    }

   public function uniquetitle($str)
	{
		$this->load->form('balance_titleform', 'btform');
		/* $form = $this->btform;
		$param = $form->get_value('title'); */
		$this->load->model('balance_titlemodel');
		$count = $this->balance_titlemodel->check_duplicate_title($str);
		if($count>0)
		{
			$this->form_validation->set_message('uniquetitle', "This title already exists.");
			return false;
		}
		return true; 
	}  

	function status($id,$stat) {
        $this->load->model('balance_titlemodel');
        $row = $this->balance_titlemodel->find($id);
        if (empty($row)) {
            show_404();
        }
        $this->balance_titlemodel->update_status($stat,$id);
        $this->session->set_flashdata('success', "Title status has been changed successfully.");
        redirect('balance_title');
    }	
	
}

?>
