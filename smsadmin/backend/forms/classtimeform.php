<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Classtimeform extends MT_Form{
    var $name = 'class_time';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_input('title')->set_label('Class Time')->set_validator('required');
		$this->add_input('serial')->set_label('Serial No.')->set_validator('required');
        $this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));   	   
	}
	
	public function get_model()
	{
		return 'classtimemodel';
	}
}
?>
