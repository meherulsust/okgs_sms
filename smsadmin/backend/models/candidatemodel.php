<?php 
 class Candidatemodel extends BACKEND_Model
 {
 	 public function __construct()
 	 {
 	     	parent::__construct();
 	 }
	 public function get_table_name()
	 {
	   	  return 'candidate';
	 } 
 } 
 
?>