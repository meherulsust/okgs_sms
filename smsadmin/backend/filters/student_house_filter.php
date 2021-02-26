<?php
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class Student_house_filter extends MT_Filter{
    var $name = 'shfilter';
    public function init(){
        $this->add_input('first_name')->set_label('Name');
		$this->add_model_select('house_id',array('model'=>'housemodel','add_empty'=>'--Select House--'))->set_label('House');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
