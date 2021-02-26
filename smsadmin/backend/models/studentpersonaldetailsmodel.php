<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 23, 2012
 * Model class for sutdentpersonaldetails.
 */
class Studentpersonaldetailsmodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_table_name() {
        return 'student_personal_details';
    }

    public function get_columns() {
        return array('id', 'student_id', 'personal_details_id', 'created_at');
    }

}

?>
