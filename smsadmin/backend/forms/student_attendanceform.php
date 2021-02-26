<?php
/**
 * @ Author      Avijit Chakravarty <a.chakravarty@outlook.com>
 * @ Created     July 31, 2016
 * Form to filter attendance
 */
class Student_attendanceform extends MT_Form {
    var $name = 'stdattendance';
    function init() {
        $this->set_name('stdattendance');
        $this->add_input('full_name')->set_label('Name');
        $this->add_input('student_number')->set_label('Student Number');
//        $this->add_select('attendance_status',array('Present'=>'Present','Absent'=>'Absent'))->set_label('Attendance Status');
        $this->add_model_select('class_id', array('model' => 'classmodel', 'where' => 'status="ACTIVE"', 'add_empty' => 'Select Class'))->set_label('Class')->set_validator('required');
        $this->add_model_select('section_id', array('model' => 'sectionmodel', 'where' => "class_id='" . $this->get_default('class_id', 0) . "'", 'add_empty' => 'Select Form'))->set_label('Form');
        $this->add_input('date_from')->set_label('Date From')->set_validator('required');
        $this->add_input('date_to')->set_label('Date to')->set_validator('required');
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));        
        $this->add_button(array('class' => 'btn'), 'Cancel');
        $this->add_reset('button', 'Reset', array('class' => 'btn'));
    }
    function get_model() {
        return 'studentmodel';
    }
}