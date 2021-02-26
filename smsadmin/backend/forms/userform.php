<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */
class Userform extends MT_Form {

    var $name = 'user';

    public function init() {
        $this->set_name('user');
        $this->add_hidden('id');
        $this->add_model_select('user_group_id', array('model' => 'usergroupmodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select User Group'))->set_label('User Group')->set_validator('required');
        $this->add_input('username', array('class' => 'txt'))->set_validator('required')->set_label('User Name');
        $this->add_input('full_name', array('class' => 'txt'))->set_validator('required')->set_label('Full Name');
        $this->add_password('passwd')->set_label('Password')->set_validator('required');
        $this->add_password('repasswd')->set_label('Retype Password')->set_validator('required');
        $this->add_input('email')->set_label('Email')->set_validator('required');
        $this->add_input('mobile_no')->set_label('Mobile')->set_validator('required');
        $this->add_textarea('address', array('style' => 'width:200px;height:100px;'))->set_label('Address');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn'), 'Cancel');
    }

    public function get_model() {
        return 'usermodel';
    }

}