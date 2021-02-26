<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This controller is for section tuition fee configuration 
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 16, 2014
 */
class Studenttypetuitionfee extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		//$this->tpl->set_js('select-chain');
        $this->load->filter('studenttypetuitionfee_filter', 'sttff');
		$this->init_grid();
	}
	protected function init_grid()
	{
		$this->load->library('grid_board');
		$this->grid_board->set_title('Student Type Tuition Fee List');
	    $this->grid_board->set_filter($this->sttff);
        $this->grid_board->add_link('Create Student Type Tuition Fee', site_url('studenttypetuitionfee/create'), array('class' => 'add', 'id' => 'new_sec_fee'));
        $this->config->set_item('grid_status_menu_items',array('active'=>'Active','inactive'=>'Inactive'));
		$grid_columns = array('id'=>array('visible'=>false),'head'=>array('title'=>'Fee Head','link'=>'tuitionfeehead/view','id_column'=>'tuition_fee_head_id','tips'=>'Show head details'),'student_type'=>'Student Type','class'=>'Class','version'=>'Version','ammount'=>'Fee Amount', 
	   						'status'=>array('title'=>'Status','status'=>'status'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('studenttypetuitionfeemodel');
	}
	
	function filter() {
        $this->load->filter('studenttypetuitionfee_filter', 'sttff');
        $this->sttff->execute();
        redirect('studenttypetuitionfee/index');
    }
	
    function create()
	{
	   $this->tpl->set_js(array('select-chain'));
	   $this->load->form('studenttypetuitionfeeform','sttform');	   
	}

	function edit($id='')
	{	
		if(empty($id))
		redirect('studenttypetuitionfee');
		$this->load->model('studenttypetuitionfeemodel');
		$info = $this->studenttypetuitionfeemodel->get_edit_info($id);
                if(empty($info))
                redirect('studenttypetuitionfee');
		$this->load->form('studenttypetuitionfeeform','sttform',$info);
		$this->process_form($this->sttform);
	   
	}
        
	
	function view($id)
	{
		$this->load->model('studenttypetuitionfeemodel');
		$info = $this->studenttypetuitionfeemodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$labels = array('head'=>'Head Name','student_type'=>'Student Type','class'=>'Class','version'=>'Version',
                    'creator'=>'Created By','created_at'=>'Created at');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info[0]);
         $this->tpl->set_view('elements/record_view',true); 
	}
	
	
	public function save()
	{
		$this->load->form('studenttypetuitionfeeform','sttform');	
		$this->process_form($this->sttform);
		$this->tpl->set_view('create');
	}
	
	protected function process_form($form)
	{
		if($form->validate())
		{
			$id = $form->save();
			if($form->is_new())
				$this->session->set_flashdata('success',"Tuition fee has been created successfully.");
			else
				$this->session->set_flashdata('success',"Tuition fee has been edited successfully.");
		    redirect('studenttypetuitionfee');
		}
	}
	
	public function del($id)
	{
		$this->load->model('studenttypetuitionfeemodel');
		$this->studenttypetuitionfeemodel->cascade_delete($id);
		$this->session->set_flashdata('success',"Tuition fee has been deleted successfully");
		redirect('studenttypetuitionfee');
	}
        
	public function status($id,$stat){
		$this->load->model('studenttypetuitionfeemodel');
		if($stat == 'active'){
			$stat = 1;
		} else{
			$stat = 0;
		}
		$this->studenttypetuitionfeemodel->update_status($stat,$id);
		$this->session->set_flashdata('success',"Tuition fee status has been changed successfully");
		redirect('studenttypetuitionfee');
	} 
       
        
     
        
	
	
}