<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 9, 2011
 */
class Candidate extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->tpl->set_page_title('BCS Exam Management System: Center Manager');
		
	}
	
	function index()
	{
        $this->init_grid();
		//$this->tpl->set_view(false);	
	}
	
	protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $grid_columns = array('full_name'=>'Full Name','address'=>'Address','mobile_no'=>array('title'=>'Mobile','sort'=>false));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('candidatemodel');	
	}
	
}
?>