<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     September 01, 2012
 */
 class Bookmodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'book';
    }	
   public function get_columns()
   {
   	  return array('id','course_title_id','class_id','writer_name','title','created_at','book_type_lookup_id','link','status','description');
   }
   public function grid_query($params){
       $this->info_query();
   }
   
   protected function info_query(){
       $query = $this->db->select('b.id,b.title,b.description,writer_name,link,b.status,c.title class,l.title book_type,b.created_at,b.created_by')
               ->from('book b')
               ->join('class c','c.id = class_id','left')
               ->join('lookup l','l.id = book_type_lookup_id','left');
       return $query;
   }
   public function get_info($id){
       $q = $this->info_query();
       $q->where('b.id',$id);
       $query = $q->get();
       return $query->result_array();
   }
 }

?>