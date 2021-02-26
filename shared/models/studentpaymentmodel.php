<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     January 08, 2012
 */
 class Studentpaymentmodel extends MT_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'student_payment_transection';
    }
	public function get_columns()
	{
		return array('id','student_tuition_fee_payment_id','bank_transection_id','created_at','created_by');
	}
   
  
   
 }

?>