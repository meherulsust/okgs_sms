<?php
/*
 * Created on July 24, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 class Smsmodel extends Frontend_Model
 {
 	function __construct()
 	{
 		parent::__construct(); 		
 	}	 	
	
	function get_unpaidinfo()
	{
		$this->db->select('sp.student_id,pd.mobile,first_name');
		$this->db->from('student_tuition_fee_payment sp');
		$this->db->join('personal_details pd','pd.student_id=sp.student_id','left');
		$this->db->join('admission ad','ad.student_id=sp.student_id','left');
		$this->db->where('sp.pay_status','UNPAID');
		$this->db->where('sp.month',date('m'));
		$this->db->where('sp.expire_date < ',date('Y-m-d'));
		$this->db->where('ad.class_id',4);
		//$this->db->group_by('sp.student_id');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 	
	}
	
	/*************************************/
	function get_student_number()
	{
		$this->db->select('sp.student_id,pd.mobile');
		$this->db->from('student_tution_fee_payment_message sp');
		$this->db->join('personal_details pd','pd.student_id=sp.student_id','left');
		$this->db->where('sp.status','1');
		$this->db->group_by('pd.mobile');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 	

	}
	
	
	function get_student_rong_number()
	{
		$this->db->select('*');
		$this->db->from('sms_rong_sms_number sp');
		$rs=$this->db->get(); 	    
		return $rs->result_array(); 	

	}
	
	
	
		function add_paymentdata($data)
	{
		$this->db->insert('payment_table',$data);
		return $this->db->insert_id();
	}

	/**************************************/
	
	function payment_message($data)
	{
		$this->db->insert('student_tution_fee_payment_message',$data);
		return $this->db->insert_id();
	}
 }
 
?>