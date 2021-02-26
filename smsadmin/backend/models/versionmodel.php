<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Md. Imrul Hasan
 * @ Created    September 14, 2014
 */
 class Versionmodel extends BACKEND_Model
 {
	public function __construct()
	{
		parent::__construct();
	}
  
    public function get_columns()
	{
		return array('id','title');
	}
  
	public function get_table_name()
	{
		return 'version_list';
	}

	
 }

?>