<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 3, 2012
*/
 function rand_str($len=8)
 {
 	  $salt='';
  	  $letters='';
  	  foreach(range('a','z') as $c)
  	  {
  	  	$letters .=$c.strtoupper($c);
  	  }
  	  for($i=0;$i<$len;$i++)
  	  {
  	  	list($usec, $sec) = explode(' ', microtime());
  		srand((float) $sec + ((float) $usec * 100000));
  	     $p=rand(0,51);
  	     $salt .= $letters[$p];	
  	  }
  	  return $salt;
 }
 
 function rand_email($len=4,$domain='gmail.com')
 {
 	return rand_str($len).'@'.$domain;
 }
 
 function rand_number($len=10)
 {
 	   $salt='';
  	  $digits='';
  	  for($i=0;$i<$len;$i++)
  	  {
  	  	list($usec, $sec) = explode(' ', microtime());
  		srand((float) $sec + ((float) $usec * 100000));
  	    $salt .=rand(0,9);
  	  }
  	  return $salt;
 	
 }
 function array_random_assoc($arr, $num = 1)
 {
    $keys = array_keys($arr);
    shuffle($keys);
   
    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[$keys[$i]] = $arr[$keys[$i]];
    }
    return $r;
 }

 
?>
