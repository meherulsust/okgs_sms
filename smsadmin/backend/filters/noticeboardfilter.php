<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 21, 2013
 */
class Noticeboardfilter extends MT_Filter{
    var $name = 'nbfilter';
    public function init(){
        
        $this->add_input('notice_title',array('class'=>'txt'))->set_label('Notice Title');
        $this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Version--'))->set_label('Select Version');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_model_select('house_id',array('model'=>'housemodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select House--'))->set_label('Select House');
		$this->add_model_select('facility_id',array('model'=>'extrafacilitymodel','add_empty'=>'--Select Facility--'))->set_label('Select Facility');
		$this->add_input('student_number', array('class' => 'txt'))->set_label('Student Number');
        $this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
		$this->add_submit('submit','Search',array('class'=>'btn')); 		
    }
    	
}
?>
