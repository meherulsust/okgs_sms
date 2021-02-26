<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 21, 2013
 */
class Studenttransferfilter extends MT_Filter{
    var $name = 'stfilter';
    public function init(){
        
        $this->add_input('student_number')->set_label('Student Id');
        $this->add_input('first_name')->set_label('Name');
        $this->add_input('mobile')->set_label('Mobile');
        $this->add_select('gender',array('All', 'MALE'=>'Male','FEMALE'=>'Female'))->set_label('Gender');
        $this->add_submit('submit','Search',array('class'=>'btn'));
        
    }
}
?>
