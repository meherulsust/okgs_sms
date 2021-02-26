<?php
/*
 * Created on Feb 17, 2016
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Result extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
		$this->tpl->set_js('select-chain');
		$this->load->model('teachermodel');
    }

  	function index()
	{		
		$this->load->model('teachermodel');
		$get_class = $this->teachermodel->get_class();
		$this->tpl->assign('get_class',$get_class);
		
	} 

	public function exam_list() 
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teachermodel');
		$class_id = $this->input->post('class_id');	
		$rs=array(array('id'=>'','title'=>'Select Exam'));	
		$get_exam = array_merge($rs,$this->teachermodel->get_exam_list($class_id));
        $this->output->set_output(json_encode($get_exam)); 
    }
	
	function exam_result()
	{		
		$this->tpl->set_layout(false);
		$exam_id     = $this->input->post('exam_id');
		echo $url = file_get_contents("http://localhost/imsn/smsadmin/index.php/exam/genarate_progress_report_tp/$exam_id");exit();
		
	
	}  	
		
		
	
 }