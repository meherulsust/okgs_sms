<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 18, 2013
 * form class for admission
 */
class Lookupform extends MT_Form{
	var $name = 'lookup';
	public function init()
	{
		$this->add_hidden('id');
                $this->add_input('title')->set_label('Lookup Name')->set_validator('required');
		$this->add_input('unique_code')->set_label('Lookup  code')->set_validator('required');
                $this->add_select('value_type',array('STRING'=>'STRING','TEXT'=>'TEXT','NUMBER'=>'NUMBER','BOOL'=>'BOOL'))->set_default('STRING');
                if($this->is_new())
                     $this->add_input('value')->set_label('Lookup  Value')->set_validator('required');
                else{
                    if( $this->get_default('value_type') == 'TEXT')
                        $this->add_textarea('value',array('style'=>'width:200px;height:100px;'))->set_label('Lookup  Value')->set_validator('required');
                    else
                         $this->add_input('value')->set_label('Lookup  Value')->set_validator('required');
                }
                $this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
	   	$this->add_button(array('class'=>'btn','id'=>'cancel-btn'),'Cancel');
                $this->add_hidden('lookup_type_id');
	}
	
	public function get_model()
	{
		return 'lookupmodel';
	}
  
   
}