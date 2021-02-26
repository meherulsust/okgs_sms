<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 21, 2013
 */
class StudentFilter extends MT_Filter{
    var $name = 'sfilter';
    public function init(){
        
        $this->add_input('student_number')->set_label('Student Id');
        $this->add_input('first_name')->set_label('Name');
        $this->add_input('mobile')->set_label('Mobile');
        $this->add_select('gender',array('All', 'MALE'=>'Male','FEMALE'=>'Female'))->set_label('Gender');
        $this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class');
        $this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))
                            ->set_label('Form');
        $this->add_model_select('student_type_id',array('model'=>'studenttypemodel','add_empty'=>'--Select Type--','order_by'=>'id asc'))->set_label('Student Type');
		//$this->add_model_select('house_id',array('model'=>'housemodel','add_empty'=>'--Select House--','order_by'=>'id asc'))->set_label('House');
		$this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Medium/Version--'))->set_label('Medium/Version');
		$this->add_model_select('extra_facility_id',array('model'=>'extrafacilitymodel','add_empty'=>'--Select Facility--'))->set_label('Select facility');
	$this->add_select('religion',array('Select', 'Islam' => 'Islam', 'Hindu' => 'Hindu', 'Chrisrtiain' => 'Chrisrtiain', 'Buddha' => 'Buddha', 'Others' => 'Others'))->set_label('Religion');
                $this->add_submit('reset','Reset Filter',array('class'=>'btn','id'=>'reset'));
        $this->add_submit('submit','Search',array('class'=>'btn'));
        
        
    }
    public function build_condition1($model) {
        if($this->values['gender']){
            $model->db->where('gender',$this->values['gender']);
        }
    }
}
?>
