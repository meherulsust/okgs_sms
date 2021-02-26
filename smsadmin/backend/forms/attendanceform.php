<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 8, 2012
 * 
 * Student Absent form 
 */
class Attendanceform extends MT_Form{
	var $name = 'attendance';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'--Select Form--'))->set_label('Form')->set_validator('required');
		$this->add_html('student_list','')->set_label('Student List');
		$this->add_input('adatepicker',array('class'=>'txt'))->set_validator('required')->set_label('Attendance Date')->skip();
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
        $this->add_hidden('attendance_date');
	    
	}
	
	public function get_model()
	{
		return 'attendancemodel';
	}
  
   
}