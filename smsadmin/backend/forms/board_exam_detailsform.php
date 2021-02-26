<?php

/* 
 * @ Author         Avijit Chakravarty
 * 
 * @ Created        Jan 26, 2017
 */

class Board_exam_detailsform extends MT_Form{
    var $name = 'boardexam';
    
    public function init() {
        $this->add_hidden('id');
        $this->add_hidden('main_image');
        $this->add_model_select('board_exam_id', array('model' => 'board_examsmodel', 'add_empty' => '---Select Examination---', 'order_by' => 'id asc'))->set_label('Examination')->set_validator('required');
        $this->add_textarea('description')->set_label('Description');
        $this->add_select('year',array('0'=>'---- Select Year ----','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year')->set_validator('required');
        $this->add_file('file_name', array('class' => 'txt'))->set_label('File');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('reset', 'Reset', array('class' => 'btn'));
    }
    function get_model() {
        return 'board_exams_detailsmodel';
    }
}