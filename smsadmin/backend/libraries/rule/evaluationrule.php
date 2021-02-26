<?php
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    December 25, 2012
 * 
 * base class for evaluation rule
 */
 class Evaluationrule{
     protected $rules = array();
     protected $row   = array();
     protected $CI;
     public function __construct() {
         $this->CI = &get_instance();
     }
 }
?>
