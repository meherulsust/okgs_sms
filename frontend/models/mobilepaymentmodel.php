<?php
/*
 * Created on July 24, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Mobilepaymentmodel extends Frontend_Model
 {
 	function __construct()
 	{
 		parent::__construct(); 		
 	}	 	
	
	function check_valid_regino($student_number)
 	{ 
 		$this->db->select('id');		
 	 	$this->db->from('student');
		$this->db->where('student_number',$student_number);
 	 	return $this->db->count_all_results(); 		
 	}	
 	
	function check_valid_shortname($student_number,$shortname)
 	{ 
 		$this->db->select('st.id');		
 	 	$this->db->from('student st');
		$this->db->join('personal_details std','std.student_id=st.id','left');
		$this->db->where('st.student_number',$student_number);		
		$where = "(std.first_name LIKE '%$shortname%' OR last_name LIKE '%$shortname%')";
		$this->db->where($where);
		return $this->db->count_all_results(); 		
 	}
	
	
	function check_due_payment($student_number,$month,$year)
 	{ 
 		$this->db->select('tfp.id');		
 	 	$this->db->from('student_tuition_fee_payment tfp');
		$this->db->join('student st','st.id=tfp.student_id','left');
		$this->db->where('st.student_number',$student_number);
		$this->db->where('tfp.month',$month);
		$this->db->where('tfp.pay_status','UNPAID');
		$where = "(tfp.year='$year' OR tfp.payment_generate_type>0)";
		$this->db->where($where);	
		return $this->db->count_all_results(); 		
 	}
	
	function get_due_payment($student_number,$month,$year)
 	{ 
 		$this->db->select('tfp.id,tfp.ammount,tfp.start_date,tfp.student_id');		
 	 	$this->db->from('student_tuition_fee_payment tfp');
		$this->db->join('student st','st.id=tfp.student_id','left');
		$this->db->where('st.student_number',$student_number);	
		$this->db->where('tfp.month',$month);
		$this->db->where('tfp.pay_status','UNPAID');
		$where = "(tfp.year='$year' OR tfp.payment_generate_type=1)";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
 	}
	
	
	function insert_temp_payment($data)
	{
		$this->db->insert('student_tuition_fee_payment_temp',$data);
 		return $this->db->insert_id();
	}
	
 	
	function check_transaction_status($student_number,$transaction_id)
 	{ 
 		$this->db->select('id');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('student_number',$student_number);
		$this->db->where('transaction_id',$transaction_id);
		$this->db->where('payment_status','Paid');
 	 	return $this->db->count_all_results(); 		
 	}
	
	
	function check_transaction_number($student_number,$transaction_id)
 	{ 
 		$this->db->select('id');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('student_number',$student_number);
		$this->db->where('transaction_id',$transaction_id);
 	 	return $this->db->count_all_results(); 		
 	}
	
		
	function get_payment_info($student_number)
	{
		$this->db->select('*');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('student_number',$student_number);
		$this->db->where('payment_status','Unpaid');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row_array();
	}	
	
	function get_paid_payment_info($student_number)
	{
		$this->db->select('*');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('student_number',$student_number);
		$this->db->where('payment_status','Paid');
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row_array();
	}
	
	
	function update_temp_payment($id,$data)
	{
		return $this->db->update('student_tuition_fee_payment_temp',$data,array('id'=>$id));
	}
	
	function update_payment($id,$data)
	{
		return $this->db->update('student_tuition_fee_payment',$data,array('id'=>$id));
	}
	
	function insert_payment_transaction($data)
	{
		$this->db->insert('sms_student_payment_transection',$data);
 		return $this->db->insert_id();
	}
	
 	function update_payment_transaction($student_tuition_fee_payment_id,$data)
	{
		return $this->db->update('sms_student_payment_transection',$data,array('student_tuition_fee_payment_id'=>$student_tuition_fee_payment_id));
	}
	
	
	function check_transaction_cancel_status($student_number,$transaction_id)
 	{ 
 		$this->db->select('id');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('student_number',$student_number);
		$this->db->where('transaction_id',$transaction_id);
		$this->db->where('payment_status','Canceled');
 	 	return $this->db->count_all_results(); 		
 	}
	
	
	
 }
 
?>