<?php

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 5, 2013
 */
class Transfer extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        //$this->load->filter('studenttransferfilter', 'stdtf');
        $this->tpl->set_jquery_ui(array('position', 'dialog'));
        $this->tpl->set_js(array('student_transfer', 'jquery.validate', 'jquery.form', 'jquery.loadmask'));
        $this->tpl->set_css(array('jquery.loadmask'));
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Student list');
        //$this->grid_board->set_filter($this->stdtf);
        $this->grid_board->add_link('Initiate Student Transfer ', site_url('transfer/transfernew'), array('class' => 'add', 'id' => 'new_transfer'));
        $grid_columns = array('id' => array('visible' => false), 'student_number' => 'Student ID', 'student_name' => 'Student Name','father_name' => "Father's Name",'mother_name' => "Mother's Name",
            'created_at' => 'Create Date', 'mobile' => 'Mobile', 'gender' => 'Gender');
        $actions = array(
                            'view'=>array('title'=>'View','action'=>'view','controller'=>'','tips'=>'View details of this record'),
                            'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit transfer information'),
                            //'certificate'=>array('title'=>'Transfer Certificate','action'=>'certificate','controller'=>'','tips'=>'generate transfer certificate'),
                            //'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete transfer information'),
                            );
		$this->grid_board->set_action($actions);
		$this->grid_board->set_column($grid_columns);
		$this->grid_board->render('studenttransfermodel');
    }
	
		
	
    public function transfernew() {
        $this->load->form('studenttransferform', 'stform');
    }

    public function stdinfo($std_number) {
        $this->load->model('studentmodel');
        $info = $this->studentmodel->find_info_by_number($std_number);
        $record_exists = false;
        if ($info) {
            $this->tpl->assign($info);
            $record_exists = true;
        }
        $this->tpl->assign('has_record', $record_exists);
        $this->tpl->set_view('elements/student_info_modal', true);
    }

    public function save() {
        $this->output->set_content_type('application/json');
        $response = array('success' => 0, 'message' => 'Student number is not valid.');
        $student_number = $this->input->post('transfer_student_number');
        if ($student_number) {
            $this->load->model('studentmodel');
            $student_id = $this->studentmodel->find_one_by('id', array('student_number' => $student_number));
            if ($student_id) {
                $this->load->form('studenttransferform', 'stform', array('student_id' => $student_id));
                if ($this->stform->validate()) {
                    $_POST['transfer_student_id'] = $student_id;
                    $this->stform->save();
                    $response['success'] = 1;
                    $response['redirect'] = site_url('transfer/index');
					$update_data['status_id']=5;
					$this->studenttransfermodel->update_status($student_id,$update_data);
                    if($this->stform->is_new())
                        $this->session->set_flashdata('success', "Student transfer has been initiated successfully");
                    else
                        $this->session->set_flashdata('success', "Student transfer information has been updated successfully");
                }else{
                    $response['message'] = 'Student already exist in TC list.';
                }
            }
        }
        $this->output->set_output(json_encode($response));
    }
    
    public function edit($id){
        $this->load->model('studenttransfermodel','stmodel');
        $info = $this->stmodel->get_info($id);
        if(empty($info))
            show_404 ();
        $this->load->form('studenttransferform','stform',$info);
        $this->tpl->set_view('transfernew');   
    }
    public function view($id){
         $this->load->model('studenttransfermodel','stmodel');
         $info = $this->stmodel->record_info($id);
          if(empty($info))
            show_404 ();
        $this->load->helper('date');
        $this->tpl->assign('row',$info);
        $labels = array('photo' => array('title' => 'Photo', 'type' => 'image', 'path' => base_url() . 'uploads/std_photo/', 'width' => '100', 'height' => '100'),
				   'student_number'=>'Student Number','student_name'=>'Student Name','father_name' => "Father's Name",'mother_name' => "Mother's Name",'reason'=>'Transfer Reason','dob'=>'Date Of Birth',				   
				   'mobile' => 'Mobile', 'gender' => 'Gender','class'=>'Class','section'=>'Section','class_roll'=>"Roll",'comments'=>'Comments',
                   'created_at'=>'Created At');
        $this->tpl->assign('labels',$labels);
        $this->tpl->set_view('elements/record_view',true);
    }
    public function certificate($id){
        $this->tpl->set_layout('print_layout'); 
        $this->load->model('studenttransfermodel','stmodel');
        $info = $this->stmodel->get_student_info($id);
        $this->load->helper('date');
        $this->tpl->assign($info);
        $this->tpl->set_page_title(' Student Transfer certificate -'.$info['student_number']);
    }
    public function del($id){
         $this->load->model('studenttransfermodel','stmodel');
         $info = $this->stmodel->find($id);
         if(empty($info))
            show_404 ();
         $this->stmodel->delete($id);
         $this->session->set_flashdata('success', "Student transfer record has been deleted successfully");
         redirect('transfer');
         
    }
	
	
	function duplicate_student_check($str)
  	{
		$this->load->model('studentmodel');
        $student_id = $this->studentmodel->find_one_by('id', array('student_number' => $str));
		
		
		$query = $this->db->query("SELECT id FROM sms_student_transfer where student_id='$student_id'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('duplicate_student_check', "%s <span style='color:green;'>$student_id</span> already exists");
			return false;
		}else{
			return true; 
		}
  	}
	

}

?>