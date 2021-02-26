<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 2, 2011
 */
class Login extends Backend_Controller{
	
	function __construct()
	{   
		$this->set_ignore_auth('login'); 
	  	parent::__construct();
		$this->tpl->set_page_title('IMSN::Login');
		$this->tpl->set_layout('login_layout');
	}
	
	function index()
	{
	 	 if($this->auth->is_logged_in())
		 {
		 	redirect('home');
		 }
	}
	function dologin()
	{
		 $user = $this->input->post('username');
		 $pass = $this->input->post('password');
		 $db_postfix = $this->input->post('ac_year');
		 $ret = $this->auth->check_login(array('username'=>$user,'passwd'=>$pass,'status'=>'ACTIVE'),$db_postfix);
		 if($ret)
		 {
			redirect('home');
		 }
		 else
		 {
		 	$this->session->set_flashdata('error_msg','Username or possword did not match');
		 	redirect('login');
		 }	
	}
	
	function logout()
	{
		$this->auth->logout();
		redirect();
	}
}

?>
