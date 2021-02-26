<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2012
 * Model class for caste.
 */
class Balance_titlemodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'balance_sheet_title';
   }
    
   public function get_columns()
   {
   	  return array('id','title','balance_type_id','created_at');
   }
   
    public function grid_query() {
        $this->db->select('bst.id,bst.title,bst.created_at,bt.title balance_type,status',false)
                ->from('balance_sheet_title bst')
				->join('balance_type bt', 'bt.id = bst.balance_type_id', 'left')
				->order_by('bst.title','ASC');
    }
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('balance_sheet_title bst');
        return $query->count_all_results();
    }
	
	
   public function check_duplicate_title($str)
    {
		$this->db->select('id');	
		$this->db->from('balance_sheet_title');	
		$this->db->where('title',$str);
		$rs=$this->db->get();	    
		return $rs->num_rows();
    }
   
 } 
?>