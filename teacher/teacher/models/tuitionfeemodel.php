<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     January 08, 2012
 */
 class Tuitionfeemodel extends Frontend_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'tuition_fee';
    }
   public function get_columns()
   {
   	  return array('id','tuition_fee_head_id','amount','created_at','created_by','updated_at','updated_by');
   }
   
   public function get_active_fee(){
       $q= $this->db->select('head_code,title,amount,head_type')
               ->from('tuition_fee f')
               ->join('tuition_fee_head h','h.tuition_fee_id=f.id','left')
               ->where('status',1)
               ->order_by('display_order asc');
       $query = $q->get();
       return $query->result_array();
   }
  
   
 }

?>