<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 05, 2013
 * Model class for School.
 */
class Schoolmodel extends MT_Model
{
   public function __construct()
   {
      	parent::__construct();
   }
   public function get_table_name()
   {
   	  return 'school';
   }
   public function get_columns()
   {
   	  return array('id','name','logo_file','address1','address2','establish_date','description','created_at');
   }
    
}
?>
