<?php

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Feb 23, 2012
 */
class Pmt_node {

    private $_children = array();

    function __construct() {
        
    }

    public function append_child($child) {
        $this->_children[] = $child;
    }

    public function get_children() {
        return $this->_children;
    }

    public function get_module() {
        if ($this->url) {
            $tmp = explode('/', $this->url);
            return $tmp[0];
        }
        return false;
    }

    public function get_action() {
        if ($this->url) {
            $tmp = explode('/', $this->url);
            return (count($tmp) > 1) ? $tmp['1'] : 'index';
        }
        return false;
    }

}

?>