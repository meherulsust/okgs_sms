<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    September 1, 2012
 * class school class form
 */
class Tuitionfeeheadform extends MT_Form{
	var $name = 'tution_fee_head';
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('title',array('class'=>'txt'))->set_validator('required')->set_label('Head Title');
	    $this->add_input('head_code',array('class'=>'txt'))->set_validator('required')->set_label('Head Unique Code');
        $this->add_model_select('fund_id',array('model'=>'fundmodel','where'=>"status = 'ACTIVE'",'add_empty'=>'--Select Fund--'))->set_label('Select Fund')->set_validator('required');
		$this->add_input('ammount',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Amount')->add_text_before('(Taka)');
        $this->add_input('display_order',array('class'=>'txt','style'=>'width:100px;'))->set_validator('required')->set_label('Display Order');
		$this->add_select('head_type',array('COST'=>'Cost','WAIVER'=>'Waiver','CONDITIONAL'=>'Conditional','TRANSPORT'=>'Transport Facility','SPECIAL_CLASS'=>'Special Class','FINE'=>'Fine'),array('style'=>'width:100px;'))->set_default('0')->set_validator('required')->set_label('Head Type');
        $this->add_checkbox('is_common',array())->add_text_after('(Is applicable for all?)');
        $this->add_textarea('description',array('style'=>'width:200px;height:100px;'))->set_label('Description');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn','id'=>'btn-cancel'));
	    
	}
	
	public function get_model()
	{
		return 'tuitionfeeheadmodel';
	}
  
   
}