<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 21, 2013
 */
class Ugroup extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->tpl->set_page_title('User Group Manager');
    }

    function index() {
        $this->tpl->set_page_title('User Group List');
        $this->init_grid();
    }

    protected function init_grid() {
        $this->load->library('grid_board');
        $this->grid_board->add_link('Create Group', site_url('ugroup/create'), array('class' => 'add', 'id' => 'new_grup'));
         $actions = array(
            'view' => array('title' => 'View', 'action' => 'view', 'controller' => '', 'tips' => 'View details of this menu items'),
            'edit' => array('title' => 'Edit', 'action' => 'edit', 'controller' => '', 'tips' => 'Edit child menu'),
            'menu' => array('title' => 'Assign Menu', 'action' => 'menu', 'controller' => '', 'tips' => 'Assign menu'),
            'del' => array('title' => 'Delete', 'action' => 'del', 'controller' => '', 'tips' => 'Delete child menu'),
        );
        $this->grid_board->set_action($actions);
        $this->grid_board->set_title('User group list');
        $grid_columns = array('id' => array('visible' => false), 'title' => 'Group Name', 'description' => 'Description', 
            'status' => array('title' => 'Status', 'status' => 'status'), 'created_at' => array('title' => 'Create Date', 'date' => true));
        $this->grid_board->set_column($grid_columns);
        $this->grid_board->render('usergroupmodel');
    }

    function create() {
         $this->tpl->set_page_title('User Group Creation');
        $this->load->form('usergroupform');
    }

    public function save() {
        $this->load->form('usergroupform');
        $this->tpl->set_view('create');
        $this->process_form($this->usergroupform);
    }

    public function edit($id) {
         $this->tpl->set_page_title('User Group Modification');
        $this->load->model('usergroupmodel');
        $info = $this->usergroupmodel->find($id);
        if (empty($info)) {
            show_404();
        }
        $this->load->form('usergroupform', null, $info);
        $this->tpl->set_view('create');
    }

    protected function process_form($form) {
        if ($form->validate()) {
            $form->save();
            if ($form->is_new())
                $this->session->set_flashdata('success', "User group has been created successfully");
            else
                $this->session->set_flashdata('success', "User group has been updated successfully");
            redirect('ugroup/index');
        }
    }

    function status($id = '', $stat = '') {
        if (empty($id) || empty($stat))
            show_404 ();
        $this->load->model('usergroupmodel');
        $this->usergroupmodel->update_status($stat, $id);
        $this->session->set_flashdata('success', "User group status has been changed successfully");
        redirect('ugroup/index');
    }

    function view($id) {
       $this->tpl->set_page_title('User Group Details');
       $this->load->helper('date');
       $columns = array('title' => 'Group name', 'description' => 'Description','created_at'=>'Created At','created_by'=>'Created By');
       $this->load->model('usergroupmodel');
       $this->tpl->assign('view_title','User group details');
       $this->tpl->assign('view_button',array('url'=>'ugroup/create','alt'=>'Create user group','title'=>'Create User Group'));
       $info = $this->usergroupmodel->find($id);
       $this->tpl->assign('row',$info);
       $this->tpl->assign('labels',$columns);
       $this->tpl->set_view('elements/record_view',true);
    }
    
    public function menu($id){
       $this->load->model('usergroupmodel');
       $info = $this->usergroupmodel->find($id);
       if(empty($info)){
           show_404();
       }
       $this->tpl->assign($info);
       $this->tpl->set_page_title('User Group Details');
       $this->load->model('menumodel');
        $this->load->model('usergroupmenumodel','ugmmodel');
       // $this->ugmmodel->get_group_menu($id);
    }
    public function msave(){
       $data['user_group_id'] = $this->input->post('group_id');
       $data['menus'] = $this->input->post('menus');
       $this->load->model('usergroupmenumodel','ugmmodel');
       $this->ugmmodel->save($data);
       $this->session->set_flashdata('success', "Menu has been assigned to this user group successfully");
       redirect('ugroup/menu/'.$data['user_group_id']);
    }
    
     public function del($id){
        if(!$id){
            show_404();
        }
         $this->load->model('usergroupmodel','ugmmodel');
         $group = $this->ugmmodel->find($id);    
         if($group){
             $this->load->model('usermodel');
             $num = $this->usermodel->count(array('user_group_id'=>$id));
             if($num > 0){
                $this->session->set_flashdata('notice', "You cann't delete '".$group['title']."' group. It is  being used."); 
                redirect('ugroup');
             }
             $this->ugmmodel->delete($id);
             $this->session->set_flashdata('success', "User Group has been deleted successfully."); 
             redirect('ugroup');
         }else{
             show_404();
         }
         
        
        
    }

}