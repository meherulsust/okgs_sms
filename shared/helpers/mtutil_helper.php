<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 3, 2012
 * this helper will contain some utility functions.
 */

/*
 * If arg1 is not empty, it returns arg1 otherwise it returns arg2
 * @argument mixed 
 * @return mixed
 */
function if_empty($arg1,$arg2)
{
	return isset($arg1) && !empty($arg1) ? $arg1 : $arg2; 
}


?>