<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 17, 2011
*/

/**
 * generate option tag of 
 * select element based on provided options
 * mapping array to option value and innter text.
 * provide selecte param for selected item.
 * @param array $opts
 * @param mixed $selected
 * @return String
 */
 function html_options(array $opts,$selected)
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
 
 /*
  *  generate option tag of 
  * select element based on provided options param
  * available options:
  *  * model: model/object (required)
  *  * method: model method which will return query object that select
  *           * two columns first column will be key and second column
  *           * will be value.  
  *  * order_by: order by field name
  *              * it must me sql format 
  *              * field asc or field desc
  *  
  *            
  *  * key: field name which will be used as html option tag (id is by default)
  *  * value : field name which will be used as text  between option tag (title is by default).
  *  * add_empty: add option with empty key at the beginning of available option list. 
  *  * selected: mixed type value which will be selected by default.
  *  * where: condition used to select data. must be in sql format.
  *  
  * @ see html_options function.
  * 
  */
 function html_model_options(array $options,  $attributes=array())
 {
 	$CI = &get_instance();
 	if(isset($options['model']))
 	{ 
 		$key = isset($options['key'])? $options['key']: 'id';
 		$value = isset($options['value'])? $options['value']: 'title';
 		$model = $options['model'];
 		if(!is_object($model))
 		{
 			 $CI->load->model($model,'tmp_hmo_model');
 			 $model = $CI->tmp_hmo_model;
 		}
 		if(isset($options['method']))
 		{
 			if(method_exists($model,$options['method']))
 			{
 				$query = $model->$options['method']();
 			}
 		}
 		else
 		{
 			$CI->db->from($model->get_table_name())
 			        ->select($key.','.$value);       
	 		if(isset($options['order_by']))
	 		{ 
	 			$CI->db->order_by($options['order_by']);
	 		} 
	 		if(isset($options['where']))
	 		{ 
	 			$CI->db->where($options['where'],NULL,false);
	 		} 
	 		$query = $CI->db->get();       
 		} 
 		if($query->num_rows() > 0)
 		{
 			$rs = $query->result_array();
 			$selected = $options['selected'];
 			$selected = is_array($selected)? $selected: array($selected); 
 			$html='';	 
 			foreach($rs as $row)
 			{
		      if( in_array($row[$key],$selected))
		     	 $html .= '<option  selected value="'.$row[$key].'">'.$row[$value].'</option>';
		      else
		     	 $html .= '<option  value="'.$row[$key].'">'.$row[$value].'</option>';   
		    }
		    $CI->unload('tmp_hmo_model');
 		    return $html;
 		}
 		 $CI->unload('tmp_hmo_model');
 	}
 	else
 	{
 		show_error('model is a required option  in calling html_model_options function');
 	}
 }
 function printr($var)
 {
 		echo "<pre>";
 		print_r($var);
 		echo "</pre>";
 		
 }
 
?>