<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 30, 2012
 * Model class for religion.
 */

 class Nationalitymodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'nationality';
   } 
   public function get_columns()
   {
   	  return array('id','title');
   }
   
 } 
 
?>