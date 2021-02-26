<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 03, 2012
 * Model class for occupation.
 */
class Thanamodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
 	 
   public function get_list($district_id='')
   {
   	   $sql = $this->db->from($this->get_table_name())
           		->select('id,name as title')
           		 ->order_by('title asc');
       if($district_id)  		
       $sql->where('district_id',$district_id);
          
      $query = $this->db->get();  
      return $query->result_array(); 
   }	
   public function get_table_name()
   {
   	  return 'thana';
   }
    public function get_columns()
   {
   	  return array('id','name','district_id','dname');
   }
    
  public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('t.id,t.name,d.name as dname')
               ->from('thana t')
               ->join('district d','d.id = t.district_id','left');               
	   return $query;
   }
 } 
?>
