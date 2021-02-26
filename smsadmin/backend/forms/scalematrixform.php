<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 20, 2012
 * class resultscaleform for generating result scale.
 */
class Scalematrixform extends MT_Form{
	var $name = 'scale_matrix';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('result_scale_id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Title');
		$this->add_input('min_range',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Minimum Range');
		$this->add_input('max_range',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Maximum Range');
		$this->add_input('weight',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Weight');
		$this->add_input('grade_title',array('class'=>'txt'))->set_validator('required')->set_label('Grade Title');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-sm-cancel'),'Cancel');
	
	}
	
	public function get_model()
	{
		return 'scalematrixmodel';
	}
  
   
}