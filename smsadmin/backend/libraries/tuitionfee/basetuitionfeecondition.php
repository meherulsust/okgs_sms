<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    February 10, 2014
 * base class for tuition fee condition
 * define common tuition fee condition for 
 * generating tuition fee condition type head for each student. 
 */
class Basetuitionfeecondition{
    protected $head_info = array();
    protected $student = array();
    protected $CI;
    function __construct() {
          $this->CI = &get_instance();
    }
    public function getFee($head_code,$std_id=''){
        if($std_id){
            $this->CI->load->model('studentacademicvmodel','scvmodel');
            $student = $this->CI->scvmodel->find($std_id);
            if($student){
                $this->student = $student;
            }
            $this->_validate_code($head_code);
        }
        $this->CI->load->model('tuitionfeeheadmodel','tfhmodel');
        $head_info =  $this->CI->tfhmodel->find_by_code($head_code);
        if($head_info){
            $this->head_info = $head_info;
        }
        $func_name = strtolower($this->head_info['head_code']);
        $ret = $this->$func_name();
        if($ret)
            return $this->head_info['ammount'];
        else 
           return false; 
        
    }
    protected function late_fee_condition(){
        $d = date('d');
        return 7 >= $d;        
    }
    
   
}
?>