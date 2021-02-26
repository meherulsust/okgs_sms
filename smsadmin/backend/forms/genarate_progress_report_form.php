<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Genarate_progress_report_form extends MT_Form{
	var $name = 'progress_report';
	
	public function init()
	{
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
        //$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_model_select('exam_id',array('model'=>'exammodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Exam--'))->set_label('Exam')->set_validator('required');
		$this->add_submit('submit','Genarate Progress Report',array('class'=>'btn','style'=>'width:200px;'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));  	
	}
	
	public function get_model()
	{
		return 'classmodel';
	}
  
   
}