<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 12, 2011
 */
class MT_Controller extends CI_Controller {

    private $_ignore_auth = array();

    function __construct() {
        parent::__construct();
        $this->init_app_config();
        $this->do_access_controll();
        $this->init_app_libs();
        $this->init_app();
    }

    protected function init_app_config() {
        $this->load->helper('url');
        $this->load->helper('mtutil');
        $this->load->helper('template');
    }

    protected function init_app_libs() {
        //load template library from shared location
        $this->load->library('template', null, 'tpl');
    }

    protected function init_app() {
        $this->_clear_cache();
        return true;
    }

    /**
     * store module list which does not require
     * to check authentication.
     * @param mixed $module 
     * @return boolean
     */
    public function set_ignore_auth($module) {
        if (is_array($module)) {
            $this->_ignore_auth = array_merge($this->_ignore_auth, $module);
        } else {
            array_push($this->_ignore_auth, $module);
        }
        return true;
    }

    public function get_open_module() {
        return $this->_ignore_auth;
    }

    public function require_login($module = '') {
        $module = empty($module) ? $this->router->class : $module;
        $this->_ignore_auth;
        if (in_array(strtolower($this->router->class), $this->_ignore_auth)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     *  ensure access controlling 
     *  for current request.
     * 
     */
    public function do_access_controll() {
        if ($this->config->item('enable_auth')) {
            $this->load->library($this->config->item('auth_lib'), null, 'auth');
            if ($this->require_login()) {
                $ret = $this->auth->is_logged_in();
                if (!$ret) {
                    redirect('login');
                }
            }
        }
    }

    public function request($name, $deafult = '', $type = 'get') {
        switch ($type) {
            case 'get':
                $params = $this->uri->uri_to_assoc();
                return isset($params[$name]) ? $params[$name] : $default;
                break;
        }
    }

    /**
     * unset class loadded through load api.
     * @param $class_name
     * @param $type
     * @return true
     */
    public function unload($class_name, $type = 'model') {
        $obj = $this->{$class_name};
        if (is_object($obj)) {
            switch (strtolower($type)) {
                case 'model' :
                    unset($this->load->_ci_models[array_search($class_name, $this->load->_ci_models)]);
                    break;
            }
        }
        unset($obj, $this->{$class_name});
    }

    /**
     * 
     * @param String $type message type i.e  success,eorror,notice,info 
     * @param String $message message to be displayed
     * @return Boolean
     */
    public function flash_message($type = 'success', $message) {
        switch ($type) {
            case 'error' :
                $class = 'error';
                break;
            case 'notice':
                $class = 'notice';
                break;
            default:
                $class = 'info';
        }
        $this->session->set_flashdata('message', "<div class='$class'>$message</div>");
        return true;
    }
    /**
     * prevent browser to cache page.
     */
    private function _clear_cache() {
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Cache-Control: no-cache, must-revalidate');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    }
	
	
	function current_date()
	{
		$timezone = "Asia/Dhaka";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
		return date("Y-m-d");
	}

	function current_datetime()
	{
		$timezone = "Asia/Dhaka";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);	
		return date("Y-m-d h:i:s");
	}	
	

}

?>