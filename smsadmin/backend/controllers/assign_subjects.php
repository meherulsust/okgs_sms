<?php
/* 
 * Created on 11-05-2016
 * Developed by: Arena Development Team
 * 
 */
class Assign_subjects extends BACKEND_Controller{
    public $error = array();
    function __construct() {
        parent::__construct();
        $this->load->model('assigned_subjectsmodel');
    }
    function index(){
        $this->init_grid();
    }
    protected function init_grid(){
        $this->load->library('grid_board');
        $this->grid_board->set_title('Assigned Subjects List');
        $grid_columns = array('class_title' => 'Class Name', 'course_title' => 'Subject');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('assigned_subjectsmodel');
    }
    public function configure_subjects() {
        $this->load->form('configure_subjectsform');
    }
    public function save() {
        $this->load->form('configure_subjectsform');
        $this->tpl->set_view('configure_subjects');
        $this->_process_configure_subject_form($this->configure_subjectsform);
    }
    private function _process_configure_subject_form($form) {
        if($form->validate()){
            $data['class_id'] = $this->input->post('configure_subjects_class_id');
            $data['course_title_id'] = $this->input->post('configure_subjects_course_title_id');
            $data['status'] = 'ACTIVE';
            $data['created_by'] = $this->session->userdata('user_group_id');
            $course_id = $this->input->post('course_id');
            
            $duplicate = $this->assigned_subjectsmodel->config_subject_duplicate($data['class_id'], $data['course_title_id']);
            if(empty($duplicate)){
                if(($course_id)){
                    $edit_assign_subject = $this->assigned_subjectsmodel->edit($course_id, $data);
                    $this->session->set_flashdata('success', 'The Configuration successfully Updated');
                    redirect('assign_subjects');
                }else {
                $assign_subject_id = $this->assigned_subjectsmodel->set_subject($data);
                $this->session->set_flashdata('success', 'The Configuration saved successfully');
                redirect('assign_subjects');
                }
            }else{
                $this->session->set_flashdata('error', 'The Configuration you are trying to create is already exist!');
                redirect(base_url().'index.php/assign_subjects/configure_subjects?class='.$data['class_id'].'&course='.$data['course_title_id'].'&course_id='.$course_id);
            }
        }
    }
    function edit($id = ''){
        if(empty($id))
            redirect ('assign_subjects');
        $info = $this->assigned_subjectsmodel->find($id);
        $this->load->form('configure_subjectsform', NULL, $info);
        $this->tpl->assign('config_subject', $info);
    }
    function edit_assign_subjects() {
        $this->load->form('configure_subjectsform');
        $this->tpl->set_view('edit');
        $this->edit_data($this->configure_subjectsform);
    }
    function edit_data($form) {
        $assign_subject_id = $this->input->post('config_subject_id');
        if($form->validate()){
            $data['class_id'] = $this->input->post('configure_subjects_class_id');
            $data['course_title_id'] = $this->input->post('configure_subjects_course_title_id');
            $duplicate = $this->assigned_subjectsmodel->config_subject_duplicate($data['class_id'], $data['course_title_id']);
            
            if(empty($duplicate)){
                $edit_assigned_subjects = $this->assigned_subjectsmodel->edit($assign_subject_id, $data);
                $this->session->set_flashdata('success', 'The Configuration Updated successfully');
                redirect('assign_subjects');
            }else{
                $this->session->set_flashdata('error', 'The Subject you are trying to configure is already exist!');
                redirect(base_url().'index.php/assign_subjects/configure_subjects?class='.$data['class_id'].'&course='.$data['course_title_id'].'&course_id='.$assign_subject_id);
            }
        }
    }
    function del($id){
        $this->assigned_subjectsmodel->delete($id);
        $this->session->set_flashdata('success', 'The Configuration has been deleted Successfully');
        redirect('assign_subjects');
    }
    function view($id){
        $info = $this->assigned_subjectsmodel->get_info($id);
        if(empty($info)){
            show_404();
        }
        $this->tpl->assign($info[0]);
    }
    
}