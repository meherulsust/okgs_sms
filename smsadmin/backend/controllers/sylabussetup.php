<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 02, 2012
 */
class Sylabussetup extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function attribute($sylabus_id)
	{
		$this->init_attribute_grid($sylabus_id);
		
	}
	
	protected function init_attribute_grid($sid)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
	   $this->grid_board->set_params(array('sylabus_id'=>$sid));
	   $column_option = $this->config->item('grid_column_option');
	   $column_option['sort'] = false;
	   $this->config->set_item('grid_column_option',$column_option);
	   $this->grid_board->set_title('Sylabus attribute');
	   $this->grid_board->add_link('New Sylabus Attribute',site_url('sylabussetup/newattribute/'.$sid),array('class'=>'add','id'=>'new_attribute'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'viewattribute','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'editattribute','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'delattribute','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'attribute'=>'Attribute','status'=>'Status','params'=>'Parameter','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabuscourseattributemodel');	
	}
	
  public function newattribute($sylabus_id)
  {
  		$this->load->form('sylabuscourseattributeform','scaform');
		$this->scaform->set_default('sylabus_id',$sylabus_id);	
		$this->tpl->assign('form_title','ASSIGN SYLABUS COURSE TYPE');
  }	
 public function saveattribute()
 {
	if(!$this->input->is_ajax_request())
	{
		show_404();
	}
	$this->output->set_content_type('application/json');
	$response = array('success' => 1,'message'=>'');
	$this->load->form('sylabuscourseattributeform','scaform');
	if($this->scaform->validate())
	{
	  $this->scaform->save();
	  $response = array('success' => 1,'message'=>'');
	  if($this->scaform->is_new())
	  $this->session->set_flashdata('success', 'Sylabus attribute has been assigned successfully');
	  else
	  $this->session->set_flashdata('success', 'Sylabus attribute has been updated successfully');
	}
	else
	{
		$response = array('success' => 0,'message'=>'One or more required fields are missing.');
	} 
	$this->output->set_output(json_encode($response));	
 }
	
 public function editattribute($id)
 {
 	$this->load->model('sylabuscourseattributemodel','scamodel');
	$info = $this->scamodel->find($id);
	$this->tpl->assign('form_title','EDIT SYLABUS ATTRIBUTE');
	if(empty($info))
	{
		show_404();
	}
	$this->load->form('sylabuscourseattributeform','scaform',$info);
	$this->tpl->set_view('newattribute');
 }
 
 public function viewattribute($id)
 {
 	$this->load->model('sylabuscourseattributemodel','scamodel');
	$info = $this->scamodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
	$this->load->helper('date');
	$this->tpl->assign($info);
 }
 public function delattribute($id)
 {
 	$this->output->set_content_type('application/json');
 	$this->load->model('sylabuscourseattributemodel','scamodel');
 	$this->scamodel->delete($id);
 	$response = array('success' => 1);
 	$this->session->set_flashdata('success', 'Sylabus attribute has been deleted successfully');
 	$this->output->set_output(json_encode($response));
 }
 
 
	
	public function ctype($sylabus_id)
	{
		$this->init_ctype_grid($sylabus_id);
		
	}
	protected function init_ctype_grid($sid)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
	   $this->grid_board->set_params(array('sylabus_id'=>$sid));
	   $column_option = $this->config->item('grid_column_option');
	   $column_option['sort'] = false;
	   $this->config->set_item('grid_column_option',$column_option);
	   $this->grid_board->set_title('Sylabus course type');
	   $this->grid_board->add_link('Assign New Course Type',site_url('sylabussetup/assignctype/'.$sid),array('class'=>'add','id'=>'assign_new_type'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'sctview','controller'=>'','tips'=>'View details of this scale'),
  						'edit'=>array('title'=>'Edit','action'=>'sctedit','controller'=>'','tips'=>'Edit this scale'),
  						'del'=>array('title'=>'Delete','action'=>'sctdel','controller'=>'','tips'=>'Delete this scale'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'course_type'=>'Course type','status'=>'Status','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabuscoursetypemodel');	
	}
	
	
  public function assignctype($sylabus_id)
  {
  		$this->load->form('sylabuscoursetypeform','sctform');
		$this->sctform->set_default('sylabus_id',$sylabus_id);	
		$this->tpl->assign('form_title','ASSIGN SYLABUS COURSE TYPE');
  }	
 public function savesctype()
 {
	if(!$this->input->is_ajax_request())
	{
		show_404();
	}
	$this->output->set_content_type('application/json');
	$response = array('success' => 1,'message'=>'');
	$this->load->form('sylabuscoursetypeform','sctform');
	if($this->sctform->validate())
	{
	  $this->sctform->save();
	  $response = array('success' => 1,'message'=>'');
	  if($this->sctform->is_new())
	  $this->session->set_flashdata('success', 'Course type has been assigned successfully');
	  else
	  $this->session->set_flashdata('success', 'Course type has been updated successfully');
	}
	else
	{
		$response = array('success' => 0,'message'=>'One or more required fields are missing.');
	} 
	$this->output->set_output(json_encode($response));	
 }
 
 public function sctedit($id)
 {
 	$this->load->model('sylabuscoursetypemodel','sctmodel');
	$info = $this->sctmodel->find($id);
	$this->tpl->assign('form_title','EDIT SYLABUS COURSE TYPE');
	if(empty($info))
	{
		show_404();
	}
	$this->load->form('sylabuscoursetypeform','sctform',$info);
	$this->tpl->set_view('assignctype');
 }
 
 public function sctview($id)
 {
 	$this->load->model('sylabuscoursetypemodel','sctmodel');
	$info = $this->sctmodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
	$this->load->helper('date');
	$this->tpl->assign($info);
 }
 public function sctdel($id)
 {
 	$this->output->set_content_type('application/json');
 	$this->load->model('sylabuscoursetypemodel','sctmodel');
 	$this->sctmodel->delete($id);
 	$response = array('success' => 1);
 	$this->session->set_flashdata('success', 'Course type has been deleted successfully');
 	$this->output->set_output(json_encode($response));
 }
 
 
 
   public function evaluation($sylabus_id)
	{
		$this->init_evaluation_grid($sylabus_id);
		
	}

	protected function init_evaluation_grid($sid)
	{
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
	   $this->grid_board->set_params(array('sylabus_id'=>$sid));
	   $column_option = $this->config->item('grid_column_option');
	   $column_option['sort'] = false;
	   $this->config->set_item('grid_column_option',$column_option);
	   $this->grid_board->set_title('Sylabus Evaluation Type');
	   $this->grid_board->add_link('Assign New Evaluation Type',site_url('sylabussetup/assigneval/'.$sid),array('class'=>'add','id'=>'assign_eval'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'setview','controller'=>'','tips'=>'View record details'),
  						'edit'=>array('title'=>'Edit','action'=>'setedit','controller'=>'','tips'=>'Edit this record'),
  						'del'=>array('title'=>'Delete','action'=>'setdel','controller'=>'','tips'=>'Delete this record'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'evaluation_type'=>'Evaluation type','serial'=>'Serial', 'status'=>'Status','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabusevaluationtypemodel');	
	}
	
  public function assigneval($sylabus_id)
  {
  		$this->load->form('sylabusevaluationtypeform','setform');
		$this->setform->set_default('sylabus_id',$sylabus_id);	
		$this->tpl->assign('form_title','ASSIGN SYLABUS EVALUATION TYPE');
  }	
	
	
public function saveeval()
 {
	if(!$this->input->is_ajax_request())
	{
		show_404();
	}
	$this->output->set_content_type('application/json');
	$response = array('success' => 1,'message'=>'');
	$this->load->form('sylabusevaluationtypeform','setform');
	if($this->setform->validate())
	{
	  $this->setform->save();
	  $response = array('success' => 1,'message'=>'');
	  if($this->setform->is_new())
	  $this->session->set_flashdata('success', 'Sylabus evaluation type has been assigned successfully');
	  else
	  $this->session->set_flashdata('success', 'Sylabus evaluation type has been updated successfully');
	}
	else
	{
		$response = array('success' => 0,'message'=>'One or more required fields are missing.');
	} 
	$this->output->set_output(json_encode($response));	
 }
 
public function setedit($id)
{
 	$this->load->model('sylabusevaluationtypemodel','setmodel');
	$info = $this->setmodel->find($id);
	$this->tpl->assign('form_title','EDIT SYLABUS EVALUATION TYPE');
	if(empty($info))
	{
		show_404();
	}
	$this->load->form('sylabusevaluationtypeform','setform',$info);
	$this->tpl->set_view('assigneval');
}
 
public function setview($id)
{
 	$this->load->model('sylabusevaluationtypemodel','setmodel');
	$info = $this->setmodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
	$this->load->helper('date');
	$this->tpl->assign($info);
}
public function setdel($id)
{
 	$this->output->set_content_type('application/json');
 	$this->load->model('sylabusevaluationtypemodel','setmodel');
 	$this->setmodel->delete($id);
 	$response = array('success' => 1);
 	$this->session->set_flashdata('success', 'Sylabus evaluation type has been deleted successfully');
 	$this->output->set_output(json_encode($response));
}
 

public function course($sylabus_id)
{
	
	$this->tpl->set_js(array('jquery.multiselect'));
	$this->tpl->set_css(array('jquery.multiselect'));
	$this->init_course_grid($sylabus_id);
		
}
protected function init_course_grid($sid)
{
   $this->load->library('grid_board');
   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
   $this->grid_board->set_params(array('sylabus_id'=>$sid));
   $column_option = $this->config->item('grid_column_option');
   $column_option['sort'] = false;
   $this->config->set_item('grid_column_option',$column_option);
   $this->grid_board->set_title('Sylabus Course list');
   $this->grid_board->add_link('Assign New Course',site_url('sylabussetup/newcourse/'.$sid),array('class'=>'add','id'=>'new_course'));
   $actions = array(
  					'view'=>array('title'=>'View','action'=>'viewcourse','controller'=>'','tips'=>'View record details'),
  					'edit'=>array('title'=>'Edit','action'=>'editcourse','controller'=>'','tips'=>'Edit this record'),
  					'del'=>array('title'=>'Delete','action'=>'delcourse','controller'=>'','tips'=>'Delete this record'),
  					);
   $this->grid_board->set_action($actions);
   $grid_columns = array('id'=>array('visible'=>false),'course_title'=>'Subject Name','course_type'=>'Course Type','serial'=>'Serial', 'total_marks'=>'Total Marks','status'=>'Status','created_at'=>array('title'=>'Create Date','datetime'=>true));
   $this->grid_board->set_column($grid_columns);
   $this->grid_board->render('coursemodel');	
}

public function newcourse($sylabus_id)
{
  		$this->load->form('courseform',null,array('sylabus_id'=>$sylabus_id));
  		$this->tpl->assign('sylabus_id',$sylabus_id);	
		$this->tpl->assign('form_title','SYLABUS COURSE INFORMATION');
}

public function savecourse($sylabus_id)
{
	if(!$this->input->is_ajax_request())
	{
		show_404();
	}
	$this->output->set_content_type('application/json');
	$response = array('success' => 1,'message'=>'');
	$this->load->form('courseform',null,array('sylabus_id'=>$sylabus_id));
	if($this->courseform->validate())
	{
	  $this->courseform->save();
	  $response = array('success' => 1,'message'=>'');
	  if($this->courseform->is_new())
	  $this->session->set_flashdata('success', 'Course has been assigned successfully');
	  else
	  $this->session->set_flashdata('success', 'Course type has been updated successfully');
	}
	else
	{
		$response = array('success' => 0,'message'=>'One or more required fields are missing.');
	} 
	$this->output->set_output(json_encode($response));	
	
}	
public function editcourse($id)
{
 	$this->load->model('coursemodel');
	$info = $this->coursemodel->find($id);
	$this->tpl->assign('form_title','EDIT COURSE');
	if(empty($info))
	{
		show_404();
	}
	$this->load->model('coursesylabusevaltypemodel','csetmodel');
	$course_evals = $this->csetmodel->get_by_course($info['id']);
	$this->load->model('coursecourseattrmodel','ccamodel');
	$course_attrs = $this->ccamodel->get_by_course($info['id']);
	$this->load->model('coursebookmodel');
	$books = $this->coursebookmodel->get_field('book_id',array('course_id'=>$info['id'],'is_delete'=>0));
	$info['course_evals'] = $course_evals;
	$info['course_attrs'] = $course_attrs;
	$info['books'] = $books;
	$this->load->form('courseform',null,$info);
	$this->tpl->assign('sylabus_id',$info['sylabus_id']);
	$this->tpl->set_view('newcourse');
}
 
public function viewcourse($id)
{
 	$this->load->model('coursemodel');
	$info = $this->coursemodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
	$this->load->helper('date');
	$this->tpl->assign($info);
	$this->load->model('coursesylabusevaltypemodel','csetmodel');
	$course_evals = $this->csetmodel->get_by_course($info['id']);
	$this->tpl->assign('course_evals',$course_evals);
	$this->load->model('coursecourseattrmodel','ccamodel');
	$course_attrs = $this->ccamodel->get_by_course($info['id']);
	$this->tpl->assign('course_attrs',$course_attrs);
}
public function delcourse($id)
{
 	$this->output->set_content_type('application/json');
 	$this->load->model('coursemodel');
 	$info = $this->coursemodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
 	$this->coursemodel->del_course($id);
 	$response = array('success' => 1);
 	$this->session->set_flashdata('success', 'Course has been deleted successfully');
 	$this->output->set_output(json_encode($response));
}

public function examtype($sid){
    
    $this->init_exam_type_grid($sid);
}

protected function init_exam_type_grid($sid){
	   $this->load->library('grid_board');
	   $this->grid_board->query_condition(array('sylabus_id'=>$sid));
	   $this->grid_board->set_params(array('sylabus_id'=>$sid));
	   $column_option = $this->config->item('grid_column_option');
	   $column_option['sort'] = false;
	   $this->config->set_item('grid_column_option',$column_option);
	   $this->grid_board->set_title('Sylabus Exam Type List');
	   $this->grid_board->add_link('Assign New Exam Type',site_url('sylabussetup/newexamtype/'.$sid),array('class'=>'add','id'=>'new_exam'));
	   $actions = array(
  						'view'=>array('title'=>'View','action'=>'examtypeview','controller'=>'','tips'=>'View record details'),
  						'edit'=>array('title'=>'Edit','action'=>'examtypeedit','controller'=>'','tips'=>'Edit this record'),
                                                'eval'=>array('title'=>'Delete','action'=>'examcourseeval','controller'=>'','tips'=>'Assign evaluation'),
  						'del'=>array('title'=>'Delete','action'=>'examtypedel','controller'=>'','tips'=>'Delete this record'),
  						);
	   $this->grid_board->set_action($actions);
	   $grid_columns = array('id'=>array('visible'=>false),'exam_type'=>'Exam type','final_percent'=>'Final Percent','status'=>'Status','created_at'=>array('title'=>'Create Date','datetime'=>true));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('sylabusexamtypemodel');	
	
}

public function newexamtype($sylabus_id){
        $this->load->form('sylabusexamtypeform','setform',array('sylabus_id'=>$sylabus_id));
        $this->tpl->assign('sylabus_id',$sylabus_id);	
        $this->tpl->assign('form_title','SYLABUS EXAM TYPE INFORMATION');
}


public function saveexamtype(){
	if(!$this->input->is_ajax_request())
	{
		show_404();
	}
	$this->output->set_content_type('application/json');
	$response = array('success' => 1,'message'=>'');
	$this->load->form('sylabusexamtypeform','setform');
	if($this->setform->validate())
	{
	  $this->setform->save();
	  $response = array('success' => 1,'message'=>'');
	  if($this->setform->is_new())
	  $this->session->set_flashdata('success', 'Exam type has been assigned successfully');
	  else
	  $this->session->set_flashdata('success', 'Exam type has been updated successfully');
	}
	else
	{
		$response = array('success' => 0,'message'=>'One or more required fields are missing.');
	} 
	$this->output->set_output(json_encode($response));	
}

 public function examtypeedit($id){
        $this->load->model('sylabusexamtypemodel','setmodel');
	$info = $this->setmodel->find($id);
	$this->tpl->assign('form_title','EDIT SYLABUS EXAM TYPE');
	if(empty($info))
	{
		show_404();
	}
       $this->load->form('sylabusexamtypeform','setform',$info);
       $this->tpl->set_view('newexamtype');   
}
 
public function examtypeview($id)
{
 	$this->load->model('sylabusexamtypemodel','setmodel');
	$info = $this->setmodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
        $this->tpl->assign('view_title','Exam type details information');
	$this->load->helper('date');
	$this->tpl->assign('row',$info);
        $this->tpl->assign('labels',array('exam_type'=>'Exam Type','final_percent'=>'Final Percent','status'=>'Status','created_at'=>'Create Date','created_by'=>'Created By'));
        $this->tpl->set_view('elements/record_view',true);
}

public function examtypedel($id){
 	$this->output->set_content_type('application/json');
 	$this->load->model('sylabusexamtypemodel','setmodel');
 	$info = $this->setmodel->get_info($id);
	if(empty($info))
	{
		show_404();
	}
 	$this->setmodel->delete($id);
 	$response = array('success' => 1);
 	$this->session->set_flashdata('success', 'Course has been deleted successfully');
 	$this->output->set_output(json_encode($response));
}

public function examcourseeval($exam_type_id){
    $this->tpl->set_js(array('exam_course_eval'));
    $this->load->model('sylabusexamtypemodel','setmodel');
    $info = $this->setmodel->get_info($exam_type_id);
    $this->load->model('coursemodel');
    $this->load->model('sylabusevaluationtypemodel','evalmodel');
    $this->tpl->assign($info);
}

public function saveexameval(){
   
     $this->load->model('sylabusexamtypecoursemodel','setcmodel');
     $this->setcmodel->save($_POST);
     $response = array('success' => 1,'message'=>'Information has been saved successfully');
     $this->output->set_content_type('application/json');
     $this->output->set_output(json_encode($response));	
}


 
 
	
	
}
