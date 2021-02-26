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
		$this->load->model('studentvmodel');
		$student_number = $this->auth->get_user()->student_number;
		$row = $this->studentvmodel->find_row(array('student_number'=>$student_number));
		$data['class_id'] = $row['class_id'];	
		$syllabus_list = $this->studentvmodel->get_syllabus($data);
		$this->tpl->assign('syllabus_list',$syllabus_list);
		
	}  
		
	
	
	public function syllabus_download($file_name)
	{
		$url = base_url(); 
		$urlarray =explode("/",$url);
		$final_url = $urlarray[0].'/'.$urlarray[1].'/'.$urlarray[2].'/'.$urlarray[3];
		
		$this->load->helper('download');
		$data = file_get_contents($final_url."/smsadmin/uploads/upload_syllabus_image/".$file_name); 
		$name = $file_name;
		force_download($name,$data);
	}
	
	public function syllabus_view($file_name)
	{
		$this->tpl->set_layout(false);
		$this->tpl->assign('file_name',$file_name);	
		
	}
	
 }