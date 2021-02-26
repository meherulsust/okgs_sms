<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 9, 2012
 * class registration  form
 */
class Registrationform extends MT_Form{
	var $name = 'regi';
	public function init()
	{
		$this->add_hidden('id');
                if($this->is_new()){
                   $this->add_model_select('admission_id[]',array('model'=>'exammodel','method'=>'get_admission_list','params'=>array('exam_id'=>$this->get_default('exam_id',0))
		),array('class'=>'admission','multiple'=>'multiple'))->set_label('Student')->set_validator('required');
                }
                else {
                    $this->add_select('status',array('ACTIVE'=>'Active','INACTIVE'=>'Inactive','PENDING'=>'pending'))->set_default('ACTIVE')->set_validator('required');
                }
                $this->add_hidden('exam_id');
		$this->add_input('fee_received',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Fee Received');
		$this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'btn-regi-cancel'),'Cancel');
	    
	}
	
	public function get_model()
	{
		return 'examregistrationmodel';
	}
  
   
}