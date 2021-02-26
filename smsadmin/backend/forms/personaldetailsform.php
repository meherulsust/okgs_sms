<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    May 12, 2011
 * class personaldetailsform
 */

class Personaldetailsform extends MT_Form{
       var $name = 'personal';
	public function init()
	{
		$this->add_hidden('std_id');
		$this->add_hidden('std_number');
		$this->add_hidden('id');
		$this->add_input('student_number',array('class'=>'txt'))->set_validator('required|callback_duplicate_std_number_check');
		$this->add_input('first_name',array('class'=>'txt'))->set_validator('required');
		$this->add_input('last_name',array('class'=>'txt'));
		$this->add_input('passwd',array('class'=>'txt'))->set_label('Password');
		$this->add_input('datepicker',array('class'=>'txt'))->set_validator('required')->set_label('Date Of Birth');
		$this->add_select('gender',array('Select gender', 'MALE'=>'Male','FEMALE'=>'Female'))->set_validator('required')->set_default('MALE');
		$this->add_model_select('blood_group_id',array('model'=>'bloodgroupmodel','add_empty'=>'--Select --'))->set_label('Blood Group');
		$this->add_model_select('religion_id',array('model'=>'religionmodel'))->set_default('1')->set_label('Religion')->skip();
		$this->add_model_select('caste_id',array('model'=>'castemodel','where'=>'religion_id=1'))->set_default('1')->set_label('Caste');
		$this->add_input('mobile')->set_validator('required')->set_label('Contact Number');
		$this->add_input('email')->set_label('Email');
		$this->add_select('is_tribe',array('YES'=>'YES','NO'=>'NO'))->set_default('NO');
		$this->add_model_select('nationality_id',array('model'=>'nationalitymodel'))->set_default('1')->set_label('Nationality');
		$this->add_textarea('comments',array('style'=>'width:280px;height:150px;'));
		$this->add_model_select('student_group_id',array('model'=>'studentgroupmodel','add_empty'=>'--Select --'))->set_label('Group');
		$this->add_model_select('subject_group_id',array('model'=>'subjectgroupmodel','add_empty'=>'--Select --'))->set_label('Subject Group');
                $this->add_hidden('student_id');
		$this->add_hidden('dob');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));
                if($this->CI->input->is_ajax_request()){
                    $this->add_button(array('class' => 'btn cancel', 'id' => 'btn-cancel'), 'Cancel');
                    $this->add_hidden('cancel_url',site_url('student/personal/type/personal/std_id/'.$this->get_default('student_id').'/id/'.$this->get_default('id').'/actn/view'));
                }
	   
	}
	
	public function get_model()
	{
		return 'personaldetailsmodel';
	}
}
?>
