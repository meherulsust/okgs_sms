<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advancefeegenerateform extends MT_Form{
	var $name = 'fee_generate';
	public function init()
	{
		$this->add_input('student_number',array('class'=>'txt'))->set_validator('required')->set_label('Student Number')
                      ->add_text_after('<span class="req">*</span> &nbsp; <a href="#" id="std-check" class="check-lnk">Check Student</a>');
		$this->add_select('year',array(''=>'Select Year','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year')->set_validator('required');
		$this->add_html('month_list','')->set_label('Month');
		$this->add_input('start_date',array('class'=>'txt'))->set_validator('required')->set_label('Start Date')->skip();
		$this->add_input('expire_date',array('class'=>'txt'))->set_validator('required')->set_label('Expire Date')->skip();
		$this->add_submit('submit','Generate',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	}
	
	public function get_model()
	{
		return 'tuitionfeepaymentmodel';
	}
  
   
}