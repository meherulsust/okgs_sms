<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
 class Housemodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
  
    public function get_columns()
   {
   	  return array('id','title','description','status','create_date');
   }
  
   public function get_table_name()
   {
   	 return 'house';
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