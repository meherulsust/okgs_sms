<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2012
 * Model class for religion.
 */

 class Religionmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'religion';
   } 
   public function get_columns()
   {
   	  return array('id','title');
   }
   
   public function get_caste_id($data){
       $this->db->select('c.id')
               ->from('religion r')
               ->join('religion_caste c','r.id = c.religion_id','right')
               ->where('c.title',$data['caste'])
               ->where('r.title',$data['religion']);
       return $this->get_one();
   }
 } 
 
?>