<?php

/* 
 * Created on 17-05-2016
 * Developed by: Arena Development Team
 * 
 */

class Class_result_publishform extends MT_Form {
    var $name = 'class_result';
    
    function init() {
        $this->set_name('class_result');
        $this->add_hidden('id');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('exam_id', array('model' => 'exammodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Exam'))->set_label('Examination')->set_validator('required');
        $this->add_submit('submit','Publish',array('class'=>'btn'));
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }
    function get_model() {
        return 'classmodel';
    }
}