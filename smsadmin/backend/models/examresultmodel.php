<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 13, 2013
 * 
 * model class for exam result
 */
 class Examresultmodel extends BACKEND_Model
 {
    public function __construct()
    {
      parent::__construct();
    }
   public function get_table_name()
   {
   	 return 'exam_result';
   }
   public function get_columns()
   {
   	  return array('id','exam_registration_id','obtain_marks','weight','additional_marks','additional_weight','scale_matrix_id','created_at','updated_at','updated_by','created_by');
   }
 }
 ?>