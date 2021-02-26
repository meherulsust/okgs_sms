<?php

/* 
 * Created on 11-05-2016
 * Developed by: Arena Development Team
 * 
 */

class Configure_subjectsform extends MT_Form {
    var $name = 'configure_exam_class';
    
    function init() {
        $this->set_name('configure_subjects');
        $this->add_hidden('id');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('course_title_id', array('model' => 'coursetitlemodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Subject'))->set_label('Subject')->set_validator('required');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_button(array('class' => 'btn', 'id' => 'btn-cancel'), 'Cancel');
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }
    function get_model() {
        return 'classmodel';
    }
}