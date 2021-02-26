<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     November 25, 2012
 * Model class for course book.
 */
class Coursebookmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function save($values)
   {
 	  $rows = $this->get_where(array('course_id'=>$values['course_id'],'is_delete'=>0));
 	  // edit previous course id
 	  if($rows)
 	  {
 	  	 $rows = array_assoc_by_key($rows,'book_id');
 	  	 foreach($values['books'] as $book_id)
 	  	 {
 	  	 	//newly added
 	  	 	$data = array();
 	  	 	if(!isset($rows[$book_id]))
 	  	 	{
 	  	 		 $data['course_id'] = $values['course_id'];
 	  	 		 $data['book_id'] = $book_id;
 	  	 		 $data['is_delete'] = '0';
 	  	   	  	 $data['created_at'] = $this->now();
 	  	   	     $data['created_by'] = 1;
 	  	   	     $data['course_id'] = $values['course_id'];
 	  	   	     $this->db->insert($this->get_table_name(),$data);
 	  	 	}
 	  	 	unset($rows[$book_id]);
 	  	 }
 	  	 
 	  	 //not using. need to delete
 	  	 if($rows)
 	  	 {
 	  	 	foreach($rows as $row)
 	  	 	{
 	  	 		$data = array();
 	  	 		$data['is_delete'] = 1; 
 	  	 		$this->db->where('id', $row['id']);
 	  	 		$this->db->update($this->get_table_name(),$data);
 	  	 	}
 	  	 	
 	  	 }
 	  }
 	  //insert new record
 	  else
 	  {
 	  	   $data = array();
 	  	   foreach($values['books'] as $k=>$v)
 	  	   {
 	  	   	  $data[$k]['course_id'] = $values['course_id'];
 	  	   	  $data[$k]['book_id'] = $v;
 	  	   	  $data[$k]['is_delete'] = 0;
 	  	   	  $data[$k]['created_at'] = $this->now();
 	  	   	  $data[$k]['created_by'] = 1;
 	  	   }
 	  	   $this->db->insert_batch($this->get_table_name(),$data);
 	  }
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
   	  return 'course_book';
   }
   public function get_columns()
   {
   	  return array('id','course_id','book_id','is_delete','created_at','created_by');
   }
    

 } 
?>
