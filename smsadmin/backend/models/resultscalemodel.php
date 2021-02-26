<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 016, 2012
 * model class for resultscale
 */
 class Resultscalemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'result_scale';
    }	
   public function get_columns()
   {
   	  return array('id','title','status','code_name', 'description','created_at','created_by');
   }   
   
   public function get_matrix_by_code($code){
       $query = $this->db->select('code_name,min_range,max_range,m.title,weight')
               ->from('result_scale r')
               ->join('scale_matrix m','r.id = m.result_scale_id','left')
               ->where('r.status','ACTIVE')
               ->where('code_name',$code)
               ->order_by('weight desc')
               ->get();
       return    $query->result_array();
   }
    public function get_matrix_by_scale($id){
       $query = $this->db->select('id, min_range,max_range,title,weight')
               ->from('scale_matrix')
               ->where('result_scale_id',$id)
               ->order_by('weight desc')
               ->get();
       return    $query->result_array();
   }
   
 }

?>