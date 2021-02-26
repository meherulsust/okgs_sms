<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 06, 2012
 */
class Classtest extends BACKEND_Controller {
     function __construct() {
        parent::__construct();
    }
    public function index($exam_id){
        $this->load->model('exammodel');
        $info = $this->exammodel->get_info($exam_id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $this->tpl->assign($info);
        $this->init_grid($exam_id);
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->tpl->set_jquery_ui(array('position','dialog','datepicker'));
        $this->tpl->set_js(array('jquery.loadmask', 'jquery.validate','classtest','jquery.form')); 
    }
    
    protected function init_grid($exam_id = '') {
        $this->load->library('grid_board');
        $this->grid_board->query_condition(array('exam_id'=>$exam_id));
        $this->grid_board->add_link('Create Monthly Exam', site_url('classtest/add/' . $exam_id), array('class' => 'add', 'id' => 'new_test'));
        $this->grid_board->set_title('Monthly exam list ');
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'view', 'controller' => '', 'tips' => 'View details of this scale'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit this scale'),
            'studentlist' => array('title' => 'Student List', 'action' => 'student', 'controller' => '', 'tips' => 'Registered student list'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete this scale'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Title', 'start_date' =>array('title'=>'Start Date','date'=>true),'end_date' =>array('title'=>'End Date','date'=>true), 'status' => array('title' => 'Status', 'status' => 'exam/registat'), 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('examclasstestmodel');
        
    }
    
    public function add($exam_id){
        $this->load->form('classtestform','ctform',array('exam_id'=>$exam_id));
    }
    
    public function save(){
       $this->load->form('classtestform','ctform');
       $this->process_form($this->ctform);    
    }
    
    protected function process_form($form) {
           if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $response = array('success' => 1, 'message' => '');
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        if ($form->validate()) {
            $form->save();
            if ($form->is_new()) {
                $this->session->set_flashdata('success', "Monthly exam has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Monthly exam has been updated successfully");
            }
            $response['redirect'] = site_url('classtest/index/'.$form->get_value('exam_id'));
        }else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
        $this->output->set_output(json_encode($response));
    }
    
    public function edit($id){
        $this->load->model('examclasstestmodel','ectmodel');
        $info = $this->ectmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $temp_date = DateTime::createFromFormat('Y-m-d', $info['start_date']);
        $info['sdatepicker'] = $temp_date->format('d F, Y');
        $temp_date = DateTime::createFromFormat('Y-m-d', $info['end_date']);
        $info['edatepicker'] = $temp_date->format('d F, Y');
        $this->load->form('classtestform','ctform',$info);
        $this->tpl->set_view('add'); 
    }
    
     function del($id) {
         $this->load->model('examclasstestmodel','ectmodel');
         $info = $this->ectmodel->find($id);
         if(empty($info)){
             show_404();
         }
         $this->ectmodel->delete($id);
         $this->session->set_flashdata('success','Classtest has been deleted successfully');
         redirect('classtest/index/'.$info['exam_id']);
    }
    
     function view($id) {
         $this->load->model('examclasstestmodel','ectmodel');
         $info = $this->ectmodel->find($id);
         $this->load->helper('date');
         $labels = array('title'=>'Exam Title','start_date'=>'Start Date','end_date'=>'End Date',
                    'created_by'=>'Created By', 'created_at'=>'Created At');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info);
         $this->tpl->set_view('elements/record_view',true); 
    }
    
    function student($id){
        die('Functionality is under construction.');
        $this->load->helper('date');
        $this->load->model('examclasstestmodel','ectmodel');
        $info = $this->ectmodel->get_info($id);
        $this->tpl->assign($info);
        $this->init_registration_grid($info['exam_id']); 
    }
    
     protected function init_registration_grid($info) {
        $eid = $info['exam_id'];
        $id = $info['id'];
        $this->load->library('grid_board');
        $this->grid_board->set_param('exam_id', $eid);
        $this->grid_board->add_link('Marks Bulk Upload', site_url('classtest/upload/' .$id), array('class' => 'add', 'id' => 'bulk_upload'));
        $this->grid_board->set_title('Registered student list');
        $actions = array(
            'marks' => array('title' => 'Assign Marks', 'action' => 'marks', 'controller' => '', 'tips' => 'Assign exam marks'),
          );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'student' => 'Student', 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('examregistrationmodel');
    }

}
?>
