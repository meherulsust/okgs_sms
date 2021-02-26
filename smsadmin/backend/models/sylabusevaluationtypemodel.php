<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 04, 2012
 * 
 * model clas for sylabus evaluation type
 */
 class Sylabusevaluationtypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'sylabus_evaluation_type';
   }
   public function get_columns()
   {
   	  return array('id','sylabus_id','evaluation_type_id','serial','created_at','created_by','status');
   } 
   public function grid_query($params)
   {
   			$query = $this->get_info_query();
    		$query->where('se.sylabus_id',$params['sylabus_id']);
   }
   
   public function get_info($id)
   {
   	  $query = $this->get_info_query();
   	  $query->where('se.id',$id);
   	  $query = $this->db->get();
   	  return $query->row_array();	
   }

   protected function get_info_query()
   {
   		$query = $this->db->select('se.id,sylabus_id,s.title sylabus,se.status,se.serial, e.title evaluation_type, se.created_at')
   	 			->from('sylabus_evaluation_type se')
   	 			->join('evaluation_type e','e.id=se.evaluation_type_id','left')
   	 			->join('sylabus s','s.id=se.sylabus_id','left')
                                ->order_by('se.serial asc');
   	 	return $query;		
   }
   
   public function get_eval_by_sylabus($sylabus_id)
   {
   		$query = $this->db->select('se.id eval_id,title,eval_type')
   	 			->from('sylabus_evaluation_type se')
   	 			->join('evaluation_type e','e.id=se.evaluation_type_id','left')
   				->where('sylabus_id',$sylabus_id)
   				->where('se.status','ACTIVE')
   				->order_by('se.serial asc')->get();
   		return $query->result_array();
   }
 }

?>
