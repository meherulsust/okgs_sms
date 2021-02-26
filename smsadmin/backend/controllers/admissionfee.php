<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This controller is for admissionwise tuition fee configuration 
 * it will cater the tuition of a student for one year.
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 09, 2014
 */
class Admissionfee extends BACKEND_Controller{
	
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
	   $this->grid_board->set_title('Student Admissionwise Tuition Fee List');
            $this->grid_board->add_link('Assign Student Tuition Fee', site_url('admissionfee/create'), array('class' => 'add', 'id' => 'new_cls_fee'));
           $this->config->set_item('grid_status_menu_items',array('active'=>'Active','inactive'=>'Inactive'));
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>array('title'=>'Title','link'=>'tuitionfeehead/view','id_column'=>'tuition_fee_head_id','tips'=>'Show head details'),'student_number'=>'Student Number','session'=>'Applicable Year','ammount'=>'Fee Amount', 
	   						'status'=>array('title'=>'Status','status'=>'status'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('admissionfeemodel');
	}
	
        function create()
	{
	   $this->load->form('admissionfeeform','atform');
	   
	}

	function edit($id='')
	{	
		if(empty($id))
		redirect('admissionfee');
		$this->load->model('admissionfeemodel');
		$info = $this->admissionfeemodel->get_info($id);
                if(empty($info))
		{
			show_404();
		}
		$this->load->form('admissionfeeform','atform',$info);
		$this->process_form($this->atform);
	   
	}
        
	
	function view($id)
	{
		$this->load->model('admissionfeemodel');
		$info = $this->admissionfeemodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$labels = array('title'=>'Head Name', 'head_code'=>'Head Code','head_type'=>'Head Type','full_name'=>'Student Name','student_number'=>'Student Number','description'=>'Description',
                   'session'=>'Applicable For','creator'=>'Created By','created_at'=>'Created at');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info);
         $this->tpl->set_view('elements/record_view',true); 
	}
	
	
	public function save()
	{
		$this->load->form('admissionfeeform','atform');	
		$this->process_form($this->atform);
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
		    redirect('admissionfee');
		}
	}
	public function del($id)
	{
		$this->load->model('admissionfeemodel');
		$this->admissionfeemodel->delete($id);
		$this->session->set_flashdata('success',"Tuition fee has been deleted successfully");
		redirect('admissionfee');
	}
        
        public function status($id,$stat){
            $this->load->model('admissionfeemodel');
            if($stat == 'active'){
                $stat = 1;
            } else{
                $stat = 0;
            }
            $this->admissionfeemodel->update_status($stat,$id);
            $this->session->set_flashdata('success',"Tuition fee status has been changed successfully");
            redirect('admissionfee');
        } 
       
        
     
        
	
	
}
