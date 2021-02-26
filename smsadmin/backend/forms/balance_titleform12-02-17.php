<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class balance_titleform
 */
class balance_titleform extends MT_Form {

    var $name = 'titleform';

    public function init() {
        $this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required|callback_uniquetitle')->set_label('Title');
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive','PENDING'=>'Pending'))->set_default('ACTIVE')->set_validator('required');
		//$this->add_model_select('balance_type_id',array('model'=>'balance_typemodel','add_empty'=>'--Select Type--'))->set_label('Type')->set_validator('required');
		$this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'send_message'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn','id'=>'cancell-btn'), 'Cancel');
    }

    public function get_model() {
        return 'balance_titlemodel';
    }

}