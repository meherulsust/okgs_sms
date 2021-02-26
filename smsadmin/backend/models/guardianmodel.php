<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 11, 2012
 * Model class for guardian.
 */
class Guardianmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function save($values)
   {
 	  $values['guardian_id'] = parent::save($values);
          $values['id'] = isset($values['student_guardian_id']) ? $values['student_guardian_id']:'';
          $this->load->model('studentguardianmodel','sgm');
 	  $this->sgm->save($values);
   	  return $values['guardian_id'];
   	 
   }
   public function get_info($id){
       $query = $this->db->select('g.id,sg.id student_guardian_id, relationship_id,first_name,last_name,mobile,phone,anual_income,email,occupation_id,national_id,designation_id,service_no')
               ->from('student_guardian sg')
               ->join('guardian g','sg.guardian_id = g.id','right')
               ->where('g.id',$id)
               ->get();
       if($query->num_rows() > 0)
           return $query->row_array();
       else
           return false;
   }
   public function get_table_name(){
       return 'guardian';
   }
  
   public function get_columns()
   {
   	  return array('id','first_name','last_name','mobile','national_id','phone','email','anual_income','occupation_id','designation_id','service_no');
   }
    

 } 
?>
