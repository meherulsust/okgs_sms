<?php
/*
 * Created on Sept 07, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Home extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
		$this->load->helper('download');
    }

  	function index()
	{		
		$this->load->model('teachermodel');
		$user_id = $this->auth->get_user()->id;
		$info = $this->teachermodel->teacher_details($user_id);
		$designation_id = $info[0]['designation_id'];
		$g_notice = $this->teachermodel->get_general_notice($designation_id);	
		$this->tpl->assign('general_notice',$g_notice);	

	}	
	
	function all_notice($class_id='')
	{
		$this->load->model('teachermodel');
		if($class_id){
			$head='Personal Notice';
		}else{
			$head='General Notice';
		}
		$this->tpl->assign('head',$head);
		$all_notice = $this->teachermodel->get_all_notice($class_id);
		$this->tpl->assign('notice',$all_notice);	
	}
	
	function myprofile(){
		$this->load->model('teachermodel');
		$user_id = $this->auth->get_user()->id;
		$details = $this->teachermodel->teacher_details($user_id);
		$this->tpl->assign('details',$details);
		$this->tpl->assign('user_id',$user_id);
	}
	
	function prospectus()
	{
	
	}
	
	function download()
	{
		$data = file_get_contents("./images/prospectus.pdf"); 
		force_download('prospectus.pdf',$data);	
	}
	
	function class_routine()
	{
            $this->tpl->set_js('select-chain');
            $this->load->model('teachermodel');
            $teacher_id = $this->auth->get_user()->id;
            $routine_list = $this->teachermodel->get_class_routine($teacher_id);
            $this->tpl->assign('routine_list',$routine_list);
            $day_list = $this->teachermodel->get_class_day();
            $this->tpl->assign('day_list',$day_list);
            //Extra class
            $extra_classes = $this->teachermodel->get_extra_classes($teacher_id);
            $this->tpl->assign('extra_classes', $extra_classes);		
	}
	
	public function section() 
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teachermodel');
		$class_id = $this->input->post('class_id');	
		$rs=array(array('id'=>'','title'=>'Select Section'));	
		$get_section = array_merge($rs,$this->teachermodel->get_section($class_id));
        $this->output->set_output(json_encode($get_section)); 
    }
	
	function get_routine()
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('teachermodel');
		$class_id = $this->input->post('class_id');
		$section_id = $this->input->post('section_id');
		$get_class = $this->teachermodel->get_class();
		$routine_list = $this->teachermodel->get_class_routine($class_id,$section_id);
		$this->tpl->assign('routine_list',$routine_list);
		$time_list = $this->teachermodel->get_class_time($class_id);
		$this->tpl->assign('time_list',$time_list);
		$day_list = $this->teachermodel->get_class_day();
		$this->tpl->assign('day_list',$day_list);		
		$this->tpl->assign('get_class',$get_class);
	}
	
	
	function change_password()
	{
		$this->load->library(array('form_validation'));
		$config = array(
               array(
                     'field'   => 'old_password',
                     'label'   => 'Old Password',
                     'rules'   => 'trim|required|xss_clean|callback_password_check'
                  ),
			  array(
                     'field'   => 'new_password',
                     'label'   => 'New Password',
                     'rules'   => 'trim|required|min_length[6]|max_length[20]|matches[retype_password]|xss_clean'
                  ),
			  array(
                     'field'   => 'retype_password',
                     'label'   => 'Re-type Password',
                     'rules'   => 'trim|required|xss_clean'
                  )
            );

		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	  	if ($this->form_validation->run() == FALSE)
		{			
			//$this->load->view('home/change_password');			
		}
		else
		{
			$this->load->model('teachermodel');
			$st_id = $this->auth->get_user()->id;
			$passwd = $this->input->post('new_password');
			$this->teachermodel->update_password($st_id,$passwd);  // update password
			$this->session->set_flashdata('message',"<div class='success'>Password has been changed successfully.</div>");
			redirect('home/change_password');
			
		}
	}
	
	function edit_profile($id)
	{
		$this->load->model('teachermodel');
		$teacher = $this->teachermodel->get_record($id);       // get record
        $this->tpl->assign('teacher',$teacher);
		$this->load->library(array('form_validation'));
		$config = array(
               array(
                     'field'   => 'teacher_name',
                     'label'   => 'teacher_name',
                     'rules'   => 'trim|required|xss_clean'
                  ),
			  array(
                     'field'   => 'username',
                     'label'   => 'username',
                     'rules'   => 'trim|required|xss_clean|callback_username_check'
                  ),
            array(
                     'field'   => 'dob',
                     'label'   => 'dob',
                     'rules'   => 'trim|required|xss_clean'
                  ),
            array(
                     'field'   => 'gender',
                     'label'   => 'gender',
                     'rules'   => 'trim|required|xss_clean'
                  ),

            array(
                     'field'   => 'blood_group_id',
                     'label'   => 'blood_group_id',
                     'rules'   => 'trim|xss_clean'
                  ),
            array(
                     'field'   => 'religion_id',
                     'label'   => 'religion_id',
                     'rules'   => 'trim|xss_clean'
                  ),
            array(
                     'field'   => 'address',
                     'label'   => 'address',
                     'rules'   => 'trim|required|xss_clean'
                  ),
            array(
                     'field'   => 'mobile_no',
                     'label'   => 'mobile_no',
                     'rules'   => 'trim|required|xss_clean'
                  ),
            array(
                     'field'   => 'email',
                     'label'   => 'email',
                     'rules'   => 'trim|required|xss_clean'
                  ),
            array(
                     'field'   => 'relevant_subject_id',
                     'label'   => 'relevant_subject_id',
                     'rules'   => 'trim|xss_clean'
                  )
            );

		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	  	if ($this->form_validation->run() == FALSE)
		{			
			$designation_options = $this->teachermodel->get_designation();
			$this->tpl->assign('designation_options',$designation_options);
			
			$blood_group_options = $this->teachermodel->get_blood_group();
			$this->tpl->assign('blood_group_options',$blood_group_options);
			
			$religion_options = $this->teachermodel->get_religion();
			$this->tpl->assign('religion_options',$religion_options);
			
			$subject_options = $this->teachermodel->get_subject();
			$this->tpl->assign('subject_options',$subject_options);
			
			$gender_options = array('MALE'=>'MALE','FEMALE'=>'FEMALE');
			$this->tpl->assign('gender_options',$gender_options);
			
			//$this->load->view('home/edit_profile');			
		}
		else
		{
			$data['name'] = $this->input->post('teacher_name');
			$data['designation_id'] = $this->input->post('designation_id');
			$data['username'] = $this->input->post('username');
			$data['dob'] = $this->input->post('dob');
			$data['gender'] = $this->input->post('gender');
			$data['blood_group_id'] = $this->input->post('blood_group_id');
			$data['religion_id'] = $this->input->post('religion_id');
			$data['address'] = $this->input->post('address');
			$data['mobile_no'] = $this->input->post('mobile_no');
			$data['email'] = $this->input->post('email');
			$data['relevant_subject_id'] = $this->input->post('relevant_subject_id');
			$data['updated_at'] = date('Y-m-d');

			if (trim($_FILES["photo"]["name"]) != '') {
					$ext = end(explode(".", $_FILES['photo']['name']));
				$file_name = rand(100000, 999999) . '_' . rand(100000, 999999) . '.' . $ext;
				if ($this->upload_images('photo', $file_name)) {

					$data['photo'] = $file_name;
					$teacher_id = $this->teachermodel->edit_teacher($id, $data);
					if ($teacher_id) {
						$this->session->set_flashdata('message', "<div class='info'>Updated successfully</div>");
						redirect('home/myprofile');
					}
				} else {
					$e_data['upload_error'] = $this->upload->display_errors();
					//$this->load->view('tender/edit_tender', $e_data);
				}
			} else {
				$teacher_id = $this->teachermodel->edit_teacher($id, $data);
				if ($teacher_id) {
					
					$this->session->set_flashdata('message', "<div class='info'>Updated successfully</div>");
					redirect('home/myprofile');
				}
			}
			
		
		}
	}
	
	
	function password_check($str)
	{
		$st_id = $this->auth->get_user()->id;
		
		$query = $this->db->query("SELECT id FROM sms_student where id='$st_id' AND passwd='$str'");
		if($query->num_rows()>0)
		{
			return true;			
		}else{
			$this->form_validation->set_message('password_check', "Old password doesn't match.");
			return false;
		}
		
	}
	
	function username_check($str)
	{
		$st_id = $this->auth->get_user()->id;
		
		$query = $this->db->query("SELECT id FROM sms_teacher where NOT id='$st_id'");
		if($query->num_rows()>0)
		{
			return true;			
		}else{
			$this->form_validation->set_message('username_check', "Username already exist.");
			return false;
		}
		
	}
	
	function upload_images($field_name, $image_name) {
        $upconfig['upload_path'] = "./../smsadmin/uploads/teacher_photo";
        $file_info = pathinfo($image_name);
        $upconfig['file_name'] = basename($image_name, '.' . $file_info['extension']);
        $upconfig['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
        $upconfig['max_size'] = '500000';
        $upconfig['max_width'] = '1024';
        $upconfig['max_height'] = '768';
        $upconfig['overwrite'] = FALSE;
        $this->load->library('upload');
        $this->upload->initialize($upconfig);

        if (!$this->upload->do_upload($field_name)) {
            return false;
        } else {
            $updata = $this->upload->data();
            return true;
        }
    }
	
	
	
 }
