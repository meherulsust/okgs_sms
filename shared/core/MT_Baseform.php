<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jan 17, 2013
 */

class MT_BaseForm{
    protected $labels = array();
    protected $fields = array();
    protected $default_values = array();
    protected $current_field = array();
    protected $button_str = '';
    protected $hidden_str = '';
    protected $values = array();
    protected $name = '';
    protected $name_format = '{FORM_NAME}_%s';
    protected $CI = '';
    public function __construct(array $values = array()) {
        $this->CI = &get_instance();
        $this->CI->load->helper('form');
        $this->default_values = $values;
    }
    public function set_name_format($format) {

        $this->name_format = $format;
    }
    public function add_fields(array $fields) {
        $this->fields = array_merge($this->fields, $fields);
        return $this;
    }
     public function add_field($field, array $attributes = array()) {

        $default_attributes = array('id' => $field);
        $this->fields[$field] = array_merge($default_attributes, $attributes);
        $this->current_field = $field;
        return $this;
    }
    public function get_fields() {
        return $this->fields;
    }
    
    /*
     * insert text after form element
     * @Param String field optional
     * @Param String text to insert
     * 
     */
    public function add_text_after() {
        $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'add_text_after function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $text = $args[0];
        } else {
            $field = $args[0];
            $text = $args[1];
        }
        if (empty($field)) {
            show_error("No field name is assigned for adding text");
        }
        return $this->add_text($field, $text);
    }
/*
     * insert text before form element
     * @Param String field optional
     * @Param String text to insert
     * 
     */

    public function add_text_before() {
        $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'add_text_after function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $text = $args[0];
        } else {
            $field = $args[0];
            $text = $args[1];
        }
        return $this->add_text($field, $text, 'before');
    }
    
    /**
     * append text before or after form field
     * 
     * @param text $field
     * @param text $text
     * @param text $position
     * @return form object
     */
    public function add_text($field, $text, $position = 'after') {
        if (empty($field)) {
            show_error("No field name is assigned for adding text");
        }
        $this->fields[$field]['text_' . $position] = $text;
        return $this;
    }
    
    /*
     *  add input type text field.
     *  @param String field name
     *  @param Array  optional attributes of the field.
     */

    public function add_input($name, array $attributes = array()) {
        $attributes['type'] = 'text';
        return $this->add_field($name, $attributes);
    }
/*
     *  add input type file.
     *  @param String field name
     *  @param Array  optional attributes of the field.
     */

    public function add_file($name, array $attributes = array()) {
        $attributes['type'] = 'file';
        return $this->add_field($name, $attributes);
    }
 /*
     *  add textarea html element
     *  @param String field name
     *  @param Array  optional attributes of the field.
     */

    public function add_textarea($name, array $attributes = array()) {
        $attributes['type'] = 'textarea';
        return $this->add_field($name, $attributes);
    }
     /*
     *  add input type hidden field.
     *  @param String field name
     *  @param String  optional value of the field.
     */

    public function add_hidden($name, $value = '') {
        $this->add_field($name, array('type' => 'hidden'));
        if (!isset($this->default_values[$name]))
            $this->set_default($name, $value);
        return $this;
    }

    /*
     *  add select type input field.
     *  @param String field name
     *  @param String selected key
     *  @param Array  optional attributes of the field.
     */

    public function add_select($name, array $options, array $attributes = array()) {

        $attributes['type'] = 'select';
        $attributes['options'] = $options;
        return $this->add_field($name, $attributes);
    }
 /*
     *  generate select html element  based on provided params
     * name: name of html select element.
     * available options:
     *  * model: model name/object (required)
     *  * method: model method which will return query object that select
     *           * two columns first column will be key and second column
     *           * will be value. 
     *  * params : parameter to pass method. it must be an associative array.          
     *  * order_by: order by field name
     *              * it must me sql format 
     *              * field asc or field desc
     *  
     *            
     *  * key: field name which will be used as html option tag (id is by default)
     *  * value : field name which will be used as text  between option tag (title is by default).
     *  * add_empty: add option with empty key at the beginning of available option list.
     *  * where: condition used to select data. must be in sql format.
     *  
     * @ see add_select function.
     * 
     */

    public function add_model_select($name, array $options, array $attributes = array()) {
        if (isset($options['model'])) {
            $key = isset($options['key']) ? $options['key'] : 'id';
            $value = isset($options['value']) ? $options['value'] : 'title';
            $model = $options['model'];
            if (!is_object($model)) {
                $this->CI->load->model($model, 'tmp_hmo_model');
                $model = $this->CI->tmp_hmo_model;
            }
            if (isset($options['method'])) {
                if (method_exists($model, $options['method'])) {
                    if (isset($options['params']))
                        $query = $model->$options['method']($options['params']);
                    else
                        $query = $model->$options['method']();
                }
            }
            else {
                $this->CI->db->from($model->get_table_name())
                        ->select($key . ',' . $value);
                if (isset($options['order_by'])) {
                    $this->CI->db->order_by($options['order_by']);
                }
                if (isset($options['where'])) {
                    $this->CI->db->where($options['where'], NULL, false);
                }
                $query = $this->CI->db->get();
            }
            $data = array();
            if (isset($options['add_empty']) && $options['add_empty'])
                $data[''] = $options['add_empty'];
            if ($query->num_rows() > 0) {
                $rs = $query->result_array();
                foreach ($rs as $row) {
                    $data[$row[$key]] = $row[$value];
                }
            }
            $this->CI->unload('tmp_hmo_model');
            return $this->add_select($name, $data, $attributes);
        } else {
            show_error('model is a required option  in calling html_model_options function');
        }
    }
/*
     *  add  password type input field.
     *  @param String field name
     *  @param Array  optional attributes of the field.
     *  @return form object
     */

    public function add_password($name, array $attributes = array()) {
        $attributes['type'] = 'password';
        return $this->add_field($name, $attributes);
    }
    /*
     *  add  checkbox type input field.
     *  @param String field name
     *  @param Array  optional attributes of the field.
     *  @return form object
     */

    public function add_checkbox($name, array $attributes = array()) {
        $attributes['type'] = 'checkbox';
        return $this->add_field($name, $attributes);
    }
    public function add_button($data = '', $content = '', $extra = '') {
        $this->button_str .= form_button($data, $content, $extra);
        return $this;
    }
    public function get_value($field, $default = '') {
        if ($this->values) {
            return isset($this->values[$field]) ? $this->values[$field] : $default;
        } else {
            if ($this->is_submit()) {
                $field = $this->prepare_field_name($field);
                return $this->CI->input->post($field);
            }
        }
    }

    public function get_values() {
        return $this->values;
    }
    /*
     * set default value for a given field 
     * 
     * @access public 
     * @param String field name (optional when current field is set)
     * @param Mixed  field default value 
     * @return form object
     */

    public function set_default() {
        //var_dump($this->is_new());

        $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'set_default function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $default = $args[0];
        } else {
            $field = $args[0];
            $default = $args[1];
        }
        if (empty($field)) {
            show_error("No field name is assigned for default value");
        }
        if (!$this->is_new() && isset($this->default_values[$field])) {
            return $this;
        } else {
            $this->default_values[$field] = $default;
        }
        return $this;
    }

    public function set_defaults(array $value) {
        $this->default_values = array_merge($this->default_values, $value);
        return $this;
    }

    /*
     * set label for a given field 
     * 
     * @access public 
     * @param String field name (optional when current field is set)
     * @param Mixed  field label 
     * @return form object
     */

    public function set_label() {
        $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'set_label function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $label = $args[0];
        } else {
            $field = $args[0];
            $label = $args[1];
        }
        if (empty($field)) {
            show_error("No field name is assigned for setting label");
        }

        $this->labels[$field] = $label;
        return $this;
    }

    public function get_default($field, $val = false) {
        return isset($this->default_values[$field]) ? $this->default_values[$field] : $val;
    }

    public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    public function get_name() {
        return $this->name;
    }

    /**
     * add submit button in form.
     * 
     * @param String $name
     * @param String $value
     * @param Array $attributes
     * @return object
     */
    public function add_submit($name, $value = 'Submit', $attributes = array()) {

        $attributes['name'] = $name;
        $this->button_str .= form_submit($attributes, $value);
        return $this;
    }

    /**
     * 
     * @param String $name
     * @param String $value
     * @param Array $attributes
     * @return Object
     */
    public function add_reset($name, $value = 'Submit', $attributes = array()) {

        $attributes['name'] = $name;
        $this->button_str .= form_reset($attributes, $value);
        return $this;
    }

    protected function field_attributes() {
        return array(
            'type' => 'text',
            'id' => '',
            'class' => '',
            'style' => '',
            'text_after' => '',
            'text_before' => ''
        );
    }
     protected function naming_format($format, $field_name) {
        $this->labels[$field_name] = isset($this->labels[$field_name]) ? $this->labels[$field_name] : str_replace('_', ' ', $field_name);
        $this->fields[$field_name]['name'] = sprintf($format, $field_name);
        $this->fields[$field_name]['id'] = $this->name . '_' . $field_name;
    }
    protected function prepare_field_name($field_name) {
        $format = str_replace('{FORM_NAME}', $this->name, $this->name_format);
        return sprintf($format, $field_name);
    }

    public function get_model() {
        show_error("Please define a 'get_model' fuction in your form class.");
    }
    
    /**
     * field name similar to table field name
     * this will add field value which does not exist in form 
     * but exists in table. Call this function before save.
     * 
     * @param String $fld
     * @param String $val
     * @return \MT_BaseForm
     */
    public function set_value($fld,$val){
        $this->values[$fld] = $val;
        return $this;
    }
    
    /**
     * this will add a div element instead of input field
     * 
     * @param String $fld
     * @param Mixed  $attr
     * @return \MT_BaseForm
     */
    public function add_html($fld,$content){
        $attribute = array();
        $attribute['type'] = 'html';
        if(!is_array($content)){
           $attribute['tagname'] = 'div';
           $attribute['content'] = $content;
        }else{
             $attribute = array_merge($attribute,$content);
        }
        $this->fields[$fld] = $attribute;
        $this->current_field = $fld;
        return $this;
    }



}
?>
