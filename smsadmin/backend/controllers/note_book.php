<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */
class Note_book extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->tpl->set_js('select-chain');
        $this->init_grid();
    }
	//added by Md.Meherul Islam for add downlaod icon in to grid borad
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Note Book List');
		$grid_all_actions = $this->config->item('grid_all_actions');
        $grid_all_actions['view_details'] = array();
        $this->config->set_item('grid_all_actions', $grid_all_actions);
		$actions = array(
                            'view'=>array('title'=>'View','action'=>'view','controller'=>'','tips'=>'View Note details'),
                            'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit Note'),
                            'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete Note'),
							'view_details' => array('title' => 'Download', 'action' => 'note_download', 'controller' => '', 'tips' => 'Download'),
                            );
		$this->grid_board->set_action($actions);					
        $grid_columns = array('id' => array('visible' => false),
		'note_title'=>'Title','description' => 'Description', 'subject' => 'Subject','class' => 'Class','section' => 'Form',
		'status' => array('title' => 'Status', 'status' => 'status'));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('notebookmodel');
    }
	//end
    function create() {
        $this->load->form('notebookform', 'nbform');
        $this->tpl->set_js(array('jquery.validate', 'select-chain'));
    }
	
	function save() {
        $this->tpl->set_js(array('jquery.validate', 'select-chain'));
        $this->load->form('notebookform', 'nbform');
        $this->process_form($this->nbform);
        $this->tpl->set_view('create');
    }
	
    public function edit($id) {
        $this->load->model('notebookmodel');
        $info = $this->notebookmodel->find($id);
        if(empty($info)){
            show_404();
        }        
        $this->tpl->set_jquery_ui();
        $this->tpl->set_js(array('jquery.validate', 'select-chain'));
		$info['main_file_name']= $info['file_name'];
        $this->load->form('notebookform','nbform', $info);
		$this->process_form($this->nbform);        
    }
	
	
    protected function process_form($form) {
        $this->load->form('notebookform','nbform');
        $this->load->model('notebookmodel');
        if ($form->validate()) {
            
			if ($form->is_new()){
			
				if(trim($_FILES["notebook_file_name"]["name"])!='')
				{
					$ext = end(explode(".", $_FILES['notebook_file_name']['name']));
					$file_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;

					$upconfig['upload_path'] = $this->config->item('upload_dir').'/note_book/';
					$file_info = pathinfo($file_name);
					$upconfig['file_name']=basename($file_name,'.'.$file_info['extension']);
					$upconfig['allowed_types'] = 'gif|jpg|png|pdf';
					$upconfig['max_size'] = '5000000';
					//$upconfig['max_width'] = '300';
					//$upconfig['max_height'] = '320';
					$upconfig['overwrite'] = FALSE;
					$this->load->library('upload',$upconfig);
					if($this->upload->do_upload('notebook_file_name')) {
						$id = $form->save();
						$this->notebookmodel->update(array('file_name'=>$file_name,'id'=>$id));
						$this->session->set_flashdata('success', "Note book has been uploaded successfully.");
						redirect('note_book');

					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('note_book/create');
					}

				}else{
					$this->session->set_flashdata('error', 'Please select file.');
					redirect('note_book/create');
				}	
			}else{
				if(trim($_FILES["notebook_file_name"]["name"])!='')
				{
					$ext = end(explode(".", $_FILES['notebook_file_name']['name']));
					$file_name= rand(1000000,9999999).'_'.rand(1000000,9999999).'.'.$ext;

					$upconfig['upload_path'] = $this->config->item('upload_dir').'/note_book/';
					$file_info = pathinfo($file_name);
					$upconfig['file_name']=basename($file_name,'.'.$file_info['extension']);
					$upconfig['allowed_types'] = 'gif|jpg|png|pdf';
					$upconfig['max_size'] = '5000000';
					//$upconfig['max_width'] = '300';
					//$upconfig['max_height'] = '320';
					$upconfig['overwrite'] = FALSE;
					$this->load->library('upload',$upconfig);
					if($this->upload->do_upload('notebook_file_name')) {
						$id = $form->save();						
						$this->notebookmodel->update(array('file_name'=>$file_name,'id'=>$this->nbform->get_value('id')));
						$this->session->set_flashdata('success', "Note book has been updated successfully.");
						redirect('note_book');

					}else{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('note_book/create');
					}

				}else{
					$id = $form->save();						
					$this->notebookmodel->update(array('file_name'=>$this->nbform->get_value('main_file_name'),'id'=>$this->nbform->get_value('id')));
					$this->session->set_flashdata('success', "Note book has been updated successfully.");
					redirect('note_book');
				}
			}
        }
    }

    function view($id = '') {
        if (empty($id))
            show_error('Requested url is not correct!');
        $columns = array('note_title'=>'Title','description' => 'Description', 'subject' => 'Subject','class' => 'Class','section' => 'Form','status' =>'Status');
		$info = $this->load->model('notebookmodel');
		$this->tpl->assign('view_title','Note Book Details');
		$info = $this->notebookmodel->get_details_info($id);
		$this->tpl->assign('row',$info);
		$this->tpl->assign('labels',$columns);
		$this->tpl->set_view('elements/record_view',true);	
    }
	
	
	function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            redirect('note_book');
        $this->load->model('notebookmodel');
        $this->notebookmodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "Note book status has been changed successfully");
        redirect('note_book');
    }
	
    public function del($id) {
        $this->load->model('notebookmodel');        
		$this->notebookmodel->delete($id);
		$this->session->set_flashdata('success', "Note book has been deleted successfully.");
		redirect('note_book');       
    }
	//added by Md.Meherul Islam for download note book
	public function note_download($id)
	{	
		
		$this->load->model('notebookmodel');
        $info = $this->notebookmodel->find($id);
		$data1 = base_url()."uploads/note_book/".$info['file_name'];
		$this->load->helper('download');
		$data = file_get_contents($data1); 
		$name = $info['file_name'];
		force_download($name,$data);
		
	}
	//end
}

?>
