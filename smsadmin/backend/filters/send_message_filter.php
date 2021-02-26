<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 21, 2013
 */
class Send_message_filter extends MT_Filter{
    var $name = 'msgfilter';
    public function init(){
        $this->add_model_select('message_id',array('model'=>'messagemodel','add_empty'=>'--Select Class--'))->set_label('Message');
        $this->add_model_select('house_id',array('model'=>'housemodel','add_empty'=>'--Select House--'))->set_label('House');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
