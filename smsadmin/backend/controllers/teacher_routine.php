<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 3, 2011
 */

class Teacher_routine extends BACKEND_Controller{
    function __construct()
    {
        parent::__construct();
		
    }

  	function index()
	{		
	
	}	
	function class_routine()
	{	
		$teacher_id = $this->input->post('teacher_id');
		$class_id = $this->input->post('class_id');
		$this->tpl->set_js('select-chain');
		$this->load->model('teacher_routine_model');
		$get_class = $this->teacher_routine_model->get_class();
		$routine_list = $this->teacher_routine_model->get_class_routine($class_id,$teacher_id);
		$this->tpl->assign('routine_list',$routine_list);
		$time_list = $this->teacher_routine_model->get_class_time($class_id);
		$this->tpl->assign('time_list',$time_list);
		$day_list = $this->teacher_routine_model->get_class_day();
		$this->tpl->assign('day_list',$day_list);		
		$this->tpl->assign('get_class',$get_class);
		
			
	}
	public function teacher() 
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teacher_routine_model');
		$class_id = $this->input->post('class_id');	
		$rs=array(array('id'=>'','name'=>'Select Teacher'));	
		$get_teacher = array_merge($rs,$this->teacher_routine_model->get_teacher($class_id));
        $this->output->set_output(json_encode($get_teacher));
			
    }
	
	function get_routine()
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teacher_routine_model');
		$class_id = $this->input->post('class_id');
		$teacher_id = $this->input->post('teacher_id');
		$get_class = $this->teacher_routine_model->get_class();
		$routine_list = $this->teacher_routine_model->get_class_routine($class_id,$teacher_id);
		$this->tpl->assign('routine_list',$routine_list);
		$time_list = $this->teacher_routine_model->get_class_time($class_id);
		$this->tpl->assign('time_list',$time_list);
		$day_list = $this->teacher_routine_model->get_class_day();
		$this->tpl->assign('day_list',$day_list);		
		$this->tpl->assign('get_class',$get_class);
	}
	
 }
