<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    May 12, 2011
 * class guardian form
 */
class Fatherform extends MT_Form {

    public function init() {
        $this->set_name('father');
        $this->add_hidden('id');
        $this->add_input('first_name', array('class' => 'txt'))->set_validator('required');
        $this->add_input('last_name', array('class' => 'txt'))->set_label('Last Name');
        $this->add_input('anual_income', array('style' => 'width:100px;'))->set_label('Anual Income')->set_validator('required');
        $this->add_model_select('occupation_id', array('model' => 'occupationmodel'))->set_default('1')->set_label('Occupation');
        $this->add_model_select('designation_id',array('model'=>'designationmodel','where'=>'type = "Guardian" '))->set_default('1')->set_label('Designation');
		$this->add_input('service_no', array('class' => 'txt'))->set_validator('required')->set_label('Service No / Institute');
        $this->add_input('national_id', array('class' => 'txt'))->set_validator('required')->set_label('National ID Number');
        $this->add_input('mobile')->set_label('Mobile')->set_validator('required');
        $this->add_hidden('student_id', '');
        $this->add_hidden('relationship_id', 2);
        $this->add_submit('submit', 'Submit', array('class' => 'btn'));
        $this->add_reset('button','Reset',array('class'=>'btn'));
        $this->add_button(array('class'=>'btn cancel','id'=>'btn-cancel'),'Cancel');
            
    }

    public function get_model() {
        return 'guardianmodel';
    }

}

?>