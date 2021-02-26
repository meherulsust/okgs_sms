<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 21, 2013
 */
class Usergroupmodel extends BACKEND_Model {
   public function __construct() {
        parent::__construct();
    }

    public function get_columns() {
        return array('id', 'title', 'description', 'status' ,'created_at', 'created_by');
    }
    

    public function get_table_name() {
        return 'user_group';
    }
    

}
?>
