<?php
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    November 01, 2015
 */
class Unpaid_message_filter extends MT_Filter{
    var $name = 'upfilter';
    public function init(){
		$this->add_input('student_number')->set_label('Student Number');
        $this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
		$this->add_input('mobile')->set_label('Mobile');
		$this->add_input('class_roll')->set_label('Class Roll');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
