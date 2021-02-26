<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * tuition fee class with property similar to tuition fee details
 * it has been used as record object
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    March 03, 2014
 */
class Studentfee{
    static $total_ammount = 0;
    public function get_ammount(){
        if($this->head_type =='CONDITIONAL'){
            $method = 'get_'.strtolower($this->head_code);
            if(method_exists($this, $method)){
               $ammount = $this->$method();
               $this->total_ammount +=$ammount;
               return $ammount;
            }
        }else{
            return $this->ammount;
        }
    }
    
   protected function get_late_fee(){
       $CI = &get_instance();
       $CI->load->helper('lookup');
       $day = lookup_value('TUITION_FEE','FEE_PAYMENT_BUFFER');
       if($day < $this->day_before){
           $this->additional_ammount += $this->ammount;
           return $this->ammount;
       }
       else 
        return false;
   }
   
   protected function get_vat(){
      $val = ($this->total)*$this->ammount/100;
      $this->additional_ammount += $this->ammount;
      return $val;
   }
   
   public function get_total_ammount(){
       return $this->total;
   }
}

?>