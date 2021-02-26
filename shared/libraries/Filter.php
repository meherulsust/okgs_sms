<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    April 18, 2011
*/
class Filter{
	
	public function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->library('session');
	}
	public function init(array $fields)
	{
		if(!$this->CI->input->is_post_request())
		 return $this;
		foreach($fields as $fld)
		{
			 $data[$this->CI->router->class][$fld]=$this->CI->input->post($fld);
		}
		$this->CI->session->set_userdata($data);
		return $this;
	}
	public function reset()
	{
		$this->CI->session->unset_userdata($this->CI->router->class);
		return $this;
	}
	/*
	 * return filter values
	 */
	public function get_values()
	{
		return $this->CI->session->userdata($this->CI->router->class);
	}
	public function get_value($field)
	{
		$values = $this->CI->session->userdata($this->CI->router->class);
		return $values[$field];
	}	
}
?>