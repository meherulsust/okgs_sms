<?php
/*
 * Created on July 24, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Paymentmodel extends Frontend_Model
 {
 	function __construct()
 	{
 		parent::__construct(); 		
 	}	 	
	
	function insert_temp_payment($data)
	{
		$this->db->insert('student_tuition_fee_payment_temp',$data);
 		return $this->db->insert_id();
	}
	
 	
	function get_temp_payment_info($payment_id)
	{
		$this->db->select('*');		
 	 	$this->db->from('student_tuition_fee_payment_temp');
		$this->db->where('payment_id',$payment_id);
		$this->db->where('payment_status','Paid');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		return $query->row_array();
	}	
		
	function update_temp_payment($id,$data)
	{
		$this->db->update('student_tuition_fee_payment_temp',$data,array('id'=>$id));
		return $this->db->affected_rows();
	}
	
 }
 
?>