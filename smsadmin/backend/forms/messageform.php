<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */
class Messageform extends MT_Form {

    var $name = 'message';

    public function init() {
        $this->set_name('message');
        $this->add_hidden('id');
        $this->add_input('title', array('class' => 'txt'))->set_validator('required')->set_label('Title');
        $this->add_textarea('description', array('style'=>'width:200px;height:100px;'))->set_validator('required')->set_label('Description');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn'), 'Cancel');
    }

    public function get_model() {
        return 'messagemodel';
    }

}