<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 10, 2012
 * class school class form
 */

class Studenttransferform extends MT_Form{
        var $name = 'transfer';
	public function init()
	{
		$this->add_hidden('id');
                $this->add_hidden('student_id');
                $this->CI->load->helper('lookup');
		$this->add_input('student_number',array('class'=>'txt'))->set_validator('required|callback_duplicate_student_check')->set_label('Student ID')
                      ->add_text_after('<span class="req">*</span> &nbsp; <a href="#" id="std-check" class="check-lnk">Check Student</a>');
		$this->add_select('reason_id', lookup_assoc('STD_TRANSFER_REASON'))->set_label('Reason')->set_validator('required');
                $this->add_textarea('comments',array('style'=>'width:200px;height:100px;'))->set_label('Comments');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
                $this->add_reset('button','Reset',array('class'=>'btn'));
	    
	}
	
	public function get_model()
	{
		return 'studenttransfermodel';
	}
}
?>