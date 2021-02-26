<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Avijit Chakravarty
 * @ Created     Jan 10, 2017
 */
class Set_extra_classform extends MT_Form{
    var $name = 'extraclass';
	
    public function init(){
        $this->add_hidden('id');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'add_empty' => '--Select Class--', 'order_by' => 'serial asc'))->set_label('Class')->set_validator('required');
        $this->add_model_select('section_id', array('model' => 'sectionmodel', 'where' => "class_id='" . $this->get_default('class_id', 0) . "'", 'add_empty' => '--Select Section--'))->set_label('Section')->set_validator('required');
        $this->add_model_select('subject_id', array('model' => 'coursetitlemodel', 'where' => 'status = "ACTIVE" ', 'order_by' => 'title asc', 'add_empty' => 'Select Subject'))
                ->set_label('Subject Title')->set_validator('required');
        $this->add_model_select('teacher_id', array('model' => 'teachermodel', 'value' => 'name', 'where' => 'status = "ACTIVE" ', 'order_by' => 'name asc', 'add_empty' => '--Select Teacher --'))->set_label('Teacher')->set_validator('required');
        $this->add_model_select('class_day_id', array('model' => 'classdaymodel', 'add_empty' => '-- Select Day --', 'order_by' => 'id asc'))->set_label('Class Day')->set_validator('required');
        $this->add_model_select('class_time_id', array('model' => 'classtimemodel', 'where' => "class_id='" . $this->get_default('class_id', 0) . "'", 'add_empty' => '--Select Time--', 'order_by' => 'serial asc'))->set_label('Class Time')->set_validator('required');
        $this->add_input('class_date', array('class' => 'txt'))->set_validator('required');;        
        $this->add_submit('submit', 'Submit', array('class' => 'btn', 'id' => 'submit_btn'));
        $this->add_reset('reset', 'Reset', array('class' => 'btn', 'id' => 'reset_btn'));
    }
	
	public function get_model()
	{
		return 'extra_classmodel';
	}
}
