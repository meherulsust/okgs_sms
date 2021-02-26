<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 03, 2014
 */
class Tuitionfeehead extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Tuition head fee list');
        $this->grid_board->add_link('New Tuition Head', site_url('tuitionfeehead/create'), array('class' => 'add', 'id' => 'new_exam'));
        $this->config->set_item('grid_status_menu_items', array('active' => 'Active', 'inactive' => 'Inactive'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'head_type' => 'Type', 'fund' => 'Fund Name', 'head_code' => 'Head Code', 'ammount' => 'Fee Amount',
            'status' => array('title' => 'Status', 'status' => 'status'), 'created_at' => 'Create Date');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('tuitionfeeheadmodel');
    }

    function create() {
        $this->load->form('tuitionfeeheadform');
    }

    function edit($id = '') {
        if (empty($id))
            redirect('tuitionfeehead');
        $this->load->model('tuitionfeeheadmodel');
        $info = $this->tuitionfeeheadmodel->find($id);
        $this->load->form('tuitionfeeheadform', null, $info);
        $this->process_form($this->tuitionfeeheadform);
    }

    function view($id) {
        $this->load->model('tuitionfeeheadmodel');
        $info = $this->tuitionfeeheadmodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $labels = array('title' => 'Head Name','fund' => 'Fund Name', 'head_type' => 'Head Type', 'head_code' => 'Head Code', 'description' => 'Description',
            'creator' => 'Created By', 'created_at' => 'Created at');
        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info[0]);
        $this->tpl->set_view('elements/record_view', true);
    }

    public function save() {
        $this->load->form('tuitionfeeheadform');
        $this->process_form($this->tuitionfeeheadform);
        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $id = $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Tuition fee head has been created successfully");
            else
                $this->session->set_flashdata('success', "Tuition fee head has been edited successfully");
            redirect('tuitionfeehead');
        }
    }

    public function del($id) {
        $this->load->model('tuitionfeepaymentdetailsmodel','tfpdm');
        $count = $this->tfpdm->count(array('tuition_fee_head_id'=>$id));
        if($count>0){
             $this->session->set_flashdata('notice', "Opps! You cannot delete this tuition fee head. it is already assigned to student.");
        }else{
            $this->load->model('classtuitionfeemodel','cufm');
            $count = $this->cufm->count(array('tuition_fee_head_id'=>$id));
             if($count>0){
                $this->session->set_flashdata('notice', "Opps! You cannot delete this tuition fee head. it is already using in class.");
             }else{
                  $this->load->model('sectiontuitionfeemodel','stfm');
                  $count = $this->stfm->count(array('tuition_fee_head_id'=>$id));
                  if($count>0){
                  $this->session->set_flashdata('notice', "Opps! You cannot delete this tuition fee head. it is already using in section.");
                  }else{
                    $this->load->model('tuitionfeeheadmodel');
                    $this->tuitionfeeheadmodel->delete($id);
                    $this->session->set_flashdata('success', "Tuition fee head has been deleted successfully");
                  }
             }
        }
        redirect('tuitionfeehead');
    }

    public function status($id, $stat) {
        $this->load->model('tuitionfeeheadmodel');
        if ($stat == 'active') {
            $stat = 1;
        } else {
            $stat = 0;
        }
        $this->tuitionfeeheadmodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Tuition fee head status has been changed successfully");
        redirect('tuitionfeehead');
    }
    

}