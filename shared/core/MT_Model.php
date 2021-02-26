<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MT_Model extends CI_Model {

    protected $default_values = array();

    public function __construct() {
        parent::__construct();
        $this->init();
    }

    protected function init() {
        
    }

    public function get_table_name() {
        show_error('Model: Please define get_table_name function in your model class.');
    }

    /*
     * return first row first column 
     * value of a query result.
     */

    public function get_one() {
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return array_pop($row);
        }
        else
            return false;
    }

    public function get_assoc($field_name = 'id') {
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result_array();
            foreach ($rs as $row) {
                $data[$row[$field_name]] = $row;
            }
        }
        return $data;
    }

    public function get_list() {
        $data = array();
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result_array();
            foreach ($rs as $row) {
                $data[$row['id']] = $row['title'];
            }
        }
        return $data;
    }

    public function cur_date() {
        return date('Y-m-d');
    }

    public function now() {
        return date('Y-m-d H:i:s');
    }

    public function append_audit_trail(array $data, $type = 'create') {
        switch ($type) {
            case 'create':
                $audit['created_at'] = $this->now();
                $audit['created_by'] = $this->session->userdata('user_id');
                break;
            case 'update':
                $audit['updated_at'] = $this->now();
                $audit['updated_by'] = $this->session->userdata('user_id');
                break;
            default :
                $audit['created_at'] = $this->now();
                $audit['created_by'] = $this->session->userdata('user_id');
                $audit['updated_at'] = $this->now();
                $audit['updated_by'] = $this->session->userdata('user_id');
        }

        return array_merge($data, $audit);
    }

    /**
     * Insert 
     * 
     * @param Array $data
     * @return model object.
     */
    public function insert(array $data) {
        $data = $this->do_clean($this->append_audit_trail($data,'create'));
        $this->db->insert($this->get_table_name(), $data);
        return $this->db->insert_id();
    }

    /**
     * update table data.
     * 
     * @param Array $data
     * @return Boolean 
     */
    public function update(array $data) {
        $pk = $this->get_primary_field();
        $data = $this->do_clean($data);
        if (array_key_exists($pk, $data) && !empty($data[$pk])) {
            $this->db->where($pk, $data[$pk]);
            $this->db->update($this->get_table_name(), $data);
            return $data[$pk];
        }else{
         show_error('Model:'.$pk.' is not found in field list of  model class.');   
         return false;
        }
    }

    /**
     * insert or update table data.
     * 
     * @param Array $data
     * @return Integer 
     */
    public function save(array $data) {
        $pk = $this->get_primary_field();
        $id = $data[$pk];
        if ($id) {
            $id = $this->update($data);
        } else {
            $id = $this->insert($data);
        }
        return $id;
    }

    public function find($id) {
        $pk = $this->get_primary_field();
        $query = $this->db->get_where($this->get_table_name(), array($pk => $id));
        $result = false;
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }
        return $result;
    }

    public function find_by($field_name, $value) {
        $result = array();
        $query = $this->db->get_where($this->get_table_name(), array($field_name => $value));
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function find_one_by_pk($field_name, $pk_value) {
        $pk = $this->get_primary_field();
        $this->db->select($field_name)->where($pk, $pk_value)->from($this->get_table_name());
        return $this->get_one();
    }

    public function set_default($field, $value = '') {
        if (is_array($field)) {
            $this->default_values = array_merge($this->default_values, $field);
        } else {
            $this->default_values[$field] = $value;
        }
        return $this;
    }
    
    public function find_one_by($field,$where){
        $query = $this->db->select($field)->from($this->get_table_name())->where($where)->get();
        if($query->num_rows()>0){
            $row = $query->row_array();
            return $row[$field];
        }
        return false;
    }

    /*
     * return primary field name of the model.
     */

    public function get_primary_field() {
        return 'id';
    }

    public function do_clean($data) {
        $columns = $this->get_columns();
        $clean_data = array();
        foreach ($columns as $col) {
            if (isset($data[$col])) {
                $clean_data[$col] = $data[$col];
            }
        }
        return $clean_data;
    }

    public function delete($id) {
        if ($id) {
            $this->db->where($this->get_primary_field(), $id);
            $this->db->delete($this->get_table_name());
            return true;
        }
    }

    public function delete_where($where) {
        $this->db->delete($this->get_table_name(), $where);
        return true;
    }
    public function delete_where_in(array $values,$field=''){
        if($values){
            $field =  empty($field) ? $this->get_primary_field() : $field ;
            $this->db->where_in($field,$values);
            $this->db->delete($this->get_table_name());
            return true;
        }
        return false;
    }

    /**
     * creat one dimentional array selecting
     * one field from database;
     * field is table field name
     * where is the condition used to select data.
     * 
     * @param String $field
     * @param Mixed $where (Optional)
     * @return One dimentional array
     */
    public function get_field($field, $where = false) {
        $sql = $this->db->select($field);
        $cond = array();
        if ($where) {
            if (!is_array($where)) {
                $cond[$this->get_primary_field()] = $where;
                $where = $cond;
            }
            $sql->where($where);
        }
        $query = $sql->get($this->get_table_name());
        if($query->num_rows() > 0)
            return array_map('current', $query->result_array());
        else
            return array();
    }
    
     public function get_field_where_in($field, $key, array $values) {
        $sql = $this->db->select($field);
        $sql->where_in($key,$values);
        $query = $sql->get($this->get_table_name());
        if($query->num_rows() > 0)
            return array_map('current', $query->result_array());
        else
            return array();
    }


    public function get_where($where, $limit = false, $offset = false) {
        $query = $this->db->get_where($this->get_table_name(), $where, $limit, $offset);
        return $query->result_array();
    }

    /*
     * work as abstract method. Must me implement in model class.
     * It returns an array of all  fields of a table.
     */

    public function get_columns() {
        show_error('Model: Please define get_columns function in your model class.');
    }

    public function insert_batch(array $data) {
        $this->db->insert_batch($this->get_table_name(), $data);
    }
    public function update_batch(array $data) {
        $this->db->update_batch($this->get_table_name(),$data,$this->get_primary_field());
    }
    public function delete_batch(array $keys) {
        $this->db->where_in($this->get_primary_field(),$keys);
        $this->db->delete($this->get_table_name());
    }
    
    

    public function count($where = array()) {
        $this->db->from($this->get_table_name());
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }

    public function update_status($stat, $id) {
        $pk = $this->get_primary_field();
        $this->db->set('status', strtoupper($stat));
        $this->db->where($pk, $id);
        $this->db->update($this->get_table_name());
        return $id;
    }

    public function find_row($where) {
        $this->db->from($this->get_table_name());
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get()->row_array();
    }
    public function update_fields($data,$id){
       $this->db->where($this->get_primary_field(),$id);
       return $this->db->update($this->get_table_name(),$data);
    }
    /**
     * 
     * @param String $fields
     * @param Mixed $where
     */
    public function select_where($fields,$where){
       $query = $this->db->select($fields)
                ->from($this->get_table_name())
                ->where($where)
                ->get();
       if($query->num_rows()>0){
           return $query->result_array();
       }
       return false;
        
    }
    
    public function assoc_where($fields,$where){
        if(is_array($fields)){
            list($key,$val) = each($fields);
        }else{
            $key = $this->get_primary_field();
        }
        $query = $this->db->select($fields)
                ->from($this->get_table_name())
                ->where($where)
                ->get();
        $data = array();
        if($query->num_rows()){
            $rs = $query->row_array();
            foreach($rs as $row){
                unset($row[$key]);
                $data[$row[$key]] = $row;
            }
        }
        return $data;
      
        
    }
    
    public function list_where($where,$field='title'){
        return $this->assoc_where($field, $where);
    }
}

?>
