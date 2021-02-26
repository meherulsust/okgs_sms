<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 11, 2012
 * Model class for addressmodel.
 */
class Addressmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function save($values)
   {
   	  $this->load->model('studentaddressmodel','sam');
 	  $address_id= parent::save($values);
 	  $values['address_id'] = $address_id;
 	  $this->sam->save($values);
   	  return $address_id;
   	 
   }
   public function find_address($id='')
   {
   	  $sql = $this->db->select('a.id,address_line,post_office_id,t.id thana, t.district_id district')
   	  		->from($this->get_table_name().' a ')
   	  		->join('post_office p', 'p.id = a.post_office_id', 'left')
   	  		->join('thana t', 't.id = p.thana_id', 'left');
   	  if($id)
   	  {
   	  	$sql->where('a.id',$id);
   	  } 		
   	  $query = $sql->get();
   	  return $query->row_array();		
   }
   public function get_table_name()
   {
   	  return 'address';
   }
  
   public function get_columns()
   {
   	  return array('id','address_line','district','thana','post_office_id');
   }
    

 } 
?>
