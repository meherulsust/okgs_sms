<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    October 13, 2012
 * class school class form
 */
class Courseattributeform extends MT_Form{
	var $name = 'course_atribute';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Attribute Name');
		$this->add_select('attribute_for',array('SYLLABUS'=>'Syllabus','COURSE_TYPE'=>'Course Type','COURSE'=>'Course','OTHER'=>'Other'))->set_default('COURSE_TYPE');
		$this->add_select('eval_type',array('TEXT'=>'TEXT','NUMBER'=>'NUMBER','BOOL'=>'BOOL'))->set_default('TEXT');
		$this->add_input('eval_func',array('class'=>'txt'))->set_validator('required')->set_label('Attribute Function');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	}
	
	public function get_model()
	{
		return 'courseattributemodel';
	}
  
   
}
