<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
class House extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->add_link('New House', site_url('house/create'), array('class' => 'add', 'id' => 'new_house'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'description' => 'Description', 'status' => array('title' => 'Status', 'status' => 'status'),'create_date' => 'Create Date');
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit this house')
        );
        $this->grid_board->set_action($actions);
        $this->grid_board->render('housemodel');
    }

    function create() {
		$this->tpl->set_js(array('jquery.validate','house_form'));
        $this->load->form('houseform');        
    }

    public function save() {
        $this->tpl->set_js(array('jquery.validate','house_form'));
		$this->load->form('houseform');
        $this->tpl->set_view('create');
        $this->process_form($this->houseform);
    }

    public function edit($id) {
        $this->load->model('housemodel');
        $info = $this->housemodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $this->load->form('houseform', null, $info);
        $this->process_form($this->houseform);
        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "House has been created successfully");
            else
                $this->session->set_flashdata('success', "House has been updated successfully");
            redirect('house/index');
        }
    }

    function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('house/index');
        $this->load->model('housemodel');
        $this->housemodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "House status has been changed successfully");
        redirect('house/index');
    }

    public function del($id) {
        if (empty($id))
            redirect('house');

        $this->load->model('housemodel');
        $this->housemodel->delete($id);
        $this->session->set_flashdata('success', "House has been deleted successfully");
        redirect('house/index');
    }

}