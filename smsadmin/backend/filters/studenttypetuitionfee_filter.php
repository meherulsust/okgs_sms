<?php
/**
 * @ Author      Imrul Hasan
 * @ Created     Dec 18, 2014
 */
class Studenttypetuitionfee_filter extends MT_Filter{
    var $name = 'sttffilter';
    public function init(){
        $this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('student_type_id',array('model'=>'studenttypemodel','add_empty'=>'--Select Student Type--','order_by'=>'id'))->set_label('Student Type');
		$this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Version--'))->set_label('Version');
		$this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
    }
    	
}
?>
