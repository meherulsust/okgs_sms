<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MT_Loader extends CI_Loader {

    var $_ci_forms = array();
    var $_ci_form_paths = array();
    var $_ci_filters = array();
    var $_ci_filter_paths = array();

    public function __construct() {
        parent::__construct();
        $this->_ci_form_paths = array(SHAREDPATH, APPPATH);
        $this->_ci_filter_paths = array(SHAREDPATH, APPPATH);
    }

    /**
     * Over Write Base Load Class
     *
     * This function loads the specified helper file.
     *
     * @access	public
     * @param	mixed
     * @return	void
     */
    function helper($helpers = array()) {
        foreach ($this->_ci_prep_filename($helpers, '_helper') as $helper) {
            if (isset($this->_ci_helpers[$helper])) {
                continue;
            }

            $ext_helper = APPPATH . 'helpers/' . config_item('subclass_prefix') . $helper . EXT;
            $share_helper = SHAREDPATH . 'helpers/' . config_item('shared_subclass_prefix') . $helper . EXT;
            // Is this a helper extension request?
            if (file_exists($ext_helper)) {
                if (file_exists($base_helper)) {
                    include_once($share_helper);
                }
                $base_helper = BASEPATH . 'helpers/' . $helper . EXT;

                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . EXT);
                }

                include_once($ext_helper);
                include_once($base_helper);

                $this->_ci_helpers[$helper] = TRUE;
                log_message('debug', 'Helper loaded: ' . $helper);
                continue;
            } elseif (file_exists($share_helper)) {
                $base_helper = BASEPATH . 'helpers/' . $helper . EXT;

                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . EXT);
                }

                include_once($share_helper);
                include_once($base_helper);

                $this->_ci_helpers[$helper] = TRUE;
                log_message('debug', 'Helper loaded: ' . $helper);
                continue;
            }

            // Try to load the helper
            foreach ($this->_ci_helper_paths as $path) {
                if (file_exists($path . 'helpers/' . $helper . EXT)) {
                    include_once($path . 'helpers/' . $helper . EXT);

                    $this->_ci_helpers[$helper] = TRUE;
                    log_message('debug', 'Helper loaded: ' . $helper);
                    break;
                }
            }

            // unable to load the helper
            if (!isset($this->_ci_helpers[$helper])) {
                show_error('Unable to load the requested file: helpers/' . $helper . EXT);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * Form Loader
     *
     * This function lets users load and instantiate forms.
     *
     * @access	public
     * @param	string	the name of the class
     * @param	string	name for the form
     * @param	bool	database connection
     * @return	void
     */
    function form($form, $name = '', $default_values = array()) {
        if ($form == '') {
            return;
        }

        $path = '';

        // Is the form in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($form, '/')) !== FALSE) {
            // The path is in front of the last slash
            $path = substr($form, 0, $last_slash + 1);

            // And the model name behind it
            $form = substr($form, $last_slash + 1);
        }

        if ($name == '') {
            $name = $form;
        }

        if (in_array($name, $this->_ci_forms, TRUE)) {
            return;
        }
        $CI = & get_instance();
        if (isset($CI->$name)) {
            show_error('The form name you are loading is the name of a resource that is already being used: ' . $name);
        }
        // check is shared location.
        $form_file = SHAREDPATH . 'core/' . $path . config_item('shared_subclass_prefix') . 'Form' . EXT;
        if (!file_exists($form_file)) {
            show_error('Base form file is required: ' . $form_file);
        }
        require_once($form_file);
        //check in application end
        $form_file = APPPATH . 'core/' . $path . config_item('subclass_prefix') . 'Form' . EXT;
        if (file_exists($form_file)) {
            require_once($form_file);
        }
        $form_file = APPPATH . 'forms/' . $path . $form . EXT;
        if (!file_exists($form_file)) {
            // couldn't find the form
            show_error('Unable to locate the form you have specified: ' . $form);
        }
        require_once($form_file);
        $form = ucfirst($form);
        $CI->$name = new $form($default_values);

        $this->_ci_forms[] = $name;
        return;
    }

    // --------------------------------------------------------------------

    /**
     * Filter Loader
     *
     * This function lets users load and instantiate filters.
     *
     * @access	public
     * @param	string	the name of the class
     * @param	string	name for the filter
     * @param	string	default_value for the filter input box
     * @return	void
     */
    function filter($filter, $name = '', $default_values = array()) {
        if ($filter == '') {
            return;
        }

        $path = '';

        // Is the filter in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($filter, '/')) !== FALSE) {
            // The path is in front of the last slash
            $path = substr($filter, 0, $last_slash + 1);

            // And the model name behind it
            $filter = substr($filter, $last_slash + 1);
        }

        if ($name == '') {
            $name = $filter;
        }

        if (in_array($name, $this->_ci_filters, TRUE)) {
            return;
        }
        $CI = & get_instance();
        if (isset($CI->$name)) {
            show_error('The filter name you are loading is the name of a resource that is already being used: ' . $name);
        }
        // check in shared location.
        $filter_file = SHAREDPATH . 'core/' . $path . config_item('shared_subclass_prefix') . 'Filter' . EXT;
        if (!file_exists($filter_file)) {
            show_error('Base filter file is required: ' . $filter_file);
        }
        require_once($filter_file);
        //check in application end
        $filter_file = APPPATH . 'core/' . $path . config_item('subclass_prefix') . 'Filter' . EXT;
        if (file_exists($filter_file)) {
            require_once($filter_file);
        }
        $filter_file = APPPATH . 'filters/' . $path . $filter . EXT;
        if (!file_exists($filter_file)) {
            // couldn't find the form
            show_error('Unable to locate the form you have specified: ' . $filter);
        }
        require_once($filter_file);
        $filter = ucfirst($filter);
        $CI->$name = new $filter($default_values);

        $this->_ci_filters[] = $name;
        return;
    }

    // --------------------------------------------------------------------
}

?>