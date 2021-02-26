<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Book extends BACKEND_Controller{
	
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
	   $this->grid_board->set_title('Book list');
       $this->config->set_item('grid_status_menu_items',array('active'=>'Active','inactive'=>'Inactive'));
           // print_r($this->config->item('grid_status_menu_items'));
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','writer_name'=>'Writer name','class'=>'Class Name','book_type'=>'Book Type','link'=>'Book Link',
	   						'status'=>array('title'=>'Status','status'=>'status'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('bookmodel');
	}
	
    function create()
	{
	   $this->load->form('bookform');
	   
	}

	function edit($id='')
	{	
		if(empty($id))
		redirect('book');
		$this->load->model('bookmodel');
		$info = $this->bookmodel->find($id);
		$this->load->form('bookform',null,$info);
		$this->process_form($this->bookform);
	   
	}
	
	function view($id)
	{
		$this->load->model('bookmodel');
		$info = $this->bookmodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->tpl->assign($info[0]);
	}
	
	
	public function save()
	{
		$this->load->form('bookform');	
		$this->process_form($this->bookform);
		$this->tpl->set_view('create');
	}
	
	protected function process_form($form)
	{
		if($form->validate())
		{
			$id = $form->save();
			if($form->is_new())
				$this->session->set_flashdata('success',"Book has been created successfully");
			else
				$this->session->set_flashdata('success',"Book has been edited successfully");
		    redirect('book/index/');
		}
	}
	public function del($id)
	{
		$this->load->model('bookmodel');
		$this->bookmodel->delete($id);
		$this->session->set_flashdata('success',"Book has been deleted successfully");
		redirect('book/index/');
	}
        
        public function status($id,$stat){
            $this->load->model('bookmodel');
            $this->bookmodel->update_status($stat,$id);
            $this->session->set_flashdata('success',"Book status has been changed successfully");
            redirect('book/index');
        } 
       
        
        public function course(){
            $this->init_course_grid();
        }
        
        protected function init_course_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Course title list');
	   $actions = array(
						'view'=>array('title'=>'View','action'=>'viewct','controller'=>'','tips'=>'View course title details'),
						'edit'=>array('title'=>'Edit','action'=>'editct','controller'=>'','tips'=>'Edit course title'),
						'del'=>array('title'=>'Delete','action'=>'delct','controller'=>'','tips'=>'Delete course title'),
						);
	   $this->grid_board->set_action($actions);
       $this->grid_board->add_link('New Course Title',site_url('book/newcoursetitle'),array('class'=>'add','id'=>'new_course_title'));
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','order'=>'Order','status'=>array('title'=>'Status','status'=>'ctstatus'),'created_at'=>'Create Date');
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('coursetitlemodel');
	}
        public function newcoursetitle(){
            $this->load->form('coursetitleform','ctform');
        }
        public function savect(){
            $this->load->form('coursetitleform','ctform');
            $this->process_ctform($this->ctform);
            $this->tpl->set_view('newcoursetitle');
        }
	protected function process_ctform($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
				$this->session->set_flashdata('success',"Course title has been created successfully");
			else
				$this->session->set_flashdata('success',"Course title has been edited successfully");
		    redirect('book/course');
		}
	}
        
        function editct($id='')
	{	
		if(empty($id))
                redirect('book/course');
		$this->load->model('coursetitlemodel','ctmodel');
		$info = $this->ctmodel->find($id);
		$this->load->form('coursetitleform','ctform',$info);
                $this->tpl->set_view('newcoursetitle');
	}
        
        public function viewct($id){
            $this->load->model('coursetitlemodel','ctmodel');
	    $info = $this->ctmodel->find($id);
            if(empty($info))
            {
                    show_404();
            }
            $this->load->helper('date');
           $labels = array('title'=>'Course title','status'=>'status', 'created_at'=>'Created At','created_by'=>'Created By');
           $this->tpl->assign('labels',$labels);
           $this->tpl->assign('row',$info); 
           $this->tpl->set_view('elements/record_view.php',true);
        }
        public function delct($id)
	{
		$this->load->model('coursetitlemodel','ctmodel');
		$this->ctmodel->delete($id);
		$this->session->set_flashdata('success',"Course title been deleted successfully");
		redirect('book/course');
	}
     public function ctstatus($id,$stat){
            $this->load->model('coursetitlemodel');
            $this->coursetitlemodel->update_status($stat,$id);
            $this->session->set_flashdata('success',"Course title status has been changed successfully");
            redirect('book/course');
        }     
	
	
}