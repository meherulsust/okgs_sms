<?php
/* 
 * Created on 14-06-2016
 * Developed by: Arena Development Team
 * 
 */
class Template_grid_boardform extends MT_Form {
    var $name = 'template_grid';
    function init() {
        $this->set_name('template_grid');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('section_id', array('model' => 'sectionmodel', 'where' => "class_id='" . $this->get_default('class_id', 0) . "'", 'add_empty' => 'Select Form'))->set_label('Form')->set_validator('required');
        $this->add_model_select('exam_id', array('model' => 'exammodel', 'where' => "status='ACTIVE'", 'add_empty' => 'Select Exam'))->set_label('Examination')->set_validator('required');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));        
        $this->add_button(array('class' => 'btn'), 'Cancel');
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }
    function get_model() {
        return 'pen_picturemodel';
    }
}