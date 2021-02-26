<?php
/* 
 * Created on 14-06-2016
 * Developed by: Arena Development Team
 * 
 */

class Pen_picture extends BACKEND_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('pen_picturemodel');
        $this->load->model('publish_resultmodel');
    }
    function index(){
        $this->init_grid();
    }
    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Template List');
        $this->grid_board->add_link('Create New', site_url('pen_picture/add_template'), array('class' => 'add', 'id' => 'new_template'));
        $grid_columns = array('title' => 'Title', 'description' => 'Description');
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete'),            
        );
        $this->grid_board->set_action($actions);
        $as = $this->grid_board->render('pen_picturemodel');
    }
    function add_template(){
        $this->load->form('add_templateform');
    }
    function save_template(){
        $this->load->form('add_templateform');
        $this->tpl->set_view('add_template');
        $this->process_template_form($this->add_templateform);        
    }
    function process_template_form($form){
        if($form->validate()){
            $data['title'] = $this->input->post('template_title');
            $data['description'] = $this->input->post('template_description');
            $duplicate = $this->pen_picturemodel->check_template_duplicate($data['title']);
            if(empty($duplicate)){
                $template_id = $this->pen_picturemodel->add_template($data);
                $this->session->set_flashdata('success', 'The Template saved successfully');
                redirect('pen_picture');
            }else{
                $this->session->set_flashdata('error', 'The Template you are trying to create is already exist!');
                redirect('pen_picture/add_template');
//                redirect(base_url().'index.php/publish_result/create?class='.$data['class_id'].'&exam='.$data['exam_id'].'&subject='.$data['subject_id'].'&total_marks='.$data['total_marks']);
            }
        }
    }
    function edit($id = ''){
        if(empty($id))
            redirect ('pen_picture');
        $info = $this->pen_picturemodel->find($id);
        $this->load->form('add_templateform', NULL, $info);
        $this->tpl->assign('template_data', $info);
    }
    function update_template(){
        $this->load->form('add_templateform');
        $this->tpl->set_view('edit');
        $this->edit_data($this->add_templateform);
    }
    function edit_data($form){
        $template_id = $this->input->post('template_id');
        if($form->validate()){
            $data['title'] = $this->input->post('template_title');
            $data['description'] = $this->input->post('template_description');
            $template_id = $this->pen_picturemodel->update_template($template_id, $data);
            $this->session->set_flashdata('success', 'The Template updated successfully');
            redirect('pen_picture');
        }
    }
    function del($id){
        $this->pen_picturemodel->delete($id);
        $this->session->set_flashdata('success', 'The Template has been deleted Successfully');
        redirect('pen_picture');
    }
    function template_details() {
        $this->load->form('template_grid_boardform');
        $this->tpl->set_view('template_details');
        $this->insert_grid_board($this->template_grid_boardform);
    }
    function insert_grid_board($form) {
        if($form->validate()){
            $this->tpl->set_view('insert_grid_board');
            $class_id = $this->input->post('template_grid_class_id');
            $section_id = $this->input->post('template_grid_section_id');
            $exam_id = $this->input->post('template_grid_exam_id');
            
            $templates = $this->pen_picturemodel->get_templates();
            $this->tpl->assign('templates', $templates);
            
            $students = $this->publish_resultmodel->get_students_by_form($class_id, $section_id);
            $info = array();
            foreach ($students as $student){
                $data['student_name'] = $student['first_name']. ' '.$student['last_name'];
                $data['student_id'] = $student['student_id'];
                $data['class_roll'] = $student['class_roll'];
                $info[] = $data;
            }
            
            $this->tpl->assign('form_elements', $info);
            $entry_details = $this->pen_picturemodel->get_result_entry_details($class_id, $section_id);
            $this->tpl->assign('entry_details', $entry_details);
            $class_info = array('class_id'=> $class_id, 'exam_id' => $exam_id, 'section_id' => $section_id);
            $this->tpl->assign('info', $class_info);
            $activities = array('A'=> 'Outstanding', 'B' => 'Good', 'C' => 'Average', 'D' => 'Below Average', 'E' => 'Poor');
            $this->tpl->assign('activities', $activities);
            
        }
    }
    
    function insert_result(){
        $row_count = $this->input->post('row_count');
        $data['exam_id'] = $this->input->post('exam_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $check_template = $this->pen_picturemodel->check_penpic_entry($data['class_id'], $data['section_id'], $data['exam_id']);
        if($check_template > 0){
            $this->session->set_flashdata('error', 'Records already Exist');
            redirect('pen_picture/template_details'); 
        }else{
            for($i=0;$i<$row_count;$i++){
                $data['pen_picture_temaplte_id'] = $this->input->post('pen_picture_temaplte_id'.$i);
                $data['discipline'] = $this->input->post('discipline'.$i);
                $data['cleanliness'] = $this->input->post('cleanliness'.$i);
                $data['co_curricular_activities'] = $this->input->post('co_curricular_activities'.$i);
                $data['student_id'] = $this->input->post('student_id'.$i);
                $pen_pic_detail_id = $this->pen_picturemodel->add_pen_pic_details($data);
            }            
            $this->session->set_flashdata('success', 'The Student Pen Picture Deatails added successfully');
            redirect('pen_picture/template_details');       
        }
    }
    function update_entry() {
        $this->load->form('template_grid_boardform');
        $this->tpl->set_view('update_entry');
        $this->edit_entry($this->template_grid_boardform);
    }
    function edit_entry($form){
        if($form->validate()){
            $this->tpl->set_view('edit_entry');
            $class_id = $this->input->post('template_grid_class_id');
            $section_id = $this->input->post('template_grid_section_id');
            $exam_id = $this->input->post('template_grid_exam_id');
            
            $templates = $this->pen_picturemodel->get_templates();
            $this->tpl->assign('templates', $templates);
            
//            $students = $this->publish_resultmodel->get_students_by_form($class_id, $section_id);
            $students = $this->pen_picturemodel->get_students_ids($class_id, $section_id, $exam_id);
            
            $info = array();
            foreach ($students as $student){
                $student_name = $this->publish_resultmodel->get_student_name($student['student_id']);
                $section = $this->publish_resultmodel->get_section($student['student_id']);
                $data['student_name'] = $student_name['first_name'].' '. $student_name['last_name'];
                $data['student_id'] = $student['student_id'];
                $data['class_roll'] = $section['class_roll'];                  
                
                $template = $this->pen_picturemodel->get_template_info($data['student_id'], $class_id, $section_id, $exam_id);
                
                $data['pen_picture_temaplte_id'] = $template['pen_picture_temaplte_id'];
                $data['discipline'] = $template['discipline'];
                $data['cleanliness'] = $template['cleanliness'];
                $data['co_curricular_activities'] = $template['co_curricular_activities'];
                $data['pen_detail_id'] = $template['id'];
                
                $info[] = $data;
            }
            
            $this->tpl->assign('form_elements', $info);
            $entry_details = $this->pen_picturemodel->get_result_entry_details($class_id, $section_id);
            $this->tpl->assign('entry_details', $entry_details);
            $class_info = array('class_id'=> $class_id, 'exam_id' => $exam_id, 'section_id' => $section_id);
            $this->tpl->assign('info', $class_info);
            $activities = array('A'=> 'Outstanding', 'B' => 'Good', 'C' => 'Average', 'D' => 'Below Average', 'E' => 'Poor');
            $this->tpl->assign('activities', $activities);            
        }
    }
    function update_pen_pictures() {
        $row_count = $this->input->post('row_count');                
        $data['exam_id'] = $this->input->post('exam_id');
        if(!empty($row_count)){
            for($i=0;$i<$row_count;$i++){
                $data['pen_picture_temaplte_id'] = $this->input->post('pen_picture_temaplte_id'.$i);
                $data['discipline'] = $this->input->post('discipline'.$i);
                $data['cleanliness'] = $this->input->post('cleanliness'.$i);
                $data['co_curricular_activities'] = $this->input->post('co_curricular_activities'.$i);
                $data['student_id'] = $this->input->post('student_id'.$i);
                $id = $this->input->post('pen_details_id'.$i);

            $edit_pen_pic = $this->pen_picturemodel->edit_pen_pic_details($id, $data);
            }
        $this->session->set_flashdata('success', 'The Student Pen Picture Deatails Updated successfully');
        redirect('pen_picture/update_entry');
        }
    }
}