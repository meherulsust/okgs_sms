<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    November 04, 2012
 * form class school class sylabus evaluation type
 */
class Sylabusexamtypeform extends MT_Form{
	var $name = 'sylabus_exam_type';
	public function init()
	{
                $this->CI->load->helper('lookup');
		$this->add_hidden('id');
		$this->add_hidden('sylabus_id');
		$this->add_select('exam_type_lookup_id',lookup_assoc('EXAM_TYPE','id desc'))->set_label('Exam Type')->set_validator('required');
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive'))->set_default('ACTIVE')->set_validator('required');
		$this->add_input('final_percent',array('style'=>'width:100px;'))->set_label('Final Percent')->set_validator('required');
                $this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	public function get_model()
	{
		return 'sylabusexamtypemodel';
	}
  
   
}
