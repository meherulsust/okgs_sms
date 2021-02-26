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

 function teacher_image($user_id=null){
     $CI = &get_instance();
     $CI->load->model('teachermodel');
     $user_id = empty($std_id) ? $CI->auth->get_user()->id: $user_id;
	 $image  = $CI->teachermodel->get_photo($user_id);

	 if($image){
         
         return '<img src ="'.$admin_url.'uploads/teacher_photo/'.$image.'" title="Teacher Photo" />';
     }else{
          return '<img src ="'.base_url().'images/nophoto.jpg" title="Teacher Photo" />';
     }
 }
 
 function html_options($opts,$selected)
 {
 	$html="";
 	if(is_array($opts))
 	{
 	 $selected = is_array($selected)? $selected: array($selected); 	 
 	 foreach($opts as $key=>$val){
      if( in_array($key,$selected))
      $html .= "<option  selected value='$key'>$val</option>";
      else
      $html .= "<option  value='$key'>$val</option>";   
    }
 		return $html;
 	}
 	
 }
 
?>
