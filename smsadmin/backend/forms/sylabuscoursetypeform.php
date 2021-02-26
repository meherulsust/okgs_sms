<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 03, 2012
 * form class school class sylabuscoursetype
 */
class Sylabuscoursetypeform extends MT_Form{
	var $name = 'sylabus_course_type';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('sylabus_id');
		$this->add_model_select('course_type_id',array('model'=>'coursetypemodel','add_empty'=>'Select course type','where'=>"status='ACTIVE'"))->set_label('Course Type')->set_validator('required');
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	public function get_model()
	{
		return 'sylabuscoursetypemodel';
	}
  
   
}