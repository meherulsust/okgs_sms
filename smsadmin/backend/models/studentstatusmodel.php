<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2012
 * Model class for caste.
 */
class Studentstatusmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }    
   public function get_table_name()
   {
   	  return 'student_status';
   }
   public function get_columns()
   {
   	 return array('id','student_id','status_id','lookup_id','comments', 'created_at','created_by');
   }
   public function grid_query($params){
       $query = $this->info_query();
       $query->where('student_id',$params['student_id']);
   }
   
   public function total_grid_record($params){
       return $this->count(array('student_id'=>$params['student_id']));
   }
   public function get_info($id){
       $query = $this->info_query();
       $query->where('ss.id',$id);
       $query = $query->get();
       if($query->num_rows()>0){
          return $query->row_array();
       }
       return false;
   }
   
   protected function info_query(){
      $query=  $this->db->select('ss.id,s.title,l.title reason,comments,ss.created_at,ss.created_by')
               ->from('student_status ss')
               ->join('status s','s.id=ss.status_id','left')
               ->join('lookup l','ss.lookup_id=l.id','left');
      return $query;
   }
   

 } 
?>