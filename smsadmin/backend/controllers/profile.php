<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Sep 3, 2011
 */

class Profile extends BACKEND_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
	   $this->load->model('usermodel');
           $this->load->helper('date');
           $info = $this->usermodel->get_info($this->session->userdata('user_id'));
            if(empty($info)){
                show_404();
            }
            $this->tpl->set_css(array('jquery.loadmask'));
            $this->tpl->set_jquery_ui(array('dialog','position'));
            $this->tpl->set_js(array('jquery.loadmask','jquery.validate','jquery.form'));
            $this->tpl->assign('view_title','Profile details');
           $this->tpl->assign('view_button', array('url' => 'profile/password', 'title' => 'Change password', 'alt' => 'Change login password','class'=>'user_edit'));
           $labels = array('group_name'=>'User Group Name', 'username'=>'User Name','full_name'=>'Full Name','email'=>'Email', 'mobile_no'=>'Mobile No.',
                      'address'=>'Address','created_at'=>'Create Date');
           $this->tpl->assign('row',$info);
           $this->tpl->assign('labels',$labels);
	}
        function password(){
           $this->tpl->set_js(array('password_change_form'));
        }
        
        function passsave(){
            
        }
        
        function edit(){
            $this->load->model('usermodel');
            $info = $this->usermodel->find($this->session->userdata('user_id'));
            if(empty($info)){
                show_404();
            }
            $this->tpl->set_css(array('jquery.loadmask'));
            $this->tpl->set_jquery_ui(array('dialog','position'));
            $this->tpl->set_js(array('jquery.validate','jquery.form','jquery.loadmask'));
            $this->load->form('profileform','pform',$info);
        }
        function save(){
             $this->load->form('profileform','pform');
             if($this->pform->validate()){
                 $this->pform->set_value('id',$this->session->userdata('user_id'));
                 $this->pform->save();
                 $this->session->set_flashdata('success', "Profile information has been changed sucessfully.");
                 redirect('profile');
             }
             $this->tpl->set_view('edit');
        }
        
        function savepass(){
            $this->output->set_content_type('application/json');
            $old_pass = $this->input->post('old_password');
            $pass = $this->input->post('password');
            $re_pass = $this->input->post('password');
            $this->load->model('usermodel');
            $response = array('success' => 1, 'message' => '');
             $ret = $this->usermodel->has_same_password($this->session->userdata('user_id'),$old_pass);
            if(!$ret){
                $response['success'] = false;
                $response['message'] = 'Old password did not match';
            }
            elseif($pass != $re_pass){
                 $response['success'] = false;
                 $response['message'] = 'Two passwords are not equal';
            }
            else{
                 $response['success'] = true;
                 $response['message'] = 'Password has been modified successfully.';
                 $this->usermodel->update_password($this->session->userdata('user_id'),$pass);
            }
            $this->output->set_output(json_encode($response));
        }
}
?>