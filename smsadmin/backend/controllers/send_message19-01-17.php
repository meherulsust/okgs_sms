<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    August 31, 2012
 */
class Send_message extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->load->filter('send_message_filter', 'mf');
        $this->init_message_grid();
		
		//sms information
		
		/* $username='arerajcpsc';
		$password='arerajcpsc!@#';
		$security_code='arenaapi!@#';
		$url = 'http://202.126.120.118/smsenquiry/index.php/webservice';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&security_code=$security_code");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec ($ch);
		$data   = json_decode($result, TRUE);
		$result = array_flip($data);
		curl_close ($ch);
		$this->tpl->assign('result',$result); */
    }

    protected function init_message_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Sent message list');
        $this->grid_board->set_filter($this->mf);
        $this->grid_board->add_link('Send SMS', site_url('send_message/send_sms'), array('class' => 'add', 'id' => 'new_message'));
        $grid_columns = array('id' => array('visible' => false), 'full_name' => 'Student', 'class' => 'Class', 'section' => 'Form', 'house_name' => 'House', 'message' => 'Message','mobile' => 'Mobile No.',
            'created_at' => array('title' => 'Date', 'datetime' => true), 'status' => 'Status');
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'del' => array('title' => 'Delete', 'action' => 'del_message', 'controller' => '', 'tips' => 'Delete this message'),
        );
        $this->grid_board->set_action($actions);
        //$this->grid_board->render('sentmessagemodel');
		$params = array('count_method' => 'message_count', 'model' => 'sentmessagemodel', 'method' => 'message_list');
        $this->grid_board->render($params);
    }

    function filter() {
        $this->load->filter('send_message_filter', 'mf');
        $this->mf->execute();
        redirect('send_message/index');
    }

    function send_sms() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'send_message_form'));
        $this->load->form('sendmessageform');
    }

    public function save_send_message() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'send_message_form'));
        $this->load->form('sendmessageform');
        $this->tpl->set_view('send_sms');
        //$this->message_process_form($this->sendmessageform);
		$this->load->model('messagemodel');		
		$this->load->model('sentmessagemodel');
		$message_row = $this->messagemodel->get_full_message($this->input->post('send_message_message_id'));
		$full_message = $message_row['description']; 
        foreach ($this->input->post('student_number') as $lm => $val) {
            $data['student_id'] = $val;
            $data['message_id'] = $this->input->post('send_message_message_id');
            $data['created_at'] = date('Y-m-d h:i:s');
			
			$row = $this->sentmessagemodel->get_student_mobile_no($val);
			
			/*---------- send message config -----------*/
			/*$sms_id=rand(100000,999999);
			$gsm='880'.substr($row['mobile'],-10);
			$message=urlencode($full_message);
			$username='arerajcpsc';
			$password='arerajcpsc!@#';
			$security_code='arenaapi!@#';
			$url = 'http://202.126.120.118/smsenquiry/index.php/home';
						
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec ($ch);
			curl_close ($ch); 	
			
			//$result = substr($output, 0, 4);
			if($result==1)
			{
				$data['status']=1;
			}else{
				$data['status']=0;
			}
			
			/*---------- send message config -----------*/
			
            $this->sentmessagemodel->add_sent_message($data);         // add sent message
        }
       

        $this->session->set_flashdata('success', "Message has been sent successfully");
      	redirect('send_message/filter');
    }

    protected function message_process_form($form, $data) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Message has been sent successfully");
            else
                $this->session->set_flashdata('success', "Message has been sent successfully");
            redirect('send_message/index');
        }
    }

    public function del_message($id) {
        if (empty($id))
            redirect('send_message/index');

        $this->load->model('sentmessagemodel');
        $this->sentmessagemodel->delete($id);
        $this->session->set_flashdata('success', "Message has been deleted successfully");
        redirect('send_message/index');
    }

    function get_student_list() {
        $this->load->model('sentmessagemodel');
        $data['class_id'] = $_POST['class_id'];
		$data['section_id'] = $_POST['section_id'];
		$data['house_id'] = $_POST['house_id'];
		$data['facility_id'] = $_POST['facility_id'];
		
		$student_list = $this->sentmessagemodel->get_student_list($data);         // get student
        
		if(!empty($student_list)) 
		{
			$this->html = '';
			$this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
					<table width="50%">
						<thead>
						<tr>
							<th style="width:20px !important;"><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
							<th style="width:300px !important;text-align:center !important;">Student Name</th>
							<th style="text-align:center !important;">Roll</th>
							<th>Mobile No.</th>
						</tr>	
						<thead>';
			foreach ($student_list as $val) {

				$this->html .='<tr>
							<td align="center"><input type="checkbox" name="student_number[]" value="' . $val['id'] . '"/></td>
							<td>' . $val['student_name'] . '</td>
							<td style="text-align:center !important;">' . $val['class_roll'] . '</td>
							<td>' . $val['mobile'] . '</td>
						</tr>';
			}
			$this->html .='</table>
				</div>';
		}else{
			$this->html = 'Student not found.';
		}    
        $html = $this->html;
        return $this->output->set_output($html);
    }
	
	
    /**********************  SMS send to Teacher  ***********************/
	
	function teacher_sms() {
        $this->tpl->set_js('select-chain');
        $this->init_teacher_message_grid();
    }

    protected function init_teacher_message_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Sent teacher message list');
        $this->grid_board->add_link('Send SMS', site_url('send_message/teacher_send_sms'), array('class' => 'add', 'id' => 'new_message'));
        $grid_columns = array('id' => array('visible' => false), 'teacher_name' => 'Teacher','message' => 'Message','mobile_no' => 'Mobile No.',
            'created_at' => array('title' => 'Date', 'datetime' => true), 'status' => 'Status');
        $this->grid_board->set_column($grid_columns);
        $actions = array(
            'del' => array('title' => 'Delete', 'action' => 'del_message', 'controller' => '', 'tips' => 'Delete this message'),
        );
        $this->grid_board->set_action($actions);
        //$this->grid_board->render('sentmessagemodel');
		$params = array('count_method' => 'message_count', 'model' => 'sentteachermessagemodel', 'method' => 'message_list');
        $this->grid_board->render($params);
    }

    function teacher_send_sms() {
        $this->tpl->set_js(array('select-chain','jquery.validate', 'send_message_form'));
        $this->load->form('sendteachermessageform');
		$designation_id = 'designation_id';
    }

    public function teacher_save_send_message() {        
		$this->tpl->set_js(array('select-chain','jquery.validate', 'send_message_form'));
        $this->load->form('sendteachermessageform');
        $this->tpl->set_view('send_sms');
        //$this->message_process_form($this->sendmessageform);
		$this->load->model('messagemodel');		
		$this->load->model('sentteachermessagemodel');
		$message_row = $this->messagemodel->get_full_message($this->input->post('send_message_message_id'));
		$full_message = $message_row['description']; 
        foreach ($this->input->post('teacher') as $lm => $val) {
            $data['id'] = $val;
            $data['message_id'] = $this->input->post('send_message_message_id');
            $data['created_at'] = date('Y-m-d h:i:s');
			
			$row = $this->sentteachermessagemodel->get_teacher_mobile_no($val);
			
			/*---------- send message config -----------*/
			$sms_id=rand(100000,999999);
			$gsm='880'.substr($row['mobile_no'],-10);
			$message=urlencode($full_message);
			$username='arerajcpsc';
			$password='arerajcpsc!@#';
			$security_code='arenaapi!@#';
			$url = 'http://202.126.120.118/smsenquiry/index.php/home';
						
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$username&password=$password&gsm=$gsm&message=$message&sms_id=$sms_id&security_code=$security_code");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec ($ch);
			curl_close ($ch); 
			
			//$result = substr($output, 0, 4);
			if($result==1)
			{
				$data['status']=1;
			}else{
				$data['status']=0;
			}
			
			/*---------- send message config -----------*/
			
            $this->sentteachermessagemodel->add_sent_teacher_message($data);         // add sent message
        }
       

        $this->session->set_flashdata('success', "Message has been sent successfully");
      	redirect('send_message/teacher_filter');
    }

    protected function teacher_message_process_form($form, $data) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "Message has been sent successfully");
            else
                $this->session->set_flashdata('success', "Message has been sent successfully");
            redirect('send_message/teacher_sms');
        }
    }

    public function teacher_del_message($id) {
        if (empty($id))
            redirect('send_message/teacher_sms');

        $this->load->model('sentteachermessagemodel');
        $this->sentmessagemodel->delete($id);
        $this->session->set_flashdata('success', "Message has been deleted successfully");
        redirect('send_message/teacher_sms');
    }

    function get_teacher_list($designation_id='') {
        $this->load->model('sentteachermessagemodel');
		$data['designation_id'] = $_POST['designation_id'];
		if($data['designation_id']==''){
			$teacher_list = $this->sentteachermessagemodel->get_all_teacher_list();         // get teacher
		}else{
			$teacher_list = $this->sentteachermessagemodel->get_teacher_list($data);         // get teacher
		}		
        
		if(!empty($teacher_list)) 
		{
			$this->html = '';
			$this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
					<table width="50%">
						<thead>
						<tr>
							<th style="width:20px !important;"><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
							<th style="width:300px !important;text-align:center !important;">Teacher Name</th>
							<th>Mobile No.</th>
						</tr>	
						<thead>';
			foreach ($teacher_list as $val) {

				$this->html .='<tr>
							<td align="center"><input type="checkbox" name="teacher[]" value="' . $val['id'] . '"/></td>
							<td>' . $val['name'] . '</td>
							<td>' . $val['mobile_no'] . '</td>
						</tr>';
			}
			$this->html .='</table>
				</div>';
		}else{
			$this->html = 'Teacher not found.';
		}    
        $html = $this->html;
        return $this->output->set_output($html);
    }

}