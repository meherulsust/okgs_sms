<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    November 01, 2015
 */
class Bulk_smsform extends MT_Form{
	
	 var $name = 'bulk_sms';
    
	public function init()
	{
		$this->add_hidden('id');
		$this->add_textarea('message', array('style'=>'width:200px;height:100px;'))->set_validator('required')->set_label('Message');		
		$this->add_file('mobile',array('class'=>'txt'))->set_label('Bulk Upload');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'bulk_sms_model';
	}
}
?>
