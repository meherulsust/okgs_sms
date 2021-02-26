<?php
if(!defined('BASEPATH')) exit ('not direct script access allowed.');

/* 
 * @ Author         Avijit Chakravarty
 * 
 * @ Created        29th January, 2017
 */

class Board_examsmodel  extends BACKEND_Model{
    public function __construct() {
        parent::__construct();
    }
    function get_table_name() {
        return 'board_exams';
    }
    function get_columns() {
        return array('id', 'title', 'description', 'status', 'created_at', 'created_by');
    }
    
}