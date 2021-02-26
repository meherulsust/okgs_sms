<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    January 19, 2013
 */
require_once(dirname(__FILE__) . '/MT_Baseform.php');
class MT_Filter extends MT_BaseForm{
    private $_field_mapper = array();
    public function __construct() {
        $this->CI = &get_instance();
        parent::__construct($this->get_values());
        $this->init();
    }
    
    public function render(){
        $content = '';
        $format = str_replace('{FORM_NAME}', $this->name, $this->name_format);
        $num = 1; 
        foreach ($this->fields as $name => &$field) {
            if($num % 2 == 1)
                $content .= '<tr>';
            $this->naming_format($format, $name);
            $attributes = $this->field_attributes();
            $field = $field + $attributes;
            $type = $field['type'];
            if ($this->CI->input->is_post_request() && $this->CI->input->post($field['name']))
                $value = set_value($field['name'], $this->CI->input->post($field['name']));
            elseif (isset($this->default_values[$name]))
                $value = set_value($field['name'], $this->default_values[$name]);
            else
                $value = set_value($field['name']);
            
            if ('hidden' != $type) {
                $content .= '<th class="lbl"><label for="' . $field['id'] . '">' . ucwords($this->labels[$name]) . "</label></th><td class='cln'>:</td><td>";
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
                case 'select' :
                    $options = $field['options'];
                    unset($field['options'], $field['type']);
                    $select_attr = $field;
                    unset($select_attr['name']);
                    $content .= form_dropdown($field['name'], $options, $value, false, $select_attr);
                    break;
                case 'hidden' :
                    $this->hidden_str .= "<input type='hidden' name='" . $field['name'] . "' value='$value' id='" . $field['name'] . "' />";
                    continue 2;
                    break;
            }
            if ($text_after) {
                $content .= $text_after;
            }
            if($num % 2 == 0){
              $content .= '</td></tr>';
            }else{
               $content .= '</td>';
            }
            $num++;
        }
        if($num %2 == 0)
              $content .= '<td colspan="3"></td></tr>';
        if (!empty($this->button_str)) {
            $content .= '<tr><td colspan="2">&nbsp;</td><td class="btn-container" colspan="4">';
            $content .= $this->button_str;
            $content .='</td></tr>';
        }
        return $content;
       
    }
    public function execute(){
        if ($this->CI->input->is_post_request()) {
            if(isset($_POST['reset'])){
                $this->reset();
            }else{
                $this->process_filter();
                $this->remember();
            }
        } 
    }
    
    protected function process_filter(){
            foreach ($this->fields as $name => $field) {
               $field_name = $this->prepare_field_name($name);
               $this->values[$name] = $this->CI->input->post($field_name);
            } 
    }
    
    public function build_condition($model) {
        foreach ($this->values as $fld => $val) {
            $column = isset($this->_field_mapper[$fld]) ? $this->_field_mapper[$fld]:$fld;
            if ($val){
                switch($this->fields[$fld]['type']){
                    case 'select':
                         $model->db->where($column, $val);
                        break;
                    default:
                        $model->db->like($column,$val,false);
                }
                
            }
                
        }
    }
    
    public function get_values(){
        if($this->values){
            $data = $this->values;
        }else{
            $data = $this->CI->session->userdata($this->get_name());
            $this->values = $data;
        }
        // generate result with default filter values
        if(empty($this->values)){
             $data = $this->default_values;
             $this->values = $data;
             $this->remember();
        }
        return is_array($data) ? $data : array();
    }
    public function remember(){
        $filter_name = $this->get_name();
        $this->CI->session->set_userdata(array($filter_name=>$this->values));
       
    }
    public function reset(){
        $filter_name = $this->get_name();
        $this->CI->session->set_userdata(array($filter_name=>array()));
        return $this;
    }
    public function is_new() {
        return true;
    }
    public function map_to_column(){
         $num_arg = func_num_args();
        if ($num_arg == 0) {
            show_error("Field name is missing in 'map_to_column function.'");
        }
        $args = func_get_args();
        if ($num_arg == 1) {
            $field = $this->current_field;
            $tbl_column = $args[0];
        } else {
            $field = $args[0];
            $tbl_column = $args[1];
        }
        if (empty($field)) {
            show_error("No field name is assigned for mapping column");
        }
        return $this->add_column_mapping($field, $tbl_column);
    }
    
    public function add_column_mapping($field,$column){
        $this->_field_mapper[$field] = $column;
    }
        

}
?>
