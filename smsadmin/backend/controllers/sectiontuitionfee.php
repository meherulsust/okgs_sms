<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This controller is for section tuition fee configuration 
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 16, 2014
 */
class Sectiontuitionfee extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->init_grid();

	}
	protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Class Tuition Fee List');
            $this->grid_board->add_link('Create Form Tuition Fee', site_url('sectiontuitionfee/create'), array('class' => 'add', 'id' => 'new_sec_fee'));
           $this->config->set_item('grid_status_menu_items',array('active'=>'Active','inactive'=>'Inactive'));
	   $grid_columns = array('id'=>array('visible'=>false),'head'=>array('title'=>'Fee Head','link'=>'tuitionfeehead/view','id_column'=>'tuition_fee_head_id','tips'=>'Show head details'),'class'=>'Class','section'=>'Form','ammount'=>'Fee Amount', 
	   						'status'=>array('title'=>'Status','status'=>'status'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sectiontuitionfeemodel');
	}
	
    function create()
	{
	   $this->load->form('sectiontuitionfeeform','stform');
	   
	}

	function edit($id='')
	{	
		if(empty($id))
		redirect('sectiontuitionfee');
		$this->load->model('sectiontuitionfeemodel');
		$info = $this->sectiontuitionfeemodel->get_edit_info($id);
                if(empty($info))
                redirect('sectiontuitionfee');
		$this->load->form('sectiontuitionfeeform','stform',$info);
		$this->process_form($this->stform);
	   
	}
        
	
	function view($id)
	{
		$this->load->model('sectiontuitionfeemodel');
		$info = $this->sectiontuitionfeemodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$labels = array('head'=>'Head Name','class'=>'Class','section'=>'Form',
                    'creator'=>'Created By','created_at'=>'Created at');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info[0]);
         $this->tpl->set_view('elements/record_view',true); 
	}
	
	
	public function save()
	{
		$this->load->form('sectiontuitionfeeform','stform');	
		$this->process_form($this->stform);
		$this->tpl->set_view('create');
	}
	
	protected function process_form($form)
	{
		if($form->validate())
		{
			$id = $form->save();
			if($form->is_new())
				$this->session->set_flashdata('success',"Tuition fee has been created successfully");
			else
				$this->session->set_flashdata('success',"Tuition fee has been edited successfully");
		    redirect('sectiontuitionfee');
		}
	}
	public function del($id)
	{
		$this->load->model('sectiontuitionfeemodel');
		$this->sectiontuitionfeemodel->cascade_delete($id);
		$this->session->set_flashdata('success',"Tuition fee has been deleted successfully");
		redirect('sectiontuitionfee');
	}
        
        public function status($id,$stat){
            $this->load->model('sectiontuitionfeemodel');
            if($stat == 'active'){
                $stat = 1;
            } else{
                $stat = 0;
            }
            $this->sectiontuitionfeemodel->update_status($stat,$id);
            $this->session->set_flashdata('success',"Tuition fee status has been changed successfully");
            redirect('sectiontuitionfee');
        } 
       
        
     
        
	
	
}