<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 14, 2012
 * form class for exam result details
 */
class Examresultdetailsform extends MT_Form{
	var $name = 'result_details';
	public function init()
	{
            if($this->is_new()){
                $this->new_marks_fields();
                
            }else{
                $this->saved_marks_fields();
            }
            $this->add_submit('submit','Submit',array('class'=>'btn'));
            $this->add_reset('button','Reset',array('class'=>'btn'));
            $this->add_button(array('class'=>'btn','id'=>'btn-cancel'),'Cancel');
	}
	
	protected function new_marks_fields()
	{
          print_r('<pre>');
          $reg_id = $this->get_default('exam_registration_id');
          $this->CI->load->model('examregistrationmodel','ermodel');
          $rs = $this->CI->ermodel->get_course_details($reg_id);
          $rs = array_group_by_key($rs,'course_id');
          print_r($rs);
          exit();
        
	}
	
	protected function saved_marks_fields()
	{
		
			
	}
	
	
	
	public function get_model()
	{
		return 'examresultdetailsmodel';
	}
	
}
