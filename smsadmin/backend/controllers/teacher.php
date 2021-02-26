<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */
class Teacher extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->init_grid();
    }
	
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Teacher List');
        $grid_columns = array('id' => array('visible' => false),'full_name' => array('title'=>'Full Name','link'=>'teacher/view','tips'=>'View teacher details'),
            'designation'=>'Designation','username'=>'Username','email'=>'Email','mobile_no' => 'Mobile', 'gender' => 'Gender','relevant_subject'=>'Relevant Subject','edulabel'=>'Qualification','status' => array('title' => 'Status', 'status' => 'status'));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('teachermodel');
    }
	
    function create() {
        $this->load->form('teacherform', 'tform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
    }
	
	function save() {
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $this->load->form('teacherform', 'tform');
        $this->process_form($this->tform);
        $this->tpl->set_view('create');
    }
	
    public function edit($id) {
        $this->load->model('teachermodel');
        $info = $this->teachermodel->find($id);
        if(empty($info)){
            show_404();
        }
        
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        if (empty($info['dob'])) {
            $info['datepicker'] = date('Y-m-d');
        } else {
            $date = new DateTime($info['dob']);
            $info['datepicker'] = $date->format('d F, Y');
        }
		$info['main_photo']= $info['photo'];
        $this->load->form('teacherform','tform', $info);
		$this->process_form($this->tform);        
    }
	
	
    protected function process_form($form) {
        $this->load->form('teacherform','tform');
        $this->load->model('teachermodel');
        if ($form->validate()) {
           
			if(trim($_FILES["teacher_photo"]["name"])!='') 
			{
				$ext = end(explode(".", $_FILES['teacher_photo']['name']));
				$image_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;
				
				$upconfig['upload_path'] = $this->config->item('upload_dir').'/teacher_photo/';
				$file_info = pathinfo($image_name);
				$upconfig['file_name']=basename($image_name,'.'.$file_info['extension']);
				$upconfig['allowed_types'] = 'gif|jpg|png';
				$upconfig['max_size'] = '5000000';
				$upconfig['max_width'] = '400';
				$upconfig['max_height'] = '400';
				$upconfig['overwrite'] = FALSE;
				$this->load->library('upload',$upconfig);
				if($this->upload->do_upload('teacher_photo')) {
					$id = $form->save();
					
					if ($form->is_new()){
                        $this->teachermodel->update(array('photo'=>$image_name,'id'=>$id));
                        $this->session->set_flashdata('success', "Teacher has been created successfully.");
					}
					else{
                        $this->teachermodel->update(array('photo'=>$image_name,'id'=>$this->tform->get_value('id')));
                        $this->session->set_flashdata('success', "Teacher has been updated successfully.");
					}    
					redirect('teacher');	
					
				}else{
					$this->session->set_flashdata('error', $this->upload->display_errors());
				} 		
					
			}else{
				$id = $form->save(); 
				if ($form->is_new()){
					$this->session->set_flashdata('success', "Teacher has been created successfully.");   
				}
				else{
					$this->teachermodel->update(array('photo'=>$this->tform->get_value('main_photo'),'id'=>$this->tform->get_value('id')));
					$this->session->set_flashdata('success', "Teacher has been updated successfully.");
				}                
				redirect('teacher');
			}	
        }
    }

    function view($id = '') {
        if (empty($id))
            show_error('Requested url is not correct!');
        $this->load->helper('date');
		$columns = array('full_name' => 'Name','dob' => 'Date of Birth','gender'=>'Gender','blood_group' => 'Blood Group', 'religion' => 'Religion','address'=>'Address','email' => 'Email', 'mobile_no' => 'Mobile Number','relevant_subject'=>'Relevant Subject',
		'photo' => array('title' => 'Photo', 'type' => 'image', 'path' => base_url() . 'uploads/teacher_photo/', 'width' => '100', 'height' => '100'),);
		$info = $this->load->model('teachermodel');
		$this->tpl->assign('view_title','Teacher Details');
		$this->tpl->assign('view_button',array('url'=>'teacher/edit/'.$id,'alt'=>'Edit Teacher','title'=>'Edit Teacher'));
		$info = $this->teachermodel->get_details_info($id);
		$this->tpl->assign('row',$info);
		$this->tpl->assign('labels',$columns);
		$this->tpl->set_view('elements/record_view',true);	
    }
	
	
	function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('teacher');
        $this->load->model('teachermodel');
        $this->teachermodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Teacher status has been changed successfully");
        redirect('teacher');
    }
	
    public function del($id) {
        $this->load->model('teachermodel');        
		$this->teachermodel->delete($id);
		$this->session->set_flashdata('success', "Teacher has been deleted successfully.");
		redirect('teacher');       
    }

    public function photo($std_id, $id = '') {
        $this->load->model('photomodel');
        $this->tpl->assign('id', $id);
        if ($id) {
            $this->load->form('photoform', 'pform', array('id' => $id, 'student_id' => $std_id));
        } else {
            $this->load->form('photoform', 'pform');
            $this->tpl->assign('photos', $this->photomodel->get_student_photo($std_id));
            $this->pform->set_defaults(array('student_id' => $std_id, 'id' => $id));
        }
    }

    public function upload($id = '') {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->load->form('photoform', 'pform');
        $this->pform->validate();
        if ($id) {
            $this->load->model('photomodel');
            $info = $this->photomodel->find($id);
            $file_name = $info['file_name'];
        }
        $this->photomodel->db->trans_start();
        $photo_id = $this->pform->save();
        $std_id = $this->pform->get_value('student_id');
        $config['upload_path'] = $this->config->item('upload_dir').'/std_photo';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '120000';
        $config['max_width'] = '350';
        $config['max_height'] = '350';
        $config['file_name'] = 'std_photo_' . $photo_id;
        $this->load->library('upload', $config);
        $this->output->set_content_type('application/json');
        if (!$this->upload->do_upload('photo_image')) {
            $response = array('success' => 0, 'message' => $this->upload->display_errors());
            $this->photomodel->db->trans_rollback();
        } else {
            $data = $this->upload->data();
            $result['file_name'] = $data['file_name'];
            $result['image_type'] = $data['file_type'];
            $result['image_size'] = $data['image_width'] . 'x' . $data['image_height'];
            $result['id'] = $photo_id;
            $this->load->model('photomodel');
            $this->photomodel->save($result);
            $response = array('success' => 1, 'message' => 'Photo uploaded successfully.');
            $response['redirect'] = site_url('student/photo/' . $std_id);
            $response['photo'] = base_url() . str_replace('./', '', $this->config->item('upload_dir')).'std_photo/' . $data['file_name'];
            $this->session->set_flashdata('success', "Photo has been uploaded successfully");
            if ($id && $file_name) {
                unlink($this->config->item('upload_dir') . $file_name);
            }
            $this->photomodel->db->trans_commit();
        }
        $this->output->set_output(json_encode($response));
    }

   public function uniqueusername($str)
	{
		$this->load->form('teacherform', 'tform');
		$form = $this->tform;
		$param = $form->get_value('username');
		$this->load->model('teachermodel');
		$count = $this->teachermodel->check_duplicate_user($str,$param);
		if($count>0)
		{
			$this->form_validation->set_message('uniqueusername', "This user already exists.");
			return false;
		}
		return true; 
	}   
	public function matchpasswrd($str,$param='')
	{
		if($this->input->post('teacher_passwd')!=$this->input->post('teacher_repasswd'))
		{
          $this->form_validation->set_message('matchpasswrd', " Password does not match");
		 	 	 return false;
		}
		return true;
	}   

}

?>
