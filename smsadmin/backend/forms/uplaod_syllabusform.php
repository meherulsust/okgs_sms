<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 **/

class Uplaod_syllabusform extends MT_Form{
	
	 var $name = 'u_syllabus';
    
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('main_image');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Syllabus Name');        		
		$this->add_model_select('class',array('model'=>'classmodel','where'=>'status = "ACTIVE" ','order_by'=>'title asc','add_empty'=>'Select Class'))
                        ->set_label('Select Class');
		$this->add_select('status', array('ACTIVE' => 'Active', 'INACTIVE' => 'Inactive', 'PENDING' => 'Pending'))->set_validator('required')->set_default('ACTIVE');				
		$this->add_file('syllabus_image',array('class'=>'txt'))->set_label('Upload Syllabus');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'upload_syllabus_model';
	}
}
?>
