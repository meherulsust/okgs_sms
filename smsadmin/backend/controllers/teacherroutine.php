<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 3, 2011
 */

class Teacherroutine extends BACKEND_Controller{
    function __construct()
    {
        parent::__construct();
		
    }

  	function index()
	{		
	  $this->load->form('teacher_routineform');
	}	
	
	// added by Md.Meherul Islam
	function class_routine()
	{
            $this->load->form('teacher_routineform');
            $this->load->model('teacher_routine_model');
            $teacher_id = $this->input->post('teacher_routine_teacher_id');
            $routine_list = $this->teacher_routine_model->get_class_routine($teacher_id);
            $this->tpl->assign('routine_list',$routine_list);
            $day_list = $this->teacher_routine_model->get_class_day();
            $this->tpl->assign('day_list',$day_list);
            //show extra classes 11-01-2017
            $extra_classes = $this->teacher_routine_model->get_extra_classes($teacher_id);
            $this->tpl->assign('extra_classes', $extra_classes);
//            print_r($extra_classes);
            
	}
	//end
	
 }
