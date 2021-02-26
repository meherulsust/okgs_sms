<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 11, 2012
 * class school class form
 */
class Sectionform extends MT_Form {

    var $name = 'section';

    public function init() {
        $this->add_hidden('id');
        $this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Version--'))->set_label('Version/Medium')->set_validator('required');
        $this->add_input('title', array('class' => 'txt'))->set_validator('required')->set_label('Form Title');
        $this->add_input('room_number', array('class' => 'txt'))->set_validator('required')->set_label('Room Number');
        $this->add_textarea('description', array('style' => 'width:200px;height:100px;'))->set_label('Description');
        $this->add_hidden('class_id');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn','id'=>'btn-cancel'), 'Cancel');
    }

    public function get_model() {
        return 'sectionmodel';
    }

}

?>