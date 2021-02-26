<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 19, 2011
 */

class MT_Output extends CI_Output
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	public function _display($output = '')
	{
                $CI =& get_instance();
		if (class_exists('MT_Controller') && !$CI->input->is_cli_request())
		{
			$CI->tpl->render();
		}
		parent::_display($output);
	}
}
?>