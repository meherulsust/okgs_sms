<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * Created on 14-06-2016
 * Developed by: Arena Development Team
 * 
 */

class Add_templateform extends MT_Form{
        var $name = 'template';
	public function init()
	{
            $this->add_hidden('id');
            $this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Title');
            $this->add_textarea('description',array('style'=>''))->set_label('Description')->set_validator('required');
            $this->add_submit('submit','Submit',array('class'=>'btn'));
            $this->add_reset('button','Reset',array('class'=>'btn'));
	}
	public function get_model()
	{
		return 'classmodel';
	}
}
?>