<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 23, 2013
 */
class Usergroupmenumodel extends BACKEND_Model {
   public function __construct() {
        parent::__construct();
    }

    public function get_columns() {
        return array('id', 'user_group_id', 'menu_id','created_at', 'created_by');
    }
    
    public function get_table_name() {
        return 'user_group_menu';
    }
    
    public function save($data){
       $records=array();
       $old_data = $this->get_group_menu($data['user_group_id']);
       $old_data_asc = array_assoc_by_key($old_data, 'menu_id');
        foreach($data['menus'] as $i=>$menu_id){
           if(isset($old_data_asc[$menu_id])){
               unset($old_data_asc[$menu_id]);
               continue;
           }
           $records[$i]['user_group_id'] = $data['user_group_id'];
           $records[$i]['menu_id'] = $menu_id;
           $records[$i]['created_at'] = $this->now();
           $records[$i]['created_by'] = $this->get_created_by();
       }
       if($records)
            $this->insert_batch($records);
       if($old_data_asc){
           foreach($old_data_asc as $row){
               $ids[] = $row['id'];
           }
           $this->delete_batch($ids);
       }
     
      return true;
    }
    
    public function get_group_menu($group_id){
       $query = $this->db->select('id,menu_id')
               ->from($this->get_table_name())
               ->where(array('user_group_id'=>$group_id))
               ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
    }
    

}
?>
