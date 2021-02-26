<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 10, 2012
 */
class School extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->tpl->set_page_title('Manage school');
    }

    function index() {
        $this->init_grid();
    }

    public function search() {
        $this->init_grid();
        $this->grid_board->filter()->render('centermodel');
        $this->tpl->set_view('index');
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'code' => 'Class code', 'serial' => 'Serial No.',
            'created_at' => array('title' => 'Created At', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('classmodel');
    }

    public function cadd() {
        $this->load->form('classform', 'cform');
        $this->tpl->set_view('new_class');
    }

    public function csave() {
        $this->load->form('classform', 'cform');
        $this->process_class_form($this->cform);
        $this->tpl->set_view('new_class');
    }

    public function edit($id) {
        $this->tpl->set_view('edit_class');
        
        $this->load->model('classmodel', 'cmodel');
        $info = $this->cmodel->get_class_info($id); 
//        print_r($info);
//        exit;
        $this->tpl->assign('class_info', $info);        
        $this->load->form('classform', 'cform', $info);
    }
    public function edit_class() { 
        $this->load->model('classmodel', 'cmodel');
        $data['title'] = $this->input->post('class_title');
        $data['code'] = $this->input->post('class_code');
        $data['serial'] = $this->input->post('class_serial');
        $data['result_scale_id'] = $this->input->post('class_result_scale_id');
        $data['start_date'] = $this->input->post('class_start_date');
        $data['end_date'] = $this->input->post('class_end_date');
        $data['is_result_publish'] = $this->input->post('class_is_result_publish');
        $class_id = $this->input->post('class_id');
        $edit_class = $this->cmodel->edit_class($class_id, $data);
        $this->session->set_flashdata('success', "Class has been edited successfully");
        redirect('school/view/' . $class_id);
    }

//    protected function process_class_form($form) {
//        if ($form->validate()) {
//            $id = $form->save();
//            if ($form->is_new()) {
//                $this->session->set_flashdata('success', "Class has been created successfully");
//            } else {
//                $this->session->set_flashdata('success', "Class has been edited successfully");
//            }
//
//            redirect('school/view/' . $id);
//        }
//    }
    protected function process_class_form($form) {
        if ($form->validate()) {
            $this->load->model('classmodel', 'cmodel');
            $data['title'] = $this->input->post('class_title');
            $data['code'] = $this->input->post('class_code');
            $data['serial'] = $this->input->post('class_serial');
            $data['result_scale_id'] = $this->input->post('class_result_scale_id');
            $data['start_date'] = $this->input->post('class_start_date');
            $data['end_date'] = $this->input->post('class_end_date');
            $data['is_result_publish'] = $this->input->post('class_is_result_publish');
            $class_id = $this->cmodel->addclass($data);
            $this->session->set_flashdata('success', "Class has been created successfully");
            redirect('school/view/' . $class_id);
        }
    }

    public function view($id = '') {
        $this->load->model('classmodel', 'cmodel');
        $info = $this->cmodel->find($id);
        if(empty($info))
            show_404 ();
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->tpl->set_jquery_ui(array('dialog', 'position'));
        $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate', 'jquery.form', 'section'));
        $this->tpl->assign('view_button', array('url' => 'school/newsec/' . $id, 'title' => 'Edit category', 'alt' => 'Edit this category'));
        $this->load->helper('date');
        $this->tpl->assign($info);
        $this->init_section_grid($id);
    }
    
      protected function init_section_grid($class_id) {
        $this->load->library('grid_board');
        //$this->grid_board->query_condition(array("class_id"=>$class_id));
        $this->grid_board->add_link('Add Form', site_url('school/newsec/' . $class_id), array('class' => 'add', 'id' => 'new_sec'));
        $this->grid_board->set_title('Form list');
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'viewsec', 'controller' => '', 'tips' => 'View section details'),
            'edit' => array('title' => 'Edit', 'action' => 'editsec', 'controller' => '', 'tips' => 'Edit section information'),
            'del' => array('title' => 'Delete', 'action' => 'delsec', 'controller' => '', 'tips' => 'Delete this section'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Form Name','version'=>'Medium/Version','room_number' => 'Room No', 'status' => array('status'=>'school/secstat','title'=>'Status'), 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->condition_render('sectionmodel',$class_id);
    }


    public function savesec() {
        $this->output->set_content_type('application/json');
        $this->load->form('sectionform', 'secform');
        $response = array('success' => 1, 'message' =>'');
        if ($this->secform->validate()) {
            $this->secform->save();
            $section = $this->secform->get_values();
            if ($this->secform->is_new())
                $this->session->set_flashdata('success', "Form has been added successfully");
            else
                $this->session->set_flashdata('success', "Form information has been edited successfully");
                $response['redirect'] = site_url('school/view/' . $section['class_id']);
        }else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
         
         $this->output->set_output(json_encode($response));
    }
    
    public function editsec($id){
        $this->load->model('sectionmodel');
        $info = $this->sectionmodel->find($id);
        if(empty($info)){
            show_404();
        }
        $this->load->form('sectionform','secform',$info);
        $this->tpl->set_view('newsec');
    }
    
    public function delsec($id){
        $this->load->model('sectionmodel');
        $info = $this->sectionmodel->find($id);
         if(empty($info)){
            show_404();
        }
        $this->sectionmodel->delete($id);
        $this->session->set_flashdata('success', "Form has been deleted successfully");
         redirect('school/view/'.$info['class_id']);
    }
    
    public function viewsec($id){
        $this->load->model('sectionmodel');
        $info = $this->sectionmodel->find($id);
         if(empty($info)){
            show_404();
        } 
        $this->tpl->assign('row',$info);
        $labels = array('title'=>'Form Name','description'=>'Description','created_at'=>'Created At','created_by'=>'Created By');
        $this->tpl->assign('labels',$labels);
        $this->load->helper(array('date'));
        $this->tpl->set_view('elements/record_view.php',true);
        
    }

    public function secstat($id,$stat){
        $this->load->model('sectionmodel');
        $info = $this->sectionmodel->find($id);
        if(empty($info))
            show_404();
        
        $this->sectionmodel->update_status(strtoupper($stat),$id);
        $this->session->set_flashdata('success', "Form status has been changed successfully");
        redirect('school/view/'.$info['class_id']);
        
    }
        
    public function info() { 
        $this->load->model('schoolmodel');
        $this->load->helper('date');
        $this->tpl->assign('row', $this->schoolmodel->find(1));
        $this->tpl->assign('view_button', array('url' => 'school/newinfo', 'title' => 'Update information', 'alt' => 'Update school information'));
        $this->tpl->assign('view_title', 'Details information of school');
        $this->tpl->assign('labels', array('name' => 'School Name','address1' => 'Address Line 1','address2' => 'Address Line 2', 'establish_date' => 'Established',
            'logo_file' => array('title' => 'Logo', 'type' => 'image', 'path' => base_url() . '/uploads/logo/', 'width' => '100', 'hieght' => '100'),
            'description' => 'Description'));
    }

    public function newinfo() {
        $this->load->model('schoolmodel');
        $info = $this->schoolmodel->find(1);
        $this->load->form('schoolform', 'sform', $info);
    }

    public function saveinfo() {
        $this->load->form('schoolform', 'sform');
        if ($this->sform->validate()) {
            $this->load->model('schoolmodel');
            $this->schoolmodel->db->trans_start();
            $this->sform->save();
            $this->session->set_flashdata('success', "School information been modified successfully");
            if ($_FILES['school_logo_file']['name']) {
                $config['upload_path'] = $this->config->item('upload_dir') . '/logo/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '400';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['file_name'] = 'school_logo_' . mktime();
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('school_logo_file')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->schoolmodel->db->trans_rollback();
                } else {
                    $data = $this->upload->data();
                    $this->do_resize($data);
                    $this->load->model('schoolmodel');
                    $prev_file = $this->schoolmodel->find_one_by_pk('logo_file',$this->sform->get_value('id'));
                    unlink($config['upload_path'].'/'.$prev_file);
                    unlink($config['upload_path'].'/'.str_replace('_thumb.','.',$prev_file));
                    $this->schoolmodel->update(array('logo_file' => $data['raw_name'].'_thumb'.$data['file_ext'], 'id' => $this->sform->get_value('id')));
                    $this->schoolmodel->db->trans_commit();
                }
            } else {
                $this->schoolmodel->db->trans_commit();
            }

            redirect('school/info');
        }
        $this->tpl->set_view('newinfo');
    }
    
    public function newsec($class_id){
        $this->load->form('sectionform','secform',array('class_id'=>$class_id));
        
    }
    
    public function do_resize($info) {
        $config = array(
            'image_library' => 'gd2',
            'source_image' => $info['full_path'],
            'maintain_ratio' => false,
            'create_thumb' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 150,
            'height' => 150
        );
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->resize()) {
            $this->session->set_flashdata('error',$this->image_lib->display_errors());
            return false;
        }
        $this->image_lib->clear();
        return true;
    }
	
	
	public function del($id) {
        if (empty($id))
            redirect('school');

        $this->load->model('classmodel');
        $this->classmodel->delete($id);
        $this->session->set_flashdata('success', "Class has been deleted successfully.");
        redirect('school');
    }
	
}

?>