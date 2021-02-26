<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Added By      Md.Meherul Islam <meherulsust@gmail.com>
 * @ Created On    November 01, 2015
 */
 class Bulk_sms_model extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'bulk_sms';
   }
   public function get_columns()
   {
   	  return array('id','message','mobile','date','status');
   } 
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }
    
    public function save_bulk_data($mobile){
        $this->db->insert('bulk_sms', $mobile);
    }

 }
 

?>