<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Examform extends MT_Form{
	var $name = 'exam';
	public function init()
	{
                $this->CI->load->helper('lookup');
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Exam Name');
		$this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))
                        ->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id=".$this->get_default('class_id',0),'add_empty'=>'All Form'))->set_label('Form');
//		$this->add_model_select('sylabus_id[]',array('model'=>'sylabusmodel','method'=>'get_class_sylabus_list','params'=>array('class_id'=>$this->get_default('class_id',0),'section_id'=>$this->get_default('section_id',0)),
//		'add_empty'=>'Select Sylabus'),array('class'=>'syl','multiple'=>'multiple'))->set_label('Sylabus')->set_validator('required');
		$this->add_input('fee',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Exam Fee');
                $this->add_input('exam_session',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Exam Session')->set_default(date('Y'));
		$this->add_select('exam_type_lookup_id',  array(''=>'--Select Exam Type--') + lookup_assoc_by_value('EXAM_TYPE',1,'id asc'))
                      ->set_label('Exam Type')->set_validator('required');
                $this->add_select('is_final',array('1'=>'Yes','0'=>'No'),array('style'=>'width:100px;'))->set_default('0')->set_validator('required')->set_label('Final Exam');
                $this->add_input('sdatepicker',array('class'=>'txt'))->set_validator('required')->set_label('Start Date')->skip();
		$this->add_input('edatepicker',array('class'=>'txt'))->set_validator('required')->set_label('End Date')->skip();
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_hidden('start_date');
		$this->add_hidden('end_date');
//		$this->add_submit('submit','Submit',array('class'=>'btn'));
//	   	$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
	    
	}
	
	public function get_model()
	{
		return 'exammodel';
	}
  
   
}