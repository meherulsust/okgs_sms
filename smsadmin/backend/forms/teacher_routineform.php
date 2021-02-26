<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Md.Meherul Islam
 * @ Created    13.03.2016
 */

class teacher_routineform extends MT_Form{
    var $name = 'teacher_routine';
	
	public function init()
	{
		$this->add_hidden('id');
		$this->add_model_select('teacher_id',array('model'=>'teachermodel','value'=>'name','where'=>'status = "ACTIVE" ','where'=>'relevant_subject_id !=""','order_by'=>'name asc',''=>'--Select Teacher --'))->set_label('Teacher');
		$this->add_submit('submit','Submit',array('class'=>'btn'));
		//$this->add_reset('reset','Reset',array('class'=>'btn'));       
	   
	}
	
	public function get_model()
	{
		return 'classroutinemodel';
	}
}
?>
