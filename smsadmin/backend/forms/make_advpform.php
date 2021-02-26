<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */

class Make_advpform extends MT_Form{
    var $name = 'advp';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_select('payment_generate_type',array(''=>'---- Select Type ----','1'=>'Adavance','0'=>'General'))->set_validator('required')->set_label('Payment Generate');
		$this->add_submit('submit','Update',array('class'=>'btn'));	   	
	}
	
	public function get_model()
	{
		return 'tuitionfeepaymentmodel';
	}
}
?>