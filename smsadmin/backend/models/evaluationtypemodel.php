<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 26, 2012
 *  
 * Model class for evaluation type
 */
 class Evaluationtypemodel extends BACKEND_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'evaluation_type';
    }	
   public function get_columns()
   {
   	  return array('id','eval_type','title','eval_func','description','status','description','created_at','created_by');
   }   
 }

?>