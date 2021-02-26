<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    June 30, 2012
 */
class Student extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->load->filter('studentfilter', 'stdf');
        $this->init_grid();
    }

    function create() {
        $this->load->form('personaldetailsform', 'piform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
    }

    public function edit($id) {
        $this->load->model('studentmodel');
        $row = $this->studentmodel->find($id);
        if(empty($row)){
            show_404();
        }
        $this->load->model('personaldetailsmodel', 'pdm');
        $info = $this->pdm->find($row['personal_details_id']);
        if(empty($info)){
            show_404();
        }
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $info['std_number'] = $row['student_number'];
	    $info['student_number'] = $row['student_number'];
	    $info['passwd'] = $row['passwd'];
	    $info['std_id'] = $row['id'];	
		
        if (empty($info['dob'])) {
            $info['datepicker'] = date('Y-m-d');
        } else {
            $date = new DateTime($info['dob']);
            $info['datepicker'] = $date->format('d F, Y');
        }
        $this->load->form('personaldetailsform', 'piform', $info);
    }

    function save() {
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $this->load->form('personaldetailsform', 'piform');
        $this->process_form($this->piform);
        $this->tpl->set_view('create');
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Student list');
        $this->grid_board->set_filter($this->stdf);
        $grid_all_actions = $this->config->item('grid_all_actions');
        $grid_all_actions['view_details'] = array();
        $this->config->set_item('grid_all_actions', $grid_all_actions);
		$actions = array(
           'marks' => array('title' => 'View Attaindence', 'action' => 'view_attaindence', 'controller' => '', 'tips' => 'View Attaindence'),
		   'view_details' => array('title' => 'Download', 'action' => 'view_details', 'controller' => '', 'tips' => 'Download'),
			'view' => array('title' => 'View', 'action' => 'view', 'controller' => '', 'tips' => 'View'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete'),            
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'student_number' => 'Student Number', 'full_name' => array('title'=>'Name','link'=>'student/view','tips'=>'View student details'),
            'mobile' => 'Mobile', 'gender' => 'Gender', 'status' => array('title' => 'Status', 'status' => 'status'), 'student_type' => 'Student Type','class' => 'Class','section' => 'Form','class_roll' => 'Class Roll');
        $this->grid_board->set_column($grid_columns);
        $params = array('count_method' => 'count_student', 'model' => 'studentvmodel', 'method' => 'get_student_list');
        $this->grid_board->render($params);
		//$this->grid_board->render('studentvmodel');
    }
    function student_information() {
        $this->load->form('student_infoform');
        $this->student_info($this->student_infoform);
    }
    function student_info($form) {
        if($form->validate()){
            $this->tpl->set_view('student_info');
            $class_id = $this->input->post('stdinfo_class_id');
            $section_id = $this->input->post('stdinfo_section_id');
			$this->session->set_userdata(array(
					'class_id'       => $class_id,
					'section_id'      => $section_id
			));
            $std_info = $this->studentmodel->get_student_data($class_id, $section_id);
            $this->tpl->assign('std_info', $std_info);            
        }
    }
    function filter() {
        $this->load->filter('studentfilter', 'stdf');
        $this->stdf->execute();
        redirect('student/index');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $id = $form->save(); 
            $student_id = $form->get_value('student_id');
            $student_id = $student_id ? $student_id: $id ;
            if ($form->is_new()){
              $this->session->set_flashdata('success', "Student has been created successfully");   
            }
            else{
            	$std_id = $form->get_value('std_id');
		$data['student_number'] = $form->get_value('student_number');
		$data['passwd'] = $form->get_value('passwd');
		$this->load->model('studentmodel','stdm');
		$this->stdm->update_std_number($std_id,$data);
				
                $this->session->set_flashdata('success', "Student has been updated successfully");
            }
                
            redirect('student/view/' . $student_id);
        }
    }
    
    function duplicate_std_number_check($std_number)
    {
	$this->load->form('personaldetailsform', 'piform');
	$form = $this->piform;
	$param = $form->get_value('std_number');
	$this->load->model('studentmodel');
	$count = $this->studentmodel->count_student_number($std_number,$param);
	if($count>0)
	{
		$this->form_validation->set_message('duplicate_std_number_check', "This student number already exists.");
	 	return false;
	}
	return true; 
    }
    	
    function view($id = '') {
        if (empty($id))
            show_error('Requested url is not correct!');
        $this->load->model('studentvmodel');
        $info = $this->studentvmodel->find($id);
        if ($info) {
            $this->load_tab_js();
            if ($info['father_guardian_id'])
                $parent_id = $info['father_guardian_id'] . '_' . $info['mother_guardian_id'];
            else
                $parent_id = '';
            $this->tpl->assign('parent_id', $parent_id);
            $this->tpl->assign($info);
        }
    }
	 function view_attaindence($id) { 
		$this->load->model('attendancemodel');
        $this->load->model('studentvmodel');
        $info = $this->studentvmodel->find($id);
		$info['working_days'] =$this->attendancemodel->working_days();
		$info['total_attaindence']= $this->attendancemodel->total_attendance($id);
		$info['total_adsence']=$info['working_days']-$info['total_attaindence'];
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $labels = array(
		'full_name' => 'Student Name','student_number'=>'Student Number','class' => 'Class', 'section' => 'Form',
		'working_days'=>'Total Working days','total_attaindence'=>'Total Present','total_adsence'=>'Total Absent');
      
        $this->tpl->assign('labels', $labels);
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view', true);
    }
    
    
    function view_details($id = '') 
	{        
		$this->tpl->set_layout(false);	
		$this->load->library('pdf');
		$this->load->model('studentmodel');
        $info = $this->studentmodel->get_student_details($id);
		
		$this->load->model('schoolmodel');
        $school = $this->schoolmodel->find(1);
		//$this->tpl->assign($info);
		$html = '
		<style>
		table{
			font-size:12px;
		}
		table tr td{
			height:24px;
		}
		fieldset{
			padding:10px 0;
			border:1px solid #e5e5e5;
			margin-bottom:15px;
			padding-left:10px;					
		}
		legend{
			color: #06661D;
			padding:4px 10px;
			margin-left: 14px;
			font-weight:bold;
			font-size: 13px;
			font-weight:bold;
			border:1px solid #e5e5e5;
			background:#f5f5f5;
		}
		</style>
		<p align="center" style="margin:-10px 0;">
			<img src="'.base_url() .'uploads/logo/'.$school["logo_file"].'" width="80" style="border:none !important;">
		</p>
		<h3 align="center">'.$school["name"].'</h3>
		<p align="center">'.$school["address1"].'</p>
		<div id="box">						
			<fieldset>
				<legend>PERSONAL INFORMATION</legend>
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="20%"><b>Student Number </b></td>
							<td width="35%"><b>:</b> <b>'.$info["student_number"].'</b></td>
							<td width="25%"></td>
							<td width="20%" rowspan="4" align="right">
								<img src="'.base_url() .'uploads/std_photo/'.$info["image_file"].'" width="100" height="110" style="float: right;margin:-10px 10px 0 0;border:1px solid #eee;padding:5px;" />
							</td>	
						</tr>
						<tr>				
							<td width="20%"><b>Student Name </b></td>
							<td><b>:</b> <b>'.$info["full_name"].'</b></td>
							<td></td>				
						</tr>
						<tr>				
							<td><b>Class </b></td>
							<td><b>:</b> '.$info["class"].'</td>
							<td></td>				
						</tr>
						<tr>				
							<td><b>Form </b></td>
							<td><b>:</b> '.$info["section"].'</td>
							<td></td>				
						</tr>
						<tr>				
							<td><b>Class Roll </b></td>
							<td><b>:</b> '.$info["class_roll"].'</td>
							<td></td>				
						</tr>
						<tr>				
							<td><b>Board Roll </b></td>
							<td><b>:</b> '.$info["board_roll"].'</td>
							<td><b>Board Regi. No. </b></td>
							<td width="20%"><b>:</b> '.$info["board_regino"].'</td>
						</tr>
						<tr>				
							<td><b>Session </b></td>
							<td><b>:</b> '.$info["student_session"].'</td>
							<td><b>Gender </b></td>
							<td><b>:</b> '.$info["gender"].'</td>
						</tr>
						<tr>				
							<td><b>Student Type </b></td>
							<td><b>:</b> '.$info["student_type"].'</td>
							<td><b>Date of Birth </b></td>
							<td><b>:</b> '.$info["dob"].'</td>
						</tr>
						<tr>				
							<td><b>Version/Medium </b></td>
							<td><b>:</b> '.$info["version"].'</td>
							<td><b>Birth Registration No. </b></td>
							<td><b>:</b> '.$info["birth_reg_no"].'</td>
						</tr>
						<tr>				
							<td><b>Nationality </b></td>
							<td><b>:</b> '.$info["nationality"].'</td>
							<td><b>Religion </b></td>
							<td><b>:</b> '.$info["religion"].'</td>
						</tr>
						<tr>				
							<td><b>Is Tribe </b></td>
							<td><b>:</b> '.$info["is_tribe"].'</td>								
							<td><b>Blood Group  </b></td>
							<td><b>:</b> '.$info["blood_group"].'</td>			
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			<div style="clear:both;"></div>
			<div style="width:48%;float:left;">
			<fieldset>
				'."<legend>FATHER'S INFORMATION</legend>".'
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="35%"><b>'."Father's Name ".'</b></td>
							<td width="65%"><b>:</b> '.$info["father_name"].'</td>					
						</tr>
						<tr>				
							<td><b>Annual Income </b></td>
							<td><b>:</b> '.$info["father_monthly_income"].'</td>								
						</tr>
						<tr>				
							<td><b>Occupation </b></td>
							<td><b>:</b> '.$info["father_occupation"].'</td>								
						</tr>
						<tr>				
							<td><b>NID </b></td>
							<td><b>:</b> '.$info["father_national_id"].'</td>								
						</tr>
						<tr>				
							<td><b>Mobile </b></td>
							<td><b>:</b> '.$info["father_mobile"].'</td>								
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			</div>
			<div style="width:48%;float:right;">
			<fieldset>
				'."<legend>MOTHER'S INFORMATION</legend>".'
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="35%"><b>'."Mother's Name ".'</b></td>
							<td width="65%"><b>:</b> '.$info["mother_name"].'</td>					
						</tr>
						<tr>				
							<td><b>Annual Income </b></td>
							<td><b>:</b> '.$info["mother_monthly_income"].'</td>								
						</tr>
						<tr>				
							<td><b>Occupation </b></td>
							<td><b>:</b> '.$info["mother_occupation"].'</td>								
						</tr>
						<tr>				
							<td><b>NID </b></td>
							<td><b>:</b> '.$info["mother_national_id"].'</td>								
						</tr>
						<tr>				
							<td><b>Mobile </b></td>
							<td><b>:</b> '.$info["mother_mobile"].'</td>								
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			</div>
			<div style="width:100%;">
			<fieldset>
				<legend>LOCAL GUARDIAN INFORMATION</legend>
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="35%"><b>Guardian Name </b></td>
							<td width="65%"><b>:</b> '.$info["local_guardian_name"].'</td>					
						</tr>
						<tr>				
							<td><b>Relationship Name </b></td>
							<td><b>:</b> '.$info["relationship"].'</td>								
						</tr>
						<tr>				
							<td><b>Occupation </b></td>
							<td><b>:</b> '.$info["local_guardian_occupation"].'</td>								
						</tr>
						<tr>				
							<td><b>NID </b></td>
							<td><b>:</b> '.$info["local_guardian_national_id"].'</td>								
						</tr>
						<tr>				
							<td><b>Mobile </b></td>
							<td><b>:</b> '.$info["local_guardian_mobile"].'</td>								
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			</div>
			<div style="clear:both;"></div>
			<div style="width:48%;float:left;">
			<fieldset>
				<legend>PRESENT ADDRESS</legend>
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="35%"><b>Address </b></td>
							<td width="65%"><b>:</b> '.$info["present_address"].'</td>					
						</tr>
						<tr>				
							<td><b>District </b></td>
							<td><b>:</b> '.$info["present_district"].'</td>								
						</tr>
						<tr>				
							<td><b>Thana </b></td>
							<td><b>:</b> '.$info["present_thana"].'</td>								
						</tr>
						<tr>				
							<td><b>Post Office </b></td>
							<td><b>:</b> '.$info["present_post"].'</td>								
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			</div>
			<div style="width:48%;float:right;">
			<fieldset>
				<legend>PERMANENT ADDRESS</legend>
				<table class="frm-tbl" cellspacing="0" cellpadding="0" border="0">
					<tbody>			
						<tr>				
							<td width="35%"><b>Address </b></td>
							<td width="65%"><b>:</b> '.$info["parmanent_address"].'</td>					
						</tr>
						<tr>				
							<td><b>District </b></td>
							<td><b>:</b> '.$info["parmanent_district"].'</td>								
						</tr>
						<tr>				
							<td><b>Thana </b></td>
							<td><b>:</b> '.$info["parmanent_thana"].'</td>								
						</tr>
						<tr>				
							<td><b>Post Office </b></td>
							<td><b>:</b> '.$info["parmanent_post"].'</td>								
						</tr>			
					</tbody>	
				</table>	
			</fieldset>
			</div>
		</div>';		
		
		$title['page_title'] = 'Student Details';
		$full_html = $html;		
		$pdf = $this->pdf->load();
		$pdf->WriteHTML($full_html); // write the HTML into the PDF
		$pdf->Output($info['student_number'].'.pdf','D');
		exit;			
    }
    
    
    public function del($id) {
        $this->load->model('studentmodel');
        $info = $this->studentmodel->find($id);
        if ($info['admission_id']) {
            $this->session->set_flashdata('info', "Student admission information exists. Please delete admission of this student.");
        } elseif ($info['photo_id']) {
            $this->session->set_flashdata('info', "Student photo exists. Please delete all photos of this student.");
        } else {
            $this->studentmodel->delete($info);
            $this->session->set_flashdata('success', "Student has been deleted successfully.");
            redirect('student/index');
        }
        redirect('student/view/' . $id);
    }

    public function personal($std_id, $id, $actn = 'view') {
        $this->tpl->assign('std_id', $std_id);
        switch ($actn) {
            case 'view':
                $this->load->model('studentmodel');
                $info = $this->studentmodel->get_details_info($std_id);
                $this->tpl->assign($info);
                $this->tpl->set_view('student/personal_info_view', true);
                break;
            case 'edit':
                $this->load->model('personaldetailsmodel', 'pdm');
                $info = $this->pdm->find($id);
                if (empty($info['dob'])) {
                    $info['datepicker'] = date('Y-m-d');
                } else {
                    $date = new DateTime($info['dob']);
                    $info['datepicker'] = $date->format('d F, Y');
                }
                $this->load->form('personaldetailsform', 'piform', $info);
                $this->tpl->set_view('edit');
                break;
            case 'save' :
                $this->tpl->set_view('personal_info');
                break;
        }
    }

    public function guardian($std_id, $type, $id = '') {
        $form_name = $type . 'form';
        $this->tpl->assign('type', $type);
        $actn = 'edit';
        if (empty($id)) {
            $actn = 'new';
        }
        switch ($actn) {
            case 'view':
                break;
            case 'father':
                $this->load->form($form_name, 'gdform');
                $this->tpl->set_view('create_guardian');
                break;
            case 'edit' :
                $this->load->model('guardianmodel', 'gd');
                $info = $this->gd->get_info($id);
                $this->load->form($form_name, 'gdform', $info);
            default:
                $this->load->form($form_name, 'gdform');
                $this->tpl->set_view('create_guardian');
                $this->gdform->set_defaults(array('student_id' => $std_id, 'id' => $id));
        }
    }

    public function address($std_id, $type, $id = '') {
        $form_name = $type . 'addressform';
        $this->tpl->assign('type', $type);
        $actn = empty($id) ? 'new' : 'edit';
        switch ($actn) {
            case 'edit' :
                $this->load->model('addressmodel', 'am');
                $info = $this->am->find_address($id);
                $info['student_id'] = $std_id;
                $this->load->form($form_name, 'adform', $info);
                break;
            default:
                $this->load->form($form_name, 'adform');
                $this->adform->set_defaults(array('student_id' => $std_id, 'id' => $id));
                break;
        }
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
        $config['max_size'] = '120';
        $config['max_width'] = '320';
        $config['max_height'] = '320';
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

    public function status($id, $stat) {
        $this->load->model('statusmodel');
        $stat_info = $this->statusmodel->find_row(array('title' => $stat));
        if (empty($stat_info)) {
            show_404();
        }
        $this->load->model('studentstatusmodel', 'ssmodel');
        $this->load->helper('lookup');
        switch (strtolower($stat)) {
            case 'active':
                $lookup_id = lookup_id('STD_STAT_CHANGE_REASON', 'ADMISSION_CONFIRMED');
                break;
            case 'inactive':
                $lookup_id = lookup_id('STD_STAT_CHANGE_REASON', 'TRANSFER');
                break;
            case 'pending':
                $lookup_id = lookup_id('STD_STAT_CHANGE_REASON', 'ADMISSION_IN_PROGRESS ');
                break;
            case 'complete':
                $lookup_id = lookup_id('STD_STAT_CHANGE_REASON', 'STUDY_COMPLETED');
                break;
            default:
                $lookup_id = lookup_id('STD_STAT_CHANGE_REASON', 'OTHER');
                break;
        }
        $this->ssmodel->save(array('id'=>'','status_id' => $stat_info['id'], 'lookup_id' => $lookup_id, 'student_id' => $id));
        
		$this->load->model('studenttransfermodel','stmodel');        
		$this->stmodel->delete_tc_student($id);
		
		$this->session->set_flashdata('success', "Student status been changed sucessfully.");
        redirect('student');
    }

    public function delphoto($std_id, $id) {
        $this->output->set_content_type('application/json');
        $this->load->model('photomodel');
        $info = $this->photomodel->find($id);
        $this->photomodel->delete($id);
        if ($info['file_name'] && file_exists($this->config->item('upload_dir') . $info['file_name'])) {
            unlink($this->config->item('upload_dir') . $info['file_name']);
        }
        $this->session->set_flashdata('success', "Photo has been deleted successfully");
        $response = array('success' => 1, 'message' => 'Photo deleted successfully.');
        $response['redirect'] = site_url('student/photo/' . $std_id);
        //$response['photo'] = base_url().str_replace('./','',$this->config->item('upload_dir')).$data['file_name'];
        $this->output->set_output(json_encode($response));
    }

    public function asave($type) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $form_name = $type . 'addressform';
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form($form_name, 'adform');
        if ($this->adform->validate()) {
            $this->adform->save();
            $values = $this->adform->get_values();
            $this->session->set_flashdata('success', ucfirst($type) . " address has been saved successfully");
            $response = array('success' => 1, 'message' => 'Updated successfully.');
            $response['redirect'] = site_url('student/address/' . $values['student_id'] . '/' . $type . '/' . $values['id']);
        } else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
        $this->output->set_output(json_encode($response));
    }

    public function pisave() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form('personaldetailsform', 'piform');
        if ($this->piform->validate()) {
            $this->piform->save();
            $values = $this->piform->get_values();
            $response = array('success' => 1, 'message' => 'Updated successfully.');
            $this->session->set_flashdata('success', " Personal information has been updated successfully");
            $response['redirect'] = site_url('student/personal/' . $values['student_id'] . '/' . $values['id'] . '/view');
        } else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }


        $this->output->set_output(json_encode($response));
    }

    public function gsave($type) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

		$form_name = $type . 'form';
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form($form_name, 'gdf');
        if ($this->gdf->validate()) {
            $values['id'] = $this->gdf->save();
            $values = $this->gdf->get_values();
            $response = array('success' => 1, 'message' => 'Updated successfully.');
            $type = 'guardian';
            if ($values['relationship_id'] == 1)
                $type = 'mother';
            if ($values['relationship_id'] == 2)
                $type = 'father';
            $response['redirect'] = site_url('student/guardian/' . $values['student_id'] . '/' . $type . '/' . $values['id']);
            $this->session->set_flashdata('success', ucfirst($type) . "'s information has been added successfully");
        }
        else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }


        $this->output->set_output(json_encode($response));
    }

    protected function load_tab_js() {
        $this->tpl->set_jquery_ui(array('tabs', 'datepicker', 'position', 'dialog'));
        $this->tpl->set_js(array('jquery.validate', 'select-chain', 'jquery.form', 'jquery.loadmask'));
        $this->tpl->set_css(array('jquery.loadmask'));
    }

    public function admission($student_id) {
        $this->init_admission_grid($student_id);
    }

    protected function init_admission_grid($std_id) {
        $this->load->library('grid_board');
        $this->grid_board->query_condition(array('student_id' => $std_id));
        $this->grid_board->set_params(array('student_id' => $std_id));
        $column_option = $this->config->item('grid_column_option');
        $column_option['sort'] = false;
        $this->config->set_item('grid_column_option', $column_option);
        $grid_all_actions = $this->config->item('grid_all_actions');
        $grid_all_actions['idcard'] = array();
        $this->config->set_item('grid_all_actions', $grid_all_actions);
        $this->grid_board->set_title('Student Admission');
        $this->grid_board->add_link('Student new admission', site_url('student/newadmission/' . $std_id), array('class' => 'add', 'id' => 'new_admision'));
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'viewadmission', 'controller' => '', 'tips' => 'View details of this admission'),
            'edit' => array('title' => 'Edit', 'action' => 'editadmission', 'controller' => '', 'tips' => 'Edit this admission'),
            'book' => array('title' => 'Assign Subject', 'action' => 'assignbook', 'controller' => '', 'tips' => 'Assign subject'),
            'del' => array('title' => 'Delete', 'action' => 'deladmission', 'controller' => '', 'tips' => 'Delete this admission'),
            'idcard' => array('title' => 'ID Card', 'action' => 'generate', 'controller' => 'idcard', 'tips' => 'Generate student id card'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'student_type' => 'Student Type','class' => 'Class', 'section' => 'Form', 'class_roll' => 'Roll', 'session' => 'Session', 'status' => 'Status', 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('admissionmodel');
    }

    public function newadmission($std_id) {
        $this->load->form('admissionform', 'adform');
        $this->adform->set_default('student_id', $std_id);
        $this->tpl->assign('form_title', 'STUDENT ADMISSION INFORMATION');
    }

    public function editadmission($id) {
        $this->load->model('admissionmodel', 'admodel');
        $info = $this->admodel->get_info($id);
        $this->tpl->assign('form_title', 'EDIT ADMISSION');
        if (empty($info)) {
            show_404();
        }
        $this->load->form('admissionform', 'adform', $info);
        $this->tpl->set_view('newadmission');
    }

    public function saveadmission() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form('admissionform', 'adform');
        if ($this->adform->validate()) {
            $std_id = $this->adform->get_value('student_id');
            $sid = $this->adform->get_value('session');
            $id =  $this->adform->get_value('id');
            $this->load->model('admissionmodel','admodel');
            $ret = $this->admodel->is_admission_exists($id,$std_id,$sid);
            if($ret){
                $response = array('success' => 0, 'message' => 'Student admission completed for session '.$sid);
            }else{
                 $this->adform->save();
                    $response = array('success' => 1, 'message' => '');
                 if ($this->adform->is_new())
                    $this->session->set_flashdata('success', 'Student has been admitted successfully');
                 else
                    $this->session->set_flashdata('success', 'Student admission has been updated successfully');
            }
        }else {
            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
        $this->output->set_output(json_encode($response));
    }

    public function deladmission($id) {
        $this->output->set_content_type('application/json');
        $this->load->model('admissionmodel', 'admodel');
        $this->admodel->delete($id);
        $response = array('success' => 1);
        $this->session->set_flashdata('success', 'Admission record has been deleted successfully');
        $this->output->set_output(json_encode($response));
    }

    public function viewadmission($id) {
        $this->load->model('admissionmodel', 'admodel');
        $info = $this->admodel->get_info($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->helper('date');
        $labels = array('student_type'=>'Student Type','class'=>'Class','section'=>'Form','class_roll'=>'Class Roll','board_roll'=>'Board Roll','board_regino'=>'Board Registration','index_no'=>'Index Number','birth_regino'=>'Birth Registration No.','session'=>'Session','fee'=>'Admission Fee',
                    'status'=>'Status','created_by'=>'Created By', 'created_at'=>'Created At');
         $this->tpl->assign('labels',$labels);
         $this->tpl->assign('row',$info);
         $this->tpl->set_view('elements/record_view',true); 
    }

    public function assignbook($admission_id) {
        $this->load->model('admissioncoursemodel', 'adcmodel');
        $rs = $this->adcmodel->get_course($admission_id);
        $rs = array_group_by_key($rs, 'course_type_id');
        $this->tpl->assign('assigned_courses', $rs);
        $this->load->model('admissionmodel', 'admodel');
        $rs = $this->admodel->get_course($admission_id);
        $rs = array_group_by_key($rs, 'course_type_id');
        $this->load->model('admissionmodel', 'admodel');
        $course_types = $this->admodel->get_course_type($admission_id);
        $this->tpl->assign('course_types', $course_types);
        $this->tpl->assign('courses', $rs);
        $this->tpl->assign('admission_id', $admission_id);
    }

    public function savecourse() {
        $this->output->set_content_type('application/json');
        $response = array('success' => 0);
        if (!empty($_POST['adcrs'])) {
            $response = array('success' => 1);
            $this->load->model('admissioncoursemodel', 'adcmodel');
            $this->adcmodel->save($_POST);
            $this->session->set_flashdata('success', 'Course has been saved successfully');
        } else {
            $response['message'] = "Error! You did not select any course.";
        }
        $this->output->set_output(json_encode($response));
    }

    public function sstatus($id) {
        $this->init_status_grid($id);
    }

    protected function init_status_grid($std_id) {
        $this->load->library('grid_board');
        $this->grid_board->query_condition(array('student_id' => $std_id));
        $this->grid_board->set_params(array('student_id' => $std_id));
        $column_option = $this->config->item('grid_column_option');
        $column_option['sort'] = false;
        $this->config->set_item('grid_column_option', $column_option);
        $this->grid_board->set_title('Student status list');
        $this->grid_board->add_link('Change Student Status', site_url('student/statusadd/' . $std_id), array('class' => 'add', 'id' => 'status_add'));
        $actions = array(
            'view' => array('title' => 'View', 'action' => 'statusview', 'controller' => '', 'tips' => 'View details of this admission'),
            'edit' => array('title' => 'Edit', 'action' => 'statusedit', 'controller' => '', 'tips' => 'Edit this admission'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Status', 'reason' => 'Reason', 'comments' => 'Comments', 'created_at' => array('title' => 'Create Date', 'datetime' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('studentstatusmodel');
    }

    public function statusadd($std_id) {
        $this->load->form('studentstatusform', 'ssform', array('student_id' => $std_id));
    }

    public function statusedit($id) {
        $this->load->model('studentstatusmodel', 'ssmodel');
        $info = $this->ssmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->form('studentstatusform', 'ssform', $info);
        $this->tpl->set_view('statusadd');
    }

    public function sstatussave() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $this->output->set_content_type('application/json');
        $response = array('success' => 1, 'message' => '');
        $this->load->form('studentstatusform', 'ssform');
        if ($this->ssform->validate()) {
            $this->ssform->save();
            if ($this->ssform->is_new()) {
                $this->session->set_flashdata('success', 'Student status has been saved successfully');
            } else {
                $this->session->set_flashdata('success', 'Student status has been updated successfully');
            }
        } else {

            $response = array('success' => 0, 'message' => 'One or more required fields are missing.');
        }
        $this->output->set_output(json_encode($response));
    }

    public function statusview($id) {
        $this->load->model('studentstatusmodel', 'ssmodel');
        $info = $this->ssmodel->get_info($id);
        $this->load->helper('date');
        $this->tpl->assign('labels', array('title' => 'Status Name', 'reason' => 'Reason', 'comments' => 'Comments',
            'created_at' => 'Created At', 'created_by' => 'Created By'));
        $this->tpl->assign('row', $info);
        $this->tpl->set_view('elements/record_view', true);
    }
    
    public function bulk(){
       if($_POST){
        $bulk_path = $this->config->item('upload_dir').'bulk_data';
        if(!file_exists($bulk_path))
            mkdir($bulk_path);
        $config['upload_path'] = $bulk_path ;
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 100*1024;
        $config['file_name'] = 'std_' .date('YmdHis');
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file_excel')) {
            $file = $this->upload->data();
            $this->session->set_flashdata('success', "Bulk data has been uploaded successfully");
            $this->load->library('excel');
            $this->load->model('studentmodel');
            $data = $this->excel->get_array($bulk_path.'/'.$file['file_name']);
            unlink($bulk_path.'/'.$file['file_name']);
            $this->studentmodel->save_bulk_data($data);
            redirect('student/index');
        }else{
            $this->session->set_flashdata('error',$this->upload->display_errors());
            redirect('student/bulk');
        }  
           
       }
        
    }
	
	
/* 	public function student_promotion(){
		$this->load->form('studentpromotionform','stdpform');
		$this->tpl->set_js(array('jquery.validate','select-chain','student_promotion_form'));
		
		if ($this->stdpform->validate()) {
			$promotrd_class_id = $this->input->post('promotion_promoted_class_id');
			$student_list = $this->input->post('student_id');
			if($student_list){
			
				foreach ($student_list as $lm => $val) {				
					$student_id = $val;
					$data['class_id'] = $promotrd_class_id;
					$data['section_id'] = 0;
					$this->load->model('studentmodel');		
					$this->studentmodel->update_student_class($student_id,$data);				
				}
				$this->session->set_flashdata('success', "Student has been promoted successfully.");
			}else{
				$this->session->set_flashdata('error', "You don't select any student.");
			}
			redirect('student/student_promotion');
		}
	}
	
	
	public function student_promotion_sectionwise(){
		$this->load->form('studentpromotionsectionform','stdpsform');
		$this->tpl->set_js(array('jquery.validate','select-chain','student_promotion_section_form'));
		
		if ($this->stdpsform->validate()) {
			$promotrd_class_id = $this->input->post('promotion_promoted_class_id');
			$promotrd_section_id = $this->input->post('promotion_promoted_section_id');
			$student_list = $this->input->post('student_id');
			if($student_list){
			
				foreach ($student_list as $lm => $val) {				
					$student_id = $val;
					$data['class_id'] = $promotrd_class_id;
					$data['section_id'] = $promotrd_section_id;
					$this->load->model('studentmodel');		
					$this->studentmodel->update_student_class($student_id,$data);				
				}
				$this->session->set_flashdata('success', "Student has been promoted successfully.");
			}else{
				$this->session->set_flashdata('error', "You don't select any student.");
			}
			redirect('student/student_promotion_sectionwise');
		}
	}
	 */
	 
	 public function student_promotion(){
		$this->load->form('studentpromotionform','stdpform');
		$this->tpl->set_js(array('jquery.validate','select-chain','student_promotion_form'));
		
		if ($this->stdpform->validate()) {
			$promotrd_class_id = $this->input->post('promotion_promoted_class_id');
			$student_list = $this->input->post('student_id');
			if($student_list){
			
				foreach ($student_list as $lm => $val) {				
					$student_id = $val;
					$data['class_id'] = $promotrd_class_id;
					$data['section_id'] = 0;
					$this->load->model('studentmodel');
					$info = $this->studentmodel->get_roll($student_id);
					if($info['position'] != ""){
					   $data['class_roll'] = $info['position'];
					}	
					$this->studentmodel->update_student_class($student_id,$data);				
				}
				$this->session->set_flashdata('success', "Student has been promoted successfully.");
			}else{
				$this->session->set_flashdata('error', "You don't select any student.");
			}
			redirect('student/student_promotion');
		}
	}
	
	
	public function student_promotion_sectionwise(){
		$this->load->form('studentpromotionsectionform','stdpsform');
		$this->tpl->set_js(array('jquery.validate','select-chain','student_promotion_section_form'));
		
		if ($this->stdpsform->validate()) {
			$promotrd_class_id = $this->input->post('promotion_promoted_class_id');
			$promotrd_section_id = $this->input->post('promotion_promoted_section_id');
			$student_list = $this->input->post('student_id');
			if($student_list){
			
				foreach ($student_list as $lm => $val) {				
					$student_id = $val;
					$data['class_id'] = $promotrd_class_id;
					$data['section_id'] = $promotrd_section_id;
					$this->load->model('studentmodel');	
					$info =$this->studentmodel->get_roll($student_id);
					if($info['position'] != ""){
						$data['class_roll'] = $info['position']; 
					}	
					$this->studentmodel->update_student_class($student_id,$data);				
				}
				$this->session->set_flashdata('success', "Student has been promoted successfully.");
			}else{
				$this->session->set_flashdata('error', "You don't select any student.");
			}
			redirect('student/student_promotion_sectionwise');
		}
	}
	
	
	function get_student_list() {
        $data['class_id'] = $class_id = $_POST['class_id'];
		$data['section_id']=$_POST['section_id'];
        if ($class_id != '' OR $class_id != Null) {
			$this->load->model('studentmodel');		
			$student_list = $this->studentmodel->get_all_students($data);         // get full message
			
            if (!empty($student_list)) {
                $this->html = '';
                $this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
						<table width="50%">
							<thead>
							<tr>
								<th style="width:20px;"><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
								<th style="min-width:200px;">Student Name</th>
								<th>Student Number</th>
								<th style="text-align:center;">Roll</th>
								<th>Form</th>
							</tr>	
							<thead>';
                foreach ($student_list as $val) {

                    $this->html .='<tr>
								<td align="center"><input type="checkbox" id="student_id" name="student_id[]" value="' . $val->id . '"/></td>
								<td>' . $val->first_name.' '. $val->last_name .'</td>
								<td>' . $val->student_number . '</td>
								<td width="100" style="text-align:center;">' . $val->class_roll . '</td>
								<td>' . $val->section . '</td>
							</tr>';
                }
                $this->html .='</table>
					</div>';
            } else {
                $this->html = 'No student available.';
            }
        }

        $html = $this->html;
        return $this->output->set_output($html);
    }
	
	
	
	function get_student_facility_list() {
        $data['class_id'] = $class_id = $_POST['class_id'];
		$data['section_id']=$_POST['section_id'];
		$facility_id=$_POST['facility_id'];
        if ($class_id != '' OR $class_id != Null) {
			$this->load->model('studentmodel');		
			$student_list = $this->studentmodel->get_all_students($data);         // get full message
			
            if (!empty($student_list)) {
                $this->html = '';
                $this->html .='<div style="width:600px;height:400px;overflow:scroll;overflow-x:hidden;">
						<table width="50%">
							<thead>
							<tr>
								<th style="width:20px;"><input type="checkbox" name="checkall" onclick="checkedAll();"/></th>
								<th style="min-width:200px;">Student Name</th>
								<th>Student Number</th>
								<th style="text-align:center;">Roll</th>
								<th>Form</th>
							</tr>	
							<thead>';
                foreach ($student_list as $val) {
					if($val->extra_facility_id==$facility_id)
					{
						$checked = 'checked';
					}else{
						$checked = '';
					}

                    $this->html .='<tr>
								<td align="center"><input type="checkbox" id="student_id" name="student_id[]" value="' . $val->id . '" '.$checked.'/></td>
								<td>' . $val->first_name.' '. $val->last_name .'</td>
								<td>' . $val->student_number . '</td>
								<td width="100" style="text-align:center;">' . $val->class_roll . '</td>
								<td>' . $val->section . '</td>
							</tr>';
                }
                $this->html .='</table>
					</div>';
            } else {
                $this->html = 'No student available.';
            }
        }

        $html = $this->html;
        return $this->output->set_output($html);
    }
	
	
	public function promoted_class_check($class_id)
	{
		$query = $this->db->query("SELECT id FROM sms_admission where class_id='$class_id'");
		if($query->num_rows()>0)
		{
			$this->form_validation->set_message('promoted_class_check', "Student already exists on this class.");
		 	return false;
		}
		return true;
		
	}
	
	
	public function extra_facility()
	{
		$this->tpl->set_jquery_ui(array('datepicker'));
		$this->tpl->set_js(array('jquery.multiselect'));
		$this->tpl->set_css(array('jquery.multiselect'));
		$this->tpl->set_js(array('jquery.validate','select-chain','extra_facility_form'));
        $this->load->form('extrafacilityform','eform'); 		
	}
	
	
	
	
	public function update_extra_facility()
	{
		$this->load->model('studentmodel');	
		$student_id = $this->input->post('student_id'); 
        $extra_facility_id = $this->input->post('extra_facility_facility_id'); 
		
		$data['class_id'] = $this->input->post('extra_facility_class_id');
		$data['section_id'] = $this->input->post('extra_facility_section_id');
		
		$student_list = $this->studentmodel->get_all_students($data);         // get full message
		/* $update_data = array();
		foreach ($student_list as $val) {
			$update_data[] = array(
				'id'=>$val->id,
                'extra_facility_id' => '0'
            );
		}
					
		$this->studentmodel->update_extra_facility($update_data); */
		
		$updateArray = array();
        for($x = 0; $x < sizeof($student_id); $x++){
           
            $updateArray[] = array(
				'id'=>$student_id[$x],
                'extra_facility_id' => $extra_facility_id
            );
		}      
		/* echo"<pre>";
		print_r($updateArray);exit(); */
		$this->studentmodel->re_update_extra_facility($updateArray);
		$this->session->set_flashdata('success',"Students extra facility has been updated successfully.");
		redirect('student');	
	}
	
	function approve() {
        $this->init_approve_grid();
    }
	
	protected function init_approve_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Approve Pending Student list');
        $grid_all_actions = $this->config->item('grid_all_actions');
        $grid_all_actions['view_details'] = array();
        $this->config->set_item('grid_all_actions', $grid_all_actions);
		$actions = array(
            'view' => array('title' => 'View', 'action' => 'view', 'controller' => '', 'tips' => 'View'),
        );
        $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false), 'student_number' => 'Student Number', 'full_name' => array('title'=>'Name','link'=>'student/view','tips'=>'View student details'),
            'mobile' => 'Mobile', 'gender' => 'Gender', 'status' => array('title' => 'Status', 'status' => 'status'), 'student_type' => 'Student Type','house' => 'House','class' => 'Class','section' => 'Form','class_roll' => 'Class Roll','is_approve' => array('title'=>'Is Approve','link'=>'student/approve_status','tips'=>'Change Approve'));
        $this->grid_board->set_column($grid_columns);
        $params = array('count_method' => 'count_approve_student', 'model' => 'studentvmodel', 'method' => 'get_student_approve_list');
        $this->grid_board->render($params);
		//$this->grid_board->render('studentvmodel');
    }
	
	function approve_status($id) {
       $this->load->model('studentmodel');
	   $get_approve = $this->studentmodel->get_approve($id);
		if($get_approve=='Yes')
		{
			$data['is_approve']='No';
			$data['approve_date']=$this->current_date();
		}else{
			$data['is_approve']='Yes';
			$data['approve_date']=$this->current_date();
		}
		
	   $approve = $this->studentmodel->update_student_approve($id,$data);
	   if($approve)
	   {
			redirect('student/approve');
	   }
	   
    }
	
	
	/*
	// only for student number update
	public function update_student_number()
	{
		$this->load->model('studentmodel');	
		$student_list = $this->studentmodel->allstudent(); 		
		
		foreach($student_list as $val){
			
			$id = $val->id;
			$student_number = $val->student_number;
			$year = substr($student_number, 0, 4);
			$sid = str_replace($year,'',$student_number);				
			$data['student_number'] = 'BV'.$year.sprintf('%06d', $sid);
			$this->studentmodel->update_student_number($id,$data);
		}
		
		exit();
	} */

}

?>