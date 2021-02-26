<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author     Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 19, 2013
 * Base form class school class menu form
 */
class Menuform extends MT_Form{
	var $name = 'menu';
	public function init()
	{
		$this->add_hidden('id');
                $this->add_hidden('parent_id');
		$this->add_input('title')->set_label('Title')->set_validator('required');
                $this->add_input('alias')->set_label('Alias')->set_validator('required');
		$this->add_input('url')->set_label('URL')->set_validator('required');
                $this->add_input('tips')->set_label('Tips')->set_validator('required');
                $this->add_input('serial',array('style'=>'width:50px;'))->set_label('Sequence No')->set_validator('number');
                $this->add_select('type',array('FRONTEND'=>'Frontend','BACKEND'=>'Backend'))->set_default('BACKEND')->set_validator('required');
                $this->add_select('is_visible',array('1'=>'Yes','0'=>'No'))->set_default('1')->set_validator('required');
		$this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive','PENDING'=>'Pending'))->set_default('ACTIVE')->set_validator('required');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('button','Reset',array('class'=>'btn'));
		$this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	
	
	
	public function get_model()
	{
		return 'menumodel';
	}
	
}
