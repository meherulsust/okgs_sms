<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Comment_form extends MT_Form{
	var $name = 'comment';
	public function init()
	{
        
		$this->add_hidden('id');
		$this->add_input('reply_date',array('class'=>'txt','readonly'=>'readonly','value'=>date("Y-m-d")))->set_validator('')->set_label('Reply Date');
		$this->add_textarea('comment',array('class'=>'','readonly'=>'readonly','style'=>'width:200px;height:100px;'))->set_validator('required')->set_label('Comment');
		$this->add_textarea('reply',array('style'=>'width:200px;height:100px;'))->set_validator('required')->set_label('Reply');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	  	if($this->is_new())
	    {
	   	  $this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
	    }
	}
	
	public function get_model()
	{
		return 'comment_model';
	}
  
   
}