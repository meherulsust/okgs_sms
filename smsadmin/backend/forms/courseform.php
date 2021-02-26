<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 09, 2012
 * form class of course
 */
class Courseform extends MT_Form{
	var $name = 'course';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('sylabus_id');
		$this->add_model_select('course_title_id',array('model'=>'coursetitlemodel','where'=>'status = "ACTIVE" ','order_by'=>'title asc','add_empty'=>'Select subject'))
                        ->set_label('Subject Title')->set_validator('required');
		$this->add_input('code',array('style'=>'width:100px;'))->set_label('Subject Code')->set_validator('required');
                $this->add_input('serial',array('style'=>'width:100px;'))->set_label('Display Serial')->set_validator('required');
		$this->add_input('total_marks',array('style'=>'width:100px;'))->set_label('Total Marks')->set_validator('number');
		$this->add_model_select('sylabus_course_type_id',array('model'=>'sylabuscoursetypemodel','method'=>'get_course_type_list','params'=>array('sylabus_id'=>$this->get_default('sylabus_id',0)),'add_empty'=>'Select Course Type'))
			->set_label('Course Type ')->set_validator('required');
		$this->append_evaluation_fields();
		$this->append_course_attribute_fields();
		$fld = $this->add_model_select('books[]',array('model'=>'sylabusmodel','method'=>'default_book_list','params'=>array('sylabus_id'=>$this->get_default('sylabus_id',0))),array('class'=>'book-list','multiple'=>'multiple'))->set_label('Referenced Book');
		if(!$this->is_new() && !$this->is_submit())
		{
			$fld->set_default($this->get_default('books'));
		}
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	protected function append_evaluation_fields()
	{
		$this->CI->load->model('sylabusevaluationtypemodel','setmodel');
		$eval_types = $this->CI->setmodel->get_eval_by_sylabus($this->get_default('sylabus_id',0));	
		if(!$this->is_new())
		{
			$course_evals = array();
			// not required during form submission.
			if(!$this->is_submit())
			{
				$course_evals = array_assoc_by_key($this->get_default('course_evals'),'sylabus_evaluation_type_id');
			}	
			
		}
		
		foreach($eval_types as $k=>$et)
		{
			$title = $et['title'];
			$attributes = array();
			$cset_id = '';
			// for edit
			if(!$this->is_new())
			{
				
				if($course_evals && array_key_exists($et['eval_id'],$course_evals))
				{
					$attributes['value'] = $course_evals[$et['eval_id']]['value'];
					$cset_id = $course_evals[$et['eval_id']]['id'];
				}	
					
			}
			switch($et['eval_type'])
			{
				case 'NUMBER':
							 	$title .= ' Marks';
							    $attributes['style']='width:50px;';
				case 'TEXT'	 : 
								 $this->add_input('evaluation['.$et['eval_id'].'][value]',$attributes)->set_label($title);
								 $this->add_hidden('evaluation['.$et['eval_id'].'][id]',$cset_id);
								 break;
				case 'BOOL'	 : 
								break;
					
			   		
			
			}
		}
	}
	
	protected function append_course_attribute_fields()
	{
		$this->CI->load->model('courseattributemodel','camodel');
		$course_attributes = $this->CI->camodel->get_course_attribute();
		if(!$this->is_new())
		{
			// not required during form submission.
			$cc_attrs = array();
			if(!$this->is_submit())
			{
				$cc_attrs =  array_assoc_by_key($this->get_default('course_attrs'),'course_attribute_id');
			}	
			
		}
		foreach($course_attributes as $ca)
		{
			$title = $ca['title'];
			$attributes = array();
			$cca_id = '';	
			if(!$this->is_new())
			{

				if($cc_attrs && array_key_exists($ca['id'],$cc_attrs))
				{
					$attributes['value'] = $cc_attrs[$ca['id']]['value'];
					$cca_id = $cc_attrs[$ca['id']]['id'];
				}
			}	
			switch($ca['eval_type'])
			{
				case 'NUMBER':
							 	$title .= ' Marks';
							    $attributes['style']='width:50px;';
					
				case 'TEXT'	 : 
								 $this->add_input('attributes['.$ca['id'].'][value]',$attributes)->set_label($title);
								 $this->add_hidden('attributes['.$ca['id'].'][id]',$cca_id);
								 break;
				case 'BOOL'	 :   
								break;
					
			   		
			
			}
		}
	}
	
	
	
	public function get_model()
	{
		return 'coursemodel';
	}
	
}
