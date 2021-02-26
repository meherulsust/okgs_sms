<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     January 01, 2012
 * Model class for statu.
 */
class Statusmodel extends BACKEND_Model
 {
   public function __construct()
   {
      	parent::__construct();
   }
   public function get_table_name()
   {
   	  return 'status';
   }
   public function get_columns()
   {
   	  return array('id','title','created_at','created_by');
   }
    

 } 
?>
