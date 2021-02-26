<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class Studenthouseform extends MT_Form {

    var $name = 'student_house';

    public function init() {
        $this->set_name('student_house');
        $this->add_hidden('id');
        $this->add_model_select('house_id',array('model'=>'housemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select House--'))->set_label('Select House')->set_validator('required');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form')->set_validator('required');
		$this->add_html('student_list','')->set_label('Student List');
		$this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'student_house'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }

    public function get_model() {
        return 'studenthousemodel';
    }

}