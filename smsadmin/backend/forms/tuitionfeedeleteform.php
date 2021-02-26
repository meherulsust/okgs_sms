<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tuitionfeedeleteform extends MT_Form{
	var $name = 'fee_delete';
	public function init()
	{
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_select('year',array('2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023','2024'=>'2024','2025'=>'2025','2026'=>'2026','2027'=>'2027','2028'=>'2028','2029'=>'2029','2030'=>'2030'))->set_label('Year')->set_default(date('Y'))->set_validator('required');
		$this->add_select('month',array(''=>'---- None ----','1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'))->set_label('Month')->set_default('')->set_validator('required|callback_duplicate_fee_check');
		$this->add_submit('submit','Delete',array('class'=>'btn delete'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	}
	
	public function get_model()
	{
		return 'tuitionfeepaymentmodel';
	}
  
   
}