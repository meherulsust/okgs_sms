<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 31, 2013
 * 
 * model class for comment type
 */
 class Comment_model extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'comment';
   }
   public function get_columns()
   {
   	  return array('id','comment','reply','reply_date','replyer_id');
   } 
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }
   
 }
 

?>