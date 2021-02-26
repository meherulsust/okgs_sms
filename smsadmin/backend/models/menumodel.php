<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Menumodel extends BACKEND_Model {
   public function __construct() {
        parent::__construct();
    }

    public function get_columns() {
        return array('id', 'title', 'alias', 'tips', 'url','type','status', 'serial' ,'parent_id','is_visible','created_at', 'created_by');
    }
    
    public function get_table_name() {
        return 'menu';
    }
    
    public function get_active_backend_menu_tree(){
        $query = $this->db->select('id,title,parent_id')
                ->from('menu')
                ->where(array('status'=>'ACTIVE','type'=>'BACKEND'))
                ->get();
        if($query->num_rows() > 0){
            $this->load->library('tree/pmt_tree',null,'mtree');
            $this->mtree->set_query($query);
            return $this->mtree->get_tree();
        }
        return array();
        
    }
    

}
?>
