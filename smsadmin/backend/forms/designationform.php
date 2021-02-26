<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Designationform extends MT_Form{
    var $name = 'designation';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required');
		$this->add_select('type',array('Admin'=>'Admin','Guardian'=>'Guardian'));
		$this->add_textarea('description',array('style'=>'width:280px;height:50px;'));
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'designationmodel';
	}
}
?>
