<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */

class Editpaymentstatusform extends MT_Form{
    var $name = 'payment_status';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_select('pay_status',array('PAID'=>'Paid','UNPAID'=>'Unpaid'))->set_validator('required');
		$this->add_select('pay_type',array(''=>'---- Select Type ----','WEB'=>'WEB','SMS'=>'SMS','MANUAL'=>'MANUAL'))->set_validator('required')->set_label('Payment Type');
		$this->add_input('payment_date',array('class'=>'txt'))->set_validator('required')->set_label('Payment Date');
		$this->add_input('bank_transection_id',array('class'=>'txt'))->set_validator('required')->set_label('Transection ID');
                $this->add_submit('submit','Update',array('class'=>'btn'));	   	
	}
	
	public function get_model()
	{
		return 'tuitionfeepaymentmodel';
	}
}
?>