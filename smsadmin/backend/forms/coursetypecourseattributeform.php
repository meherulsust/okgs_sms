<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 13, 2012
 * Form class for course type course attribute.
 */
class Coursetypecourseattributeform extends MT_Form {
	var $name = 'type_atribute';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('course_type_id');
		$this->add_model_select('course_attribute_id',array('model'=>'courseattributemodel','where'=>"status = 'ACTIVE' and attribute_for='COURSE_TYPE' ",'add_empty'=>'Select Course Attribute'))
			->set_label('Course Type Attribute ')->set_validator('required');
		$this->add_input('params',array('class'=>'txt'))->set_label('Parameters');
                $this->add_input('execution_order',array('class'=>'txt','style'=>'width:100px;'))->set_label('Execution Order');
                $this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	   	
	}
	
	public function get_model()
	{
		return 'coursetypecourseattributemodel';
	}
  
   
}