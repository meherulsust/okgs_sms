<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 04, 2012
 * form class school class sylabus evaluation type
 */
class Sylabusevaluationtypeform extends MT_Form{
	var $name = 'sylabus_eval_type';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('sylabus_id');
		$this->add_model_select('evaluation_type_id',array('model'=>'evaluationtypemodel','add_empty'=>'Select evaluation type','where'=>'status="ACTIVE"'))->set_label('Evaluation Type')->set_validator('required');
		$this->add_input('serial',array('style'=>'width:100px;'))->set_label('Display Serial')->set_validator('required');
                $this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	public function get_model()
	{
		return 'sylabusevaluationtypemodel';
	}
  
   
}
