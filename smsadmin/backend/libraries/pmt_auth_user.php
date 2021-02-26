<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 24, 2013
 * entity class for login user
 */
class Pmt_auth_user{
    
    public function get_full_name(){
        return ucwords($this->full_name);
    }
}

?>
