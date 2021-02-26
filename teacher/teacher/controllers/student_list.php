<?php
/*
 * Created on August 23, 2015
 * 
 * Created By Arena development Team (@ Md.Meherul Islam)
 * 
 */
 class Student_list extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
    }

  	function index()
	{		
		
	}  

	function student()
	{		
		
		$this->tpl->set_js('select-chain');
		$this->load->model('student_list_model');
		$get_class = $this->student_list_model->get_class();
		$this->tpl->assign('get_class',$get_class);	
		
	}
	
	function get_student()
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('student_list_model');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section_id'); 
		$student_list = $this->student_list_model->get_all_students($data);
		$this->tpl->assign('student_list',$student_list); 
		$get_class = $this->student_list_model->get_class();
		$this->tpl->assign('get_class',$get_class);
	}
	
	
	
	function student_profile($id){
		$this->load->model('student_list_model');
		$row = $this->student_list_model->find($id);
		$student_id = $row['id'];
		$data['working_days'] =$this->student_list_model->working_days();
		$data['total_attendance']= $this->student_list_model->total_attendance($student_id);
		$data['total_adsence']=$data['working_days']-$data['total_attendance'];
		$this->tpl->assign($data);
		$this->tpl->assign($row);
	}
	
 }