<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
 class Messagemodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
  
    public function get_columns()
   {
   	  return array('id','title','description','status','created_at');
   }
  
   public function get_table_name()
   {
   	 return 'message_notification';
   }

   
	public function get_info($id){
		$query = $this->db->select('*')
               ->from('message_notification')
               ->where('id', $id)
               ->get();
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return false;
	}
	
	public function get_full_message($message_id)
	{
		$query=$this->db->select('description')
					->from('message_notification')
					->where('id',$message_id)	
					->get();	
		if($query->num_rows() > 0){
			return $query->row_array();
		}
		return false;
	}
	
	
 }

?>