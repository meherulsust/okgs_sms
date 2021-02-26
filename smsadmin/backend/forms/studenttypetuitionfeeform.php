<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  section tuition fee form class
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 14, 2012
 */
class Studenttypetuitionfeeform extends MT_Form{
	var $name = 'sttf';
	public function init()
	{
		$this->add_hidden('id');
        $this->add_model_select('tuition_fee_head_id',array('model'=>'tuitionfeeheadmodel','where'=>"status=1 and is_common=0",'add_empty'=>'--Select Fee Head--'))->set_label('Fee Head')->set_validator('required');
        $this->add_model_select('student_type_id',array('model'=>'studenttypemodel','add_empty'=>'--Select Student Type--','order_by'=>'id'))->set_label('Student Type')->set_validator('required');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_model_select('version_id',array('model'=>'versionmodel','add_empty'=>'--Select Version--'))->set_label('Version');
		$this->add_input('ammount',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Amount')
                      ->add_text_before('(Taka)');
                $this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
                $this->add_reset('button','Cancel',array('class'=>'btn','id'=>'cancell-btn'));
	    
	}
	
	public function get_model()
	{
		return 'studenttypetuitionfeemodel';
	}
  
   
}