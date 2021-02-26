<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2012
 * Model class for personal details.
 */
class Personaldetailsmodel extends BACKEND_Model
 {
 	 
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
  
   public function save(array $data)
   {
   	  // for new record
   	  if(empty($data['student_id']))
   	  {
   	  	$this->load->model('studentmodel','stdm');
   	  	return $this->stdm->save($data);
   	  }
   	  else
   	  {
   	 	return parent::save($data);
   	  }
   }	 
   
   public function edit()
   {
    	$fields = $this->get_form_fields();
    	$id = $this->input->post('id');
   	     foreach($fields as $tf)
   	     {
   	     	$data[$tf] =  $this->input->post($tf);
   	     }
   	     $this->db->where('id',$id)->update($this->get_table_name(),$data);
   	     return true;
   }
   
   public function get_table_name()
   {
   	  return 'personal_details';
   }
  
   public function get_columns()
   {
    return array('id','student_id','first_name','last_name','dob','blood_group_id', 'subject_group_id', 'student_group_id','email','gender','caste_id','is_tribe','mobile','comments','nationality_id');
   }

 } 
?>