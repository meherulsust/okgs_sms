<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
 class Lookupvmodel extends BACKEND_Model
 {
 	   public function __construct()
 	   {
 	     	parent::__construct();
 	   }
   public function get_columns()
   {
   	  return array('id','lookup_type_id','value_type','value', 'unique_code','title','value_type', 'created_at','created_by');
   }
  
   public function get_table_name()
   {
   	 return 'lookup_v';
   }
   public function grid_query($params){
        $sql = $this->db->select('*')
                        ->from('lookup_v')
                        ->where('lookup_type_id',$params['lookup_type_id']);
   }
   public function total_grid_record($params){
       return $this->count(array('lookup_type_id'=>$params['lookup_type_id']));
   }
 }

?>