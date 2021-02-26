<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 27, 2012
 * form class for admission
 */
class Admissionform extends MT_Form{
	var $name = 'admission';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('student_id');
		$this->add_model_select('student_type_id',array('model'=>'studenttypemodel','add_empty'=>'--Select Student Type--','order_by'=>'id asc'))->set_label('Student Type')->set_validator('required');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'--Select Form--'))
                            ->set_label('Form');
		$this->add_model_select('sylabus_id',array('model'=>'sylabusmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'Deafult'))->set_label('Sylabus');
		$this->add_input('session',array('style'=>'width:100px;'))->set_label('Session')->set_default($this->get_default('session',date('Y')))->set_validator('required');
		$this->add_input('class_roll',array('style'=>'width:100px;'))->set_label('Roll')->set_validator('required');
        $this->add_input('board_roll',array('style'=>'width:100px;'))->set_label('Board Roll');
		$this->add_input('board_regino')->set_label('Board Registration');
		$this->add_input('index_no')->set_label('Index No.');
		$this->add_input('birth_regino')->set_label('Birth Registration No.')->set_validator('required');
		$this->add_input('fee',array('style'=>'width:100px;'))->set_label('Admission Fee')->set_validator('required');
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_textarea('comments',array('style'=>'width:200px;height:20px;'))->set_label('Comments');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
	}
	
	public function get_model()
	{
		return 'admissionmodel';
	}
  
   
}