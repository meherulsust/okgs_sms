<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Thanaform extends MT_Form{
    var $name = 'thana';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('name',array('class'=>'txt'))->set_validator('required');
		$this->add_model_select('district_id',array('model'=>'districtmodel','value'=>'name','add_empty'=>'--Select --'))->set_label('District')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'thanamodel';
	}
}
?>
