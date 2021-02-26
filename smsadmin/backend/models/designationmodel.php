<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     May 03, 2012
 * Model class for occupation.
 */
class Designationmodel extends BACKEND_Model
 {
 	public function __construct()
 	{
 	   	parent::__construct();
 	}
 	 
	public function get_table_name() {
        return 'designation';
    }

    public function get_columns() {
        return array('id','title','type','description');
    }
	
    public function grid_query() {
        $this->db->select('designation.*')
                ->from('designation');}
	
	public function total_grid_record() {
        $query = $this->db->select('count(id)')->from('designation');
        return $query->count_all_results();
    }
 } 
?>
