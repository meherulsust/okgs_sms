<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Imrul Hasan
 * @ Created    21.09.2014
 */
class Address extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->init_grid();
    }
	
	protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Thana List');
		$actions = array(
					'edit'=>array('title'=>'Edit','action'=>'edit','controller'=>'','tips'=>'Edit thana'),
					'del'=>array('title'=>'Delete','action'=>'del','controller'=>'','tips'=>'Delete thana'),
					);
	   $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false),'name'=>'Thana Name','dname'=>'District Name');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('thanamodel');
    }
	
    function create_thana() {
        $this->load->form('thanaform', 'tform');
        $this->tpl->set_jquery_ui();
    }
	
	function save() {
        $this->load->form('thanaform', 'tform');
        $this->process_form($this->tform);
        $this->tpl->set_view('create_thana');
    }
	
    public function edit($id) {
        $this->load->model('thanamodel');
        $info = $this->thanamodel->find($id);
        if(empty($info)){
            show_404();
        }
        $this->load->form('thanaform','tform', $info);
		$this->process_form($this->tform);        
    }
	
	
    protected function process_form($form) {
        if ($form->validate()) {
           
			if($form->validate()){
				$form->save();
				if($form->is_new())
					$this->session->set_flashdata('success',"Thana has been created successfully");
				else
					$this->session->set_flashdata('success',"Thana has been edited successfully");
				redirect('address/index');
			}
		}
	}
	
    public function del($id) {
        $this->load->model('thanamodel');        
		$this->thanamodel->delete($id);
		$this->session->set_flashdata('success', "Thana has been deleted successfully.");
		redirect('address');       
    } 
	
	function list_postoffice() {
        $this->init_postoffice_grid();
    }
	
	protected function init_postoffice_grid() {
        $this->load->library('grid_board');
        $this->grid_board->set_title('Post Office List');
		$actions = array(
					'edit'=>array('title'=>'Edit','action'=>'edit_postoffice','controller'=>'','tips'=>'Edit Post office'),
					'del'=>array('title'=>'Delete','action'=>'del_postoffice','controller'=>'','tips'=>'Delete Post office'),
					);
	   $this->grid_board->set_action($actions);
        $grid_columns = array('id' => array('visible' => false),'name'=>'Post Office','tname'=>'Thana','dname'=>'District');
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('postofcmodel');
    }
	
    function create_postoffice() {
        $this->load->form('postofficeform', 'tform');
        $this->tpl->set_jquery_ui();
    }
	
	function save_postoffice() {
        $this->load->form('postofficeform', 'tform');
        $this->process_postoffice_form($this->tform);
        $this->tpl->set_view('create_postoffice');
    }
	
    public function edit_postoffice($id) {
        $this->load->model('postofcmodel');
        $info = $this->postofcmodel->find($id);
		$this->load->model('thanamodel');  
		$row = $this->thanamodel->find($info['thana_id']);
        if(empty($info)){
            show_404();
        }
		$info['district_id'] = $row['district_id'];
        $this->load->form('postofficeform','tform', $info);
		$this->process_postoffice_form($this->tform);        
    }
	
	
    protected function process_postoffice_form($form) {
        if ($form->validate()) {
           
			if($form->validate()){
				$form->save();
				if($form->is_new())
					$this->session->set_flashdata('success',"Post Office has been created successfully");
				else
					$this->session->set_flashdata('success',"Post Office has been edited successfully");
				redirect('address/list_postoffice');
			}
		}
	}
	
    public function del_postoffice($id) {
        $this->load->model('postofcmodel');        
		$this->postofcmodel->delete($id);
		$this->session->set_flashdata('success', "Post office has been deleted successfully.");
		redirect('address/list_postoffice');       
    }


}

?>
