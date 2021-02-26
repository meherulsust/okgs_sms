<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 3, 2012
 */

class Center extends BACKEND_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->tpl->set_page_title('BCS Exam Management System: Candidate Manager');
	}
	
	function index()
	{
		//$this->session->set_userdata(array('name'=>array('first_name'=>'Reza','last_name'=>'Ahmed')));
		$this->init_grid();
		$this->grid_board->reset_filter()->render('centermodel');
		//print_r($this->session->userdata('name'));
		//$this->session->unset_userdata('name');
		//var_dump($this->session->userdata('name'));
		//$this->load->model('centermodel');
		//$result = $this->centermodel->check();
		 
		//printr($result);
		//$query = $this->db->get('center');
		//print_r($query->result_array());
	}
	
	public function search()
	{
		$this->init_grid();
		$this->grid_board->filter()->render('centermodel');
		$this->tpl->set_view('index');
	}
	
	protected function init_grid()
	{
		$this->load->helper(array('array','html'));
		$this->load->library('grid_board');
		$grid_columns = array('id'=>array('title'=>'ID','visible'=>false), 'cname'=>array('title'=>'Center Name'),'address'=>array('title'=>'Address','sort'=>false));
		$this->grid_board->set_column($grid_columns);
		$grid_actions = array('view'=>array('title'=>'show','action'=>'show'),'edit');
		$this->grid_board->set_action($grid_actions);
	}
}
?>