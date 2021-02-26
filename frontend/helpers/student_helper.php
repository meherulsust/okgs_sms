<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     April 26, 2014
 * 
 * This helper for student information
 *
 */

 function student_image($std_number=null){
     $CI = &get_instance();
     $CI->load->model('studentvmodel');
     $std_number = empty($std_id) ? $CI->auth->get_user()->student_number: $std_number;
     $image  = $CI->studentvmodel->get_photo($std_number);
     if($image){
         
         return '<img src ="'.base_url().'smsadmin/uploads/std_photo/'.$image.'" title="Student Photo" />';
     }else{
          return '<img src ="'.base_url().'images/nophoto.jpg" title="Student Photo" />';
     }
 }
 
?>
