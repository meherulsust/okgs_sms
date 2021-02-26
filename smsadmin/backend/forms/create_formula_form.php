<?php
/* 
 * Created on 21-04-2016
 * Developed by: Arena Development Team
 * 
 */
class Create_formula_form extends MT_Form {
    var $name = 'create_formula';
    function init() {
        $this->set_name('create_formula');
        $this->add_hidden('id');
        $this->add_hidden('hidden_formula');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('exam_id', array('model' => 'exammodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Exam'))->set_label('Examination')->set_validator('required');
        $this->add_model_select('subject_id', array('model' => 'coursetitlemodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Subject'))->set_label('Subject')->set_validator('required');
        $this->add_input('formula', array('style' => 'width: 450px; clear:both;', 'readonly' =>'readonly'))->set_label('Formula')->set_validator('required');        
    }
    function get_model() {
        return 'result_formulamodel';
    }
}