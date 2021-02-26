<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 22, 2012
 * 
 * class sylabusbookform
 */
class Sylabusbookform extends MT_Form{
	var $name = 'sylabs_book';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('sylabus_id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Title');
		$this->add_model_select('book_id',array('model'=>'bookmodel','add_empty'=>'--Select book--'))->set_label('Book');
		$this->add_input('subject_code',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Subject Code');
		$this->add_input('full_marks',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Full Marks');
		$this->add_input('sybjective_marks',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Subjective Marks');
		$this->add_input('objective_marks',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Objective Marks');
		$this->add_input('practical_marks',array('class'=>'txt','style'=>'width:50px'))->set_validator('required')->set_label('Practical Marks');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		//$this->add_button(array('class'=>'btn'),'Cancel');
	
	}
	
	public function get_model()
	{
		return 'sylabusbookmodel';
	}
  
   
}