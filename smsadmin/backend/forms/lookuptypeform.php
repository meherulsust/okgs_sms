<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 17, 2013
 * form class for admission
 */
class Lookuptypeform extends MT_Form{
	var $name = 'lookup_type';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('unique_code')->set_label('Lookup type code')->set_validator('required|callback_type_code_unique');
		$this->add_input('title')->set_label('Lookup Type')->set_validator('required');
		$this->add_textarea('comments',array('style'=>'width:200px;height:100px;'))->set_label('Comments');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
	}
	
	public function get_model()
	{
		return 'lookuptypemodel';
	}
  
   
}