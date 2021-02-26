<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 27, 2012
 */
class Grid_board {

    protected $CI;
    private $_filter = null;
    private $_model = null;
    private $_table_name = null;
    private $_params = array();
    private $_query_where = '';

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('date');
        $this->CI->load->config('grid_board');
        $this->CI->tpl->set_js('grid');
    }

    /**
     * Set grid title.
     * @param String 
     * @return boolean 
     */
    public function set_title($str) {
        $this->CI->tpl->assign('list_title', $str);
        return $this;
    }

    /**
     * Set grid column and its attribute.
     * i.e array('field_name'=>array('title'=>'Grid Column Title','order'=>true),
     * 'field_name'=>'Grid Column Title') or
     * default order is true 
     * @param Array 
     * @return boolean 
     */
    public function set_column(array $columns) {

        $this->CI->tpl->assign('grid_columns', $this->_prepare_column($columns));
        return $this;
    }

    /**
     * set items for grid status menu
     * @param array $items
     * @return object
     */
    public function set_status_menu(array $items = array()) {
        if (empty($items)) {
            $items = $this->CI->config->item('grid_status_menu_items');
        }
        $this->CI->tpl->assign('grid_status_menu_items', $items);
        return $this;
    }

    /*
     * replace column missing option with
     * default value
     */

    private function _prepare_column($columns) {
        $default_option = $this->CI->config->item('grid_column_option');
        foreach ($columns as $fld => &$opt) {
            if (!is_array($opt)) {
                $opt = array('title' => $opt);
            }
            $opt = array_merge($default_option, $opt);
        }
        return $columns;
    }

    public function set_config(array $config) {
        
    }

    public function render($arg) {
        if (is_array($arg)) {
            if (!array_key_exists('model', $arg)) {
                show_error('Grid Board: No model is set for grid board.');
            } else {
                $model_name = $arg['model'];
            }
            if (array_key_exists('method', $arg)) {
                $method_name = $arg['method'];
            } else {
                $method_name = 'grid_query';
            }
            if (array_key_exists('count_method', $arg)) {
                $count_method_name = $arg['count_method'];
            } else {
                $count_method_name = 'total_grid_record';
            }
        } else {
            $model_name = $arg;
            $method_name = 'grid_query';
            $count_method_name = 'total_grid_record';
        }
        $this->CI->load->model($model_name);
        $this->_model = $this->CI->{$model_name};
        $this->_table_name = $this->_model->get_table_name();
        if ($this->CI->config->item('grid_pagination')) {
            if($this->_filter)
            $this->_filter->build_condition($this->_model);
            if (method_exists($this->_model, $count_method_name)) {
                $info['total_rows'] = $this->_model->$count_method_name($this->_params);
            } else {
                $info['total_rows'] = $this->$count_method_name();
            }
            $this->CI->tpl->assign('grid_total_records',$info['total_rows']);
           //echo $this->_model->db->last_query();exit();
            $this->_init_pagination($info);
        }
        if (method_exists($this->_model, $method_name)) {
            $this->_model->$method_name($this->_params);
        } else {
            $this->grid_query();
        }
        $this->_init_sort();
        if($this->_filter)
        $this->_filter->build_condition($this->_model);
        $query = $this->_model->db->get();
        $this->CI->tpl->assign('grid_records', $query->result_array());
        if (!$this->CI->tpl->get_assigned_var('grid_actions')) {
            $this->set_action(array('view', 'edit', 'del'));
        }
        if (!$this->CI->tpl->get_assigned_var('grid_status_menu_items')) {
            $this->set_status_menu();
        }
       // $this->_filter->remember();
        //echo $this->_model->db->last_query();exit();
    }
	
	
	public function condition_render($arg,$param) {
        if (is_array($arg)) {
            if (!array_key_exists('model', $arg)) {
                show_error('Grid Board: No model is set for grid board.');
            } else {
                $model_name = $arg['model'];
            }
            if (array_key_exists('method', $arg)) {
                $method_name = $arg['method'];
            } else {
                $method_name = 'grid_query';
            }
            if (array_key_exists('count_method', $arg)) {
                $count_method_name = $arg['count_method'];
            } else {
                $count_method_name = 'total_grid_record';
            }
        } else {
            $model_name = $arg;
            $method_name = 'grid_query';
            $count_method_name = 'total_grid_record';
        }
        $this->CI->load->model($model_name);
        $this->_model = $this->CI->{$model_name};
        $this->_table_name = $this->_model->get_table_name();
        if ($this->CI->config->item('grid_pagination')) {
            if($this->_filter)
            $this->_filter->build_condition($this->_model);
            if (method_exists($this->_model, $count_method_name)) {
                $info['total_rows'] = $this->_model->$count_method_name($param);
            } else {
                $info['total_rows'] = $this->$count_method_name();
            }
            $this->CI->tpl->assign('grid_total_records',$info['total_rows']);
           //echo $this->_model->db->last_query();exit();
            $this->_init_pagination($info);
        }
        if (method_exists($this->_model, $method_name)) {
            $this->_model->$method_name($param);
        } else {
            $this->grid_query();
        }
        $this->_init_sort();
        if($this->_filter)
        $this->_filter->build_condition($this->_model);
        $query = $this->_model->db->get();
        $this->CI->tpl->assign('grid_records', $query->result_array());
        if (!$this->CI->tpl->get_assigned_var('grid_actions')) {
            $this->set_action(array('view', 'edit', 'del'));
        }
        if (!$this->CI->tpl->get_assigned_var('grid_status_menu_items')) {
            $this->set_status_menu();
        }
       // $this->_filter->remember();
        //echo $this->_model->db->last_query();exit();
    }

    private function _init_pagination($info) {
        $rec_per_page = $this->CI->input->post('grid_rec_per_page');
        $config['per_page'] = $rec_per_page ? $rec_per_page : $this->CI->config->item('grid_record_per_page');
        //$config['per_page']= $rec_per_page ? $rec_per_page:1000;
        $data['total_records'] = $info['total_rows'];
        $data['offset'] = '';
        if ($config['per_page'] < $info['total_rows'] || $rec_per_page > 0) {
            $this->CI->load->library('pagination');
            $config['num_links'] = 3;
            $config['uri_segment'] = 0;
            $config['cur_tag_open'] = '<span class=\'disabled_tnt_pagination\'>';
            $config['cur_tag_close'] = '</span>';
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Previous';
            $config['total_rows'] = $info['total_rows'];
            if ($this->CI->input->is_post_request()){
                $this->CI->pagination->cur_page = $this->CI->input->post('grid_page_offset');
            }
            $url = site_url() . '/' . $this->CI->router->class . '/' . $this->CI->router->method;
            $config['base_url'] = $url;
            $this->CI->pagination->initialize($config);
            $data['offset'] = $this->CI->pagination->cur_page;
            $this->CI->tpl->assign('grid_pagination_bar', $this->CI->pagination->create_links());
            $data['total_page'] = ceil($config['total_rows'] / $config['per_page']);
            $data['cur_page'] = $this->CI->pagination->cur_page;
            $this->_model->db->limit($config['per_page']);
            $this->_model->db->offset($data['offset']);
            $current_record = $data['offset'] + $config['per_page'];
            $current_record = ($current_record > $info['total_rows'])? $info['total_rows'] :$current_record;
            $this->CI->tpl->assign('grid_current_record', $current_record );
        } else {
            $this->CI->config->set_item('grid_pagination', FALSE);
        }
        $this->CI->tpl->assign('grid_page_info', $data);
    }

    /**
     * select all records to display
     * in grid 
     * @return query
     */
    public function grid_query() {
        $cols = $this->CI->tpl->get_assigned_var('grid_columns');
        if (is_array(($cols))) {
            $this->_model->db->select(implode(',', array_keys($cols)))->from($this->_table_name);
            if ($this->_query_where)
                $this->_model->db->where($this->_query_where);
            if($this->_filter)
                $this->_filter->build_condition($this->_model);
        }
        else {
            show_error('Model: No column is set for the grid board.');
        }
    }

    public function total_grid_record() {
        $this->CI->db->from($this->_table_name);
        if ($this->_query_where)
            $this->CI->db->where($this->_query_where);
        if($this->_filter)
            $this->_filter->build_condition($this->_model);
        return $this->_model->db->count_all_results();
    }

    private function _init_sort() {
        $cols = $this->CI->tpl->get_assigned_var('grid_columns');
        $fields = array_keys($cols);
        // set default value
        $data['type'] = $this->CI->config->item('grid_sort_type');
        $data['field'] = array_search($this->CI->config->item('grid_sort_field'), $fields);
        if ($this->CI->input->is_post_request()){
            $data['type'] = $this->CI->input->post('grid_sort_type');
            $data['field'] = $this->CI->input->post('grid_sort_field');
        }
        $nextsort = ($data['type'] == 'asc') ? 'desc' : 'asc';
        $this->_model->db->order_by($fields[$data['field']], $data['type'], true);
        $data['ntype'] = $nextsort;
        $data['field'] = $data['field'];
        $data['sort_full_name'] = ($data['type'] == 'asc') ? 'Ascending' : 'Descending';
        $this->CI->tpl->assign('grid_sort_info', $data);
    }
    /**
     * set grid action of grid board.
     * action must be registered to grid default actions
     * in grid config.
     * parameter can be simply array('edit','delete',....)
     * or 
     * array('edit'=>array('title'=>'some title','action'=>'cutom', controller=>''))
     * if any key of inner array is missed it will be replace with the default_actions 
     * key=>val in config
     * if controller is not set it will be replaced with current controller.
     * 
     * @param Array $actions
     * @return current object
     */
    public function set_action(array $actions) {
        $this->CI->tpl->assign('grid_actions', $this->_prepare_action($actions));
        return $this;
    }

    /*
     * prepare action with proper options
     */

    private function _prepare_action($actions = array()) {
        $default_actions = $this->CI->config->item('grid_all_actions');
        $result = array();
        foreach ($actions as $actn => $opt) {
            if (!is_array($opt)) {
                $actn = $opt;
                $opt = array_merge($default_actions[$opt], array('action' => $opt));
            }
            else
                $opt = array_merge($default_actions[$actn], $opt);

            $opt['controller'] = if_empty($opt['controller'], $this->CI->router->class);
            $result[$actn] = $opt;
        }
        return $result;
    }

    /**
     *  set parameter for grid
     * @param Array $params
     * @return this object
     */
    public function set_params($params = array()) {
        $this->_params = array_merge($this->_params, $params);
        return $this;
    }

    /**
     * set value for specific parameter key
     * 
     * @param mix $name
     * @param mix $val
     * @return unknown_type
     */
    public function set_param($name, $val) {
        $this->_params[$name] = $val;
        return $this;
    }

    /**
     * add query condition for grid.
     * 
     * @param Mixed $where
     * @return object
     */
    public function query_condition($where) {
        $this->_query_where = $where;
        return $this;
    }

    /**
     * add link to the grid title.
     * 
     * @param String $lbl 
     * @param String $url
     * @param Array $attributes
     * @return object
     */
    public function add_link($lbl = 'New', $url = "#", array $attributes = array()) {
        $attr = '';
        foreach ($attributes as $key => $val)
            $attr .= $key . '="' . $val . '" ';
        $link = '<a href="' . $url . '" ' . $attr . '>' . $lbl . '</a>';
        $this->CI->tpl->assign('grid_link', $link);
        return $this;
    }
    
    public function set_filter($filter){
        $this->_filter = $filter;
        return $this;
    }

}

?>