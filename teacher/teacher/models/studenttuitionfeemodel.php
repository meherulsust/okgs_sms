<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     January 08, 2012
 */
 class Studenttuitionfeemodel extends Frontend_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'student_tuition_fee';
    }
   public function get_columns()
   {
   	  return array('id','tuition_fee_head_id','amount','is_active','created_at','created_by','updated_at','updated_by');
   }
   
   public function get_student_fee($student_id){
       $this->load->model('tuitionfeemodel');
       $common_fees = $this->tuitionfeemodel->get_active_fee();
       return $common_fees;
       
   }
   
   
 }

?>