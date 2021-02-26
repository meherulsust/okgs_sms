<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 8, 2012
 * 
 * Student Absent form 
 */
class Studentpromotionsectionform extends MT_Form{
	var $name = 'promotion';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'--Select Form--'))->set_label('Form')->set_validator('required');
		$this->add_html('student_list','Student List')->set_label('Student List');
		$this->add_model_select('promoted_class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Promoted Class')->set_validator('required');
		$this->add_model_select('promoted_section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'--Select Form--'))->set_label('Promoted Form')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));        
	}
	
	public function get_model()
	{
		return 'studentmodel';
	}
  
   
}