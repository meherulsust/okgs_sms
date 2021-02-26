<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class Houseform extends MT_Form {

    var $name = 'house';

    public function init() {
        $this->add_hidden('id');
        $this->add_input('title', array('class' => 'txt'))->set_validator('required')->set_label('Title');
        $this->add_textarea('description', array('style'=>'width:300px;height:100px;'))->set_label('Description');
        $this->add_submit('submit', 'Submit', array('class' => 'btn','id'=>'house'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn'), 'Cancel');
    }

    public function get_model() {
        return 'housemodel';
    }

}