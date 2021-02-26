<?php
if (!defined('BASEPATH'))
    exit ('Not direct script access allowed.');
/* 
 * @ Author         Avijit Chakravarty
 * 
 * @ Created        29th January, 2017
 */
class Board_result_download extends BACKEND_Controller{
    function __construct() {
        parent::__construct();
    }
    function index(){
        $this->init_grid();
    }
    function init_grid(){
        $this->load->model('board_exams_detailsmodel');
        $upload_result = $this->board_exams_detailsmodel->get_board_exams();
        $this->tpl->assign('results', $upload_result);
    }
    function add_new_result(){
        $this->load->form('board_exam_detailsform', 'examdetailsform');
        $this->process_form($this->examdetailsform);
    }
    function process_form($form){
        if($form->validate()){
            if($form->is_new()){
                if(trim($_FILES['boardexam_file_name']['name']) != ''){
                    $this->load->model('board_exams_detailsmodel');
                    
                    $ext = end(explode(".", $_FILES['boardexam_file_name']['name']));
                    $file_name = rand(1000000, 9999999) . '_' . rand(1000000, 9999999) . '.' . $ext;
                    $upconfig['upload_path'] = $this->config->item('upload_dir'). '/board_result/';
                    $file_info = pathinfo($file_name);
                    $upconfig['file_name'] = basename($file_name, '.' . $file_info['extension']);
                    $upconfig['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls';
                    $upconfig['max_size'] = '5000000';
                    $upconfig['overwrite'] = FALSE;
                    $this->load->library('upload', $upconfig);
                    if($this->upload->do_upload('boardexam_file_name'))
                        $id = $form->save();
                        $update_data = array('file_name' => $file_name);
                        $this->board_exams_detailsmodel->update_board_exams($update_data, $id);
                        $this->session->set_flashdata('success', 'Document successfully uploaded.');
                        redirect('board_result_download');
                }else{
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('board_result_download');
                }
            }else{
                if(trim($_FILES['boardexam_file_name']['name']) != ''){
                    $ext = end(explode(".", $_FILES['boardexam_file_name']['name']));
                    $file_name = rand(1000000, 9999999) . '_' . rand(1000000, 9999999). '.' . $ext;
                    $upconfig['upload_path'] = $this->config->item('upload_dir') .'/board_result';
                    $file_info = pathinfo($file_name);
                    $upconfig['file_name'] = basename($file_name, '.' . $file_info['extension']);
                    $upconfig['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|xls';
                    $upconfig['max_size'] = '5000000';
                    $upconfig['overwrite'] = FALSE;
                    $this->load->library('upload', $upconfig);
                    if($this->upload->do_upload('boardexam_file_name')){
                        $id = $form->save();
                        $update_data = array('file_name' => $file_name);
                        $this->board_exams_detailsmodel->update_board_exams($update_data, $id);
                        $this->session->set_flashdata('success', 'Document updated successfully.');
                        redirect('board_result_download');                    
                    }else{
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('board_result_download');
                    }
                }else{
                    $id = $form->save();
//                    $update_data = array('file_name' => $file_name);
//                    $this->board_exams_detailsmodel->update_board_exams($update_data, $id);
                    $this->board_exams_detailsmodel->update(array('file_name' => $this->examdetailsform->get_value('main_image'), 'id' => $this->examdetailsform->get_value('id')));
                    $this->session->set_flashdata('success', "Document updated successfully.");
                    redirect('board_result_download');
                }
            }
        }
    }
     public function edit($id) {
        $this->load->model('board_exams_detailsmodel');
        $info = $this->board_exams_detailsmodel->find($id);
        if(empty($info)){
            show_404();
        }
//        print_r($info);
        $info['main_image'] = $info['file_name'];
        $this->load->form('board_exam_detailsform', 'examdetailsform', $info);
    }
    function delete($id){
        if($id == ''){
            show_404();
        }
        $this->load->model('board_exams_detailsmodel');
        $this->board_exams_detailsmodel->delete($id);
        $this->session->set_flashdata('success',"Board Result has been deleted successfully");
        redirect('board_result_download');
    }
}
