<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 05, 2013
 * class school form
 */

class Studentstatusform extends MT_Form{
        var $name = 'status';
	public function init()
	{
                $this->CI->load->helper('lookup');
		$this->add_hidden('id');
                if($this->is_new())
                    $this->add_model_select('status_id', array('model'=>'statusmodel','add_empty'=>' --- Select status ---'))->set_label('Status')->set_validator('required');
                else
                    $this->add_hidden('status_id');
                $this->add_select('lookup_id', lookup_assoc('STD_STAT_CHANGE_REASON'))->set_label('Reason')->set_validator('required');
		$this->add_textarea('comments',array('style'=>'width:200px;height:100px;'))->set_label('Comments');
		$this->add_hidden('student_id');
                $this->add_submit('submit','Submit',array('class'=>'btn'));
	   	$this->add_reset('button','Reset',array('class'=>'btn'));
                $this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	    
	}
	
	public function get_model()
	{
		return 'studentstatusmodel';
	}
}
?>