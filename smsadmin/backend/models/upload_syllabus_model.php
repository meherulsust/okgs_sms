<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 31, 2013
 * 
 * model class for Upload_syllabus
 **/
 class Upload_syllabus_model extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'upload_syllabus';
   }
   public function get_columns()
   {
   	  return array('id','title','class','syllabus_image','date','status');
   } 
      public function grid_query(){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('us.*,c.title as class')
               ->from('upload_syllabus us')
               ->join('class c','c.id = us.class','left');
       return $query;
   }
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }

 }
 

?>