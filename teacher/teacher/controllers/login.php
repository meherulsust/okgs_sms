<?php
/*
 * Created on Nov 19, 2013
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Login extends Frontend_Controller
 {
 	function __construct()
 	{
                $this->set_ignore_auth('login'); 
 		parent::__construct();
                $this->tpl->set_layout('login_layout');
	}
	
	function index()
  	{		
                if($this->auth->is_logged_in())
                {
                       redirect('home');
                }	
        }
	
	function dologin()
	{
		 $user = $this->input->post('username');
		 $pass = $this->input->post('password');
         $type = 'teacher';		
		 $ret = $this->auth->check_login(array('username'=>$user,'passwd'=>$pass,'status'=>'ACTIVE'));
		 if($ret)
		 {
			redirect('home');
		 }
		 else
		 {
		 	$this->session->set_flashdata('error_msg',"<div class='error'>Username or password did not match.</div>");
		 	redirect('login');
		 }	
	}
	
	/*--------------- end login ------------------*/
	
	
	/*--------------- start forgot password ------------------*/	
	
	function forgot_password()
	{
		$this->load->library(array('form_validation'));
		$config=array(					
					array(
						'field'   => 'email',
						'label'   => 'E-mail',
						'rules'   => 'trim|required|valid_email|callback_email_check'
					)            
				);

		$this->form_validation->set_rules($config);
	  	$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
	  	
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('login/forgot_password');
		
		}else{
		
			$forgot_password_code=rand(1000000,9999999).rand(1000000,9999999);
			$email=$this->input->post('email');
			$topup_admin_user_id=$this->session->userdata('topup_admin_user_id');
			
			$this->loginmodel->update_forgot_password_code($topup_admin_user_id,$email,$forgot_password_code);   // update forgot password code
			
			$password=uniqid();
			$domain_str=$_SERVER['HTTP_HOST'];
			$domain_name = str_replace('www.','',$domain_str);
			$reseller_info = $this->homemodel->get_reseller($domain_name);  // get reseller info
			
			
			$to      = $email;
			$subject = 'Forgot Password';
			$message = "<p>Dear User,</p> 
				<p>Please <a href='".site_url()."/login/update_password/".$forgot_password_code."/".$password."'> Click Here </a> to change your password.</p> 
				<p>Your new password id :".$password."</p>
				<p>Thanks</p>
				".$this->session->userdata('domain')." Team</br>";
			$headers = "From:  ".$reseller_info['from_email']."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
			$mail=mail($to,$subject,$message,$headers);    // send email
			if($mail)
			{
				$this->session->set_flashdata('message',"<div class='success'>Please check your email for new password.</div>");
				redirect('login/forgot_password');
			}else{
				$this->session->set_flashdata('message',"<div class='error'>Email Error.</div>");
				redirect('login/forgot_password');
			}	 
				
		}
		
	}
	
	
	function update_password($forgot_password_code,$password)
	{
		$this->loginmodel->update_forgot_password($forgot_password_code,md5($password));   // update forgot password code
		$this->session->set_flashdata('error_message',"<div class='success'>Your password has been changed successfully.</div>");
		redirect('home');
	}
	
	
	
	function email_check($str)
	{
		$topup_admin_user_id=$this->session->userdata('topup_admin_user_id');
		$query = $this->db->query("SELECT id FROM topup_general_user where email='$str' AND topup_admin_user_id='$topup_admin_user_id'");
		if($query->num_rows()>0)
		{
			return true;				
		}else{
			$this->form_validation->set_message('email_check', "Email address doesn't found.");
			return false;
		}		
	}
	
	
	/*--------------- end forgot password ------------------*/
	
	function logout()
	{
		$this->auth->logout();
		redirect();
	}
    
	
 }

?>
