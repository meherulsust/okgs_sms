<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 03, 2012
 * Model class for occupation.
 */
class Districtmodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	
   public function get_table_name()
   {
   	  return 'district';
   }
    

 } 
?>
