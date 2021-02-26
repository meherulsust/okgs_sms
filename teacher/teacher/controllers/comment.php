<?php
/*
 * Created on Sept 24, 2015
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Comment extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
		$this->load->model('comment_model');	
    }

  	public function index()
	{
		$teacher_id = $this->auth->get_user()->id;
		$all_comment = $this->comment_model->get_comment($teacher_id);	
		$this->tpl->assign('all_comment',$all_comment);	
	}  
	public function post_comment(){	
		
		$data ['comment']       = $this->input->post('comment');
		$data ['comment_date']  = date("Y-m-d");
		$data ['teacher_id']    = $this->auth->get_user()->id;
		$all_comment = $this->comment_model->get_comment($data ['teacher_id']);	
		$this->comment_model->post_comment($data);
		$this->session->set_flashdata('success',"<span style='color:green'>Comment has been submitted successfully</span>");
		redirect('comment');
		
			
	}

 }