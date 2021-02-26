<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */

class Classform extends MT_Form{
        var $name = 'class';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Class Title');
		$this->add_input('code',array('style'=>'width:100px;'))->set_label('Class Code')->set_validator('required');
                $this->add_input('serial',array('style'=>'width:100px;'))->set_label('Serial No.')->set_validator('required');
//		$this->add_submit('submit','Submit',array('class'=>'btn'));
//	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	    
	}
	
	public function get_model()
	{
		return 'classmodel';
	}
}
?>