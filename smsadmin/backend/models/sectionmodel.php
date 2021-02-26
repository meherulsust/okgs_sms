<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     August 11, 2012
 * Model section model class.
 */
class Sectionmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   
   public function get_section_by_class($class_id)
   {
   	   $query = $this->db->select('id,title,room_number,date_format(created_at,"%D %b,%Y") create_date,class_id,
   	   			date_format(updated_at,"%D %b,%Y") update_date,`status`,description',false)
   	   			->from($this->get_table_name())
   	  		    ->where('class_id',$class_id)->order_by('id asc')
   	  		    ->get();
   	   return $query->result_array();		    	
   }
   
 /**
  * class and section id by given 
  * class and section title.
  * 
  * @param array $titles
  * @return array
  */  
  public function get_id_by_title(array $titles)
   {
   	   $query = $this->db->select('s.id section_id,class_id')
                        ->from($this->get_table_name().' s')
                        ->join('class c','c.id = s.class_id','left')
                        ->where('c.title',$titles['class'])
                        ->where('s.title',$titles['section'])
                        ->get();
      if($query->num_rows()>0){
         return end($query->result_array());
      }
      return false;
   }
   
   public function get_table_name()
   {
   	  return 'section';
   }
   public function get_columns()
   {
   	  return array('id','description','version_id','class_id','status','room_number','title','created_at','created_by');
   }
   
   public function room_number_exists($room_no,$id,$class_id){
      $rec_id = $this->find_one_by('id',array('room_number'=>$room_no,'status'=>'ACTIVE'));
      if($rec_id){
          //in case of edit
           if($id == $rec_id){
               return true;
           }
           return false;
      } 
      return true;
   }
    
	public function grid_query($id)
	{
		$this->db->select('sec.id,sec.title title,sec.status,sec.room_number,sec.created_at,ver.title version')
   	 			->from('section sec')
				->join('version_list ver','ver.id=sec.version_id','left')
				->where('sec.class_id',$id);
	}

 } 
?>
