<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Home extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
		$this->load->helper('download');
    }

  	function index()
	{		
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->tpl->assign($row);
		$data['version_id'] = $row['version_id'];
		$data['class_id'] = $row['class_id'];
		$data['section_id'] = $row['section_id'];
		$data['house_id'] = '';
		$data['facility_id'] = '';
		$g_notice = $this->studentvmodel->get_general_notice($data);		
		$this->tpl->assign('general_notice',$g_notice);	
		$p_notice = $this->studentvmodel->get_personal_notice($row['student_number']);
		$this->tpl->assign('personal_notice',$p_notice);
	}	
	
	function all_notice($class_id='')
	{
		$this->load->model('studentvmodel');
		if($class_id){
			$head='Personal Notice';
		}else{
			$head='General Notice';
		}
		$this->tpl->assign('head',$head);
		$all_notice = $this->studentvmodel->get_all_notice($class_id);
		$this->tpl->assign('notice',$all_notice);	
	}
	
	function myprofile(){
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->tpl->assign($row);
	}
	
	function prospectus()
	{
	
	}
	
	function download()
	{
		$data = file_get_contents("./images/prospectus.pdf"); 
		force_download('prospectus.pdf',$data);	
	}
	
	function class_routine()
	{
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$this->tpl->assign($row);
		$routine_list = $this->studentvmodel->get_class_routine($row['class_id'],$row['section_id']);
		$this->tpl->assign('routine_list',$routine_list);
		$time_list = $this->studentvmodel->get_class_time($row['class_id']);
		$this->tpl->assign('time_list',$time_list);
		$day_list = $this->studentvmodel->get_class_day();
		$this->tpl->assign('day_list',$day_list);		
	}
	
	
	function change_password()
	{
		$this->load->library(array('form_validation'));
		$config = array(
               array(
                     'field'   => 'old_password',
                     'label'   => 'Old Password',
                     'rules'   => 'trim|required|xss_clean|callback_password_check'
                  ),
			  array(
                     'field'   => 'new_password',
                     'label'   => 'New Password',
                     'rules'   => 'trim|required|min_length[6]|max_length[20]|matches[retype_password]|xss_clean'
                  ),
			  array(
                     'field'   => 'retype_password',
                     'label'   => 'Re-type Password',
                     'rules'   => 'trim|required|xss_clean'
                  )
            );

		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	  	if ($this->form_validation->run() == FALSE)
		{			
			//$this->load->view('home/change_password');			
		}
		else
		{
			$this->load->model('studentvmodel');
			$st_id = $this->auth->get_user()->id;
			$passwd = $this->input->post('new_password');
			$this->studentvmodel->update_password($st_id,$passwd);  // update password
			$this->session->set_flashdata('message',"<div class='success'>Password has been changed successfully.</div>");
			redirect('home/change_password');
			
		}
	}
	
	
	function password_check($str)
	{
		$st_id = $this->auth->get_user()->id;
		
		$query = $this->db->query("SELECT id FROM sms_student where id='$st_id' AND passwd='$str'");
		if($query->num_rows()>0)
		{
			return true;			
		}else{
			$this->form_validation->set_message('password_check', "Old password doesn't match.");
			return false;
		}
		
	}
	
	
	
 }
