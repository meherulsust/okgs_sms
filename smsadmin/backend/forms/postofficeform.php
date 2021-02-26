<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */

class Postofficeform extends MT_Form{
    var $name = 'postof';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_input('name',array('class'=>'txt'))->set_validator('required');
		$this->add_model_select('district_id',array('model'=>'districtmodel','value'=>'name','add_empty'=>'--Select --'))->set_label('District')->set_validator('required')->skip();
		$this->add_model_select('thana_id',array('model'=>'thanamodel','value'=>'name','where'=>"district_id=".$this->get_default('district_id',0),'add_empty'=>'--Select thana--'))
                            ->set_validator('required')->set_label('Thana');
		
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'postofcmodel';
	}
	
	
}
?>
