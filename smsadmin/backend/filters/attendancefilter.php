<?php
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class Attendancefilter extends MT_Filter{
    var $name = 'attfilter';
    public function init(){
        $this->add_input('full_name')->set_label('Name');
		$this->add_input('student_number')->set_label('Student Id');
		$this->add_select('attendance_status',array(''=>'--Select Status--','Present'=>'Present','Absent'=>'Absent'))->set_label('Attendance Status');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_input('date')->set_label('Attendance Date');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
