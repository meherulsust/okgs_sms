<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    June 17, 2011
 */
 class Admission extends BACKEND_Controller{
 	function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
	}
	
	function newstd()
	{
	    $this->load->form('personaldetailsform','piform');	
	    $this->process_form($this->piform);
	    
	}
	function edit()
	{
		$arg = $this->uri->uri_to_assoc();
		$this->load->model('personaldetailsmodel','pdm');
		$info = $this->pdm->find(4);
		/*echo '<pre>';
		print_r($info);
		exit();*/
		$this->load->form('personaldetailsform','piform');	
		$this->piform->set_defaults($info);
		$this->tpl->set_view('newstd');
	}
	
	protected function process_form($form)
	{
		if($form->validate())
		{
			$form->save();
		}
		
	}
 }