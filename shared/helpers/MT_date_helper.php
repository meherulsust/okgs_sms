<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!defined('DATE_FORMAT'))
    define('DATE_FORMAT', 'd/m/Y');
if (!defined('DATE_TIME_FORMAT'))
    define('DATE_TIME_FORMAT', 'd/m/Y h:i A');
/**
 * extends CodeIgniter date helper.
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created     March 3, 2012
 */
/**
 * convert mysql date to application audit trail date
 */
if (!function_exists('mysql_to_audit')) {

    function mysql_to_audit($mysql_date) {
        $date = new DateTime($mysql_date);
        return $date->format(DATE_TIME_FORMAT);
    }

    /**
     * converts mysql date to human readable date
     * 
     * @param String $mysql_date
     * @return String
     */
}
if (!function_exists('mysql_to_date')) {

    function mysql_to_date($mysql_date) {
        $date = new DateTime($mysql_date);
        return $date->format(DATE_FORMAT);
    }

}
if (!function_exists('age')) {

    function age($dob) {
        $date = new DateTime($dob);
        $now = new DateTime();
        $interval = $now->diff($date);
        $year = $interval->y . ' Year ';
        $month = $interval->m . ' Month ';
        $day = $interval->y . ' Days ';
        if ($interval->y > 1) {
            $year = $interval->y . ' Years ';
        } else if ($interval->y == 0) {
            $year = ' ';
        }

        if ($interval->m > 1)
            $month = $interval->m . ' Months ';
        elseif ($interval->m == 0)
            $month = ' ';
        if ($interval->d > 1)
            $day = $interval->d . ' Days ';
        elseif ($interval->d == 0)
            $day = ' ';
        return $year . $month . $day;
    }

}

if (!function_exists('format_date')){
   function format_date($date_str,$format='Y-m-d'){
      $date = new DateTime($date_str);
      return $date->format($format);  
   }
}
?>