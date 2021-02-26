<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 11, 2013
 */
class Menu extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Top menu list');
        $this->grid_board->query_condition(array('parent_id' => 0));
        $this->grid_board->add_link('Create Top Menu', site_url('menu/create/0'), array('class' => 'add', 'id' => 'create_menu'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'alias' => 'Alias', 'type' => 'Menu Type', 'url' => 'URL', 'status' => array('title' => 'Status', 'status' => 'status'), 'serial' => 'Serial No.');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('menumodel');
    }

    public function create($parent_id='') {
        $this->tpl->assign('parent_id', $parent_id);
        $this->load->form('menuform', '', array('parent_id' => $parent_id));
    }

    public function save($parent_id) {
        $this->tpl->assign('parent_id', $parent_id);
        $this->load->form('menuform', '', array('parent_id' => $parent_id));
        if ($this->input->is_ajax_request()) {
            $this->process_ajax_form($this->menuform);
        } else {
            $this->process_form($this->menuform);
        }

        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $id = $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Menu has been created successfully");
            else
                $this->session->set_flashdata('success', "Menu has been edited successfully");
            redirect('menu/index/');
        }
    }

    protected function process_ajax_form($form) {
        $this->output->set_content_type('application/json');
        $response = array('success' => 0, 'message' => 'One or more required fields are missing');
        if ($form->validate()) {
            $response['success'] = 1;
            $id = $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Sub menu has been created successfully");
            else
                $this->session->set_flashdata('success', "Sub menu has been edited successfully");
            $response['redirect'] = site_url('menu/view/' . $form->get_value('parent_id'));
        }
        $this->output->set_output(json_encode($response));
    }

    public function edit($id) {
        $this->load->model('menumodel');
        $info = $this->menumodel->find($id);
        $this->tpl->assign('parent_id', $info['parent_id']);
        $this->load->form('menuform', '', $info);
        $this->tpl->set_view('create');
    }

    public function view($id) {
        $this->load->model('menumodel');
        $info = $this->menumodel->find($id);
        $this->tpl->assign($info);
        $this->init_child_menu_grid($id);
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->tpl->set_jquery_ui(array('dialog', 'position'));
        $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate', 'jquery.form', 'sub_menu'));
    }

    protected function init_child_menu_grid($id) {
        $this->load->library('grid_board');
        $this->grid_board->query_condition(array('parent_id' => $id));
        $this->grid_board->add_link('Create Sub Menu', site_url('menu/create/' . $id), array('class' => 'add', 'id' => 'add_sub_menu'));
        $this->grid_board->set_title('Sub menu item list');
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'submenuview', 'controller' => '', 'tips' => 'View details of this menu  items'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit child menu'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete child menu'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'alias' => 'Alias', 'type' => 'Menu Type', 'url' => 'URL', 'status' => array('title' => 'Status', 'status' => 'status'), 'serial' => 'Serial No.');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('menumodel');
    }

    public function del($id) {
        $this->load->model('menumodel');
        $num = $this->menumodel->count(array('parent_id' => $id));
        if ($num == 0) {
            $row = $this->menumodel->find($id);
            $this->menumodel->delete($id);
            $this->session->set_flashdata('success', "Sub menu has been deleted successfully");
            redirect('menu/view/' . $row['parent_id']);
        } else {
            $this->session->set_flashdata('warning', "Please delete sub menu first");
            redirect('menu/index');
        }
    }

    public function status($id, $status) {
        $this->load->model('menumodel');
        $row = $this->menumodel->find($id);
        if ($row) {
            $this->menumodel->update_status($status, $id);
            if ($row['parent_id'] > 0) {
                $this->session->set_flashdata('success', "Sub menu status has been changed successfully");
                redirect('menu/view/' . $row['parent_id']);
            } else {
                $this->session->set_flashdata('success', "Menu status has been changed successfully");
                redirect('menu/index');
            }
        } else {
            show_404();
        }
    }

    function submenuview($id) {
        $this->load->model('menumodel');
        $this->load->helper('date');
        $info = $this->menumodel->find($id);
        $this->tpl->assign('view_title','Sub menu item details');
        $labels = array('title' => 'Title', 'alias' => 'Alias', 'tips' => 'Tips', 'serial' => 'Serial No','url' => 'URL','status' => 'Status',
            'created_by' => 'Created By',  'created_at' => 'Created At');
        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view', true);
    }
    

}

?>
