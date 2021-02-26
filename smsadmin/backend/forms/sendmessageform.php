<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */
class Sendmessageform extends MT_Form {

    var $name = 'message';

    public function init() {
        $this->set_name('send_message');
        $this->add_hidden('id');
        $this->add_model_select('message_id',array('model'=>'messagemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select Message--'))->set_label('Message Title')->set_validator('required');
		$this->add_textarea('full_message',array('style'=>'width:400px;height:50px;'))->set_label('Full Message');
		$this->add_model_select('house_id',array('model'=>'housemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select House--'))->set_label('Select House');
		$this->add_model_select('facility_id',array('model'=>'extrafacilitymodel','add_empty'=>'--Select Facility--'))->set_label('Select Facility');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_html('student_list','')->set_label('Student List');
		$this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'send_message'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn','id'=>'cancell-btn'), 'Cancel');
    }

    public function get_model() {
        return 'sentmessagemodel';
    }

}