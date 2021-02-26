<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This controller is for class tuition fee configuration 
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 08, 2014
 */
class Classtuitionfee extends BACKEND_Controller{
	
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
            $this->grid_board->add_link('Create Class Tuition Fee', site_url('classtuitionfee/create'), array('class' => 'add', 'id' => 'new_cls_fee'));
           $this->config->set_item('grid_status_menu_items',array('active'=>'Active','inactive'=>'Inactive'));
	   $grid_columns = array('id'=>array('visible'=>false),'head'=>'Head','class'=>'Class','ammount'=>'Fee Amount', 
	   						'status'=>array('title'=>'Status','status'=>'status'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('classtuitionfeemodel');
	}
	
    function create()
	{
	   $this->load->form('classtuitionfeeform','ctform');
	   
	}

	function edit($id='')
	{	
		if(empty($id))
		redirect('tuitionfeehead');
		$this->load->model('classtuitionfeemodel');
		$info = $this->classtuitionfeemodel->find($id);
		$this->load->form('classtuitionfeeform','ctform',$info);
		$this->process_form($this->ctform);
	   
	}
        
	
	function view($id)
	{
		$this->load->model('classtuitionfeemodel');
		$info = $this->classtuitionfeemodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$labels = array('head'=>'Head Name','class'=>'Class','ammount'=>'Amount',
                    'creator'=>'Created By','created_at'=>'Created at');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info[0]);
         $this->tpl->set_view('elements/record_view',true); 
	}
	
	
	public function save()
	{
		$this->load->form('classtuitionfeeform','ctform');	
		$this->process_form($this->ctform);
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
		    redirect('classtuitionfee');
		}
	}
	public function del($id)
	{
		$this->load->model('classtuitionfeemodel');
		$this->classtuitionfeemodel->cascade_delete($id);
		$this->session->set_flashdata('success',"Tuition fee has been deleted successfully");
		redirect('classtuitionfee');
	}
        
        public function status($id,$stat){
            $this->load->model('classtuitionfeemodel');
            if($stat == 'active'){
                $stat = 1;
            } else{
                $stat = 0;
            }
            $this->classtuitionfeemodel->update_status($stat,$id);
            $this->session->set_flashdata('success',"Tuition fee status has been changed successfully");
            redirect('classtuitionfee');
        } 
       
        
     
        
	
	
}