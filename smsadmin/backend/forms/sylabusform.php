<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Sylabusform extends MT_Form{
	var $name = 'sylabus';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Syllabus Name');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--'))->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',2),'add_empty'=>'All Form'))->set_label('Form');
		$this->add_input('total_marks',array('style'=>'width:100px;'))->set_label('Total Marks')->set_validator('required');
		$this->add_input('percent_to_pass',array('style'=>'width:100px;'))->set_label('% Of Marks To Pass ')->set_validator('required');
                $this->add_model_select('result_scale_id',array('model'=>'resultscalemodel','add_empty'=>'--Select Class--','where'=>"status = 'ACTIVE'"))->set_label('Result Scale')->set_validator('required');
                $this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn'),'Cancel');
	}
	
	public function get_model()
	{
		return 'sylabusmodel';
	}
  
   
}