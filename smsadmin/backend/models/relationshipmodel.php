<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 04, 2012
 * Model class for relationship.
 */
class Relationshipmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'relationship';
   }
   public function get_columns()
   {
   	  return array('id','title');
   }
   
 } 
?>