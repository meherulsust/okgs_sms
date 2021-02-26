<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Idcard extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function generate($admission_id){
           $this->tpl->set_css('idcard');
           $this->tpl->set_page_title('Student id card');
           $this->load->helper(array('date'));
           $this->load->model('admissionmodel','amodel');
           $this->load->model('schoolmodel','smodel');
           $school_info = $this->smodel->find(1);
           $this->tpl->assign('school_info',$school_info);
           $info = $this->amodel->get_student_info($admission_id);
		  /*  echo"<pre>";
		   print_r($info);exit(); */
           $this->tpl->assign($info);
           $this->tpl->set_layout('print_layout');
        }
            

	
}