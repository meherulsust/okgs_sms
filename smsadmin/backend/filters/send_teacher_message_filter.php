<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 21, 2013
 */
class Send_teacher_message_filter extends MT_Filter{
    var $name = 'msgfilter';
    public function init(){
        $this->add_model_select('designation',array('model'=>'designationmodel','where'=>"type='Admin'",'add_empty'=>'--Select Designation--'))->set_label('Designation');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
