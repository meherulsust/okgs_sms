<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    April 14, 2012
 * class school class form
 */
class Classtestform extends MT_Form{
	var $name = 'classtest';
	public function init()
	{
                $this->CI->load->helper('lookup');
		$this->add_hidden('id');
		$this->add_hidden('exam_id');
                $this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Title');
               	$this->add_select('exam_type_lookup_id',  array(''=>'--Select Exam Type--') + lookup_assoc_by_value('EXAM_TYPE',2,'id asc'))
                      ->set_label('Exam Type')->set_validator('required');
                $this->add_input('sdatepicker',array('class'=>'txt'))->set_validator('required')->set_label('Start Date')->skip();
		$this->add_input('edatepicker',array('class'=>'txt'))->set_validator('required')->set_label('End Date')->skip();
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_hidden('start_date');
		$this->add_hidden('end_date');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
                $this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	    
	}
	
	public function get_model()
	{
		return 'examclasstestmodel';
	}
  
   
}