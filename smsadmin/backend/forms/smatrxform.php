<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Bookform extends MT_Form{
	var $name = 'book';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Book Name');
		$this->add_input('writer_name')->set_label('Writer Name')->set_validator('required');
		$this->add_select('book_type',array('-- Select book type --', 'TEXT'=>'Text','OTHER'=>'Other'))
		->set_validator('required')->set_default('TEXT');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	  	if($this->is_new())
	    {
	   	  $this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
	    }
	}
	
	public function get_model()
	{
		return 'bookmodel';
	}
  
   
}