<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Upload_syllabus extends BACKEND_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		 $this->init_grid();

	}
   
    protected function init_grid()
	{
	   $this->load->library('grid_board');
	   $this->grid_board->set_title('Uploaded Syllabus list');
	   $actions = array(
						'view'=>array('title'=>'View','action'=>'view','controller'=>'','tips'=>'View Syllabus details'),
						'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit Syllabus'),
						'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete Syllabus'),
						);
	   $this->grid_board->set_action($actions);
       $this->grid_board->add_link('Upload New Syllabus',site_url('upload_syllabus/create'),array('class'=>'add'));
	   $grid_columns = array('id'=>array('visible'=>false),'title'=>'Title','class'=>'Class','syllabus_image'=>'Uploaded Syllabus','date'=>'Created','status'=>array('title'=>'Status','status'=>'status'));
	   $this->grid_board->set_column($grid_columns);
	   $this->grid_board->render('upload_syllabus_model');
	}
    function create() {
        $this->load->form('uplaod_syllabusform', 'usform');
    }
    public function save(){
		$this->load->form('uplaod_syllabusform','usform');
		$this->process_form($this->usform);
		$this->tpl->set_view('create');
	}
    
    public function edit($id) {
        $this->load->model('upload_syllabus_model');
        $info = $this->upload_syllabus_model->find($id);
        if(empty($info)){
            show_404();
        }
		$info['main_image']= $info['syllabus_image'];
        $this->load->form('uplaod_syllabusform','usform', $info);
		$this->process_form($this->usform);        
    }
	
        
    public function view($id){
		$this->load->model('upload_syllabus_model','usmodel');
		$info = $this->usmodel->find($id);
		if(empty($info))
		{
				show_404();
		}
	   $labels = array('title'=>'Title','status'=>'Status','class'=>'Class','syllabus_image'=>'Uploaded Syllabus');
	   $this->tpl->assign('labels',$labels);
	   $this->tpl->assign('row',$info); 
	   $this->tpl->set_view('elements/record_view.php',true);
	}
    public function del($id)
	{
		$this->load->model('upload_syllabus_model','usmodel');
		$this->usmodel->delete($id);
		$this->session->set_flashdata('success',"Syllabus has been deleted successfully");
		redirect('upload_syllabus');
	}
	
	public function status($id,$stat){
		$this->load->model('upload_syllabus_model');
		$this->upload_syllabus_model->update_status($stat,$id);
		$this->session->set_flashdata('success',"Syllabus status has been changed successfully");
		redirect('upload_syllabus');
	} 
	
	protected function process_form($form) {
        $this->load->form('uplaod_syllabusform','usform');
        $this->load->model('upload_syllabus_model');
        if ($form->validate()) {
            
			if ($form->is_new()){
				
				if(trim($_FILES["u_syllabus_syllabus_image"]["name"])!='')
				{
					$ext = end(explode(".", $_FILES['u_syllabus_syllabus_image']['name']));
					$file_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;

					$upconfig['upload_path'] = $this->config->item('upload_dir').'/upload_syllabus_image/';
					$file_info = pathinfo($file_name);
					$upconfig['file_name']=basename($file_name,'.'.$file_info['extension']);
					$upconfig['allowed_types'] = 'gif|jpg|png|pdf';
					$upconfig['max_size'] = '5000000';
					//$upconfig['max_width'] = '300';
					//$upconfig['max_height'] = '320';
					$upconfig['overwrite'] = FALSE;
					$this->load->library('upload',$upconfig);
					if($this->upload->do_upload('u_syllabus_syllabus_image')) {
						$id = $form->save();
						$this->upload_syllabus_model->update(array('syllabus_image'=>$file_name,'id'=>$id));
						$this->session->set_flashdata('success', "Syllabus image has been uploaded successfully.");
						redirect('upload_syllabus');

					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('upload_syllabus/create');
					}

				}else{
					$this->session->set_flashdata('error', 'Please select file.');
					redirect('upload_syllabus/create');
				}	
			}else{
				if(trim($_FILES["u_syllabus_syllabus_image"]["name"])!='')
				{
					$ext = end(explode(".", $_FILES['u_syllabus_syllabus_image']['name']));
					$file_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;

					$upconfig['upload_path'] = $this->config->item('upload_dir').'/upload_syllabus_image/';
					$file_info = pathinfo($file_name);
					$upconfig['file_name']=basename($file_name,'.'.$file_info['extension']);
					$upconfig['allowed_types'] = 'gif|jpg|png|pdf';
					$upconfig['max_size'] = '5000000';
					//$upconfig['max_width'] = '300';
					//$upconfig['max_height'] = '320';
					$upconfig['overwrite'] = FALSE;
					$this->load->library('upload',$upconfig);
					if($this->upload->do_upload('u_syllabus_syllabus_image')) {
						$id = $form->save();						
						$this->upload_syllabus_model->update(array('syllabus_image'=>$file_name,'id'=>$this->usform->get_value('id')));
						$this->session->set_flashdata('success', "Syllabus image has been updated successfully.");
						redirect('upload_syllabus');

					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('upload_syllabus/create');
					}

				}else{
					$id = $form->save();						
					$this->upload_syllabus_model->update(array('syllabus_image'=>$this->usform->get_value('main_image'),'id'=>$this->usform->get_value('id')));
					$this->session->set_flashdata('success', "Syllabus image has been updated successfully.");
					redirect('upload_syllabus');
				}
			}
        }
    }

	
	
        
	
	
}