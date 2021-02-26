<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */

class Editpaymentform extends MT_Form{
    var $name = 'payment';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Head Title');
		$this->add_input('ammount',array('class'=>'txt'))->set_validator('required')->set_label('Amount');
		$this->add_submit('submit','Update',array('class'=>'btn'));	   	
	}
	
	public function get_model()
	{
		return 'tuitionfeepaymentdetailsmodel';
	}
}
?>