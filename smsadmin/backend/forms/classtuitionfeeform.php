<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 8, 2012
 * class school class form
 */
class Classtuitionfeeform extends MT_Form{
	var $name = 'ctf';
	public function init()
	{
		$this->add_hidden('id');
        $this->add_model_select('tuition_fee_head_id',array('model'=>'tuitionfeeheadmodel','where'=>"status=1 and is_common=0",'add_empty'=>'--Select Fee Head--'))->set_label('Fee Head');
        $this->add_model_select('class_id',array('model'=>'classmodel','add_empty'=>'--Select Class--','order_by'=>'serial asc'))->set_label('Class')->set_validator('required');
		$this->add_input('ammount',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Amount')
            ->add_text_before('(Taka)');
        $this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
        $this->add_reset('button','Cancel',array('class'=>'btn','id'=>'cancell-btn'));
	    
	}
	
	public function get_model()
	{
		return 'classtuitionfeemodel';
	}
  
   
}