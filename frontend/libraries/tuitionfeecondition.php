<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * this class contains all conditions applied to calculate 
 * tuition fee for each individual heads.
 * 
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Feb 21, 2014
 */
class Tuitionfeecondition {

    protected $CI;

    function __construct() {
        $this->CI = &get_instance();
    }
    
    public function get_fee($head_code,$params){
        $fee = array();
        switch($head_code){
            case 'VAT':
                break;
                
            case 'LATE_FEE':
                break;
        }
        
        
    }
    
    

   
}

?>