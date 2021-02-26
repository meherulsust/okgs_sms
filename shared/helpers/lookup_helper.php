<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     February 23, 2013
 */
/**
 * get lookup item/s by category code and lookup code
 */
if (!function_exists('lookup_item')) {
 
    function lookup_item($cat_code, $lookup_code = null) {
        $query = lookup_query($cat_code,$lookup_code);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }
    
    if (!function_exists('lookup_value')) {
          function lookup_value($cat_code, $lookup_code) {
              $query = lookup_query($cat_code,$lookup_code);
              if($query->num_rows()>0){
                  $row = $query->row_array();
                  return $row['value'];
              }
              return false;
          }
    }
    if (!function_exists('lookup_query')) {
          function lookup_query($cat_code, $lookup_code = null, $order_by='title asc',$where = null) {
           $CI = &get_instance();
        $query = $CI->db->select('l.id lookup_id,l.title,l.unique_code lookup_code,value')
                ->from('lookup_v l')
                ->join('lookup_type t', 'l.lookup_type_id = t.id', 'left')
                ->where('t.unique_code', $cat_code)
                ->order_by('l.'.trim($order_by));
        if ($lookup_code) {
            $query->where('l.unique_code', $lookup_code);
        }
         if ($where) {
            $query->where($where);
        }
        return $query->get();
              
          }
    }
    
    if (!function_exists('lookup_assoc')) {
        
        function lookup_assoc($cat_code,$order_by='title asc'){
               $query = lookup_query($cat_code,null,$order_by);
               if($query->num_rows()>0){
                 $data = array();  
                 foreach($query->result_array() as $row){
                     $data[$row['lookup_id']] = $row['title'];
                 }
                 return $data;
               }
               return array();
        }
        
    }
    if (!function_exists('lookup_id')) {
          function lookup_id($cat_code, $lookup_code) {
              $query = lookup_query($cat_code,$lookup_code);
              if($query->num_rows()>0){
                  $row = $query->row_array();
                  return $row['lookup_id'];
              }
              return false;
          }
    }
    
     if (!function_exists('lookup_assoc_by_value')) {
          function lookup_assoc_by_value($cat_code, $value,$order_by='title asc') {
              $query = lookup_query($cat_code,null,$order_by,array('value'=>$value));
              if($query->num_rows()>0){
                 $data = array();  
                 foreach($query->result_array() as $row){
                     $data[$row['lookup_id']] = $row['title'];
                 }
                 return $data;
              }
              return array();
          }
    }
    

}
?>