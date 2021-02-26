<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    May 12, 2011
 * class guardian form
 */

class Permanentaddressform extends MT_Form{
	public function init()
	{
		$this->set_name('permanent');
		$this->add_hidden('id');
		$this->add_input('address_line',array('class'=>'txt'))->set_validator('required');
		$this->add_model_select('district',array('model'=>'districtmodel','order_by'=>'name asc','value'=>'name','add_empty'=>'--Select District--'))
			 ->set_default('30')->set_label('District');
		$this->add_model_select('thana',array('model'=>'thanamodel','order_by'=>'name asc','value'=>'name','where'=>'district_id='.$this->get_default('district',37),'add_empty'=>'--Select Thana--'))
			 ->set_default('242')->set_label('Thana');
		$this->add_model_select('post_office_id',array('model'=>'postofcmodel','order_by'=>'name asc','value'=>'name','where'=>'thana_id='.$this->get_default('thana',303),'add_empty'=>'--Select Post Office--'))
			 ->set_default('3798')->set_label('Post Office');
		$this->add_hidden('address_type','PERMANENT');
		$this->add_hidden('student_id','');
	    $this->add_submit('submit','Submit',array('class'=>'btn'));
		if($this->is_new())
		{
		   	  $this->add_reset('button','Cancel',array('class'=>'btn cancel','id'=>'btn-cancel'));
		   	// $this->add_hidden('cancel_url',site_url('student/personal/type/personal/std_id/'.$this->get_default('student_id').'/id/'.$this->get_default('id').'/actn/view'));
		}
	}
	
	public function get_model()
	{
		return 'addressmodel';
	}
}
?>