<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Teacherform extends MT_Form{
    var $name = 'teacher';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('main_photo');
		$this->add_input('name',array('class'=>'txt'))->set_validator('required')->set_label('Full Name');
		$this->add_model_select('designation_id',array('model'=>'designationmodel','where'=>'type = "Admin" ','add_empty'=>'--Select --'))->set_validator('required')->set_label('Designation');
		$this->add_input('order',array('class'=>'txt'))->set_validator('required')->set_label('Display Order');
		$this->add_input('username', array('class' => 'txt'))->set_validator('required|callback_uniqueusername')->set_label('Username');
        $this->add_password('passwd')->set_label('Password')->set_validator('required');		
		$this->add_input('datepicker',array('class'=>'txt'))->set_validator('required')->set_label('Date Of Birth');
		$this->add_select('gender',array('Select gender', 'MALE'=>'Male','FEMALE'=>'Female'))->set_validator('required')->set_default('MALE');
		$this->add_model_select('blood_group_id',array('model'=>'bloodgroupmodel','add_empty'=>'--Select --'))->set_label('Blood Group');
		$this->add_model_select('religion_id',array('model'=>'religionmodel'))->set_default('1')->set_label('Religion');
		$this->add_textarea('address',array('style'=>'width:280px;height:50px;'));
		$this->add_input('mobile_no')->set_validator('required')->set_label('Mobile Number');
		$this->add_input('email')->set_label('Email')->set_validator('valid_email');
		$this->add_hidden('dob');
		$this->add_model_select('relevant_subject_id',array('model'=>'coursetitlemodel','where'=>'status = "ACTIVE" ','order_by'=>'title asc','add_empty'=>'Select Subject'))
                        ->set_label('Relevant Subject');
		$this->add_input('edulabel',array('class'=>'txt'))->set_validator('required')->set_label('Qualification');
		$this->add_file('photo',array('class'=>'txt'))->set_label('Select Photo')->set_validator('required')->add_text_after('<span style="margin-left:25px;font-weight:bold;color:red"> Max. Width x Height : 300x300, Max. Size : 200 KB</span>');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'teachermodel';
	}
}
?>
