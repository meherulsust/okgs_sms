<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 03, 2012
 * Model class for occupation.
 */
class Postofcmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_list($thana_id='')
   {
   	   $sql = $this->db->from($this->get_table_name())
           		->select('id,name as title')
           		 ->order_by('title asc');
       if($thana_id)  		
       $sql->where('thana_id',$thana_id);
          
      $query = $this->db->get();  
      return $query->result_array(); 
   }	 
   public function get_table_name()
   {
   	  return 'post_office';
   }
   public function get_address_by_post($code){
       $query = $this->db->select('p.id post_office_id, thana_id, district_id')
               ->from('post_office p')
               ->join('thana t','t.id = p.thana_id')
               ->where('post_code',$code)
               ->get();
               
       if($query->num_rows()>0){
           $row = $query->result_array();
           return end($row);
       }
       return false;
   }
   public function get_columns()
   {
   	  return array('id','name','thana_id','dname');
   }
    
  public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('po.id,po.name,t.name as tname,d.name as dname ')
               ->from('post_office po')
               ->join('thana t','t.id = po.thana_id','left')              
               ->join('district d','d.id = t.district_id','left');               
	   return $query;
   }
   

 } 
?>
