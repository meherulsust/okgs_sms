<?php
/*
 * Created on December 07, 2014
 *
 * Created by Arena Development Team(@ Imrul Hasan)
 */
 
 class Apimodel extends Frontend_Model
 {
 	
	/*--------------- start login ------------------*/	
 	function check_user($data)
	{
 		$this->db->select('id,student_number');
		$this->db->from('student');
 		$this->db->where('student_number',$data['student_number']);
 		$this->db->where('passwd',$data['passwd']);
 		$this->db->where('status_id',1);
 		$query = $this->db->get();
		return $query->row_array();
	}	
	/*--------------- end login ------------------*/
	
	
	/*--------------- get user info ------------------*/
	function get_user_info($data)
 	{
		$this->db->select('*');
		$this->db->from('topup_general_user');
		$this->db->where('id',$data['user_id']);
		$this->db->where('topup_admin_user_id',$data['topup_admin_user_id']);
		$row=$this->get_row();
 		return $row;
 	}
	/*--------------- end user info ------------------*/
	
	
	
	/*--------------- add user ------------------*/
	function add_user($data)
	{
		$this->db->insert('topup_general_user',$data);
		return $this->db->insert_id();
	}
	
	function duplicate_user_check($data)
	{
		$this->db->select('id,email');
		$this->db->from('topup_general_user');
 		$this->db->where('topup_admin_user_id',$data['topup_admin_user_id']);
		$this->db->where('email',$data['email']);
 		$rs=$this->db->get(); 		    
		return $rs->num_rows();	
	}
	
	/*--------------- end add user ------------------*/
	
	
	/*----------------- get package list ---------------------*/
	function get_package_list($data)
	{
		$this->db->select('topup_package.id,CONCAT(topup_package.title," ( ",topup_package.price,"  ",topup_currency.currency_code," )") as package_title',False);
		$this->db->from('topup_package');
		$this->db->join('topup_currency','topup_currency.id=topup_package.price_currency_id');
		$this->db->join('topup_total_balance','topup_total_balance.currency_id=topup_package.currency_id');
		$this->db->where('topup_total_balance.balance > topup_package.amount');
		$this->db->where('topup_package.topup_admin_user_id',$data['topup_admin_user_id']);
		$this->db->where('topup_package.currency_id',$data['currency_id']);
		$this->db->where('topup_package.status','Publish');
		return $this->get_assoc();
	}
	/*----------------- end package list ---------------------*/
	
	
	
	/*----------------- get payment type ---------------------*/
	function get_payment_type($data)
	{
		$this->db->select('topup_payment_type.payment_type_id,topup_payment_type_list.title');
		$this->db->from('topup_payment_type');
		$this->db->join('topup_payment_type_list','topup_payment_type_list.id=topup_payment_type.payment_type_id','left');
		$this->db->where('topup_payment_type.status','Publish');
		$this->db->where('topup_payment_type.topup_admin_user_id',$data['topup_admin_user_id']);
		return $this->get_assoc();	
	}
	/*----------------- end payment type ---------------------*/
	
	
	
	/*----------------- get topup list ---------------------*/
	function get_topup_list($data)
 	{ 		
		$this->db->select('topup_flexi_request.id,transaction_id,receiver,CONCAT(topup_flexi_request.amount," ",topup_currency.currency_code)as amount,CONCAT(topup_flexi_request.price," ",price_currency.currency_code) as total_price,type,request_time,topup_flexi_request.status,payment_status,topup_currency.title currency,topup_package.title package_name,topup_payment_type_list.title payment_type',False);		
 	 	$this->db->from('topup_flexi_request');
 	 	$this->db->join('topup_currency','topup_currency.id = topup_flexi_request.currency_id','left');	
		$this->db->join('topup_package','topup_package.id = topup_flexi_request.package_id','left');
		$this->db->join('topup_currency price_currency','price_currency.id = topup_package.price_currency_id','left');
		$this->db->join('topup_payment_type_list','topup_payment_type_list.id = topup_flexi_request.payment_type','left');	
		$this->db->where('topup_flexi_request.sender_id',$data['topup_admin_user_id']);
		$this->db->where('topup_flexi_request.general_sender_id',$data['user_id']);
		$rs=$this->db->get(); 	    
		$list=$rs->result_array(); 	    
		return $list;
 	}
	/*----------------- end topup list ---------------------*/
	
	
	/*--------------- start reseller info --------------*/
	
	function get_reseller($id)
	{
		$this->db->select('id,email,paypal_account,from_email');
		$this->db->from('topup_admin_user');
		$this->db->where('id',$id);
		$this->db->where('status','Active');
		return $this->get_row();
	}
	
	/*-------------- end reseller info --------------*/
	
	/*-------------- start update password --------------*/
	
	function update_forgot_password($topup_admin_user_id,$email,$password)
	{
		$this->db->set('password',$password);
		$this->db->where('topup_admin_user_id',$topup_admin_user_id);
		$this->db->where('email',$email);
		$this->db->update('topup_general_user');	
	}
	
	/*-------------- end update password --------------*/
	
 }
?>
