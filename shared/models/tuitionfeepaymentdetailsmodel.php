<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * student payment list details 
 * @ Author      Reza Ahmed <coder.reza@gamail.com>
 * @ Created     February 16, 2012
 */
 class Tuitionfeepaymentdetailsmodel extends MT_Model
 {
    public function __construct()
    {
      	parent::__construct();
    }
   
    public function get_table_name()
    {
   	   return 'student_tuition_fee_payment_details';
    }
   public function get_columns()
   {
   	  return array('id','student_tuition_fee_payment_id','tuition_fee_head_id','ammount','created_at','created_by','updated_at','updated_by');
   }
   
   public function get_fees($pid){
       $query = $this->db->select('head_type,head_code,datediff(curdate(),f.created_at) day_before,date_format(f.created_at,"%Y-%m-%d") fee_generation_date,f.expire_date,f.pay_status,h.title,h.fund_id,fd.tuition_fee_head_id,fd.id,fd.ammount,student_id,f.ammount total', false)
               ->from('student_tuition_fee_payment_details fd')
               ->join('student_tuition_fee_payment f','f.id = fd.student_tuition_fee_payment_id','left')
               ->join('tuition_fee_head h','h.id = fd.tuition_fee_head_id','left')
               ->where('fd.student_tuition_fee_payment_id',$pid)
               ->order_by('h.display_order asc')
               ->get();
      $rs = array();
       if($query->num_rows() > 0){
           $this->load->library('Studentfee');
           $rs = $query->result('Studentfee');
       }
       return $rs;
   }
	
	
	public function get_all_fees(){
       $query = $this->db->select('head_type,head_code,datediff(curdate(),f.created_at) day_before,date_format(f.created_at,"%Y-%m-%d") fee_generation_date,h.title,fd.ammount,student_id,f.ammount total', false)
               ->from('student_tuition_fee_payment_details fd')
               ->join('student_tuition_fee_payment f','f.id = fd.student_tuition_fee_payment_id','left')
               ->join('tuition_fee_head h','h.id = fd.tuition_fee_head_id','left')
               ->order_by('h.display_order asc')
               ->get();
      $rs = array();
       if($query->num_rows() > 0){
           $this->load->library('Studentfee');
           $rs = $query->result('Studentfee');
       }
       return $rs;
   }
	
	
	public function get_fee_details($id)
	{
		$query = $this->db->select('h.title,h.head_type,fd.id,fd.student_tuition_fee_payment_id,fd.ammount,fp.ammount total_amount')
               ->from('student_tuition_fee_payment_details fd')
               ->join('tuition_fee_head h','h.id = fd.tuition_fee_head_id','left')
			   ->join('student_tuition_fee_payment fp','fp.id = fd.student_tuition_fee_payment_id','left')
               ->where('fd.id',$id)
               ->get();
		return $query->row_array();
	}
	
	public function update_total_payment($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('student_tuition_fee_payment',$data);
	}
	
   
 }
?>