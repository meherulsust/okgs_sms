<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 * @Author          Arena Development Team (@Avijit Chakravarty)
 * 
 * @created         January 22, 2017
 */

class Extra_class extends BACKEND_Controller{
    function __construct() {
        parent::__construct();
    }
    function index(){
        $this->load->form('set_extra_classform', 'secform');
        $this->tpl->set_js('select-chain');
    }
    function new_extra_class(){
        $this->tpl->set_view('index');
        $this->tpl->set_js('select-chain');
        $this->load->form('set_extra_classform', 'secform');
        $this->process_form($this->secform);
    }
    protected function process_form($form) {
        if ($form->validate()) {
            $id = $form->save();
            if ($form->is_new()) {
//                $this->send_extra_class_sms();
                $this->session->set_flashdata('success', "Extra Class has been created successfully");
            } else {
                $this->session->set_flashdata('success', "Extra Class has been edited successfully");
            }
            redirect('extra_class/extra_class_list');
        }
    }
    function extra_class_list(){
        $this->load->library('grid_board');
        $this->grid_board->set_title('Extra Classes List');
        $this->grid_board->add_link('Add Extra Class', site_url('extra_class'), array('class' => 'add'));
        $grid_columns = array('id' => array('visible' => false), 'class' => 'Class', 'section' => 'Form', 'subject' => 'Subject','teacher_name' => 'Teacher','class_day' => 'Day','class_time' => 'Time',
            'class_date' => 'Date');
        $this->grid_board->set_column($grid_columns);        
        $actions = array(
            'edit' => array('title' => 'Edit Extra Class', 'action'=> 'edit', 'controller' => 'extra_class', 'tips' => 'Edit'),
            'del' => array('title' => 'Delete Extra Class', 'action'=> 'del', 'controller' => 'extra_class', 'tips' => 'Delete')
        );
        $this->grid_board->set_action($actions);
        $this->grid_board->render('extra_classmodel');
    }
    function edit($id){
        if(empty($id))
            redirect ('extra_class/extra_class_list');
        $this->load->model('extra_classmodel');
        $info = $this->extra_classmodel->find($id);
        $this->load->form('set_extra_classform', 'secform', $info);
    }
    function del($id){
        if(empty($id))
            redirect ('extra_class/extra_class_list');
        $this->load->model('extra_classmodel');
        $this->extra_classmodel->delete_extra_class($id);
        $this->session->set_flashdata('success', "Extra Class has been deleted successfully.");
        redirect ('extra_class/extra_class_list');
    }
    function check_duplicate_class(){
        $this->tpl->set_view('');
        $teacher_id = $this->input->post('teacher_id');
        $class_day_id = $this->input->post('class_day_id');
        $class_time_text = $this->input->post('class_time_text');
        
        $this->load->model('extra_Classmodel');
        $check_routine = $this->extra_Classmodel->check_empty($teacher_id, $class_day_id, $class_time_text);
        $check_extra_routine = $this->extra_Classmodel->check_empty_extra_class($teacher_id, $class_day_id, $class_time_text);
        if($check_routine <= 0 && $check_extra_routine <= 0){
            $check_dupicate = 0;
        }else{
            $check_dupicate = 1;
        }
        echo $check_dupicate;
    }
    function send_extra_class_sms(){
        $teacher_id = $this->input->post('extraclass_teacher_id');
        $teacher_info = $this->extra_classmodel->get_teacher_info($teacher_id);
        $gsm = $teacher_info['mobile_no'];
        $message = 'Dear '.$teacher_info['name'].', You have been assigned an extra class, please check your class routine. Headmaster, IMSN.';
        $result = $this->send_sms_imsn($gsm,$message);
        $result = 0;
        if($result == 1){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        $data['teacher_id'] = $teacher_id;
        $data['created_at'] = date('Y-m-d h:i:s');
        
        $this->load->model('sentteachermessagemodel');
        $this->sentteachermessagemodel->add_sent_teacher_message($data);
        return;
    }
}