<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Imrul Hasan <rifat.pstu@gmail.com>
 * @ Created     October 23, 2014
 * 
 */
class Fundmodel extends BACKEND_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_table_name()
	{
		return 'fund_list';
	}
	public function get_columns()
	{
		return array('id','title','status','create_date');
	}
	
	public function get_fund_list()
	{
		$query = $this->db->select('*')
   	   			->from('fund_list')
				->where('status','ACTIVE')
				->order_by('id','ASC')
   	  		    ->get();
		return $query->result_array();		
	}

} 
?>
