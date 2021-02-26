<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */
class Noticeboardform extends MT_Form {

    var $name = 'notice';

    public function init() {
        $this->set_name('notice_board');
        $this->add_hidden('id');
        $this->add_input('notice_title', array('class' => 'txt'))->set_label('Notice Title')->set_validator('required');
        $this->add_textarea('full_notice', array('style' => 'width:400px;height:100px;'))->set_label('Full Notice')->set_validator('required');
        $this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Version--'))->set_label('Select Version');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_model_select('house_id',array('model'=>'housemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select House--'))->set_label('Select House');
		$this->add_model_select('facility_id',array('model'=>'extrafacilitymodel','add_empty'=>'--Select Facility--'))->set_label('Select Facility');
		$this->add_input('student_number', array('class' => 'txt'))->set_label('Student Number');
        $this->add_model_select('designation_id',array('model'=>'designationmodel','where'=>'type = "Admin" ','add_empty'=>'--Select --'))->set_label('Designation');
		$this->add_submit('submit', 'Submit', array('class' => 'btn', 'id' => 'notice'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }

    public function get_model() {
        return 'noticeboardmodel';
    }

}