<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/MT_Baseform.php');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		Reza Ahmed
 */
class MT_Form extends MT_BaseForm {

    const EDIT_MODE = 'FORM_EDIT';
    const NEW_MODE = 'FORM_NEW';
    const SUBMIT_MODE = 'FORM_SUBMIT';

    private $_open_mode = 'FORM_NEW';
    protected $validators = array();
    protected $skip_fields = array();

    public function __construct(array $values = array()) {
        parent::__construct($values);
        $this->_set_open_mode();
        $this->init();
    }

    /*
     * Overwrite in child class.
     */

    public function init() {
        
    }

    private function _set_open_mode() {
        $model_name = $this->get_model();
        $this->CI->load->model($model_name);
        $model = $this->CI->{$model_name};
        $pk = $model->get_primary_field();

        //check after submit
        if ($this->is_submit()) {
            if ($this->get_value($pk)) {
                $this->_open_mode = self::EDIT_MODE;
            }
        } else {
            //check before submit
            if (array_key_exists($pk, $this->default_values) && !empty($this->default_values[$pk])) {
                $this->_open_mode = self::EDIT_MODE;
            }
        }
    }

    public function is_new() {
        // $this->_set_open_mode();
        if ($this->_open_mode == self::NEW_MODE) {
            return true;
        }
        return false;
    }

    public function is_submit() {

        if ($this->CI->input->is_post_request()) {
            return true;
        }
        return false;
    }

    public function get_open_mode() {
        return $this->_open_mode;
    }

    private function _init_validator() {
        $this->CI->load->library('form_validation');
        $this->validator = $this->CI->form_validation;
        $this->validator->set_error_delimiters('<span class="error">', '</span>');
    }

    /**
     * skip form field to save.
     * 
     * @param String $field optional
     * @return object
     */
    public function skip($field = '') {
        $field = empty($field) ? $this->current_field : $field;
        $this->skip_fields[] = $field;
        return $this;
    }

    /*
     * set validation rule for a given field 
     * 
     * @access public 
     * @param String field name (optional when current field is set)
     * @param String validation rule 
     * @return form object
     */

    public function set_validator() {
        $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'set_validator function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $rules = $args[0];
        } else {
            $field = $args[0];
            $rules = $args[1];
        }
        if (empty($field)) {
            show_error("No field name is assigned for validator");
        }
        $this->validators[$field] = $rules;
        $this->add_text_after($field, '<span class="req">*</span>');
        return $this;
    }

    public function validate() {
        if ($this->CI->input->is_post_request()) {
            $this->_init_validator();
            $this->assign_validation_rules();
            return $this->validator->run();
        }
        return false;
    }

    /**
     * Assign validation rule for corresponing field
     * @return current object
     */
    protected function assign_validation_rules() {
        $format = str_replace('{FORM_NAME}', $this->name, $this->name_format);
        foreach ($this->fields as $name => &$field) {
            $this->naming_format($format, $name);
            if (isset($this->validators[$name]) && $field['type'] != 'file') {
                $this->validator->set_rules($field['name'], $this->labels[$name], $this->validators[$name]);
            }
        }
        return $this;
    }

    public function render() {

        $content = '';
        $format = str_replace('{FORM_NAME}', $this->name, $this->name_format);
        foreach ($this->fields as $name => &$field) {
            $this->naming_format($format, $name);
            $attributes = $this->field_attributes();
            $field +=  $attributes;
            $type = $field['type'];
            if ($this->CI->input->is_post_request()) {
                $value = set_value($field['name'], $this->CI->input->post($field['name']));
            } else {
                if (isset($this->default_values[$name]))
                    $value = set_value($field['name'], $this->default_values[$name]);
                else
                    $value = set_value($field['name']);
            }
            if ('hidden' != $type) {
                $content .= '<tr><th class="lbl"><label for="' . $field['id'] . '">' . ucwords($this->labels[$name]) . "</label></th><td class='cln'>:</td><td>";
                if ($field['text_before']) {
                    $content .= $field['text_before'];
                }
            }
            $text_after = $field['text_after'];
            unset($field['text_before'], $field['text_after']);
            switch ($type) {
                case 'text' :
                    $content .= form_input($field, $value);
                    break;
                case 'file' :
                    $content .= form_upload($field, $value);
                    break;
                case 'password' :
                    $content .= form_password($field, $value);
                    break;
                case 'checkbox' :
                    if( $value || (isset($field['checked']) && $filed['checked'])){
                         $field['checked'] = TRUE;
                         $field['value'] = $value;
                    }else{
                         $field['checked'] = FALSE;
                         $field['value']=1;
                    }
                    $content .= form_checkbox($field);
                    break;
                case 'select' :
                    $options = $field['options'];
                    unset($field['options'], $field['type']);
                    $select_attr = $field;
                    unset($select_attr['name']);
                    $content .= form_dropdown($field['name'], $options, $value, false, $select_attr);
                    break;
                case 'textarea' :
                    $content .= form_textarea($field, $value);
                    break;
                case 'hidden' :
                    $this->hidden_str .= "<input type='hidden' name='" . $field['name'] . "' value='$value' id='" . $field['name'] . "' />";
                    continue 2;
                    break;
                case 'html':
                    $content .= "<".$field['tagname']." id='".$field['name']."_content' >".$field['content']."</".$field['tagname'].">";
            }
            if ($text_after) {
                $content .= $text_after;
            }
            if (isset($this->validators[$name]))
                $content .= form_error($field['name']);
            $content .= "</td></tr>";
        }
        if (!empty($this->button_str)) {
            $content .= '<tr><td>&nbsp;</td><td class="btn-container" colspan="2">';
            $content .= $this->button_str;
            $content .='</td></tr>';
        }
        return $content;
    }

    public function render_hidden() {
        return $this->hidden_str;
    }

    public function save() {
        $this->procss_form();
        return $this->do_save();
    }

    protected function procss_form() {
        if ($this->CI->input->is_post_request()) {
            foreach ($this->fields as $name => $field) {
                $indexes = array();
                //check if  array field;
                if (strpos($name, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $name, $matches)) {
                    // Note: Due to a bug in current() that affects some versions
                    // of PHP i can not pass function call directly into it
                    $x = explode('[', $name);
                    $field_name = current($x);
                    $indexes[] = $this->prepare_field_name($field_name);
                    if (in_array($field_name, $this->skip_fields))
                        continue;
                    // make field like array.
                    $temp_str = '$this->values["' . $field_name . '"]';
                    for ($i = 0; $i < count($matches['0']); $i++) {
                        if ($matches['1'][$i] != '') {
                            $indexes[] = $matches['1'][$i];
                            $temp_str .= '["' . $matches['1'][$i] . '"]';
                        } else {
                            $temp_str .= '[]';
                        }
                    }
                    $val = $this->_reduce_array($_POST, $indexes);
                    if (is_array($val)) {
                        foreach ($val as $k => $v) {
                            eval($temp_str . "='$v';");
                        }
                    } else {
                        eval($temp_str . "='$val';");
                    }
                } else {
                    if (!in_array($name, $this->skip_fields))
                        $this->values[$name] = $this->CI->input->post($field['name']);
                }
            }
            if ($this->is_new()) {
                $this->values['created_at'] = date('Y-m-d H:i:s');
            }
        }
    }

    protected function do_save() {
        $model = $this->get_model();
        $this->CI->load->model($model);
        $model = $this->CI->{$model};
        if (is_object($model) && method_exists($model, 'save')) {
            $id = $model->save($this->get_values());
            $pk_field = $model->get_primary_field();
            if($this->values[$pk_field]){
                $this->_open_mode = self::EDIT_MODE;
            }else{
                 $this->_open_mode = self::NEW_MODE;
            }
            $this->values[$pk_field] = $id;
            return $id;
        }
        return false;
    }

    /**
     * Traverse a multidimensional $_POST array index until the data is found
     *
     * @access	private
     * @param	array
     * @param	array
     * @param	integer
     * @return	mixed
     */
    private function _reduce_array($array, $keys, $i = 0) {
        if (is_array($array)) {
            if (isset($keys[$i])) {
                if (isset($array[$keys[$i]])) {
                    $array = $this->_reduce_array($array[$keys[$i]], $keys, ($i + 1));
                } else {
                    return NULL;
                }
            } else {
                return $array;
            }
        }

        return $array;
    }

}

?>
