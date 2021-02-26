<?php
/*
 * Created on Nov 19, 2013
 * Created by Arena development team
 *
 */
 class Error_page extends CI_Controller
 {
 	function __construct()
 	{
 		parent::__construct();
 		//$this->set_layout('login_layout');
 	}

 	function index()
 	{
 		echo 'Access Denied.';		
 	}
	
	
 }

?>
