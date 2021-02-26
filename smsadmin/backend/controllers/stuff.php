<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author     Md.Meherul Islam
 * @ Created    03.02.2016
 */
class Stuff extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->init_grid();
    }
	
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Staff List');
        $grid_columns = array('id' => array('visible' => false),'full_name' => array('title'=>'Full Name','link'=>'stuff/view','tips'=>'View Staff details'),
            'designation'=>'Designation','email'=>'Email','mobile_no' => 'Mobile', 'gender' => 'Gender','edulabel'=>'Qualification'/*,'status' => array('title' => 'Status', 'status' => 'status')*/);
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('stuffmodel');
    }
	
    function create() {
        $this->load->form('stuffform', 'sform');
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
    }
	
	function save() {
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'ui/jquery.ui.datepicker', 'select-chain'));
        $this->load->form('stuffform', 'sform');
        $this->process_form($this->sform);
        $this->tpl->set_view('create');
    }
	
    public function edit($id) {
        $this->load->model('stuffmodel');
        $info = $this->stuffmodel->find($id);
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
        $this->load->form('stuffform','sform', $info);
		$this->process_form($this->sform);        
    }
	
	
    protected function process_form($form) {
        $this->load->form('stuffform','sform');
        $this->load->model('stuffmodel');
        if ($form->validate()) {
           
			if(trim($_FILES["stuff_photo"]["name"])!='') 
			{
				$ext = end(explode(".", $_FILES['stuff_photo']['name']));
				$image_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;
				
				$upconfig['upload_path'] = $this->config->item('upload_dir').'/stuff_photo/';
				$file_info = pathinfo($image_name);
				$upconfig['file_name']=basename($image_name,'.'.$file_info['extension']);
				$upconfig['allowed_types'] = 'gif|jpg|png';
				$upconfig['max_size'] = '5000000';
				$upconfig['max_width'] = '400';
				$upconfig['max_height'] = '400';
				$upconfig['overwrite'] = FALSE;
				$this->load->library('upload',$upconfig);
				if($this->upload->do_upload('stuff_photo')) {
					$id = $form->save();
					
					if ($form->is_new()){
                        $this->stuffmodel->update(array('photo'=>$image_name,'id'=>$id));
                        $this->session->set_flashdata('success', "Staff has been created successfully.");
					}
					else{
                        $this->stuffmodel->update(array('photo'=>$image_name,'id'=>$this->sform->get_value('id')));
                        $this->session->set_flashdata('success', "Staff has been updated successfully.");
					}    
					redirect('stuff');	
					
				}else{
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('stuff');
				} 		
					
			}else{
				$id = $form->save(); 
				if ($form->is_new()){
					$this->session->set_flashdata('success', "staff has been created successfully.");   
				}
				else{
					$this->stuffmodel->update(array('photo'=>$this->sform->get_value('main_photo'),'id'=>$this->sform->get_value('id')));
					$this->session->set_flashdata('success', "staff has been updated successfully.");
				}                
				redirect('stuff');
			}	
        }
    }

    function view($id = '') {
        if (empty($id))
            show_error('Requested url is not correct!');
        $this->load->helper('date');
		$columns = array('full_name' => 'Name','dob' => 'Date of Birth','gender'=>'Gender','blood_group' => 'Blood Group', 'religion' => 'Religion','address'=>'Address','email' => 'Email', 'mobile_no' => 'Mobile Number',
		'photo' => array('title' => 'Photo', 'type' => 'image', 'path' => base_url() . 'uploads/stuff_photo/', 'width' => '100', 'height' => '100'),);
		$info = $this->load->model('stuffmodel');
		$this->tpl->assign('view_title','staff Details');
		$this->tpl->assign('view_button',array('url'=>'stuff/edit/'.$id,'alt'=>'Edit staff','title'=>'Edit staff'));
		$info = $this->stuffmodel->get_details_info($id);
		$this->tpl->assign('row',$info);
		$this->tpl->assign('labels',$columns);
		$this->tpl->set_view('elements/record_view',true);	
    }
	
	
	function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('stuff');
        $this->load->model('stuffmodel');
        $this->stuffmodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Staff status has been changed successfully");
        redirect('stuff');
    }
	
    public function del($id) {
        $this->load->model('stuffmodel');        
		$this->stuffmodel->delete($id);
		$this->session->set_flashdata('success', "Staff has been deleted successfully.");
		redirect('stuff');       
    }


}

?>
