<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 10, 2011
 * Look up controller
 */
class Lookup extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('html');
    }

    function index() {
        $this->init_lookup_type_grid();
    }

    protected function init_lookup_type_grid() {

        $this->load->library('grid_board');
        $this->grid_board->set_title('Lookup type list');
        $this->grid_board->add_link('Add Lookup Category', site_url('lookup/typeadd'), array('class' => 'add', 'id' => 'new_lookup_type'));
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'unique_code' => 'Type code',
            'created_at' => 'Create Date');
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'typeview', 'controller' => '', 'tips' => 'View details of this lookup type'),
            'edit' => array('title' => 'Edit', 'action' => 'typeedit', 'controller' => '', 'tips' => 'Edit this lookup type'),
            'del' => array('title' => 'Delete', 'action' => 'typedel', 'controller' => '', 'tips' => 'Delete this lookup type'),
        );
        $this->grid_board->set_action($actions);

        $this->grid_board->render('lookuptypemodel');
    }

    function typeadd() {
        $this->load->form('lookuptypeform', 'ltform');
    }

    function typesave() {
        $this->load->form('lookuptypeform', 'ltform');
        $this->process_type_form($this->ltform);
        $this->tpl->set_view('typeadd');
    }

    function typeedit($id) {
        $this->load->model('lookuptypemodel', 'ltmodel');
        $info = $this->ltmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->form('lookuptypeform', 'ltform', $info);
        $this->tpl->set_view('typeadd');
    }

    function typeview($id) {
        $this->load->model('lookuptypemodel', 'ltmodel');
        $info = $this->ltmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->tpl->set_jquery_ui(array('dialog', 'position'));
        $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate', 'jquery.form', 'lookup'));
        $this->tpl->assign('view_button', array('url' => 'lookup/typeedit/' . $id, 'title' => 'Edit category', 'alt' => 'Edit this category'));
        $this->load->helper('date');
        $this->tpl->assign($info);
        $this->init_lookup_grid($id);
    }

    protected function process_type_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Lookup category has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Lookup category has been updated successfully");
            }
            redirect('lookup/index');
        }
    }
    function type_code_unique($str)
    {
		$this->load->model('lookuptypemodel','ltmodel');
                if ($this->ltmodel->is_not_unique_code($str))
		{
			$this->form_validation->set_message('type_code_unique', '%s is begin used');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
   }

    protected function init_lookup_grid($type_id) {
        $this->load->library('grid_board');
        $this->grid_board->set_param("lookup_type_id", $type_id);
        $this->grid_board->add_link('New Lookup Item', site_url('lookup/lookupadd/' . $type_id), array('class' => 'add', 'id' => 'new_lookup'));
        $this->grid_board->set_title('Registered student list');
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'lookupview', 'controller' => '', 'tips' => 'View lookup details'),
            'edit' => array('title' => 'Edit', 'action' => 'lookupedit', 'controller' => '', 'tips' => 'Edit lookup item'),
            'del' => array('title' => 'Delete', 'action' => 'lookupdel', 'controller' => '', 'tips' => 'Delete lookup item'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Lookup item', 'unique_code' => 'Lookup Code', 'value' => 'Lookup Value', 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('lookupvmodel');
    }

    function lookupadd($type_id) {
        $this->load->form('lookupform', 'lform', array('lookup_type_id' => $type_id));
    }

    function lookupsave() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form('lookupform', 'lform');
        if ($this->lform->validate()) {
            $this->lform->save();
            $response = array('success' => 1, 'message' => '');
            if ($this->lform->is_new())
                 $this->session->set_flashdata('success', 'Lookup value has been saved successfully');
            else
                 $this->session->set_flashdata('success','Lookup value has been updated successfully');
            $response['redirect'] = site_url('lookup/typeview/'.$this->lform->get_value('lookup_type_id'));
        }
        else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
        $this->output->set_output(json_encode($response));
    }

    function lookupview($id) {
         $this->load->model('lookupvmodel','lmodel');
         $this->load->helper('date');
         $info = $this->lmodel->find($id);
         $labels = array('title'=>'Lookup Name','unique_code'=>'Lookup Code','value'=>'Value','value_type'=>'Value Type',
                    'created_by'=>'Created By','updated_by'=>'Updated By', 'created_at'=>'Created At','updated_at'=>'Updated At');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info);
         $this->tpl->set_view('elements/record_view',true); 
    }

    function lookupedit($id) {
        $this->load->model('lookupvmodel','lmodel');
        $info = $this->lmodel->find($id);
        $this->load->form('lookupform', 'lform', $info);
        $this->tpl->set_view('lookupadd');
    }

    function lookupdel($id) {
         $this->load->model('lookupmodel','lmodel');
         $info = $this->lmodel->find($id);
         if(empty($info)){
             show_404();
         }
         $this->lmodel->delete($info);
         $this->session->set_flashdata('success','Lookup item has been deleted successfully');
         redirect('lookup/typeview/'.$info['lookup_type_id']);
    }
    

}