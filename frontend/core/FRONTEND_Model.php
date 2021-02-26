<?php 
class Frontend_Model extends MT_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_created_by()
	{
		return $this->session->userdata('user_id');
	}
}

?>