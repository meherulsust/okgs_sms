<?php
/*
 * Created on Sept 24, 2015
 *
 * Created by Arena Development Team(@ Md.Meherul Islam)
 */
 class Syllabus_list extends FRONTEND_Controller{
    function __construct()
    {
        parent::__construct();
    }

  	function index()
	{		
		$this->load->model('syllabus_list_model');
		$get_class = $this->syllabus_list_model->get_class();
		$this->tpl->assign('get_class',$get_class);
		
	}  
		
	function get_syllabus()
	{
		$this->tpl->set_layout('ajax_layout');
		$this->load->model('syllabus_list_model');
		$class_id = $this->input->post('class_id');
		$syllabus_list = $this->syllabus_list_model->get_syllabus($class_id);
		$this->tpl->assign('syllabus_list',$syllabus_list);
		$get_class = $this->syllabus_list_model->get_class();
		$this->tpl->assign('get_class',$get_class);	
		
	}
	
	public function syllabus_download($file_name)
	{
		$url = base_url(); 
		$urlarray =explode("/",$url);
		$final_url = $urlarray[0].'/'.$urlarray[1].'/'.$urlarray[2].'/'.$urlarray[3];
		$this->load->helper('download');
		$data = file_get_contents("./../smsadmin/uploads/upload_syllabus_image/".$file_name); 
		$name = $file_name;
		force_download($name,$data);
	}
	
	public function syllabus_view($file_name)
	{
		$this->tpl->set_layout(false);
		$this->tpl->assign('file_name',$file_name);	
		
	}
	
 }