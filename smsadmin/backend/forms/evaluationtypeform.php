<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 23, 2012
 * form class school class for evaluation type
 */
class Evaluationtypeform extends MT_Form{
	var $name = 'eval_type';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Title');
		$this->add_select('eval_type',array('TEXT'=>'TEXT','NUMBER'=>'NUMBER','BOOL'=>'BOOL'))->set_default('TEXT');
		$this->add_input('eval_func',array('class'=>'txt'))->set_validator('required')->set_label('Evaluation Function');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
	}
	
	public function get_model()
	{
		return 'evaluationtypemodel';
	}
  
   
}