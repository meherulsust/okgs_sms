<?php
/*
 * Created on Feb 04, 2016
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Attendance extends Frontend_Controller{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {		
		$this->load->model('attendancemodel');
		$this->load->helper('date');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$student_id = $row['id'];
		$data['working_days'] =$this->attendancemodel->working_days();
		$data['total_attendance']= $this->attendancemodel->total_attendance($student_id);
		$data['total_adsence']=$data['working_days']-$data['total_attendance'];
        $data['current_date']= date(DATE_FORMAT);
		$this->tpl->assign($row);
        $this->tpl->assign($data);	
    }
    
 
	
	
 }
