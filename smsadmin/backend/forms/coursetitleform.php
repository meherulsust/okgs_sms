<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 31, 2013
 * Course title form class
 */
class Coursetitleform extends MT_Form {

    var $name = 'course_title';

    public function init() {
        $this->add_hidden('id');
        $this->add_input('title', array('class' => 'txt'))->set_validator('required')->set_label('Course Title');
		$this->add_input('order', array('class' => 'txt'))->set_validator('required')->set_label('Order');
		$this->add_select('status', array('ACTIVE' => 'Active', 'INACTIVE' => 'Inactive', 'PENDING' => 'Pending'))->set_validator('required')->set_default('ACTIVE');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }

    public function get_model() {
        return 'coursetitlemodel';
    }

}