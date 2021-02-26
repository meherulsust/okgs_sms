<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */
class Sendteachermessageform extends MT_Form {

    var $name = 'message';

    public function init() {
        $this->set_name('send_message');
        $this->add_hidden('id');
        $this->add_model_select('message_id',array('model'=>'messagemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select Message--'))->set_label('Message Title')->set_validator('required');
		$this->add_textarea('full_message',array('style'=>'width:400px;height:50px;'))->set_label('Full Message');
		$this->add_model_select('designation',array('model'=>'designationmodel','where'=>"type = 'Admin'",'add_empty'=>'--Select All--'))->set_label('Select Designation');
		$this->add_html('teacher_list','')->set_label('Teacher List');
		$this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'send_message'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn','id'=>'cancell-btn'), 'Cancel');
    }

    public function get_model() {
        return 'sentteachermessagemodel';
    }

}