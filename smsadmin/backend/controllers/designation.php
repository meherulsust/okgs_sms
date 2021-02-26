<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */
class Designation extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }
	
	protected function init_grid()
	{
		$this->load->library('grid_board');
		$this->grid_board->set_title('Designation list');
		$this->grid_board->add_link('New Designation',site_url('designation/create'),array('class'=>'add','id'=>'new_sylabus'));
		$grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','type'=>'Type','description'=>'Description');
	    $grid_all_actions = $this->config->item('grid_all_actions');
        $this->config->set_item('grid_all_actions', $grid_all_actions);
		$actions = array(
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete'),            
        );
        $this->grid_board->set_action($actions);
	   
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('designationmodel');	
	}
	
    function create()
	{
		$this->load->form('designationform','dform'); 
	}
	
	function edit($id='')
	{	
		$this->load->model('designationmodel','dm');
		$info = $this->dm->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->form('designationform','dform',$info);
		$this->process_form($this->dform);
	   
	}
	function save()
	{
		$this->load->form('designationform','dform');
		$this->process_form($this->dform);
		$this->create();
		$this->tpl->set_view('designation/create_tpl',true);
	}

	protected function process_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Designation has been created successfully");
			else
			$this->session->set_flashdata('success',"Designation has been updated successfully");
			redirect('designation/index');
		}
	}
    public function del($id) {
        $this->load->model('designationmodel');        
		$this->designationmodel->delete($id);
		$this->session->set_flashdata('success', "Designation has been deleted successfully.");
		redirect('designation');       
    }

}

?>
