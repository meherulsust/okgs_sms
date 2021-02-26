<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 22, 2012
 * 
 * model class for sylabus book.
 */
 class Sylabusbookmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus_book';
   }
   public function get_columns()
   {
   	  $fields = array('id','sylabus_id','title','book_id', 'subject_code','full_marks','subjective_marks', 'objective_marks', 
   	  			'practical_marks', 'created_at','created_by');
   	  return $fields;
   } 
   public function grid_query1()
   {
   	 $this->db->select('s.id,s.title,s.status,c.title class,ifnull(se.title,"All Form") section,total_marks,s.created_at',false)
   	 			->from('sylabus s')
   	 			->join('class c','c.id=s.class_id','left') 
   	 			->join('section se','se.id=section_id','left');
   }
   public function get_info($id)
   {
   	  $this->grid_query();
   	  $this->db->select('s.description')->where('s.id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }	   
 }

?>