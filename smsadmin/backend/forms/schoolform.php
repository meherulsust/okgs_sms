<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 05, 2013
 * class school form
 */

class Schoolform extends MT_Form{
        var $name = 'school';
	public function init()
	{
		$this->add_hidden('id')->set_default(1);
		$this->add_input('name',array('class'=>'txt'))->set_validator('required')->set_label('School Name');
                $this->add_input('address1')->set_label('Address Line 1')->set_validator('required');
                $this->add_input('address2')->set_label('Address Line2');
                $this->add_input('establish_date')->set_label('Established')->set_validator('required');
                $this->add_file('logo_file')->set_label('Logo')->add_text_after('<span style="margin-left:25px;font-weight:bold;"> Max. Width x Height : 320x320, Max. Size : 120 KB</span>')->skip();
                $this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	    
	}
	
	public function get_model()
	{
		return 'schoolmodel';
	}
}
?>