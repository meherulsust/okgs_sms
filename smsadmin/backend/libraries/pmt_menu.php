<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Feb 23, 2012
 * generate tree structure menu
 */
class Pmt_menu {

    private $_current_node;
    private $_current_top_node;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->config('pmt_menu');
        $this->CI->load->library('tree/Pmt_tree', null, 'tree');
        $this->_current_node = $this->_find_current_node();
    }

    public function get_top_menu() {
        $db = $this->CI->db->select('*')
                ->from($this->CI->config->item('menu_table'))
                ->where('type', 'BACKEND')
                ->where('status', 'ACTIVE')
                ->where('parent_id', 0)
                ->order_by('serial', 'ASC');
        $query = $db->get();
        $this->CI->tree->set_query($query);
        return $this->CI->tree->get_tree();
    }

    public function get_full_menu() {
        $user_group_id = $this->CI->session->userdata('user_group_id');
        $query = $this->CI->db->select('m.*')
                ->from($this->CI->config->item('menu_table').' m')
                ->where('type', 'BACKEND')
                ->where('status', 'ACTIVE')
                ->order_by('serial', 'ASC');
        if($user_group_id > 1){
          $query->join('user_group_menu gm','gm.menu_id = m.id','left')
                 ->where('gm.user_group_id',$user_group_id);
                
        }
        $this->CI->tree->set_query($query->get());
        return $this->CI->tree->get_tree();
    }

    public function get_current_node() {
        return $this->_current_node;
    }
    
    private function _find_current_node(){
         $url = $this->CI->router->class;
         $query = $this->CI->db->select('*')
               ->from($this->CI->config->item('menu_table'))
               ->where('type', 'BACKEND')
               ->where('status', 'ACTIVE')
               ->where("( url like '$url%')")
               ->order_by('id', 'ASC')
               ->get();      
         return $query->row();
    }
    
    public function get_current_parent_id(){
        return  $this->_current_node->parent_id ?  $this->_current_node->parent_id :  $this->_current_node->id;
    }
    
    public function set_current_top_node($node){
        $this->_current_top_node = $node;
    }
     public function get_current_top_node(){
       return $this->_current_top_node ;
    }

}

?>