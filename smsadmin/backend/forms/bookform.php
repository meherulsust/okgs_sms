<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Bookform extends MT_Form{
	var $name = 'book';
	public function init()
	{
        $this->CI->load->helper('lookup');
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Book Name');
		$this->add_model_select('course_title_id',array('model'=>'coursetitlemodel','where'=>"status='ACTIVE'",'order_by'=>'title asc','add_empty'=>'Select Course Title'))
                            ->set_label('Course Title')->set_validator('required');
                $this->add_model_select('class_id',array('model'=>'classmodel','where'=>"status='ACTIVE'",'order_by'=>'serial asc', 'add_empty'=>'Select Class'))
                            ->set_label('Class Name')->set_validator('required');
                $this->add_input('writer_name')->set_label('Writer Name')->set_validator('required');
		$this->add_select('book_type_lookup_id',lookup_assoc('BOOK_TYPE','id desc'))->set_label('Book Type')->set_validator('required');
		$this->add_input('link',array('class'=>'txt'))->set_validator('required|prep_url|valid_url_format|url_exists');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	  	if($this->is_new())
	    {
	   	  $this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
	    }
	}
	
	public function get_model()
	{
		return 'bookmodel';
	}
  
   
}