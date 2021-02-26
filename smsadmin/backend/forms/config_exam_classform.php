<?php

/* 
 * Created on 18-04-2016
 * Developed by: Arena Development Team
 * 
 */

class Config_exam_classform extends MT_Form {
    var $name = 'config_exam_class';
    
    function init() {
        $this->set_name('config_exam_class');
        $this->add_hidden('id');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('exam_id', array('model' => 'exammodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Exam'))->set_label('Examination')->set_validator('required');
        $this->add_model_select('subject_id', array('model' => 'coursetitlemodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Subject'))->set_label('Subject')->set_validator('required');
        $this->add_input('total_marks',array('class'=>''))->set_validator('required')->set_label('Total Marks');
//        $this->add_input('pass_marks',array('class'=>''))->set_validator('required')->set_label('Pass Marks');
        
    }
    function get_model() {
        return 'classmodel';
    }
}