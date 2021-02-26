<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 17, 2013
 * Model class for lookup type.
 */
class Lookuptypemodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function get_table_name()
   {
   	  return 'lookup_type';
   }
  
   public function get_columns()
   {
   	  return array('id','title','unique_code','comments','created_at','created_by');
   }
   
   public function is_not_unique_code($code){
       $num = $this->count(array('unique_code'=>$code));
       if($num > 0)
           return true;
       else
           return false;
       
   }
    

 } 
?>
