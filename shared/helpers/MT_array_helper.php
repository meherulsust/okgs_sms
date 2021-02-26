<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 3, 2012
*/
// make a cycle within  input array
function cycle($ary=array())
{
  static $pointer=0;
  if($pointer==count($ary))
  $pointer=0;
  return $ary[$pointer++]; 
  
}
function make_option($array)
 {
 	$data=array();
 	foreach( $array as $key=>$val)
 	{
 		$data[$val]=$val;
 	}
 	return $data;
 }
 function assoc($rows=array())
 {
 	foreach($rows as $row)
 	{
		$temp=each($row);
		$num=count($row);
		if($num==1)
		{
			$data[$temp['value']]=$temp['value'];
		}
		elseif($num==2)
			$data[$temp['value']]=array_pop($row);
		else
		$data[$temp['value']]=$row;
 	}
 	return $data; 	
 }
 
 function array_assoc_by_key(array $data,$key)
 {
 	$result = array();
 	foreach($data as $i=>$row)
 	{
 		$result[$row[$key]] = $row;
 	}
 	return $result;
 }
 
 /**
  * Create group base on provided key of 2d array
  * value of inner_key will be the index of respective row.   
  *  
  * @param array $data
  * @param String $key
  * @param String $inner_key
  * @return array
  */
 function array_group_by_key(array $data,$key,$inner_key=false)
 {
 	$result = array();
 	foreach($data as $i=>$row)
 	{
                if($inner_key && $row[$inner_key])
                    $result[$row[$key]][$row[$inner_key]] = $row;
                else
                    $result[$row[$key]][] = $row; 
 	}
 	return $result;
 }
 

?>