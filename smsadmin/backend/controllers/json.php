<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 30, 2012
 */
class Json extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->output->set_content_type('application/json');
        $this->tpl->set_view(false);
    }

    public function caste() {
        $this->load->model('castemodel');
        $religion_id = $this->input->post('personal_religion_id');
        $rs = $this->castemodel->caste_list_by_religion($religion_id);
        $this->output->set_output(json_encode($rs));
    }

    public function thana() {
        $rs = array('--Select Thana--');
        $district_id = '';
        $district_id = $this->input->post('present_district');
        if (!$district_id)
            $district_id = $this->input->post('permanent_district');
        if ($district_id) {
            $this->load->model('thanamodel');
            $rs = array_merge($rs, $this->thanamodel->get_list($district_id));
        }
        $this->output->set_output(json_encode($rs));
    }
    
    public function address_thana() {
        $rs = array('--Select Thana--');
        $district_id = '';
        $district_id = $this->input->post('district_id');
        if ($district_id) {
            $this->load->model('thanamodel');
            $rs = array_merge($rs, $this->thanamodel->get_list($district_id));
        }
        $this->output->set_output(json_encode($rs));
    }

    public function poffice() {
        $rs = array('--Select Post Office--');
        $thana_id = '';
        $thana_id = $this->input->post('present_thana');
        if (!$thana_id)
            $thana_id = $this->input->post('permanent_thana');
        if ($thana_id) {
            $this->load->model('Postofcmodel', 'pom');
            $rs = array_merge($rs, $this->pom->get_list($thana_id));
        }
        $this->output->set_output(json_encode($rs));
    }

    public function section() {
        $rs = array(array('id' => 0, 'title' => 'All Forms'));
        $class_id = $this->input->post('class_id');
        if (empty($class_id))
            $class_id = $this->input->post('sylabus_class_id');
        if ($class_id) {
            $this->load->model('sectionmodel', 'sm');
            $rows = $this->sm->select_where('id,title', array('class_id' => $class_id, 'status' => 'ACTIVE'));
            $rs = array_merge($rs, $rows ? $rows : array() );
        }
        $this->output->set_output(json_encode($rs));
    }
	
	
	public function class_time() {
        $rs = array(array('id' =>'', 'title' => '--- Select Time --- '));
        $class_id = $this->input->post('class_id');
        if ($class_id) {
            $this->load->model('classtimemodel', 'ct');
            $rows = $this->ct->select_where('id,title', array('class_id' => $class_id, 'status' => 'ACTIVE'));
            $rs = array_merge($rs, $rows ? $rows : array() );
        }
        $this->output->set_output(json_encode($rs));
    }

    public function admission_section() {
        $rs = array(array('id' => '', 'title' => '--Select Form--'));
        $class_id = $this->input->post('admission_class_id');
        if ($class_id) {
            $this->load->model('sectionmodel', 'sm');
            $rows = $this->sm->select_where('id,title', array('class_id' => $class_id, 'status' => 'ACTIVE'));
            $rs = array_merge($rs, $rows ? $rows : array() );
        }
        $this->output->set_output(json_encode($rs));
    }
	
	 public function exam() {
        $rs = array(array('id' => '', 'title' => '--Select Exam--'));
        $class_id = $this->input->post('admission_class_id');
        if ($class_id) {
            $this->load->model('exammodel', 'em');
            $rows = $this->em->select_where('id,title', array('class_id' => $class_id, 'status' => 'ACTIVE'));
            $rs = array_merge($rs, $rows ? $rows : array() );
        }
        $this->output->set_output(json_encode($rs));
    }
     public function current_admission() {
        $section_id = $this->input->post('section_id');
        if ($section_id) {
            $this->load->model('admissionmodel','am');
            $rs = $this->am->get_current_student_list($section_id);
        }
        $this->output->set_output(json_encode($rs));
    }

    public function sylabus($default = 1) {
        $rs = array();
        if ($default) {
            $rs = array(array('id' => 0, 'title' => 'Default'));
        }
        $section_id = $this->input->post('section_id');
        $class_id = $this->input->post('class_id');
        if ($class_id) {
            $this->load->model('sylabusmodel', 'sm');
            $rs = array_merge($rs, $this->sm->get_section_sylabus($class_id, $section_id));
        }
        $this->output->set_output(json_encode($rs));
    }

    public function uniqueroll() {
        $section_id = $this->input->post('section_id');
        $class_id = $this->input->post('class_id');
        $session = $this->input->post('session');
        $roll_no = $this->input->post('admission_class_roll');
        $id = $this->input->post('id');
        $this->load->model('admissionmodel', 'admodel');
        $flag = $this->admodel->is_roll_exist($id, $roll_no, $session, $class_id, $section_id);
        if ($flag)
            return $this->output->set_output("false");
        else
            return $this->output->set_output("true");
    }

    public function lookupcode() {
        $type_id = $this->input->post('type_id');
        $code = $this->input->post('lookup_unique_code');
        $id = $this->input->post('id');
        $this->load->model('lookupmodel');
        $flag = $this->lookupmodel->any_other_exists($id, $type_id, $code);
        if ($flag)
            return $this->output->set_output("false");
        else
            return $this->output->set_output("true");
    }

    public function chkpass() {
        $this->load->model('usermodel');
        $password = $this->input->post('old_password');
        $ret = $this->usermodel->has_same_password($this->session->userdata('user_id'), $password);
        if ($ret)
            return $this->output->set_output("true");
        else
            return $this->output->set_output("false");
    }

    function chksecroom() {
        $class_id = $this->input->post('class_id');
        $id = $this->input->post('id');
        $room_no = $this->input->post('section_room_number');
        $this->load->model('sectionmodel');
        $ret = $this->sectionmodel->room_number_exists($room_no, $id, $class_id);
        if ($ret)
            return $this->output->set_output("true");
        else
            return $this->output->set_output("false");
    }
    public function guardian($std_id,$type){
        $this->load->model('studentmodel','stdm');
        if( $rs = $this->stdm->get_guardian($std_id,$type)){
             $response['success'] = 1;
            $response['data'] = $rs;
        }else{
            $response['success'] = 0;
            $response['message'] = ucfirst($type).' information did not found';
        }
        return $this->output->set_output(json_encode($response));
    }
     public function address($std_id,$type='permanent'){
       $this->load->model('studentmodel','stdm');
        if( $rs = $this->stdm->get_address($std_id,$type)){
             $response['success'] = 1;
            $response['data'] = $rs;
        }else{
            $response['success'] = 0;
            $response['message'] = ucfirst($type).' address did not found';
        }
        return $this->output->set_output(json_encode($response));
    }
    
     function chkclassfee() {
        $class_id = $this->input->post('ctf_class_id');
        $head_id = $this->input->post('head_id');
        $id = $this->input->post('id');
        $this->load->model('classtuitionfeemodel','ctfmodel');
        $ret = $this->ctfmodel->fee_head_exists($class_id,$head_id);
        if(empty($ret)){
            return $this->output->set_output("true"); 
        }
        //in case of edit
        if($id){
            if($id == $ret){
                return $this->output->set_output("true"); 
            }
        }
        return $this->output->set_output("false");
    }
    
    function chksectionfee() {
        $section_id = $this->input->post('stf_section_id');
        $head_id = $this->input->post('head_id');
        $id = $this->input->post('id');
        $this->load->model('sectiontuitionfeemodel','stfmodel');
        $ret = $this->stfmodel->fee_head_exists($section_id,$head_id);
        if(empty($ret)){
            return $this->output->set_output("true"); 
        }
        //in case of edit
        if($id){
            if($id == $ret){
                return $this->output->set_output("true"); 
            }
        }
        return $this->output->set_output("false");
    }
	public function get_full_message() {
        $this->load->model('messagemodel');
        $message_id = $_POST['message_id'];
        $rs = $this->messagemodel->get_full_message($message_id);
        return $this->output->set_output(json_encode($rs['description']));
    }
	
	public function teacher() {
        $rs = array(array('id' => 0, 'title' => '--- Select ---'));
        $subject_id = $this->input->post('subject_id');        
        if ($subject_id) {
            $this->load->model('teachermodel');
            $rows = $this->teachermodel->select_where('id,name as title', array('relevant_subject_id' => $subject_id, 'status' => 'ACTIVE'));
            $rs = array_merge($rs, $rows ? $rows : array() );
        }
        $this->output->set_output(json_encode($rs));
    }
	

}

?>