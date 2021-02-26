<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Sylabus extends BACKEND_Controller{
	
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
	   $this->grid_board->set_title('Syllabus list');
      // $this->grid_board->add_link('New Syllabus',site_url('sylabus/create'),array('class'=>'add','id'=>'new_sylabus'));
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','total_marks'=>'Total Marks','class'=>'Class',
	   						'section'=>'Form','status'=>array('title'=>'Status','status'=>'status'),'created_at'=> array('title'=>'Create Date','datetime'=>'true'));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabusmodel');	
	}
	
    function create()
	{
	    $this->tpl->set_js(array('jquery.validate','select-chain'));
		$this->load->form('sylabusform','sform'); 
	}
	
	function edit($id='')
	{	
		$this->load->model('sylabusmodel','sm');
		$info = $this->sm->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->tpl->set_js(array('jquery.validate','select-chain'));
		$this->load->form('sylabusform','sform',$info);
		$this->process_form($this->sform);
	   
	}
	function save()
	{
		$this->load->form('sylabusform','sform');
		$this->process_form($this->sform);
		$this->create();
		$this->tpl->set_view('sylabus/create_tpl',true);
	}
	public function view($id='')
	{
		if(empty($id))
		redirect('sylabus');
		$this->load->helper('date');
		$this->load_tab_js();
		$this->load->model('sylabusmodel','sm');
		$info = $this->sm->get_info($id);
		$this->tpl->assign($info);
		
	}
	
	protected function load_tab_js()
	{
		$this->tpl->set_jquery_ui(array('tabs','dialog','position'));
		$this->tpl->set_js(array('jquery.loadmask','jquery.validate','jquery.form'));
        $this->tpl->set_css(array('jquery.loadmask'));
        	
		
	}
	public function del($id)
	{
		if(empty($id))
		redirect('sylabus');
		
		$this->load->model('sylabusmodel','sm');
		$this->sm->delete($id);
		$this->session->set_flashdata('success',"Syllabus has been deleted successfully");
		redirect('sylabus/index');
		
	}
	
	protected function process_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Syllabus has been created successfully");
			else
			$this->session->set_flashdata('success',"Syllabus has been updated successfully");
			redirect('sylabus/index');
		}
	}
	
	public function setup($id)
	{
		$this->load->model('sylabusmodel','sm');
		$info = $this->sm->get_info($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->tpl->assign($info);
		$this->tpl->set_jquery_ui(array('dialog','position'));
		$this->init_sylabus_book_grid($id);
	}
	
	protected function init_sylabus_book_grid($sid)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
	   $this->grid_board->set_title('Sylabus book list');
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'smview','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'smedit','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'smdel','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','full_marks'=>'Full Marks','subjective_marks'=>'Subjective Marks','objective_marks'=>'Objective Marks','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabusbookmodel');	
	}
	
	public function bookadd($sid)
	{
		$this->load->form('sylabusbookform','sbform');
		$this->sbform->set_default('sylabus_id',$sid);
		
	}
	
	
	
	public function scale()
	{
		$this->init_scale_grid();
	}
	protected function init_scale_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Scale list');
           $this->grid_board->add_link('New Scale',site_url('sylabus/newscale'),array('class'=>'add','id'=>'new_scale'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'rsview','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'rsedit','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'rsdel','controller'=>'','tips'=>'Delete this scale'),
	   					'config'=>array('title'=>'Config','action'=>'rsconfig','controller'=>'','tips'=>'Configure this scale')
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','code_name'=>'Code','status'=>array('title'=>'Status','status'=>'scalestatus'),'created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('resultscalemodel');	
	}
	function newscale()
	{
	    $this->tpl->set_js(array('jquery.validate'));
		$this->load->form('resultscaleform','rsform'); 
	}
	
	function savescale()
	{
		$this->load->form('resultscaleform','rsform');
		$this->process_scale_form($this->rsform);
		$this->newscale();
		$this->tpl->set_view('sylabus/newscale_tpl',true);
	}
	function rsedit($id='')
	{
		$this->load->model('resultscalemodel','rsmodel');
		$info = $this->rsmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('resultscaleform','rsform',$info);
		$this->process_form($this->rsform);
	   
	}
	function scalestatus($id='',$stat='')
	{
		if(empty($id) || empty($stat))
		redirect('sylabus/scale');
		$this->load->model('resultscalemodel','rsmodel');
		$this->rsmodel->update(array('status'=>strtoupper($stat),'id'=>$id));
		$this->session->set_flashdata('success',"Result scale status has been changed successfully");
		redirect('sylabus/scale');
	}
	
	public function rsdel($id)
	{
		$this->load->model('resultscalemodel','rsmodel');
		$this->rsmodel->delete($id);
		$this->session->set_flashdata('success',"Result scale has been deleted successfully");
		redirect('sylabus/scale');
	}
	
	function rsview($id='')
	{
		$this->load->model('resultscalemodel','rsmodel');
		$info = $this->rsmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->tpl->assign($info);
	}
	
	
	protected function process_scale_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Result scale has been created successfully");
			else
			$this->session->set_flashdata('success',"Result scale has been updated successfully");
			redirect('sylabus/scale');
		}
	}
	
	function rsconfig($id='')
	{
		$this->load->helper('date');
		$this->load->model('resultscalemodel','rsmodel');
		$info = $this->rsmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->init_matrix_grid($id);
		$this->tpl->assign($info);
		$this->tpl->set_jquery_ui(array('dialog','position'));
		
	}
	
	protected function init_matrix_grid($sid)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('result_scale_id'=>$sid));
	   $this->grid_board->set_title('Scale matrix list');
           $this->grid_board->add_link('New Scale Range',site_url('sylabus/smadd/'.$sid),array('class'=>'add','id'=>'sradd'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'smview','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'smedit','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'smdel','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','max_range'=>'Max Range','min_range'=>'Min Range','weight'=>'Weight','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('scalematrixmodel');	
	}
	
	function smadd($sid='')
	{
		$this->load->form('scalematrixform','sform');
		$this->sform->set_default('result_scale_id',$sid);
	}
	
	function smsave()
	{
		$this->load->form('scalematrixform','sform');
		if($this->sform->validate())
		{
			$this->sform->save();
			$sid = $this->sform->get_value('result_scale_id');
			if($this->sform->is_new())
			$this->session->set_flashdata('success',"Scale range has been created successfully");
			else
			$this->session->set_flashdata('success',"Scale range has been updated successfully");
			redirect('sylabus/rsconfig/'.$sid);
		}
		
	}
	function smedit($id)
	{
		$this->load->model('scalematrixmodel','smmodel');
		$info = $this->smmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->form('scalematrixform','sform',$info);
		$this->tpl->set_view('smadd');
	}
	
	function ctype()
	{
		$this->init_ctype_grid();
	}
	protected function init_ctype_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Course type list');
	   $this->grid_board->add_link('New Course Type',site_url('sylabus/newctype'),array('class'=>'add','id'=>'new_course_type'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'showctype','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'editctype','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'delctype','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','status'=>array('title'=>'Status', 'status'=>'ctypestat'),'created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('coursetypemodel');	
	}
	
	function newctype()
	{
		 $this->tpl->set_js(array('jquery.validate'));
		 $this->load->form('coursetypeform','ctform'); 
	}
	function savectype()
	{
		$this->newctype();
		$this->process_course_type_form($this->ctform);
		$this->tpl->set_view('sylabus/newctype_tpl',true);
	}
	function editctype($id)
	{
		$this->load->model('coursetypemodel','ctmodel');
		$info = $this->ctmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('coursetypeform','ctform',$info);
	}
	protected function process_course_type_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Course type has been created successfully");
			else
			$this->session->set_flashdata('success',"Course type has been updated successfully");
			redirect('sylabus/ctype');
		}
	}
	
	public function showctype($id)
	{
		$this->load->model('coursetypemodel','ctmodel');
		$info = $this->ctmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->init_course_type_attribute_grid($id);
		$this->tpl->assign($info);
		$this->tpl->set_jquery_ui(array('dialog','position'));
	}
	
	protected function init_course_type_attribute_grid($course_type_id)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_params(array('course_type_id'=>$course_type_id));
	    $this->grid_board->query_condition(array('course_type_id'=>$course_type_id));
	   $this->grid_board->add_link('Assign Attribute',site_url('sylabus/newctattr/'.$course_type_id),array('class'=>'add','id'=>'new_course_type_attr'));
	   $this->grid_board->set_title('Course type attribute list');
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'viewctattr','controller'=>'','tips'=>'View record details'),
  						'edit'=>array('title'=>'Edit','action'=>'editctattr','controller'=>'','tips'=>'Edit record'),
  						'del'=>array('title'=>'Delete','action'=>'delctattr','controller'=>'','tips'=>'Delete record'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'attribute'=>'Attribute','params'=>'Parameter', 'status'=>array('title'=>'Status','status'=>false),'created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('coursetypecourseattributemodel');	
	
	}
	
	public function newctattr($course_type_id)
	{
		$this->load->form('coursetypecourseattributeform','ctcaform');
		$this->ctcaform->set_default('course_type_id',$course_type_id);
				
	}
	public function savectattr()
	{
		$this->output->set_content_type('application/json');
		$this->load->form('coursetypecourseattributeform','ctcaform');
		$response = array('success'=>false,'message'=>'','redirect'=>'');
		if($this->ctcaform->validate())
		{
			$this->ctcaform->save();
			$response['success']=true;
			$ctype_id = $this->ctcaform->get_value('course_type_id');
			if($this->ctcaform->is_new())
			$this->session->set_flashdata('success',"Course attribute has been created successfully");
			else
			$this->session->set_flashdata('success',"Course attribute has been updated successfully");	
			$response['redirect'] = site_url('sylabus/showctype/'.$ctype_id);
		}
		else
		$response['message'] = 'One or more required fields are missing';
		$this->output->set_output(json_encode($response));
	}
	
	function editctattr($id)
	{
		$this->load->model('coursetypecourseattributemodel','ctcamodel');
		$info = $this->ctcamodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->form('coursetypecourseattributeform','ctcaform',$info);
		$this->tpl->set_view('newctattr');
	}
	
	public function delctattr($id)
	{
		$this->load->model('coursetypecourseattributemodel','ctcamodel');
		$info = $this->ctcamodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->ctcamodel->delete($id);
		$this->session->set_flashdata('success',"Course type attribute has been deleted successfully");
		redirect('sylabus/showctype/'.$info['course_type_id']);
	}
	
	public function viewctattr($id)
	{
		$this->load->model('coursetypecourseattributemodel','ctcamodel');
		$info = $this->ctcamodel->get_info($id);
		if(empty($info))
		{
			show_404();
		}
	 	$this->load->helper('date');
		$this->tpl->assign($info);
	}
	
   function statctattr($id='',$stat='')
	{
		$this->load->model('coursetypecourseattributemodel','ctcamodel');
		$info = $this->ctcamodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->ctcamodel->update(array('status'=>strtoupper($stat),'id'=>$id));
		$this->session->set_flashdata('success',"Course type attribute status has been changed successfully");
		redirect('sylabus/showctype/'.$info['course_type_id']);
	}
 	public function delctype($id)
	{
		$this->load->model('coursetypemodel','ctmodel');
		$this->ctmodel->delete($id);
		$this->session->set_flashdata('success',"Course type has been deleted successfully");
		redirect('sylabus/ctype');
	}
	function ctypestat($id='',$stat='')
	{
		$this->load->model('coursetypemodel','ctmodel');
		$info = $this->ctmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->ctmodel->update(array('status'=>strtoupper($stat),'id'=>$id));
		$this->session->set_flashdata('success',"Course type status has been changed successfully");
		redirect('sylabus/ctype');
	}
	
	public function evaltype()
	{
		$this->init_evaluation_type_grid();
		
	}
	
	protected function init_evaluation_type_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Course evaluation type list');
           $this->grid_board->add_link('New Eval Type',site_url('sylabus/newevaltype'),array('class'=>'add','id'=>'new_eval'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'showevaltype','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'editevaltype','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'delevaltype','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','eval_type'=>'Eval Type', 'status'=>array('title'=>'Status', 'status'=>'ctypestat'),'created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('evaluationtypemodel');	
	
		
	}
	public function newevaltype()
	{
		 $this->tpl->set_js(array('jquery.validate'));
		 $this->load->form('evaluationtypeform','etform'); 
	}
	function saveevaltype()
	{
		$this->newevaltype();
		$this->process_evaluation_type_form($this->etform);
		$this->tpl->set_view('sylabus/newevaltype_tpl',true);
	}
	function editevaltype($id)
	{
		$this->load->model('evaluationtypemodel','etmodel');
		$info = $this->etmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('evaluationtypeform','etform',$info);
	}
	protected function process_evaluation_type_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Evaluation type has been created successfully");
			else
			$this->session->set_flashdata('success',"Evaluation type has been updated successfully");
			redirect('sylabus/evaltype');
		}
	}
	
	public function showevaltype($id)
	{
		$this->load->model('evaluationtypemodel','etmodel');
		$info = $this->etmodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->tpl->assign($info);
	}
	
	public function delevaltype($id)
	{
		$this->load->model('evaluationtypemodel','etmodel');
		$this->etmodel->delete($id);
		$this->session->set_flashdata('success',"Evaluation type has been deleted successfully");
		redirect('sylabus/evaltype');
	}
	
	public function cattr()
	{
		$this->init_course_attribute_grid();
		$this->tpl->set_view('course_attribute/courseattr');
	}
	
	protected function init_course_attribute_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Course attribute list');
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'showcattr','controller'=>'','tips'=>'Course attribute details'),
  						'edit'=>array('title'=>'Edit','action'=>'editcattr','controller'=>'','tips'=>'Edit course attrbute'),
  						'del'=>array('title'=>'Delete','action'=>'delcattr','controller'=>'','tips'=>'Delete course attribute'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','eval_type'=>'Eval Type', 'eval_func'=>'Eval Function','attribute_for'=>'Attritute for', 'status'=>array('title'=>'Status', 'status'=>'cattrstat'),'created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('courseattributemodel');	
	}
	
	public function newcattr()
	{
		 $this->tpl->set_js(array('jquery.validate'));
		 $this->load->form('courseattributeform','caform'); 
		 $this->tpl->set_view('course_attribute/newcattr');
	}
	function savecattr()
	{
		$this->newcattr();
		$this->process_course_attr_form($this->caform);
		$this->tpl->set_view('sylabus/course_attribute/newcattr_tpl',true);
	}
	function editcattr($id)
	{
		$this->load->model('courseattributemodel','camodel');
		$info = $this->camodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->tpl->set_js(array('jquery.validate'));
		$this->load->form('courseattributeform','caform',$info);
		$this->tpl->set_view('course_attribute/editcattr');
	}
	protected function process_course_attr_form($form)
	{
		if($form->validate())
		{
			$form->save();
			if($form->is_new())
			$this->session->set_flashdata('success',"Course Attribute has been created successfully");
			else
			$this->session->set_flashdata('success',"Course Attribute has been updated successfully");
			redirect('sylabus/cattr');
		}
	}
	public function delcattr($id)
	{
		$this->load->model('courseattributemodel','camodel');
		$info = $this->camodel->find($id);
		if($info)
		{
			$this->camodel->delete($id);
			$this->session->set_flashdata('success',"Course Attribute has been deleted successfully");
			redirect('sylabus/cattr');
		
		}
	}
	
	public function showcattr($id)
	{
		$this->load->model('courseattributemodel','camodel');
		$info = $this->camodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->load->helper('date');
		$this->tpl->assign($info);
		$this->tpl->set_view('course_attribute/showcattr');
	}
	
	function cattrstat($id='',$stat='')
	{
		$this->load->model('courseattributemodel','camodel');
		$info = $this->camodel->find($id);
		if(empty($info))
		{
			show_404();
		}
		$this->camodel->update(array('status'=>strtoupper($stat),'id'=>$id));
		$this->session->set_flashdata('success',"Course attribute status has been changed successfully");
		redirect('sylabus/cattr');
	}
	
	
	
	
	
	
	
	
}