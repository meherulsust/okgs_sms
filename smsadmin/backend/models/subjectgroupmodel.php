<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Arena Development Team
 * @ Created     May 18, 2016
 */
class Subjectgroupmodel extends BACKEND_Model
 {
 	public function __construct()
 	{
 	   	parent::__construct();
 	}
 	 
	public function get_columns() {
        return array('id','title','compulsory_sub_id', 'optional_sub_id');
    }
	
	public function get_table_name()
	{
            return 'subject_grouping';
	}
    

 } 
