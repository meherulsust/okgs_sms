<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 12, 2011
 */
class MT_Input extends CI_Input{
	
	/*
	 * it returns request type in 
	 * uppercase letter i.e GET,POST etc.
	 */
	public function get_request_type()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
	public function is_get_request()
	{
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}
    public function is_post_request()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}
} 
?>