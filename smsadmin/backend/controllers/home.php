<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 3, 2011
 */

class Home extends BACKEND_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
        $this->tpl->set_css(array('dashboard','livegraph'));
		$this->tpl->set_js('jquery.livegraph');
		$this->load->config('pmt_auth');
		$this->config->item('user_table');
		$this->session->userdata('name');
		$this->load->model('studentmodel');	
		$student_list = $this->studentmodel->count_student_classwise();
		$this->tpl->assign('student_list',$student_list);
		$this->load->model('attendancemodel');
		$attendance = $this->attendancemodel->get_attendance();
		$this->tpl->assign('attendance_list',$attendance);
		//echo $this->auth->show();
	}
}
?>