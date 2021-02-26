<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 31, 2012
 */
class Message extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->add_link('New SMS Template', site_url('message/create'), array('class' => 'add', 'id' => 'new_message'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'description' => 'Description', 'status' => array('title' => 'Status', 'status' => 'status'), 'created_at' => array('title' => 'Create Date', 'datetime' => 'true'));
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit this message'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete this message'),
        );
        $this->grid_board->set_action($actions);
        $this->grid_board->render('messagemodel');
    }

    function create() {
        $this->load->form('messageform');
        $this->tpl->set_jquery_ui();
    }

    public function save() {
        $this->load->form('messageform');
        $this->tpl->set_view('create');
        $this->process_form($this->messageform);
    }

    public function edit($id) {
        $this->load->model('messagemodel');
        $info = $this->messagemodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $this->load->form('messageform', null, $info);
        $this->process_form($this->messageform);
        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Message has been created successfully");
            else
                $this->session->set_flashdata('success', "Message has been updated successfully");
            redirect('message/index');
        }
    }

    function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('message/index');
        $this->load->model('messagemodel');
        $this->messagemodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Message status has been changed successfully");
        redirect('message/index');
    }

    public function del($id) {
        if (empty($id))
            redirect('message');

        $this->load->model('messagemodel');
        $this->messagemodel->delete($id);
        $this->session->set_flashdata('success', "Message has been deleted successfully");
        redirect('message/index');
    }

}