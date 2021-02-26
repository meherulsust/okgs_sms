<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 23, 2012
 * class school class form
 */
class Coursetypeform extends MT_Form{
	var $name = 'coursetype';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Type Name');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
	}
	
	public function get_model()
	{
		return 'coursetypemodel';
	}
  
   
}