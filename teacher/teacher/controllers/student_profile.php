<?php
/*
 * Created on Dec 23, 2013
 *
 * Created by Arena Development Team
 */
 class Student_profile extends Bindu_Controller
 {
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('studentprofilemodel','homemodel'));
		$this->load->helper(array('form','url','html'));
		$this->is_logged_in();
		$this->topup_user_id=$this->session->userdata('student_id');  // set student_id
	}
	
	/*------------- Login check ----------*/
	
	function is_logged_in()
    {
		$is_logged_in = $this->session->userdata('student_id');
		if($is_logged_in =='')
		{
			redirect('home');
		}else{
			return true;
		}       
    }
	
	/*------------- end login check ----------*/
	
  	
	/* ---------------- Start student profile ----------*/
	
	function index()
  	{		
		$row=$this->studentprofilemodel->get_profile_info($this->session->userdata('student_id'));
		$this->assign($row);
		$this->load->view('student_profile/profile');			
    }	
	
	/* ---------------- End student profile ----------*/
	
	
 }