<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 31, 2013
 * 
 * model class for course title
 */
 class Coursetitlemodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'course_title';
   }
   public function get_columns()
   {
   	  return array('id','title','order','created_at','status','created_by');
   } 
   
    public function grid_query() {
        $this->db->select('*')
                ->from('course_title')
				->order_by('order','ASC');
    }
   
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('c.id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }

 }
 

?>