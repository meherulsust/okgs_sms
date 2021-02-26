<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Notebookform extends MT_Form{
    var $name = 'notebook';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_hidden('main_file_name');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required');
		$this->add_textarea('description',array('style'=>'width:280px;height:50px;'));
		$this->add_model_select('subject_id',array('model'=>'coursetitlemodel','where'=>"status='ACTIVE'",'order_by'=>'title asc','add_empty'=>'Select Subject'))->set_label('Subject')->set_validator('required');
        $this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_model_select('section_id',array('model'=>'sectionmodel','where'=>"class_id='".$this->get_default('class_id',0)."'",'add_empty'=>'--Select Form--'))->set_label('Form');
		$this->add_file('file_name',array('class'=>'txt'))->set_label('Select File');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'notebookmodel';
	}
}
?>
