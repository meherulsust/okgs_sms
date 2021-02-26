<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 10, 2012
 * Model class for School class.
 */
class Classmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   
   public function save($values)
   {
 	  $photo_id = parent::save($values);
 	  return $photo_id;
   }
   public function get_student_photo($std_id)
   {
   	   $query = $this->db->select('id,file_name,student_id,date_format(created_at,"%D %b,%Y") create_date,
   	   			date_format(updated_at,"%D %b,%Y") update_date',false)
   	   			->from($this->get_table_name())
   	  		    ->where('student_id',$std_id)->order_by('id asc')
   	  		    ->get();
   	   return $query->result_array();		    	
   }
   public function get_table_name()
   {
   	  return 'class';
   }
   public function get_columns()
   {
   	  return array('id','code','title','serial','result_scale_id','start_date','end_date','created_at','created_by', 'is_result_publish');
   }
    
	public function get_class_list()
	{
		$query = $this->db->select('*')
   	   			->from('class')
				->where('status','ACTIVE')
   	  		    ->order_by('serial','ASC')
   	  		    ->get();
		return $query->result_array();		
	}
    public function get_class_info($id) {
        $this->db->select('*');
        $this->db->from('class');
        $this->db->where('id', $id);
        $rs = $this->db->get();
        return $rs->row_array();
    }
    public function edit_class($class_id, $data) {
        return $this->db->update('class', $data, array('id' => $class_id));
    }
    public function addclass($data) {
        $this->db->insert('class', $data);
        return $this->db->insert_id();
    }
 } 
?>
