<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 * 
 * model clas for sylabus
 */
 class Sylabusmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus';
   }
   public function get_columns()
   {
   	  return array('id','title','total_marks','class_id', 'section_id','percent_to_pass', 'result_scale_id','created_at','created_by','status','description');
   } 
   public function grid_query()
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
   
   public function get_section_sylabus($class_id,$section_id)
   {
   	    $query = $this->db->select('id,title')
   	 		 ->from('sylabus')
   	 		 ->where("( class_id = '$class_id' AND status = 'ACTIVE' ) AND ( section_id = '0' or section_id = '$section_id' ) ");
   	   return $query->get()->result_array();
   }

   public function get_class_sylabus_list($params)
   {
   	  $class_id = $params['class_id'];
   	  $section_id = $params['section_id'];
   	  $query = $this->db->select('id , title')
   	  		   ->from($this->get_table_name())
   	  		   ->where("( class_id = '$class_id' AND status = 'ACTIVE' ) AND ( section_id = '0' or section_id = '$section_id' ) ");
   	  return $query->get();		   
   }
   public function get_result_scale_matrix($sylabus_id){
        $query = $this->db->select('s.result_scale_id,sm.id scale_matrix_id,rs.code_name,sm.title, min_range, max_range, weight')
   	 		 ->from('sylabus s')
                         ->join('result_scale rs','s.result_scale_id = rs.id','left')
                         ->join('scale_matrix sm','s.result_scale_id = sm.result_scale_id','left')
                         ->where('s.id',$sylabus_id)
                         ->order_by('weight desc')
                         ->get();
        return $query->result_array();
   }
   public function default_book_list($params){
         $class_id = $this->find_one_by_pk('class_id',$params['sylabus_id']);
         $query =  $this->db->select('id,title')
                 ->from('book')
                 ->where('class_id',$class_id)
                 ->get();
       return $query;
   }
 }

?>