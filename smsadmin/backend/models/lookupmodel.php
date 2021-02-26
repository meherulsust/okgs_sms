<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     September 01, 2012
 */
class Lookupmodel extends BACKEND_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_columns() {
        return array('id', 'lookup_type_id', 'value_type', 'unique_code', 'title', 'created_at', 'created_by');
    }

    public function get_table_name() {
        return 'lookup';
    }

    public function save($data) {
        $tables = array('BOOL' => 'lookup_bool_value', 'TEXT' => 'lookup_text_value', 'NUMBER' => 'lookup_num_value', 'STRING' => 'lookup_str_value');
        $this->db->trans_start();
        $values['value'] = $data['value'];
        $values['updated_at'] = $this->now();
        $values['updated_by'] = $this->get_created_by();
        //in case of update
        if ($data['id']) {
            $prev_rec = $this->find($data['id']);
            $id = parent::save($data);
            //value type did not change. upadate previous value.
            if ($prev_rec['value_type'] == $data['value_type']) {
                $this->db->where('lookup_id', $data['id']);
                $this->db->update($tables[$data['value_type']], $values);
            } else {
                //remove previous value
                $this->db->delete($tables[$prev_rec['value_type']], array('lookup_id' => $data['id']));
               //insert new value
                $values['lookup_id'] = $id;
                $this->db->insert($tables[$data['value_type']], $values);
            }
        } else {
            $id = parent::save($data);
            $values['lookup_id'] = $id;
            $this->db->insert($tables[$data['value_type']], $values);
        }

        $this->db->trans_complete();
        return $id;
    }

    public function any_other_exists($id, $type_id, $code) {
        $rs = $this->get_where(array('lookup_type_id' => $type_id, 'unique_code' => $code));
        if ($rs) {
            //check for edit
            if ($id && $rs['0']['id'] == $id) {
                return false;
            }else
                return true;
        }else {
            return false;
        }
    }
    
    public function delete($data){
        $tables = array('BOOL' => 'lookup_bool_value', 'TEXT' => 'lookup_text_value', 'NUMBER' => 'lookup_num_value', 'STRING' => 'lookup_str_value');
        $this->db->delete($tables[$data['value_type']], array('lookup_id' => $data['id'])); 
        parent::delete($data['id']);
        return $data['id'];
    }

}

?>